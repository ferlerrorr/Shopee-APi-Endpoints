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
$refreshToken = $_ENV['SHOPEE_REFRESH_TOKEN'];

$apiPath = "/api/v2/auth/access_token/get";
$body = array("partner_id" => $partner_id, "shop_id" => $shopId, "refresh_token" => $refreshToken);
$baseString = sprintf("%s%s%s", $partner_id, $apiPath, $timest);
var_dump($baseString);
$sign = hash_hmac('sha256', $baseString, $partnerKey);
var_dump($sign);
$url = sprintf("%s%s?partner_id=%s&timestamp=%s&sign=%s", $baseUrl, $apiPath, $partner_id, $timest, $sign);
var_dump($url);
$c = curl_init($url);
curl_setopt($c, CURLOPT_POST, 1);
curl_setopt($c, CURLOPT_POSTFIELDS, json_encode($body));
curl_setopt($c, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($c, CURLOPT_SSL_VERIFYHOST, false);
$resp = curl_exec($c);

// Check for cURL errors
if (curl_errno($c)) {
    $error_message = curl_error($c);
    echo "cURL Error: " . $error_message;
    // Handle the error appropriately, such as logging or displaying a message to the user
} else {
    // No cURL error occurred, proceed with processing the response
    $ret = json_decode($resp, true);

    // Check if there's an error in the response
    if (isset($ret)) {
        var_dump($ret);
        // Handle the API error appropriately
    }
}

// Close the cURL session
curl_close($c);
