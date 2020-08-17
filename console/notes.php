<!DOCTYPE html>

<?php include 'includes/connection.php'; ?>

<?php include 'includes/adminheader.php';
?>
<?php 
if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {

header("location: /dashboard/index.php");  //HAS TO BE CHANGED WHEN ON SERVER
}
?>
    <div id="wrapper">
<?php ?>

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

		<!-- Primary Page Layout
		================================================== -->	

<!-- 		<div class="shadow-title parallax-top-shadow">L'Etoile Feb</div>
		
		<div class="section padding-page-top padding-bottom over-hide z-bigger">
			<div class="container z-bigger">
				<div class="row page-title px-5 px-xl-2">
					<div class="col-12 parallax-fade-top">
						<h1>L'Etoile Feb</h1>
					</div>
					<div class="offset-1 col-11 parallax-fade-top mt-2 mt-sm-3">
						<p>fashion, art direction</p>
					</div>
				</div>
			</div>
		</div>
       -->
        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                        <div class="col-xs-4">

           <!--  <button><a href="/dashboard/uploadnote.php" class="btn btn-primary">Add New Note</a></button> -->
            </div>
                         MY NOTES
                        </h1>
                         
<div class="row">
<div class="col-lg-12">
        <div class="table-responsive">

<form action="" method="post">
            <table class="table table-bordered table-striped table-hover">


            <thead>
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Type </th>
                        <th>Uploaded on</th>
                        <th>Status</th>
                        <th>View</th>
                        <th>Delete</th>
                        
                    </tr>
                </thead>
                <tbody>

                 <?php
                 $currentuser = $_SESSION['username'];

$query = "SELECT * FROM uploads WHERE file_uploader= '$currentuser' ORDER BY file_uploaded_on DESC";
$run_query = mysqli_query($conn, $query) or die(mysqli_error($conn));
if (mysqli_num_rows($run_query) > 0) {
while ($row = mysqli_fetch_array($run_query)) {
    $file_id = $row['file_id'];
    $file_name = $row['file_name'];
    $file_description = $row['file_description'];
    $file_type = $row['file_type'];
    $file_date = $row['file_uploaded_on'];
    $file_status = $row['status'];
    $file = $row['file'];

    echo "<tr>";
    echo "<td>$file_name</td>";
    echo "<td>$file_description</td>";
    echo "<td>$file_type</td>";
    echo "<td>$file_date</td>";
    echo "<td>$file_status</td>";
    echo "<td><a href='/dashboard/allfiles/$file' target='_blank' style='color:green'>View </a></td>";
    echo "<td><a onClick=\"javascript: return confirm('Are you sure you want to delete this post?')\" href='?del=$file_id'><i class='fa fa-times' style='color: red;'></i>delete</a></td>";

    echo "</tr>";

}
}
else {
    echo "<script>alert('No notes yet! Start uploading now');
    window.location.href= 'newnote.php';</script>";
}
?>


                </tbody>
            </table>
</form>
</div>
</div>
</div>
 <?php
 
    if (isset($_GET['del'])) {
        $note_del = mysqli_real_escape_string($conn, $_GET['del']);
        $file_uploader = $_SESSION['username'];
        $del_query = "DELETE FROM uploads WHERE file_id='$note_del' AND file_uploader = '$file_uploader' ";
        $run_del_query = mysqli_query($conn, $del_query) or die (mysqli_error($conn));
        if (mysqli_affected_rows($conn) > 0) {
            echo "<script>alert('note deleted successfully');
            window.location.href='notes.php';</script>";
        }
        else {
         echo "<script>alert('error occured.try again!');</script>";   
        }
        }
   ?>    
<button onclick="window.location.href = 'newnote.php';">New note</button>

 <script src="js/jquery.js"></script>

    
    <script src="js/bootstrap.min.js"></script>




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