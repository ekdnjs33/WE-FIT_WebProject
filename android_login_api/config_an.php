<?php
/*14.49.37.187 DB 접속을 위한 코드*/
$mysql_hostname = "localhost";
$mysql_user = "root";
$mysql_pw = "dawon";
$mysql_db = "wefit";

$db = mysqli_connect($mysql_hostname, $mysql_user, $mysql_pw, $mysql_db);

if(mysqli_connect_errno()){
  echo "Could not connect: ".mysqli_connect_error();
  exit();
}
/*
if(!$db){
  die('MySQL connect ERROR: '.mysqli_error());
}else{
  echo "MySQL 연결 완료!";
}*/
?>
