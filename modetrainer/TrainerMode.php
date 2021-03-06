<?php
include('../lock.php');

$number=0; //방 번호
?>
<!doctype html>
<html>
  <head>
    <!--3초마다 방 목록 새로고침-->
    <meta http-equiv=refresh content='3; url='>
    <meta http-equiv="Content-Type" content="text/html" charset="utf-8">
    <title>WE FIT - TrainerMode</title>
    <link href="../css/trainermode.css" rel="stylesheet"></link>
    <script src="../js/jquery.js"></script>
  </head>
  <body>

    <div id="top">
      <a href="../SelectMode.php">
        <br><img src="../img/logo.png" alt="we fit 로고" width="7%" align="center"> 트레이너 모드입니다!
      </a>
      <p align="right" style="margin-top:20px; margin-right:70px; margin-bottom:40px"><a href="CreateRoom.php"><input class="make" type="button" value="방 생성하기"/></a>
      </p>
    </div>

    <center>
      <div id="bottom">
        <table width="91%">
          <!--<caption style="margin-bottom: 10px; padding:15px; font-size: 20pt;">전체 방 목록</caption>-->
          <colgroup>
            <col width="8%">
            <col width="55%">
            <col width="17%">
            <col width="20%">
          </colgroup>
          <thead>
            <tr style="background:#b2afa6">
              <td>번호</td>
              <td>방 이름</td>
              <td>트레이너</td>
              <td>생성시간</td>
            </tr>
          </thead>
          <?php $sql = mysqli_query($db, "SELECT * FROM triroom ORDER BY idx DESC LIMIT 0,7");
          while($board = mysqli_fetch_array($sql)){
            $title = $board['title'];
            $idx = $board['idx'];
            $trainer = $board['createrid'];
            $number += 1;
          ?>
          <tbody>
            <tr>
              <td><?php echo $number; ?></td>
              <td><a href="TMEntrance.php?<?php echo "roomtitle=$title&roomidx=$idx&trainer=$trainer";?>" style="color:#68217A"><?php echo $title; ?></a></td>
              <td><?php echo $trainer; ?></td>
              <td><?php echo $board['createdate']; ?></td>
            </tr>
          <tbody>
          <?php } ?>
        </table>
      </div>
    </center>

  </body>
</html>
