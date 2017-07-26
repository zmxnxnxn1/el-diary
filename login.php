<? 

require_once('inc/common.php');

switch ($_POST["loginMode"]) {
	case "login":
		userLogin($_POST["username"], $_POST["password"]);
		break;

	case "logout":
		session_destroy();
		break;

	case "register":
		userRegister($_POST["username"], $_POST["password"]);
		break;

}

?>

<head>
	<meta charset='utf-8' />
	<script>
		location.replace('index.php');
	</script>
</head>