<?php
include('lock.php');

$roomtitle=$_GET['roomtitle'];
$roomidx=$_GET['roomidx'];
$trainer=$_GET['trainer'];

$major_sql=mysqli_query($db, "SELECT * FROM users WHERE email='".$trainer."'");
$major_row=mysqli_fetch_array($major_sql);
$trainer_major=$major_row['major'];
$playtime=date('Y-m-d H:i:s');
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta http-equiv="Content-Type" content="text/html" charset="utf-8">
    <title>ingUser</title>
    <script src="js/jquery.js"></script>
    <link href="css/inguser.css" rel="stylesheet"></link>
    <script>
    var seconds = 9;
    var pmajor = "<?php echo $player_major; ?>";
    var tmajor = "<?php echo $trainer_major; ?>";
    var nowtime = "<?php echo $playtime; ?>";

    /*키넥트 서버에서 mode1을 콜하는 함수*/
    function trainerServerCall(tmajor, pmajor, nowtime){
      var allData = {"sourceUser":tmajor, "targetUser":pmajor, "now":nowtime};
      $.ajax({
      	url: "http://localhost:8080/algorithm/mode1/ 트레이너 major id/사용자 major id/현재 시간",  //받아올 내용이 있는 url
        type: POST, //전송 방식(get/post)
        data: allData, //전송할 데이터
        dataType: "json", //요청한 데이터 타입
      	cache: false,
      	success: function(data){
          //전송에 성공하면 실행될 코드
          var minusScore = data;
          var database = trainerDB(minusScore, pmajor);
      	}
        error: function(){
          //전송에 실패하면 실행될 코드
        }
      });
    }

    /*DB에 데이터를 저장하고 불러오는 함수*/
    function trainerDB(minusScore, pmajor){
      var triData = {"minus":minusScore, "targetUser":pmajor};
      $.ajax({
      	url: "t-database.php", //받아올 내용이 있는 url
        type: POST, //전송 방식(get/post)
        data: triData, //전송할 데이터
        dataType: "json", //요청한 데이터 타입
      	cache: false,
      	success: function(data){ //score와 rank 받아오기
          //전송에 성공하면 실행될 코드
          var score_result = data.score;
          var rank_result = data.rank;

          $(".score").html(score_result); //화면에 뿌리기
          $(".rank").html(rank_result);
      	}
        error: function(){
          //전송에 실패하면 실행될 코드
        }
      });
    }

    /*카운트다운 함수*/
    function secondPassed(){
      var minutes = Math.round((seconds - 30)/60);
      var remainingSeconds = seconds % 60;
        /*if (remainingSeconds < 10) {
            remainingSeconds = "0" + remainingSeconds;
        }*/
        document.getElementById('down').innerHTML = remainingSeconds;
        if(seconds==0){
          clearInterval(countdownTimer);
          document.getElementById('down').innerHTML = "start";
          var servertimer = setInterval('trainerServerCall(tmajor, pmajor, nowtime)', 1000);
        }
        else{
          seconds--;
        }
      }

      var countdownTimer = setInterval('secondPassed()', 1000);
      </script>
  </head>
  <body>
    <div class="wrapper">
      <div class="one">10초 후에 운동을 시작합니다.</div>
      <div class="two1">트레이너 영상</div>
      <div class="two2">
        <div class="resultshow">
          <p id="down" class="countdown">10</p>
          <p class="now">현재 순위</p>
          <p class="rank"></p>
          <p class="now">내 점수</p>
          <p class="score"></p>
        </div>
        <div class="stopbtn">
          <a href="exit_ok.php?<?php echo "roomidx=$roomidx"; ?>"><input class="finish" type="button" value="중단하기"></a>
        </div>
      </div>
      <div class="two3">사용자 영상</div>
    </div>
  </body>
</html>
