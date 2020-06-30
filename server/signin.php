<?php
	header("Content-Type: application/json; charset=utf-8'");
	$response = [ "error" => "no" ];

	session_start();

	$userid = $json["userinfo"]["userid"];
	$passwd = $json["userinfo"]["password"];

	$_SESSION["userid"] = null;

	$mysqli = new mysqli("127.0.0.1", "test1", "bitnami", "project_db", 3307);

	$sql = "select account_id, userid, name from UserAccounts where userid='" . $userid . "' and passwd=sha2('" . $passwd . "', 224)";
	$result = $mysqli->query($sql);
	if ($result == null) {
		$response['error'] = 'query error';
		echo json_encode($response);
		exit;
	}
 
	$n_rows = $result->num_rows;
	if ($n_rows == 1) {
		$obj = $result->fetch_object();
		$_SESSION["account_id"] = $obj->account_id;
		$_SESSION["userid"] = $obj->userid;
		$_SESSION["name"] = $obj->name;
	}
	else {
		$response["error"] = "not registered or not matched password.";
	}

	$result->free();
	$mysqli->close();

	echo json_encode($response);
?>