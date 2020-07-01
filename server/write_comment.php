<?php

header("Content-Type: application/json; charset=utf-8'");

session_start();

$response = [ "error" => "no" ];

if (empty($_SESSION['userid'])) {
	$response["error"] = "you haven't logged.";
	echo json_encode($response);
	exit;
}

$mysqli = new mysqli("127.0.0.1", "test1", "bitnami", "project_db", 3306);
if ($mysqli->connect_errno) {
	$response['error'] = "Failed to connect to MySQL: " . $mysqli -> connect_error;
	echo json_encode($response);
	exit;
}

$postId = $_REQUEST["postId"];
$parent_comment_id = $_REQUEST["parent_comment_id"];
$parent_comment_id = $parent_comment_id === null ? 'null' : $parent_comment_id; 
$text = $_REQUEST["text"];

$account_id = $_SESSION["account_id"];
$author = $_SESSION["nickname"];

if ($text == "") {
	$response['error'] = '양식에 맞게 입력해주세요.';
	echo json_encode($response);
	exit;
}

$query = "insert into Comment(post_id, parent_comment_id, author_account_id, author, text) 
    values($postId, $parent_comment_id, $account_id, '$author', '$text')";
$result = $mysqli->query($query);
if ($result == null) {
	$response['error'] = 'write post query error';
	echo json_encode($response);
	exit;
}

$mysqli->close();

echo json_encode($response);
?>