# Stays API - PHP Client (Unofficial)

PHP client for server-side integration with Stays API v1 (unofficial library)

![GitHub release (latest by date)](https://img.shields.io/github/v/release/robsonsanches/stays-php-client?display_name=tag)
![GitHub](https://img.shields.io/github/license/robsonsanches/stays-php-client)


#### Table of contents:
* [Requirements](#requirements)
* [Installation](#installation)
* [Getting started](#getting-started)
* [Setup](#setup)
* [Making Requests](#making-requests)
* [Using Responses](#using-responses)
* [Docs](#docs)
* [License](#license)
* [Release History](#release-history)

## Requirements

* PHP >= 7.3
* Composer 

## Installation

```
composer require robsonsanches/stays-php-client
```

## Getting started

To obtain API credentials please read the Stays API Docs <https://stays.net/external-api/#introduction>.

## Setup

Setup for the Stays API integration:

```php
require '/vendor/autoload.php';

use RobsonSanches\Stays\Client\Client;

$stays = new Client($domain, $clientId, $clientSecret, $options);
```
### Client Parameters

| Parameter              | Type     | Required | Description                                         |
|------------------------|----------|----------|-----------------------------------------------------|
| `$domain`              | `string` | yes      | System's domain, example: https://play.stays.net/   |
| `$clientId`            | `string` | yes      | API Client ID                                       |
| `$clientSecret`        | `string` | yes      | API Client Secret                                   |
| `$options`             | `array`  | no       | Additional options (see additional   options table) |

#### Additional options

| Option                | Type     | Required | Description                                                         |
|-----------------------|----------|----------| --------------------------------------------------------------------|
| `type`                | `string` | no       | API type, default is `external`                                     |
| `version`             | `string` | no       | API version, default is `v1`                                        |
| `timeout`             | `number` | no       | Request timeout, default is `2.0`                                   |
| `response_format`     | `string` | no       | Response format (`array`, `object` or `string`), default is `array` |
| `http_errors`         | `bool`   | no       | Set to `false` to disable throwing exceptions, default is `true`    |
| `http_client_options` | `array`  | no       | Guzzle HTTP client options                                          |

## Making Requests
You may use the get, post, patch, and delete methods to make requests to Stays API.

### Request Methods

```php
$stays->get($endpoint, $query = [], $headers = [])
$stays->post($endpoint, $data = [], $headers = [])
$stays->patch($endpoint, $data = [], $headers = [])
$stays->delete($endpoint, $query = [], $headers = [])
```

#### Arguments

| Parameter     | Type     | Description                                                  |
|---------------|----------|--------------------------------------------------------------|
| `$endpoint`   | `string` | Stays API endpoint, example: `content/groups`                |
| `$data`       | `array`  | Only for POST and PATCH, data that will be converted to JSON |
| `$query`      | `array`  | Only for GET and DELETE, request query string                |
| `$headers`    | `array`  | Additional http headers                                      |

## Using Responses

All the request methods will return a response that can be a _multidimensional array_, _array of objects_ or _JSON string_ on success. If is present the argument `http_errors = true`, will throwing `ClientException` error on failure.

```php
use RobsonSanches\Stays\Client\ClientException;

try {
    $results = $stays->get('content/groups');
    print_r( $results, true ); // array or JSON string

} catch (ClientException $e) {
    echo $e->getMessage(); // Exception message.
}
```

To get the response data from Http Client:

```php
$response = $stays->http()->getResponse();

echo $response->getReasonPhrase(); // Reason phrase (string).
echo $response->getStatusCode(); // Response code (int).
echo $response->getBody()->getContents(); // Response body (JSON).

print_r( $response->getHeaders() ); // Response headers (array).
print_r( $response->getBody() ); // PSR-7 StreamInterface (object).
```

If you need to get the last requested data:

```php
$request = $stays->http()->getRequest();

echo $request->getUri(); // Requested URI (string).
echo $request->getMethod(); // Request method (string).
echo $request->getBody()->getContents(); // Request body content (JSON).

print_r( $request->getHeaders() ); // Request headers (array).
print_r( $request->getUri() ); // PSR-7 UriInterface (object).
print_r( $request->getBody() ); // PSR-7 StreamInterface (object).
```

## Docs
[Stays Documentation](https://stays.net/external-api/#introduction)

## Licence

[The MIT License](https://github.com/robsonsanches/stays-php-client/blob/master/LICENSE)

## Release History

- 2022-02-20 - 1.0.0 - Initial release.
