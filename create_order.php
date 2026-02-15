<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
// ================= CONFIG =================
$API_KEY    = "1c8838e3-0d84-44ae-be64-7d40be508d49";
$API_SECRET = "ebb68e2b753c4887bee6c367438ccd89486a7d85c4921cfaac471ff2d9f02404";
$API_URL    = "https://api.zwitch.io/v1/orders"; // sandbox/live

// ================= VALIDATION =================
if (!isset($_POST['amount'])) {
    die("Invalid Request");
}

$amount = (int) $_POST['amount'];

$allowed = [49, 99];
if (!in_array($amount, $allowed)) {
    die("Invalid Amount");
}

// ================= ORDER =================
$order_id = "ORD_" . time() . rand(100,999);
$amount_paise = $amount * 100;

$data = [
    "merchant_key" => $API_KEY,
    "order_id"     => $order_id,
    "amount"       => $amount_paise,
    "currency"     => "INR",
    "redirect_url" => "https://sweetmeets.in/payment-success.php",
    "callback_url" => "https://sweetmeets.in/payment-callback.php"
];

// ================= CURL =================
$ch = curl_init($API_URL);
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST           => true,
    CURLOPT_HTTPHEADER     => [
        "Content-Type: application/json",
        "Authorization: Bearer $API_SECRET"
    ],
    CURLOPT_POSTFIELDS => json_encode($data)
]);

$response = curl_exec($ch);
curl_close($ch);

$result = json_decode($response, true);

if (isset($result['payment_url'])) {
    header("Location: " . $result['payment_url']);
    exit;
} else {
    echo "Payment initiation failed";
}
