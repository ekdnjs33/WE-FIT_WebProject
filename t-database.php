<?php
include('config.php');

$json_data = $_POST['triData'];
$value = json_decode(stripcslashes($json_data));

$minus=$value['minus'];
$pmajor=$value['pmajor'];

//수강생의 major에 따른 현재 저장된 score, id, idx를 가져옴
$db_sql=mysqli_query($db, "SELECT * FROM player, users WHERE users.id=player.id AND major='".$pmajor."'");

$row=mysqli_fetch_array($db_sql);
$score=$row['score'];
$id=$row['id'];
$idx=$row['idx'];

$result=$score-$minus;
//그 수강생의 score를 감점된 점수로 갱신
$result_sql=mysqli_query($db, "UPDATE player SET score=$result WHERE id=$id");

//현재 같은 방 수강생끼리의 순위를 비교하여 가져옴
$rank_sql=mysqli_query($db, "SELECT idx, id, checkT, score, (SELECT COUNT(*)+1 FROM player WHERE score > b.score AND idx=$idx) AS rank FROM player AS b WHERE id=$id ORDER BY rank ASC");

$rank_row=mysqli_fetch_array($rank_sql);
$rank=$rank_row['rank'];

echo(json_encode(array("score" => $result, "rank" => $rank)));
?>
