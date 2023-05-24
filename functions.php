<?php
@session_start();
mb_language('uni');
mb_internal_encoding('UTF-8');

if(!isset($_SESSION['loggedin'])){
	$_SESSION['loggedin'] = false;
	$_SESSION['name'] = "";
	$_SESSION['email'] = "";
	$_SESSION['birthday'] = "";
	$_SESSION['website'] = "";
}

class Connection{
	public $servername = "localhost";
	public $username = "root";
	public $password = "";
	public $dbname = "frik";
	public $conn;

	public function __construct(){
		$this->conn = mysqli_connect($this->servername, $this->username, $this->password, $this->dbname);
		$this->conn->query("SET character_set_results=utf8");
		$this->conn->query("set names 'utf8'");
	}
}

class Register extends Connection{
	public function registratiton($name, $email, $password, $password_again, $birthday, $website){
		$check_email = mysqli_query($this->conn, "SELECT * FROM users WHERE email = '$email'");
		if(mysqli_num_rows($check_email) > 0){
			//Email cím foglalt
			$message_bold = "Sikertelen művelet!";
			$message = " E-mail cím foglalt.";
			$message_type = 1;
			infobox($message_bold, $message, $message_type);
			echo '<script type="text/javascript">', 'infobox();', '</script>';
		} else {
			if($password == $password_again){
				$password = md5($password);

				if(($birthday != "") && ($website != "")){
					$sql = "INSERT INTO users (email,password,name,birthday,website) VALUES ('$email','$password','$name','$birthday','$website')";
				} else if(($birthday != "") && ($website == "")){
					$sql = "INSERT INTO users (email,password,name,birthday) VALUES ('$email','$password','$name','$birthday')";
				} else if(($birthday == "") && ($website != "")){
					$sql = "INSERT INTO users (email,password,name,website) VALUES ('$email','$password','$name','$website')";
				} else if(($birthday == "") && ($website == "")){
					$sql = "INSERT INTO users (email,password,name) VALUES ('$email','$password','$name')";
				}
				
				mysqli_query($this->conn, $sql);

				$message_bold = "Sikeres művelet!";
				$message = " A regisztráció megtörtént.";
				$message_type = 0;
				infobox($message_bold, $message, $message_type);
				echo '<script type="text/javascript">', 'infobox();', '</script>';
			} else {
				//Jelszavak nem egyeznek
				$message_bold = "Sikertelen művelet!";
				$message = " A jelszavak nem egyeznek.";
				$message_type = 1;
				infobox($message_bold, $message, $message_type);
				echo '<script type="text/javascript">', 'infobox();', '</script>';
			}
		}
	}
}

class Profile_data_mod extends Connection{
	public function data_mod($name, $email, $password, $birthday, $website){
		$password = md5($password);
		$check_password = mysqli_query($this->conn, "SELECT * FROM users WHERE password = '$password' AND email = '".$_SESSION["email"]."'");
		if(mysqli_num_rows($check_password) > 0){
			//Jó jelszó lett megadva a felhasználóhoz, módosítás
			if(($birthday != "") && ($website != "")){
				$sql = "UPDATE users SET email = '$email', name = '$name', birthday = '$birthday', website = '$website' WHERE email = '".$_SESSION['email']."'";
			} else if(($birthday != "") && ($website == "")){
				$sql = "UPDATE users SET email = '$email', name = '$name', birthday = '$birthday', website = NULL WHERE email = '".$_SESSION['email']."'";
			} else if(($birthday == "") && ($website != "")){
				$sql = "UPDATE users SET email = '$email', name = '$name', birthday = NULL, website = '$website' WHERE email = '".$_SESSION['email']."'";
			} else if(($birthday == "") && ($website == "")){
				$sql = "UPDATE users SET email = '$email', name = '$name', birthday = NULL, website = NULL WHERE email = '".$_SESSION['email']."'";
			}
			
			mysqli_query($this->conn, $sql);

			$_SESSION['name'] = $name;
			$_SESSION['email'] = $email;
			$_SESSION['birthday'] = $birthday;
			$_SESSION['website'] = $website;

			$message_bold = "Sikeres művelet!";
			$message = " Adatok módosítva.";
			$message_type = 0;
			infobox($message_bold, $message, $message_type);
			echo '<script type="text/javascript">', 'infobox();', '</script>';
		} else {
			$message_bold = "Sikertelen művelet!";
			$message = " Hibás jelszó.";
			$message_type = 1;
			infobox($message_bold, $message, $message_type);
			echo '<script type="text/javascript">', 'infobox();', '</script>';
		}
	}
}

class Password_mod extends Connection{
	public function pass_mod($new_pass, $new_pass_again, $curr_pass){
		$curr_pass = md5($curr_pass);
		$check_password = mysqli_query($this->conn, "SELECT * FROM users WHERE password = '$curr_pass' AND email = '".$_SESSION["email"]."'");
		if(mysqli_num_rows($check_password) > 0){
			//Jó jelszó lett megadva a felhasználóhoz
			if($new_pass == $new_pass_again){
				//Egyeznek a jelszavak
				$new_pass = md5($new_pass);

				$sql = "UPDATE users SET password = '$new_pass' WHERE email = '".$_SESSION['email']."'";
				mysqli_query($this->conn, $sql);

				$message_bold = "Sikeres művelet!";
				$message = " Jelszó módosítva.";
				$message_type = 0;
				infobox($message_bold, $message, $message_type);
				echo '<script type="text/javascript">', 'infobox();', '</script>';
			} else {
				$message_bold = "Sikertelen művelet!";
				$message = " Jelszavak nem egyeznek.";
				$message_type = 1;
				infobox($message_bold, $message, $message_type);
				echo '<script type="text/javascript">', 'infobox();', '</script>';
			}
		} else {
			$message_bold = "Sikertelen művelet!";
			$message = " Hibás jelszó.";
			$message_type = 1;
			infobox($message_bold, $message, $message_type);
			echo '<script type="text/javascript">', 'infobox();', '</script>';
		}
	}
}

function getYears($user_birthday , $current_date , $differenceFormat = '%a' ){
    $datetime1 = date_create($user_birthday);
    $datetime2 = date_create($current_date);
   
    $interval = date_diff($datetime1, $datetime2);
   
    return $interval->format($differenceFormat);
}

class Loginer extends Connection{
	public function login($email, $password){
		$password = md5($password);
		$result = mysqli_query($this->conn, "SELECT * FROM users WHERE email = '$email' AND password = '$password'");
		$row = mysqli_fetch_assoc($result);

		if(mysqli_num_rows($result) > 0){
			$_SESSION['loggedin'] = true;
			$_SESSION['name'] = $row["name"];
			$_SESSION['email'] = $row["email"];
			$_SESSION['birthday'] = $row["birthday"];
			$_SESSION['website'] = $row["website"];

			$message_bold = "Sikeres művelet!";
			$message = " Sikeresen bejelentkezett.";
			$message_type = 0;
			infobox($message_bold, $message, $message_type);
			echo '<script type="text/javascript">', 'infobox();', '</script>';
		} else {
			//Nincs találat
			$message_bold = "Sikertelen művelet!";
			$message = " A meadott e-mail és jelszó páros nem található.";
			$message_type = 1;
			infobox($message_bold, $message, $message_type);
			echo '<script type="text/javascript">', 'infobox();', '</script>';
		}
	}
}

function logout(){
	$_SESSION['loggedin'] = false;
	$_SESSION['name'] = "";
	$_SESSION['email'] = "";
	$_SESSION['birthday'] = "";
	$_SESSION['website'] = "";

	$message_bold = "Sikeres kijelentkezés!";
	$message = "";
	$message_type = 0;
	infobox($message_bold, $message, $message_type);
	echo '<script type="text/javascript">', 'infobox();', '</script>';
}

function infobox($message_bold, $message, $message_type){
	if($message_type == 0){
		?><div class="alert alert-success" id="infobox" style="text-align: center; position: fixed; left: 50%; top: 50%; z-index:10; transform: translate(-50%, -50%); 
			max-width: 20rem; color: black"><strong><?php echo $message_bold; ?></strong><br><?php echo $message;?>
		</div><?php
	} else if($message_type == 1){
		?><div class="alert alert-danger" id="infobox" style="text-align: center; position: fixed; left: 50%; top: 50%; z-index:10; transform: translate(-50%, -50%); 
			max-width: 20rem; color: black"><strong><?php echo $message_bold; ?></strong><br><?php echo $message;?>
		</div><?php
	} else if($message_type == 2){
		?><div class="alert alert-warning" id="infobox" style="text-align: center; position: fixed; left: 50%; top: 50%; z-index:10; transform: translate(-50%, -50%); 
			max-width: 20rem; color: black"><strong><?php echo $message_bold; ?></strong><br><?php echo $message;?>
		</div><?php
	}
}

function menu(){
	?><div class="row">
		<div class="col-sm-12">
			<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
			  	<div class="container-fluid">
			  		<a class="navbar-brand" href="index.php">Frik</a>
			    	<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor01" aria-controls="navbarColor01" 
			    	aria-expanded="false" aria-label="Toggle navigation" style="margin: 10px;">
			      		<span class="navbar-toggler-icon"></span>
			    	</button>
				    <div class="collapse navbar-collapse" id="navbarColor01">
				      	<ul class="navbar-nav me-auto">
				       		<li class="nav-item">
				          		<a class="nav-link" href="index.php">Profil</a>
				        	</li>
				        	<li class="nav-item">
				          		<a class="nav-link" href="elemzes.php">Elemzés</a>
				        	</li>
				        	<li class="nav-item">
				          		<a class="nav-link" href="chat.php">Chat</a>
				        	</li>
				      	</ul>
				    </div>
			  	</div>
			</nav>
		</div>
	</div><?php
}

function top(){
	?><nav class="navbar navbar-expand-lg navbar-dark bg-primary" style="z-index: 5;">			
		<?php echo "<p style='margin: auto; margin-left: 10px'>Bejelentkezve: ".$_SESSION['name']."</p>";?>
		<form method="POST" action="index.php" style="margin: 0px;">
			<button type="submit" name="logout_button" class="btn btn-info" style="margin: 10px;">Kijelentkezés</button>
		</form>
	</nav><?php
}
?>