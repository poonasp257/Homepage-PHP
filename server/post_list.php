<?php

header("Content-Type: application/json; charset=utf-8'");

session_start();

$response = [ "error" => "no" ];
$forumType = $_REQUEST["forumType"];
$pageNumber = $_REQUEST["pageNumber"];

$mysqli = new mysqli("127.0.0.1", "test1", "bitnami", "project_db", 3306);
if ($mysqli->connect_errno) {
	$response['error'] = "Failed to connect to MySQL: " . $mysqli -> connect_error;
	echo json_encode($response);
	exit;
}

$query = "select count(*) as count from Post where forum_type='$forumType'";
$result = $mysqli->query($query);
if ($result == null) {
	$response['error'] = 'get all posts query error';
	echo json_encode($response);
	exit;
}

$obj = $result->fetch_assoc();
$result->free();

$maxNumOfPosts = 8;
$numOfPages = ceil($obj['count'] / $maxNumOfPosts);

$response['numOfPages'] = $numOfPages;

$startIndex = ($pageNumber - 1) * $maxNumOfPosts;

$query = "select post_id, author, title, created_date from Post
	where forum_type='$forumType' order by post_id desc limit $startIndex, $maxNumOfPosts";
$result = $mysqli->query($query);
if ($result == null) {
	$response['error'] = 'get all posts query error';
	echo json_encode($response);
	exit;
}

$response['postList'] = array();

while($row = $result->fetch_assoc()) {
    $response['postList'][] = $row;
}

$result->free();
$mysqli->close();

echo json_encode($response);
?>