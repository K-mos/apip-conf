<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\PermissionRuleRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: PermissionRuleRepository::class)]
#[ApiResource(
    mercure: true,
    normalizationContext: ['groups' => ['permission']],
    security: 'is_granted("ROLE_ADMIN")'
)]
class PermissionRule
{
    #[ORM\Id, ORM\Column, ORM\GeneratedValue]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'rules')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups('permission')]
    private Permission $permission;

    #[ORM\ManyToOne]
    #[Groups('permission')]
    private ?Organization $organization = null;

    #[ORM\ManyToOne]
    #[Groups('permission')]
    private ?Service $service = null;

    #[ORM\ManyToOne]
    #[Groups('permission')]
    private ?Position $position = null;

    #[ORM\Column(type: 'boolean', options: ['default' => false])]
    #[Groups('permission')]
    private bool $manager = false;

    #[ORM\Column(type: 'simple_array', nullable: true)]
    #[Groups('permission')]
    private ?array $filters = [];

    #[ORM\Column(type: 'simple_array', nullable: true)]
    #[Groups('permission')]
    private ?array $groups = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPermission(): Permission
    {
        return $this->permission;
    }

    public function setPermission(Permission $permission): void
    {
        $this->permission = $permission;
    }

    public function getOrganization(): ?Organization
    {
        return $this->organization;
    }

    public function setOrganization(?Organization $organization): void
    {
        $this->organization = $organization;
    }

    public function getService(): ?Service
    {
        return $this->service;
    }

    public function setService(?Service $service): void
    {
        $this->service = $service;
    }

    public function getPosition(): ?Position
    {
        return $this->position;
    }

    public function setPosition(?Position $position): void
    {
        $this->position = $position;
    }

    public function getManager(): bool
    {
        return $this->manager;
    }

    public function setManager(bool $manager): void
    {
        $this->manager = $manager;
    }

    public function isGenericRule(): bool
    {
        return !$this->getOrganization() && !$this->getService() && !$this->getPosition() && !$this->getManager();
    }

    public function getPriority(): int
    {
        $priority = 0;

        // unfiltered rules have a higher priority.
        if (empty($this->getFilters())) {
            ++$priority;
        }

        if ($this->isGenericRule()) {
            return $priority;
        }

        if ($this->getOrganization()) {
            ++$priority;
        }

        if ($this->getService()) {
            $priority += 2;
        }

        if ($this->getPosition()) {
            $priority += 3;
        }

        if ($this->getManager()) {
            $priority += 4;
        }

        return $priority;
    }

    public function getFilters(): ?array
    {
        return $this->filters;
    }

    public function setFilters(?array $filters): void
    {
        $this->filters = $filters;
    }

    public function getGroups(): ?array
    {
        return $this->groups;
    }

    public function setGroups(?array $groups): void
    {
        $this->groups = $groups;
    }
}
