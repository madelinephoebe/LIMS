<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Dashboard</title>

<!--CSS-->
<link rel="stylesheet" href="loginindex.css"> 

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
            <a href="staffdash.php" class="nav-link text-dark">
              <i class="lni lni-grid-alt"></i>
              <span class="fs-5 ms-2 d-none d-sm-inline">Dashboard</span>  
            </a>
          </li>

          <li class="nav-item my-2">
            <a href="staffnewproduct.php" class="nav-link text-dark">
              <i class="fs-5 lni lni-package"></i>
              <span class="fs-5 ms-2 d-none d-sm-inline">Products</span></a>
          </li>

        
          <li class="nav-item my-2">
             <a href="staff_Form.php" class="nav-link text-dark">
              <i class="fs-5 lni lni-write"></i> 
            <span class="fs-5 ms-2 d-none d-sm-inline">Form</span>
          </a>
      
        </li>
          <li class="nav-item my-2">
            <a href="staffreports.php" class="nav-link active text-dark" aria-current="page">
              <i class="fs-5 lni lni-folder"></i> 
              <span class="fs-5 ms-2 d-none d-sm-inline">Reports</span>
            </a>
          </li>

          <li class="nav-item my-2">
            <a href="staffProfile.html" class="nav-link text-dark">
              <i class="fs-5 lni lni-user"></i> 
              <span class="fs-5 ms-2 d-none d-sm-inline">Staff</span>
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
      <h1 class="h-products
      my-3 mx-3">Borrowed Items Report</h1>

<div class="col-sm-6 col-md-6 col-lg-4 mt-5 mb-3 mx-3"> 
<div class="item_table" id="itemTableDisplay">
<form class="d-flex" role="search">
<input class="form-control me-2" type="search"  id="searchInput" style="width: 250px;" placeholder="Search" aria-label="Search" onkeyup="filterItems()">
<button class="btn btn-success d-flex searchbtn" type="submit"><i class="lni lni-magnifier search-icon"></i> Search</button>
</form><br><center>
  <table class="table text-center table-hover" style="width: 1100px;"></center>
      <thead>
        <tr>
          <th>Student Name</th>
          <th>Student Number</th>
          <th>Room</th>
          <th>Category</th>
          <th>Item Name</th>
          <th>Quantity Borrowed</th>
          <th>Borrowed Item Status</th>
          <th>Borrow Date</th>
          <th>Return Date</th>
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
      
      if ($conn === false)
          die(print_r(sqlsrv_errors(), true));
      

        $sql = "SELECT [Borrow_ID], [Student_Name], [Student_Number], [Room], [Borrowed_Category], [Borrowed_Item_Name], [Quantity_Borrowed], [Borrowed_Item_Status], [Borrow_Date], [Return_Date] FROM [WEBAPP].[dbo].[BORROWED]";
        $result = sqlsrv_query($conn, $sql);

        if ($result === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>" . $row['Student_Name'] . "</td>";
            echo "<td>" . $row['Student_Number'] . "</td>";
            echo "<td>" . $row['Room'] . "</td>";
            echo "<td>" . $row['Borrowed_Category'] . "</td>";
            echo "<td>" . $row['Borrowed_Item_Name'] . "</td>";
            echo "<td>" . $row['Quantity_Borrowed'] . "</td>";
            echo "<td>";
            echo "<input type='checkbox' id='returnCheckbox{$row['Borrow_ID']}' onchange='updateReturnStatus({$row['Borrow_ID']})' " . ($row['Borrowed_Item_Status'] === 'Returned' ? 'checked' : '') . ">";
            echo "</td>";
            echo "<td>" . $row['Borrow_Date']->format('Y-m-d H:i:s') . "</td>";
            echo "<td>" . ($row['Return_Date'] ? $row['Return_Date']->format('Y-m-d H:i:s') : 'Not Returned') . "</td>";
            echo "</tr>";
        }

        sqlsrv_close($conn);
        ?>

      </tbody>
    </table>
  </div>
      </div>
      </div>
      </div>
</section>
<div class="row justify-content-end mt-3">
    <div class="col-6">
      <form action="generate_word_report.php" method="post">
        <button type="submit" class="btn btn-success">Generate Word Report</button>
      </form>
      <br>
    </div>
<script src="script.js"></script>

<script>

  function Home() {
    window.location.href = "index.html";
  }
  function filterItems() {
    var input = document.getElementById("searchInput").value.toUpperCase();
    var table = document.querySelector("#itemTableDisplay table");
    var tr = table.getElementsByTagName("tr");

    for (var i = 0; i < tr.length; i++) {
        var shouldDisplay = false;
        var td = tr[i].getElementsByTagName("td");
        
        for (var j = 0; j < td.length; j++) {
            var cellText = td[j].textContent || td[j].innerText;
            if (cellText.toUpperCase().indexOf(input) > -1) {
                shouldDisplay = true;
                break;
            }
        }

        tr[i].style.display = shouldDisplay ? "" : "none";
    }
}


  function updateReturnStatus(borrowID) {
    var checkbox = document.getElementById(`returnCheckbox${borrowID}`);
    var status = checkbox.checked ? 'Returned' : 'Not Returned';

    // Send an AJAX request to update the status in the database
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
      if (xhr.readyState === XMLHttpRequest.DONE) {
        if (xhr.status === 200) {
          // Update successful
          console.log(`Borrow ID ${borrowID} status updated to ${status}`);
        } else {
          // Update failed
          console.error(`Failed to update status for Borrow ID ${borrowID}`);
          // You can add additional error handling here
        }
      }
    };

    xhr.open("POST", "update_return_status.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send(`borrowID=${borrowID}&status=${status}`);
  }
  function showReportsSection() {
    window.location.href = "dashboard.php";
  }
</script>
</body>
</html>
