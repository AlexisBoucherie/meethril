<?php

namespace App\Entity;

use App\Repository\UserSessionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserSessionRepository::class)]
class UserSession
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'userSessions')]
    private ?User $userId = null;

    #[ORM\ManyToOne(inversedBy: 'userSessions')]
    private ?Session $sessionId = null;

    #[ORM\Column(nullable: true)]
    private ?bool $userIsOwner = null;

    #[ORM\Column(length: 150, nullable: true)]
    private ?string $pcName = null;

    #[ORM\Column(length: 150, nullable: true)]
    private ?string $pcRace = null;

    #[ORM\Column(length: 150, nullable: true)]
    private ?string $pcClass = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $updatedAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): ?User
    {
        return $this->userId;
    }

    public function setUserId(?User $userId): self
    {
        $this->userId = $userId;

        return $this;
    }

    public function getSessionId(): ?Session
    {
        return $this->sessionId;
    }

    public function setSessionId(?Session $sessionId): self
    {
        $this->sessionId = $sessionId;

        return $this;
    }

    public function isUserIsOwner(): ?bool
    {
        return $this->userIsOwner;
    }

    public function setUserIsOwner(?bool $userIsOwner): self
    {
        $this->userIsOwner = $userIsOwner;

        return $this;
    }

    public function getPcName(): ?string
    {
        return $this->pcName;
    }

    public function setPcName(?string $pcName): self
    {
        $this->pcName = $pcName;

        return $this;
    }

    public function getPcRace(): ?string
    {
        return $this->pcRace;
    }

    public function setPcRace(?string $pcRace): self
    {
        $this->pcRace = $pcRace;

        return $this;
    }

    public function getPcClass(): ?string
    {
        return $this->pcClass;
    }

    public function setPcClass(?string $pcClass): self
    {
        $this->pcClass = $pcClass;

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
}
