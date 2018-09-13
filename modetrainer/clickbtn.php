<?php
include('../config.php');

$roomidx = $_GET['roomidx'];
$playerid = $_GET['playerid'];

$sql = mysqli_query($db, "UPDATE player SET click = 1 WHERE id = $playerid");

?>
