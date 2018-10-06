<?php
echo '<meta http-equiv="Content-Type" content="text/html" charset="utf-8">';
echo "<body style='background:#f5c94c'>";

include('../config.php');

$playerid = $_GET['playerid'];
$number = $_GET['number'];

if($number == 1){
  $click_sql = mysqli_query($db, "UPDATE basicone SET old_score = score WHERE id = $playerid");

  //echo '<script type = "text/javascript">alert("운동을 종료했습니다.")</script>';
  echo "<meta http-equiv='refresh' content='0; url=BMScoreList1.php'>";
}
else if($number == 2){
  $click_sql = mysqli_query($db, "UPDATE basictwo SET old_score = score WHERE id = $playerid");

  //echo '<script type = "text/javascript">alert("운동을 종료했습니다.")</script>';
  echo "<meta http-equiv='refresh' content='0; url=BMScoreList2.php'>";
}

?>
