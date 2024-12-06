<?php

include_once('includes/mysql_connect.php');

$parameters = $_GET;
//Use Query to get the shop information
$query = "SELECT * FROM shops WHERE shop_url = '" . $parameters['shop'] . "' LIMIT 1";
$result = $mysqli->query($query);

//check if the result is empty then that means, we need to redirect to the install page
if ($result->num_rows < 1) {
    header("Location: install.php?shop=" . $_GET['shop']);
    exit();

}

$store_data = $result->fetch_assoc();

echo print_r($store_data);


// echo "hello";