<?php

header("Content-Type: application/json; charset=utf-8'");

session_start();

$response = [ "error" => "no" ];

if (empty($_SESSION['userid'])) {
	$response["error"] = "you haven't logged.";
	echo json_encode($response);
	exit;
}
 
echo json_encode($response);

session_destroy();

?>