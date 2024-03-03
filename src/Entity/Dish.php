<?php

namespace App\Entity;

use App\Repository\DishRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DishRepository::class)
 */
class Dish
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="time", nullable=true)
     */
    private $time;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $difficulty;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $rating;

    /**
     * @ORM\OneToMany(targetEntity=IngredientList::class, mappedBy="dish")
     */
    private $ingredientLists;

    public function __construct()
    {
        $this->ingredientLists = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTime(): ?\DateTimeInterface
    {
        return $this->time;
    }

    public function setTime(?\DateTimeInterface $time): self
    {
        $this->time = $time;

        return $this;
    }

    public function getDifficulty(): ?int
    {
        return $this->difficulty;
    }

    public function setDifficulty(?int $difficulty): self
    {
        $this->difficulty = $difficulty;

        return $this;
    }

    public function getRating(): ?int
    {
        return $this->rating;
    }

    public function setRating(?int $rating): self
    {
        $this->rating = $rating;

        return $this;
    }

    /**
     * @return Collection<int, IngredientList>
     */
    public function getIngredientLists(): Collection
    {
        return $this->ingredientLists;
    }

    public function addIngredientList(IngredientList $ingredientList): self
    {
        if (!$this->ingredientLists->contains($ingredientList)) {
            $this->ingredientLists[] = $ingredientList;
            $ingredientList->setDish($this);
        }

        return $this;
    }

    public function removeIngredientList(IngredientList $ingredientList): self
    {
        if ($this->ingredientLists->removeElement($ingredientList)) {
            // set the owning side to null (unless already changed)
            if ($ingredientList->getDish() === $this) {
                $ingredientList->setDish(null);
            }
        }

        return $this;
    }
}
