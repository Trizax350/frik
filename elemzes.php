<?php
@session_start();
include ("functions.php");

if($_SESSION['loggedin'] != true){
	echo "<p style='color: red; font-weight: bold; font-size: 200%; margin-left: 20px;'>
	Nincs jogosultságod az oldal megtekintéséhez.</p>";
	?><a href="index.php" style="color: blue; font-weight: bold; font-size: 150%; margin-left: 20px;">Vissza a főoldalra.</a><?php
	exit();
}
?>
<html>
	<head>
		<title>Frik feladat - Elemzés</title>
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
		<style>
		    table {
		      border-collapse: collapse;
		      width: 100%;
		    }
		    table td {
		      border: 1px solid black;
		      padding: 5px;
		    }
		</style>
	</head>
	<body align="center">
		<?php top(); ?>
		<div class="container" style="margin-top: 10px; z-index: 5;">
			<?php menu();?>
			<div class="card text-white bg-primary mb-3" style="z-index: 5; margin-top: 10px">
			  	<div class="card-header" style="text-align: center;">Elemzés</div>
			  	<div class="card-body" align="center" style="padding-bottom: 0px;">
		     		<input type="url" class="form-control" id="urlInput" style="max-width: 30rem; margin-bottom: 10px;" 
		     		name="urlInput" placeholder="URL" required>
		    		<button class="btn btn-info" name="submitButton" id="submitButton" style="margin-bottom: 10px;">Szavak keresése</button>
			  	</div>
			</div>
		</div>
		<div id="wordTableContainer"></div>

		<script src="elemzes.js"></script>
	</body>
</html>