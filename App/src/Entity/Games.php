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

    #[ORM\Column(length: 255)]
    private ?string $game_cover = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    /**
     * @var Collection<int, GameGenres>
     */
    #[ORM\ManyToMany(targetEntity: GameGenres::class, mappedBy: 'ID_game')]
    private Collection $gameGenres;

    public function __construct()
    {
        $this->gameGenres = new ArrayCollection();
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

    public function setGameCover(string $game_cover): static
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
     * @return Collection<int, GameGenres>
     */
    public function getGameGenres(): Collection
    {
        return $this->gameGenres;
    }

    public function addGameGenre(GameGenres $gameGenre): static
    {
        if (!$this->gameGenres->contains($gameGenre)) {
            $this->gameGenres->add($gameGenre);
            $gameGenre->addIDGame($this);
        }

        return $this;
    }

    public function removeGameGenre(GameGenres $gameGenre): static
    {
        if ($this->gameGenres->removeElement($gameGenre)) {
            $gameGenre->removeIDGame($this);
        }

        return $this;
    }
}
