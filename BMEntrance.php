<?php
include('lock.php');

$roomtitle=$_GET['roomtitle'];
$roomidx=$_GET['roomidx'];
$trainer=$_GET['trainer'];
$player=$row['id'];

if($login_session == $trainer){
  $trainer_sql=mysqli_query($db, "INSERT INTO player(idx, id, checkT, score) VALUES($roomidx, $player, 1, 100)");
}else{
  $player_sql=mysqli_query($db, "INSERT INTO player(idx, id, checkT, score) VALUES($roomidx, $player, 0, 100)");
}

$list=[];
$num=0;
?>
<!doctype html>
<html>
<head>
  <!--5초마다 방 목록 새로고침-->
  <meta http-equiv=refresh content='5; url='>
  <meta http-equiv="Content-Type" content="text/html" charset="utf-8">
  <title>WE FIT - StayMode</title>
  <link href="css/trainermode.css" rel="stylesheet"></link>
  <link href="bootstrap-4.0.0/dist/css/bootstrap.css" rel="stylesheet"></link>
</head>

<body style="margin:8px; background:#f5c94c">
  <div id="top">
    <a href="exit_ok.php?<?php echo "roomidx=$roomidx"; ?>" style="text-decoration: none; color:black;">
    <br><img src="logo.png" alt="we fit 로고" width="7%" align="center"><?php echo " $roomtitle"; ?></a>
    <!--<span align="center" style=" font-size:18pt; margin-left:190px;">키넥트 센서와 웨어러블 기기의 블루투스를 연결해주세요!</span>-->
    <a href="ingUser.php?<?php echo "roomtitle=$roomtitle&roomidx=$roomidx&trainer=$trainer";?>" style="position: absolute; right: 0; margin-right:70px;"><input style="margin-top:50px" class="make" type="button" value="시작하기"/></a>
  </div>

  <div class="content-wrapper">

    <div class="container" align="center">
<center>
      <div class="card-deck mb-3 text-center" style="padding-left:150px;">
        <div class="card border-wefit mb-3" style="max-width: 400px ; height: 500px; border:4px solid #813f7f;">
          <div class="card-header bg-transparent border-wefit text-wefit text-center"><b>코스명</b></div>
          <div class="card-body">

            코스설명
            소요시간
            운동부위
            reference누군지

          </div>

        </div>

        <div class="card border-wefit mb-3" style="max-width: 400px; height: 500px; border:4px solid #813f7f;">
          <div class="card-header bg-transparent border-wefit text-wefit text-center"><b>Player</b></div>
          <div class="card-body">
             <img src="img/user-silhouette.png" style="width:200px; height:200px;"/>
             <br><br>
            <h5 class="card-title">
              <?php
                echo $list[2];
              ?>
            </h5>
          </div>
          <div class="card-footer bg-transparent border-wefit"><b>Wearables <img src="img/checked.png" style="width:20px; height:20px;"/>
            &nbsp Kinect <img src="img/checked.png" style="width:20px; height:20px;"/>  </b></div>
        </div>

    </div>
  </center>
</div>
</div>
<p align="center" style="font-family:'210 데이라잇'; font-size:18pt; margin-top:10px;">
  키넥트 센서와 웨어러블 기기의 블루투스를 연결해주세요!
</p>

</body>
</html>