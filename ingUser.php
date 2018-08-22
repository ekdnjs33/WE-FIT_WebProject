<?php
include('lock.php');

$roomtitle=$_GET['roomtitle'];
$roomidx=$_GET['roomidx'];
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta http-equiv="Content-Type" content="text/html" charset="utf-8">
    <title>ingUser</title>
    <script src="js/jquery.js"></script>
    <link href="css/inguser.css" rel="stylesheet"></link>
    <script src="js/countdown.js"></script>
  </head>
  <body>
    <div class="wrapper">
      <div class="one">10초 후에 운동을 시작합니다.</div>
      <div class="two1">트레이너 영상</div>
      <div class="two2">
        <div class="resultshow">
          <p id="down" class="countdown">10</p>
          <p class="now">현재 순위</p>
          <p class="rank">1</p>
          <p class="now">내 점수</p>
          <p class="score">90</p>
        </div>
        <div class="stopbtn">
          <a href="exit_ok.php?<?php echo "roomidx=$roomidx"; ?>"><input class="finish" type="button" value="중단하기"></a>
        </div>
      </div>
      <div class="two3">사용자 영상</div>
    </div>
  </body>
</html>
