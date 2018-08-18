<?php
/*DB 접속을 위한 코드*/
$mysql_hostname = "localhost";
$mysql_user = "root";
$mysql_pw = "jamie0507";
$mysql_db = "android_api";

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
}
?>
