<?php

namespace App\Entity;

use App\Repository\IngredientListRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation as Serializer;

/**
 * @ORM\Entity(repositoryClass=IngredientListRepository::class)
 */
class IngredientList
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"show_ingredientList"})
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Dish::class, inversedBy="ingredientLists")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"show_ingredientList"})
     */
    private $dish;

    /**
     * @ORM\ManyToOne(targetEntity=Ingredient::class, inversedBy="ingredientLists")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"show_ingredientList", "show_dish"})
     */
    private $ingredient;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"show_ingredientList"})
     */
    private $quantity;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDish(): ?Dish
    {
        return $this->dish;
    }

    public function setDish(?Dish $dish): self
    {
        $this->dish = $dish;

        return $this;
    }

    public function getIngredient(): ?Ingredient
    {
        return $this->ingredient;
    }

    public function setIngredient(?Ingredient $ingredient): self
    {
        $this->ingredient = $ingredient;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }
}
