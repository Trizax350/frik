<?php
@session_start();
include ("functions.php");

$current_date = date("Y-m-d");

$register = new Register();
if(isset($_POST['registration_button'])){
	$result = $register->registratiton($_POST['name'], $_POST['email'], $_POST['password'], $_POST['password_again'], $_POST['birthday'], $_POST['website']);
}
?>
<html>
	<head>
		<title>Frik feladat - Regisztráció</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="author" content="Hajnal Róbert Dávid">
		<meta name="copyright" content="Hajnal Róbert Dávid">
		<meta name="distribution" content="local">
		<meta name="language" content="HU">
		<meta http-equiv="Content-Type" content="text/html; charset=windows-1250">
		<meta name="rating" content="general">

		<link rel="shortcut icon" type="image/png" href="frikfvcn.png"/>
		<link rel="stylesheet" href="css/bootstrap.css">
		<script src="js/bootstrap.js"></script>
		<script src="jquery/jquery.min.js"></script>
		<script src="js/functions.js"></script>
	</head>
	<body>
		<div class="card text-white bg-primary mb-3" style="margin: auto; margin-top:10px; width: 30rem">
		  	<div class="card-header" style="text-align: center;">Regisztráció</div>
		  	<div class="card-body" align="center" style="padding-bottom: 0px;">
		  		<form method="POST">
		     		<input type="text" class="form-control" id="name" name="name" placeholder="Név" required>
		     		<input type="email" style="margin-top: 10px;" class="form-control" id="email" name="email" placeholder="Email" required>
		      		<input type="password" minlength="8" maxlength="50" style="margin-top: 10px;" class="form-control" id="password" name="password" 
		      		placeholder="Jelszó" required>
		      		<input type="password" minlength="8" maxlength="50" style="margin-top: 10px;" class="form-control" id="password_again" name="password_again" 
		      		placeholder="Jelszó újra" required>
		      		<label for="birthday" style="margin-top: 10px; float: left">Születési dátum</label>
		      		<input type="date" class="form-control" id="birthday" name="birthday" min="1900-01-01" max="<?php echo $current_date;?>">
		      		<input type="url" style="margin-top: 10px;" class="form-control" id="website" name="website" placeholder="Weboldal">
		    		<button type="submit" class="btn btn-info" name="registration_button" style="margin-top: 10px; margin-bottom: 0px;">Regisztráció</button>
				</form>
		  	</div>
		</div>
	</body>
</html>