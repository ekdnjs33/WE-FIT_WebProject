<?php
include('../lock.php');
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta http-equiv="Content-Type" content="text/html" charset="utf-8">
    <title>WE FIT - CreateRoom</title>
    <link href="../css/createroom.css" rel="stylesheet"></link>
    <script src="../js/jquery.js"></script>
  </head>
  <body>
    <center>
    <div id="box">
      <form method="post" action="create_ok.php">
          <div class="room-name">
              <input type="text" class="form-control" placeholder="방 이름" required="required" name="roomname" maxlength="100">
          </div>
          <div class="room-password">
              <input type="password" class="form-control" placeholder="비밀번호(숫자 4자리)" name="roompw" maxlength="4">
          </div>
          <input type="submit" class="finish" value="생성하기">
          <a href="TrainerMode.php"><input class="finish" type="button" value="닫기"></a>
      </form>
    </div>
    </center>
  </body>
</html>
