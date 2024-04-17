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
$apiPath = "/api/v2/auth/token/get";

$body = array("code" => $cd,  "shop_id" => $shopId, "partner_id" => $partner_id);
$baseString = sprintf("%s%s%s", $partner_id, $apiPath, $timest);
$sign = hash_hmac('sha256', $baseString, $partnerKey);
$url = sprintf("%s%s?partner_id=%s&timestamp=%s&sign=%s", $baseUrl, $apiPath, $partner_id, $timest, $sign);

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
    } else {
        // No error, proceed with your logic
        print_r($resp);
        // You can continue processing the response here
        $accessToken = $ret["access_token"];
        $newRefreshToken = $ret["refresh_token"];
        $env_update = $this->changeEnv([
            'SHOPEE_REFRESH_TOKEN'  => $newRefreshToken,
            'SHOPEE_ACCESS_TOKEN' => $accessToken
        ]);
        echo json_encode($ret);
    }
}

// Close the cURL session
curl_close($c);
