<?php
$API_SECRET = "ebb68e2b753c4887bee6c367438ccd89486a7d85c4921cfaac471ff2d9f02404";

$order_id = $_POST['order_id'] ?? '';

if (!$order_id) {
    http_response_code(400);
    exit;
}

// Verify payment
$ch = curl_init("https://api.zwitch.io/v1/orders/$order_id");
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => [
        "Authorization: Bearer $API_SECRET"
    ]
]);

$response = curl_exec($ch);
curl_close($ch);

$data = json_decode($response, true);

if ($data['status'] === "paid") {
    // ✅ Payment confirmed
    // Save in DB
} else {
    // ❌ Failed / Pending
}
