<?php
$BricklinkApi = new BricklinkApi();
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
$getFeedback = $BricklinkApi->get('/feedback');
test_cases($getFeedback,"Get Order Feedback");

//Get Order Feedback Works
$getOrderFeedback = $BricklinkApi->get('/feedback/9375140');
test_cases($getOrderFeedback,"Get Order Feedback");

//Post Feedback Not tested
$postFeedback = $BricklinkApi->post('/feedback');
test_cases($postFeedback,"Post Feedback");

//Reply Feedback Not tested
$Feedback = $BricklinkApi->t('/');
test_cases($Feedback,"Feedback");

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

//Create Coupon Not tested
$params = array(
    'date_expired' => '',
    'remarks' => 'for testing',
    'currency_code' => 'EUR',
    'disp_currency_code' => 'EUR',
    'discount_amount' => '0.25');
$createCoupon = $BricklinkApi->post('/coupons',$params);
$testingCoupon1 = $createCoupon->results;
test_cases($createCoupon,"Create Coupon");

//Get Coupon Works
$getCoupon = $BricklinkApi->get('/coupons/'.$testingCoupon1->coupon_id);
test_cases($getCoupon,"Get Coupon");

//Update Coupon Not tested
$params = array(
    'discount_amount' => '10.25'
    );
$updateCoupon = $BricklinkApi->put('/coupons/'.$testingCoupon1->coupon_id,$params);
test_cases($updateCoupon,"Update Coupon");

//Delete Coupon Not tested
$deleteCoupon = $BricklinkApi->delete('/coupons/'.$testingCoupon1->coupon_id);
test_cases($updateCoupon,"Delete Coupon");

//###############################################################
//Shipping Methods
//Get shipping methods Works
$getShippingMethods = $BricklinkApi->get('/settings/shipping_methods');
test_cases($getShippingMethods,"Get Shipping Methods");

//Get shipping Method Works
$getShippingMethod = $BricklinkApi->get('/settings/shipping_methods/'$getShippingMethods->results[0]->shipping_id);
test_cases($getShippingMethod,"Get Shipping Method");

//################################################################
//Member
//Get member rating Works
$getMemberRating = $BricklinkApi->get('/members/blockpartybrick/ratings');
test_cases($getMemberRating,"Get Member Rating");

//Create Member note Not tested
$params = array();
$createMemberNote = $BricklinkApi->post('/members/blockpartybrick/notes',$params);
test_cases($createMemberNote,"Create Member Note");

//Get member note Returns malformed URI Not sure what is wrong. May be Bricklink side error
$getMemberNote = $BricklinkApi->get('/members/blockpartybrick/notes');
test_cases($getMemberNote,"Get Member Note");

//Update member Note Not tested
$params = array();
$updateMemberNote = $BricklinkApi->put('/members/blockpartybrick/notes',$params);
test_cases($updateMemberNote,"Update Member Note");

//Delete Member Note Not tested
$deleteMemberNote = $BricklinkApi->delete('/members/blockpartybrick/notes');
test_cases($deleteMemberNote,"Delete Member Note");
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
    $response=(json_decode($test_result,true)['meta']);
    if($response['message']=="OK")
    {
        $success="green";
    }
    print "<span style=\"color:".$success."\">".$test_type." : Message : ".$response['message']." Code : ".$response['code']."</span><br>";
    
}