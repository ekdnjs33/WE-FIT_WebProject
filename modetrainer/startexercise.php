<?php
include('../config.php');

$roomidx = $_GET['roomidx'];
$playerid = $_GET['playerid'];

$click_sql = mysqli_query($db, "SELECT click FROM player WHERE idx = $roomidx AND checkT = 0");
$c_board = mysqli_fetch_array($click_sql);
$click = $c_board['click'];

$checkt_sql =  mysqli_query($db, "SELECT checkT FROM player WHERE idx = $roomidx AND id = $playerid");
$t_board = mysqli_fetch_array($checkt_sql);
$checkT = $t_board['checkT'];

echo json_encode(array('click' => $click, 'checkT' => $checkT));

?>
