<?php

require "vendor/autoload.php";

use RobsonSanches\Stays\Client\Client;
use RobsonSanches\Stays\Client\ClientException;

$stays = new Client('https://play.stays.net/', 'xxxxxx', 'xxxxxx');

$content = [
    'internalName' => 'test group 1-1',
    '_mstitle' => [
        'en_US' => 'Test Group 1-1',
        'pt_BR' => 'Grupo de teste 1-1',
    ],
    'types' => [
        0 => 'system',
        1 => 'highlight',
    ],
    'listingIds' => [
        0 => '515328ab80beb0e416000008',
    ],
];

echo '<pre>';

try {
    
    $response = $stays->patch('/content/groups/{groupId}',$content);
    print_r($response);

} catch(ClientException $e){
    echo 'Error: ' . $e->getMessage();
}
