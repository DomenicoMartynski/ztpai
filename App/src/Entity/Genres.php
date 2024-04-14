<?php

namespace App\Entity;

use App\Repository\GenresRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GenresRepository::class)]
class Genres
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $genre_name = null;

    /**
     * @var Collection<int, GameGenres>
     */
    #[ORM\ManyToMany(targetEntity: GameGenres::class, mappedBy: 'ID_genre')]
    private Collection $gameGenres;

    public function __construct()
    {
        $this->gameGenres = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGenreName(): ?string
    {
        return $this->genre_name;
    }

    public function setGenreName(string $genre_name): static
    {
        $this->genre_name = $genre_name;

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
            $gameGenre->addIDGenre($this);
        }

        return $this;
    }

    public function removeGameGenre(GameGenres $gameGenre): static
    {
        if ($this->gameGenres->removeElement($gameGenre)) {
            $gameGenre->removeIDGenre($this);
        }

        return $this;
    }
}
