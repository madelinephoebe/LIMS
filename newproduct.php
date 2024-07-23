<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Dashboard</title>
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

$sql = "SELECT [Category], [Item_Number], [Item_Name], [Quantity], [Date_Received] FROM [WEBAPP].[dbo].[ITEMS]";
$result = sqlsrv_query($conn, $sql);

if ($result === false) {
    die(print_r(sqlsrv_errors(), true));
}
?>

<!--CSS-->
<link rel="stylesheet" href="loginindex.css"> 

<script src="https://kit.fontawesome.com/06f778c4e3.js" crossorigin="anonymous"></script>
<link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Oswald&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
<style>    select#categoryFilterDropdown,
    select#statusFilter, select#dateFilter {
      border: none; /* Remove border */
      font-weight: bold; /* Make text bold */}</style>
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
            <a href="dash.php" class="nav-link text-dark">
              <i class="lni lni-grid-alt"></i>
              <span class="fs-5 ms-2 d-none d-sm-inline">Dashboard</span>  
            </a>
          </li>

          <li class="nav-item my-2">
            <a href="newproduct.php" class="nav-link active text-dark" aria-current="page">
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
      <h1 class="h-products
       my-3 mx-3">Manage Products</h1>

      <div class="col-sm-6 col-md-6 col-lg-4 mt-5 mb-3 mx-3"> 
      <div class="item_table" id="itemTableDisplay">
      <form class="d-flex" role="search">
  <input class="form-control me-2" type="search" id="searchInput" style="width: 250px;" placeholder="Search" aria-label="Search" onkeyup="filterItems()">
  <button class="btn btn-success d-flex searchbtn" type="submit"> <i class="lni lni-magnifier search-icon"></i> Search</button>
  </form><br>
   
      <center><table class="table text-center table-hover" style="width: 1100px;"></center>
<div class="row">
        <div class="col-10"></div>
        <div class="col-auto mb-3 p-0">
        <div class="container">
        <button class="btn btn-success d-flex" type="button" id="addButton" onclick="openPopup()"> <i class="lni lni-circle-plus add-icon"></i> Add Product</button>
       <!--  <button id="addButton" onclick="addRow()">Add Row</button><br> -->
 <div class="popup" id="popup">

              <div class="row" div id="addRowForm">
                <h2 class="my-2 popupText">New Products</h2>

                <div class="col-6 mb-2 inputBoxNewProd">
                  <label for="newCategory" class="fs-6 labelNewProd">Select Category:</label> <br>
                  <input type="text" class="form-select" id="newCategory" name="newCategory" required>
                </div>
                <div class="col-6 mb-2 inputBoxNewProd">
                  <label for="newItemName" class="fs-6 labelNewProd">Item Name:</label> <br>
                  <input type="text" class="form-select" id="newItemName" name="newItemName" required>
                </div>
        
                <div class="col-6 mb-2 inputBoxNewProd">
                  <label for="newQuantity" class="fs-6 labelNewProd">Quantity:</label> <br>
                  <input type="number" name="newQuantity" id="newQuantity" class="form-control"required>
                </div>
                <div class="col-6 mb-2 inputBoxNewProd">
    <label for="newDateReceived" class="fs-6 labelNewProd">Date Received:</label><br>
    <input type="date" name="newDateReceived" id="newDateReceived" class="form-control" required>
</div>

              </div>

              <div class="d-flex">
                              
              <button type="button" class="btn btn-success button my-3 mx-2" id="addNewProd" onclick="saveNewRow()" onclick="closePopup()">Add</button>
              <button type="button" class="btn btn-success button my-3 mx-2" id="cancel" onclick="closePopup()">Cancel</button>
              </div>

            </div>
          </div>
        </div>
  <thead>
    <tr>
      <th>
        <!-- Category Filter Dropdown -->
        <select id="categoryFilterDropdown" onchange="filterItems()">
          <option value="">Category</option>
          <option value="Measurement Instruments">Measurement Instruments</option>
          <option value="Electronic Component">Electronic Component</option>
          <option value="Tools and Supplies">Tools and Supplies</option>
          <option value="Networking Equipment">Networking Equipment</option>
        </select>
      </th>
      <th>Item Number</th>
      <th>Item Name</th>
      <th>Quantity</th>
      <th>
          <select id="statusFilter" onchange="filterItems()" class="S">
            <option value="">Status</option>
            <option value="Sufficient Stocks">Sufficient Stocks</option>
            <option value="Low Stocks">Low Stocks</option>
          </select>
      </th>
      <th>
            <select id="dateFilter" onchange="filterItems()">
                <option value="">Date Received</option>
                <option value="ascending">Ascending</option>
                <option value="descending">Descending</option>
            </select>
        </th>
        <th>
    </th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
        <?php
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
          $lowStockClass = ($row['Quantity'] <= 5) ? 'lowStock' : '';
          $status = ($row['Quantity'] <= 5) ? 'Low Stocks' : 'Sufficient Stocks';
          echo "<tr id='row" . $row['Item_Number'] . "' class='$lowStockClass'>";
          echo "<td>" . $row['Category'] . "</td>";
          echo "<td>" . $row['Item_Number'] . "</td>";
          echo "<td>" . $row['Item_Name'] . "</td>";
          echo "<td id='quantity" . $row['Item_Number'] . "'>" . $row['Quantity'] . "</td>";
          echo "<td>" . $status . "</td>";
          if ($row['Date_Received'] !== null) {
            echo "<td>" . $row['Date_Received']->format('Y-m-d') . "</td>";
        }
      
          echo "<td>";

          // Display the "saveButton" only if the row is being edited
          if (isset($_POST['editItemNumber']) && $_POST['editItemNumber'] == $row['Item_Number']) {
            echo "<button class='saveButton action-btn btn btn-success' onclick='saveRow(" . $row['Item_Number'] . ")'><i class='lni lni-pencil pencil-icon'></i>Save</button>";
          } else {
            echo "<td>";
            echo "<button class='editButton action-btn btn btn-success' onclick='editRow(" . $row['Item_Number'] . ")'><i class='lni lni-pencil pencil-icon'></i>Edit</button>";
            echo "<button class='deleteButton action-btn btn btn-success' onclick='deleteRow(" . $row['Item_Number'] . ")'><i class='lni lni-trash-can trash-icon'></i> Delete</button>";
            echo "</td>";     }

          echo "</td>";
          echo "</tr>";

          $updateStatusSql = "UPDATE [WEBAPP].[dbo].[ITEMS] SET [Status] = ? WHERE [Item_Number] = ?";
    $params = array($status, $row['Item_Number']);
    $updateStatusResult = sqlsrv_query($conn, $updateStatusSql, $params);
    if ($updateStatusResult === false) {
        die(print_r(sqlsrv_errors(), true));
          }
        }

          sqlsrv_close($conn);
        ?>
  </tbody>
</table>
<div class="row justify-content-end mt-3">
    <div class="col-6">
        <form action="generate_filtered_report.php" method="post" id="generateReportForm">
            <input type="hidden" name="category" id="filterCategory" value="">
            <input type="hidden" name="status" id="filterStatus" value="">
            <input type="hidden" name="date" id="filterDate" value="">
            <button type="submit" class="btn btn-success">Generate Filtered Word Report</button>
        </form>
        <br>
    </div>
</div>

</div>
<script src="script.js"></script>

<script>
  function showReportsSection() {
  var reportsSection = document.getElementById("reportsSection");
  reportsSection.style.display = "block";

  // Fetch and display reports data
  fetchReportsData();
}

function fetchReportsData() {
  // Replace 'fetchReports.php' with your actual endpoint to fetch reports data
  fetch('fetchReports.php')
    .then(response => {
      if (!response.ok) {
        throw new Error('Failed to fetch reports');
      }
      return response.json();
    })
    .then(reportsData => {
      displayReportsData(reportsData);
    })
    .catch(error => console.error('Error fetching reports data:', error));
}

function displayReportsData(reportsData) {
  var reportsTableBody = document.getElementById("reportsTableBody");
  reportsTableBody.innerHTML = '';

  reportsData.forEach(report => {
    var row = document.createElement("tr");

    var studentNameCell = document.createElement("td");
    studentNameCell.textContent = report.studentName;
    row.appendChild(studentNameCell);

    var studentIDCell = document.createElement("td");
    studentIDCell.textContent = report.studentID;
    row.appendChild(studentIDCell);

    var categoryCell = document.createElement("td");
    categoryCell.textContent = report.category;
    row.appendChild(categoryCell);

    var itemNameCell = document.createElement("td");
    itemNameCell.textContent = report.itemName;
    row.appendChild(itemNameCell);

    var quantityCell = document.createElement("td");
    quantityCell.textContent = report.quantity;
    row.appendChild(quantityCell);

    var dateBorrowedCell = document.createElement("td");
    dateBorrowedCell.textContent = report.dateBorrowed;
    row.appendChild(dateBorrowedCell);

    var dateReturnedCell = document.createElement("td");
    dateReturnedCell.textContent = report.dateReturned;
    row.appendChild(dateReturnedCell);

    var completeCell = document.createElement("td");
    var checkbox = document.createElement("input");
    checkbox.type = "checkbox";
    completeCell.appendChild(checkbox);
    row.appendChild(completeCell);

    reportsTableBody.appendChild(row);
  });
}
  function toggleTable() {
    var itemTable = document.getElementById("itemTableDisplay");
    itemTable.style.display = itemTable.style.display === "none" ? "block" : "none";
    var editButtons = document.getElementsByClassName("editButton");
    for (var i = 0; i < editButtons.length; i++) {
      editButtons[i].style.display = editButtons[i].style.display === "none" ? "inline-block" : "none";
    }
    var deleteButtons = document.querySelectorAll("#itemTableDisplay tbody tr td:last-child button:not(.editButton)");
    for (var i = 0; i < deleteButtons.length; i++) {
      deleteButtons[i].style.display = deleteButtons[i].style.display === "none" ? "inline-block" : "none";
    }
    var addButton = document.getElementById("addButton");
    addButton.style.display = addButton.style.display === "none" ? "none" : "none";
  };

  function Home() {
    window.location.href = "index.html";
  }
  function editRow(itemNumber) {
  var row = document.getElementById('row' + itemNumber);

  var categoryCell = row.cells[0].innerText;
  var itemNumberCell = row.cells[1].innerText;
  var itemNameCell = row.cells[2].innerText;
  var quantityCell = row.cells[3].innerText;
  var dateReceivedCell = row.cells[5].innerText;

  row.cells[0].innerHTML = '<input type="text" value="' + categoryCell + '" id="editCategory' + itemNumber + '">';
  row.cells[1].innerHTML = '<input type="text" value="' + itemNumberCell + '" id="editItemNumber' + itemNumber + '" disabled>'; // Item Number should not be editable if it's a unique identifier
  row.cells[2].innerHTML = '<input type="text" value="' + itemNameCell + '" id="editItemName' + itemNumber + '">';
  row.cells[3].innerHTML = '<input type="text" value="' + quantityCell + '" id="editQuantity' + itemNumber + '">';
  row.cells[5].innerHTML = '<input type="text" value="' + dateReceivedCell + '" id="editDateReceived' + itemNumber + '">';
  row.cells[6].innerHTML = '<button class="saveButton action-btn btn btn-success" onclick="saveRow(' + itemNumber + ')">Save</button>';
}
function saveRow(itemNumber) {
  var editedCategory = document.getElementById('editCategory' + itemNumber).value;
  var editedItemName = document.getElementById('editItemName' + itemNumber).value;
  var editedQuantity = document.getElementById('editQuantity' + itemNumber).value;
  var editedDateReceived = document.getElementById('editDateReceived' + itemNumber).value;

  let formData = new FormData();
  formData.append('itemNumber', itemNumber);
  formData.append('category', editedCategory);
  formData.append('itemName', editedItemName);
  formData.append('quantity', editedQuantity);
  formData.append('dateReceived', editedDateReceived);

  fetch('editProducts.php', {
    method: 'POST',
    body: formData
  })
  .then(response => response.text())
  .then(data => {
    console.log(data);

    updateTableRow(itemNumber, 'category', editedCategory);
    updateTableRow(itemNumber, 'item name', editedItemName);
    updateTableRow(itemNumber, 'quantity', editedQuantity);
    updateTableRow(itemNumber, 'dateReceived', editedDateReceived);

    var row = document.getElementById('row' + itemNumber);
    row.cells[6].innerHTML = '<button class="editButton" onclick="editRow(' + itemNumber + ')">Edit</button>';
        // Reload the page after successful save
        location.reload();
  })
  .catch((error) => {
    console.error('Error:', error);
    alert('An error occurred while saving the changes. Please try again.');
  });
}

  function updateTableRow(originalItemNumber, fieldToEdit, newValue) {
    var row = document.getElementById("row" + originalItemNumber);

    if (row) {
      var cellIndex;

      switch (fieldToEdit) {
        case "category":
          cellIndex = 0;
          break;
        case "item number":
          cellIndex = 1;
          break; 
        case "item name":
          cellIndex = 2;
          break;
        case "quantity":
          cellIndex = 3;
          case "dateReceived":
          cellIndex = 5;
          break;
        default:
          break;
      }

      if (cellIndex !== undefined && row.cells[cellIndex]) {
        row.cells[cellIndex].innerHTML = newValue;
      }
    }
  }
  function addRow() {
  var addButton = document.getElementById("addButton");
  var addRowForm = document.getElementById("addRowForm");
  addRowForm.style.display = addRowForm.style.display === "none" ? "block" : "none";

  if (addRowForm.style.display === "none") {
    document.getElementById("newCategory").value = "";
    document.getElementById("newItemName").value = "";
    document.getElementById("newQuantity").value = "";
  }
}
function saveNewRow() {
    // Get input values
    var newCategory = document.getElementById("newCategory").value;
    var newItemName = document.getElementById("newItemName").value;
    var newQuantity = document.getElementById("newQuantity").value;
    var newDateReceived = document.getElementById("newDateReceived").value;

    // Create a FormData object and append input values
    let formData = new FormData();
    formData.append('category', newCategory);
    formData.append('itemName', newItemName);
    formData.append('quantity', newQuantity);
    formData.append('dateReceived', newDateReceived);

    // Send the FormData to the server-side script
    fetch('addNewRow.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        console.log(data);

        // Check for success status and perform actions accordingly
        if (data.includes('success')) {
            // Extract item number from the response (assuming response format includes it)
            const newItemNumber = data.split(':')[1];
            // Add a new row to the table
            addNewTableRow(newItemNumber, newCategory, newItemName, newQuantity, newDateReceived);
            // Reset form inputs and close the popup
            document.getElementById("addRowForm").style.display = "none";
            document.getElementById("newCategory").value = "";
            document.getElementById("newItemName").value = "";
            document.getElementById("newQuantity").value = "";
            document.getElementById("newDateReceived").value = "";
            closePopup();
        } else {
            alert('Error adding new row: ' + data);
        }
    })
    .catch((error) => {
        console.error('Error:', error);
        alert('An error occurred while communicating with the server. Please try again.');
    });
}
function addNewTableRow(newItemNumber, newCategory, newItemName, newQuantity, newDateReceived) {
    var tableBody = document.getElementById("itemTableDisplay").getElementsByTagName('tbody')[0];

    var newRow = document.createElement("tr");
    newRow.id = "row" + newItemNumber;

    // Create cells for each column and append them to the row
    var cell1 = document.createElement("td");
    cell1.textContent = newCategory;
    newRow.appendChild(cell1);

    var cell2 = document.createElement("td");
    cell2.textContent = newItemNumber;
    newRow.appendChild(cell2);

    var cell3 = document.createElement("td");
    cell3.textContent = newItemName;
    newRow.appendChild(cell3);

    var cell4 = document.createElement("td");
    cell4.textContent = newQuantity;
    newRow.appendChild(cell4);

    // Create a cell for the date received and append it to the row
    var cell5 = document.createElement("td");
    cell5.textContent = newDateReceived;
    newRow.appendChild(cell5);

    // Append action buttons to the row
    var cell6 = document.createElement("td");
    cell6.innerHTML = '<button class="editButton action-btn btn btn-success" onclick="editRow(' + newItemNumber + ')">Edit</button>';
    newRow.appendChild(cell6);

    // Add the new row to the table body
    tableBody.appendChild(newRow);
}
function filterItems() {
    // Get the input values
    var searchInput = document.getElementById("searchInput").value.toUpperCase();
    var categoryFilter = document.getElementById("categoryFilterDropdown").value;
    var statusFilter = document.getElementById("statusFilter").value;
    var dateFilter = document.getElementById("dateFilter").value;

    // Populate hidden inputs in the report generation form
    document.getElementById("filterCategory").value = categoryFilter;
    document.getElementById("filterStatus").value = statusFilter;
    document.getElementById("filterDate").value = dateFilter;

    // Get the table and rows
    var table = document.querySelector("#itemTableDisplay table");
    var rows = table.getElementsByTagName("tr");

    // Remove the header row
    var headerRow = rows[0];
    rows = Array.from(rows).slice(1);

    // Filter rows based on the selected criteria
    rows.forEach(function(row) {
        var cells = row.getElementsByTagName("td");
        var tdCategory = cells[0].textContent;
        var tdItemName = cells[2].textContent;
        var tdStatus = cells[4].textContent;
        var tdDateReceived = cells[5].textContent;

        // Apply filters
        var matchesCategory = (categoryFilter === "" || tdCategory === categoryFilter);
        var matchesStatus = (statusFilter === "" || tdStatus === statusFilter);
        var matchesSearch = (tdItemName.toUpperCase().includes(searchInput) || tdCategory.toUpperCase().includes(searchInput));
        var showRow = matchesCategory && matchesStatus && matchesSearch;

        // Set the row visibility
        row.style.display = showRow ? "" : "none";
    });

    // Sort rows based on date received
    if (dateFilter) {
        rows.sort(function(a, b) {
            var dateA = new Date(a.cells[5].textContent);
            var dateB = new Date(b.cells[5].textContent);

            return dateFilter === "ascending" ? dateA - dateB : dateB - dateA;
        });
    }

    // Reorder rows in the table body
    var tableBody = table.querySelector("tbody");
    rows.forEach(function(row) {
        tableBody.appendChild(row);
    });
}


function deleteRow(itemNumber) {
    if (confirm("Are you sure you want to delete this item?")) {
        fetch('deleteProducts.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'itemNumber=' + itemNumber,
        })
        .then(response => response.text())
        .then(data => {
            console.log(data);

            // Remove the row from the table
            var row = document.getElementById('row' + itemNumber);
            row.parentNode.removeChild(row);
        })
        .catch((error) => {
            console.error('Error:', error);
            alert('An error occurred while deleting the item. Please try again.');
        });
    }
}
function showFormSection() {
    var formSection = document.getElementById("formSection");
    formSection.style.display = "block";
}

  function populateDropdown(dropdown, optionsArray) {
    // Clear existing options
    dropdown.innerHTML = '';

    optionsArray.forEach(optionValue => {
      const option = document.createElement('option');
      option.value = optionValue;
      option.text = optionValue;
      dropdown.appendChild(option);
    });
  }
  document.addEventListener("DOMContentLoaded", function () {
    fetchOptions();

  const form = document.getElementById('studentForm');
  form.addEventListener('submit', function (event) {
    event.preventDefault(); // Prevent default form submission
    submitForm();
  });
});
function fetchOptions() {
  fetch('fetchOptions.php')
    .then(response => {
      if (!response.ok) {
        throw new Error('Failed to fetch options');
      }
      return response.json();
    })
    .then(options => {
      // Populate category dropdown for borrowed info
      const borrowedCategoryDropdown = document.getElementById('borrowedCategory');
      populateDropdown(borrowedCategoryDropdown, options.borrowedCategories);

      // Populate item name dropdown for borrowed info
      const borrowedItemNameDropdown = document.getElementById('borrowedItemName');
      populateDropdown(borrowedItemNameDropdown, options.borrowedItemNames);
    })
    .catch(error => console.error('Error fetching options:', error));
}

function submitForm() {
    const formData = new FormData(document.getElementById('studentForm'));

    fetch('submitForm.php', {
        method: 'POST',
        body: formData,
    })
    .then(response => response.json())
    .then(data => {
        console.log('Status:', data.status);
        console.log('Message:', data.message);

        // Handle success or error, like showing a message to the user
    })
    .catch((error) => {
        console.error('Error:', error);
    });
}
function openPopup() {
  popup.classList.add("open-popup");
  document.getElementById("addButton").style.display = "inline-block"; // Show the Add button
    document.getElementById("cancel").style.display = "inline-block"; // Hide the Cancel button
}
function closePopup() {
  popup.classList.remove("open-popup");
  document.getElementById("addButton").style.display = "none"; // Show the Add button
    document.getElementById("cancel").style.display = "none"; // Hide the Cancel button
}
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="index.js"></script>
</body>
</html>

