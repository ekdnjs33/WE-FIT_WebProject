<?php
include('lock.php');
?>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>WE FIT - SelectMode</title>
  <link href="newcss/selectmode.css" rel="stylesheet"></link>
</head>
<body>
  <div id="top">
    <a class="mode-url" href="../logout_ok.php">
    <br><img src="img/logo.png" alt="we fit 로고" width="7%" align="center"><?php echo " $login_session 님 안녕하세요!"; ?></a>
  </div>
  <div id="bottom">
    <a class="mode-url" href="modetrainer/TrainerMode.php">
      <div class="mode"><p>트레이너 모드(Trainer Mode)</p>
      </div>
    </a>
    <a class="mode-url" href="modebasic/BasicMode.php">
      <div class="mode"><p>기본 모드(Basic Mode)</p>
      </div>
    </a>
  </div>
</body>
</html>
