<? require('../inc/common.php'); ?>

<?

checkSession();

$query  = " UPDATE diary_apply SET del_flag = 'Y' ";
$query .= " WHERE seq = ".$_POST["seq"];
//echo $query;
$row = freeQueryExecute($query);

?>