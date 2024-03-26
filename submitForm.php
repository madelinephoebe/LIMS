<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

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

try {
    // Get form data
    // Get the current date for Borrow_Date
    date_default_timezone_set('Asia/Manila');
    $currentDate = date('Y-m-d H:i:s');
    $studentName = isset($_POST['studentName']) ? $_POST['studentName'] : '';
    $studentID = isset($_POST['studentID']) ? $_POST['studentID'] : '';
    $room = isset($_POST['room']) ? $_POST['room'] : '';
    $borrowedCategory = isset($_POST['borrowedCategory']) ? $_POST['borrowedCategory'] : '';
    $borrowedItemName = isset($_POST['borrowedItemName']) ? $_POST['borrowedItemName'] : '';

    // Updated: Retrieve the borrowed quantity
    $borrowedQuantity = isset($_POST['borrowedQuantity']) ? $_POST['borrowedQuantity'] : '';

    // Updated: Check if the borrowed quantity is greater than 0
    if ($borrowedQuantity <= 0) {
        echo json_encode(array("status" => "error", "message" => "Quantity must be greater than 0."));
        exit; // Stop further execution
    }

    // Updated: Check if the checkbox is checked
    $borrowedItemStatus = isset($_POST['returnCheckbox']) && $_POST['returnCheckbox'] === 'on' ? 'Returned' : 'Not Returned';

    // Updated: Set the Return_Date based on the checkbox
    $returnDate = $borrowedItemStatus === 'Returned' ? $currentDate : null;

    // Updated: Check if the borrowed quantity is greater than the available quantity
    $checkAvailabilitySql = "SELECT [Quantity] FROM [WEBAPP].[dbo].[ITEMS] WHERE [Category] = ? AND [Item_Name] = ?";
    $checkAvailabilityParams = array($borrowedCategory, $borrowedItemName);
    $checkAvailabilityResult = sqlsrv_query($conn, $checkAvailabilitySql, $checkAvailabilityParams);

    if ($checkAvailabilityResult === false) {
        echo json_encode(array("status" => "error", "message" => "Failed to check item availability."));
        exit; // Stop further execution
    }

    $availableQuantity = sqlsrv_fetch_array($checkAvailabilityResult, SQLSRV_FETCH_ASSOC)['Quantity'];

    if ($borrowedQuantity > $availableQuantity) {
        echo json_encode(array("status" => "error", "message" => "Requested quantity exceeds availability."));
        exit; // Stop further execution
    }

    // Insert data into BORROWED table
    $sql = "INSERT INTO [WEBAPP].[dbo].[BORROWED] (Student_Name, Student_Number, Room, Borrowed_Category, Borrowed_Item_Name, Quantity_Borrowed, Borrow_Date, Borrowed_Item_Status, Return_Date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $params = array($studentName, $studentID, $room, $borrowedCategory, $borrowedItemName, $borrowedQuantity, $currentDate, $borrowedItemStatus, $returnDate);
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        // ... your existing error handling ...
    } else {
        // Deduct the borrowed quantity from the original quantity in ITEMS table
        $updateItemSql = "UPDATE [WEBAPP].[dbo].[ITEMS] SET [Quantity] = [Quantity] - ? WHERE [Category] = ? AND [Item_Name] = ?";
        $updateItemParams = array($borrowedQuantity, $borrowedCategory, $borrowedItemName);
        $updateItemStmt = sqlsrv_query($conn, $updateItemSql, $updateItemParams);

        if ($updateItemStmt === false) {
            // Handle the error, e.g., log or return an error response
            echo json_encode(array("status" => "error", "message" => "Failed to update item quantity."));
        } else {
            // Check if the item is returned
            if ($borrowedItemStatus === 'Returned') {
                // Increase the quantity in ITEMS table
                $updateReturnedItemSql = "UPDATE [WEBAPP].[dbo].[ITEMS] SET [Quantity] = [Quantity] + ? WHERE [Category] = ? AND [Item_Name] = ?";
                $updateReturnedItemParams = array($borrowedQuantity, $borrowedCategory, $borrowedItemName);
                $updateReturnedItemStmt = sqlsrv_query($conn, $updateReturnedItemSql, $updateReturnedItemParams);

                if ($updateReturnedItemStmt === false) {
                    // Handle the error, e.g., log or return an error response
                    echo json_encode(array("status" => "error", "message" => "Failed to update returned item quantity."));
                }
            }

            // Close the connection
            sqlsrv_close($conn);

            // Return a success message as JSON
            echo json_encode(array("status" => "success", "message" => "Data inserted successfully"));
        }
    }
} catch (Exception $e) {
    // ... your existing exception handling ...

    // Return an error message as JSON
    echo json_encode(array("status" => "error", "message" => "An unexpected error occurred"));
}

// Set the proper Content-Type header
header('Content-Type: application/json');
?>
