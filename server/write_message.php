<?php

include "parse_input.php";
	
header("Content-Type: application/json; charset=utf-8'");

session_start();

$response = [ "error" => "no" ];

if (empty($_SESSION['userid'])) {
    $response["error"] = "you haven't logged.";
    echo json_encode($response);
    exit;
}

$account_id = $_SESSION['account_id'];
$userid = $_SESSION['userid'];
$author = $_SESSION['name'];
$message = $json['message'];

$mysqli = new mysqli("127.0.0.1", "test1", "bitnami", "exam_db", 3307);

$write_query = "insert into Messages(account_id, author, text) values($account_id, '$author', '$message')";
$result = $mysqli->query($write_query);
if ($result == null) {
    $response['error'] = 'query error';
    echo json_encode($response);
    exit;
}

$mysqli->close();

echo json_encode($response);
?>