<?php

namespace App\Entity;

use App\Repository\SessionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SessionRepository::class)]
class Session
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 150, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $place = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(length: 150, nullable: true)]
    private ?string $type = null;

    #[ORM\Column(nullable: true)]
    private ?int $maxPlayerNb = null;

    #[ORM\Column(nullable: true)]
    private ?int $currentPlayerNb = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $updatedAt = null;

    #[ORM\OneToMany(mappedBy: 'sessionId', targetEntity: UserSession::class)]
    private Collection $userSessions;

    public function __construct()
    {
        $this->userSessions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPlace(): ?string
    {
        return $this->place;
    }

    public function setPlace(?string $place): self
    {
        $this->place = $place;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getMaxPlayerNb(): ?int
    {
        return $this->maxPlayerNb;
    }

    public function setMaxPlayerNb(?int $maxPlayerNb): self
    {
        $this->maxPlayerNb = $maxPlayerNb;

        return $this;
    }

    public function getCurrentPlayerNb(): ?int
    {
        return $this->currentPlayerNb;
    }

    public function setCurrentPlayerNb(?int $currentPlayerNb): self
    {
        $this->currentPlayerNb = $currentPlayerNb;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return Collection<int, UserSession>
     */
    public function getUserSessions(): Collection
    {
        return $this->userSessions;
    }

    public function addUserSession(UserSession $userSession): self
    {
        if (!$this->userSessions->contains($userSession)) {
            $this->userSessions->add($userSession);
            $userSession->setSessionId($this);
        }

        return $this;
    }

    public function removeUserSession(UserSession $userSession): self
    {
        if ($this->userSessions->removeElement($userSession)) {
            // set the owning side to null (unless already changed)
            if ($userSession->getSessionId() === $this) {
                $userSession->setSessionId(null);
            }
        }

        return $this;
    }
}
