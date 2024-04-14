<?php

namespace App\Entity;

use App\Repository\GameGenresRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GameGenresRepository::class)]
class GameGenres
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Collection<int, Games>
     */
    #[ORM\ManyToMany(targetEntity: Games::class, inversedBy: 'gameGenres')]
    private Collection $ID_game;

    /**
     * @var Collection<int, Genres>
     */
    #[ORM\ManyToMany(targetEntity: Genres::class, inversedBy: 'gameGenres')]
    private Collection $ID_genre;

    public function __construct()
    {
        $this->ID_game = new ArrayCollection();
        $this->ID_genre = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Games>
     */
    public function getIDGame(): Collection
    {
        return $this->ID_game;
    }

    public function addIDGame(Games $iDGame): static
    {
        if (!$this->ID_game->contains($iDGame)) {
            $this->ID_game->add($iDGame);
        }

        return $this;
    }

    public function removeIDGame(Games $iDGame): static
    {
        $this->ID_game->removeElement($iDGame);

        return $this;
    }

    /**
     * @return Collection<int, Genres>
     */
    public function getIDGenre(): Collection
    {
        return $this->ID_genre;
    }

    public function addIDGenre(Genres $iDGenre): static
    {
        if (!$this->ID_genre->contains($iDGenre)) {
            $this->ID_genre->add($iDGenre);
        }

        return $this;
    }

    public function removeIDGenre(Genres $iDGenre): static
    {
        $this->ID_genre->removeElement($iDGenre);

        return $this;
    }
}
