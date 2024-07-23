<?php
require_once 'vendor/autoload.php';
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;

// Get filter criteria from POST request
$categoryFilter = $_POST['category'];
$statusFilter = $_POST['status'];
$dateFilter = $_POST['date'];

// Create a new PHPWord object
$phpWord = new PhpWord();

// Add a section
$section = $phpWord->addSection();

// Add a title
$section->addText("Filtered Word Report", array('bold' => true, 'size' => 16), array('alignment' => 'center'));

// Add a table
$table = $section->addTable();
$table->addRow();
$table->addCell(2000)->addText('Category');
$table->addCell(2000)->addText('Item Number');
$table->addCell(2000)->addText('Item Name');
$table->addCell(2000)->addText('Quantity');
$table->addCell(2000)->addText('Date Received');

// Connect to the database
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

// Build the query based on the filter criteria
$query = "SELECT [Category], [Item_Number], [Item_Name], [Quantity], [Date_Received] FROM [WEBAPP].[dbo].[ITEMS] WHERE 1=1";

if (!empty($categoryFilter)) {
    $query .= " AND [Category] = ?";
    $params[] = $categoryFilter;
}

if (!empty($statusFilter)) {
    if ($statusFilter == "Sufficient Stocks") {
        $query .= " AND [Quantity] > 5";
    } elseif ($statusFilter == "Low Stocks") {
        $query .= " AND [Quantity] <= 5";
    }
}

if (!empty($dateFilter)) {
    if ($dateFilter == "ascending") {
        $query .= " ORDER BY [Date_Received] ASC";
    } elseif ($dateFilter == "descending") {
        $query .= " ORDER BY [Date_Received] DESC";
    }
} else {
    $query .= " ORDER BY [Date_Received] ASC"; // Default ordering
}

$params = isset($params) ? $params : [];

// Execute the query
$result = sqlsrv_query($conn, $query, $params);

if ($result === false) {
    die(print_r(sqlsrv_errors(), true));
}

// Populate the table with the filtered data
while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
    $table->addRow();
    $table->addCell()->addText($row['Category']);
    $table->addCell()->addText($row['Item_Number']);
    $table->addCell()->addText($row['Item_Name']);
    $table->addCell()->addText($row['Quantity']);
    if ($row['Date_Received']) {
        $table->addCell()->addText($row['Date_Received']->format('Y-m-d'));
    } else {
        $table->addCell()->addText('');
    }
}

// Close the database connection
sqlsrv_close($conn);

// Save the document
$filename = "Filtered_Word_Report.docx";
$objWriter = IOFactory::createWriter($phpWord, 'Word2007');
$objWriter->save($filename);

// Download the file
header("Content-Disposition: attachment; filename=$filename");
readfile($filename);
unlink($filename); // Delete the file after download
?>
