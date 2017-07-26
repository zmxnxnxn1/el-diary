<?

session_start(); // 세션 사용하기

/** 데이터베이스 접속 정보 */
$db['hostname'] = "my5510.gabiadb.com"; // 데이터베이스 주소
$db['username'] = "el2a"; // ID
$db['password'] = "alsk145123"; // PW
$db['dbname'] = "elzz"; // 데이터베이스 이름


/** 제목 색상 배열 */
// default
$titleColorArr["default"]["bgColor"] = "#3a87ad";
$titleColorArr["default"]["textColor"] = "white";

// black
$titleColorArr["black"]["bgColor"] = "black";
$titleColorArr["black"]["textColor"] = "white";

// red
$titleColorArr["red"]["bgColor"] = "red";
$titleColorArr["red"]["textColor"] = "white";



/** 복조화 key */
$encryKey = "key";

//$_SESSION["seq"] = "";

//echo $_SESSION["seq"];


// 데이터베이스 연결
function dbConnect() {
	global $db;

	$conn = new mysqli($db['hostname'], $db['username'], $db['password'], $db['dbname']) or die("MySQL Server 연결에 실패했습니다");
	mysqli_query($conn, "set names utf8");
	return $conn;
}

// 데이터베이스 연결 종료
function dbClose($conn) {
	$conn->close();
}

// 결과값을 배열로 담아준다.
function fetch_row($result) {
	$i = 0;
	$value = "";
	while ($row = mysqli_fetch_row($result)) {
		$value[$i] = $row;
		$i++;
	}
	return $value;
}

// 데이터베이스 SELECT 자유로운 쿼리
function freeQuerySelect($query) {
	$conn = dbConnect();

	$result = mysqli_query($conn, $query);
	$row = fetch_row($result);
	dbClose($conn);

	return $row;
}

// 데이터베이스 execute 자유로운 쿼리
function freeQueryExecute($query) {
	$conn = dbConnect();

	$result = mysqli_query($conn, $query);
	$id = mysqli_insert_id($conn);
	dbClose($conn);

	return $id;
}

// 세션이 있는지 체크
function checkSession() {
	if (!$_SESSION["seq"]) exit;
}

// 로그인
function userLogin($id, $pw) {

	$query  = " SELECT seq, pw FROM diary_userInfo ";
	$query .= " WHERE del_flag = 'N' AND id = '".$id."' ";
	$row = freeQuerySelect($query);

	if (crypt($pw, $row[0][1]) == $row[0][1]) {
		 $_SESSION["seq"] = $row[0][0];
	} else {
		echo "<script>alert('로그인에 실패했습니다.');</script>";
	}
		
}


// 등록
function userRegister($id, $pw) {
	$query  = " SELECT seq FROM diary_userInfo ";
	$query .= " WHERE del_flag = 'N' AND id = '".$id."' ";
	$row = freeQuerySelect($query);

	if ($row[0][0] > 0) {
		echo "<script>alert('이미 등록된 아이디 입니다.');</script>";
	} else {
		$query  = " INSERT INTO diary_userInfo(id, pw) ";
		$query .= " VALUES('".$id."', '".crypt($pw)."') ";
		$seq = freeQueryExecute($query);

		$_SESSION["seq"] = $seq;
			
		echo "<script>alert('등록을 완료하였습니다.');</script>";
	}	
}


// 데이터 암호화 (양방향)
function dataEncrypt($data) {
	global $encryKey;
	
	return base64_encode(mcrypt_ecb(MCRYPT_GOST, $encryKey, $data, MCRYPT_ENCRYPT));
}

// 데이터 암호화 (양방향)
function dataDecrypt($data) {
	global $encryKey;

	return mcrypt_ecb(MCRYPT_GOST, $encryKey, base64_decode($data), MCRYPT_DECRYPT);
}

// 제목 색상
function chooseTitleColor($colorValue) {
	global $titleColorArr;

	$color["bgColor"] = $titleColorArr[$colorValue]["bgColor"];
	$color["textColor"] = $titleColorArr[$colorValue]["textColor"];

	return $color;
}



?>