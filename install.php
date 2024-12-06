<?php

$_API_KEY = '8d7659e7bc0a9d439c6ed96d51833a28';
$_NGROK_URL = 'https://ba07-2409-4055-18e-dd32-913e-a571-e76c-b12.ngrok-free.app';
$shop = $_GET['shop'];
$scopes = 'read_products,write_products,read_orders,write_orders';
$redirect_uri = $_NGROK_URL . '/elana/token.php';
$nonce = bin2hex( random_bytes(12) );
$access_mode = 'per-user';

$oauth_url = 'https://' . $shop . '/admin/oauth/authorize?client_id=' . $_API_KEY . '&scope=' . $scopes . '&redirect_uri=' . $redirect_uri . '&state=' . $nonce . '&access_mode=' . $access_mode;

header("Location:" . $oauth_url);
exit();
// echo $shop;