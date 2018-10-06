<?php
include('../config.php');

$minus = $_GET['minus'];
$pmajor = $_GET['pmajor'];

//수강생의 major에 따른 현재 저장된  id를 가져옴
$db_sql = mysqli_query($db, "SELECT * FROM  basictwo, users WHERE basictwo.id = users.id AND major = $pmajor");

$row = mysqli_fetch_array($db_sql);
$score = $row['score'];
$id = $row['id'];

$result = $score - $minus;

//그 수강생의 score를 감점된 점수로 갱신
$result_sql = mysqli_query($db, "UPDATE basictwo SET score = $result WHERE id = $id");

echo json_encode(array("score" => $result));
?>
