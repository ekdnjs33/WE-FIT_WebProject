<?php
include('../config.php');

$roomidx = $_GET['roomidx'];
$sensor = $_GET['sensor'];

$num = 0;
$num2 = 0;

if($sensor == 1){ //wearable
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
