<?php
require('connect_db.php');

$query = 'SELECT DISTINCT `round` FROM `Matches`;';
$result = mysqli_query($db, $query);
$max = mysqli_num_rows($result);
// $max = int(float($max[0]));
// var_dump($max);

$query = 'SELECT * FROM `Teams`;';
$result = mysqli_query($db, $query);
$teams_res = mysqli_fetch_all($result);
$teams = array();
foreach ($teams_res as $key => $value) {
	$teams[$value[0]] = $value[1];
}
// var_dump($teams);

$ret = array('rounds' => $max, 'matches' => ((2**$max)-1), 'teams' => $teams);
for ($round=1; $round <= $max; $round++) { 
	$result = mysqli_query($db, 'SELECT * FROM `Matches` WHERE `round` = '.$round.';');
	while($row = mysqli_fetch_array($result))
		$ret[$round][] = $row;
}

echo json_encode($ret);