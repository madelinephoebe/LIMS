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


$result = sqlsrv_query($conn, $sql);

if ($result === false) {
    die(print_r(sqlsrv_errors(), true));
}

// Assuming you have a primary key named 'Item_Number'
$itemNumber = $_POST['itemNumber'];

// Sanitize and validate $itemNumber to prevent SQL injection
// ...

$sql = "DELETE FROM [WEBAPP].[dbo].[ITEMS] WHERE [Item_Number] = ?";
$params = array($itemNumber);

$result = sqlsrv_query($conn, $sql, $params);

if ($result === false) {
    die(print_r(sqlsrv_errors(), true));
}

sqlsrv_close($conn);
echo 'success';
?>
