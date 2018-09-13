<?php
include('../config.php');

$roomidx = $_GET['roomidx'];
$playermajor = $_GET['pmajor'];
$sensor = $_GET['sensor'];

$sql = mysqli_query($db, "SELECT * FROM player, users WHERE player.id = users.id AND users.major = $playermajor AND player.idx = $roomidx");
$board = mysqli_fetch_array($sql);
$playerid = $board['id'];

if($sensor == 1){ //wearable
  $yes_sql = mysqli_query($db, "UPDATE player SET w = 1 WHERE id = $playerid");
}
else if($sensor == 2){ //kinect
  $no_sql = mysqli_query($db, "UPDATE player SET k = 1 WHERE id = $playerid");
}
?>
