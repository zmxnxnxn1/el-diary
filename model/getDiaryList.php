<? require('../inc/common.php'); ?>

<?

checkSession();

$query  = " SELECT DATE_FORMAT(start_date, '%Y-%m-%d %H:%i:%s') as start ";
$query .= " , date_add(DATE_FORMAT(end_date, '%Y-%m-%d %H:%i:%s'), interval +1 day) as end ";
$query .= " , title, seq, bg_color, text_color FROM diary_apply ";
$query .= " WHERE user_seq = ".$_SESSION["seq"]." AND del_flag = 'N' ";
//echo $query;
$row = freeQuerySelect($query);

if (!$row) exit;

for ($i=0; $i<count($row); $i++) {
	$result[$i]["start"] = $row[$i][0];
	$result[$i]["end"] = $row[$i][1];
	$result[$i]["title"] = trim(dataDecrypt($row[$i][2])); // 제목
	$result[$i]["id"] = $row[$i][3];
	$result[$i]["color"] = $row[$i][4]; // 배경색
	$result[$i]["textColor"] = $row[$i][5]; // 글자색

	if (strpos($result[$i]["start"], "00:00:00")) {  
		$result[$i]["start"] = substr($result[$i]["start"], 0, 10);
	}
	if (strpos($result[$i]["end"], "00:00:00")) {  
		$result[$i]["end"] = substr($result[$i]["end"], 0, 10);
	}

}

echo json_encode($result);

?>