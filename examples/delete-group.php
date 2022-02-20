<?php

require "vendor/autoload.php";

use RobsonSanches\Stays\Client\Client;
use RobsonSanches\Stays\Client\ClientException;

$stays = new Client('https://play.stays.net/', 'xxxxxx', 'xxxxxx');

echo '<pre>';

try {

    $response = $stays->delete('/content/groups/{groupId}');
    print_r($response);

} catch(ClientException $e){
    echo 'Error: ' . $e->getMessage();
}
