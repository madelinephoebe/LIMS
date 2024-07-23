<?php
$serverName = "MADELINEPHOEBE\SQLEXPRESS01";
$connectionOptions = [
    "Database" => "WEBAPP",
    "Uid" => "",
    "PWD" => ""
];
$conn = sqlsrv_connect($serverName, $connectionOptions);

if ($conn === false) {
    die(print_r(sqlsrv_errors(), true));
}

// Data from the form
$itemNumber = $_POST['itemNumber'];
$category = $_POST['category'];
$itemName = $_POST['itemName'];
$quantity = $_POST['quantity'];
$dateReceived = $_POST['dateReceived'];

// Update query
$sql = "UPDATE [WEBAPP].[dbo].[ITEMS] SET Category = ?, Item_Name = ?, Quantity = ?, Date_Received = ? WHERE Item_Number = ?";
$params = array($category, $itemName, $quantity, $dateReceived, $itemNumber);

$query = sqlsrv_query($conn, $sql, $params);

if ($query === false) {
    die("Error updating record: " . print_r(sqlsrv_errors(), true));
} else {
    echo "Record updated successfully.";
}

sqlsrv_close($conn);
?>
