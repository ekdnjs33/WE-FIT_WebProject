<?php
/*로그인 시, 아이디나 비밀번호가 존재하는지를 검사하는 코드*/
echo '<meta http-equiv="Content-Type" content="text/html" charset="utf-8">';
echo "<body style='background:#f5c94c'>";
include("config.php");
session_start();

if($_POST["userid"] != ""){ //index에서 가져오는 부분
  $myuserid=$_POST["userid"];
  $myuserpw=$_POST["userpw"];

  $sql="SELECT * FROM users WHERE email='".$myuserid."'";

  $result=mysqli_query($db, $sql);

  $user=mysqli_fetch_array($result);

  $salt=$user['salt'];
  $encrypted_password=$user['encrypted_password'];

  $hash = base64_encode(sha1($myuserpw . $salt, true) . $salt);

  if ($encrypted_password == $hash) {
      // user authentication details are correct
    $count=1;
  }else{
    $count=0;
  }
  //Testing
  //echo "$count";

  if($count==1){
    $_SESSION['login_user']=$myuserid;
    header("Location:SelectMode.php");//선택모드 화면으로 넘어감
    //Testing
    //echo " 존재함";
  }else{
    echo '<script type ="text/javascript">alert("아이디 또는 비밀번호를 잘못 입력하셨습니다.")</script>';
    //echo "$salt  $encrypted_password  $hash";
    echo "<meta http-equiv='refresh' content='0; url=index.html'>";
    //Testing
    //echo " 존재하지 않음";
  }
}
?>
