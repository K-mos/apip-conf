<?php

declare(strict_types=1);

namespace App\Serializer;

use ApiPlatform\Core\Serializer\SerializerContextBuilderInterface;
use App\Security\PermissionManager;
use Symfony\Component\HttpFoundation\Request;

final class PermissionContextBuilder implements SerializerContextBuilderInterface
{
    private SerializerContextBuilderInterface $decorated;
    private PermissionManager $permissionManager;

    public function __construct(SerializerContextBuilderInterface $decorated, PermissionManager $permissionManager)
    {
        $this->decorated = $decorated;
        $this->permissionManager = $permissionManager;
    }

    public function createFromRequest(Request $request, bool $normalization, ?array $extractedAttributes = null): array
    {
        $context = $this->decorated->createFromRequest($request, $normalization, $extractedAttributes);
        if (!isset($context['groups'])) {
            return $context;
        }

        $route = $request->get('_route');
        if ((null === $rule = $this->permissionManager->getPermissionForRoute($route)) || empty($rule->getGroups())) {
            return $context;
        }
        $context['groups'] = array_merge($context['groups'], $rule->getGroups());

        return $context;
    }
}
