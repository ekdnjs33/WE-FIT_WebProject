<?php
include('../lock.php');

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
      <a href="../SelectMode.php" style="text-decoration: none; color:black;">
        <br><img src="../img/logo.png" alt="we fit 로고" width="7%" align="center"/><?php echo " $roomtitle"; ?>
      </a>
    </div>

    <div class="content-wrapper">

      <div class="container" align="center" style="margin-top: 50px;">
        <!--<h3>운동 결과</h3> -->
        <br><br>
        <table class="table table-light table-bordered table-striped" style="border-color: #fff; width: 1000px; font-family: 'a고딕13'; font-size:15pt;">
          <thead style="background-color:#813f7f; color:#fff;">
            <tr>
              <th scope="col">순위</th>
              <th scope="col">ID</th>
              <th scope="col">운동 점수</th>
            </tr>
          </thead>
          <?php $sql = mysqli_query($db, "SELECT idx, email, score, (SELECT COUNT(*)+1 FROM player WHERE score > b.score) AS ranking FROM player AS b, users WHERE b.id = users.id AND b.idx = $roomidx AND b.checkT > 0 ORDER BY ranking ASC");
          while($board = mysqli_fetch_array($sql)){
            $p_id = $board['email'];
            $p_score = $board['score'];
            $p_rank = $board['ranking']-1;

            if($login_session == $p_id){
              if($myscore == 100){
                $myscore = $p_score;
                $myrank = $p_rank+1;
              }
              else{
                $myscore = $p_score;
                $myrank = $p_rank;
              }
            }
          ?>
          <tbody>
            <tr>
              <td scope="row"><?php if($p_rank == 1){
                echo '<img src="../img/gold-medal.png" style="width: 30px; height: 30px;"/>';
              } echo $p_rank; ?></td>
              <td><?php echo $p_id; ?></td>
              <td><?php echo $p_score; ?></td>
            </tr>
          </tbody>
          <?php } ?>
        </table>
        <br><br>
        <h3><?php echo " $login_session"; ?> 님의 점수는<?php echo "<strong> $myscore</strong>"; ?> 점 , 순위는<?php echo "<strong> $myrank</strong>"; ?> 위 입니다!</h3>
      </div>

    </div>
    <p align="center" style="margin-top:50px;">
      <a href="exit_ok.php?<?php echo "roomidx=$roomidx"; ?>">
        <input class="make" type="button" value="HOME"/>
      </a>
    </p>
  </body>
</html>
