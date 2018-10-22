<?php

session_start();

if(isset($_POST['header-login-submit'])){
  include 'dbh.inc.php';

  $username = mysqli_real_escape_string($conn, $_POST['header-login-username']);
  $password = mysqli_real_escape_string($conn, $_POST['header-login-password']);

  //Error handlers
  //Check if inputs are empty
  if (empty($username) || empty($password)) {
    header("Location: ../index.php?login=empty");
    exit();
  }else{
    $sql = "SELECT * FROM users WHERE user_username='$username'";
    $result = mysqli_query($conn,$sql);
    $resultCheck = mysqli_num_rows($result);
    if($resultCheck < 1){
      header("Location: ../index.php?login=error");
      exit();
    }else{
      if($row = mysqli_fetch_assoc($result)){
        //Dehashing the password
        $hashedPasswordCheck = password_verify($password, $row['user_password']);
        if($hashedPasswordCheck == false){
          header("Location: ../index.php?login=error");
          exit();
        } elseif($hashedPasswordCheck == true){
          //Log in the user here
          $_SESSION['user_id'] = $row['user_id'];
          $_SESSION['user_username'] = $row['user_username'];
          header("Location: ../index.php?login=success");

          exit();
        }
      }
    }
  }
}else{
  header("Location: ../index.php?login=error");
  exit();
}
