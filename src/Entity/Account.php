<?php

namespace App\Entity;

use App\Repository\AccountRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\UX\Turbo\Attribute\Broadcast;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use App\Entity\Role;

#[ORM\Entity(repositoryClass: AccountRepository::class)]
// #[Broadcast]
class Account implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $email = null;

    #[ORM\Column(length: 125)]
    private ?string $password = null;

    #[ORM\ManyToOne(inversedBy: 'accounts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Role $role = null;

    /**
     * @var Collection<int, Board>
     */
    #[ORM\ManyToMany(targetEntity: Board::class, inversedBy: 'accounts')]
    private Collection $boards;

    public function __construct()
    {
        $this->boards = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): string
    {
        return $this->password ?? '';
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;
        return $this;
    }

    public function getUserIdentifier(): string
    {
        return $this->email ?? '';
    }

    /*
    * Function for user roles
    */
    public function getRoles(): array
    {
        // Get the role label (ROLE_ADMIN, ROLE_USER, etc.)
        $roleLabel = $this->role?->getLabel() ?? 'ROLE_USER';

        // Symfony expects an array
        $roles = [$roleLabel];

        // Always guarantee at least ROLE_USER
        if (!in_array('ROLE_USER', $roles, true)) {
            $roles[] = 'ROLE_USER';
        }

        return array_unique($roles);
    }
    
    public function getRole(): ?Role
    {
        return $this->role;
    }

    public function setRole(?Role $role): self
    {
        $this->role = $role;
        return $this;
    }

    public function eraseCredentials(): void {}

    /**
     * @return Collection<int, board>
     */
    public function getBoards(): Collection
    {
        return $this->boards;
    }

    public function addBoard(board $board): static
    {
        if (!$this->boards->contains($board)) {
            $this->boards->add($board);
        }

        return $this;
    }

    public function removeBoard(board $board): static
    {
        $this->boards->removeElement($board);

        return $this;
    }
}
