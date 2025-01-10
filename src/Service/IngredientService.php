<?php
namespace App\Service;

use App\Repository\IngredientRepository;
use App\Entity\Ingredient;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use  Doctrine\ORM\EntityManagerInterface;
use  App\Service\FileUploaderService;

class IngredientService
{
    private $ingredientRepository;
    private $serializer;
    private $entityManager;
    private $fileUploaderService;
    public function __construct(IngredientRepository $ingredientRepository, SerializerInterface $serializer, EntityManagerInterface $entityManager,FileUploaderService $fileUploaderService)
    {
        $this->ingredientRepository = $ingredientRepository;
        $this->serializer = $serializer;
        $this->entityManager=$entityManager;
        $this->fileUploaderService=$fileUploaderService;


    }

    // public function getAllIngredients()
    // {
    //     $ingredients= $this->ingredientRepository->findAll();
    //     $data = array('ingredients' => array());
    //     foreach ($ingredients as $ingredient) {
    //         $data['ingredients'][] = $this->serializeIngredient($ingredient);
    //     }
    //     $response = new Response(json_encode($data), 200);
    //     $response->headers->set('Content-Type', 'application/json');
    //     return $response;
    // }
    public function getAllIngredients()
    {
        $ingredients = $this->ingredientRepository->findAll();
        $data = ['ingredients' => []];
    
        foreach ($ingredients as $ingredient) {
            $ingredientData = $this->serializeIngredient($ingredient);
    
            $uploadedFile = $ingredient->getImage();
            if ($uploadedFile) {
                try {
                    $filePath = $this->fileUploaderService->getFile($uploadedFile);
                    $filePath = str_replace('\\', '/', $filePath);
                    $ingredientData['imagePath'] = $filePath; 
                } catch (\Exception $e) {
               
                    $ingredientData['imagePath'] = null;
                }
            } else {
                $ingredientData['imagePath'] = null;
            }
    
            $data['ingredients'][] = $ingredientData;
           
        }
    
        return new JsonResponse($data, 200);
    }
    
    private function serializeIngredient(Ingredient $ingredient)
    {
        return array(
            'id' => $ingredient->getId(),
            'name' => $ingredient->getName(),
        );
    }
    public function getFile($fileUploaderService, $uploadedFile)
    {

        $fileName= $fileUploaderService->getUploadedFileName($uploadedFile);
        try {
            $filePath = $fileUploaderService->getFile($fileName);
    
            return new BinaryFileResponse($filePath);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 404);
        }
    }

    public function addIngredient($request, $uploadedFile, $fileUploaderService){


    try {
        $ingredient = new Ingredient();
        $ingredient->setName($request->get('name'));
        $ingredient->setDescription([$request->get('description')]);
        $ingredient->setImage( $fileUploaderService->getUploadedFileName($uploadedFile));
        $this->entityManager->persist($ingredient);
        $this->entityManager->flush();

        $fileUploaderService->upload($uploadedFile, $fileUploaderService->getUploadedFileName($uploadedFile));
        return new JsonResponse(['message' => 'Ingredient added successfully'], Response::HTTP_CREATED);
    } catch (\Exception $e) {
        return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
    }


    public function getById($id){
        $ingrdient=$this->ingredientRepository->findById($id);
        return  $this->serializer->serialize($ingrdient, 'json', ['groups' => 'show_ingredient']);
    }
}
