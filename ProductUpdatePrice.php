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

$path = '/api/v2/product/update_price';
$base_string = sprintf("%s%s%s%s%s", $partner_id, $path, $time_stamp, $access_token, $shop_id);
// var_dump($base_string);
$sign = generateSign($base_string, $partner_key);

$url = $host . $path . '?access_token=' . $access_token . '&partner_id=' . $partner_id . '&shop_id=' . intval($shop_id) . '&sign=' . $sign . '&timestamp=' . $time_stamp;

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
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => '{
        "item_id": 24416626450,
        "price_list": [
            {
                "original_price": 415
            }
        ]
    }',
    CURLOPT_HTTPHEADER => array(
        'Content-Type: application/json'
    ),
));

$response = curl_exec($curl);

curl_close($curl);
print_r($response);
