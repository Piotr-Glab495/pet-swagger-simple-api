<?php

namespace App\Controller;

use App\DTO\NamedElementDTO;
use App\DTO\PetDTO;
use App\Service\PetStoreApiService;
use RuntimeException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PetController extends AbstractController
{
    private PetStoreApiService $petService;

    public function __construct(PetStoreApiService $petService)
    {
        $this->petService = $petService;
    }

    #[Route('/api/pets', name: 'get_pets', methods: ['GET'])]
    public function getPets(Request $request): JsonResponse
    {
        $statuses = $request->query->get($key = 'status', $default = 'available');
        $statusesArray = explode(',', $statuses);

        try {
            $pets = $this->petService->getAllPetsByStatus($statusesArray);
        } catch(RuntimeException $e) {
            return $this->json(['error' => $e->getMessage()], $e->getCode());
        }
        return $this->json($pets);
    }

    #[Route('/api/pet/{id}', name: 'get_pet', methods: ['GET'])]
    public function getPet(int $id): JsonResponse
    {
        try {
            $pet = $this->petService->getPetById($id);
        } catch(RuntimeException $e) {
            return $this->json(['error' => $e->getMessage()], $e->getCode());
        }
        return $this->json($pet);
    }

    #[Route('/api/pet', name: 'add_pet', methods: ['POST'])]
    public function addPet(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $petDTO = PetDTO::fromArray($data);
        try {
            $result = $this->petService->addPet($petDTO);
        } catch(RuntimeException $e) {
            return $this->json(['error' => $e->getMessage()], $e->getCode());
        }
        return $this->json($result);
    }

    #[Route('/api/pet', name: 'update_pet', methods: ['PUT'])]
    public function updatePet(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $petDTO = PetDTO::fromArray($data);
        try {
            $result = $this->petService->updatePet($petDTO);
        } catch(RuntimeException $e) {
            return $this->json(['error' => $e->getMessage()], $e->getCode());
        }
        return $this->json($result);
    }

    #[Route('/api/pet/{id}', name: 'delete_pet', methods: ['DELETE'])]
    public function deletePet(int $id): JsonResponse
    {
        try {
            $result = $this->petService->deletePet($id);
        } catch(RuntimeException $e) {
            return $this->json(['error' => $e->getMessage()], $e->getCode());
        }
        return $this->json($result);
    }
}
