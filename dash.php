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

// Fetch the total number of distinct item names
$itemCountQuery = "SELECT COUNT(DISTINCT [Item_Name]) AS TotalItems FROM [WEBAPP].[dbo].[ITEMS]";
$itemCountResult = sqlsrv_query($conn, $itemCountQuery);

$totalItems = 0;
if ($itemCountResult !== false) {
    $row = sqlsrv_fetch_array($itemCountResult, SQLSRV_FETCH_ASSOC);
    $totalItems = $row['TotalItems'];
} else {
    die(print_r(sqlsrv_errors(), true));
}

// Fetch the total quantity of borrowed items that are not yet returned
$borrowedItemsQuery = "SELECT SUM([Quantity_Borrowed]) AS BorrowedItems FROM [WEBAPP].[dbo].[BORROWED] WHERE [Return_Date] IS NULL";
$borrowedItemsResult = sqlsrv_query($conn, $borrowedItemsQuery);

$borrowedItems = 0;
if ($borrowedItemsResult !== false) {
    $row = sqlsrv_fetch_array($borrowedItemsResult, SQLSRV_FETCH_ASSOC);
    $borrowedItems = $row['BorrowedItems'];
} else {
    die(print_r(sqlsrv_errors(), true));
}

// Fetch the total quantity of items low in stock
$lowStockItemsQuery = "SELECT COUNT(*) AS LowStockItems FROM [WEBAPP].[dbo].[ITEMS] WHERE [QUANTITY] <= 5";
$lowStockItemsResult = sqlsrv_query($conn, $lowStockItemsQuery);

$lowStockItems = 0;
if ($lowStockItemsResult !== false) {
    $row = sqlsrv_fetch_array($lowStockItemsResult, SQLSRV_FETCH_ASSOC);
    $lowStockItems = $row['LowStockItems'];
} else {
    die(print_r(sqlsrv_errors(), true));
}

sqlsrv_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Dashboard</title>

<!--CSS-->
<link rel="stylesheet" href="index.css"> 

<script src="https://kit.fontawesome.com/06f778c4e3.js" crossorigin="anonymous"></script>
<link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Oswald&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
</head>
<body>
<div class="container-fluid">
  <div class="row flex-nowrap">
    <div class="col-auto min-vh-100 bg-light" id="sidebar">
      <div class="d-flex flex-column flex-shrink-1 p-3">
        <a class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-decoration-none text-white text-center">
          <button class="btn text-dark d-flex">
            <i class="lni lni-menu"> </i>
          </button>
          <span class="fs-4 d-none d-sm-inline text-dark fw-bold" id="sidebar-span">CTH Laboratory</span>
        </a>
        <hr class="text-dark mb-4">
        <ul class="nav nav-pills flex-column mb-auto">

          <li class="nav-item">
            <a href="dash.php" class="nav-link active text-dark" aria-current="page">
              <i class="lni lni-grid-alt"></i>
              <span class="fs-5 ms-2 d-none d-sm-inline">Dashboard</span>  
            </a>
          </li>

          <li class="nav-item my-2">
            <a href="newproduct.php" class="nav-link text-dark">
              <i class="fs-5 lni lni-package"></i>
              <span class="fs-5 ms-2 d-none d-sm-inline">Products</span></a>
          </li>
      
        </li>
          <li class="nav-item my-2">
            <a href="reports.php" class="nav-link text-dark">
              <i class="fs-5 lni lni-folder"></i> 
              <span class="fs-5 ms-2 d-none d-sm-inline">Reports</span>
            </a>
          </li>

          <li class="nav-item my-2">
            <a href="adminProfile.html" class="nav-link text-dark">
              <i class="fs-5 lni lni-user"></i> 
              <span class="fs-5 ms-2 d-none d-sm-inline">Admin</span>
            </a>
          </li>
          
          <li class="nav-item my-3">
            <a href="index.php" class="nav-link text-dark">
              <i class="fs-5 lni lni-exit"></i> 
              <span class="fs-5 ms-2 d-none d-sm-inline">Logout</span>
            </a>
          </li>
        </ul>
      </div>
    </div>

    <div class="col">
      <h1 class="h-dashboard mt-3 mx-3">Dashboard</h1>
      <h4 class="overview mb-5 mx-3">Overview</h4>
      <div class="row">
        <div class="item-total col-sm-5  col-md-4 col-lg-3 py-2 my-1 mx-4 text-left" >
          <div class="row">
            <div class="col-4 d-flex justify-content-center align-items-center">
              <i class="fs-1 lni lni-cog text-white"></i>
            </div>
            <div class="col-8">
            <h1 class="text-white overview-number"><?php echo $totalItems; ?></h1>
              <h2 class="text-white overview-category">Total Items</h2>
            </div>
          </div>
        </div>

        <div class="item-borrowed col-sm-4 col-md-4 col-lg-3 py-2 my-1 mx-4 text-left" >
          <div class="row">
            <div class="col-4 d-flex justify-content-center align-items-center">
              <i class="fs-1 lni lni-customer text-white"></i>
            </div>
            <div class="col-8">
            <h1 class="text-white overview-number"><?php echo $borrowedItems; ?></h1>
              <h2 class="text-white overview-category">Total Borrowed Items</h2>
            </div>
          </div>
        </div>

        <div class="item-lowstock col-sm-5  col-md-4 col-lg-3 py-2 my-1 mx-4 text-left" >
          <div class="row">
            <div class="col-4 d-flex justify-content-center align-items-center">
              <i class="fs-1 lni lni-stats-down text-white"></i>
            </div>
            <div class="col-8">
            <h1 class="text-white overview-number"><?php echo $lowStockItems; ?></h1>
              <h2 class="text-white overview-category">Items Low in Stock</h2>
            </div>
          </div>
        </div>
        <div class="student-list mt-5">
    <table class="table table-hover table-light">
        <thead>
            <tr>
                <th scope="col">Student No.</th>
                <th scope="col">Name</th>
                <th scope="col">Item Borrowed</th>
                <th scope="col">Date & Time Borrowed</th>
            </tr>
        </thead>
        <tbody>
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

            // Fetch borrowed items for the current date
            $currentDate = date('Y-m-d'); // Get the current date in the format 'YYYY-MM-DD'
            $borrowedItemsQuery = "SELECT Student_Number, Student_Name, Borrowed_Item_Name, Borrow_Date
                                  FROM [WEBAPP].[dbo].[BORROWED]
                                  WHERE CONVERT(DATE, Borrow_Date) = ? AND [Return_Date] IS NULL";
            $borrowedItemsResult = sqlsrv_query($conn, $borrowedItemsQuery, array($currentDate));

            if ($borrowedItemsResult !== false) {
                // Display the borrowed items in the table
                while ($row = sqlsrv_fetch_array($borrowedItemsResult, SQLSRV_FETCH_ASSOC)) {
                    echo "<tr>";
                    echo "<th scope='row'>" . $row['Student_Number'] . "</th>";
                    echo "<td>" . $row['Student_Name'] . "</td>";
                    echo "<td>" . $row['Borrowed_Item_Name'] . "</td>";
                    echo "<td>" . $row['Borrow_Date']->format('Y-m-d H:i:s') . "</td>";
                    echo "</tr>";
                }
            } else {
                die(print_r(sqlsrv_errors(), true));
            }

            sqlsrv_close($conn);
            ?>
        </tbody>
    </table>
</div>


      </div>


    </div>

  </div>


</div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="index.js"></script>
</body>
</html>
