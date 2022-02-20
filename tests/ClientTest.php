<?php
namespace RobsonSanches\Stays\Client\Tests;

use PHPUnit\Framework\TestCase;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\RequestException;

use RobsonSanches\Stays\Client\Client;
use RobsonSanches\Stays\Client\ClientException;

class ClientTest extends TestCase
{

    public function testHttpInstance()
    {

        $client = new Client('https://play.stays.net/', 'xxxxxx', 'xxxxxx', [
            'http_errors' => false
        ]);

        $this->assertInstanceOf('RobsonSanches\\Stays\\Client\\Http\\HttpClient', $client->http());
    }

    public function testRequest()
    {
        $mock = new MockHandler([
            new Response(200, ['X-Foo' => 'Bar'], file_get_contents('json/create-group/response.json', FILE_USE_INCLUDE_PATH)),
            new Response(202, ['Content-Length' => 0]),
            new RequestException('Error Communicating with Server', new Request('POST', '/content/groups'))
        ]);
        
        $handlerStack = HandlerStack::create($mock);
        
        $client = new Client('', '', '', ['http_errors' => true,'http_client_options' => ['handler' => $handlerStack]]);
        
        try {

            $response = $client->request('POST','/content/groups', [
                'body' => json_decode(file_get_contents('json/create-group/request.json', FILE_USE_INCLUDE_PATH), true)
            ]);
       
        } catch(ClientException $e){
            echo $e->getMessage();
        }

        $this->assertArrayHasKey('internalName',$response);

    }

    public function testPost()
    {
        $mock = new MockHandler([
            new Response(200, ['X-Foo' => 'Bar'], file_get_contents('json/create-group/response.json', FILE_USE_INCLUDE_PATH)),
            new Response(202, ['Content-Length' => 0]),
            new RequestException('Error Communicating with Server', new Request('POST', '/content/groups'))
        ]);
        
        $handlerStack = HandlerStack::create($mock);
        
        $client = new Client('', '', '', ['http_errors' => true,'http_client_options' => ['handler' => $handlerStack]]);
        
        try {

            $response = $client->request('POST','/content/groups', [
                'body' => json_decode(file_get_contents('json/create-group/request.json', FILE_USE_INCLUDE_PATH), true)
            ]);
       
        } catch(ClientException $e){
            echo $e->getMessage();
        }

        $this->assertArrayHasKey('internalName',$response);

    }

    public function testPatch()
    {
        $mock = new MockHandler([
            new Response(200, ['X-Foo' => 'Bar'], file_get_contents('json/modify-group/response.json', FILE_USE_INCLUDE_PATH)),
            new Response(202, ['Content-Length' => 0]),
            new RequestException('Error Communicating with Server', new Request('PATCH', '/content/groups/5eb2ae76e4dd9757b91fffb5'))
        ]);
        
        $handlerStack = HandlerStack::create($mock);
        
        $client = new Client('', '', '', ['http_errors' => true,'http_client_options' => ['handler' => $handlerStack]]);
        
        try {

            $response = $client->patch('/content/groups/5eb2ae76e4dd9757b91fffb5',
                json_decode(file_get_contents('json/modify-group/request.json', FILE_USE_INCLUDE_PATH), true)
            );
       
        } catch(ClientException $e){
            echo $e->getMessage();
        }

        $this->assertArrayHasKey('internalName',$response);


    }

    public function testGet()
    {

        $mock = new MockHandler([
            new Response(200, ['X-Foo' => 'Bar'], file_get_contents('json/retrieve-group/response.json', FILE_USE_INCLUDE_PATH)),
            new Response(202, ['Content-Length' => 0]),
            new RequestException('Error Communicating with Server', new Request('GET', '/content/groups/5eb2ae76e4dd9757b91fffb5'))
        ]);
        
        $handlerStack = HandlerStack::create($mock);
        
        $client = new Client('', '', '', ['http_errors' => true,'http_client_options' => ['handler' => $handlerStack]]);
        
        try {
            $response = $client->get('/content/groups/5eb2ae76e4dd9757b91fffb5');
       
        } catch(ClientException $e){
            echo $e->getMessage();
        }

        $this->assertArrayHasKey('internalName',$response);

    }

    public function testDelete()
    {

        $mock = new MockHandler([
            new Response(200, ['X-Foo' => 'Bar'], file_get_contents('json/delete-group/response.json', FILE_USE_INCLUDE_PATH)),
            new Response(202, ['Content-Length' => 0]),
            new RequestException('Error Communicating with Server', new Request('DELETE', '/content/groups/5eb2ae76e4dd9757b91fffb5'))
        ]);
        
        $handlerStack = HandlerStack::create($mock);
        
        $client = new Client('', '', '', ['http_errors' => true,'http_client_options' => ['handler' => $handlerStack]]);
        
        try {

            $response = $client->delete('/content/groups/5eb2ae76e4dd9757b91fffb5');
       
        } catch(ClientException $e){
            echo $e->getMessage();
        }

        $this->assertArrayHasKey('internalName',$response);

    }

}