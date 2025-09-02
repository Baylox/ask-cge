<?php

namespace App\Entity;


use App\Entity\Board;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\AccountRepository;
use Symfony\UX\Turbo\Attribute\Broadcast;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Email as EmailConstraint;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


#[ORM\Entity(repositoryClass: AccountRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'This email is already used.')]
// #[Broadcast]
class Account implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    #[Assert\NotBlank(message: "Email is required.")]
    #[Assert\Email(mode: EmailConstraint::VALIDATION_MODE_STRICT)]
    #[Assert\Length(max: 255)]
    private ?string $email = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $password = null;

    #[ORM\Column(type: 'json')]
    private array $roles = [];

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

     // --- Email ---

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        // remove extra spaces and convert to lowercase
        $this->email = mb_strtolower(trim($email));

        return $this;
    }

    // --- Password (hash) ---

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

    // -- Account's Role --

    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';
        return array_values(array_unique($roles));
    }

    public function eraseCredentials(): void {}

    // --- Account's Boards ---

    /**
     * @return Collection<int, Board>
     */
    public function getBoards(): Collection
    {
        return $this->boards;
    }

    public function addBoard(Board $board): static
    {
        if (!$this->boards->contains($board)) {
            $this->boards->add($board);
            $board->addAccount($this);
        }

        return $this;
    }

    public function removeBoard(Board $board): static
    {
        if ($this->boards->removeElement($board)) {
        $board->removeAccount($this);
    }

        return $this;
    }

}
