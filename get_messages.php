<?php
@session_start();
mb_language('uni');
mb_internal_encoding('UTF-8');

$host = 'localhost';
$db = 'frik';
$user = 'root';
$password = '';

$conn = new mysqli($host, $user, $password, $db);
$conn->query("SET character_set_results=utf8");
$conn->query("set names 'utf8'");

$sql = 'SELECT * FROM chat ORDER BY sending_time ASC';
$result = $conn->query($sql);

if($result->num_rows > 0){
  while($row = $result->fetch_assoc()){
    if($row['name'] == $_SESSION['name']){
      echo '<p style="color: black; border: 1px solid black; background-color: lightblue; border-radius: 10px; margin: 0px; float: right; padding: 10px;">
      <strong>'.$row['name'].', '.str_replace("-", "/", $row['sending_time']).'</strong>:<br>'.$row['message'].'</p><br><br><br><br>';
    } else {
      echo '<p style="color: black; border: 1px solid black; background-color: lightgrey; border-radius: 10px; margin: 0px; float: left; padding: 10px;">
      <strong>'.$row['name'].', '.str_replace("-", "/", $row['sending_time']).'</strong>:<br>'.$row['message'].'</p><br><br><br><br>';
    }
  }
}

$conn->close();
?>
