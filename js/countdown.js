/*10초 카운트다운하는 코드*/
var seconds = 9;
function secondPassed(){
  var minutes = Math.round((seconds - 30)/60);
  var remainingSeconds = seconds % 60;
    /*if (remainingSeconds < 10) {
        remainingSeconds = "0" + remainingSeconds;
    }*/
    document.getElementById('down').innerHTML = remainingSeconds;
    if(seconds==0){
      clearInterval(countdownTimer);
      document.getElementById('down').innerHTML = "--";
    }
    else{
      seconds--;
    }
  }
var countdownTimer = setInterval('secondPassed()', 1000);
