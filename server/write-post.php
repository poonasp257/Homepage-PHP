<?php

header("Content-Type: application/json; charset=utf-8'");

session_start();

$response = [ "error" => "no" ];

if (empty($_SESSION['userid'])) {
	$response["error"] = "you haven't logged.";
	echo json_encode($response);
	exit;
}

$forumType = $_REQUEST["forumType"];
$account_id = $_SESSION["account_id"];
$author = $_SESSION["nickname"];
$title = $_REQUEST["title"];
$text = $_REQUEST["text"];

if ($forumType == 0 && $_SESSION['account_type'] != 0) {
	$response['error'] = "비정상적인 접근입니다.";
	echo json_encode($response);
	exit;
}

if ($title == "" || $text == "") {
	$response['error'] = '양식에 맞게 입력해주세요.';
	echo json_encode($response);
	exit;
}

$mysqli = new mysqli("127.0.0.1", "test1", "bitnami", "project_db", 3306);
if ($mysqli->connect_errno) {
	$response['error'] = "Failed to connect to MySQL: " . $mysqli -> connect_error;
	echo json_encode($response);
	exit;
}

$query = "insert into Post(forum_type, author_account_id, author, title, text) 
    values($forumType, $account_id, '$author', '$title', '$text')";
$result = $mysqli->query($query);
if ($result == null) {
	$response['error'] = 'write post query error';
	echo json_encode($response);
	exit;
}

$mysqli->close();

echo json_encode($response);
?>