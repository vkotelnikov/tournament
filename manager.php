<!DOCTYPE html>
<html>
<head>
	<title>Manager</title>
	<script src="jquery-3.3.1.min.js"></script>
	<script src="script.js"></script>
	<script src="canvas.js"></script>
	<link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body onload="matches();">
	<ul>
		<li><a href="index.php">Турнир</a></li>
	</ul>
	<div>
	<h3>Список команд</h3>
	<?php 
		require('connect_db.php');

		$query = "SELECT * FROM Teams";
		$result = mysqli_query($db, $query);
		echo "<table>";
		echo "<tr><td>id</td><td>name</td></tr>";
		while ($team = mysqli_fetch_assoc($result))
		{
			echo "<tr id=".$team['id']."><td>".$team['id']."</td><td><span class=\"team\">".$team['name'].'</span></td><td class="delete">Удалить</td></tr>';
		}
		echo "</table>";
	 ?>

	<form action="add_new_team.php" method="POST">
		<label>Добавить команду</label><br>
		<input type="text" name="name" placeholder="Введите название">
		<input type="submit" name="submit" value="ADD">
	</form>
	<h3>Сгенерировать турнир</h3>
	<form action="gen_tournament.php" method="POST">
		<label>Количество команд</label>
		<input type="number" name="count" step="4" required>
		<input type="submit" name="gen" value="Сгенерировать">
	</form>
	</div>
</body>
</html>