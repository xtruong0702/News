<?php
$apiKey = 'AIzaSyDhyIVvh0bPNGVq5PP9T7uBHzqtiOuCI3M';
$url = "https://generativelanguage.googleapis.com/v1beta/models?key=" . $apiKey;
$res = file_get_contents($url);
$data = json_decode($res, true);
foreach($data['models'] as $m) {
    if (strpos($m['name'], 'gemini') !== false) {
        echo $m['name'] . "\n";
    }
}
