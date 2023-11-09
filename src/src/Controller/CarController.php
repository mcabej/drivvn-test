<?php

namespace App\Controller;

use App\DTO\CarDTO;
use App\Entity\Car;
use App\Entity\Color;
use App\Repository\CarRepository;
use App\Traits\HTTPResponseTrait;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api/car')]
class CarController extends AbstractController
{
    use HTTPResponseTrait;

    public function __construct(
        protected ValidatorInterface $validator, 
        protected EntityManagerInterface $entityManager        
    ) {        
    }

    #[Route('/cars', name: 'car_list', methods: ['GET'])] 
    public function listCars(CarRepository $carRepository): Response {
        $result = $carRepository->findAll();
        if (count($result) <= 0) {
            return $this->generateCustomResponse(Response::HTTP_NO_CONTENT, null, 'no cars found');
        }        

        return $this->json($result);
    }

    #[Route('/{id}', name: 'car_get', methods: ['GET'])] 
    public function getCar(CarRepository $carRepository, int $id): Response {
        $result = $carRepository->findOneBy(['id' => $id]);
        if (!$result) {
            return $this->generateCustomResponse(Response::HTTP_NOT_FOUND, null, 'car with id: '.$id.', not found');
        }       
        
        return $this->json($result);
    }
    

    #[Route('/create', name: 'car_create', methods: ['POST'])]
    public function createCar(
        #[MapRequestPayload(acceptFormat: 'json')] CarDTO $carDto,        
        CarRepository $carRepository
    ): Response {
        $newCar = new Car();     
        $newCar->setMake($carDto->make);
        $newCar->setModel($carDto->model);
        $newCar->setBuildDate($carDto->buildDate);

        $color = $this->entityManager->getRepository(Color::class)->findOneBy(['id' => $carDto->color]);
        if (!$color) {
            return $this->generateCustomResponse(Response::HTTP_BAD_REQUEST, null, 'color does not exist: '.$carDto->color);
        }

        $newCar->setColor($color);        

        $this->entityManager->persist($newCar);
        $this->entityManager->flush();       
        
        return $this->json($newCar, Response::HTTP_CREATED);
    }

    #[Route('/{id}', name: 'car_delete', methods: ['DELETE'])]
    public function deleteCar(CarRepository $carRepository, int $id): Response {
        $result = $carRepository->findOneBy(['id' => $id]);
        if (!$result) {
            return $this->generateCustomResponse(Response::HTTP_NOT_FOUND, null, 'car with id: '.$id.', not found');
        }   

        $this->entityManager->remove($result);
        $this->entityManager->flush();

        return $this->generateCustomResponse(Response::HTTP_ACCEPTED, null, 'car with id: '.$id.', deleted');
    }
}
