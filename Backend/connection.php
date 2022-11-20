<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: X-Requested-With");

$db_host = "localhost";
$db_user = "root";
$db_pass = null;
$db_name = "toastdb";

$mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);