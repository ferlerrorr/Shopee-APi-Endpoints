<?php
//!Dependencies
require_once '_configLoader.php';
require_once '_getGenerateSign.php';
//!Dependencies

//! Global Variables
$shop_id = intval($_ENV['SHOPEE_SHOP_ID']);
$partner_id = intval($_ENV['SHOPEE_PARTNER_ID']);
$partner_key = $_ENV['SHOPEE_SECRET_KEY'];
$access_token = $_ENV['SHOPEE_ACCESS_TOKEN'];
$host = $_ENV['BASE_URL'];
$redirect_url = $_ENV['REDIRECT_URL'];
$time_stamp = time();
//! Global Variables
$category_id_list = [102079];
$category_id_csv = implode(',', $category_id_list);

$path = '/api/v2/product/get_attribute_tree';
$base_string = sprintf("%s%s%s%s%s", $partner_id, $path, $time_stamp, $access_token, $shop_id);
// var_dump($base_string);
$sign = generateSign($base_string, $partner_key);

$url = $host . $path . '?access_token=' . $access_token . '&category_id_list=' . $category_id_csv  . '&language=zh-Hans' . '&partner_id=' . $partner_id . '&shop_id=' . intval($shop_id) . '&sign=' . $sign . '&timestamp=' . $time_stamp;
$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
    CURLOPT_HTTPHEADER => array(
        'Content-Type: application/json'
    ),
));

$response = curl_exec($curl);

curl_close($curl);
print_r($response);

// There is something wrong with the endpoint it only returns 2 response which is 
// {"error":"product.error_param","message":"Invalid category. : should use leaf category","warning":"","request_id":"e4672d3ca6ccad969363ef204622e741"}
// and 
// {"error":"","message":"","warning":"","request_id":"4a241977980463442a7e8481efcfcc41","response":{"attribute_list":[{"attribute_id":100002,"original_attribute_name":"Aquarium Decoration Type","display_attribute_name":"Aquarium Decoration Type","is_mandatory":false,"input_validation_type":"STRING_TYPE","format_type":"NORMAL","date_format_type":"YEAR_MONTH_DATE","input_type":"COMBO_BOX","attribute_unit":[],"attribute_value_list":[],"max_input_value_number":1}]}}