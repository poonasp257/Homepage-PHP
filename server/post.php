<?php

header("Content-Type: application/json; charset=utf-8'");

session_start();

$response = [ "error" => "no" ];
$postId = $_REQUEST["postId"];

$mysqli = new mysqli("127.0.0.1", "test1", "bitnami", "project_db", 3306);
if ($mysqli->connect_errno) {
	$response['error'] = "Failed to connect to MySQL: " . $mysqli -> connect_error;
	echo json_encode($response);
	exit;
}

$query = "select * from Post where post_id='$postId'";
$result = $mysqli->query($query);
if ($result == null) {
	$response['error'] = 'get post query error';
	echo json_encode($response);
	exit;
}

$response["post"] = $result->fetch_assoc();
$result->free();

$query = "select * from Comment where post_id='$postId'";
$result = $mysqli->query($query);
if ($result == null) {
	$response['error'] = 'get comments query error';
	echo json_encode($response);
	exit;
}

$response['comments'] = array();

while($row = $result->fetch_assoc()) {
    $response['comments'][] = $row;
}

$result->free();
$mysqli->close();

echo json_encode($response);
?>