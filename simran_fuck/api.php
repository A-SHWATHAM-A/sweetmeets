<?php



// Headers for API response
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *"); 
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Database credentials
$host = "localhost";
$username = "uwckpsnwde";
$password = "Pyq9b574Ze";
$database = "uwckpsnwde";// change to your DB name

$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "Database connection failed"]));
}

// Get request method
$method = $_SERVER['REQUEST_METHOD'];

// Handle API routes

    
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            // $sql = "INSERT INTO transactions (order_id, amount, status, gateway_txn, created_at) VALUES (?, ?, ?, ?, '$time')";
            $result = $conn->query("SELECT * FROM transactions WHERE order_id = $id");
        } 
        if ($result->num_rows > 0) {

                $data = [];
                while ($row = $result->fetch_assoc()) {
                    $data[] = $row;
                }
                echo json_encode(["success" => true, "data" => $data]);
                
        }else{

            echo json_encode(["success" => false, "message" => "Invalid request method"]);
        }

       
   


$conn->close();
?>