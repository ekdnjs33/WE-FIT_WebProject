<?php
/*로그아웃 코드*/
echo '<meta http-equiv="Content-Type" content="text/html" charset="utf-8">';
echo "<body style='background:#f5c94c'>";

include('lock.php');
session_destroy();

echo '<script type = "text/javascript">alert("로그아웃 되었습니다.")</script>';
echo "<meta http-equiv='refresh' content='0; url=index.html'>";

/*else{
  echo '<script type = "text/javascript">alert("로그아웃하지 못했습니다.")</script>';
  echo "<meta http-equiv='refresh' content='0; url=/'>";
}*/
?>
