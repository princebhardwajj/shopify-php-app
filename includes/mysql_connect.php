<?php

$server= 'localhost';
$user= 'root'; 
$password= '';
$database= 'elana';


$mysqli = new mysqli($server, $user, $password, $database);

if (!$mysqli) {
    die('Error: ' . mysqli_connect_error());
}