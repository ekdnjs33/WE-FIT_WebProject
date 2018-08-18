<?php
include('lock.php');

$number=0; //방 번호
?>
<!doctype html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html" charset="utf-8">
  <title>WE FIT - TrainerMode</title>
  <script src="js/jquery.js"></script>
  <script>
  /*$(function(){
    $(".enter").hover(function(){
      $(".enter").css({"color":"white"});},
      function(){
      $(".enter").css({"color":"black"});
      });
  });*/
  </script>
  <link href="css/trainermode.css" rel="stylesheet"></link>
</head>
<body>
  <div id="top">
    <a href="SelectMode.php">
    <br><img src="logo.png" alt="we fit 로고" width="7%" align="center"> 트레이너 모드입니다!</a>
    <p align="right" style="margin-top:20px; margin-right:70px"><a href="CreateRoom.php"><input class="make" type="button" value="방 생성하기"/></a></p>
    <!--<p align="right" style="margin-right:70px"><input type="search">
    <input type="submit" value="검색"></p>-->
  </div>
  <center>
  <div id="bottom">
    <table width="90%">
      <caption style="padding:15px">전체 방 목록</caption>
      <colgroup>
        <col width="10%">
        <col width="60%">
        <col width="10%">
        <col width="20%">
      </colgroup>
      <thead>
        <tr style="background:#b2afa6">
          <td>번호</td>
          <td>방 이름</td>
          <td>트레이너</td>
          <td>생성시간</td>
        </tr>
      <thead>
      <?php $sql=mysqli_query($db, "SELECT * FROM triroom ORDER BY idx DESC LIMIT 0,7");
      while($board=mysqli_fetch_array($sql)){
        $title=$board['title'];
        $number+=1;
      ?>
      <tbody>
        <tr>
          <td><?php echo $number; ?></td>
          <td><a href="TMEntrance.html?<?php echo "roomname=$title";?>" style="color:#68217A"><?php echo $board['title']; ?></a></td>
          <td><?php echo $board['createrid']; ?></td>
          <td><?php echo $board['createdate']; ?></td>
        </tr>
      <tbody>
      <?php } ?>
    </table>
  </div>
  </center>
</body>
</html>
