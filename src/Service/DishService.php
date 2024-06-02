<?php
namespace App\Service;
use App\Entity\Dish;
use App\Repository\DishRepository;
use Symfony\Component\Serializer\SerializerInterface;
use  Doctrine\ORM\EntityManagerInterface;


class DishService
{
private $dishRepository;
private $serializer;
private $entityManager;
public function __construct(DishRepository $dishRepository,SerializerInterface $serializer,  EntityManagerInterface $entityManager){
    $this->dishRepository = $dishRepository;
    $this->serializer = $serializer;
    $this->entityManager=$entityManager;
}
public function getdish(){
    $dish= $this->dishRepository->findAll() ;
    return  $this->serializer->serialize($dish, 'json', ['groups' => 'show_dish']);

}
public function getdishById($id){
    $dish= $this->dishRepository->findById($id) ;
    return  $this->serializer->serialize($dish, 'json', ['groups' => 'show_dish']);

}
public function adddish($data){
    $dish =  $this->serializer->deserialize($data , Dish::class ,'json');
    $this->entityManager->persist($dish);
    $this->entityManager->flush();
return new Response('success', 201);
}
}
