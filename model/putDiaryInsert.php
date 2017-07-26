<? require('../inc/common.php'); ?>

<?

checkSession();

$title = "My Event";
$title = dataEncrypt($title);

$query  = " INSERT INTO diary_apply(user_seq, start_date, title, bg_color, text_color) ";
$query .= " VALUES(".$_SESSION["seq"].", DATE_FORMAT('".$_GET["dateValue"]."', '%Y-%m-%d'), '".$title."', '".$_GET["bg_color"]."', '".$_GET["text_color"]."' ) ";
//echo $query;
$row = freeQueryExecute($query);

?>