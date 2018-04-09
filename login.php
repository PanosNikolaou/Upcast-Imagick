<?php
	error_reporting(E_ALL ^ E_DEPRECATED);
	session_start();
	define('DB_HOST', 'localhost'); 
	define('DB_NAME', 'upcast'); 
	define('DB_USER','root'); 
	define('DB_PASSWORD',''); 

	$con=mysql_connect(DB_HOST,DB_USER,DB_PASSWORD) or die("Failed to connect to MySQL: ".mysql_error()); 
	$db=mysql_select_db(DB_NAME,$con) or die("Failed to connect to MySQL: " . mysql_error()); 
	
	function FindUser() 
	{ 
	if(!empty($_POST['user'])) //checking the 'user' name which is from Sign-Up.html, is it empty or have some text 
	{ $query = mysql_query("SELECT * FROM upcast_users WHERE userName = '$_POST[username]' AND password = '$_POST[password]'") or die(mysql_error()); 
	if(!$row = mysql_fetch_array($query) or die(mysql_error())) 
	{ echo "Welcome"; 
	// Set session variables
	$_SESSION["userid"] = $_POST['username'];
	echo "Session variables are set.";
	} else { echo "SORRY...YOU ARE ALREADY REGISTERED USER..."; } } 
	} 
	
	function redirect_to( $location = NULL ) {
		if ($location != NULL) {
			header("Location: {$location}");
			exit;
		}
	}
	
	function confirm_query($result_set) {
		if (!$result_set) {
			die("Database query failed: " . mysql_error());
		}
	}
	
?>

<html lang = "en">
   
   <head>
      <title>upcast login</title>
      <link href = "css/bootstrap.min.css" rel = "stylesheet">
          <link href="css/sticky-footer.css" rel="stylesheet">

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
	  	<li><a href="search.php">Αναζήτηση φωτογραφιών</a></li>
		<li><a href="searchmapphotos.php">Αναζήτηση φωτογραφιών σε χάρτη</a></li>
		<li><a href="topfive.php">Κορυφαίες εικόνες</a></li>
		<li><a href="login.php">Σύνδεση/Εγγραφή</a></li>
		<li><a href="contactus.php">Επικοινωνήστε μαζί μας</a></li>		</ul>
		</div><!-- /.navbar-collapse -->
		</div><!-- /.container-fluid -->
		</nav>

      <h2>Σύνδεση</h2> 
      <div class = "container form-signin">
         
         <?php
            $msg = '';
            
            if (isset($_POST['login']) && !empty($_POST['username']) && !empty($_POST['password'])) {
				$user_query = mysql_query("SELECT * FROM upcast_users WHERE username = '$_POST[username]' AND password = '$_POST[password]' LIMIT 1");
				//print_r($user_query);
				if (mysql_num_rows($user_query) == 1) {
				$found_user = mysql_fetch_array($user_query);
				$_SESSION["userid"] = $_POST['username'];  //uuid
				//echo $_SESSION["userid"];
				redirect_to("loggedindex.php");
				$msg = 'user found';
				}else {
                  $msg = 'Wrong username or password';
               }
            }
         ?>
      </div> <!-- /container -->
      
      <div class = "container">
		 <form class = "form-signin" action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">
            <h4 class = "form-signin-heading"><?php echo $msg; ?></h4>
            <input type = "text" class = "form-control" name = "username" placeholder =  "Όνομα χρήστη" required autofocus></br>
            <input type = "password" class = "form-control" name = "password" placeholder = "Κωδικός" required>
            <button class = "btn btn-lg btn-primary btn-block" type = "submit" name = "login">Σύνδεση</button>
         </form>
		<a class = "form-signin-heading" href="reg.php">Εγγραφή νέου χρήστη</a>
      </div> 
      
   </body>
</html>