<?php
include('../lock.php');

?>
<!doctype html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>WE FIT - Result Score</title>
    <script src="../js/jquery.js"></script>
    <link href="../css/trainermode.css" rel="stylesheet"></link>
    <link href="../bootstrap-4.0.0/dist/css/bootstrap.css" rel="stylesheet"></link>
  </head>
  <body style="background:#f5c94c; font-family: '210 데이라잇';">
    <div id="top">
      <a href="../SelectMode.php" style="text-decoration: none; color:black;"> <!--style추가 다원-->
        <br><img src="../img/logo.png" alt="we fit 로고" width="7%" align="center"/><?php echo "기본 모드 2"; ?>
      </a>
    </div>

    <div class="content-wrapper">

      <div class="container" align="center" style="margin-top: 50px;"> <!--style추가 다원-->
        <h3>운동 결과</h3> <!--b제거 다원-->
        <br><br>
        <table class="table table-light table-bordered table-striped" style="border-color: #fff; width: 1000px;">
          <thead style="background-color:#813f7f; color:#fff;">
            <tr>
              <th scope="col">순위</th>
              <th scope="col">ID</th>
              <th scope="col">운동 점수</th>
              <th scope="col">누적 점수</th>
            </tr>
          </thead>
          <?php
          $sql = mysqli_query($db, "SELECT email, (@real_rank := IF(@last > old_score, @real_rank := @real_rank+1, @real_rank)) AS real_rank, (@last := old_score) AS last FROM basictwo AS a, (SELECT @last := 0, @real_rank := 1 ) AS b, users WHERE a.id = users.id ORDER BY a.old_score DESC"); //(@ranking := @ranking+1) AS ranking

          while($board = mysqli_fetch_array($sql)){
            $p_id = $board['email']; //email
            $p_score = $board['last']; //score
            $p_rank = $board['real_rank']; //rank

            //echo "<script>alert('$p_id $p_score $p_rank');</script>";

            if($login_session == $p_id){
              $myscore = $p_score;
              $myrank = $p_rank;
            }
          ?>
          <tbody>
            <tr>
              <td scope="row"><img src="../img/gold-medal.png" style="width: 30px; height: 30px;"/><?php echo $p_rank; ?></td>
              <td><?php echo $p_id; ?></td>
              <td><?php echo $p_score; ?></td>
              <td><?php echo $p_score; ?></td>
            </tr>
          </tbody>
          <?php }?>
        </table>
        <br>
        <h4><?php echo "<strong> $login_session</strong>"; ?> 님의 점수는<?php echo "<strong> $myscore</strong>"; ?>점 , 순위는<?php echo "<strong> $myrank</strong>"; ?>위 입니다!</h4> <!--h5~>h4변경 다원-->
      </div>

    </div>
    <p align="center" style="margin-top:50px;"> <!--30px~>50px변경 다원-->
      <a href="BasicMode.php">
        <input class="make" type="button" value="HOME"/>
      </a>
    </p>
  </body>
</html>
