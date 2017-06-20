<?php

use App\Facades\Test;

/**
 * Class RaiseTest
 *
 * Executes phpunit test cases
 * for standard RAISe Procedures
 */
class RaiseTest extends Test
{
    /**
     * Test the RAISe Default Route
     *
     * Try to get the default definition of a Route
     *
     * @test
     */
    public function testIndex()
    {
        $this->configureRaise(['Content-Type' => 'application/json'], 'GET', $_SERVER, '/');

        $this->executeRaise();

        $this->assertInstanceOf(\App\Models\Response\Message::class, response()::getResponse());

        $this->assertEquals(200, response()::getResponse()->code);
    }

    /**
     * Test the RAISe Not Found Route
     *
     * Try to get the not found route of RAISe
     *
     * @test
     */
    public function testNotFound()
    {
        $this->configureRaise(['Content-Type' => 'application/json'], 'GET', $_SERVER, '/doesntexist');

        $this->executeRaise();

        $this->assertInstanceOf(\App\Models\Response\Message::class, response()::getResponse());

        $this->assertEquals(404, response()::getResponse()->code);
    }
}
