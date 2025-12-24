<?php
// Simulate browser login with cookie jar
$base = 'http://localhost:8000';
$cookieFile = __DIR__ . '/storage/app/test_cookies.txt';
if (file_exists($cookieFile)) @unlink($cookieFile);

function http_get($url, $cookieFile){
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile);
    curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    $res = curl_exec($ch);
    $info = curl_getinfo($ch);
    curl_close($ch);
    return [$res, $info];
}

function http_post($url, $data, $cookieFile){
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile);
    curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    $res = curl_exec($ch);
    $info = curl_getinfo($ch);
    curl_close($ch);
    return [$res, $info];
}

// 1. GET login page to fetch CSRF token
list($loginHtml) = http_get($base . '/login', $cookieFile);
if (!preg_match('/name="_token" value="([^"]+)"/', $loginHtml, $m)){
    echo "CSRF token not found\n";
    exit(1);
}
$token = $m[1];
echo "CSRF token: $token\n";

// 2. POST login
$credentials = [
    '_token' => $token,
    'email' => 'budi@example.com',
    'password' => 'password123',
    'remember' => 'on'
];
list($postRes, $postInfo) = http_post($base . '/login', $credentials, $cookieFile);
echo "POST /login -> HTTP code: " . ($postInfo['http_code'] ?? '??') . "\n";

// 3. Visit /explore
list($exploreHtml, $info2) = http_get($base . '/explore', $cookieFile);
$status = $info2['http_code'] ?? '??';
echo "GET /explore -> HTTP code: $status\n";
if (strpos($exploreHtml, 'Logout') !== false || strpos($exploreHtml, 'logout') !== false) {
    echo "Found Logout in explore page (user likely logged in)\n";
} else {
    echo "Logout not found in explore page (user not logged in)\n";
}

// 4. Visit /about
list($aboutHtml, $info3) = http_get($base . '/about', $cookieFile);
$status3 = $info3['http_code'] ?? '??';
echo "GET /about -> HTTP code: $status3\n";
if (strpos($aboutHtml, 'Logout') !== false || strpos($aboutHtml, 'logout') !== false) {
    echo "Found Logout in about page (user still logged in)\n";
} else {
    echo "Logout not found in about page (user got logged out)\n";
}
