<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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

    $borrowID = $_POST['borrowID'];
    $status = $_POST['status'];

    // Update Borrowed_Item_Status and Return_Date in the database
    $updateSql = "UPDATE [WEBAPP].[dbo].[BORROWED] SET [Borrowed_Item_Status] = ?, [Return_Date] = GETDATE() WHERE [Borrow_ID] = ?";
    $params = array($status, $borrowID);
    $updateResult = sqlsrv_query($conn, $updateSql, $params);

    if ($updateResult === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    // Check if the item is returned
    if ($status === 'Returned') {
        // Get borrowed item details
        $getItemSql = "SELECT [Borrowed_Category], [Borrowed_Item_Name], [Quantity_Borrowed] FROM [WEBAPP].[dbo].[BORROWED] WHERE [Borrow_ID] = ?";
        $getItemParams = array($borrowID);
        $getItemResult = sqlsrv_query($conn, $getItemSql, $getItemParams);

        if ($getItemResult === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        $itemDetails = sqlsrv_fetch_array($getItemResult, SQLSRV_FETCH_ASSOC);

        // Increase the quantity in ITEMS table
        $updateReturnedItemSql = "UPDATE [WEBAPP].[dbo].[ITEMS] SET [Quantity] = [Quantity] + ? WHERE [Category] = ? AND [Item_Name] = ?";
        $updateReturnedItemParams = array($itemDetails['Quantity_Borrowed'], $itemDetails['Borrowed_Category'], $itemDetails['Borrowed_Item_Name']);
        $updateReturnedItemStmt = sqlsrv_query($conn, $updateReturnedItemSql, $updateReturnedItemParams);

        if ($updateReturnedItemStmt === false) {
            // Handle the error, e.g., log or return an error response
            echo json_encode(array("status" => "error", "message" => "Failed to update returned item quantity."));
        }
    }

    sqlsrv_close($conn);

    // Send a response indicating success
    echo "Success";
} else {
    // Invalid request method
    http_response_code(405);
    echo "Method Not Allowed";
}
?>
