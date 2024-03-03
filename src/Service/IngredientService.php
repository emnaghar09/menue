<?php
namespace App\Service;

use App\Repository\IngredientRepository;

class IngredientService
{
    private $ingredientRepository;

    public function __construct(IngredientRepository $ingredientRepository)
    {
        $this->ingredientRepository = $ingredientRepository;
    }

    public function getAllIngredients()
    {
        return $this->ingredientRepository->findAll();
    }
}
