<?php
include('config_an.php');

// json response array
$response = array("error" => FALSE);

if ($_POST['major'] != "" && $_POST['email'] != "" && $_POST['password'] != "") {

    // receiving the post params
    $major = $_POST['major'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // check if user is already existed with the same email
    $is_sql = mysqli_query($db, "SELECT * from users WHERE email='".$email."'");

    $is_row = mysqli_num_rows($is_sql);

    if($is_row == 1){
      $response["error"] = TRUE;
      $response["error_msg"] = "User already existed with " . $email;
      echo json_encode($response);
    }
    else{
      $uuid = uniqid('', true);

      $salt = sha1(rand());
      $salt = substr($salt, 0, 10);

      $encrypted = base64_encode(sha1($password . $salt, true) . $salt);

      $hash = array("salt" => $salt, "encrypted" => $encrypted);

      $encrypted_password = $hash["encrypted"]; // encrypted password
      $salt = $hash["salt"]; // salt

      $reg_sql = mysqli_query($db, "INSERT INTO users(unique_id, major, email, encrypted_password, salt, created_at) VALUES('".$uuid."', '".$major."', '".$email."', '".$encrypted_password."', '".$salt."', NOW())");

      if($reg_sql){
        $user_sql = mysqli_query($db, "SELECT * FROM users WHERE email = '".$email."'");
        $user = mysqli_fetch_array($user_sql);

        // user stored successfully
        $response["error"] = FALSE;
            $response["uid"] = $user["unique_id"];
            $response["user"]["major"] = $user["major"];
            $response["user"]["email"] = $user["email"];
            $response["user"]["created_at"] = $user["created_at"];
            $response["user"]["updated_at"] = $user["updated_at"];
            echo json_encode($response);
      }
      else{
        // user failed to store
        $response["error"] = TRUE;
        $response["error_msg"] = "Unknown error occurred in registration!";
        echo json_encode($response);
      }
    }
} else {
    $response["error"] = TRUE;
    $response["error_msg"] = "Required parameters (major, email or password) is missing!";
    echo json_encode($response);
}
?>
