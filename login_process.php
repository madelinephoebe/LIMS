<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Fetch values from the form
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

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

    // Prepared statement to avoid SQL injection
    $query = "SELECT * FROM ACCOUNTS WHERE username=?";
    $params = array($username);
    $stmt = sqlsrv_query($conn, $query, $params);

    if ($stmt && sqlsrv_has_rows($stmt)) {
        // User found
        $insertQuery = "INSERT INTO LOGIN (username, password, date) VALUES (?, ?, GETDATE())";
        $insertParams = array($username, $hashed_password); // Use hashed password here
        sqlsrv_query($conn, $insertQuery, $insertParams);

        $_SESSION['username'] = $username;

        // Redirect based on username
        if ($username == 'admin') {
            header("Location: dash.php");
        } elseif ($username == 'staff') {
            header("Location: staffdash.php");
        } else {
            // Redirect to a generic dashboard or error page if needed
            header("Location: genericdash.php");
        }
        exit();
    } else {
        // Handle invalid login
        echo "Invalid username or password.";
    }

    sqlsrv_close($conn);
}
?>
