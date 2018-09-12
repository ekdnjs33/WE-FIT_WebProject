<?php
include('../config.php');

$roomidx = $_GET['roomidx'];
$playerid = $_GET['playerid'];

$click_sql = mysqli_query($db, "SELECT finish FROM player WHERE idx = $roomidx AND checkT = 0");
$c_board = mysqli_fetch_array($click_sql);
$click = $c_board['finish'];

echo json_encode(array('click' => $click));

?>
