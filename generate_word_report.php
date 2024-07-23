<?php
// Include PHPWord library
require_once 'vendor/autoload.php';

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;

// Create new PHPWord object
$phpWord = new PhpWord();

// Add a section
$section = $phpWord->addSection();

// Add header
$header = $section->addHeader();
$header->addText('Borrowed Items Report', array('bold' => true), array('alignment' => 'center'));

// Add table
$table = $section->addTable();
$table->addRow();
$table->addCell(2000)->addText('Borrow ID');
$table->addCell(2000)->addText('Student Name');
$table->addCell(2000)->addText('Student Number');
$table->addCell(2000)->addText('Room');
$table->addCell(2000)->addText('Borrowed Category');
$table->addCell(2000)->addText('Item Name');
$table->addCell(2000)->addText('Quantity Borrowed');
$table->addCell(2000)->addText('Borrowed Item Status');
$table->addCell(2000)->addText('Borrow Date');
$table->addCell(2000)->addText('Return Date');

// Fetch data from database and populate the table
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

$sql = "SELECT [Borrow_ID], [Student_Name], [Student_Number], [Room], [Borrowed_Category], [Borrowed_Item_Name], [Quantity_Borrowed], [Borrowed_Item_Status], [Borrow_Date], [Return_Date] FROM [WEBAPP].[dbo].[BORROWED]";
$result = sqlsrv_query($conn, $sql);

if ($result === false) {
    die(print_r(sqlsrv_errors(), true));
}

while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
    $table->addRow();
    $table->addCell()->addText($row['Borrow_ID']);
    $table->addCell()->addText($row['Student_Name']);
    $table->addCell()->addText($row['Student_Number']);
    $table->addCell()->addText($row['Room']);
    $table->addCell()->addText($row['Borrowed_Category']);
    $table->addCell()->addText($row['Borrowed_Item_Name']);
    $table->addCell()->addText($row['Quantity_Borrowed']);
    $table->addCell()->addText($row['Borrowed_Item_Status']);
    $table->addCell()->addText($row['Borrow_Date']->format('Y-m-d H:i:s'));
    $table->addCell()->addText($row['Return_Date'] ? $row['Return_Date']->format('Y-m-d H:i:s') : 'Not Returned');
}

sqlsrv_close($conn);

// Save the document
$filename = 'Borrowed_Items_Report.docx';
$objWriter = IOFactory::createWriter($phpWord, 'Word2007');
$objWriter->save($filename);

// Download the file
header("Content-Disposition: attachment; filename=$filename");
readfile($filename);
unlink($filename); // Delete the file after download
?>
