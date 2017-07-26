<? require('../inc/common.php'); ?>

<?

checkSession();

$query  = " UPDATE diary_apply SET start_date = '".$_GET["startDate"]."' ";
$query .= " , end_date = date_add('".$_GET["EndDate"]."', interval -1 day) ";
$query .= " WHERE seq = ".$_GET["seq"];
//echo $query;
$row = freeQueryExecute($query);

?>