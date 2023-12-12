<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class ProductControllerTest extends WebTestCase
{

    public function testCreateAction()
    {
        $client = static::createClient();

        $client->jsonRequest('POST', '/api/products', [
                "name" => "testowe",
                "description" => "testowy opis",
                "price" => 4.1
            ],
            [
                'CONTENT_TYPE' => 'application/json'
            ]
        );

        // var_dump($client->getResponse());

        $this->assertResponseHeaderSame('x-task', '1');

        $this->assertInstanceOf(Response::class, $client->getResponse());

        $this->assertResponseStatusCodeSame(200);
    }
    
}