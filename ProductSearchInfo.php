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

$path = '/api/v2/product/get_item_base_info';
$base_string = sprintf("%s%s%s", $partner_id, $path, $time_stamp);
// var_dump($base_string);
$sign = generateSign($base_string, $partner_key);


$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => $host . $path . '?access_token=' . $access_token . '&item_id_list=%5B34001%2C34002%5D&need_complaint_policy=true&need_tax_info=true&partner_id=1026497&shop_id=76746&sign=' . $sign . '&timestamp=' . $time_stamp,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_CUSTOMREQUEST => 'GET',
    CURLOPT_HTTPHEADER => array(
        'Content-Type: application/json'
    ),
));

$response = curl_exec($curl);

curl_close($curl);
var_dump($response);
