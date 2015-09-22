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
//Example code
//$request must be in form provided by bricklink API wiki for URI
//$request = '/items/set/10123-1/subsets';
//$params='';
//$method='GET'; // GET, PUT, DELETE, POST are options
//$post='{"item":{"no":"sw571","type":"Minifig"},"color_id":"0","quantity":"100","unit_price":"1000.00","new_or_used":"N","description":"A Minifigure that I test",
//"remarks":"No remarks","bulk":"1","is_retain":"false","my_cost":"2.00","sale_rate":"0","is_stock_room":"true"}'; 
//###############################################################
//tests follow
//Get Orders Works
$request='/orders';$params='';$method='GET';test_cases(bl_api_get_call($request,$method,$params),"Get Orders".$request);
//Get Order Works
$request='/orders/5684751';$params='';$method='GET';test_cases(bl_api_get_call($request,$method,$params),"Get Order".$request);
//Get Order Items Works
$request='/orders/5684751/items';$params='';$method='GET';test_cases(bl_api_get_call($request,$method,$params),"Get Order Items".$request);
//Get Order Messages Works
$request='/orders/5684751/messages';$params='';$method='GET';test_cases(bl_api_get_call($request,$method,$params),"Get Order Messages".$request);
//Get Order Feedback Works
$request='/orders/5684751/feedback';$params='';$method='GET';test_cases(bl_api_get_call($request,$method,$params),"Get Order Feedback".$request);
//Update Order Not tested
$request='';$params='';$method='';test_cases(bl_api_get_call($request,$method,$params),"Update Order".$request);
//Update Order Status Not tested
$request='';$params='';$method='';test_cases(bl_api_get_call($request,$method,$params),"Update Status".$request);
//Update Payment Status Not tested
$request='';$params='';$method='';test_cases(bl_api_get_call($request,$method,$params),"Update Payment Status".$request);
//Send Drive Thru Not tested
$request='';$params='';$method='';test_cases(bl_api_get_call($request,$method,$params),"Send Drive Thru".$request);
//############################################################
//User Inventory
//Get Inventories //Works 
$method='GET';$request='/inventories';$params='';test_cases(bl_api_get_call($request,$method,$params),"Get Inventories".$request);
//Get Inventory Works
$method='GET';$request='/inventories/62529738';$params='';test_cases(bl_api_get_call($request,$method,$params),"Get Inventory".$request);
//Create Inventory Works
$method='POST';$request='/inventories';$params='{"item": {"no":"sw571", "type":"MINIFIG"}, "color_id":"0", "quantity":"12", "new_or_used":"U", "unit_price":"1.2000", "description":"Testing", "remarks":"No Remarks", "bulk":"1", "is_retain":"false", "is_stock_room":"true", "date_created":'.time().', "sale_rate":"0", "my_cost":"1.0000"}';test_cases(bl_api_get_call($request,$method,$params),"Create Inventory".$request);
//Create Inventories Works for one inventory
$method='POST';$request='/inventories';$params='{"item": {"no":"sw571", "type":"MINIFIG"}, "color_id":"0", "quantity":"12", "new_or_used":"U", "unit_price":"1.2000", "description":"Testing", "remarks":"No Remarks", "bulk":"1", "is_retain":"false", "is_stock_room":"true", "date_created":'.time().', "sale_rate":"0", "my_cost":"1.0000"}';test_cases(bl_api_get_call($request,$method,$params),"Create Inventories".$request);
//Update Inventory Works
$method='PUT';$request='/inventories/80700951';$params='{"inventory_id":"80700951","quantity":"+100","unit_price":"1000.00","new_or_used":"N","description":"A Minifigure that I test",
"remarks":"No remarks","bulk":"1","is_retain":"false","my_cost":"2.00","sale_rate":"0","is_stock_room":"true"}';test_cases(bl_api_get_call($request,$method,$params),"Update Inventory".$request);
//Delete Inventory Works
$method='DELETE';$request='/inventories/80702200';$params='';test_cases(bl_api_get_call($request,$method,$params),"Delete Inventory".$request);
//##############################################################
//Catalog Item
//Get Item Works
$method='GET';$request='/items/set/10123-1';$params='';test_cases(bl_api_get_call($request,$method,$params),"Get Item".$request);
//Get Item Image Works
$method='GET';$request='/items/part/87991/images/11';$params='';test_cases(bl_api_get_call($request,$method,$params),"Get Item Image".$request);
//Get Supersets Works
$method='GET';$request='/items/part/87991/supersets';$params='color_id=11';test_cases(bl_api_get_call($request,$method,$params),"Get Supersets".$request);
//Get Subsets Works
$method='GET';$request='/items/set/10123-1/subsets';$params='box=true&instruction=true&break_minifigs=false&break_subsets=false';test_cases(bl_api_get_call($request,$method,$params),"Get Subsets".$request);
//Get Price Guide Fails When country_code and region are set otherwise, Works
$method='GET';$request='/items/part/87991/price';$params='color_id=11&guide_type=sold&new_or_used=N';test_cases(bl_api_get_call($request,$method,$params),"Get Price Guide".$request);
//Get Known Colors Works
$method='GET';$request='/items/part/87991/colors';$params='';test_cases(bl_api_get_call($request,$method,$params),"Get Known Colors".$request);
//#############################################################
//Feedback
//Get Feedback List Works
$method='GET';$request='/feedback';$params='';test_cases(bl_api_get_call($request,$method,$params),"Get Feedback List".$request);
//Get Feedback Works
$method='GET';$request='/feedback/9375140';$params='';test_cases(bl_api_get_call($request,$method,$params),"Get Feedback".$request);
//Post Feedback Not tested
$method='';$request='';$params='';test_cases(bl_api_get_call($request,$method,$params),"Post feedback".$request);
//Reply Feedback Not tested
$method='';$request='';$params='';test_cases(bl_api_get_call($request,$method,$params),"Reply Feedback".$request);
//#############################################################
//Color
//Get Color List Works
$method='GET';$request='/colors';$params='';test_cases(bl_api_get_call($request,$method,$params),"Get Color List".$request);
//Get Color Works
$method='GET';$request='/colors/11';$params='';test_cases(bl_api_get_call($request,$method,$params),"Get Color Info".$request);
//#############################################################
//Category
//Get Category List Works
$method='GET';$request='/categories';$params='';test_cases(bl_api_get_call($request,$method,$params),"Get Category List".$request);
//Get Category Works
$method='GET';$request='/categories/65';$params='';test_cases(bl_api_get_call($request,$method,$params),"Get Category".$request);
//##############################################################
//Push Notification
//Get Notifications Works
$method='GET';$request='/notifications';$params='';test_cases(bl_api_get_call($request,$method,$params),"Get Notifications".$request);
//###############################################################
//Coupon
//Get Coupons Works
$method='GET';$request='/coupons';$params='direction=out&status=E,O,-S';test_cases(bl_api_get_call($request,$method,$params),"Get Coupons".$request);
//Get Coupon //Works
$method='GET';$request='/coupons/1075368';$params='';test_cases(bl_api_get_call($request,$method,$params),"Get Coupon".$request);
//Create Coupon Not tested
$method='POST';$request='/coupons';$params='{"coupon_id":"3456789","date_issued":"'.time().'","date_expired":"2016-01-01T12:00:00.000Z","remarks":"for you","currency_code":"EUR";"disp_currency_code":"EUR";"discount_amount":"0.25"}';test_cases(bl_api_get_call($request,$method,$params),"Create Coupon".$request);
//Update Coupon Not tested
$method='PUT';$request='/coupons/3456789';$params='{"remarks":"for you","currency_code":"EUR";"disp_currency_code":"EUR";"discount_amount":"10.25"}';test_cases(bl_api_get_call($request,$method,$params),"Update Coupon".$request);
//Delete Coupon Not tested
$method='DELETE';$request='/coupons/3456789';$params='';test_cases(bl_api_get_call($request,$method,$params),"Delete Coupon".$request);
//###############################################################
//Shipping Methods
//Get shipping methods Works
$method='GET';$request='/settings/shipping_methods';$params='';test_cases(bl_api_get_call($request,$method,$params),"Get Shipping Methods".$request);
//Get shipping Method Works
$method='GET';$request='/settings/shipping_methods/21087';$params='';test_cases(bl_api_get_call($request,$method,$params),"Get Shipping method".$request);
//################################################################
//Member
//Get member rating Works
$method='GET';$request='/members/blockpartybrick/ratings';$params='';test_cases(bl_api_get_call($request,$method,$params),"Get member rating".$request);
//Get member note Returns malformed URI Not sure what is wrong. May be Bricklink side error
$method='GET';$request='/members/blockpartybrick/notes';$params='';test_cases(bl_api_get_call($request,$method,$params),"Get member note".$request);
//Create Member note Not tested
$method='';$request='';$params='';test_cases(bl_api_get_call($request,$method,$params),"Create Member Note".$request);
//Update member Note Not tested
$method='';$request='';$params='';test_cases(bl_api_get_call($request,$method,$params),"Update Member note".$request);
//Delete Member Note Not tested
$method='';$request='';$params='';test_cases(bl_api_get_call($request,$method,$params),"Delete Member note".$request);
//################################################################
//Item Mapping
//Get ElementID Works
$method='GET';$request='/item_mapping/PART/87991';$params='color_id=11';test_cases(bl_api_get_call($request,$method,$params),"Get ElementID".$request);
//Get Item Number Works
$method='GET';$request='/item_mapping/6079894';$params='';test_cases(bl_api_get_call($request,$method,$params),"Get Item Number".$request);

function test_cases($test_result,$test_type)
{
    $success="red";
    $response=(json_decode($test_result,true)['meta']);
    if($response['message']=="OK")
    {
        $success="green";
    }
    print "<span style=\"color:".$success."\">".$test_type." : Message : ".$response['message']." Code : ".$response['code']."</span><br>";
    
}
function bl_api_get_call($request,$method,$params="")
{
    if($request=="")
    {
        return;
    }
    $request = URL_API.$request; 
    $auth=auth_create($method,$request,$params);
    $curl_url=$request."?Authorization=".$auth;
    if("GET"==$method)
    {
        $curl_url=$request."?".$params."&Authorization=".$auth;
    }
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
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
    }
    if($method=='POST')
    {
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
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
function auth_create($method,$request,$params="")
{
    $time = time();
    $randstr = genrandstr(10);

    $ordered_str='oauth_consumer_key='.CONSUMER_KEY.'&oauth_nonce='.$randstr.'&oauth_signature_method='.SIGN_TYPE.'&oauth_timestamp='.$time.'&oauth_token='.TOKEN.'&oauth_version=1.0';
    if($method=="GET" && ""!=$params)
    {
        $ordered_str=$params.'&oauth_consumer_key='.CONSUMER_KEY.'&oauth_nonce='.$randstr.'&oauth_signature_method='.SIGN_TYPE.'&oauth_timestamp='.$time.'&oauth_token='.TOKEN.'&oauth_version=1.0';
        //parameters must be ordered alphabetically, and end with &
        $ordered_str=explode("&",$ordered_str);
        sort($ordered_str);
        $ordered_str=implode($ordered_str,"&");
    }
    $signature_basestring = $method.'&'.rawurlencode($request).'&'.rawurlencode($ordered_str);
    $signature = create_signature($signature_basestring);
    return $auth = rawurlencode('{"oauth_consumer_key":"'.CONSUMER_KEY.'","oauth_nonce":"'.$randstr.'","oauth_signature_method":"'.SIGN_TYPE.'","oauth_signature":"'.$signature.'","oauth_timestamp":"'.$time.'","oauth_token":"'.TOKEN.'","oauth_version":"1.0"}');
}
function create_signature($basestring)
{ // function to create signature from signature base string
    $secretstring=CONSUMER_SECRET.'&'.TOKEN_SECRET;
    return base64_encode(hash_hmac('sha1',$basestring,$secretstring,true));
}
function genrandstr($length=20) 
{ // generate random strings for the signature
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randstr = '';
    for ($i = 0; $i < $length; $i++) {
        $randstr .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randstr;
}
function e_print_r($arr)
{
    print "<pre>";
    print_r($arr);
    print "</pre>";
}