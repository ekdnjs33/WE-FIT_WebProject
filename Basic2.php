<?php
include('lock.php');

$player=$row['id'];

$is_sql = mysqli_query($db, "SELECT * from basictwo WHERE id=$player");
$is_row = mysqli_num_rows($is_sql);
if($is_row == 1){
  $player_sql=mysqli_query($db, "UPDATE basictwo SET score=100 WHERE id=$player");
}
else{
  $player_sql=mysqli_query($db, "INSERT INTO basictwo(id, score, oldscore) VALUES($player, 100, null)");
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta http-equiv="Content-Type" content="text/html" charset="utf-8">
    <title>ingUser</title>
    <script src="js/jquery.js"></script>
    <link href="css/basic.css" rel="stylesheet"></link>
    <script>
    var seconds = 9;
    var pmajor = "<?php echo $player_major; ?>";
    var rmajor = "0000";
    var tradingId = 2;
    var timeline = 1;

    /*키넥트 서버에서 mode1을 콜하는 함수*/
    function basicServerCall(rmajor, pmajor, tradingId, timeline){
      var allData = {"sourceUser":rmajor, "targetUser":pmajor, "tradingID":tradingId, "sourceDataNumber":timeline};
      $.ajax({
      	url: "http://localhost:8080/algorithm/mode2",  //받아올 내용이 있는 url
        type: GET, //전송 방식(get/post)
        data: allData, //전송할 데이터
        dataType: "json", //요청한 데이터 타입
      	cache: false,
      	success: function(data){
          //전송에 성공하면 실행될 코드
          var minusScore = data;
          var database = basicDB(minusScore, pmajor);
      	}
        /*error: function(){
          //전송에 실패하면 실행될 코드
        }*/
      });
      timeline++;
    }

    /*DB에 데이터를 저장하고 불러오는 함수*/
    function basicDB(minusScore, pmajor){
      var basData = {"minus":minusScore, "pmajor":pmajor};
      $.ajax({
      	url: "b2-database.php", //받아올 내용이 있는 url
        type: POST, //전송 방식(get/post)
        data: basData, //전송할 데이터
        dataType: "json", //요청한 데이터 타입
      	cache: false,
      	success: function(data){ //score와 rank 받아오기
          //전송에 성공하면 실행될 코드
          var score_result = data.score;

          $(".score").html(score_result); //화면에 뿌리기
      	}
        /*error: function(){
          //전송에 실패하면 실행될 코드
        }*/
      });
    }

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

          //1초마다 키넥트 서버의 mode2 콜
          //var servertimer = setInterval('basicServerCall(rmajor, pmajor, tradingId, timeline)', 1000);
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
      <div class="two1">참조 영상</div>
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
      <div class="two3">사용자 영상</div>
    </div>
  </body>
</html>