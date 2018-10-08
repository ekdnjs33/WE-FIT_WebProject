<?php
/*스쿼트 심화 운동 코드*/
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

    //var seconds = 9;
    var pmajor = "<?php echo $player_major; ?>";
    var tradingId = 1;
    var up = 0;
    var down = 0;

    //1초 마다 카운트다운 함수 실행
    //var countdownTimer = setInterval('secondPassed()', 1000);
    //1초마다 키넥트 서버의 mode2 콜
    var servertimer = setInterval('basicServerCall(pmajor, tradingId)', 1000);

    /*실시간 날짜와 시간을 받아오는 함수*/
    function getFormatDate(date){
      /*var year = date.getFullYear();
      var mon = (1+date.getMonth());
      mon = mon>=10?mon:'0'+mon;
      var day = date.getDate();
      day = day>=10?day:'0'+day;*/
      var hour = date.getHours();
      hour = hour>=10?hour:'0'+hour;
      var min = date.getMinutes();
      min = min>=10?min:'0'+min;
      var sec = date.getSeconds();
      sec = sec>=10?sec:'0'+sec;

      return hour+":"+min+":"+sec; //year+"-"+mon+"-"+day+" "+
    }
    /*키넥트 서버에서 mode2을 콜하는 함수*/
    function basicServerCall( pmajor, tradingId){
      var d = new Date();
      var state = 0;
      nowtime = getFormatDate(d);
      $.ajax({
      	url: "https://we-fit.co.kr:8080/algorithm/basicMode/"+pmajor+"/"+tradingId+"/"+nowtime,  //받아올 내용이 있는 url
        type: "GET",
        dataType: "json",
      	cache: false,
      	success: function(data){
          $(".countdown").html(nowtime);
          if(data == 1){
            if(up > 1){
              $(".minus").html("-1"); //화면에 뿌리기
              $(".feedback").html("더 올라가야해요!!");
              $(".updown").html("UP");
              basicDB(1, pmajor);
              up=0;
            }else{
              $(".minus").html("-"); //화면에 뿌리기
              $(".feedback").html("올라가세요");
              $(".updown").html("UP");
              up+=0.4;
            }
          }
          else if(data == 2){
            if(down > 1){
              $(".minus").html("-1"); //화면에 뿌리기
              $(".feedback").html("더 내려가야해요^^");
              $(".updown").html("DOWN");
              basicDB(1, pmajor);
             down=0;
           }else{
             $(".minus").html("-"); //화면에 뿌리기
             $(".feedback").html("내려가세요");
             $(".updown").html("DOWN");
             down+=0.4;
            }
          }
          else if(data == 5){
            $(".minus").html("-");
            $(".feedback").html("좋아요:)");
            $(".updown").html("GOOD");
          }
          else if(data == 6){
            $(".minus").html("-");
            $(".feedback").html("운동 끝");
            $(".updown").html("END");
            clearInterval(servertimer);
          }
      	}
      });
    }
    /*DB에 데이터를 저장하고 불러오는 함수*/
    function basicDB(minusScore, pmajor){
      $.ajax({
      	url: "b1-database.php?minus="+minusScore+"&pmajor="+pmajor, //받아올 내용이 있는 url
        type: "GET",
        dataType: "json",
      	cache: false,
      	success: function(data){ //score 받아오기
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
          //var servertimer = setInterval('basicServerCall(rmajor, pmajor, tradingId, timeline)', 1000);
        }
        else{
          seconds--;
        }
      }
    </script>

  </head>
  <body>
    <div class="wrapper">
      <div class="one">스쿼트 3초 유지 3회, 운동을 시작하세요!</div>
      <div class="two1">
        <br><br><br><br><br>
        <video autoplay="true" id="videoElement1">
        </video>

      </div>

      <div class="two2">
        <div class="resultshow">
          <p id="down" class="countdown">start</p>
          <p class="now">내 점수</p>
          <p class="score">100</p>
        </div>
        <div class="stopbtn" style="margin-top:195px">
          <a href="BasicMode.php"><input class="finish" type="button" title="운동 중단시, 점수가 저장되지 않습니다" value="중단하기"></a>
          <a href="finishBasic.php?number=1&<?php echo "playerid=$player";?>"><input class="finish" type="button" value="운동 끝내기"></a>
        </div>
      </div>
      <div class="two3">
        <p class="minus" style="margin-top: 100px; font-size:30pt; color:red">-</p>
        <p class="feedback" style="margin-top: 100px; font-size:30pt;">준비</p>
        <p class="updown" style="margin-top: 100px; font-size:30pt; color:red">-</p>
      </div>
      <script>
      var video = document.querySelector("#videoElement1");

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
