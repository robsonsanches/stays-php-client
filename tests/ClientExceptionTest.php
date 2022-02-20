<?php
namespace RobsonSanches\Stays\Client\Tests;

use PHPUnit\Framework\TestCase;
use RobsonSanches\Stays\Client\ClientException;

class ClientExceptionTest extends TestCase
{

    protected $exception;

    public function setUp():void
    {
        $this->exception = new ClientException('Error', 400);
    }

    public function testInstanceOfException()
    {
        $this->assertInstanceOf('Exception', $this->exception);
    }

    public function testGetMessage()
    {
        $this->assertEquals('Error', $this->exception->getMessage());
    }

    public function testGetCode()
    {
        $this->assertEquals(400, $this->exception->getCode());
    }


}