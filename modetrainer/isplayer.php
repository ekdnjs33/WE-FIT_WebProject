<?php
include('../config.php');

$roomidx = $_GET['roomidx'];
$playerid = $_GET['playerid'];
$num = 0;

$sql = mysqli_query($db, "SELECT checkT, email FROM player, users WHERE player.id = users.id AND player.idx = $roomidx");

while($board = mysqli_fetch_array($sql)){
  $playerid = $board['email'];
  $trainercheck = $board['checkT'];
  $arr[$num] = array('checkT' => $trainercheck, 'email' => $playerid);
  $num++;
}

echo json_encode($arr);
?>
