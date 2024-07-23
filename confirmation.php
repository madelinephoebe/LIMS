<!DOCTYPE html>
<html>
<head>
<title>Confirmation Form</title>


<script>

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

</script>  </head>

<body>
    <form id="name" name="name" method="post" action="confirmation.php">
        <label for="name">Name:</label><br>
        <input type="text" id="name" name="name" onkeydown="checkEnter(event)">  <br><br>
        <button type="button" onclick="confirmSubmission()">Submit</button>
      </form>
</body>
</html>


PHP:

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Access submitted data
  $name = $_POST["name"];

  // Process data here (e.g., store in database, send email)
  echo "Hello, " . $name . "! Your form was submitted successfully.";
} else {
  // Handle potential errors (e.g., form accessed directly)
  echo "Error: Form submission failed.";
}
?>