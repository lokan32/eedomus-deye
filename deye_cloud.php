<?php
// script créé par L2o pour eedomus
// ce script permet d'appeller l'API Deye Cloud pour récupérer des données des panneaux solaires
// https://developer.deyecloud.com/start

error_reporting(E_ALL);
ini_set("display_errors", 1);

require("eedomus.lib.php");



$api_url = 'https://eu1-developer.deyecloud.com';

$app_id = $_GET['app_id'];
$app_secret = $_GET['app_secret'];
$email = $_GET['email'];
$password = $_GET['password'];

$action = getArg('action');


// on reprend le dernier refresh_token
$refresh_token = loadVariable('refresh_token');
$expire_time = loadVariable('expire_time');

// Methodes
function sdk_deye_test($action) {
	return 'OK '.$action;
}

function sdk_deye_get_token($app_id, $app_secret, $email, $password) {
	$infoCurl = null; //pour récupérer les info curl
	$postData =  '{"appSecret":"'.$app_secret.'","email":"'.$email.'","password":"'.$password.'"}';
	$headers = array();
	$headers[] = 'Accept: application/json';
	$headers[] = 'Content-Type: application/json';
	$return = httpQuery($GLOBALS['api_url'].'/v1.0/account/token?appId='.$app_id, 'POST', $postData, NULL, $headers, false, false, $infoCurl);

	if ($infoCurl['http_code'] != 200) {
		return "Return code is $infoCurl[http_code]\n";
	}
	var_dump($return);
	$params = sdk_json_decode($return);

	return $params['refreshToken'];
}

function sdk_deye_get_stations() {

}

function sdk_deye_get_devices($station_id) {

}

function sdk_deye_get_device_latest_data($device) {

}

// Script

sdk_header('text/xml');
$xml = '<?xml version="1.0" encoding="utf8" ?>';
$xml .= '<deye>';
$xml .= '<token>';
$xml .= sdk_deye_get_token($app_id, $app_secret, $email, $password);
$xml .= '</token>';
$xml .= '</deye>';
echo $xml;

?>