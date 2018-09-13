<?php
include('../config.php');

$roomidx = $_GET['roomidx'];
$playerid = $_GET['playerid'];

$sql = mysqli_query($db, "SELECT checkT FROM player WHERE idx = $roomidx AND id = $playerid");

$board = mysqli_fetch_array($sql);
$trainercheck = $board['checkT'];

echo json_encode(array('checkT' => $trainercheck));
?>
