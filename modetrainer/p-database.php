<?php
include('../config.php');

$roomidx = $_GET['roomidx'];
$num = 0;

$db_sql = mysqli_query($db, "SELECT * FROM player WHERE idx = $roomidx");

while($board = mysqli_fetch_array($db_sql)){
  $score = $board['score'];
  $checkT = $board['checkT'];
  $arr[$num] = array('checkT' => $checkT, 'score' => $score);
  $num++;
}

echo json_encode($arr);

?>
