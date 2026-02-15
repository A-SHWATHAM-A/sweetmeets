<?php
header('Content-Type: application/json');


$input = json_decode(file_get_contents("php://input"), true);

$orderId        = $input['orderId']        ?? ("ORD" . time());
$amount         = $input['amount']         ?? "99";
$customerName   = $input['customerName']   ?? "";
$customerMobile = $input['customerMobile'] ?? "";


if (!is_numeric($amount) || $amount <= 0) {
    echo json_encode([
        "status" => "error",
        "message" => "Invalid amount"
    ]);
    exit;
}

if (strlen($orderId) < 5) {
    echo json_encode([
        "status" => "error",
        "message" => "Invalid orderId"
    ]);
    exit;
}


$username = "INDI180";                        
$password = "MjAyNTA1MTQxNjQzMjE=";           
$xApiKey  = "kcS1L9mbbw7DQOSm_a1aV-SHIitL7pxu5j3wRnlCJes";

$auth = base64_encode($username . ":" . $password);


$payload = [
    "orderId" => $orderId,
    "sellerIdentifier" => "SINDI25AACB41A0",
    "amount" => (string)$amount,
    "expiryInMinutes" => "10"
];

$ch = curl_init("https://api1.indiplex.co.in/api/v1/seller/regupiintent");

curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => json_encode($payload),
    CURLOPT_HTTPHEADER => [
        "Authorization: Basic $auth",
        "x-api-key: $xApiKey",
        "Content-Type: application/json"
    ],
    CURLOPT_TIMEOUT => 30
]);

$response = curl_exec($ch);

if ($response === false) {
    echo json_encode([
        "status" => "error",
        "message" => curl_error($ch)
    ]);
    curl_close($ch);
    exit;
}

curl_close($ch);

$res = json_decode($response, true);

if (
    !isset($res['data']) ||
    $res['data']['status'] !== "SUCCESS"
) {
    echo json_encode([
        "status" => "error",
        "message" => "Indiplex API failed",
        "api_response" => $res
    ]);
    exit;
}


echo json_encode([
    "status" => "success",
    "data" => [
        "orderId" => $res['data']['orderId'],
        "amount" => $res['data']['amount'],
        "sellerInfo" => [
            "vpa" => $res['data']['sellerInfo']['vpa'],
            "mcc" => $res['data']['sellerInfo']['mcc'],
            "payeeName" => $res['data']['sellerInfo']['payeeName']
        ]
    ]
]);
