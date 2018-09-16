<?php
include('../lock.php');

$player=$row['id'];
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta http-equiv="Content-Type" content="text/html" charset="utf-8">
    <meta content="stuff, to, help, search, engines, not" name="keywords">
    <meta content="What this page is about." name="description">
    <meta content="WE FIT - Playing" name="title">
    <title>WE FIT - Playing</title>
    <script src="../js/jquery.js"></script>
    <link href="../css/video.css" rel="stylesheet"></link>
    <link href="../css/basic.css" rel="stylesheet"></link>
    <script>
    var seconds = 9;
    var pmajor = "<?php echo $player_major; ?>";
    var rmajor = "0000";
    var tradingId = 2;
    var timeline = 1;

    //1초 마다 카운트다운 함수 실행
    var countdownTimer = setInterval('secondPassed()', 1000);

    /*키넥트 서버에서 mode2을 콜하는 함수*/
    function basicServerCall(rmajor, pmajor, tradingId, timeline){
      //var allData = {"sourceUser": rmajor, "targetUser": pmajor, "tradingID": tradingId, "sourceDataNumber": timeline};
      $.ajax({
      	url: "https://14.49.37.187:8080/algorithm/mode2/"+rmajor+"/"+pmajor+"/"+tradingId+"/"+timeline,  //받아올 내용이 있는 url
        type: "GET", //전송 방식(get/post)
        //data: allData, //전송할 데이터
        dataType: "json", //요청한 데이터 타입
      	cache: false,
      	success: function(data){
          var minusScore = data;
          basicDB(minusScore, pmajor);
          timeline++;
      	}
      });
    }
    /*DB에 데이터를 저장하고 불러오는 함수*/
    function basicDB(minusScore, pmajor){
      //var basData = {"minus": minusScore, "pmajor": pmajor};
      $.ajax({
      	url: "b2-database.php?minus="+minusScore+"&pmajor="+pmajor, //받아올 내용이 있는 url
        type: "GET", //전송 방식(get/post)
        //data: basData, //전송할 데이터
        dataType: "json", //요청한 데이터 타입
      	cache: false,
      	success: function(data){ //score와 rank 받아오기
          var score_result = data.score;

          $(".score").html(score_result); //화면에 뿌리기
      	}
      });
    }
    /*카운트다운 함수*/
    function secondPassed(){
      var minutes = Math.round((seconds - 30)/60);
      var remainingSeconds = seconds % 60;
        document.getElementById('down').innerHTML = remainingSeconds;
        if(seconds == 0){
          clearInterval(countdownTimer);
          document.getElementById('down').innerHTML = "start";

          //1초마다 키넥트 서버의 mode2 콜
          var servertimer = setInterval('basicServerCall(rmajor, pmajor, tradingId, timeline)', 1000);
        }
        else{
          seconds--;
        }
      }
    </script>
  </head>
  <body>
    <div class="wrapper">
      <div class="one">10초 후에 운동을 시작합니다.</div>
      <div class="two1">참조 영상
          <br><br><br><br><br>

          <video autoplay id="sampleMovie" src="../img/sample.mp4" style="width:640px; height:480px;" controls>
          </video>

        </div>

      <div class="two2">
        <div class="resultshow">
          <!--<p class="now"></p>
          <p class="rank"></p>-->
          <p id="down" class="countdown">10</p>
          <p class="now">내 점수</p>
          <p class="score">100</p>
        </div>
        <div class="stopbtn">
          <a href="BasicMode.php"><input class="finish" type="button" value="중단하기"></a>
        </div>
      </div>
      <div class="two3">사용자 영상
        <br><br><br><br><br>
        <video autoplay="true" id="videoElement2">

        </video>

      </div>
      <script>
      var video = document.querySelector("#videoElement2");

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
    </div>
  </body>
</html>
