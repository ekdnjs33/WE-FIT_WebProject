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
<script>
var wearable = 0;
var kinect = 0;
var pmajor = "<?php echo $player_major; ?>";

//1초마다 서버에서 wearable & kinect data call
var wearableServerTimer = setInterval('wearableServerCall(pmajor)', 1000);
var kinectServerTimer = setInterval('kinectServerCall(pmajor)', 1000);


/*서버에서 wearable data 콜하는 함수*/
function wearableServerCall(pmajor){
  var allData = {"userId":pmajor};
  $.ajax({
    url: "http://14.49.37.187:8080/wearables/user/"+pmajor,  //받아올 내용이 있는 url
    type: "GET", //전송 방식(get/post)
    async: false,
    //data: allData, //전송할 데이터
    dataType: "json", //요청한 데이터 타입
    cache: false,
    success: function(data){  //전송에 성공하면 실행될 코드

      if(data.length > 0 ){//만약 데이터가 들어왔다면 아이콘 바꾸도록 실행
        wearable = 1;
        changeWearableIcon(wearable);
      }
    }
  });
}
/*서버에서 kinect data 콜하는 함수*/
function kinectServerCall(pmajor){
  var allData = {"userId":pmajor};
  $.ajax({
    url: "http://14.49.37.187:8080/joints/user/"+pmajor,  //받아올 내용이 있는 url
    type: "GET", //전송 방식(get/post)
    async: false,
    //data: allData, //전송할 데이터
    dataType: "json", //요청한 데이터 타입
    cache: false,
    success: function(data){ //전송에 성공하면 실행될 코드
      if(data.length > 0 ){//만약 데이터가 들어왔다면 아이콘 바꾸도록 실행
        kinect = 1;
        changeKinectIcon(kinect);
      }
    }
  });
}

/*연결 여부에 따라 웨어러블 icon 바꾸는 함수*/
function changeWearableIcon(wearable){
  if(wearable==1){
      clearInterval(wearableServerTimer);
      document.getElementById('wIcon').innerHTML = "<img src='img/checked.png' style='width:20px; height:20px;'/>";
     }
 }

  /*연결 여부에 따라 키넥트 icon 바꾸는 함수*/
  function changeKinectIcon(kinect){
    if(kinect==1){
        clearInterval(kinectServerTimer);
        document.getElementById('kIcon').innerHTML ="<img src='img/checked.png' style='width:20px; height:20px;'/>";
      }
    }

  </script>
<!doctype html>
<html>
<head>
  <!--3초마다 방 목록 새로고침-->
  <meta http-equiv=refresh content='3; url='>
  <meta http-equiv="Content-Type" content="text/html" charset="utf-8">
  <title>WE FIT - StayMode</title>
  <script src="js/jquery.js"></script>
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
  <div class="card border-wefit mb-3" style="max-width: 18rem; border:4px solid #813f7f;">
    <div class="card-header bg-transparent border-wefit text-wefit text-center "><img src="img/crown.png" style="width:20px; height:20px;"/>&nbsp<b>Trainer</b>&nbsp<img src="img/crown.png" style="width:20px; height:20px;"/></div>
    <div class="card-body">
       <img src="img/user-silhouette.png" style="width:100px; height:100px;"/>
       <br><br>
      <h5 class="card-title">
        <?php $sql=mysqli_query($db, "SELECT checkT, email FROM player, users, triroom WHERE player.id=users.id AND player.idx=triroom.idx AND title='".$roomtitle."'");
        while($board=mysqli_fetch_array($sql)){
          $playerid=$board['email'];
          $trainercheck=$board['checkT'];

          if($trainercheck==1){
            echo $playerid;
          }
          else{
            $list[$num]=$playerid;
            $num++;
          }
        }
        ?>
      </h5>
    </div>
    <div class="card-footer bg-transparent border-wefit">
      <b>Wearables </b>
      <span id="wIcon"><img src="img/close.png" style="width:20px; height:20px;"/></span>
      &nbsp
      <b>Kinect</b>
      <span id="kIcon"><img src="img/close.png" style="width:20px; height:20px;"/></span>
    </div>
  </div>
</div>

    <div class="container" align="center">
<center>
      <div class="card-deck mb-3 text-center" style="padding-left: 92px;">

        <div class="card border-wefit mb-3" style="max-width: 18rem; border:4px solid #813f7f; ">
          <div class="card-header bg-transparent border-wefit text-wefit text-center"><b>Player1</b></div>
          <div class="card-body">
             <img src="img/user-silhouette.png" style="width:100px; height:100px;"/>
             <br><br>
            <h5 class="card-title">
              <?php
                echo $list[0];
              ?>
            </h5>
          </div>
          <div class="card-footer bg-transparent border-wefit">
            <b>Wearables </b>
            <span id="wIcon"><img src="img/close.png" style="width:20px; height:20px;"/></span>
            &nbsp
            <b>Kinect</b>
            <span id="kIcon"><img src="img/close.png" style="width:20px; height:20px;"/></span>
          </div>
        </div>

        <div class="card border-wefit mb-3" style="max-width: 18rem; border:4px solid #813f7f;">
          <div class="card-header bg-transparent border-wefit text-wefit text-center"><b>Player2</b></div>
          <div class="card-body">
             <img src="img/user-silhouette.png" style="width:100px; height:100px;"/>
             <br><br>
            <h5 class="card-title">
              <?php
                echo $list[1];
              ?>
            </h5>
          </div>
          <div class="card-footer bg-transparent border-wefit">
            <b>Wearables </b>
            <span id="wIcon"><img src="img/close.png" style="width:20px; height:20px;"/></span>
            &nbsp
            <b>Kinect</b>
            <span id="kIcon"><img src="img/close.png" style="width:20px; height:20px;"/></span>
          </div>
        </div>

        <div class="card border-wefit mb-3" style="max-width: 18rem;border:4px solid #813f7f;">
          <div class="card-header bg-transparent border-wefit text-wefit text-center"><b>Player3</b></div>
          <div class="card-body">
             <img src="img/user-silhouette.png" style="width:100px; height:100px;"/>
             <br><br>
            <h5 class="card-title">
              <?php
                echo $list[2];
              ?>
            </h5>
          </div>
          <div class="card-footer bg-transparent border-wefit">
            <b>Wearables </b>
            <span id="wIcon"><img src="img/close.png" style="width:20px; height:20px;"/></span>
            &nbsp
            <b>Kinect</b>
            <span id="kIcon"><img src="img/close.png" style="width:20px; height:20px;"/></span>
          </div>
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
