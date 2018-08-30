<?php
require('connect_db.php');

$query = "DELETE FROM Teams WHERE id = ".mysqli_real_escape_string($db, $_POST['id']).";";
if(mysqli_query($db, $query))
	echo true;