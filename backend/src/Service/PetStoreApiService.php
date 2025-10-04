<?php

namespace App\Service;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use App\DTO\PetDTO;

/**
 * Since it is just a POC and I'd liked to show more sophisticated way of thinking,
 * I've chosen to map request data to DTOs in Controller, pass them here, serialize them
 * if needed for request and return the DTO outside. It seems a clear way to separate concerns,
 * even though in this example it is an obvious overkill, because we do not perform any
 * operations on those DTOs and it looks like a chain of unneeded convertions :P
 */
class PetStoreApiService
{
    private const string BASE_URL = 'https://petstore.swagger.io/v2/';

    private Client $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => self::BASE_URL,
            'timeout'  => 30.0,
        ]);
    }

    /** @return PetDTO[] 
     * @throws \RuntimeException
     */
    public function getAllPetsByStatus(array $statuses = ['available']): array
    {
        try {
            $response = $this->client->get('pet/findByStatus', [
                'query' => ['status' => implode(',', $statuses)]
            ]);
            $decoded = json_decode($response->getBody(), true) ?? [];
            if (!is_array($decoded)) {
                throw new \RuntimeException("Invalid response format from PetStore API");
            }

            return array_map(fn($petData) => PetDTO::fromArray($petData), $decoded);
        } catch (RequestException $e) {
            throw new \RuntimeException("We could not get pets by status: " . $e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * @return PetDTO
     * @throws \RuntimeException
     */
    public function getPetById(int $id): PetDTO
    {
        try {
            $response = $this->client->get("pet/{$id}");
            return PetDTO::fromArray(json_decode($response->getBody(), true));
        } catch (RequestException $e) {
            throw new \RuntimeException("We could not get a pet: " . $e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * @return PetDTO
     * @throws \RuntimeException
     */
    public function addPet(PetDTO $pet): PetDTO
    {
        try {
            $response = $this->client->post('pet', [
                'json' => $pet->toArray()
            ]);
            return PetDTO::fromArray(json_decode($response->getBody(), true));
        } catch (RequestException $e) {
            throw new \RuntimeException("We could not add a pet: " . $e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * @throws \RuntimeException
     */
    public function updatePet(PetDTO $pet): PetDTO
    {
        try {
            $response = $this->client->put('pet', [
                'json' => $pet->toArray()
            ]);
            return PetDTO::fromArray(json_decode($response->getBody(), true));
        } catch (RequestException $e) {
            throw new \RuntimeException("We could not update a pet: " . $e->getMessage(), $e->getCode(), $e);
        }
    }

    /** 
     * @return string[]
     * @throws \RuntimeException
     */
    public function deletePet(int $id): array
    {
        try {
            $response = $this->client->delete("pet/{$id}");
            return ['success' => $response->getStatusCode() === 200];
        } catch (RequestException $e) {
            throw new \RuntimeException("We could not delete a pet: " . $e->getMessage(), $e->getCode(), $e);
        }
    }
}
