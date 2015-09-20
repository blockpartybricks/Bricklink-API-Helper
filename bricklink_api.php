<?php
//My implementation for the Bricklink API
// ######################################################################
// CONSTANTS
// ######################################################################
// Must be defined before functions can be tested.
define("SIGN_TYPE","HMAC-SHA1");
define("CONSUMER_SECRET",""); // ConsumerSecret from bricklink
define("CONSUMER_KEY",""); // ConsumerKey from bricklink
define("VERSION","1.0");
define("TOKEN",""); // TokenValue from bricklink
define("TOKEN_SECRET",""); // TokenSecret from bricklink
define("URL_API","https://api.bricklink.com/api/store/v1");

//#######################################################################
//e-mail blockpartybricks@gmail.com with bugs
//If someone could write test cases for all methods, that would be appreciated.
//Open source, available for any use.
//You use this code at your own risk.
//#######################################################################

//Example code
//$request must be in form provided by bricklink API wiki for URI
$method='GET'; // GET, PUT, DELETE, POST are options
$request = '/items/set/4436-1/subsets';
//if providing a parameter,
$params='box=false&break_minifigs=false&break_subsets=false&instruction=true';
//otherwise, $params can be empty 
$post='{"item":{"no":"sw571","type":"Minifig"},"color_id":"0","quantity":"100","unit_price":"1000.00","new_or_used":"N","description":"A Minifigure that I test",
"remarks":"No remarks","bulk":"1","is_retain":"false","my_cost":"2.00","sale_rate":"0","is_stock_room":"true"}'; 
//only used if method is PUT, otherwise, $post can be empty string
//must be format '{"key":"value"}' singleqoute surrounding doubleqoutes, or 
//malformed JSON error

$result=bl_api_get_call($request,$method,$params,$post);
print $result;

function bl_api_get_call($request,$method,$params,$post)
{
	$request = URL_API.$request;
	//parameters must be ordered alphabetically, and end with &
	$params=explode("&",$params);
	sort($params);
	$params=implode($params,"&")."&";
	$params=substr_replace(",","%2C",$params);
    $auth=auth_create($method,$request,$params);
	$curl_url=$request."?".$params."Authorization=".$auth;
	if(!mb_detect_encoding($curl_url,'UTF-8',true)) //check if request is UTF-8 encoded
	{
		return "Request was not UTF-8 encoded";
	}
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $curl_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLINFO_HEADER_OUT,true);
    if($method=='DELETE')
    {
    	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
    }
    if($method=='PUT')
    {
    	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
    	curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    }
    if($method=='POST')
    {
    	curl_setopt($ch, CURLOPT_POST, 1);
    	curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    }
    //curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    //If you receive a certificate error, delete comment line to run.
    //However, you really should get a certificate to verify ssl, google php curl verify ssl certificate 
    //or go to http://snippets.webaware.com.au/howto/stop-turning-off-curlopt_ssl_verifypeer-and-fix-your-php-config/
    //for some helpful tips. Don't use this without SSL on a regular basis.
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    $result = curl_exec($ch);
    //curl_close($ch);
    if(!$result)
    {
    	return curl_error($ch);
    }
    else
    {
    	//only call this function if we actually made an API call
    	//added else clause to be more explicit about behavior
    	count_requests(1);
    	return $result;
    }
}
function count_requests()
{
	//doesn't do anything yet
}
function auth_create($method,$request,$params)
{
	$time = time();
    $randstr = genrandstr(10);
	$signature_basestring = $method.'&'.rawurlencode($request).'&'.rawurlencode($params.'oauth_consumer_key='.CONSUMER_KEY.'&oauth_nonce='.$randstr.'&oauth_signature_method='.SIGN_TYPE.'&oauth_timestamp='.$time.'&oauth_token='.TOKEN.'&oauth_version=1.0');
    $signature = create_signature($signature_basestring);
    return $auth = rawurlencode('{"oauth_consumer_key":"'.CONSUMER_KEY.'","oauth_nonce":"'.$randstr.'","oauth_signature_method":"'.SIGN_TYPE.'","oauth_signature":"'.$signature.'","oauth_timestamp":"'.$time.'","oauth_token":"'.TOKEN.'","oauth_version":"1.0"}');
}
function create_signature($basestring)
{ // function to create signature from signature base string
    $secretstring=CONSUMER_SECRET.'&'.TOKEN_SECRET;
    return base64_encode(hash_hmac('sha1',$basestring,$secretstring,true));
}
function genrandstr($length) 
{ // generate random strings for the signature
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randstr = '';
    for ($i = 0; $i < $length; $i++) {
        $randstr .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randstr;
}