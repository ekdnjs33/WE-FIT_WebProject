<?php
include('../lock.php');

$player=$row['id'];
//$playtime=date('Y-m-d H:i:s');

$is_sql = mysqli_query($db, "SELECT * FROM basictwo WHERE id = $player");
$is_row = mysqli_num_rows($is_sql);
if($is_row == 1){
  $player_sql = mysqli_query($db, "UPDATE basictwo SET score = 100 WHERE id = $player");
}
else{
  $player_sql = mysqli_query($db, "INSERT INTO basictwo(id, score, old_score) VALUES($player, 100, null)");
}
?>
<!doctype html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html" charset="utf-8">
    <title>WE FIT - StayMode</title>
    <script src="../js/jquery.js"></script>
    <script>
    var wearable = 0;
    var kinect = 0;
    var pmajor = "<?php echo $player_major; ?>";

    //1초마다 서버에서 wearable & kinect data call
    var wearableServerTimer = setInterval('wearableServerCall(pmajor)', 1000);
    var kinectServerTimer = setInterval('kinectServerCall(pmajor)', 1000);
    //시작버튼 활성화
    var ableStart = setInterval('ablestartbtn(wearable, kinect)', 1000);

    /*서버에서 wearable data 콜하는 함수*/
    function wearableServerCall(pmajor){
      var allData = {"userId": pmajor};
      $.ajax({
        url: "https://we-fit.co.kr:8080/wearables/user/"+pmajor,  //받아올 내용이 있는 url
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
      var allData = {"userId": pmajor};
      $.ajax({
        url: "https://we-fit.co.kr:8080/joints/user/"+pmajor,  //받아올 내용이 있는 url
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
      if(wearable == 1){
        clearInterval(wearableServerTimer);
        document.getElementById('wIcon').innerHTML = "<img src='../img/checked.png' style='width:20px; height:20px;'/>";
      }
    }
    /*연결 여부에 따라 키넥트 icon 바꾸는 함수*/
    function changeKinectIcon(kinect){
      if(kinect == 1){
        clearInterval(kinectServerTimer);
        document.getElementById('kIcon').innerHTML ="<img src='../img/checked.png' style='width:20px; height:20px;'/>";
      }
    }
    /*웨어러블, 키넥트 센서가 모두 연결된 경우 시작하기 버튼 활성화*/
    function ablestartbtn(wearable, kinect){
      if(wearable == 1 && kinect == 1){
        clearInterval(ableStart);
        $('#startbtn').attr('disabled', false);
        $('#startbtn').css("background-color","#813f7f");
      }
    }
    </script>
    <link href="../css/trainermode.css" rel="stylesheet"></link>
    <link href="../bootstrap-4.0.0/dist/css/bootstrap.css" rel="stylesheet"></link>
  </head>
  <body style="margin:8px; background:#f5c94c">
    <div id="top">
      <a href="BasicMode.php" style="text-decoration: none; color:black;"> <!--BasicMode.php로 변경 다원-->
      <br><img src="../img/logo.png" alt="we fit 로고" width="7%" align="center"> 기본 2코스(Basic 2)</a> <!--기본 2코스(Basic 2)로 변경 다원-->
      <a href="Basic2.php?<?php echo "player=$player";?>" style="position: absolute; right: 0; margin-right:70px;"><input style="margin-top:50px" class="make" type="button" value="시작하기"/></a>
    </div>

    <div class="content-wrapper">

      <div class="container" align="center">
        <center>
          <div class="card-deck mb-3 text-center" style="margin-top:50px; padding-left:150px;"> <!--margin-top추가 다원-->
            <div class="card border-wefit mb-3" style="max-width: 400px ; height: 500px; border:4px solid #813f7f;">
              <div class="card-header bg-transparent border-wefit text-wefit text-center"><h4><b>코스명</b></h4></div>
              <div class="card-body">
                <h5><b>기본 2코스(Basic 2)</h5></b>
                <h5><b>소요시간:</h5></b>
                <h5><b>운동부위:</h5></b>
              </div>
            </div>

            <div class="card border-wefit mb-3" style="max-width: 400px; height: 500px; border:4px solid #813f7f;">
              <div class="card-header bg-transparent border-wefit text-wefit text-center"><h4><b>Player</b></h4></div>
              <div class="card-body">
                <img src="../img/user-silhouette.png" style="margin-top:40px; width:200px; height:200px;"/>
                <br><br>
                <h4 class="card-title" style="margin-top:10px;"><?php echo $login_session; ?></h4>
              </div>

              <div class="card-footer bg-transparent border-wefit">
                <b>Wearables </b>
                <span id="wIcon"><img src="../img/close.png" style="width:20px; height:20px;"/></span>
                &nbsp
                <b>Kinect</b>
                <span id="kIcon"><img src="../img/close.png" style="width:20px; height:20px;"/></span>
              </div>
            </div>
          </div>
        </center>
      </div>
    </div>
    <p align="center" style="font-family:'210 데이라잇'; font-size:18pt; margin-top:10px;">
    <span id="connect">키넥트 센서와 웨어러블 기기의 블루투스를 연결해주세요!</span>
    </p>
  </body>
</html>
