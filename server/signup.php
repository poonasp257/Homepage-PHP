<?php
include "util.php";

header("Content-Type: application/json; charset=utf-8'");

session_start();

$response = [ "error" => "no" ];
$nickname = $_REQUEST["nickname"];
$userId = $_REQUEST["userId"];
$password = $_REQUEST["password"];

if (!checkNicknameFormat($nickname)) {
	$response["error"] = "닉네임은 특수문자, 공백을 제외한 20자 이하로 구성되어야 합니다.";
	echo json_encode($response);
	exit;
}
else if (!checkUsernameFormat($userId)) {
	$response["error"] = "아이디는 5~20자의 영소문자의 조합으로 구성되어야 합니다.";
	echo json_encode($response);
	exit;
}
else if (!checkPasswordFormat($password)) {
	$response["error"] = "비밀번호는 최소 8자 이상이어야 합니다.";
	echo json_encode($response);
	exit;
}

$mysqli = new mysqli("127.0.0.1", "test1", "bitnami", "project_db", 3306);
if ($mysqli->connect_errno) {
	$response['error'] = "Failed to connect to MySQL: " . $mysqli -> connect_error;
	echo json_encode($response);
	exit;
}

$query = "select * from Account where nickname='$nickname'";
$result = $mysqli->query($query);
if ($result == null) {
	$response['query'] = $query;
	$response['error'] = "nickname search query error";
 	echo json_encode($response);
 	exit;
}

$n_rows = $result->num_rows;
$result->free();

if ($n_rows > 0) {
	$response['error'] = "이미 존재하는 닉네임입니다.";
	echo json_encode($response);
	exit;
}

$query = "select * from Account where userid='$userId'";
$result = $mysqli->query($query);
if ($result == null) {
	$response['error'] = "userid search query error";
 	echo json_encode($response);
 	exit;
}

$n_rows = $result->num_rows;
$result->free();

if ($n_rows > 0) {
	$response['error'] = "이미 존재하는 아이디입니다.";
	echo json_encode($response);
	exit;
}

$query = "insert into Account(nickname, userid, passwd) values('$nickname', '$userId', sha2('$password', 224))";
$result = $mysqli->query($query);
if ($result == null) {
	$response['error'] = "create account query error";
 	echo json_encode($response);
 	exit;
}

$mysqli->close();

echo json_encode($response);
?>