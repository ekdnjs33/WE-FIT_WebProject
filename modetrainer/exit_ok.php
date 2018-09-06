<?php
/*자신이 속한 방(TMEntrance)에서 나가는 코드*/
echo '<meta http-equiv="Content-Type" content="text/html" charset="utf-8">';
echo "<body style='background:#f5c94c'>";

include('../lock.php');

//방 나가기(player목록에서 삭제)
$outid = $row['id'];
$roomout = $_GET['roomidx'];
$res_out = mysqli_query($db, "DELETE FROM player WHERE idx = $roomout AND id = $outid");
if($res_out == 1){
  echo '<script type = "text/javascript">alert("방을 나갔습니다.")</script>';
  echo "<meta http-equiv='refresh' content='0; url=TrainerMode.php'>";
}
else{
  echo '<script type = "text/javascript">alert("방을 나가지 못했습니다.")</script>';
  echo "<meta http-equiv='refresh' content='0; url=/'>";
}
?>
