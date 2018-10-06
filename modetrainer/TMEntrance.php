<?php
/*방 입장 후 대기하는 화면*/
include('../lock.php');

$roomtitle = $_GET['roomtitle'];
$roomidx = $_GET['roomidx'];
$trainer = $_GET['trainer'];
$player = $row['id'];

//방에 들어온 사람에게 순서대로 번호 부여하기(이름이나 센서 연결 표시시 사용하기 위해)
if($login_session == $trainer){
  $trainer_sql = mysqli_query($db, "INSERT INTO player(idx, id, checkT, w, k, score) VALUES($roomidx, $player, 0, 0, 0, 100)");
}
else{
  for($i = 1; $i <= 3; $i++){
    $num_sql = mysqli_query($db, "SELECT * FROM player WHERE idx = $roomidx AND checkT = $i");
    $num_row = mysqli_num_rows($num_sql);
    if($num_row == 0){
      $player_sql = mysqli_query($db, "INSERT INTO player(idx, id, checkT, w, k, score) VALUES($roomidx, $player, $i, 0, 0, 100)");
      break;
    }
  }
}
?>
<!doctype html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html" charset="utf-8">
  <title>WE FIT - StayMode</title>
  <script src="../js/jquery.js"></script>
  <script>
  var num = 0;
  var wearable = 0;
  var kinect = 0;
  var pmajor = "<?php echo $player_major; ?>";
  var roomidx = "<?php echo $roomidx; ?>";
  var playerid = "<?php echo $player; ?>";

  var isplayerTimer = setInterval('isplayer(roomidx, playerid)', 100); //사용자가 입장 확인

  //서버에서 wearable & kinect data 콜
  var wearableServerTimer = setInterval('wearableServerCall(pmajor)', 100);
  var kinectServerTimer = setInterval('kinectServerCall(pmajor)', 100);

  //버튼 활성화 여부를 체크하여 운동을 시작
  var abledisableButton = ablebutton(roomidx, playerid);
  var startExercising = setInterval('startExercise()', 100);

  /*서버에서 wearable data 콜하는 함수*/
  function wearableServerCall(pmajor){
    $.ajax({
      url: "https://we-fit.co.kr:8080/wearables/user/"+pmajor, //받아올 내용이 있는 url
      type: "GET",
      async: false,
      dataType: "json",
      cache: false,
      success: function(data){
        sensor = 1;
        if(data.length > 0 ){ //만약 데이터가 들어왔다면 아이콘 데이터 변경 함수 실행
          changeWearableIcon(sensor ,pmajor);
        }
        searchAllWearable(roomidx,sensor);
      }
    });
  }
  /*서버에서 kinect data 콜하는 함수*/
  function kinectServerCall(pmajor){
    $.ajax({
      url: "https://we-fit.co.kr:8080/joints/user/"+pmajor,  //받아올 내용이 있는 url
      type: "GET",
      async: false,
      dataType: "json",
      cache: false,
      success: function(data){
        sensor = 2;
        if(data.length > 0 ){ //만약 데이터가 들어왔다면 아이콘 변경 함수 실행
          changeKinectIcon(sensor, pmajor);
        }
        searchAllKinect(roomidx,sensor);
      }
    });
  }
  /*사용자의 웨어러블이 연결되었는지 확인하여 표시*/
  function searchAllWearable(roomidx,sensor){
    $.ajax({
      url: "showcheck.php?roomidx="+roomidx+"&sensor="+sensor,
      type: "GET",
      async: false,
      dataType: "json",
      cache: false,
      success: function(response){
        document.getElementById('wIcon0').innerHTML ="<img src='../img/close.png' style='width:20px; height:20px;'/>";
        document.getElementById('wIcon1').innerHTML ="<img src='../img/close.png' style='width:20px; height:20px;'/>";
        document.getElementById('wIcon2').innerHTML ="<img src='../img/close.png' style='width:20px; height:20px;'/>";
        document.getElementById('wIcon3').innerHTML ="<img src='../img/close.png' style='width:20px; height:20px;'/>";

        for(i = 0; i < response.length; i++){
          var checkT_r = response[i].checkT;
          var w = response[i].w;

          if(w == 1){
            document.getElementById('wIcon'+checkT_r.toString()).innerHTML ="<img src='../img/checked.png' style='width:20px; height:20px;'/>";
          }
        }
      }
    });
  }
  /*사용자의 키넥트가 연결되었는지 확인하여 표시*/
  function searchAllKinect(roomidx,sensor){
    $.ajax({
      url: "showcheck.php?roomidx="+roomidx+"&sensor="+sensor,
      type: "GET",
      async: false,
      dataType: "json",
      cache: false,
      success: function(response){
        document.getElementById('kIcon0').innerHTML ="<img src='../img/close.png' style='width:20px; height:20px;'/>";
        document.getElementById('kIcon1').innerHTML ="<img src='../img/close.png' style='width:20px; height:20px;'/>";
        document.getElementById('kIcon2').innerHTML ="<img src='../img/close.png' style='width:20px; height:20px;'/>";
        document.getElementById('kIcon3').innerHTML ="<img src='../img/close.png' style='width:20px; height:20px;'/>";

        for(i = 0; i < response.length; i++){
          var checkT_r = response[i].checkT;
          var k = response[i].k;

          if(k == 1){
            document.getElementById('kIcon'+checkT_r.toString()).innerHTML ="<img src='../img/checked.png' style='width:20px; height:20px;'/>";
          }
        }
      }
    });
  }
  /*연결 여부에 따라 웨어러블 icon 데이터를 표시하는 함수*/
  function changeWearableIcon(sensor, pmajor){
    $.ajax({
      url: "checksensor.php?roomidx="+roomidx+"&pmajor="+pmajor+"&sensor="+sensor, //받아올 내용이 있는 url
      type: "GET",
      async: true,
      dataType: "json",
      cache: false,
      success: function(response){
      }
    });
   }
  /*연결 여부에 따라 키넥트 icon 데이터를 표시하는 함수*/
  function changeKinectIcon(sensor, pmajor){
    $.ajax({
      url: "checksensor.php?roomidx="+roomidx+"&pmajor="+pmajor+"&sensor="+sensor, //받아올 내용이 있는 url
      type: "GET",
      async: true,
      dataType: "json",
      cache: false,
      success: function(response){
      }
    });
  }
  /*사용자 입장 여부에 따라 화면에 표시하는 함수*/
  function isplayer(roomidx, playerid){
    $.ajax({
      url: "isplayer.php?roomidx="+roomidx+"&playerid="+playerid, //받아올 내용이 있는 url
      type: "GET",
      async: true,
      dataType: "json",
      cache: false,
      success: function(response){
        $("#Player0").html("-");
        $("#Player1").html("-");
        $("#Player2").html("-");
        $("#Player3").html("-");

        for(i = 0; i < response.length; i++){
          var checkT_result = response[i].checkT;
          var player_result = response[i].email;

          $("#Player"+checkT_result.toString()).html(player_result); //화면에 뿌리기
          if(checkT_result == 0)
            document.getElementById('t0').innerHTML ="<img src='../img/trainer.png' style='width:130px; height:130px;'/>";
          if(checkT_result == 1)
            document.getElementById('t1').innerHTML ="<img src='../img/trainee1.png' style='width:130px; height:130px;'/>";
          if(checkT_result == 2)
            document.getElementById('t2').innerHTML ="<img src='../img/trainee2.png' style='width:130px; height:130px;'/>";
          if(checkT_result == 3)
            document.getElementById('t3').innerHTML ="<img src='../img/trainee3.png' style='width:130px; height:130px;'/>";
        }
      }
    });
  }
  /*운동 시작 버튼 활성화 & 비활성화*/
  function ablebutton(roomidx, playerid){
    $.ajax({
      url: "abledisable.php?roomidx="+roomidx+"&playerid="+playerid, //받아올 내용이 있는 url
      type: "GET",
      async: true,
      dataType: "json",
      cache: false,
      success: function(response){
        if(response.checkT > 0){ //트레이니일 경우 비활성화
          $('#startbtn').attr('disabled', true);
        }
        else{ //트레이너일 경우 모든 사용자의 연결 체크후 활성화 & 비활성화 결정
          $('#startbtn').attr('disabled', true);
          var TrainerButton = setInterval('trainerButton(roomidx)', 100);
        }
      }
    });
  }
  /*트레이너 화면의 운동 시작 버튼을 활성화*/
  function trainerButton(roomidx){
    $.ajax({
      url: "allchecking.php?roomidx="+roomidx, //받아올 내용이 있는 url
      type: "GET",
      async: true,
      dataType: "json",
      cache: false,
      success: function(response){
        if(response.checking == 1){
          $('#startbtn').attr('disabled', false);
          $('#startbtn').css("background-color","#813f7f");
        }
        else{
          $('#startbtn').attr('disabled', true);
          $('#startbtn').css("background-color","#b2afa6");
        }
      }
    });
  }
  /*운동 시작 버튼 클릭 여부 확인*/
  function clickButton(){
    $.ajax({
      url: "clickbtn.php?roomidx="+roomidx+"&playerid="+playerid,
      type: "GET",
      async: true,
      dataType: "json",
      cache: false,
      success: function(response){
      }
    });
    var win1 = window.open("ingUser.php?<?php echo "roomtitle=$roomtitle&roomidx=$roomidx&trainer=$trainer#4";?>",'_blank',"shilpijain","modal=no");
    var win2 = window.open("ingUser.php?<?php echo "roomtitle=$roomtitle&roomidx=$roomidx&trainer=$trainer#6";?>",'_blank',"shilpijain","modal=no");
    win1.focus();
    win2.focus();
  }
  /*트레이너가 운동 시작 버튼을 누른 경우, 모든 사용자가 다음 페이지로 이동*/
  function startExercise(){
    $.ajax({
      url: "startexercise.php?roomidx="+roomidx+"&playerid="+playerid,
      type: "GET",
      async: true,
      dataType: "json",
      cache: false,
      success: function(response){
        if(response.click == 1 && response.checkT == 0){
          location.href = "TMView.php?<?php echo "roomtitle=$roomtitle&roomidx=$roomidx";?>";
        }
        else if(response.click == 1 && response.checkT > 0){
          location.href = "ingUser.php?<?php echo "roomtitle=$roomtitle&roomidx=$roomidx&trainer=$trainer";?>";
        }
      }
    });
  }
  </script>
  <link href="../css/trainermode.css" rel="stylesheet"></link>
  <link href="../bootstrap-4.0.0/dist/css/bootstrap.css" rel="stylesheet"></link>
</head>
<body style="margin:8px; background:#f5c94c">
  <div id="top">
    <a href="exit_ok.php?<?php echo "roomidx=$roomidx"; ?>" style="text-decoration: none; color:black;">
    <br><img src="../img/logo.png" alt="we fit 로고" width="7%" align="center"><?php echo " $roomtitle"; ?></a>
    <input style="position: absolute; right: 0; margin-right:70px; margin-top:50px; background-color:#b2afa6;" id="startbtn" class="make" type="button" value="시작하기" onclick='clickButton()'/>
  </div>

  <div class="content-wrapper">
    <div class="container" align="center">
      <div class="card border-wefit mb-3" style="max-width: 18rem; border:4px solid #813f7f;">
        <div class="card-header bg-transparent border-wefit text-wefit text-center " style="font-family: 'a고딕16'; font-size: 20px;"><img src="../img/crown.png" style="width:25px; height:25px;"/>&nbsp<b>Trainer</b>&nbsp<img src="../img/crown.png" style="width:25px; height:25px;"/></div>
        <div class="card-body">
          <span id="t0"><img src="../img/white-question.png" style="width:130px; height:130px; margin-bottom:15px"/></span>
          <br>
          <h5 id="Player0" class="card-title" style="margin-top:10px;">-</h5>
        </div>
        <div class="card-footer bg-transparent border-wefit" style="font-family: 'a고딕16'; font-size: 13pt;">
          <span>Wearables </span>
          <span id="wIcon0"><img src="../img/close.png" style="width:20px; height:20px;"/></span>
          &nbsp
          <span>Kinect</span>
          <span id="kIcon0"><img src="../img/close.png" style="width:20px; height:20px;"/></span>
        </div>
      </div>
    </div>

    <div class="container" align="center">
      <center>
        <div class="card-deck mb-3 text-center" style="padding-left: 92px;">
          <div class="card border-wefit mb-3" style="max-width: 18rem; border:4px solid #813f7f; ">
            <div class="card-header bg-transparent border-wefit text-wefit text-center" style="font-family: 'a고딕16'; font-size: 20px;"><b>Player1</b></div>
            <div class="card-body">
              <span id="t1"><img src="../img/white-question.png" style="width:130px; height:130px; margin-bottom:15px"/></span>
              <br>
              <h5 id="Player1" class="card-title" style="margin-top:10px;">-</h5>
            </div>
            <div class="card-footer bg-transparent border-wefit" style="font-family: 'a고딕16'; font-size: 13pt;">
              <span>Wearables </span>
              <span id="wIcon1"><img src="../img/close.png" style="width:20px; height:20px;"/></span>
              &nbsp
              <span>Kinect</span>
              <span id="kIcon1"><img src="../img/close.png" style="width:20px; height:20px;"/></span>
            </div>
          </div>

          <div class="card border-wefit mb-3" style="max-width: 18rem; border:4px solid #813f7f;">
            <div class="card-header bg-transparent border-wefit text-wefit text-center" style="font-family: 'a고딕16'; font-size: 20px;"><b>Player2</b></div>
            <div class="card-body">
              <span id="t2"><img src="../img/white-question.png" style="width:130px; height:130px;margin-bottom:15px"/></span>
              <br>
              <h5 id="Player2" class="card-title" style="margin-top:10px;">-</h5>
            </div>
            <div class="card-footer bg-transparent border-wefit" style="font-family: 'a고딕16'; font-size: 13pt;">
              <span>Wearables </span>
              <span id="wIcon2"><img src="../img/close.png" style="width:20px; height:20px;"/></span>
              &nbsp
              <span>Kinect</span>
              <span id="kIcon2"><img src="../img/close.png" style="width:20px; height:20px;"/></span>
            </div>
          </div>

          <div class="card border-wefit mb-3" style="max-width:18rem; border:4px solid #813f7f;">
            <div class="card-header bg-transparent border-wefit text-wefit text-center" style="font-family: 'a고딕16'; font-size: 20px;"><b>Player3</b></div>
            <div class="card-body">
              <span id="t3"><img src="../img/white-question.png" style="width:130px; height:130px;margin-bottom:15px"/></span>
              <br>
              <h5 id="Player3" class="card-title" style="margin-top:10px;">-</h5>
            </div>
            <div class="card-footer bg-transparent border-wefit" style="font-family: 'a고딕16'; font-size: 13pt;">
              <span>Wearables </span>
              <span id="wIcon3"><img src="../img/close.png" style="width:20px; height:20px;"/></span>
              &nbsp
              <span>Kinect</span>
              <span id="kIcon3"><img src="../img/close.png" style="width:20px; height:20px;"/></span>
            </div>
          </div>

        </div>
      </center>
    </div>
  </div>
  <p align="center" style="font-family:'210 데이라잇'; font-size:18pt; margin-top:10px;">키넥트 센서와 웨어러블 기기의 블루투스를 연결해주세요!</p>
</body>
</html>
