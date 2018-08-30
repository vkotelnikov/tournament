<!DOCTYPE html>
<html>
<head>
	<title>Adding teams</title>
</head>
<body>

</body>
</html>
<?php
require('connect_db.php');

$query = "INSERT INTO Teams(name) VALUES ('".mysqli_real_escape_string($db, $_POST['name'])."');";

if(mysqli_query($db, $query))
	{
		header('Location:http://'.$_SERVER_['DOCUMENT_ROOT'].'/tournament/manager.php');
	}
else
	{
		echo 'Команда '.$_POST['name'].' не добавлена';
	}
?>