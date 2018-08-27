/*10초 카운트다운하는 코드*/
<script>
var seconds = 9;
function basicServerCall(){
  $.ajax({
  	url: "http://localhost:8080/algorithm/mode1/ 트레이너 major id/사용자 major id/현재 시간",  //받아올 내용이 있는 url
    type: POST, //전송 방식(get/post)
    data: , //전송할 데이터
    dataType: "json", //요청한 데이터 타입
  	cache: false,
  	success: function(data){ //data=[{minusScore:값}]
      //전송에 성공하면 실행될 코드
      var minusScore=data;
  		//받아온 내용을 처리할 부분
      var score_result =
      var rank_result =
      $(".score").html(score_result);
      $(".rank").html(rank_result);
  	}
    error: function(){
      //전송에 실패하면 실행될 코드
    }
  }); //1초에 한번씩 받아온다
}

function trainerServerCall(tmajor, pmajor, nowtime){
  var tmajor = this.tmajor;
  var pmajor = this.pmajor;
  var nowtime = this.nowtime;
  $.ajax({
  	url: "http://localhost:8080/algorithm/mode1/ 트레이너 major id/사용자 major id/현재 시간",  //받아올 내용이 있는 url
    type: POST, //전송 방식(get/post)
    data: , //전송할 데이터
    dataType: "json", //요청한 데이터 타입
  	cache: false,
  	success: function(data){ //data=[{minusScore:값}]
      //전송에 성공하면 실행될 코드
      var minusScore=data;
  		//받아온 내용을 처리할 부분
      var score_result =
      var rank_result =
      $(".score").html(score_result);
      $(".rank").html(rank_result);
  	}
    error: function(){
      //전송에 실패하면 실행될 코드
    }
  }); //1초에 한번씩 받아온다
}

function secondPassed(){//trainermajor, playermajor, playtime
  var tmajor = trainermajor;
  var pmajor = playermajor;
  var nowtime = playtime;
  var minutes = Math.round((seconds - 30)/60);
  var remainingSeconds = seconds % 60;
    /*if (remainingSeconds < 10) {
        remainingSeconds = "0" + remainingSeconds;
    }*/
    document.getElementById('down').innerHTML = remainingSeconds;
    if(seconds==0){
      clearInterval(countdownTimer);
      document.getElementById('down').innerHTML = "start";
      //var servertimer = setInterval('trainerServerCall(tmajor, pmajor, nowtime)', 1000);
    }
    else{
      seconds--;
    }
  }
  var countdownTimer = setInterval('secondPassed()', 1000);
  </script>
