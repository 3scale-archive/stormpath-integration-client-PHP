<?php
include_once "urlencode.php";
require 'vendor/autoload.php';


//Parsing all the variables from the form (passed as arguments to this script)
$username=$_GET["username"];
$password=$_GET["password"];
$threescale_client_id="";
$threescale_client_secret="";
$stormpath_app_id=$_GET["stormpath_app_id"];
$stormpath_api_key=$_GET["stormpath_api_key"];
$stormpath_api_secret=$_GET["stormpath_api_secret"];
$threescale_or_stormpath=$_GET["threescale_or_stormpath"];

//we check if we have to make the call directly to Stormpath or through 3scale
if ($threescale_or_stormpath=="threescale")
{

$threescale_client_id=$_GET["threescale_client_id"];
$threescale_client_secret=$_GET["threescale_client_secret"];
$token=get_token_through_3scale($username,$password, $threescale_client_id,$threescale_client_secret);
}
else
{

$token=get_token_from_stormpath($username,$password, $stormpath_api_key,$stormpath_api_secret,$stormpath_app_id);	
}

//we echo the token to the screen
echo $token;



function get_token_through_3scale($username,$password, $client_id,$client_secret)
{
	$sURL = "http://ec2-54-167-218-142.compute-1.amazonaws.com/oauth/token?";
	$sPD = "username=".$username."&password=".$password."&client_id=".$client_id."&client_secret=".$client_secret; // The POST Data
	
	$aHTTP = array
	  (
	  'http' => 
	    array(
	    'method'  => 'POST',
	    'header'  => 'Content-type: application/x-www-form-urlencoded',
	    'content' => $sPD
	  )
	);

	$context = stream_context_create($aHTTP);
	$contents = file_get_contents($sURL, false, $context);
	$token=json_decode($contents,TRUE);

	return($token["access_token"]);
}


function get_token_from_stormpath($username,$password, $stormpath_api_key,$stormpath_api_secret,$stormpath_app_id)
{

	
	$sURL = "https://".$stormpath_api_key.":".myUrlEncode($stormpath_api_secret)."@api.stormpath.com/v1/applications/".$stormpath_app_id."/oauth/token";
	$sPD = "grant_type=password&username=".$username."&password=".$password; // The POST Data
	$aHTTP = array
	  (
	  'http' => 
	    array(
	    'method'  => 'POST',
	    'header'  => 'Content-type: application/x-www-form-urlencoded',
	    'content' => $sPD
	  )
	);
	  
	$context = stream_context_create($aHTTP);
	$contents = file_get_contents($sURL, false, $context);
	$token=json_decode($contents,TRUE);
	
	return($token["access_token"]);
}

function store_access_token_3scale($provider_key, $service_id, $app_id, $access_token)
{
	$sURL = "http://su1.3scale.net/services/".$service_id."/oauth_access_tokens.xml";
	$sPD = "provider_key=".$provider_key."&app_id=".$app_id."&token=".$access_token; 

	$aHTTP = array
	  (
	  'http' => 
	    array(
	    'method'  => 'POST',
	    'header'  => 'Content-type: application/x-www-form-urlencoded',
	    'content' => $sPD
	  )
	);

	$context = stream_context_create($aHTTP);
	$contents = file_get_contents($sURL, false, $context);
}


?>
