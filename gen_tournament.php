<?php
require('connect_db.php');

function delete_matches($db)
{
	mysqli_query($db, 'DELETE FROM `Matches`;');
}

function first_round($db, $count_teams)
{
	delete_matches($db);
	$query = 'SELECT * FROM `Teams` LIMIT '.mysqli_real_escape_string($db, $count_teams).';';
	$result = mysqli_query($db, $query);
	$teams = mysqli_fetch_all($result);
	$i=0;
	if ($count_teams <= count($teams)) {
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
}

function sim_round($db, $i)
{
	$query = 'SELECT * FROM `Matches` WHERE `round` = '.($i-1).';';
	$result = mysqli_query($db, $query);
	$matches = mysqli_fetch_all($result);
	$j = 0;
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
}

function gen_tournament($db){
	$post_teams = intval($_POST['count']);
	if ($post_teams >= 4) {

		first_round($db, $post_teams);

		$i=2;

		while ($i <= log($post_teams, 2)) {
			sim_round($db, $i);
			$i++;
		}
	}
}

if (isset($_POST['del'])) {
	delete_matches($db);
}

if (isset($_POST['gen'])){
	if ($_POST['count'] >= 4) {
		gen_tournament($db);
	}
}

if (isset($_POST['gen_step'])) {
	$query = 'SELECT max(`round`), count(*) FROM `Matches`;';
	$result = mysqli_query($db, $query);
	$current = mysqli_fetch_row($result);
	$current_round = intval($current[0]);
	$matches = intval($current[1]);
	// echo $current_round**2;
	if ($_POST['count'] >= 4) {
		first_round($db, $_POST['count']);
	} else {
		sim_round($db, ($current_round+1));
	}
}

header('Location:manager.php');