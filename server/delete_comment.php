<?php

header("Content-Type: application/json; charset=utf-8'");

session_start();

$response = [ "error" => "no" ];

$comment_id = $_REQUEST["comment_id"];
$author_account_id = $_REQUEST["author_account_id"];

if ($_SESSION['account_type'] != 0
    && $author_account_id != $_SESSION['account_id']) {
	$response["error"] = "권한이 없습니다.";
	echo json_encode($response);
	exit;
}

$mysqli = new mysqli("127.0.0.1", "test1", "bitnami", "project_db", 3306);
if ($mysqli->connect_errno) {
	$response['error'] = "Failed to connect to MySQL: " . $mysqli -> connect_error;
	echo json_encode($response);
	exit;
}

$query = "update Comment SET is_displayed=FALSE WHERE comment_id=$comment_id";
$result = $mysqli->query($query);
if ($result == null) {
	$response['error'] = 'get post query error';
	echo json_encode($response);
	exit;
}

$mysqli->close();

echo json_encode($response);
?>