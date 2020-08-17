
<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>Classwork</title>
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700" rel="stylesheet"><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
<link rel="stylesheet" href="mainstyle.css">

</head>
<body>

<!-- partial:index.partial.html -->
<div id="container">
  <img class="logo" src="images/logo.png" />
  <h1>Classwork</h1>
  <section class="welcome">
    <p>All in one portal for schools and colleges with image processing</p>
    <ul class="buttons">
      <li><a class="primary" href="#">Log In</a></li>
      <!-- <li><a href="#">Explore Themes</a></li> -->
    </ul>
  </section>  
  
  <form id="login" class="hidden" method="POST">
    <section>
      <div class="field">
        <label for="username"><svg class="icon"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#user"></use></svg></label>
        <input type="text" name="user" placeholder="Username" required="">
      </div>
      <div class="field">
        <label for="password"><svg class="icon"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#lock"></use></svg></label>
        <input type="password" name="pass" placeholder="Password" required="">
      </div>
    </section>
    <ul class="buttons">
      <li><input type="submit" name="login" value="login" class="primary disabled"></li>
      <li><a href="#" class="minor">&#10229; Go back</a></li>
    </ul>
  </form>
</div>

<div id="footer">
  <ul>
    <li><a href="#">Copyrights to Classwork</a></li>
<!--     <li><a href="#">Privacy</a></li>
    <li><a href="#">Contact</a></li> -->
  </ul>
</div>



<svg xmlns="http://www.w3.org/2000/svg" class="icons hidden">
  <symbol id="user" viewBox="0 0 32 32" fill="none" stroke="currentcolor" stroke-linecap="round" stroke-linejoin="round" stroke-width="6.25%"><path d="M22 11 C22 16 19 20 16 20 13 20 10 16 10 11 10 6 12 3 16 3 20 3 22 6 22 11 Z M4 30 L28 30 C28 21 22 20 16 20 10 20 4 21 4 30 Z" /></symbol>
  <symbol id="lock" viewBox="0 0 32 32" fill="none" stroke="currentcolor" stroke-linecap="round" stroke-linejoin="round" stroke-width="6.25%"><path d="M5 15 L5 30 27 30 27 15 Z M9 15 C9 9 9 5 16 5 23 5 23 9 23 15 M16 20 L16 23" /><circle cx="16" cy="24" r="1" />
  </symbol>
</svg>
<!-- partial -->
  <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js'></script><script  src="mainscript.js"></script>

  <?php include 'includes/connection.php';?>


<?php
session_start();
if (isset($_POST['login'])) {
  $username  = $_POST['user'];
  $password = $_POST['pass'];
  mysqli_real_escape_string($conn, $username);
  mysqli_real_escape_string($conn, $password);
$query = "SELECT * FROM users WHERE username = '$username'";
$result = mysqli_query($conn , $query) or die (mysqli_error($conn));
if (mysqli_num_rows($result) > 0) {
  while ($row = mysqli_fetch_array($result)) {
    $id = $row['id'];
    $user = $row['username'];
    $pass = $row['password'];
    $name = $row['name'];
    $email = $row['email'];
    $role= $row['role'];
    $course = $row['course'];
    if (password_verify($password, $pass )) {
      $_SESSION['id'] = $id;
      $_SESSION['username'] = $username;
      $_SESSION['name'] = $name;
      $_SESSION['email']  = $email;
      $_SESSION['role'] = $role;
      $_SESSION['course'] = $course;
      header('location: console/');
    }
    else {
      echo "<script>alert('invalid username/password');
      window.location.href= 'index.php';</script>";

    }
  }
}
else {
      echo "<script>alert('invalid username/password');
      window.location.href= 'index.php';</script>";

    }
}
?>


</body>
</html>
