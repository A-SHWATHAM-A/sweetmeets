<?php

// ===============================
// INDIPLEX CREDENTIALS
// ===============================
$api_username = "INDI180";
$api_password = "MJAyNTA1MTQxNjQzMjE="; // as provided
$access_token = "kcS1L9mbbw7DQOSm_a1aV-SHIitL7pxu5j3wRnlCJes";

// ===============================
// BASIC AUTH
// ===============================
$basicAuth = base64_encode($api_username . ":" . $api_password);

// ===============================
// IP VERIFICATION URL (FROM DOCS)
// ===============================
$url = "https://api1.indiplex.co.in/verification/ip";

// ===============================
// cURL CALL
// ===============================
$ch = curl_init($url);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true); // POST required
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: Basic $basicAuth",
    "x-api-key: $access_token",
    "Content-Type: application/json"
]);

// No payload required
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([]));

$response = curl_exec($ch);

if (curl_errno($ch)) {
    echo "cURL Error: " . curl_error($ch);
    exit;
}

curl_close($ch);

echo "<pre>";
echo $response;
