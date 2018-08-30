<?php 
require('connect_db.php');

$query = "UPDATE Teams SET name = '".mysqli_real_escape_string($db, $_POST['change_name'])."' WHERE id = ".mysqli_real_escape_string($db, $_POST['change_id']).";";
if(mysqli_query($db, $query))
	header('Location:manager.php');