<?php
//!Dependencies
require_once '_configLoader.php';
require_once '_getGenerateSign.php';
//!Dependencies

//? Global Variables
$partner_id = $_ENV['SHOPEE_PARTNER_ID'];
$partner_key = $_ENV['SHOPEE_SECRET_KEY'];
$host = $_ENV['BASE_URL'];
$shop_id = $_ENV['SHOPEE_SHOP_ID'];
$redirect_url = $_ENV['REDIRECT_URL'];
$time_stamp = time();
$path = "/api/v2/shop/auth_partner"; //this line is a dynamic variable depends on usage
$base_string = sprintf("%s%s%s", $partner_id, $path, $time_stamp);
//? This script was a sign generation of Products > item_list 
$sign = generateSign($base_string, $partner_key);
//? This script was a sign generation of Products > item_list 
//? Global Variables

//? This script was a auth generation of Products > item_list 
$url = sprintf("%s%s?partner_id=%s&timestamp=%s&sign=%s&redirect=%s", $host, $path, $partner_id, $time_stamp, $sign, $redirect_url);
//? This script was a auth generation of Products > item_list 

echo "Generated Url: " . $url . "\n"; // Echo 
echo "Generated Sign: " . $sign . "\n"; // Echo 
echo "Generated Timestamp: " . $time_stamp . "\n"; // Echo 


//Todo for function that consume an GET HTTP Request that can Generate a CODE and Stage to ENV for ACCESS
