<?php
// Database credentials
$host = "localhost";
$user = "u128793493_shubham21";
$pass = "Shubhamganwani@2003    ";
$db   = "u128793493_flirt";


// Create connection
$conn = mysqli_connect($host, $username, $password, $database);

// Check connection
if (!$conn) {
    die(json_encode(["success" => false, "message" => "Database connection failed: " . mysqli_connect_error()]));
}

// Get parameters from GET or POST
$amount      = isset($_REQUEST['amt']) ? $_REQUEST['amt'] : null;
$order_id    = isset($_REQUEST['order_id']) ? $_REQUEST['order_id'] : null;
$status      = isset($_REQUEST['status']) ? $_REQUEST['status'] : null;
$gateway_txn = isset($_REQUEST['gateway_txn']) ? $_REQUEST['gateway_txn'] : null;
const names = ["Amit", "Rahul", "Neha", "Priya", "Vikas", "Simran"];
// get phone from form input (assuming method="post")
$phone = isset($_POST['phone']) ? $_POST['phone'] : '';
// Validate required fields
// if (!$amount || !$order_id || !$status || !$gateway_txn) {
//     http_response_code(400);
//     echo json_encode(["success" => false, "message" => "Missing required parameters"]);
//     exit;
// }

// Prepare SQL to prevent SQL injection
$sql = "INSERT INTO transactions (order_id, amount, status, gateway_txn, created_at) VALUES (?, ?, ?, ?, NOW())";

$stmt = mysqli_prepare($conn, $sql);
if ($stmt) {
    mysqli_stmt_bind_param($stmt, "sdss", $order_id, $amount, $status, $gateway_txn);

    if (mysqli_stmt_execute($stmt)) {
        echo json_encode([
            "success" => true,
            "message" => "Transaction saved successfully",
            "data" => [
                "order_id" => $order_id,
                "amount" => $amount,
                "status" => $status,
                "gateway_txn" => $gateway_txn
            ]
        ]);
    } else {
        http_response_code(500);
        echo json_encode(["success" => false, "message" => "Insert failed: " . mysqli_error($conn)]);
    }

    mysqli_stmt_close($stmt);
} else {
    echo json_encode(["success" => false, "message" => "Prepare failed: " . mysqli_error($conn)]);
}

// Close connection
mysqli_close($conn);

$ivrApiUrl = "https://web.betyphon.com/api/public/inboundleads"
    . "?cid=6899c8107254df2ceeb30627"
    . "&phone=" . urlencode($mobile)
    . "&firstName=" . urlencode($name)
    . "&amount=" . urlencode($amount)
    . "&status=" . urlencode($status)
    . "&admin=" . urlencode("biomanix6@gmail.com")
    . "&source=" . urlencode("Website");


// Call IVR API with cURL
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $ivrApiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Disable only for testing


$response = curl_exec($ch);
if (curl_errno($ch)) {
    $error_msg = curl_error($ch);
    echo "IVR API Error: " . $error_msg;
}
curl_close($ch);

?>