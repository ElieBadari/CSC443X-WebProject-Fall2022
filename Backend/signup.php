<?php

include('connection.php');
include('functions.php');

$username = $email = $password = "";
$results = [];
$response = [];
$flag = true;

//validate user input for all three sign up fields

if (isset($_POST["username"]) && $_POST["username"] != ""){
    $check = $mysqli->prepare("SELECT user_id FROM users WHERE username = ?");
    $param = filter_data($_POST["username"]);
    $check->bind_param("s",$param);
    if ($check->execute()){
        $check->store_result();
        if ($check->num_rows() == 1){
            $results["username"] = false;
        }else {
            $results["username"] = true;
            $username = filter_data($_POST["username"]);
        }
    }
    $check->close();
}else {
    $results["username"] = false;
}

if (isset($_POST["email"]) && $_POST["email"] != ""){
    $check = $mysqli->prepare("SELECT user_id FROM users WHERE email = ?");
    $param = filter_data($_POST["email"]);
    $check->bind_param("s",$param);
    if ($check->execute()){
        $check->store_result();
        if ($check->num_rows() == 1){
            $results["email"] = false;
        }else {
            $results["email"] = true;
            $email = filter_data($_POST["email"]);
        }
    }
    $check->close();
}else {
    $results["email"] = false;
}

if (isset($_POST["password"]) && $_POST["password"] != ""){
    $pass = hash('sha256', filter_data($_POST["password"]));
    $results["password"] = true;
}else {
    $results["password"] = false;
}


