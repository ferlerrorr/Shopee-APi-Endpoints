<?php
// Dependencies
require_once '_configLoader.php';
require_once '_getGenerateSign.php';

// Global Variables
$shop_id = intval($_ENV['SHOPEE_SHOP_ID']);
$partner_id = intval($_ENV['SHOPEE_PARTNER_ID']);
$partner_key = $_ENV['SHOPEE_SECRET_KEY'];
$access_token = $_ENV['SHOPEE_ACCESS_TOKEN'];
$host = $_ENV['BASE_URL'];
$redirect_url = $_ENV['REDIRECT_URL'];
$time_stamp = time();

$item_id_list = [24416626450, 24516626352];
$item_id_csv = implode(',', $item_id_list);
$path = '/api/v2/product/get_item_base_info';
$base_string = sprintf("%s%s%s%s%s", $partner_id, $path, $time_stamp, $access_token, $shop_id);
$sign = generateSign($base_string, $partner_key);

$url = $host . $path . '?access_token=' . $access_token . '&item_id_list=' . $item_id_csv . '&need_complaint_policy=true&need_tax_info=true&partner_id=' . $partner_id . '&shop_id=' . $shop_id . '&sign=' . $sign . '&timestamp=' . $time_stamp;

// Debug URL
// var_dump($url);

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
if ($response === false) {
    $error = curl_error($curl);
    var_dump($error);
}
curl_close($curl);

var_dump($response);
