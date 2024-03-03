<?php

namespace App\Entity;

use App\Repository\IngredientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation as Serializer;


/**
 * @ORM\Entity(repositoryClass=IngredientRepository::class)
 */
class Ingredient
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Serializer\Groups({"show_ingrediennt"})
     * 
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Serializer\Groups({"show_ingrediennt"})
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=IngredientList::class, mappedBy="ingredient")
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

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
            $ingredientList->setIngredient($this);
        }

        return $this;
    }

    public function removeIngredientList(IngredientList $ingredientList): self
    {
        if ($this->ingredientLists->removeElement($ingredientList)) {
            // set the owning side to null (unless already changed)
            if ($ingredientList->getIngredient() === $this) {
                $ingredientList->setIngredient(null);
            }
        }

        return $this;
    }
}
