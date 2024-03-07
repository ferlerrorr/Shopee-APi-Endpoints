<?php
// signature_helper.php
function generateSign($base_string, $partner_key)
{
    if ($partner_key !== null) {
        return hash_hmac('sha256', $base_string, $partner_key);
    } else {
        return "Error: Partner key is null.";
    }
}
