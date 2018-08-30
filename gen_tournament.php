<?php
require('connect_db.php');

function first_round($db ,$i, $teams, $count_teams)
{
	mysqli_query($db, 'DELETE FROM `Matches`;');
		while ($i < $count_teams) {
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
}

function sim_round($db, $i, $j)
{
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
	$j=0;
}

$query = 'SELECT * FROM `Teams` LIMIT '.mysqli_real_escape_string($db, $_POST['count']).';';
$result = mysqli_query($db, $query);
$teams = mysqli_fetch_all($result);
$post_teams = intval($_POST['count']);
$i=0;
var_dump($post_teams);
if ($post_teams <= count($teams)) {

	first_round($db, $i, $teams, $post_teams);

	$i=2;
	$j=0;

	while ($i <= log($post_teams, 2)) {
		sim_round($db, $i, $j);
		$i++;
	}
}

header('Location:manager.php');