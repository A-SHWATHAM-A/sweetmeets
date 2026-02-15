<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header("Content-Type: application/json");
header("Content-Type: application/json");

// Database connection
$host = "localhost";
$user = "u128793493_shubham21";
$pass = "Shubhamganwani@2003";
$db   = "u128793493_flirt";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    echo json_encode([
        "success" => false,
        "message" => "Database connection failed: " . $conn->connect_error
    ]);
    exit;
}

// Get input from JSON body OR fallback to GET/POST
$rawInput = file_get_contents("php://input");
$data = json_decode($rawInput, true);

// If JSON decoding fails or empty, fallback to GET/POST
if (!$data || !is_array($data)) {
    $data = $_POST;
    if (empty($data)) {
        $data = $_GET;
    }
}

// Validate fields
if (!isset($data['name'], $data['mobile'], $data['transaction_id'])) {
    echo json_encode([
        "success" => false,
        "message" => "Missing required fields"
    ]);
    exit;
}

$name = trim($data['name']);
$mobile = trim($data['mobile']);
$transactionId = trim($data['transaction_id']);

// Prepared statement
$stmt = $conn->prepare("INSERT INTO user (name, number, transaction_id) VALUES (?, ?, ?)");
if (!$stmt) {
    echo json_encode([
        "success" => false,
        "message" => "Prepare failed: " . $conn->error
    ]);
    exit;
}

$stmt->bind_param("sss", $name, $mobile, $transactionId);

if ($stmt->execute()) {
    echo json_encode([
        "success" => true,
        "message" => "User saved successfully",
        "id" => $stmt->insert_id
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "Insert failed: " . $stmt->error
    ]);
}

$stmt->close();
$conn->close();
?>
