<?php
file_put_contents(
    __DIR__ . "/step1_raw.log",
    date('Y-m-d H:i:s') . "\nRAW: " . file_get_contents("php://input") . 
    "\nPOST: " . json_encode($_POST) . "\n\n",
    FILE_APPEND
);


/*
|--------------------------------------------------------------------------
| CONFIG
|--------------------------------------------------------------------------
*/
define('INDIPLEX_X_API_KEY', 'kcS1L9mbbw7DQOSm_a1aV-SHIitL7pxu5j3wRnlCJes');

/*
|--------------------------------------------------------------------------
| READ INPUT (JSON + FORM SUPPORT)
|--------------------------------------------------------------------------
*/
$rawInput = file_get_contents("php://input");
$data = json_decode($rawInput, true);

// fallback for form-urlencoded (REAL INDIPLEX CALLBACK)
if (!$data || !is_array($data)) {
    $data = $_POST;
}

// LOG EVERYTHING (CRITICAL FOR DEBUG)
file_put_contents(
    __DIR__ . "/indiplex_callback.log",
    date('Y-m-d H:i:s') . "\nRAW: " . $rawInput . "\nDATA: " . json_encode($data) . "\n\n",
    FILE_APPEND
);

// if still no data, respond OK (stop retries)
if (!$data || !is_array($data)) {
    echo "OK";
    exit;
}

/*
|--------------------------------------------------------------------------
| 1️⃣ JWT + OTP HANDSHAKE (INDIPLEX VERIFICATION)
|--------------------------------------------------------------------------
*/
if (isset($data['token'])) {

    $jwt = $data['token'];
    $parts = explode('.', $jwt);

    if (count($parts) !== 3) {
        echo "OK";
        exit;
    }

    list($header64, $payload64, $signature64) = $parts;

    // verify signature
    $expectedSignature = rtrim(strtr(
        base64_encode(
            hash_hmac(
                'sha256',
                "$header64.$payload64",
                INDIPLEX_X_API_KEY,
                true
            )
        ),
        '+/', '-_'
    ), '=');

    if ($signature64 !== $expectedSignature) {
        echo "OK";
        exit;
    }

    // decode payload
    $payload = json_decode(base64_decode(strtr($payload64, '-_', '+/')), true);

    if (!isset($payload['OTP'])) {
        echo "OK";
        exit;
    }

    // respond OTP back
    echo json_encode([
        "status"  => true,
        "message" => "success",
        "OTP"     => $payload['OTP']
    ]);
    exit;
}

/*
|--------------------------------------------------------------------------
| 2️⃣ REAL PAYMENT CALLBACK
|--------------------------------------------------------------------------
*/

// adapt keys if IndiPlex sends different names
$datatnx = $data['transaction_data'];
$orderId = $datatnx['merchantRequestId']   ?? $data['order_id'] ?? null;
$status  = $datatnx['gatewayResponseStatus'] ?? $data['status']   ?? null;
$amount  = $datatnx['amount']    ?? null;

// basic validation
if (!$orderId || !$status) {
    echo "OK";
    exit;
}

// OPTIONAL: strict amount check
if ($status === "SUCCESS") {
    markEnquiryPaid($orderId);
}

/*
|--------------------------------------------------------------------------
| ALWAYS RESPOND OK (STOP INDIPLEX RETRIES)
|--------------------------------------------------------------------------
*/
echo "OK";
exit;

/*
|--------------------------------------------------------------------------
| MARK ORDER PAID
|--------------------------------------------------------------------------
*/
function markEnquiryPaid($enquiryId)
{
    $url = "https://api.jmdherbs.in/api/v1/common/enquiry/isPaid/" . intval($enquiryId);

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Content-Type: application/json"
    ]);

    $response = curl_exec($ch);
    curl_close($ch);

    return $response;
}
