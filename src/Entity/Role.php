<?php

namespace App\Entity;

use App\Repository\RoleRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="roles")
 * @ORM\Entity(repositoryClass=RoleRepository::class)
 * @UniqueEntity("login")
 */
class Role implements UserInterface, PasswordAuthenticatedUserInterface
{
    public const ROLE_INSTRUCTOR = 'ROLE_INSTRUCTOR';
    public const ROLE_ADMIN = 'ROLE_ADMIN';

    public const ROLE_NAMES = [
        self::ROLE_INSTRUCTOR => 'Инструктор',
        self::ROLE_ADMIN => 'Администратор',
    ];

    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=100)
     *
     * @Assert\NotBlank()
     * @Assert\Length(max=100)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=100, unique=true)
     *
     * @Assert\NotBlank()
     * @Assert\Length(max=100)
     */
    private $login;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=50)
     *
     * @Assert\NotBlank()
     * @Assert\Choice({Role::ROLE_INSTRUCTOR, Role::ROLE_ADMIN})
     */
    private $role;

    /**
     * @ORM\OneToOne(targetEntity=Group::class, cascade={"persist", "remove"})
     */
    private $selectedGroup;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function setLogin(string $login): self
    {
        $this->login = $login;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
    }

    public function getUserIdentifier(): ?string
    {
        return $this->getLogin();
    }

    public function getRoles(): array
    {
        $roles = [
            $this->role,
            'ROLE_USER',
        ];

        return array_unique($roles);
    }

    public function getSalt(): ?string
    {
        return null;
    }

    public function eraseCredentials(): void
    {
    }

    public function getUsername(): ?string
    {
        return $this->getUserIdentifier();
    }

    public function getSelectedGroup(): ?Group
    {
        return $this->selectedGroup;
    }

    public function setSelectedGroup(?Group $selectedGroup): self
    {
        $this->selectedGroup = $selectedGroup;

        return $this;
    }
}
