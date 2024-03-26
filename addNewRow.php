<?php
$serverName = "MADELINEPHOEBE\SQLEXPRESS01";
$connectionOptions = [
    "Database" => "WEBAPP",
    "Uid" => "",
    "PWD" => ""
];
$conn = sqlsrv_connect($serverName, $connectionOptions);

if ($conn === false)
    die(print_r(sqlsrv_errors(), true));

$sql = "SELECT [Category], [Item_Number], [Item_Name], [Quantity] FROM [WEBAPP].[dbo].[ITEMS]";
$result = sqlsrv_query($conn, $sql);

if ($result === false) {
    die(print_r(sqlsrv_errors(), true));
}

// Data from the form
$category = $_POST['category'];
$itemName = $_POST['itemName'];
$quantity = $_POST['quantity'];

// Insert query
$sql = "INSERT INTO [WEBAPP].[dbo].[ITEMS] (Category, Item_Name, Quantity) VALUES (?, ?, ?)";
$params = array($category, $itemName, $quantity);

$query = sqlsrv_query($conn, $sql, $params);

if ($query === false) {
  echo "fail";
} else {
  echo "success";
}

sqlsrv_close($conn);
?>
