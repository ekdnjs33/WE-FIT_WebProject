<?php
/*트레이너 모드에서 방을 생성하는 코드*/
echo '<meta http-equiv="Content-Type" content="text/html" charset="utf-8">';
echo "<body style='background:#f5c94c'>";
include('lock.php');

date_default_timezone_set("Asia/Seoul");//서울시간

$date=date('Y-m-d H:i');
$roompw=$_POST['roompw'];
//비밀번호 암호화
//password_hash($_POST['roompw'], PASSWORD_DEFAULT);
$title=$_POST['roomname'];

//Testing
//echo "$date";
//echo "$roompw";
//echo "$title";
//echo "$login_session";

$sql="INSERT INTO triroom(createrid, roompw, title, createdate) VALUES('".$user_check."', '".$roompw."', '".$title."', '".$date."')";
$res=mysqli_query($db, $sql);

if($res==1){
  echo '<script type = "text/javascript">alert("방이 생성되었습니다.")</script>';
  echo "<meta http-equiv='refresh' content='0; url=TrainerMode.php'>";
}
else{
  echo '<script type = "text/javascript">alert("방이 생성되지 않았습니다. 다시 생성해주세요!")</script>';
  echo "<meta http-equiv='refresh' content='0; url=TrainerMode.php'>";
}
?>
