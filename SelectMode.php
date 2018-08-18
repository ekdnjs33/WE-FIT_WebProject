<?php
include('lock.php');
?>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>WE FIT - SelectMode</title>
  <link href="css/selectmode.css" rel="stylesheet"></link>
</head>
<body>
  <div id="top">
    <a class="mode-url" href="index.html" style="color:black">
    <br><img src="logo.png" alt="we fit 로고" width="7%" align="center"><?php echo " $login_session 님 안녕하세요!"; ?></a>
    <!--<p align="right" style="margin-top:20px; margin-right:70px"><a href="logout.php"><input class="make" type="button" value="로그아웃"/></a></p>-->
  </div>
  <div id="bottom">
    <a class="mode-url" href="TrainerMode.php">
      <div class="mode"><p>트레이너 모드(Trainer Mode)</p>
      </div>
    </a>
    <a class="mode-url" href="BasicMode.html">
      <div class="mode"><p>기본 모드(Basic Mode)</p>
      </div>
    </a>
  </div>
</body>
</html>
