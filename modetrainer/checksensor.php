<?php
include('../config.php');

$roomidx = $_GET['roomidx'];
$playermajor = $_GET['pmajor'];
$sensor = $_GET['sensor'];

$num = 0;
$num2 = 0;

$sql = mysqli_query($db, "SELECT * FROM player, users WHERE player.id = users.id AND users.major = $playermajor AND player.idx = $roomidx");
$board = mysqli_fetch_array($sql);
$playerid = $board['id'];

if($sensor == 1){ //wearable
  $yes_sql = mysqli_query($db, "UPDATE player SET w = 1 WHERE id = $playerid");

  $wear_sql = mysqli_query($db, "SELECT checkT, w FROM player WHERE idx = $roomidx");

  while($wboard = mysqli_fetch_array($wear_sql)){
    $wearable = $wboard['w'];
    $trainercheck = $wboard['checkT'];
    $arr[$num] = array('checkT' => $trainercheck, 'w' => $wearable);
    $num++;
  }
  echo json_encode($arr);
}
else if($sensor == 2){ //kinect
  $no_sql = mysqli_query($db, "UPDATE player SET k = 1 WHERE id = $playerid");

  $kin_sql = mysqli_query($db, "SELECT checkT, k FROM player WHERE idx = $roomidx");

  while($kboard = mysqli_fetch_array($kin_sql)){
    $kinect = $kboard['k'];
    $trainercheck = $kboard['checkT'];
    $arr[$num2] = array('checkT' => $trainercheck, 'k' => $kinect);
    $num2++;
  }
  echo json_encode($arr);
}
?>
