<?php
// Database connection settings
$serverName = "MADELINEPHOEBE\SQLEXPRESS01";
$connectionOptions = [
    "Database" => "WEBAPP",
    "Uid" => "",
    "PWD" => ""
];
$conn = sqlsrv_connect($serverName, $connectionOptions);

// Check connection
if ($conn === false) {
    die(print_r(sqlsrv_errors(), true));
}

// Get form data
$category = $_POST['category'];
$itemName = $_POST['itemName'];
$quantity = $_POST['quantity'];
$dateReceived = $_POST['dateReceived']; // Get date received from form data

// Prepare and execute the SQL insert query
$sql = "INSERT INTO [WEBAPP].[dbo].[ITEMS] (Category, Item_Name, Quantity, Date_Received) VALUES (?, ?, ?, ?)";
$params = [$category, $itemName, $quantity, $dateReceived]; // Include date received as a parameter

// Execute the query
$query = sqlsrv_query($conn, $sql, $params);

// Check the query result
if ($query === false) {
    die(print_r(sqlsrv_errors(), true));
} else {
    echo "success";
}

// Close the connection
sqlsrv_close($conn);
?>
