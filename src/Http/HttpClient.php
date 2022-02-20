<?php

namespace RobsonSanches\Stays\Client\Http;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

/**
 * Class HttpClient
 */
class HttpClient
{

    /**
     * Options.
     *
     * @var array
     */
    protected $options;

    /**
     * Client.
     *
     * @var Client
     */
    protected $client;

    /**
     * Request.
     *
     * @var Request
     */
    protected $request;

    /**
     * Response.
     *
     * @var Response
     */
    protected $response;

    /**
     * Initialize http client.
     *
     * @param array  $options Options.
     */
    public function __construct(array $options)
    {
        $this->options = $options;
        $this->client = new Client($this->options);
    }

    /**
     * Execute a http request.
     * 
     * @param string     $method    http method.
     * @param string     $url       Request URL.
     * @param array      $options   options (query, body, headers)
     * 
     * @return \HttpClient\Response
     */
    public function request(string $method, string $url, array $options = [])
    {
        $this->request = new Request($method, $url);
        $this->response = $this->client->send($this->request, $options);

        return $this->response;
    }

    /**
     * Get http client request.
     * 
     * @return \HttpClient\Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * Get http client response.
     * 
     * @return \HttpClient\Response
     */
    public function getResponse()
    {
        return $this->response;
    }


}