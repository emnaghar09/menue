<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\IngredientService;
use Symfony\Component\HttpFoundation\JsonResponse;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\SerializerInterface;

class IngredientController extends AbstractController
{
    /**
     * @Route("/ingredient", name="app_ingredient")
     */
    public function index(): Response
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/IngredientController.php',
        ]);
    }
    /**
     * @Rest\Get("/allIngredient", name="show_ingrediennt")
      * @Rest\View(serializerGroups={"show_ingrediennt"})
     */
    public function showAllIngredient(IngredientService $ingredientService)
    {
        $ingredients = $ingredientService->getAllIngredients();
        return new JsonResponse($ingredients);
    }

}
