<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login & Registration Form</title>
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
  <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css" />
 </head>
 <body class="login-page">
  <div class="container-fluid-md container-login">
    <div class="form-container admin-login d-flex justify-content-center align-items-center">
   <!-- LOGIN FORM -->
   <form id="admin" action="login_process.php" method="post" class="text-center">
    <h1>Admin Login</h1>
    <input type="text" placeholder="Username" class="form-control my-2" name="username" >
    <input type="password" placeholder="Password" class="form-control my-2" name="password">
    <button type="submit" class="btn btn-success mt-3" name="admin_submit">Login</button>
  </form>
</div>

<div class="form-container staff-login d-flex justify-content-center align-items-center">
<form id="staff" action="login_process.php" method="post" class="text-center">
    <h1>Staff Login</h1>
    <input type="text" placeholder="Username" class="form-control my-2" name="username">
    <input type="password" placeholder="Password" class="form-control my-2" name="password">
    <button type="submit" class="btn btn-success mt-3">Login</button>
</form>

</div>

<div class="toggle-container">
  <div class="toggle">
    <div class="toggle-panel toggle-left">
      <h1>Welcome back <br> Staff!</h1>
      <p>Not a staff?</p>
      <button class="hidden btn btn-dark" id="admin-account">Admin Login</button>
    </div>
    <div class="toggle-panel toggle-right">
      <h1>Welcome back <br>Admin!</h1>
      <p>Not an admin?</p>
      <button class="hidden btn btn-dark" id="staff-account">Staff Login</button>
      </div>
  </div>
</div>
</div> 

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="login.js"></script>
</body>
</html>
