<?php
mb_language('uni');
mb_internal_encoding('UTF-8');

$host = 'localhost';
$db = 'frik';
$user = 'root';
$password = '';

$conn = new mysqli($host, $user, $password, $db);
$conn->query("SET character_set_results=utf8");
$conn->query("set names 'utf8'");

if($_SERVER['REQUEST_METHOD'] === 'POST'){
  $email = $_POST['email'];
  $name = $_POST['name'];
  $message = $_POST['message'];

  //Üzenet mentése az adatbázisba
  $sql = "INSERT INTO chat (email,name,message) VALUES ('$email','$name','$message')";
  $result = $conn->query($sql);
}

$conn->close();
?>