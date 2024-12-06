<?php
include_once('includes/mysql_connect.php');

$api_key='8d7659e7bc0a9d439c6ed96d51833a28';
$secret_key='4831588f1cb20d198f8b770852dbc69f';
$parameters = $_GET;
$shop_url = $parameters['shop'];
$hmac= $parameters['hmac'];
$parameters= array_diff_key($parameters, array('hmac' => ''));

$new_hmac = hash_hmac('sha256', http_build_query($parameters), $secret_key);

if(hash_equals($hmac, $new_hmac)){
    $access_token_endpoint = 'https://' . $shop_url . '/admin/oauth/access_token';

    $var = array(
        'client_id' => $api_key,
        'client_secret' => $secret_key,
        'code' => $parameters['code']
    );
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $access_token_endpoint);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, count($var));
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($var));
    $response = curl_exec($ch);
    curl_close($ch);

    $response = json_decode($response, true);

    echo print_r($response);

    $query = "INSERT INTO shops (shop_url, access_token, install_date) VALUES ('" . $shop_url . "', '" . $response['access_token'] . "', '" . date('Y-m-d H:i:s') . "') ON DUPLICATE KEY UPDATE access_token='" . $response['access_token'] . "', install_date='" . date('Y-m-d H:i:s') . "'";

    if($mysqli->query($query)){
        header("Location: https://" . $shop_url. "/admin/apps");
        exit();
    }
}else{
    echo 'This is not coming from Shopify and probably someone is trying to hack us';
}