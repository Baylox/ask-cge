<?php

namespace App\Entity;

use App\Repository\BoardRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\UX\Turbo\Attribute\Broadcast;

#[ORM\Entity(repositoryClass: BoardRepository::class)]
// #[Broadcast]
class Board
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $title = null;

    /**
     * @var Collection<int, Account>
     */
    #[ORM\ManyToMany(targetEntity: Account::class, mappedBy: 'boards')]
    private Collection $accounts;

    /**
     * @var Collection<int, lane>
     */
    #[ORM\OneToMany(mappedBy: 'board', targetEntity: Lane::class, orphanRemoval: true, cascade: ['persist'])]
    #[ORM\OrderBy(['position' => 'ASC'])]
    private Collection $lanes;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column(enumType:BoardState::class)]
    private BoardState $state = BoardState::Draft;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $createdAt = null;


    public function __construct()
    {
        $this->accounts = new ArrayCollection();
        $this->lanes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return Collection<int, Account>
     */
    public function getAccounts(): Collection
    {
        return $this->accounts;
    }

    public function addAccount(Account $account): static
    {
        if (!$this->accounts->contains($account)) {
            $this->accounts->add($account);
            $account->addBoard($this);
        }

        return $this;
    }

    public function removeAccount(Account $account): static
    {
        if ($this->accounts->removeElement($account)) {
            $account->removeBoard($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, lane>
     */
    public function getLanes(): Collection
    {
        return $this->lanes;
    }

    public function addLane(lane $lane): static
    {
        if (!$this->lanes->contains($lane)) {
            $this->lanes->add($lane);
            $lane->setBoard($this);
        }

        return $this;
    }

    public function removeLane(lane $lane): static
    {
        if ($this->lanes->removeElement($lane)) {
            // set the owning side to null (unless already changed)
            if ($lane->getBoard() === $this) {
                $lane->setBoard(null);
            }
        }

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get the value of state
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set the value of state
     *
     * @return  self
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
