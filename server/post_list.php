<?php

header("Content-Type: application/json; charset=utf-8'");

session_start();

$response = [ "error" => "no" ];
$forumType = $_REQUEST["forumType"];
$pageNumber = $_REQUEST["pageNumber"];
$keyword = $_REQUEST["keyword"];

$mysqli = new mysqli("127.0.0.1", "test1", "bitnami", "project_db", 3306);
if ($mysqli->connect_errno) {
	$response['error'] = "Failed to connect to MySQL: " . $mysqli -> connect_error;
	echo json_encode($response);
	exit;
}

$keyword_condition = $keyword ? "and title like '%$keyword%'" : '';

$query = "select count(*) as count from Post 
	where forum_type='$forumType' and is_displayed = TRUE $keyword_condition";
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

$query = "select post_id, author, title, created_date, is_displayed from Post
	where forum_type='$forumType' $keyword_condition
	order by post_id desc limit $startIndex, $maxNumOfPosts";
$result = $mysqli->query($query);
if ($result == null) {
	$response['error'] = 'get all posts query error';
	echo json_encode($response);
	exit;
}

$response['postList'] = array();

while($row = $result->fetch_assoc()) {
	if ($row['is_displayed'] == '0') continue;

    $response['postList'][] = $row;
}

$result->free();
$mysqli->close();

echo json_encode($response);
?>