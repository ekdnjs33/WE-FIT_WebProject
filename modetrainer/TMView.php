<?php
/*운동중 트레이너가 보는 화면*/
include('../lock.php');

$roomidx = $_GET['roomidx'];
$roomtitle = $_GET['roomtitle'];
$player = $row['id'];
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta http-equiv="Content-Type" content="text/html" charset="utf-8">
    <title>WE FIT -Playing</title>
    <script src="../js/jquery.js"></script>
    <link href="../css/basic.css" rel="stylesheet"></link>
    <style>
    #container {
      margin: 0px auto;
      width: 700px;
      height: 700px;
    }
    #videoElement {
      width: 700px;
      height: 700px;
    }
    </style>
    <script>
    var seconds = 29;
    var roomidx = "<?php echo $roomidx; ?>";
    var playerid = "<?php echo $player; ?>";

    var show = showTrainee();
    //1초마다 카운트다운 함수 실행
    var countdownTimer = setInterval('secondPassed()', 1000);
    var finishExercising = setInterval('finishExercise()', 100);
    //현재시간과 사용자들의 점수를 불러오는 함수 실행
    var showData = setInterval('showPlaying()', 1000);

    /*실시간 날짜와 시간을 받아오는 함수*/
    function getFormatDate(date){
      var hour = date.getHours();
      hour = hour>=10?hour:'0'+hour;
      var min = date.getMinutes();
      min = min>=10?min:'0'+min;
      var sec = date.getSeconds();
      sec = sec>=10?sec:'0'+sec;

      return hour+":"+min+":"+sec;
    }
    /*카운트다운 함수*/
    function secondPassed(){
      var minutes = Math.round((seconds - 30)/60);
      var remainingSeconds = seconds % 60;

      document.getElementById('down').innerHTML = remainingSeconds;
      if(seconds == 0){
        clearInterval(countdownTimer);
        document.getElementById('down').innerHTML = "start";
      }
      else{
        seconds--;
      }
    }
    /*운동 끝내기 버튼을 누른 경우 실행*/
    function endButton(){
      $.ajax({
        url: "endbtn.php?roomidx="+roomidx+"&playerid="+playerid,
        type: "GET",
        async: true,
        dataType: "json",
        cache: false,
        success: function(response){
        }
      });
    }
    /*트레이너가 운동 시작 버튼을 누른 경우, 모든 사용자가 Scorelist로 이동*/
    function finishExercise(){
      $.ajax({
        url: "finishexercise.php?roomidx="+roomidx+"&playerid="+playerid,
        type: "GET",
        async: true,
        dataType: "json",
        cache: false,
        success: function(response){
          if(response.click == 1){
            location.href = "TMScoreList.php?<?php echo "roomtitle=$roomtitle&roomidx=$roomidx";?>";
          }
        }
      });
    }
    /*트레이니의 점수와 현재시간 출력*/
    function showPlaying(){
      //var d = new Date();
      //nowtime = getFormatDate(d);
      $.ajax({
        url: "p-database.php?roomidx="+roomidx,
        type: "GET",
        async: true,
        dataType: "json",
        cache: false,
        success: function(response){
          //$("#nowtime").html(nowtime);
          for(i = 0; i < response.length; i++){
            var checkT_result = response[i].checkT;
            var player_result = response[i].score;

            if(checkT_result > 0)
              $("#Player"+checkT_result.toString()).html(player_result); //화면에 뿌리기
          }
        }
      });
    }
    /*트레이니 표시*/
    function showTrainee(){
      $.ajax({
        url: "isplayer.php?roomidx="+roomidx+"&playerid="+playerid,
        type: "GET",
        async: true,
        dataType: "json",
        cache: false,
        success: function(response){
          for(i = 0; i < response.length; i++){
            var checkT_t = response[i].checkT;
            var player_t = response[i].email;

            if(checkT_t > 0)
              $("#num"+checkT_t.toString()).html(player_t); //화면에 뿌리기
          }
        }
      });
    }
    </script>
  </head>
  <body>
    <div class="wrapper">
      <div class="one">30초 후에 운동을 시작합니다.</div>
      <div class="two1" style="font-size:20px"><p>트레이너 영상</p>
        <div id="container">
          <video autoplay="true" id="videoElement"></video>
        </div>
      </div>
      <div class="two2">
        <div class="resultshow">
          <p id="down" class="countdown2">30</p>
          <p class="now2"><img src="../img/logo.png" alt="we fit 로고" width="45%" align="center"></p>
          <!--<p style="font-size: 32pt;" id="nowtime">-</p>-->

          <div class="stopbtn">
            <input class="finish" type="button" value="운동 끝내기" onclick='endButton()'></a>
          </div>
        </div>
      </div>

      <div class="two4">
        <div class="panel panel-primary panel-transparent">
          <div class="panel-heading">
            <p class="panel-title" id="num1" style="font-size:18pt">Player1 ID</p>
          </div>
          <div class="panel-body" id="Player1" style="font-size:32pt; color:red">
            -
          </div>
        </div>
      </div>
      <div class="two5">
        <div class="panel panel-primary panel-transparent">
          <div class="panel-heading">
            <p class="panel-title" id="num2" style="font-size:18pt">Player2 ID</p>
          </div>
          <div class="panel-body" id="Player2" style="font-size:32pt; color:red">
            -
          </div>
        </div>
      </div>
      <div class="two6">
        <div class="panel panel-primary panel-transparent">
          <div class="panel-heading">
            <p class="panel-title" id="num3" style="font-size:18pt">Player3 ID</p>
          </div>
          <div class="panel-body" id="Player3" style="font-size:32pt; color:red">
            -
          </div>
        </div>
      </div>

    </div>
    <script>
      var video = document.querySelector("#videoElement");

      if(navigator.mediaDevices.getUserMedia){
        navigator.mediaDevices.getUserMedia({video: true})
        .then(function(stream){
          video.srcObject = stream;
        })
        .catch(function(err0r) {
          console.log("Something went wrong!");
        });
      }
    </script>
  </body>
</html>
