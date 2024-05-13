<?php

namespace App\Entity;

use App\Repository\ReviewsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReviewsRepository::class)]
class Reviews
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $rating_given = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $user_comment = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $modified_at = null;

    #[ORM\ManyToOne(inversedBy: 'reviews')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Games $ReviewedGame = null;

    #[ORM\ManyToOne(inversedBy: 'reviews')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $Reviewer = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRatingGiven(): ?int
    {
        return $this->rating_given;
    }

    public function setRatingGiven(int $rating_given): static
    {
        $this->rating_given = $rating_given;

        return $this;
    }

    public function getUserComment(): ?string
    {
        return $this->user_comment;
    }

    public function setUserComment(string $user_comment): static
    {
        $this->user_comment = $user_comment;

        return $this;
    }

    public function getModifiedAt(): ?\DateTimeImmutable
    {
        return $this->modified_at;
    }

    public function setModifiedAt(\DateTimeImmutable $modified_at): static
    {
        $this->modified_at = $modified_at;

        return $this;
    }

    public function getReviewedGame(): ?Games
    {
        return $this->ReviewedGame;
    }

    public function setReviewedGame(?Games $ReviewedGame): static
    {
        $this->ReviewedGame = $ReviewedGame;

        return $this;
    }

    public function getReviewer(): ?User
    {
        return $this->Reviewer;
    }

    public function setReviewer(?User $Reviewer): static
    {
        $this->Reviewer = $Reviewer;

        return $this;
    }
}
