<?php

declare(strict_types=1);

namespace App\EventListener;

use App\Entity\User;
use App\Security\PermissionManager;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Mercure\Authorization;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\SerializerInterface;

class AuthenticationSuccessListener
{
    private const SUBSCRIBE_URLS = [
        '{*}/permission_rules/{*}',
        '{*}/permissions/{*}',
    ];
    private const PUBLISH_URLS = [];

    private PermissionManager $permissionManager;
    private SerializerInterface $serializer;
    private Authorization $authorization;
    private RequestStack $requestStack;

    public function __construct(RequestStack $requestStack,
                                Authorization $authorization,
                                PermissionManager $permissionManager,
                                SerializerInterface $serializer
    ) {
        $this->permissionManager = $permissionManager;
        $this->serializer = $serializer;
        $this->authorization = $authorization;
        $this->requestStack = $requestStack;
    }

    public function onAuthenticationSuccessResponse(AuthenticationSuccessEvent $event)
    {
        /** @var User $user */
        $user = $event->getUser();

        try {
            $context = array_merge([
                'groups' => ['login'],
                'enable_max_depth' => true,
            ]);
            $userData = $this->serializer->normalize($user, 'jsonld', $context);
        } catch (ExceptionInterface) {
            $userData = null;
        }

        $data = $event->getData();
        $data['user'] = $userData;
        $data['permissions'] = $this->permissionManager->getAllPermissions();

        // same permissions for everyone for the POC
        // should generate cookie with urls based on user
        $request = $this->requestStack->getCurrentRequest();
        $mercureCookie = $this->authorization->createCookie(
            $request,
            self::SUBSCRIBE_URLS,
            self::PUBLISH_URLS,
        );

        $event->getResponse()->headers->setCookie($mercureCookie);
        $event->setData($data);
    }
}
