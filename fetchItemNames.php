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

    $category = isset($_GET['category']) ? $_GET['category'] : '';
    
    if (empty($category)) {
        // No category provided, return an empty array
        echo json_encode([]);
        exit;
    }
    
    // Perform a database query to get item names based on the selected category
    $serverName = "MADELINEPHOEBE\SQLEXPRESS01";
    $connectionOptions = [
        "Database" => "WEBAPP",
        "Uid" => "",
        "PWD" => ""
    ];
    $conn = sqlsrv_connect($serverName, $connectionOptions);
    
    if ($conn === false) {
        // Handle database connection error
        echo json_encode(['error' => 'Failed to connect to the database']);
        exit;
    }
    
    try {
        // Query to fetch item names based on the selected category
        $sql = "SELECT [Item_Name] FROM [WEBAPP].[dbo].[ITEMS] WHERE [Category] = ?";
        $params = array($category);
        $stmt = sqlsrv_query($conn, $sql, $params);
    
        if ($stmt === false) {
            // Handle query execution error
            echo json_encode(['error' => 'Failed to fetch item names']);
            exit;
        }
    
        $itemNames = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $itemNames[] = $row['Item_Name'];
        }
    
        // Return item names as JSON
        echo json_encode($itemNames);
    } catch (Exception $e) {
        // Handle other exceptions
        echo json_encode(['error' => 'An unexpected error occurred']);
    } finally {
        // Close the database connection
        if ($conn) {
            sqlsrv_close($conn);
        }
    }
    ?>
    