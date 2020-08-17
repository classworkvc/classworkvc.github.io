<!DOCTYPE html>
<?php include 'includes/connection.php';?>

<?php include('ver.php');  ?> 







<!--[if IE 8]><html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]>
<!--><html class="no-js" lang="en"><!--<![endif]-->
<head>

	<!-- Basic Page Needs
	================================================== -->
	<meta charset="utf-8">
	<title>Classwork</title>
	

	<!-- Mobile Specific Metas
	================================================== -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<meta name="theme-color" content="#212121"/>
    <meta name="msapplication-navbutton-color" content="#212121"/>
    <meta name="apple-mobile-web-app-status-bar-style" content="#212121"/>

	<!-- Web Fonts 
	================================================== -->
	<link href="https://fonts.googleapis.com/css?family=Muli:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&amp;subset=latin-ext,vietnamese" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i&amp;subset=cyrillic,cyrillic-ext,greek,greek-ext,latin-ext,vietnamese" rel="stylesheet">
	
	<!-- CSS
	================================================== -->
	<link rel="stylesheet" href="css/bootstrap.min.css"/>
	<link rel="stylesheet" href="css/font-awesome.min.css"/>
	<link rel="stylesheet" href="css/animsition.min.css"/>
	<link rel="stylesheet" href="css/swiper.min.css"/>
	<link rel="stylesheet" href="css/style.css"/>
			
	<!-- Favicons
	================================================== -->
	<link rel="icon" type="image/png" href="favicon.jpg">
	<link rel="apple-touch-icon" href="apple-touch-icon.jpg">
	<link rel="apple-touch-icon" sizes="72x72" href="apple-touch-icon-72x72.jpg">
	<link rel="apple-touch-icon" sizes="114x114" href="apple-touch-icon-114x114.jpg">
	
	
</head>
<body>







	<!-- Page preloader wrap
	================================================== -->

	<div class="animsition">	
		
		<!-- Nav and Logo
		================================================== -->

		
		<header class="cd-header">
			<div class="header-wrapper">
				<div class="logo-wrap">
					<!-- <a href="index.html" class="hover-target animsition-link"><img src="img/logo.png" alt=""></a> -->
				</div>
				<div class="nav-but-wrap">
					<div class="menu-icon hover-target">
						<span class="menu-icon__line menu-icon__line-left"></span>
						<span class="menu-icon__line"></span>
						<span class="menu-icon__line menu-icon__line-right"></span>
					</div>					
				</div>					
			</div>				
		</header>

		<div class="nav">
			<div class="nav__content">
				<li class="nav__list-item"><a href="index.html" class="hover-target animsition-link">Home</a></li>
					<li class="nav__list-item"><a href="/logout.php" class="hover-target animsition-link">Logout</a></li>



					<!-- <li class="nav__list-item"><a href="newstudent.php" class="hover-target animsition-link">Register a student</a></li> -->

				</ul>
			</div>
		</div>	

		<?php
if (isset($_POST['signup'])) {
require "gump.class.php";
$gump = new GUMP();
$_POST = $gump->sanitize($_POST); 

$gump->validation_rules(array(
  'username'    => 'required|alpha_numeric|max_len,20|min_len,4',
  'name'        => 'required|alpha_space|max_len,30|min_len,5',
  'email'       => 'required|valid_email',
  'password'    => 'required|max_len,50|min_len,6',
));
$gump->filter_rules(array(
  'username' => 'trim|sanitize_string',
  'name'     => 'trim|sanitize_string',
  'password' => 'trim',
  'email'    => 'trim|sanitize_email',
  ));
$validated_data = $gump->run($_POST);

if($validated_data === false) {
  ?>
  <center><font color="red" > <?php echo $gump->get_readable_errors(true); ?> </font></center>
  <?php
}
else if ($_POST['password'] !== $_POST['repassword']) 
{
  echo  "<center><font color='red'>Passwords do not match </font></center>";
}
else {
      $username = $validated_data['username'];
      $checkusername = "SELECT * FROM users WHERE username = '$username'";
      $run_check = mysqli_query($conn , $checkusername) or die(mysqli_error($conn));
      $countusername = mysqli_num_rows($run_check); 
      if ($countusername > 0 ) {
    echo  "<center><font color='red'>Username is already taken! try a different one</font></center>";
}
$email = $validated_data['email'];
$checkemail = "SELECT * FROM users WHERE email = '$email'";
      $run_check = mysqli_query($conn , $checkemail) or die(mysqli_error($conn));
      $countemail = mysqli_num_rows($run_check); 
      if ($countemail > 0 ) {
    echo  "<center><font color='red'>Email is already taken! try a different one</font></center>";
}

  else {
      $name = $validated_data['name'];
      $email = $validated_data['email'];
      $pass = $validated_data['password'];
      $password = password_hash("$pass" , PASSWORD_DEFAULT);
      $role = $_POST['role'];
      $course = $_POST['course'];
      $gender = $_POST['gender'];
      $joindate = date("F j, Y");
      $query = "INSERT INTO users(username,name,email,password,role,course,gender,joindate,token) VALUES ('$username' , '$name' , '$email', '$password' , '$role', '$course', '$gender' , '$joindate' , '' )";
      $result = mysqli_query($conn , $query) or die(mysqli_error($conn));
      if (mysqli_affected_rows($conn) > 0) { 
        echo "<script>alert('SUCCESSFULLY REGISTERED');
        window.location.href='dashboard/index.php';</script>";
}
else {
  echo "<script>alert('Error Occured');</script>";
}
}
}
}
?>




		<!-- Primary Page Layout
		================================================== -->	

		<div class="shadow-title parallax-top-shadow">Register</div>
		
		<div class="section padding-page-top padding-bottom over-hide z-bigger">
			<div class="container z-bigger">
				<div class="row page-title px-5 px-xl-2">
					<div class="col-12 parallax-fade-top">
						<h1>Register </h1>
					</div>
					<div class="offset-1 col-11 parallax-fade-top mt-2 mt-sm-3">
						<p>a new student</p>
					</div>
				</div>
			</div>
		</div>


		<div class="section padding-bottom-big over-hide z-bigger">
			<form id="contactform" method="POST"> 
			<div class="container">
				<div class="row px-5 px-xl-2">
					<div class="col-lg-9">
						<div class="row ajax-form">
							<div class="col-md-6">
								<input id="name" name="name" placeholder="First and last name" required="" tabindex="1" type="text" value="<?php if(isset($_POST['signup'])) { echo $_POST['name']; } ?>"> 
							</div>	
							<div class="col-md-6 mt-4 mt-md-0">
								 <input id="email" name="email" placeholder="Email id" required="" type="email" value="<?php if(isset($_POST['signup'])) { echo $_POST['email']; } ?>"> 
							</div>	
							<div class="col-md-6 mt-4">
								<input id="username" name="username" placeholder="username" required="" tabindex="2" type="text" value="<?php if(isset($_POST['signup'])) { echo $_POST['username']; } ?>"> 
							</div>	
							<div class="col-md-6 mt-4">
								            <select class="wide" name="gender">
				            <option value="Male">Male</option>
				            <option value="Female">Female</option>
				            </select><br><br>
							</div>	
							<div class="col-md-6 mt-4 hover-target">
								<input type="password" id="password" name="password" required=""> 
							</div>	
							<div class="col-md-6 mt-4 hover-target">
							<input type="password" id="repassword" name="repassword" required=""> 
							</div>	
							<div class="col-md-6 mt-4">
								<select class="wide" name="role">
				            <option value="teacher">Teacher</option>
				            <option value="student">Student</option>
				            </select><br><br>
							</div>	
							<div class="col-md-6 mt-4">
								<select class="wide" name="course">
		            <option value="Computer Science">Computer Sc Engineering</option>
		            <option value="Electrical">Electrical Engineering</option>
		            <option value="Mechanical">Mechanical Engineering</option>
		            </select><br><br>
							</div>	
							<div class="col-md-12 mt-4">
								<button class="hover-target" id="submit" tabindex="5" value="Sign me up!" type="submit" data-lang="en"><span>submit</span></button>
								<input class="buttom" name="signup" id="submit" tabindex="5" value="Create" type="submit">
								 <button type="submit" name="signup" id="submit" class="btn btn-primary" value="Create">Create</button>

							</div>
						</div>	
					</div>
					
				</div>		
			</div>	
			</form>			
		</div>

		

		
		<!-- Social links
		================================================== -->
		
		<div class="social-fixed">
			<a href="#" class="hover-target">Class</a>
			<a href="#" class="hover-target">Work</a>
			<a href="#" class="hover-target">Console</a>
		</div>
		<div class="copyr">
			2020 © <a href="http://retronerd.ml" class="hover-target">Design by Retronerd</a>
					</div>
		
		<div class="scroll-to-top hover-target"></div>
		
		<!-- Page cursor
		================================================== -->
		
        <div class='cursor' id="cursor"></div>
        <div class='cursor2' id="cursor2"></div>
        <div class='cursor3' id="cursor3"></div>		
		
	</div>

	
	<!-- JAVASCRIPT
    ================================================== -->
	<script src="js/jquery.min.js"></script>
	<script src="js/popper.min.js"></script> 
	<script src="js/bootstrap.min.js"></script>
	<script src="js/plugins.js"></script> 
	<script src="js/custom.js"></script>  
<!-- End Document
================================================== -->
</body>
</html>