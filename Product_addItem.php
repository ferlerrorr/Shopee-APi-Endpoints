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
$category = 102073;
$path = '/api/v2/product/add_item';
$base_string = sprintf("%s%s%s%s%s", $partner_id, $path, $time_stamp, $access_token, $shop_id);
// var_dump($base_string);
$sign = generateSign($base_string, $partner_key);

$url = $host . $path . '?access_token=' . $access_token   . '&partner_id=' . $partner_id . '&shop_id=' . intval($shop_id) . '&sign=' . $sign . '&timestamp=' . $time_stamp;
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
   CURLOPT_HTTPHEADER => array(
      'Content-Type: application/json'
   ),
   CURLOPT_POSTFIELDS => '{
    "attribute_list": [
        {
            "attribute_id": 4990,
            "attribute_value_list": [
                {
                    "original_value_name": "Brand",
                    "value_id": 32142,
                    "value_unit": " kg"
                }
            ]
        }
    ],
    "brand": {
        "brand_id": 0,
        "original_brand_name": "nike"
    },
    "category_id": 102086,
    "condition": "NEW",
    "description": "item description test",
    "description_info": {
        "extended_description": {
            "field_list": [
                {
                    "field_type": "text",
                    "text": "test"
                }
            ]
        }
    },
    "description_type": "extended", 
    "dimension": {
        "package_height": 11,
        "package_length": 11,
        "package_width": 11
    },
    "image": {
        "image_id_list": [
            "https://cf.shopee.sg/file/sg-11134201-7rd51-lu7lmm7s2uyob1"
        ]
    },
    "item_dangerous": 0,
    "item_name": "Item Name Example_11",
    "item_sku": "-",
    "item_status": "UNLIST",
    "logistic_info": [
        {
            "enabled": true,
            "logistic_id": 80101
        }
    ],
    "normal_stock": 33,
    "original_price": 123.3,
    "pre_order": {
        "days_to_ship": 3,
        "is_pre_order": true
    },
    "seller_stock": [
        {
            "stock": 0
        }
    ],
    "weight": 1.1,
    "wholesale": [
        {
            "max_count": 100,
            "min_count": 1,
            "unit_price": 28.3
        }
    ]
}'
));

$response = curl_exec($curl);

curl_close($curl);
print_r($response);
