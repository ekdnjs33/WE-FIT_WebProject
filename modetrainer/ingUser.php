<?php
include('../lock.php');

$roomtitle = $_GET['roomtitle'];
$roomidx = $_GET['roomidx'];
$trainer = $_GET['trainer'];
$player = $row['id'];

$major_sql = mysqli_query($db, "SELECT * FROM users WHERE email = '".$trainer."'");
$major_row = mysqli_fetch_array($major_sql);
$trainer_major = $major_row['major'];

$trainer_sql = mysqli_query($db, "SELECT * FROM player WHERE id='".$player."'");
$trainer_row = mysqli_fetch_array($trainer_row);
$trainerOrNot = $major_row['checkT'];

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <script type='text/javascript' src='https://cdn.scaledrone.com/scaledrone.min.js'></script>
    <meta http-equiv="Content-Type" content="text/html" charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <title>WE FIT - Playing</title>
    <script src="../js/jquery.js"></script>
    <link href="../css/inguser.css" rel="stylesheet"></link>
    <script>
    var seconds = 9;
    var pmajor = "<?php echo $player_major; ?>";
    var tmajor = "<?php echo $trainer_major; ?>";
    var roomidx = "<?php echo $roomidx; ?>";
    var playerid = "<?php echo $player; ?>";

    //1초 마다 카운트다운 함수 실행
    var countdownTimer = setInterval('secondPassed()', 1000);
    var finishExercising = setInterval('finishExercise()', 100);

    /*실시간 날짜와 시간을 받아오는 함수*/
    function getFormatDate(date){
      var year = date.getFullYear();
      var mon = (1+date.getMonth());
      mon = mon>=10?mon:'0'+mon;
      var day = date.getDate();
      day = day>=10?day:'0'+day;
      var hour = date.getHours();
      hour = hour>=10?hour:'0'+hour;
      var min = date.getMinutes();
      min = min>=10?min:'0'+min;
      var sec = date.getSeconds();
      sec = sec>=10?sec:'0'+sec;

      return year+"-"+mon+"-"+day+" "+hour+":"+min+":"+sec;
    }
    /*키넥트 서버에서 mode1을 콜하는 함수*/
    function trainerServerCall(tmajor, pmajor){
      var d = new Date();
      nowtime = getFormatDate(d);
      var allData = {tmajor, pmajor, nowtime};
      $.ajax({
      	url: "https://we-fit.co.kr:8080/algorithm/mode1/"+tmajor+"/"+pmajor+"/"+nowtime,  //받아올 내용이 있는 url
        type: "GET", //전송 방식(get/post)
        //data: allData, //전송할 데이터
        dataType: "json", //요청한 데이터 타입
      	cache: false,
      	success: function(data){
          var minusScore = data;
          trainerDB(minusScore, pmajor);
      	}
      });
    }
    /*DB에 데이터를 저장하고 불러오는 함수*/
    function trainerDB(minusScore, pmajor){
      $.ajax({
      	url: "t-database.php?minus="+minusScore+"&pmajor="+pmajor, //받아올 내용이 있는 url
        type: "GET", //전송 방식(get/post)
        dataType: "json", //요청한 데이터 타입
      	cache: false,
        async: false,
      	success: function(data){ //score와 rank 받아오기
          var minus_result = 0 - minusScore;
          var score_result = data.score;
          var rank_result = data.rank;

          $(".minus").html(minus_result);
          $(".score").html(score_result); //화면에 뿌리기
          $(".rank").html(rank_result);
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
      if(seconds == 0){
        clearInterval(countdownTimer);
        document.getElementById('down').innerHTML = "start";

        //1초마다 키넥트 서버의 mode1 콜
        var servertimer = setInterval('trainerServerCall(tmajor, pmajor)', 1000);
      }
      else{
        seconds--;
      }
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
      <div class="two1">트레이너 영상<br><br><br>
      <video id="localVideo" autoplay muted></video></div>
      <div class="two2">
        <div class="resultshow">
          <p id="down" class="countdown">10</p>
          <p class="minus">minus</p>
          <p class="now">현재 순위</p>
          <p class="rank">1</p>
          <p class="now">내 점수</p>
          <p class="score">100</p>
        </div>
        <div class="stopbtn">
          <a href="exit_ok.php?<?php echo "roomidx=$roomidx"; ?>"><input class="finish" type="button" value="중단하기"></a>
        </div>
      </div>
      <div class="two3">사용자 영상 <br><br><br>
        <video id="remoteVideo" autoplay></video></div>
    </div>
      <script >
      // Generate random room name if needed
      if (!location.hash) {
        location.hash = "<?php echo $player; ?>";
      }

      const roomHash = "location.hash.substring(1);"

      // TODO: Replace with your own channel ID
      const drone = new ScaleDrone('yiS12Ts5RdNhebyM');
      // Room name needs to be prefixed with 'observable-'
      const roomName = 'observable-' + roomHash;
      const configuration = {
        iceServers: [{
          urls: 'stun:stun.l.google.com:19302' //Google's public stun server
        }]

      };
      let room;
      let pc;


      function onSuccess() {};
      function onError(error) {
        console.error(error);
      };

      drone.on('open', error => {
        if (error) {
          return console.error(error);
        }
        room = drone.subscribe(roomName);
        room.on('open', error => {
          if (error) {
            onError(error);
          }
        });
        // We're connected to the room and received an array of 'members'
        // connected to the room (including us). Signaling server is ready.
        room.on('members', members => {
          console.log('MEMBERS', members);
          // If we are the second user to connect to the room we will be creating the offer
          const isOfferer = members.length === 2;
          startWebRTC(isOfferer);
        });
      });

      // Send signaling data via Scaledrone
      function sendMessage(message) {
        drone.publish({
          room: roomName,
          message
        });
      }

      function startWebRTC(isOfferer) {
        pc = new RTCPeerConnection(configuration); //local과 remote peer 사이의 connection 의미

        // 'onicecandidate' notifies us whenever an ICE agent needs to deliver a
        // message to the other peer through the signaling server
        pc.onicecandidate = event => {
          if (event.candidate) {
            sendMessage({'candidate': event.candidate});
          }
        };

        // If user is offerer let the 'negotiationneeded' event create the offer
        if (isOfferer) {
          pc.onnegotiationneeded = () => {
            pc.createOffer().then(localDescCreated).catch(onError);
          }
        }
        var ifTrainer = "<?php echo $trainerOrNot; ?>";
        if(ifTrainer == 0){ //if trainer
        // When a remote stream arrives display it in the #remoteVideo element
          pc.ontrack = event => {
            const stream = event.streams[0];
            if (!remoteVideo.srcObject || remoteVideo.srcObject.id !== stream.id) {
              remoteVideo.srcObject = stream;
            }
          };

          navigator.mediaDevices.getUserMedia({
            audio: true,
            video: true,
          }).then(stream => {
            // Display your local video in #localVideo element
            localVideo.srcObject = stream;
            // Add your stream to be sent to the conneting peer
            stream.getTracks().forEach(track => pc.addTrack(track, stream));
          }, onError);
        }
        else{ //if trainee
          pc.ontrack = event => {
            const stream = event.streams[0];
            if (!remoteVideo.srcObject || remoteVideo.srcObject.id !== stream.id) {
              localVideo.srcObject = stream;
            }
          };

          navigator.mediaDevices.getUserMedia({
            audio: true,
            video: true,
          }).then(stream => {
            // Display your local video in #localVideo element
            remoteVideo.srcObject = stream;
            // Add your stream to be sent to the conneting peer
            stream.getTracks().forEach(track => pc.addTrack(track, stream));
          }, onError);
        }
        // Listen to signaling data from Scaledrone
        room.on('data', (message, client) => {
          // Message was sent by us
          if (client.id === drone.clientId) {
            return;
          }

          if (message.sdp) {
            // This is called after receiving an offer or answer from another peer
            pc.setRemoteDescription(new RTCSessionDescription(message.sdp), () => {
              // When receiving an offer lets answer it
              if (pc.remoteDescription.type === 'offer') {
                pc.createAnswer().then(localDescCreated).catch(onError);
              }
            }, onError);
          } else if (message.candidate) {
            // Add the new ICE candidate to our connections remote description
            pc.addIceCandidate(
              new RTCIceCandidate(message.candidate), onSuccess, onError
            );
          }
        });
      }

      function localDescCreated(desc) {
        pc.setLocalDescription(
          desc,
          () => sendMessage({'sdp': pc.localDescription}),
          onError
        );
      }
      </script>
  </body>
</html>
