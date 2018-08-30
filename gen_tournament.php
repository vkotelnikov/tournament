<?php
require('connect_db.php');

$query = 'SELECT * FROM `Teams` LIMIT '.mysqli_real_escape_string($db, $_POST['count']).';';
$result = mysqli_query($db, $query);
$teams = mysqli_fetch_all($result);
// echo count($teams).'   '.$_POST['count'];
$i=0;
if ($_POST['count'] <= count($teams)) {
	mysqli_query($db, 'DELETE FROM `Matches`;');
// var_dump($teams);
	while ($i < count($teams)) {
		$score_host = rand(0,10);
		$score_guest = rand(0,10);
		if ($score_host > $score_guest) {
			$winner = $teams[$i][0];
		} else {
			$winner = $teams[$i+1][0];
		}
		mysqli_query($db, 'INSERT INTO `Matches`(`round`, `host`, `host_score`, `guest`, `guest_score`, `winner`) VALUES (1, '.$teams[$i][0].', '.$score_host.', '.$teams[($i+1)][0].', '.$score_guest.', '.$winner.');');
		$i+=2;
	}

	$i=2;
	$j=0;

		// var_dump(log(count($teams), 2));
	while ($i <= log(count($teams), 2)) {
		$query = 'SELECT * FROM `Matches` WHERE `round` = '.($i-1).';';
		$result = mysqli_query($db, $query);
		$matches = mysqli_fetch_all($result);
		while ($j < count($matches)) {
			$score_host = rand(0,10);
			$score_guest = rand(0,10);
			if ($score_host > $score_guest) {
				$winner = $matches[$j][6];
			} else {
				$winner = $matches[$j+1][6];
			}
			mysqli_query($db, 'INSERT INTO `Matches`(`round`, `host`, `host_score`, `guest`, `guest_score`, `winner`) VALUES ('.$i.', '.$matches[$j][6].', '.$score_host.', '.$matches[($j+1)][6].', '.$score_guest.', '.$winner.');');
			$j+=2;
		}
		$i++;
		$j=0;
	}
}

header('Location:manager.php');