<?php
include('../config.php');

$roomidx = $_GET['roomidx'];
$check = 1;

$sql = mysqli_query($db, "SELECT w, k FROM player, users WHERE player.id = users.id AND player.idx = $roomidx");

while($board = mysqli_fetch_array($sql)){
  $w = $board['w'];
  $k = $board['k'];
  if($w == 0 || $k == 0){
    $check = 0;
    break;
  }
}

echo json_encode(array('checking' => $check));
?>
