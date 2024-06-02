<?php
namespace App\Service;

use App\Repository\IngredientRepository;
use App\Entity\Ingredient;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use  Doctrine\ORM\EntityManagerInterface;
class IngredientService
{
    private $ingredientRepository;
    private $serializer;
    private $entityManager;
    public function __construct(IngredientRepository $ingredientRepository, SerializerInterface $serializer, EntityManagerInterface $entityManager)
    {
        $this->ingredientRepository = $ingredientRepository;
        $this->serializer = $serializer;
        $this->entityManager=$entityManager;

    }

    public function getAllIngredients()
    {
        $ingredients= $this->ingredientRepository->findAll();
        $data = array('ingredients' => array());
        foreach ($ingredients as $ingredient) {
            $data['ingredients'][] = $this->serializeIngredient($ingredient);
        }
        $response = new Response(json_encode($data), 200);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    private function serializeIngredient(Ingredient $ingredient)
    {
        return array(
            'id' => $ingredient->getId(),
            'name' => $ingredient->getName(),
        );
    }

    public function addIngredient($data){
        $ingredient =  $this->serializer->deserialize($data , Ingredient::class ,'json');
        $this->entityManager->persist($ingredient);
        $this->entityManager->flush();
    return new Response('success', 201);
    }

    public function getById($id){
        $ingrdient=$this->ingredientRepository->findById($id);
        return  $this->serializer->serialize($ingrdient, 'json', ['groups' => 'show_ingredient']);
    }
}
