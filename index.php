<?php
@session_start();
include ("functions.php");

$current_date = date("Y-m-d");

$login = new Loginer();

$profile_mod = new Profile_data_mod();

$password_mod = new Password_mod();

if(isset($_POST['login_button'])){
	$result = $login->login($_POST['email'], $_POST['password']);
}

if(isset($_POST['logout_button'])){
	logout();
}

if(isset($_POST['profile_mod_button'])){
	$result = $profile_mod->data_mod($_POST['name'], $_POST['email'], $_POST['password'], $_POST['birthday'], $_POST['website']);
}

if(isset($_POST['password_mod_button'])){
	$result = $password_mod->pass_mod($_POST['new_pass'], $_POST['new_pass_again'], $_POST['curr_pass']);
}
?>
<html>
	<head>
		<title>Frik feladat</title>
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
	<body align="center">
		<?php
		if($_SESSION['loggedin'] == false){
			//Nincs bejelentkezés
			?>
			<div class="card text-white bg-primary mb-3" style="max-width: 20rem; margin: auto; top: 10%; z-index: 5;">
			  	<div class="card-header" style="text-align: center;">Bejelentkezés</div>
			  	<div class="card-body" align="center" style="padding-bottom: 10px;">
			  		<form method="POST">
			     		<input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
			      		<input type="password" style="margin-top: 10px;" class="form-control" id="password" name="password" placeholder="Jelszó" required>
			    		<button type="submit" class="btn btn-info" name="login_button" style="margin-top: 10px; margin-bottom: 0px;">Bejelentkezés</button>
					</form>
					Nincs még fiókod? <a href="registration.php" target="_blank" style="color: #66C4E0"><i>Regisztráció</i></a>
			  	</div>
			</div>
			<?php
		} else {
			//Van bejelentkezés
			top();
			?>
			<div class="container" style="margin-top: 10px; z-index: 5;">	
				<?php menu();?>
				<div class="row">
					<div class="col-sm-6">
						<div class="card text-white bg-primary mb-3" style="z-index: 5; margin-top: 10px">
						  	<div class="card-header" style="text-align: center;">Felhasználói adatok módosítása</div>
						  	<div class="card-body" align="center" style="padding-bottom: 10px;">
						  		<svg xmlns="http://www.w3.org/2000/svg" width="160" height="160" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
								  <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
								  <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>
								</svg>
								<?php 
								if($_SESSION['birthday'] != ""){
									echo "<p style='font-size: 150%; margin: 10px'>Életkor: ".getYears($_SESSION['birthday'], $current_date, '%y')."</p>";
								}
								?>
						  		<form method="POST" style="margin-top: 10px">
						     		<input type="text" class="form-control" id="name" name="name" placeholder="Név" value="<?php echo $_SESSION['name'] ?>" required>
						     		<input type="email" style="margin-top: 10px;" class="form-control" id="email" name="email" placeholder="Email" 
						     		value="<?php echo $_SESSION['email'] ?>" required>
						     		<label for="birthday" style="margin-top: 10px; float: left">Születési dátum</label>
		      						<input type="date" class="form-control" id="birthday" name="birthday" min="1900-01-01" max="<?php echo $current_date;?>" 
		      						value="<?php echo $_SESSION['birthday'] ?>">
						     		<input type="url" style="margin-top: 10px;" class="form-control" id="website" name="website" placeholder="Weboldal" 
						     		value="<?php echo $_SESSION['website'] ?>">
						     		<label for="birthday" style="margin-top: 20px; float: left">A módosításhoz add meg jelszavad</label>
						      		<input type="password" style="margin-top: 10px;" class="form-control" id="password" name="password" placeholder="Jelszó" required>
						    		<button type="submit" class="btn btn-info" name="profile_mod_button" style="margin-top: 10px; margin-bottom: 0px;">Adatok módosítása</button>
								</form>
						  	</div>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="card text-white bg-primary mb-3" style="z-index: 5; margin-top: 10px">
						  	<div class="card-header" style="text-align: center;">Jelszó módosítása</div>
						  	<div class="card-body" align="center" style="padding-bottom: 10px;">
						  		<svg xmlns="http://www.w3.org/2000/svg" width="160" height="160" fill="currentColor" class="bi bi-shield-lock" viewBox="0 0 16 16">
								  <path d="M5.338 1.59a61.44 61.44 0 0 0-2.837.856.481.481 0 0 0-.328.39c-.554 4.157.726 7.19 2.253 9.188a10.725 10.725 0 0 0 2.287 2.233c.346.244.652.42.893.533.12.057.218.095.293.118a.55.55 0 0 0 .101.025.615.615 0 0 0 .1-.025c.076-.023.174-.061.294-.118.24-.113.547-.29.893-.533a10.726 10.726 0 0 0 2.287-2.233c1.527-1.997 2.807-5.031 2.253-9.188a.48.48 0 0 0-.328-.39c-.651-.213-1.75-.56-2.837-.855C9.552 1.29 8.531 1.067 8 1.067c-.53 0-1.552.223-2.662.524zM5.072.56C6.157.265 7.31 0 8 0s1.843.265 2.928.56c1.11.3 2.229.655 2.887.87a1.54 1.54 0 0 1 1.044 1.262c.596 4.477-.787 7.795-2.465 9.99a11.775 11.775 0 0 1-2.517 2.453 7.159 7.159 0 0 1-1.048.625c-.28.132-.581.24-.829.24s-.548-.108-.829-.24a7.158 7.158 0 0 1-1.048-.625 11.777 11.777 0 0 1-2.517-2.453C1.928 10.487.545 7.169 1.141 2.692A1.54 1.54 0 0 1 2.185 1.43 62.456 62.456 0 0 1 5.072.56z"/>
								  <path d="M9.5 6.5a1.5 1.5 0 0 1-1 1.415l.385 1.99a.5.5 0 0 1-.491.595h-.788a.5.5 0 0 1-.49-.595l.384-1.99a1.5 1.5 0 1 1 2-1.415z"/>
								</svg>
						  		<form method="POST" style="margin-top: 10px">
						     		<input type="password" minlength="8" maxlength="50" style="margin-top: 10px;" class="form-control" id="new_pass" 
						     		name="new_pass" placeholder="Új jelszó" required>
						      		<input type="password" minlength="8" maxlength="50" style="margin-top: 10px;" class="form-control" id="new_pass_again" 
						      		name="new_pass_again" placeholder="Új jelszó újra" required>
						      		<input type="password" style="margin-top: 10px;" class="form-control" id="curr_pass" name="curr_pass" 
						      		placeholder="Jelenlegi jelszó" required>
						    		<button type="submit" class="btn btn-info" name="password_mod_button" style="margin-top: 10px; margin-bottom: 0px;">
						    		Jelszó módosítása</button>
								</form>
						  	</div>
						</div>
					</div>
				</div>
			</div><?php
		}
		?>
	</body>
</html>