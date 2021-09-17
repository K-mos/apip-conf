<?php

declare(strict_types=1);

namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserDataPersister implements ContextAwareDataPersisterInterface
{
    private EntityManagerInterface $em;
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(
        EntityManagerInterface $em,
        UserPasswordHasherInterface $passwordHasher
    ) {
        $this->em = $em;
        $this->passwordHasher = $passwordHasher;
    }

    public function supports($data, array $context = []): bool
    {
        return $data instanceof User;
    }

    /**
     * @param User $data
     */
    public function persist($data, array $context = []): void
    {
        if ($data->getPlainPassword()) {
            $password = $this->passwordHasher->hashPassword($data, $data->getPlainPassword());
            $data->setPassword($password);
            $data->eraseCredentials();
        }

        $this->em->persist($data);
        $this->em->flush();
    }

    public function remove($data, array $context = []): void
    {
        $this->em->remove($data);
        $this->em->flush();
    }
}
