<!DOCTYPE html>
<?php include 'connection.php';?>
<?php include 'ver.php';?>

<?php 
if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {

header("location: /dashboard/index.php");
}
?>







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
if (isset($_POST['upload'])) {
require "../gump.class.php";
$gump = new GUMP();
$_POST = $gump->sanitize($_POST); 

$gump->validation_rules(array(
    'title'    => 'required|max_len,60|min_len,3',
    'description'   => 'required|max_len,150|min_len,3',
));
$gump->filter_rules(array(
    'title' => 'trim|sanitize_string',
    'description' => 'trim|sanitize_string',
    ));
$validated_data = $gump->run($_POST);

if($validated_data === false) {
    ?>
    <center><font color="red" > <?php echo $gump->get_readable_errors(true); ?> </font></center>
    <?php 
    $file_title = $_POST['title'];
      $file_description = $_POST['description'];
}
else {
    $file_title = $validated_data['title'];
      $file_description = $validated_data['description'];
if (isset($_SESSION['id'])) {
        $file_uploader = $_SESSION['username'];
        $file_uploaded_to = $_SESSION['course'];
    }

    $file = $_FILES['file']['name'];
    $ext = pathinfo($file, PATHINFO_EXTENSION);
    $validExt = array ('pdf', 'txt', 'doc', 'docx', 'ppt' , 'zip');
    if (empty($file)) {
echo "<script>alert('Attach a file');</script>";
    }
    else if ($_FILES['file']['size'] <= 0 || $_FILES['file']['size'] > 30720000 )
    {
echo "<script>alert('file size is not proper');</script>";
    }
    else if (!in_array($ext, $validExt)){
        echo "<script>alert('Not a valid file');</script>";

    }
    else {
        $folder  = 'allfiles/';
        $fileext = strtolower(pathinfo($file, PATHINFO_EXTENSION) );
        $notefile = rand(1000 , 1000000) .'.'.$fileext;
        if(move_uploaded_file($_FILES['file']['tmp_name'], $folder.$notefile)) {
            $query = "INSERT INTO uploads(file_name, file_description, file_type, file_uploader, file_uploaded_to, file) VALUES ('$file_title' , '$file_description' , '$fileext' , '$file_uploader' , '$file_uploaded_to' , '$notefile')";
            $result = mysqli_query($conn , $query) or die(mysqli_error($conn));
            if (mysqli_affected_rows($conn) > 0) {
                echo "<script> alert('file uploaded successfully.It will be published after admin approves it');
                window.location.href='notes.php';</script>";
            }
            else {
                "<script> alert('Error while uploading..try again');</script>";
            }
        }
    }
}
}
?>

        <!-- Primary Page Layout
        ================================================== -->  

        <div class="shadow-title parallax-top-shadow">Upload</div>
        
        <div class="section padding-page-top padding-bottom over-hide z-bigger">
            <div class="container z-bigger">
                <div class="row page-title px-5 px-xl-2">
                    <div class="col-12 parallax-fade-top">
                        <h1>Upload  </h1>
                    </div>
                    <div class="offset-1 col-11 parallax-fade-top mt-2 mt-sm-3">
                        <p>a new note</p>
                    </div>
                </div>
            </div>
        </div>
        

        <div class="section padding-bottom-big over-hide z-bigger">
            <form role="form" action="" method="POST" enctype="multipart/form-data">
            <div class="container">
                <div class="row px-5 px-xl-2">
                    <div class="col-lg-9">
                        <div class="row ajax-form">
                            <div class="col-md-6">
                               <input type="text" name="title" class="form-control" placeholder="Name of the note"  value = "<?php if(isset($_POST['upload'])) {
                                echo $file_title; } ?>" required="">
                            </div>  
                            <div class="col-md-6 mt-4 mt-md-0">
                                 <input type="text" name="description" class="form-control" placeholder="Enter a short description" value="<?php if(isset($_POST['upload'])) {
            echo $file_description;  } ?>" required="" >
                            </div>  
                            
                            <div class="col-md-12 mt-4">
                                <input type="file" name="file"> 
                                <h1></h1>
                                <button type="submit" name="upload" class="btn btn-primary" value="Upload Note">Upload Note</button>
                                <!-- <button class="hover-target" id="submit" tabindex="5" value="Sign me up!" type="submit" data-lang="en"><span>submit</span></button> -->
                                <!-- <input class="buttom" name="signup" id="submit" tabindex="5" value="Create" type="submit"> -->
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