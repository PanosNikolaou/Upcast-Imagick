<?php
	error_reporting(E_ALL ^ E_DEPRECATED);
	session_start();
	
	define('DB_HOST', 'localhost'); 
	define('DB_NAME', 'upcast'); 
	define('DB_USER','root'); 
	define('DB_PASSWORD',''); 
	
	$con=mysql_connect(DB_HOST,DB_USER,DB_PASSWORD) or die("Failed to connect to MySQL: ".mysql_error()); 
	$db=mysql_select_db(DB_NAME,$con) or die("Failed to connect to MySQL: " . mysql_error()); 

	if(isset($_POST['submit'])) { SignUp(); } 
	
	$msg='';
	
	function newuser() 
	{
		$username = trim($_POST['user']);	
		$firstname = trim($_POST['fname']); 
		$lastname = trim($_POST['lname']); 
		$email = trim($_POST['email']); 
		$password = trim($_POST['pass']); 
		$confirmed_password = trim($_POST['verpass']);
		if($password==$confirmed_password) {
		$query = "INSERT INTO upcast_users (username,firstname,lastname,email,password) VALUES ('$username','$firstname','$lastname','$email','$password')"; 
		$data = mysql_query ($query)or die(mysql_error()); 
		if($data) { $msg = "YOUR REGISTRATION IS COMPLETED..."; echo $msg;
		header("Location: index.php");
		} 
		}else $msg = "Ο κωδικός εισαγωγής με τον κωδικό επαλήθευσης δεν είναι οι ίδιοι"; echo $msg; 
	}

	function SignUp() 
	{ 
		if(!empty($_POST['user']))
		{ 
		$query = mysql_query("SELECT * FROM upcast_users WHERE username = '$_POST[user]'"); 
			if(!$row = mysql_fetch_array($query)) 
			{	
				newuser(); 
			} else { 
			$msg =  "SORRY...YOU ARE ALREADY REGISTERED USER..."; echo $msg;
			}
		} 
	} 

	
?>

<html lang = "en">
   
   <head>
      <title>upcast login</title>
      <link href = "css/bootstrap.min.css" rel = "stylesheet">
      
      <style>
         body {
            padding-top: 0px;
            padding-bottom: 40px;
            background-color: #fff;
         }
         
         .form-signin {
            max-width: 330px;
            padding: 15px;
            margin: 0 auto;
            color: #017572;
         }
         
         .form-signin .form-signin-heading,
         .form-signin .checkbox {
            margin-bottom: 10px;
         }
         
         .form-signin .checkbox {
            font-weight: normal;
         }
         
         .form-signin .form-control {
            position: relative;
            height: auto;
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
            padding: 10px;
            font-size: 16px;
         }
         
         .form-signin .form-control:focus {
            z-index: 2;
         }
         
         .form-signin input[type="email"] {
            margin-bottom: -1px;
            border-bottom-right-radius: 0;
            border-bottom-left-radius: 0;
            border-color:#017572;
         }
         
         .form-signin input[type="password"] {
            margin-bottom: 10px;
            border-top-left-radius: 0;
            border-top-right-radius: 0;
            border-color:#017572;
         }
         
         h2{
            text-align: center;
            color: #017572;
         }
      </style>
      
   </head>
	
   <body>
      
	<nav class="navbar navbar-default">
		<div class="container-fluid">
				<!-- Brand and toggle get grouped for better mobile display -->
				<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				</button>
			<a class="navbar-brand" href="index.php">UpCast</a>
		</div>

		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav">
			</ul>
			<ul class="nav navbar-nav navbar-right">
			<li><a href="login.php">Σύνδεση/Εγγραφή</a></li>
		</ul>
		</div><!-- /.navbar-collapse -->
		</div><!-- /.container-fluid -->
	</nav>
	  
      <h2>Εγγραφή</h2> 
      <div class = "container form-signin"> 

      </div> <!-- /container -->
      <div class = "container">
		 <form class = "form-signin" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
            <h4 class = "form-signin-heading"><?php if(isset($msg))echo $msg; ?></h4>		 
			<input type="text" class = "form-control" name="fname" placeholder = "Όνομα" required></br>
			<input type="text" class = "form-control" name="lname" placeholder = "Επώνυμο" required></br>
			<input type="email" class = "form-control" name="email" placeholder = "email" required></br>
			<input type="text" class = "form-control" name="user" placeholder = "Όνομα χρήστη" required></br>
			<input type="password" class = "form-control" name="pass" placeholder = "Κωδικός" required></br>
			<input type="password" class = "form-control" name="verpass" placeholder = "Επιβεβαίωση κωδικού" required></br>
			<input id="button" class = "btn btn-lg btn-primary btn-block" type="submit" name="submit" value="Εγγραφή">
		</form> 
      </div> 
   </body>
</html>