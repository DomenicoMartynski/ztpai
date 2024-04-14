<?php

namespace App\Entity;

use App\Repository\GamesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GamesRepository::class)]
class Games
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $game_name = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $release_date = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $game_cover = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    /**
     * @var Collection<int, Genres>
     */
    #[ORM\ManyToMany(targetEntity: Genres::class, inversedBy: 'games')]
    private Collection $GameGenres;

    /**
     * @var Collection<int, Platforms>
     */
    #[ORM\ManyToMany(targetEntity: Platforms::class, inversedBy: 'games')]
    private Collection $GamePlatforms;

    /**
     * @var Collection<int, Reviews>
     */
    #[ORM\OneToMany(targetEntity: Reviews::class, mappedBy: 'ReviewedGame')]
    private Collection $reviews;

    public function __construct()
    {
        $this->GameGenres = new ArrayCollection();
        $this->GamePlatforms = new ArrayCollection();
        $this->reviews = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGameName(): ?string
    {
        return $this->game_name;
    }

    public function setGameName(string $game_name): static
    {
        $this->game_name = $game_name;

        return $this;
    }

    public function getReleaseDate(): ?\DateTimeInterface
    {
        return $this->release_date;
    }

    public function setReleaseDate(\DateTimeInterface $release_date): static
    {
        $this->release_date = $release_date;

        return $this;
    }

    public function getGameCover(): ?string
    {
        return $this->game_cover;
    }

    public function setGameCover(?string $game_cover): static
    {
        $this->game_cover = $game_cover;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, Genres>
     */
    public function getGameGenres(): Collection
    {
        return $this->GameGenres;
    }

    public function addGameGenre(Genres $gameGenre): static
    {
        if (!$this->GameGenres->contains($gameGenre)) {
            $this->GameGenres->add($gameGenre);
        }

        return $this;
    }

    public function removeGameGenre(Genres $gameGenre): static
    {
        $this->GameGenres->removeElement($gameGenre);

        return $this;
    }

    /**
     * @return Collection<int, Platforms>
     */
    public function getGamePlatforms(): Collection
    {
        return $this->GamePlatforms;
    }

    public function addGamePlatform(Platforms $gamePlatform): static
    {
        if (!$this->GamePlatforms->contains($gamePlatform)) {
            $this->GamePlatforms->add($gamePlatform);
        }

        return $this;
    }

    public function removeGamePlatform(Platforms $gamePlatform): static
    {
        $this->GamePlatforms->removeElement($gamePlatform);

        return $this;
    }

    /**
     * @return Collection<int, Reviews>
     */
    public function getReviews(): Collection
    {
        return $this->reviews;
    }

    public function addReview(Reviews $review): static
    {
        if (!$this->reviews->contains($review)) {
            $this->reviews->add($review);
            $review->setReviewedGame($this);
        }

        return $this;
    }

    public function removeReview(Reviews $review): static
    {
        if ($this->reviews->removeElement($review)) {
            // set the owning side to null (unless already changed)
            if ($review->getReviewedGame() === $this) {
                $review->setReviewedGame(null);
            }
        }

        return $this;
    }
}
