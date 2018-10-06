<?php
/*로그인이 성공적으로 이루어지지 않았을 경우 초기 화면으로 이동*/
include('config.php');
session_start();
$user_check = $_SESSION['login_user'];

$ses_sql = mysqli_query($db, "SELECT * FROM users WHERE email = '".$user_check."'");

$row = mysqli_fetch_array($ses_sql);

$login_session = $row['email'];
$player_major = $row['major'];

if(!isset($login_session)){
  header("Location: index.html");
}
?>
