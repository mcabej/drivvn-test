<?php

namespace App\Tests\Controller;

use ApiTestCase\JsonApiTestCase;
use App\Entity\Car;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;

class CarControllerTest extends JsonApiTestCase
{
    public function testGetCar(): void
    {
        $this->client->request('GET', '/api/car/1');
        
        $response = $this->client->getResponse();
        
        // status is 200
        $this->assertResponseCode($response, Response::HTTP_OK);

        $expected = [
            'id' => 1,
            'make' => 'Honda',
            'model' => 'Prius',
            'color' => [
                'id' => 1,
                'name' => 'red'
            ], 
            'buildDate' => '2020-03-25T00:00:00-07:00'
        ];

        $actual = json_decode($response->getContent(), true);
        $this->assertEquals($expected, $actual);
    }

    public function testGetNonExistingCar(): void
    {
        $this->client->request('GET', '/api/car/999');
        
        $response = $this->client->getResponse();
        
        // status is 200
        $this->assertResponseCode($response, Response::HTTP_NOT_FOUND);
    }

    public function testCreateCar(): void
    {
        $this->client->request(
            'POST',
            '/api/car/create',
            [],
            [],
            [
                'CONTENT_TYPE' => 'application/json',
            ],
            json_encode(['make' => 'Ferrari', 'model' => 'Roma', 'buildDate' => '2020-11-09', 'color' => 1])
        );

        $response = $this->client->getResponse();

        // status is 201
        $this->assertResponseCode($response, Response::HTTP_CREATED);
        
        $car = json_decode($response->getContent(), true);
        $this->assertEquals($car['make'], 'Ferrari');

        $this->assertTrue( 
            $response->headers->contains('Content-Type', 'application/json'),
            $response->headers
        );
    }

    public function testCreateCarInvalidColor(): void
    {
        $this->client->request(
            'POST',
            '/api/car/create',
            [],
            [],
            [
                'CONTENT_TYPE' => 'application/json',
            ],
            json_encode(['make' => 'Ferrari', 'model' => 'Roma', 'buildDate' => '2020-11-09', 'color' => 99])
        );

        $response = $this->client->getResponse();

        // status is 400
        $this->assertResponseCode($response, Response::HTTP_BAD_REQUEST);
    }

    public function testCreateCarInvalidDate(): void
    {
        $this->client->request(
            'POST',
            '/api/car/create',
            [],
            [],
            [
                'CONTENT_TYPE' => 'application/json',
            ],
            json_encode(['make' => 'Vauxhall', 'model' => 'Astra', 'buildDate' => '2015-11-09', 'color' => 1])
        );

        $response = $this->client->getResponse();

        // status is 400
        $this->assertResponseCode($response, Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function testCreateCarMissingMake(): void
    {
        $this->client->request(
            'POST',
            '/api/car/create',
            [],
            [],
            [
                'CONTENT_TYPE' => 'application/json',
            ],
            json_encode(['model' => 'Roma', 'buildDate' => '2020-11-09', 'color' => 1])
        );

        $response = $this->client->getResponse();

        // status is 422
        $this->assertResponseCode($response, Response::HTTP_UNPROCESSABLE_ENTITY);

        $content = json_decode($response->getContent(), true);
        $violations = $content['violations'];
        $this->assertTrue(!empty($violations), 'validation failed');
    }

    public function testDeleteCar(): void
    {
        $this->client->request('DELETE', '/api/car/1');

        $response = $this->client->getResponse();

        // status is 202
        $this->assertResponseCode($response, Response::HTTP_ACCEPTED);
    }

    public function testDeleteNonExistingCar(): void
    {
        $this->client->request('DELETE', '/api/car/999');

        $response = $this->client->getResponse();

        // status is 404
        $this->assertResponseCode($response, Response::HTTP_NOT_FOUND);
    }
}
