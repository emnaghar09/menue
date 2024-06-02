<?php
namespace App\Service;
use App\Entity\IngredientList;
use App\Repository\IngredientListRepository;
use Symfony\Component\Serializer\SerializerInterface;
use  Doctrine\ORM\EntityManagerInterface;


class IngredientListService
{
private $ingredientListRepository;
private $serializer;
private $entityManager;
public function __construct(IngredientListRepository $ingredientListRepository,SerializerInterface $serializer,  EntityManagerInterface $entityManager){
    $this->ingredientListRepository = $ingredientListRepository;
    $this->serializer = $serializer;
    $this->entityManager=$entityManager;
}
public function getIngredientList(){
    $ingredientList= $this->ingredientListRepository->findAll() ;
    return  $this->serializer->serialize($ingredientList, 'json', ['groups' => 'show_ingredientList']);

}
public function getIngredientListByDish($dishId){
    $ingredientList= $this->ingredientListRepository->findBydish($dishId) ;
    return  $this->serializer->serialize($ingredientList, 'json', ['groups' => 'show_ingredientList']);

}
public function addIngredientList($data){
    $ingredientList =  $this->serializer->deserialize($data , IngredientList::class ,'json');
    $this->entityManager->persist($ingredientList);
    $this->entityManager->flush();
return new Response('success', 201);
}
}
