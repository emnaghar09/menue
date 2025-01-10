<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\IngredientService;
use App\Service\IngredientListService;
use Symfony\Component\HttpFoundation\JsonResponse;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\HttpFoundation\Request;
use App\Service\DishService;
use FOS\RestBundle\Request\ParamFetcher;
use  App\Service\FileUploaderService;


class IngredientController extends AbstractController
{
    
public $ingredientListService;
public $dishService;
public function __construct(IngredientListService $ingredientListService, DishService $dishService){

    $this->ingredientListService=$ingredientListService;
    $this->dishService=$dishService;

}
    /**
     * @Rest\Get("/ingredient", name="show_ingredient")
     * @Rest\View(serializerGroups={"show_ingrediennt"})
    */
    public function showAllIngredient(IngredientService $ingredientService)
    {
        return  $ingredientService->getAllIngredients();
    }
    /**
     * @Rest\Get("/ingredient/{id}")
     * @Rest\View(serializerGroups={"show_ingrediennt"})
     */
    public function getIngredientById($id,IngredientService $ingredientService){
        $jsonData = $ingredientService->getById($id);
        return new JsonResponse($jsonData, 200, [], true);
    }

    /**
     * @Rest\FileParam(name="imagePath",description="photo de l'ingredient")
     * @Rest\Post("/ingredient", name="add_ingredient")
    */
    public function addIngredient(Request $request, IngredientService $ingredientService, ParamFetcher $paramFetcher,  FileUploaderService $fileUploaderService){
        $imageFile = $paramFetcher->get('imagePath');
        return  $ingredientService->addIngredient($request, $imageFile , $fileUploaderService);
    }

    /**
     * @Rest\Get("/ingredientList")
     * @Rest\View(serializerGroups={"show_ingredientList"})
     */
    public function getIngredientList()
    {
        $data = $this->ingredientListService->getIngredientList();
        return new JsonResponse($data, 200, [], true);
    }

    /**
     * @Rest\Post("/ingredientList")
     * @Rest\View(serializerGroups={"show_ingredientList"})
     */
    public function addIngredientList( ParamFetcher $paramFetcher, Request $request)
    {
        $image = $paramFetcher->get('image');
        
        return  $this->ingredientListService->addIngredientList($request->getContent());
    }

    /**
     * @Rest\Get("/ingredientbyDish/{dishId}")
     * @Rest\View(serializerGroups={"show_ingredientList"})
     */
    public function getIngredientListByDish($dishId){
        $jsonData =  $this->ingredientListService->getIngredientListByDish($dishId);
        return new JsonResponse($jsonData, 200, [], true);
    }


        /**
     * @Rest\Get("/dish")
     * @Rest\View(serializerGroups={"show_dish"})
     */
    public function getDish()
    {
        $data = $this->dishService->getDish();
        return new JsonResponse($data, 200, [], true);
    }

    /**
     * @Rest\Post("/dish")
     * @Rest\View(serializerGroups={"show_dish"})
     */
    public function addDish(Request $request)
    {
        return  $this->dishService->addDish($request->getContent());
    }
}
