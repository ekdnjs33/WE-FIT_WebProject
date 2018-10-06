<?php
include('../lock.php');
?>
<!doctype html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html" charset="utf-8">
    <title>WE FIT - BasicMode</title>
    <link href="../newcss/basicmode.css" rel="stylesheet"></link>
    <link href="../bootstrap-4.0.0/dist/css/bootstrap.css" rel="stylesheet"></link>
    <script src="../js/popup.js"></script>
    <script src="../js/jquery.js"></script>
    <script src="../bootstrap-4.0.0/dist/js/bootstrap.js"></script>
  </head>
  <body style="margin:8px;">

    <div id="top">
      <a class="mode-url" href="../SelectMode.php" style="text-decoration: none; color:black;">
      <br><img src="../img/logo.png" alt="we fit 로고" width="7%" align="center"> 기본 모드입니다!
      </a>
    </div>

    <div id="bottom">
      <p align ="right" style="margin-right:15px">
        <button type="button" id="mymodal" class="btn btn-lg" style="background-color:#813f7f;" data-toggle="modal" data-target="#myModal">
          <img src="../img/white-question.png" style="width: 30px; height: 30px;"/>
        </button>
      </p>

      <div id="container" align="center">
        <a class="mode-url" href="BMEntrance1.php" style="text-decoration: none;">
          <div class="mode2"><p style="margin-top:78px;">스쿼트 심화 운동</p>
          </div>
        </a>
        <a class="mode-url" href="BMEntrance2.php" style="text-decoration: none;">
          <div class="mode2"><p style="margin-top:78px;">런지 심화 운동</p>
          </div>
        </a>

      </div>
    </div>

  <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel">기본코스 소개</h4>
            <button type="button" class="close"  data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          </div>
          <div class="modal-body" style="font-size: 14pt;">
            스쿼트 심화 운동 : 3초간 유지 x 3회
            <br>
            런지 심화 운동 : 3초간 유지 x 좌우 2세트
            <br>
            자세한 운동 부위에 대한 설명은 클릭 후 Course Info를 참조하세요 :)

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" style="background-color:#813f7f; color:#fff; font-size: 13pt;" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>

  </body>
</html>
