<?php
$order_id = $_GET['order_id'] ?? '';
echo "<h2>Payment Successful</h2>";
echo "Order ID: " . htmlspecialchars($order_id);
