<?php

use App\Facades\Test;

/**
 * Class ClientTest.
 *
 * Executes phpunit test cases
 * for Client Procedures
 *
 * @see \App\Models\Communication\Client
 * @see \App\Models\Response\Client
 * @see \App\Controllers\Client
 */
class ClientTest extends Test
{
    /**
     * Test the Client Register.
     *
     * Try to insert a standard client definition
     * and verifies if the response is valid
     *
     * @uses \App\Controllers\Client
     * @uses \App\Models\Response\Client
     *
     * @test
     */
    public function testRegister()
    {
        $clientResponse = $this->createClient();

        $this->assertInstanceOf(\App\Models\Response\Token::class, $clientResponse);

        $this->assertEquals(200, $clientResponse->code);
    }

    /**
     * Test the Client Listing.
     */
    public function testList()
    {
        $clientResponse = $this->createClient();

        $queryResponse = $this->createQuery($clientResponse->token, '/client');

        $this->assertInstanceOf(\App\Models\Communication\Client::class, $queryResponse->clients[0]);

        $this->assertEquals(200, response()::response()->code);
    }

    /**
     * Test the Client Filtering.
     */
    public function testFilter()
    {
        $clientResponse = $this->createClient();

        $queryResponse = $this->createQuery($clientResponse->token,
            '/client?name=Sample Test&mac=FF:FF:FF:FF:FF');

        $this->assertInstanceOf(\App\Models\Communication\Client::class, $queryResponse->clients[0]);

        $this->assertEquals('Sample Test', $queryResponse->clients[0]->name);

        $this->assertEquals('FF:FF:FF:FF:FF', $queryResponse->clients[0]->mac);

        $this->assertEquals(200, $queryResponse->code);
    }
}
