<?php
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
      width: 600px;
      height: 600px;

    }
    #videoElement {
      width: 600px;
      height: 600px;

    }
    </style>
    <script>
    var seconds = 9;
    var roomidx = "<?php echo $roomidx; ?>";
    var playerid = "<?php echo $player; ?>";

    //1초 마다 카운트다운 함수 실행
    var countdownTimer = setInterval('secondPassed()', 1000);

    var finishExercising = setInterval('finishExercise()', 100);

    /*카운트다운 함수*/
    function secondPassed(){
      var minutes = Math.round((seconds - 30)/60);
      var remainingSeconds = seconds % 60;
        /*if (remainingSeconds < 10) {
            remainingSeconds = "0" + remainingSeconds;
        }*/
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
    /*트레이너가 운동 시작 버튼을 누른 경우, 각각의 사용자가 Scorelist로 이동*/
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
    </script>
  </head>
  <body>
    <div class="wrapper">
      <div class="one">10초 후에 운동을 시작합니다.</div>
      <div class="two1"><h4><b>Trainer</b></h4>
        <div id="container">
          <video autoplay="true" id="videoElement"></video>
        </div>
      </div>
      <div class="two2">
        <div class="resultshow">
          <!--<p class="now"></p>
          <p class="rank"></p>-->
          <p id="down" class="countdown2">10</p>
          <p class="now2">운동시간</p>
          <p style="font-size: 15pt;">경과시간</p>

          <div class="stopbtn">
            <!--<a href="exit_ok.php?<?php //echo "roomidx=$roomidx"; ?>">--><input class="finish" type="button" value="운동 끝내기" onclick='endButton()'></a>
          </div>
        </div>
      </div>

      <div class="two4">
        <div class="panel panel-primary panel-transparent">
          <div class="panel-heading">
            <h4 class="panel-title"><b>Player1 ID</b></h4>
          </div>
          <div class="panel-body">
            현재 점수:
          </div>
        </div>
      </div>
      <div class="two5">
        <div class="panel panel-primary panel-transparent">
          <div class="panel-heading">
            <h4 class="panel-title"><b>Player2 ID</b></h4>
          </div>
          <div class="panel-body">
            현재 점수:
          </div>
        </div>
      </div>
      <div class="two6">
        <div class="panel panel-primary panel-transparent">
          <div class="panel-heading">
            <h4 class="panel-title"><b>Player3 ID</b></h4>
          </div>
          <div class="panel-body">
            현재 점수:
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
