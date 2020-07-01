<?php

header("Content-Type: application/json; charset=utf-8'");

session_start();

$response = [ "error" => "no" ];

$mysqli = new mysqli("127.0.0.1", "test1", "bitnami", "project_db", 3306);
if ($mysqli->connect_errno) {
	$response['error'] = "Failed to connect to MySQL: " . $mysqli -> connect_error;
	echo json_encode($response);
	exit;
}

$maxNumOfPosts = 5;

$query = "(select post_id, forum_type, title from Post where forum_type='0' order by post_id desc limit $maxNumOfPosts)
    union all (select post_id, forum_type, title from Post where forum_type='1' order by post_id desc limit $maxNumOfPosts)";
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