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

$options = array(
    'borrowedCategories' => array(),
    'borrowedItemNames' => array()
);

// Fetch distinct categories
$categoryQuery = "SELECT DISTINCT [Category] FROM [WEBAPP].[dbo].[ITEMS]";
$categoryResult = sqlsrv_query($conn, $categoryQuery);

while ($category = sqlsrv_fetch_array($categoryResult, SQLSRV_FETCH_ASSOC)) {
    $options['borrowedCategories'][] = $category['Category'];
}

// Fetch distinct item names
$itemNameQuery = "SELECT DISTINCT [Item_Name] FROM [WEBAPP].[dbo].[ITEMS]";
$itemNameResult = sqlsrv_query($conn, $itemNameQuery);

while ($itemName = sqlsrv_fetch_array($itemNameResult, SQLSRV_FETCH_ASSOC)) {
    $options['borrowedItemNames'][] = $itemName['Item_Name'];
}

sqlsrv_close($conn);

header('Content-Type: application/json');
echo json_encode($options);
?>
