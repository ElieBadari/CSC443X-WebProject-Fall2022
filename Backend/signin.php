<?php

include("connection.php");
include("functions.php");

$username = $password = "";
$results = [];
$response = [];
$flag = true;

if (isset($_POST["username"]) && $_POST["username"] != ""){
    $check = $mysqli->prepare("SELECT user_id FROM users WHERE username = ?");
    $param = filter_data($_POST["username"]);
    $check->bind_param("s",$param);
    if ($check->execute()){
        $check->store_result();
        if ($check->num_rows() == 1){
            $results["username"] = true;
            $username = filter_data($_POST["username"]);
        }else {
            $results["username"] = false;
            
        }
    }
    $check->close();
}else {
    $results["username"] = false;
}

if (isset($_POST["password"]) && $_POST["password"] != ""){
    $password = hash('sha256', filter_data($_POST["password"]));
    $check = $mysqli->prepare("SELECT user_id FROM users WHERE username = ? AND password = ?");
    $check->bind_param("ss",$username,$password);
    if ($check->execute()){
        $check->store_result();
        if ($check->num_rows() == 1){
            $results["password"] = true;
        }else {
            $results["password"] = false;
        }
    }
    $check->close();
}else {
    $results["password"] = false;
}

foreach ($results as $key => $value){
    if (!$value){
        $flag = false;
    }
    $response[$key] = $value;
}

if (!$flag){
    $response["Success"] = false;
}else {
    $query = $mysqli->prepare("SELECT user_id FROM users WHERE username = ?");
    $query->bind_param("s",$username);
    if ($query->execute()){
        $result = $query->get_result();
        $user_id = $result->fetch_assoc();
        $response["Success"] = true;
        $response["user_id"] = $user_id["user_id"];
    }else {
        $response["Success"] = false;
    }

}
echo json_encode($response);

?>