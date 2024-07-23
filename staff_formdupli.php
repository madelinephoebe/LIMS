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
             <a href="staff_Form.php" class="nav-link active text-dark" aria-current="page">
              <i class="fs-5 lni lni-write"></i> 
            <span class="fs-5 ms-2 d-none d-sm-inline">Form</span>
          </a>
      
        </li>
          <li class="nav-item my-2">
            <a href="staffreports.php" class="nav-link text-dark">
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

<!-- Student Form Section -->
<div id="formSection"><br>
  <h1 class="h-form my-3 mx-3">Borrowing Form</h1>
  <h2 class="h-form my-3 mx-3">Student Information</h2>  
  <div class="row mx-3 mt-3 mb-4">
        <div class="col-sm-6 col-md-6 col-lg-3">
  <form id="studentForm" action="submitForm.php" method="post">
  <label for="studentName" class="fs-6 mb-1">Student Name:</label>
<input type="text" class="form-control" placeholder="Full name"  id="studentName" name="studentName" required>
</div>
        <div class="col-sm-6 col-md-6 col-lg-3">
<label for="studentID" class="fs-6 mb-1">Student ID Number:</label>
<input type="number" class="form-control" placeholder="20xxxxxxx" id="studentID" name="studentID" required>
</div>
<div class="col-sm-6 col-md-6 col-lg-3">
<label for="room" class="fs-6 mb-1">Room:</label>
<input type="text" class="form-control" id="room" placeholder="CTH1xx" name="room" required>
</div>
</div>
<h2 class="h-form my-3 mx-3">Item Information</h2>  
<div class="row mx-3">
<div class="col-sm-4 col-md-6 col-lg-3">
                <label for="borrowedCategory" class="fs-6">Select Item Category:</label>
                <select id="borrowedCategory" class="form-select" name="borrowedCategory" onchange="fetchItemNames()">
                </select>
</div>
<div class="col-sm-4 col-md-6 col-lg-3">
                <label for="borrowedItemName" class="fs-6">Borrowed Item Name:</label>
                <select id="borrowedItemName" class="form-select" name="borrowedItemName">
                </select>
</div>
<div class="col-sm-4 col-md-6 col-lg-3">
    <label for="borrowedQuantity" class="fs-6">Quantity Borrowed:</label>
    <input type="number" id="borrowedQuantity"  class="form-control" name="borrowedQuantity" required>
</div>
<div class="col-sm-4 col-md-6 col-lg-3 mt-4 mb-5">

 <button type="submit" class="add-btn btn btn-success" id="submitButton" onclick="confirmSubmission()">Submit</button>
  </form>
</div><script>
    function showFormSection() {
        var formSection = document.getElementById("formSection");
        // You can choose to use other styles to make it instantly visible
        formSection.style.opacity = 1; // This makes it instantly visible
    }
    function confirmSubmission() {
        if (confirm("Are You Sure?")) {
          document.getElementById("name").submit(); // Submit form if Yes is clicked
        }
      }
      
    function checkEnter(event) {
        if (event.keyCode === 13) { // Check for Enter key (keyCode 13)
          confirmSubmission();
        }
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

        // Call the showFormSection function immediately after the DOM is loaded
        showFormSection();
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

            // Set the default "Select" option first
            borrowedCategoryDropdown.innerHTML = '<option value="" disabled selected>Select</option>' + borrowedCategoryDropdown.innerHTML;

            // Populate the dropdown with options
            populateDropdown(borrowedCategoryDropdown, options.borrowedCategories);

            // Initially, the item names dropdown is empty
            const borrowedItemNameDropdown = document.getElementById('borrowedItemName');
            borrowedItemNameDropdown.innerHTML = '<option value="" disabled selected>Select</option>';
        })
        .catch(error => console.error('Error fetching options:', error))
        .finally(() => {
            // Ensure the "Select" option is enabled after fetching options
            document.getElementById('borrowedCategory').removeAttribute('disabled');
        });
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
            if (data.status === 'success') {
                // Clear the form
                document.getElementById('studentForm').reset();

                alert('Form submitted successfully');
            } else {
                // Optionally, show an error message to the user
                alert('Failed to submit form. ' + data.message);
            }
        })
        .catch((error) => {
            console.error('Error:', error);
        });
}
function fetchItemNames() {
    const categoryDropdown = document.getElementById('borrowedCategory');
    const selectedItem = categoryDropdown.value;

    if (!selectedItem) {
        // No category selected, reset item names dropdown
        resetItemNamesDropdown();
        return;
    }

    // Fetch item names based on the selected category
    fetch(`fetchItemNames.php?category=${selectedItem}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Failed to fetch item names');
            }
            return response.json();
        })
        .then(itemNames => {
            // Populate item name dropdown for borrowed info
            const borrowedItemNameDropdown = document.getElementById('borrowedItemName');
            populateDropdown(borrowedItemNameDropdown, itemNames);
        })
        .catch(error => console.error('Error fetching item names:', error));
}

function resetItemNamesDropdown() {
    // Reset item names dropdown when no category is selected
    const borrowedItemNameDropdown = document.getElementById('borrowedItemName');
    borrowedItemNameDropdown.innerHTML = '<option value="">Item Name</option>';
}
</script>
</body>
</html>

