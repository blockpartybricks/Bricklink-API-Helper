<?php

include_once('autoload.php');

$BricklinkApi = new PHPBricklinkAPI\BricklinkApi([
    'tokenValue' => '',
    'tokenSecret' => '',
    'consumerKey' => '',
    'consumerSecret' => '',
    'isDevelopment' => true
    ]);
//Example code
//Seee Bricklink API Reference http://apidev.bricklink.com/redmine/projects/bricklink-api/wiki/API_References
//
//###############################################################
//tests follow

//Get Orders Works
$getOrders = $BricklinkApi->get('/orders');
test_cases($getOrders,"Get Orders");

//Get Order Works
$getOrder = $BricklinkApi->get('/orders/'.$getOrders->results[0]->order_id);//Use an order that should have been returned.
test_cases($getOrder,"Get Order");

//Get Order Items Works
$getOrderItem = $BricklinkApi->get('/orders/'.$getOrders->results[0]->order_id.'/items');
test_cases($getOrderItem,"Get Order Items");

//Get Order Messages Works
$getOrderMessages = $BricklinkApi->get('/orders/'.$getOrders->results[0]->order_id.'/messages');
test_cases($getOrderMessages,"Get Order Messages");

//Get Order Feedback Works
$getOrderMessages = $BricklinkApi->get('/orders/'.$getOrders->results[0]->order_id.'/feedback');
test_cases($getOrderMessages,"Get Order Feedback");

//Update Order Works
$params = array(
	'remarks' => 'Test Update Order'
	);
$updateOrder = $BricklinkApi->put('/orders/'.$getOrders->results[0]->order_id,$params);
test_cases($updateOrder,"Update Order");

//Update Order Status Works
$params = array(
	'field' => 'status',
	'value' => $getOrders->results[0]->status);
$updateOrderStatus = $BricklinkApi->put('/orders/'.$getOrders->results[0]->order_id.'/status',$params);
test_cases($updateOrderStatus,"Update Order Status");

//Update Payment Status Not tested
$params = array(
	'field' => 'payment_status',
	'value' => $getOrders->results[0]->payment->status);
$updateOrderPaymentStatus = $BricklinkApi->put('/orders/'.$getOrders->results[0]->order_id.'/status',$params);
test_cases($updateOrderPaymentStatus,"Update Order Payment Status");

//Send Drive Thru Works, limited
	//Send Drive thru can take a get parameter, mail_me
	///orders/1234/drive_thru?mail_me=true
	//Our current setup does not allow us to generate a valid signature for a post
/*$sendDriveThru = $BricklinkApi->post('/orders/'.$getOrders->results[0]->order_id.'/drive_thru');
test_cases($sendDriveThru,"Send Drive Thru");*/

//############################################################
//User Inventory
//Get Inventories Works 
//$getInventories = $BricklinkApi->get('/inventories');
//test_cases($getInventories,"Get Inventories");

//Create Inventory Works
//Will respond with data about the inventory created
$testInventory = array(
    'item' => [
        'no' => 'sw571',
        'type' => 'MINIFIG'],
    'color_id' => 0,
    'quantity' => 12,
    'new_or_used' => 'U',
    'unit_price' => '1.200',
    'description' => 'Testing',
    'remarks' => 'No Remarks',
    'bulk' => 1,
    'is_retain' => false,
    'is_stock_room' => true,
    'sale_rate' => 0,
    'my_cost' => "1.000"
    );
$createInventory = $BricklinkApi->post('/inventories',$testInventory);
$testInventory1 = $createInventory->results;
test_cases($createInventory,"Create Inventory");

//Get Inventory Works
$getInventory = $BricklinkApi->get('/inventories/'.$testInventory1->inventory_id);
test_cases($getInventory,"Get Inventory");

//Create Inventories Works for multiple items
//IMPORTANT!! When you create two inventories at once, you will not have a response.
//You will not know what inventory ids have been assigned to the items you created.
$testInventory = [
    [
        'item' => [
            'no' => 'sw571',
            'type' => 'MINIFIG'],
        'color_id' => 0,
        'quantity' => 12,
        'new_or_used' => 'U',
        'unit_price' => '1.200',
        'description' => 'Testing',
        'remarks' => 'No Remarks',
        'bulk' => 1,
        'is_retain' => false,
        'is_stock_room' => true,
        'sale_rate' => 0,
        'my_cost' => "1.000"
        ],
        [
        'item' => [
            'no' => 'sw571',
            'type' => 'MINIFIG'],
        'color_id' => 0,
        'quantity' => 12,
        'new_or_used' => 'U',
        'unit_price' => '1.200',
        'description' => 'Testing',
        'remarks' => 'No Remarks',
        'bulk' => 1,
        'is_retain' => false,
        'is_stock_room' => true,
        'sale_rate' => 0,
        'my_cost' => "1.000"
        ]];
$createInventories = $BricklinkApi->post('/inventories',$testInventory);
test_cases($createInventory,"Create Inventories");

//Update Inventory Works
$testInventory = array(
    'sale_rate' => 50,
    'my_cost' => "3.000"
    );
$updateInventory = $BricklinkApi->put('/inventories/'.$testInventory1->inventory_id,$testInventory);
test_cases($updateInventory,"Update Inventory");

//Delete Inventory Works
$deleteInventory = $BricklinkApi->delete('/inventories/'.$testInventory1->inventory_id);
test_cases($deleteInventory,"Delete Inventory");
//##############################################################
//Catalog Item
//Get Item Works
$getItem = $BricklinkApi->get('/items/set/10123-1');
test_cases($getItem,"Get Item");

//Get Item Image Works
$getItemImage = $BricklinkApi->get('/items/part/87991/images/11');
test_cases($getItemImage,"Get Item Image");

//Get Supersets Works
$params = array(
    'color_id' => 11
    );
$getSupersets = $BricklinkApi->get('/items/part/87991/supersets',$params);
test_cases($getSupersets,"Get Superset");


//Get Subsets Works
$params = array(
    'box' => true,
    'instruction' => true,
    'break_minifigs' => false,
    'break_subsets' => false
    );
$getSubsets = $BricklinkApi->get('/items/set/10123-1/subsets',$params);
test_cases($getSubsets,"Get Subset");

//Get Price Guide Fails When country_code and region are set otherwise, Works
$params = array(
    'color_id' => 11,
    'guide_type' => 'sold',
    'new_or_used' => 'N'
    );
$getPriceGuide = $BricklinkApi->get('/items/part/87991/price',$params);
test_cases($getPriceGuide,"Get Price Guide");

//Get Known Colors Works
$getKnownColors = $BricklinkApi->get('/items/part/87991/colors');
test_cases($getKnownColors,"Get Known Colors");

//#############################################################
//Feedback
//Get Feedback List Works
//$getFeedback = $BricklinkApi->get('/feedback');
//test_cases($getFeedback,"Get Order Feedback");

//Get Order Feedback Works
//$getOrderFeedback = $BricklinkApi->get('/feedback/'.$getOrders->results[0]->order_id);
//test_cases($getOrderFeedback,"Get Order Feedback");

//Post Feedback Not tested
/*$params = array(
	'order_id' => $getOrders->results[0]->order_id,
	'rating' => '',
	'comment' => '');
$postFeedback = $BricklinkApi->post('/feedback',$params);
test_cases($postFeedback,"Post Feedback");*/

//Reply Feedback Not tested
/*$params = array(
	'reply' => ''
	);
$replyFeedback = $BricklinkApi->post('/feedback/'.feedback_id.'/reply',$params);
test_cases($replyFeedback,"Feedback");*/

//#############################################################
//Color
//Get Color List Works
$getColorList = $BricklinkApi->get('/colors');
test_cases($getColorList,"Get Color List");

//Get Color Works
$getColor = $BricklinkApi->get('/colors/11');
test_cases($getColor,"Get Color");

//#############################################################
//Category
//Get Category List Works
$getCategoryList = $BricklinkApi->get('/categories');
test_cases($getCategoryList,"Get Category List");

//Get Category Works
$getCategory = $BricklinkApi->get('/categories/65');
test_cases($getCategory,"Get Category");

//##############################################################
//Push Notification
//Get Notifications Works
$getNotification = $BricklinkApi->get('/notifications');
test_cases($getNotification,"Get Notifications");

//###############################################################
//Coupon
//Get Coupons Works
$params = array(
    'direction' => 'out',
    'status' => 'E,O,-S'
    );
$getCoupons = $BricklinkApi->get('/coupons',$params);
test_cases($getCoupons,"Get Coupons");

//Create Coupon Works
$params = array(
    'date_expire' => date("Y-m-d\TH:i:s.000\Z", time() + (60*60*24*31)),
    'remarks' => 'for testing',
    'currency_code' => 'EUR',
    'disp_currency_code' => 'EUR',
    'discount_amount' => '0.25',
    'buyer_name' => 'legofan1992',
    'discount_type' => 'F',
    'status' => 'O'
    );
$createCoupon = $BricklinkApi->post('/coupons',$params);
$testingCoupon1 = $createCoupon->results;
test_cases($createCoupon,"Create Coupon");

//Get Coupon Works
$getCoupon = $BricklinkApi->get('/coupons/'.$testingCoupon1->coupon_id);
test_cases($getCoupon,"Get Coupon");

//Update Coupon Works
$params = array(
    'discount_amount' => '10.25'
    );
$updateCoupon = $BricklinkApi->put('/coupons/'.$testingCoupon1->coupon_id,$params);
test_cases($updateCoupon,"Update Coupon");

//Delete Coupon Works
$deleteCoupon = $BricklinkApi->delete('/coupons/'.$testingCoupon1->coupon_id);
test_cases($updateCoupon,"Delete Coupon");

//###############################################################
//Shipping Methods
//Get shipping methods Works
$getShippingMethods = $BricklinkApi->get('/settings/shipping_methods');
test_cases($getShippingMethods,"Get Shipping Methods");

//Get shipping Method Works
$getShippingMethod = $BricklinkApi->get('/settings/shipping_methods/'.$getShippingMethods->results[0]->method_id);
test_cases($getShippingMethod,"Get Shipping Method");

//################################################################
//Member
//Get member rating Works
$getMemberRating = $BricklinkApi->get('/members/blockpartybrick/ratings');
test_cases($getMemberRating,"Get Member Rating");

//Create Member note Not tested
//$params = array();
//$createMemberNote = $BricklinkApi->post('/members/blockpartybrick/notes',$params);
//test_cases($createMemberNote,"Create Member Note");

//Get member note Returns malformed URI Not sure what is wrong. May be Bricklink side error
//$getMemberNote = $BricklinkApi->get('/members/blockpartybrick/notes');
//test_cases($getMemberNote,"Get Member Note");

//Update member Note Not tested
//$params = array();
//$updateMemberNote = $BricklinkApi->put('/members/blockpartybrick/notes',$params);
//test_cases($updateMemberNote,"Update Member Note");

//Delete Member Note Not tested
//$deleteMemberNote = $BricklinkApi->delete('/members/blockpartybrick/notes');
//test_cases($deleteMemberNote,"Delete Member Note");
//################################################################
//Item Mapping
//Get ElementID Works
$params = array(
    'color_id' => 11
    );
$getElementId = $BricklinkApi->get('/item_mapping/PART/87991',$params);
test_cases($getElementId,"Get Element ID");

//Get Item Number Works
$getItemNumber = $BricklinkApi->get('/item_mapping/6079894');
test_cases($getItemNumber,"Get Item Number");

function test_cases($test_result,$test_type)
{
    $success="red";
    if(!$test_result->hasError)
    {
        $success="green";
    }
    print "<span style=\"color:".$success."\">".$test_type." :  Code : ".$test_result->code."</span><br>";
    
}