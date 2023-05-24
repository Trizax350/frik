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
		<title>Frik feladat - Chat</title>
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
		<?php top();?>
		<div class="container" style="margin-top: 10px; z-index: 5;">
			<?php menu();?>
		</div>
		<div class="card text-white bg-primary mb-3" style="z-index: 5; margin: auto; margin-top: 10px; max-width: 45rem;">
		  	<div class="card-header" style="text-align: center;">Chat</div>
		  	<div class="card-body" id="chatbox" align="center" style="padding-bottom: 0px;">
		  		<div class="card-body" id="messages" style="padding-bottom: 0px; background-color: white; height: 30rem; border-radius: 5px; overflow: auto;"></div>
	     		<input type="text" class="form-control" id="message" style="max-width: 20rem; margin: 10px; display: inline;" 
	     		name="message" placeholder="Üzenet" required>
	     		<input type="hidden" class="form-control" id="email" style="max-width: 20rem; margin: 10px; display: inline;" 
	     		name="email" value="<?php echo $_SESSION['email'] ?>">
	     		<input type="hidden" class="form-control" id="name" style="max-width: 20rem; margin: 10px; display: inline;" 
	     		name="name" value="<?php echo $_SESSION['name'] ?>">
	    		<button class="btn btn-info" name="send_message_button" id="send_message_button" 
	    		style="margin: 0px; width: 3rem; height: 3rem; border-radius: 35px;">
	    			<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-send-fill" viewBox="0 0 16 16">
					  <path d="M15.964.686a.5.5 0 0 0-.65-.65L.767 5.855H.766l-.452.18a.5.5 0 0 0-.082.887l.41.26.001.002 4.995 3.178 3.178 4.995.002.002.26.41a.5.5 0 0 0 .886-.083l6-15Zm-1.833 1.89L6.637 10.07l-.215-.338a.5.5 0 0 0-.154-.154l-.338-.215 7.494-7.494 1.178-.471-.47 1.178Z"/>
					</svg>
				</button>
		  	</div>
		</div>

		<script src="chat.js"></script>
	</body>
</html>