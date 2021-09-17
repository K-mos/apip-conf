<?php

namespace App\Doctrine;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryCollectionExtensionInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryItemExtensionInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use App\Annotation\FilterPermission;
use App\Security\PermissionManager;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\HttpFoundation\RequestStack;

final class PermissionExtension implements QueryCollectionExtensionInterface, QueryItemExtensionInterface
{
    private PermissionManager $permissionManager;
    private RequestStack $requestStack;

    public function __construct(PermissionManager $permissionManager, RequestStack $requestStack)
    {
        $this->permissionManager = $permissionManager;
        $this->requestStack = $requestStack;
    }

    public function applyToCollection(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, string $operationName = null): void
    {
        $this->addWhere($queryBuilder, $resourceClass);
    }

    public function applyToItem(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, array $identifiers, string $operationName = null, array $context = []): void
    {
        $this->addWhere($queryBuilder, $resourceClass);
    }

    private function addWhere(QueryBuilder $queryBuilder, string $resourceClass): void
    {
        if (null === $request = $this->requestStack->getCurrentRequest()) {
            return;
        }

        $route = $request->get('_route');
        $rule = $this->permissionManager->getPermissionForRoute($route);
        if (!$rule || empty($rule->getFilters())) {
            return;
        }

        try {
            $reflectionClass = new \ReflectionClass($resourceClass);
            $permissions = $reflectionClass->getAttributes(FilterPermission::class, \ReflectionAttribute::IS_INSTANCEOF);
        } catch (\ReflectionException) {
            return;
        }

        if (empty($permissions)) {
            return;
        }

        $rootAlias = $queryBuilder->getRootAliases()[0];
        foreach ($rule->getFilters() as $filter) {
            if (
                (null === $permission = $this->getPermission($filter, $permissions)) ||
                (null === $value = $this->permissionManager->getCurrentValue($permission->value))
            ) {
                continue;
            }

            $queryBuilder
                ->andWhere(sprintf('%s.%s = :filter_%s', $rootAlias, $permission->field, $filter))
                ->setParameter(sprintf('filter_%s', $filter), $value);
        }
    }

    /**
     * @param \ReflectionAttribute[] $attributes
     */
    private function getPermission(string $filter, array $attributes): ?FilterPermission
    {
        foreach ($attributes as $attribute) {
            if (FilterPermission::class !== $attribute->getName()) {
                continue;
            }

            /** @var FilterPermission $permission */
            $permission = $attribute->newInstance();
            if ($filter === $permission->name) {
                return $permission;
            }
        }

        return null;
    }
}
