<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\PermissionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PermissionRepository::class)]
#[ApiResource(
    mercure: true,
    security: 'is_granted("ROLE_ADMIN")'
)]
class Permission
{
    #[ORM\Id, ORM\Column, ORM\GeneratedValue]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $code;

    #[ORM\OneToMany(mappedBy: 'permission', targetEntity: PermissionRule::class, orphanRemoval: true)]
    private Collection $rules;

    public function __construct()
    {
        $this->rules = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): void
    {
        $this->code = $code;
    }

    /**
     * @return Collection|PermissionRule[]
     */
    public function getRules(): Collection
    {
        return $this->rules;
    }

    public function addRule(PermissionRule $rule): self
    {
        if (!$this->rules->contains($rule)) {
            $this->rules[] = $rule;
            $rule->setPermission($this);
        }

        return $this;
    }

    public function removeRule(PermissionRule $rule): self
    {
        // set the owning side to null (unless already changed)
        if ($this->rules->removeElement($rule) && $rule->getPermission() === $this) {
            $rule->setPermission(null);
        }

        return $this;
    }

    public function isPublic(): bool
    {
        return $this->rules->isEmpty();
    }
}
