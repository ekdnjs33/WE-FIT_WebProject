<?php
include('config_an.php');

// json response array
$response = array("error" => FALSE);

if ($_POST['email'] != "" && $_POST['password'] != "") {

    // receiving the post params
    $email = $_POST['email'];
    $password = $_POST['password'];

    // get the user by email and password
    $user_sql = mysqli_query($db, "SELECT * FROM users WHERE email='".$email."'");
    $user = mysqli_fetch_array($user_sql);

    $salt = $user['salt'];
    $encrypted_password = $user['encrypted_password'];

    $hash = base64_encode(sha1($password . $salt, true) . $salt);

    if($encrypted_password == $hash){
      $response["error"] = FALSE;
      $response["uid"] = $user["unique_id"];
      $response["user"]["major"] = $user["major"];
      $response["user"]["email"] = $user["email"];
      $response["user"]["created_at"] = $user["created_at"];
      $response["user"]["updated_at"] = $user["updated_at"];
      echo json_encode($response);
    }
    else{
      $response["error"] = TRUE;
      $response["error_msg"] = "Login credentials are wrong. Please try again!";
      echo json_encode($response);
    }
} else {
    // required post params is missing
    $response["error"] = TRUE;
    $response["error_msg"] = "Required parameters email or password is missing!";
    echo json_encode($response);
}
?>
