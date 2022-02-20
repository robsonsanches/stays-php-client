<?php
/**
 * Stays PHP Client
 *
 * @package		RobsonSanches
 * @subpackage	Stays/Client
 * @category	Client
 * @author		Robson Sanches
 * @version     1.0.0
 *
 */

namespace RobsonSanches\Stays\Client;

use RobsonSanches\Stays\Client\Helper;
use RobsonSanches\Stays\Client\ClientException;
use RobsonSanches\Stays\Client\Http\HttpClient;
use RobsonSanches\Stays\Client\Http\HttpClientException;
use RobsonSanches\Stays\Client\Http\HttpRequestException;

/**
 * Class Client
 */
class Client {

    /**
     * System's domain.
     *
     * @var string
     */
    protected $domain;

    /**
     * Client ID.
     *
     * @var string
     */
    protected $clientId;

    /**
     * Client secret.
     *
     * @var string
     */
    protected $clientSecret;

    /**
     * Options.
     *
     * @var array
     */
    protected $options = [
        'type'                => 'external',
        'version'             => 'v1',
        'timeout'             => '2.0',
        'response_format'     => 'array',
        'http_errors'         => true,
        'http_client_options' => []
    ];

    /**
     * HttpClient instance.
     *
     * @var HttpClient
     */
    protected $http;

    /**
     * Initialize client.
     *
     * @param string $domain       System's domain.
     * @param string $clientId     Client ID.
     * @param string $clientSecret Client secret.
     * @param array  $options      Options (type, version, timeout, response_format, http_errors, http_client_options).
     */
    public function __construct(string $domain, string $clientId, string $clientSecret, array $options = [])
    {
        $this->domain = $domain;
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        
        $this->setOptions($options);
    }

    /**
     * Creates or return a HttpClient instance.
     *
     * @return \HttpClient
     */
    public function http():HttpClient
    {

        $defaultOptions = [
            'timeout' => $this->options['timeout'],
            'headers' => [
                'accept'        => 'application/json',
                'Authorization' => 'Basic ' . base64_encode($this->clientId . ':' . $this->clientSecret),
                'Content-Type'  => 'application/json'
            ],
            'http_errors' => $this->options['http_errors']
        ];

        $options = array_merge($defaultOptions, $this->options['http_client_options']);

        if($this->http instanceof HttpClient){
            return $this->http;

        } else {
            $this->http = new HttpClient($options);
        }

        return $this->http;
    }

    /**
     * Execute a http request.
     * 
     * @param string     $method    http method.
     * @param string     $endpoint  API endpoint.
     * @param array      $options   options (query, body, headers)
     * 
     * @return mixed
     */
    public function request(string $method, string $endpoint, array $options = [])
    {
        $url = $this->buildRequestUrl($endpoint);

        if(in_array(strtolower($method), ['post','put','patch']) && !empty($options['body']) && is_array($options['body'])){
            $options['body'] = json_encode($options['body']);
        }

        try {
            $response = $this->http()->request($method, $url, $options);

        } catch (HttpClientException $e) {
            throw new ClientException($e->getMessage(), $e->getCode(), $e);

        } catch (HttpRequestException $e) {
            throw new ClientException($e->getMessage(), $e->getCode(), $e);

        } catch (\Exception $e) {
            throw new ClientException($e->getMessage(), $e->getCode(), $e);
        }

        $result = $response->getBody()->getContents();
        $response->getBody()->seek(0);

        if(strtolower($this->options['response_format']) == 'array'){
            return json_decode(($result ?? []), true);

        } else if(strtolower($this->options['response_format']) == 'object'){
            return json_decode(($result ?? []), false);

        } else {
            return $result;
        }

    }

    /**
     * POST method.
     *
     * @param string $endpoint API endpoint.
     * @param array  $data     Request data.
     * @param array  $headers  Aditional headers.
     *
     * @return \HttpClient\Response
     */
    public function post(string $endpoint, array $data = [], array $headers = [])
    {
        return $this->request('POST', $endpoint, [
            'body' => $data,
            'headers' => $headers
        ]); 
    }

    /**
     * PATCH method.
     *
     * @param string $endpoint API endpoint.
     * @param array  $data     Request data.
     * @param array  $headers  Aditional headers.
     *
     * @return \HttpClient\Response
     */
    public function patch(string $endpoint, array $data = [], array $headers = [])
    {
        return $this->request('PATCH', $endpoint, [
            'body' => $data,
            'headers' => $headers
        ]);
    }

    /**
     * GET method.
     *
     * @param string $endpoint API endpoint.
     * @param array  $query    Request query string parameters.
     * @param array  $headers  Aditional headers.
     *
     * @return \HttpClient\Response
     */
    public function get(string $endpoint, array $query = [], array $headers = [])
    {
        return $this->request('GET', $endpoint, [
            'query' => $query,
            'headers' => $headers
        ]);
    }

    /**
     * DELETE method.
     *
     * @param string $endpoint API endpoint.
     * @param array  $query    Request query string parameters.
     * @param array  $headers  Aditional headers.
     *
     * @return \HttpClient\Response
     */
    public function delete(string $endpoint, array $query = [], array $headers = [])
    {
        return $this->request('DELETE', $endpoint, [
            'query'   => $query,
            'headers' => $headers
        ]);
    }

    /**
     * Set options.
     *
     * @return self
     */
    private function setOptions(array $options):self
    {
        $this->options = array_merge($this->options, $options);
        return $this;
    }

    /**
     * Build Request URL.
     * 
     * @param string $endpoint API endpoint.
     *
     * @return string
     */
    private function buildRequestUrl(string $endpoint):string
    {

        $endpointPrefix = $this->options['type'] . '/' . $this->options['version'];

        $endpoint = Helper::removeSlashes($endpoint);
        $endpoint = str_replace($endpointPrefix,'',$endpoint);

        $url = Helper::removeSlashes($this->domain) . '/';

        if(!empty($this->options['type'])){
            $url .= Helper::removeSlashes($this->options['type']) . '/';
        }

        if(!empty($this->options['version'])){
            $url .= Helper::removeSlashes($this->options['version']) . '/';
        }

        $url .= Helper::removeSlashes($endpoint);

        return $url;

    }

}