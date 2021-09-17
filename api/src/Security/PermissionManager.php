<?php

declare(strict_types=1);

namespace App\Security;

use ApiPlatform\Core\Security\ExpressionLanguage;
use App\Entity\Permission;
use App\Entity\PermissionRule;
use App\Entity\User;
use App\Repository\PermissionRepository;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Security;

final class PermissionManager
{
    private PermissionRepository $permissionRepository;
    private Security $security;

    public function __construct(Security $security, PermissionRepository $permissionRepository)
    {
        $this->permissionRepository = $permissionRepository;
        $this->security = $security;
    }

    public function getAllPermissions(): array
    {
        $userPermissions = [];
        $permissions = $this->permissionRepository->findAll();

        foreach ($permissions as $permission) {
            if (!$this->hasAccess($permission)) {
                continue;
            }
            $userPermissions[] = $permission->getCode();
        }

        return $userPermissions;
    }

    public function hasAccess(Permission $permission): bool
    {
        if ($permission->isPublic()) {
            return true;
        }

        try {
            $this->findRule($permission);
        } catch (AccessDeniedException) {
            return false;
        }

        return true;
    }

    public function getPermissionForRoute(string $route): ?PermissionRule
    {
        $permission = $this->permissionRepository->findOneBy(['code' => $route]);
        if (null === $permission) {
            return null;
        }

        return $this->findRule($permission);
    }

    /**
     * Returns the rule with the higher priority.
     */
    private function findRule(Permission $permission): PermissionRule
    {
        $priority = -1;
        $matchedRule = null;
        foreach ($permission->getRules() as $rule) {
            if (!$this->isEligible($rule) || $rule->getPriority() <= $priority) {
                continue;
            }

            $matchedRule = $rule;
            $priority = $rule->getPriority();
        }

        if (!$matchedRule) {
            throw new AccessDeniedException();
        }

        return $matchedRule;
    }

    private function isEligible(PermissionRule $rule): bool
    {
        if ($rule->isGenericRule()) {
            return true;
        }
        $user = $this->getCurrentUser();

        return
            (!$rule->getOrganization() || $rule->getOrganization() === $user->getOrganization()) &&
            (!$rule->getService() || $rule->getService() === $user->getService()) &&
            (!$rule->getPosition() || $rule->getPosition() === $user->getPosition()) &&
            (!$rule->getManager() || !$user->getManaged()->isEmpty());
    }

    public function getCurrentUser(): User
    {
        $currentUser = $this->security->getUser();
        if (!$currentUser instanceof User) {
            throw new AccessDeniedException();
        }

        return $currentUser;
    }

    public function getCurrentValue(string $value)
    {
        $expression = new ExpressionLanguage();

        return $expression->evaluate($value, ['user' => $this->getCurrentUser()]);
    }
}
