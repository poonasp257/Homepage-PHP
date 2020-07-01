<?php
header("Content-Type: application/json; charset=utf-8'");

session_start();

$response = [ "error" => "no" ];
$userId = $_REQUEST["userId"];
$password = $_REQUEST["password"];

if (!isset($userId) || $userId == ""
	|| !isset($password) || $password == "") {
	$response['error'] = "아이디 혹은 비밀번호를 입력해주세요.";
	echo json_encode($response);
	exit;
}

$mysqli = new mysqli("127.0.0.1", "test1", "bitnami", "project_db", 3306);
if ($mysqli->connect_errno) {
	$response['error'] = "Failed to connect to MySQL: " . $mysqli -> connect_error;
	echo json_encode($response);
	exit;
}

$query = "select account_id, account_type, nickname, userid from Account 
	where userid='$userId' and passwd=sha2('$password', 224)";
$result = $mysqli->query($query);
if ($result == null) {
	$response['error'] = 'search account query error';
	echo json_encode($response);
	exit;
}

$n_rows = $result->num_rows;
if ($n_rows > 0) {
	$obj = $result->fetch_object();
	$_SESSION["account_id"] = $obj->account_id;
	$_SESSION["account_type"] = $obj->account_type;
	$_SESSION["nickname"] = $obj->nickname;
	$_SESSION["userid"] = $obj->userid;

	$response["account_id"] = $obj->account_id;
	$response["account_type"] = $obj->account_type;
}
else {
	$response["error"] = "아이디 혹은 비밀번호가 일치하지 않습니다.";
}

$result->free();
$mysqli->close();

echo json_encode($response);
?>