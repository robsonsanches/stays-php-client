<?php

require "vendor/autoload.php";

use RobsonSanches\Stays\Client\Client;
use RobsonSanches\Stays\Client\ClientException;

$stays = new Client('https://play.stays.net/', 'xxxxxx', 'xxxxxx');

$content = [
    "status" => "active", 
    "internalName" => "test group 1",
    "types" => [
        "system"
    ], 
    "_mstitle" => [
        "en_US" => "Test Group 1"
    ]
];

echo '<pre>';

try {

    $response = $stays->post('/content/groups/',$content);
    print_r($response);

} catch(ClientException $e){
    echo 'Error: ' . $e->getMessage();
}
