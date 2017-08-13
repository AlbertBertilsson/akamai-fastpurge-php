<?php

require_once 'src/Authentication.php';
require_once 'src/Authentication/Timestamp.php';
require_once 'src/Authentication/Nonce.php';
require_once 'src/Authentication/Exception.php';
require_once 'src/Authentication/Exception/ConfigException.php';
require_once 'src/Authentication/Exception/SignerException.php';

function fastPurge($hostname, array $objects)
{
    $body = json_encode(array(
        'hostname' => $hostname,
        'objects' => $objects
    ));

    $auth = \Akamai\Open\EdgeGrid\Authentication::createFromEdgeRcFile('default', './.edgerc');
    $auth->setHttpMethod('POST');
    $auth->setPath('/ccu/v3/invalidate/url');
    $auth->setBody($body);

    $context = array(
        'http' => array(
            'header' => array(
                'Authorization: ' . $auth->createAuthHeader(),
                'Content-Type: application/json',
                'Content-Length: ' . strlen($body),
            ),
            'method' => 'POST',
            'content' => $body
        )
    );

    $context = stream_context_create($context);

    $response = file_get_contents('https://' . $auth->getHost() . $auth->getPath(), null, $context);
    if ($response === false) return;

    $json = json_decode($response, true);
    echo "Result:\n" . json_encode($json, JSON_PRETTY_PRINT) . "\n";
}

if ($argc < 3) {
    echo "Usage: php $argv[0] <string domain> <path> [<paths> ...]\n";
    echo "Example: php $argv[0] www.google.com /services/ /preferences\n";
    echo "Ensure you have properly configured the .edgerc file.\n";
    return;
}

//Call the fastPurge function with the domain and paths as given on command line.
fastPurge($argv[1], array_slice($argv, 2));
