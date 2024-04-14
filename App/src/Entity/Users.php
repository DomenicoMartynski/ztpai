<?php

namespace App\Entity;

use App\Repository\UsersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UsersRepository::class)]
class Users
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    /**
     * @var Collection<int, Roles>
     */
    #[ORM\ManyToMany(targetEntity: Roles::class, inversedBy: 'users')]
    private Collection $UserRoles;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?UserProfile $UserProfile = null;

    /**
     * @var Collection<int, Reviews>
     */
    #[ORM\OneToMany(targetEntity: Reviews::class, mappedBy: 'Reviewer')]
    private Collection $reviews;

    public function __construct()
    {
        $this->UserRoles = new ArrayCollection();
        $this->reviews = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return Collection<int, Roles>
     */
    public function getUserRoles(): Collection
    {
        return $this->UserRoles;
    }

    public function addUserRole(Roles $userRole): static
    {
        if (!$this->UserRoles->contains($userRole)) {
            $this->UserRoles->add($userRole);
        }

        return $this;
    }

    public function removeUserRole(Roles $userRole): static
    {
        $this->UserRoles->removeElement($userRole);

        return $this;
    }

    public function getUserProfile(): ?UserProfile
    {
        return $this->UserProfile;
    }

    public function setUserProfile(UserProfile $UserProfile): static
    {
        $this->UserProfile = $UserProfile;

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
            $review->setReviewer($this);
        }

        return $this;
    }

    public function removeReview(Reviews $review): static
    {
        if ($this->reviews->removeElement($review)) {
            // set the owning side to null (unless already changed)
            if ($review->getReviewer() === $this) {
                $review->setReviewer(null);
            }
        }

        return $this;
    }
}
