<?php
include('lock.php');

$roomtitle = $_GET['roomtitle'];
$roomidx = $_GET['roomidx'];
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
        <br><img src="../img/logo.png" alt="we fit 로고" width="7%" align="center"/><?php echo " $roomtitle"; ?>
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
          <?php $sql = mysqli_query($db, "SELECT idx, email, score, (SELECT COUNT(*)+1 FROM player WHERE score > b.score) AS ranking FROM player AS b, users WHERE b.id = users.id AND b.idx = $roomidx AND b.checkT > 0 ORDER BY ranking ASC");
          while($board = mysqli_fetch_array($sql)){
            $p_id = $board['email'];
            $p_score = $board['score'];
            $p_rank = $board['ranking'];
          ?>
          <tbody>
            <tr>
              <td scope="row"><img src="../img/gold-medal.png" style="width: 30px; height: 30px;"/><?php echo $p_rank; ?></td>
              <td><?php echo $p_id; ?></td>
              <td><?php echo $p_score; ?></td>
              <td><?php echo $p_score; ?></td>
            </tr>
          </tbody>
          <?php } ?>
        </table>
        <?php $rank_sql = mysqli_query($db, "SELECT score, (SELECT COUNT(*)+1 FROM player GROUP BY idx HAVING score > b.score) AS ranking FROM player AS b WHERE id = $login_session ORDER BY ranking ASC");

        $rank_row = mysqli_fetch_array($rank_sql);
        $r_score = $rank_row['score'];
        $r_rank = $rank_row['ranking'];
        ?>
        <br>
        <h4>나의 점수는<?php echo " $r_score"; ?>점 , 순위는<?php echo " $r_rank"; ?>위입니다!</h4> <!--h5~>h4변경 다원-->
      </div>

    </div>
    <p align="center" style="margin-top:50px;"> <!--30px~>50px변경 다원-->
      <a href="exit_ok.php?<?php echo "roomidx=$roomidx"; ?>">
        <input class="make" type="button" value="HOME"/>
      </a>
    </p>
  </body>
</html>
