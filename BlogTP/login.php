<?php 
//author : Younes zaidi
    session_start();
    if(isset($_POST['username']) && isset($_POST['password'])){
		include('config.php');
		$db    = config::_connection();
	    if($db){
		   $users = config::_select($db,'select * from users where login = "'.trim($_POST['username']).'" and pass = "'.trim($_POST['password']).'" ');
		   if($users){
			  $_SESSION['id']       = current($users)['id'];
			  $_SESSION['Username'] = current($users)['login'];
			  $_SESSION['Type']     = current($users)['function'];
			  header('Location: /BlogTp/index.php');
			  exit;
		   }else{
			   header('Location: /BlogTp/login.php');
			   exit;
		   }
		}else{
			header('Location: localhost/BlogTp/login.php');
			exit;
		}
	}
	if(isset($_SESSION['Username'])){
		header('Location: /BlogTp/index.php');
		exit;
	}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Blog - Login</title>
    <meta name="keywords"     content=""/>
    <meta name="description"  content=""/>
    <meta name="author"       content="Younes zaidi"/>
    <meta name="viewport"     content="width=device-width, initial-scale=1.0"/>
    <link rel="stylesheet"    href="/BlogTp/css/materialdesignicons.min.css"/>
    <link rel="stylesheet"    href="/BlogTp/css/vendor.bundle.base.css"/>
    <link rel="stylesheet"    href="/BlogTp/css/vendor.bundle.addons.css"/>
    <link rel="stylesheet"    href="/BlogTp/css/style.css"/>
    <link rel="shortcut icon" href="/BlogTp/images/favicon.png"/>

</head>
<body class="external-page sb-l-c sb-r-c">
<div id="main" class="animated fadeIn">
	  <style type="text/css">
	   @media screen and (min-width: 500px) {#andApp {display: none;}}
      </style>
<section id="content_wrapper">
 <section id="content">
 <form method="post" action="/BlogTp/login.php" id="login">
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper auth-page">
      <div class="content-wrapper d-flex align-items-center auth auth-bg-1 theme-one">
        <div class="row w-100">
          <div class="col-lg-4 mx-auto">
            <div class="auto-form-wrapper">
              <form action="#">
                <div class="form-group">
                  <label class="label">Username</label>
                  <div class="input-group">
                    <input type="text" class="form-control" name="username" id="username" placeholder="Username">
                    <div class="input-group-append">
                      <span class="input-group-text">
                        <i class="mdi mdi-check-circle-outline"></i>
                      </span>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label class="label">Password</label>
                  <div class="input-group">
                    <input type="password" name="password" id="password"  class="form-control" placeholder="*********">
                    <div class="input-group-append">
                      <span class="input-group-text">
                        <i class="mdi mdi-check-circle-outline"></i>
                      </span>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <button class="btn btn-primary submit-btn btn-block" type="submit" name="login">Login</button>
                </div>
                <div class="form-group d-flex justify-content-between">
                  <div class="">
                    <label class="form-check-label">
                      <a  class="form-check-input"  href='index.php'> Go to Blog !! </a>
                    </label>
                  </div>
                  <a href="" class="text-small forgot-password text-black" title='Contact use Pleas !!'>Forgot Password </a>
                </div>
              </form>
            </div>
            <ul class="auth-footer">
              <li>
                <a href="#">Conditions</a>
              </li>
              <li>
                <a href="#">Help</a>
              </li>
              <li>
                <a href="#">Terms</a>
              </li>
            </ul>
            <p class="footer-text text-center">copyright © 2019 Younes Zaidi. All rights reserved.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
 </form>
 </section>
</section>
</div>
  <script src="/BlogTp/js/vendor.bundle.base.js"></script>
  <script src="/BlogTp/js/vendor.bundle.addons.js"></script>
  <script src="/BlogTp/js/off-canvas.js"></script>
  <script src="/BlogTp/js/misc.js"></script>
</body>
</html>