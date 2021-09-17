<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Annotation\FilterPermission;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[ApiResource(
    normalizationContext: ['groups' => ['user']],
)]
#[FilterPermission(name: 'organization')]
#[FilterPermission(name: 'service')]
#[FilterPermission(name: 'position')]
#[FilterPermission(name: 'manager')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Groups('user')]
    private ?string $email;

    #[ORM\Column(type: 'json')]
    private array $roles = [];

    #[ORM\Column]
    private string $password;

    #[SerializedName('password')]
    private ?string $plainPassword = null;

    #[ORM\Column(length: 255)]
    #[Groups(['user', 'login'])]
    private ?string $firstname;

    #[ORM\Column(length: 255)]
    #[Groups(['user', 'login'])]
    private ?string $lastname;

    #[ORM\OneToOne(inversedBy: 'user')]
    #[ORM\JoinColumn(onDelete: 'CASCADE')]
    private ?Address $address = null;

    #[ORM\ManyToOne(inversedBy: 'users')]
    #[Groups(['user', 'login'])]
    private ?Organization $organization;

    #[ORM\ManyToOne(inversedBy: 'users')]
    #[Groups('user')]
    private ?Service $service;

    #[ORM\ManyToOne(inversedBy: 'users')]
    #[Groups('user')]
    private ?Position $position;

    #[ORM\ManyToOne(inversedBy: 'users')]
    #[ApiProperty(readableLink: false)]
    #[Groups('user:admin')]
    private ?User $manager = null;

    /**
     * @var Collection|User[]
     */
    #[ORM\OneToMany(mappedBy: 'manager', targetEntity: User::class)]
    private Collection | array $managed;

    public function __construct()
    {
        $this->managed = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): void
    {
        $this->roles = $roles;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(?string $plainPassword): void
    {
        $this->plainPassword = $plainPassword;
    }

    public function getSalt(): ?string
    {
        return null;
    }

    public function eraseCredentials(): void
    {
        $this->plainPassword = null;
    }

    public function getUsername(): ?string
    {
        return $this->email;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): void
    {
        $this->firstname = $firstname;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): void
    {
        $this->lastname = $lastname;
    }

    public function getAddress(): ?Address
    {
        return $this->address;
    }

    public function setAddress(?Address $address): void
    {
        $this->address = $address;
        $address?->setUser($this);
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

    public function getManager(): ?User
    {
        return $this->manager;
    }

    public function setManager(?User $manager): void
    {
        $this->manager = $manager;
    }

    /**
     * @return Collection|User[]
     */
    public function getManaged(): Collection
    {
        return $this->managed;
    }

    public function addManaged(User $user): void
    {
        if (!$this->managed->contains($user)) {
            $this->managed[] = $user;
            $user->setManager($this);
        }
    }

    public function removeManaged(User $user): void
    {
        if ($this->managed->removeElement($user) && $user->getManager() === $this) {
            $user->setManager(null);
        }
    }

//
//    public function getCurrentValues(): array
//    {
//        return [
//            'organization' => $this->getOrganization(),
//            'service' => $this->getService(),
//            'position' => $this->getPosition(),
//            'manager' => $this,
//        ];
//    }
}
