<? require('../inc/common.php'); ?>

<?

checkSession();

$titleColor = chooseTitleColor($_GET["colorSelect"]); // 제목 색상 선택
$titleName = dataEncrypt($_GET["title"]); // 제목 복호화

$query  = " UPDATE diary_apply SET title = '".$titleName."', bg_color = '".$titleColor["bgColor"]."', text_color = '".$titleColor["textColor"]."' ";
$query .= " WHERE seq = ".$_GET["seq"];
//echo $query;
$row = freeQueryExecute($query);

?>