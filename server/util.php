<?php
function checkNicknameFormat($exp) {
    $regExp = "/^[가-힣0-9a-zA-Z]{1,20}$/u";
	return preg_match($regExp, $exp);
}

function checkUsernameFormat($exp) {
    $regExp = "/^[a-z0-9]{5,20}$/";
	return preg_match($regExp, $exp);
}

function checkPasswordFormat($exp) {
    $regExp = "/^(?=.*[a-zA-Z])(?=.*[0-9])[a-zA-Z0-9!@#$%^&*]{8,}$/";
	return preg_match($regExp, $exp);
}
?>