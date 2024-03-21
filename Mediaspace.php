<?php
//!Dependencies
require_once '_configLoader.php';
require_once '_getGenerateSign.php';
//!Dependencies

$shopId = intval($_ENV['SHOPEE_SHOP_ID']);
$cd = $_ENV['CODE'];
$timest = time();
$partner_id = intval($_ENV['SHOPEE_PARTNER_ID']);
$partnerKey = $_ENV['SHOPEE_SECRET_KEY'];
$baseUrl = $_ENV['BASE_URL'];
$apiPath = "/api/v2/media_space/upload_image";

$body = array("code" => $cd,  "shop_id" => $shopId, "partner_id" => $partner_id);
$baseString = sprintf("%s%s%s", $partner_id, $apiPath, $timest);
$sign = hash_hmac('sha256', $baseString, $partnerKey);
$url = sprintf("%s%s?partner_id=%s&timestamp=%s&sign=%s", $baseUrl, $apiPath, $partner_id, $timest, $sign);


$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => array('image' => new CURLFILE('images\ph-11134207-7r98o-lsdn2hgweublbe_tn.jpg')),
    CURLOPT_HTTPHEADER => array(
        'Content-Type: multipart/form-data'
    ),
    CURLOPT_SSL_VERIFYHOST => false,
    CURLOPT_SSL_VERIFYPEER => false,
));


$response = curl_exec($curl);

echo $response;
