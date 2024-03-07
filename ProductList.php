<?php

//! The result of this script is paginated need to consolidate the whole json collection maximum per pages is 100 products

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


//Todo Get All Products 
try {
    $path = "/api/v2/product/get_item_list"; // Path may change dynamically
    $base_string = sprintf("%s%s%s%s%s", $partner_id, $path, $time_stamp, $access_token, $shop_id);
    $sign = generateSign($base_string, $partner_key);
    $url = strval($host) . strval($path) . '?access_token=' . strval($access_token) . '&item_status=NORMAL&offset=0&page_size=100&partner_id=' . strval($partner_id) . '&shop_id=' . strval($shop_id) . '&sign=' . strval($sign) . '&timestamp=' . strval($time_stamp) . '&update_time_from=1611311600&update_time_to=' . strval($time_stamp);
    // var_dump($base_string);
    // var_dump($sign);
    // var_dump($url);
    // Generate sign for the request
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


    // Execute the cURL request
    $response = curl_exec($curl);

    // Check for cURL errors
    if (curl_errno($curl)) {
        throw new Exception('cURL error: ' . curl_error($curl));
    }

    // Print the response
    print_r($response);

    // Close cURL handle
    curl_close($curl);
} catch (Exception $e) {
    // Catch and display any exceptions
    echo 'Caught exception: ', $e->getMessage(), "\n";
    var_dump($e);
}
