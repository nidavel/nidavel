<?php

function fetch(string $url, string $method = 'GET', $payload = [], array $options = [])
{
    $ch = curl_init($url);

    if (!empty($payload)) {
        $payload = json_encode($payload);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    }

    if (!empty($options)) {
        curl_setopt_array($ch, $options);
    }
    
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json'
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $result = curl_exec($ch);
    curl_close($ch);

    return $result;
}
