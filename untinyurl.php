<?php

function untinyurl($tinyurl) 
{
    $url = parse_url($tinyurl);
    $host = $url['host'];
    $port = isset($url['port']) ? $url['port'] : 80;
    $query = isset($url['query']) ? '?' . $url['query'] : '';
    $fragment = isset($url['fragment']) ? '#' . $url['fragment'] : '';

    $sock = @fsockopen($host, $port);
    if (!$sock) return $tinyurl;
    
    $url = $url['path'] . $query . $fragment;
    $request = "HEAD {$url} HTTP/1.0\r\nHost: {$host}\r\nConnection: Close\r\n\r\n";

    fwrite($sock, $request);
    $response = '';
    while (!feof($sock)) {
        $response .= fgets($sock, 128);
    }
    $lines = explode("\r\n", $response);
    foreach ($lines as $line) {
        if (strpos(strtolower($line), 'location:') === 0) {
            list(, $location) = explode(':', $line, 2);
            return ltrim($location);
        }
    }
    return $tinyurl;
}