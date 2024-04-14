<?php

namespace App\Entity;

use App\Repository\PlatformsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlatformsRepository::class)]
class Platforms
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $platform_name = null;

    /**
     * @var Collection<int, Games>
     */
    #[ORM\ManyToMany(targetEntity: Games::class, mappedBy: 'GamePlatforms')]
    private Collection $games;

    public function __construct()
    {
        $this->games = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPlatformName(): ?string
    {
        return $this->platform_name;
    }

    public function setPlatformName(string $platform_name): static
    {
        $this->platform_name = $platform_name;

        return $this;
    }

    /**
     * @return Collection<int, Games>
     */
    public function getGames(): Collection
    {
        return $this->games;
    }

    public function addGame(Games $game): static
    {
        if (!$this->games->contains($game)) {
            $this->games->add($game);
            $game->addGamePlatform($this);
        }

        return $this;
    }

    public function removeGame(Games $game): static
    {
        if ($this->games->removeElement($game)) {
            $game->removeGamePlatform($this);
        }

        return $this;
    }
}
