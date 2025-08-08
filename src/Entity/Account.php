<?php

namespace App\Entity;

use App\Repository\AccountRepository;
use App\Entity\Role;
use App\Entity\Board;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: AccountRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'Cet email est déjà utilisé.')]
class Account implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank]
    #[Assert\Email(mode: 'strict')]
    #[Assert\Length(max: 255)]
    #[ORM\Column(length: 255, unique: true)]
    private ?string $email = null;

    #[Assert\NotBlank(groups: ['create'])]
    #[Assert\Length(min: 8, max: 125)]
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

    // ==================== Getters / Setters ====================

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $hashedPassword): self
    {
        $this->password = $hashedPassword;
        return $this;
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

    /**
     * @return Collection<int, Board>
     */
    public function getBoards(): Collection
    {
        return $this->boards;
    }

    public function addBoard(Board $board): self
    {
        if (!$this->boards->contains($board)) {
            $this->boards->add($board);
        }
        return $this;
    }

    public function removeBoard(Board $board): self
    {
        $this->boards->removeElement($board);
        return $this;
    }

    // ==================== Security ====================

    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    public function getRoles(): array
    {
        // On récupère le label depuis l'entité Role
        $label = $this->role?->getLabel();

        if ($label) {
            $label = strtoupper($label);
            if (!str_starts_with($label, 'ROLE_')) {
                $label = 'ROLE_' . $label;
            }
            $roles = [$label];
        } else {
            $roles = [];
        }

        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function eraseCredentials(): void
    {
        // $this->plainPassword = null;
    }

    // ==================== Utilitaire ====================

    public function __toString(): string
    {
        return $this->email ?? 'account#' . $this->id;
    }
}


