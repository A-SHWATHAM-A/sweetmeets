<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// DB connection
$servername = "localhost";
$username   = "uwckpsnwde";
$password   = "Pyq9b574Ze";
$dbname     = "uwckpsnwde";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Join query: user.transaction_id = transactions.order_id
$sql = "
    SELECT 
        u.id AS user_id,
        u.name,
        u.mobile,
        u.transaction_id AS user_transaction_id,
        t.id AS txn_table_id,
        t.order_id,
        t.amount,
        t.status,
        t.gateway_txn,
        t.created_at
    FROM user u
    INNER JOIN transactions t 
        ON u.transaction_id = t.order_id
    ORDER BY t.created_at DESC
";

$result = $conn->query($sql);

// Display results
if ($result && $result->num_rows > 0) {
    echo "<!DOCTYPE html><html><head><title>Transactions</title></head><body>";
    echo "<table border='1' cellpadding='5' cellspacing='0'>";
    echo "<tr>
            <th>User ID</th>
            <th>Name</th>
            <th>Mobile</th>
            <th>User Transaction ID</th>
            <th>Transaction Table ID</th>
            <th>Order ID</th>
            <th>Amount</th>
            <th>Status</th>
            <th>Gateway TXN</th>
            <th>Created At</th>
          </tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['user_id']}</td>
                <td>{$row['name']}</td>
                <td>{$row['mobile']}</td>
                <td>{$row['user_transaction_id']}</td>
                <td>{$row['txn_table_id']}</td>
                <td>{$row['order_id']}</td>
                <td>{$row['amount']}</td>
                <td>{$row['status']}</td>
                <td>{$row['gateway_txn']}</td>
                <td>{$row['created_at']}</td>
              </tr>";
    }
    echo "</table>";
    echo "</body></html>";
} else {
    echo "No records found.<br>";
    if (!$result) {
        echo "SQL Error: " . $conn->error;
    }
}

$conn->close();
?>
