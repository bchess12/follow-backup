<?php

if (isset($_POST['submit-signup'])) {

  include_once 'dbh.inc.php';
  session_start();

  //prepare and bind
  $stmt = $conn->prepare("INSERT INTO users (user_first, user_last, user_username, user_password, user_email, user_profile_pic) VALUES (?, ?, ?, ?, ?, ?);");
  $stmt->bind_param("ssssss", $first, $last, $username, $hashedPassword, $email, $pic);

  $first = mysqli_real_escape_string($conn, $_POST['first']);
  $last = mysqli_real_escape_string($conn, $_POST['last']);
  $username = mysqli_real_escape_string($conn, $_POST['username']);
  $password = mysqli_real_escape_string($conn, $_POST['password']);
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $pic = 'default.png';

  //Error handlers
  //Check for empty fields
  if(empty($first) || empty($last) || empty($username) || empty($password) || empty($email)){
    header("Location: ../signup.php?signup=empty");
    exit();
  }else{
    //Check if input characters are valid
    if(!preg_match("/^[a-zA-Z]*$/", $first) || !preg_match("/^[a-zA-Z]*$/", $last) || !preg_match("/^[a-zA-Z0-9]*$/", $username)){
      header("Location: ../signup.php?signup=invalid");
      exit();
    }else{
      //Check if email is valid
      if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        header("Location: ../signup.php?signup=email");
        exit();
      }else{
        //Check if email is taken
        $sql = "SELECT * FROM users WHERE user_email ='$email'";
        $result = mysqli_query($conn, $sql);
        $resultCheck = mysqli_num_rows($result);
        if($resultCheck > 0){
          header("Location: ../signup.php?signup=emailtaken");
          exit();
        }else{
          $sql = "SELECT * FROM users WHERE user_username ='$username'";
          $result = mysqli_query($conn, $sql);
          $resultCheck = mysqli_num_rows($result);
          if($resultCheck > 0){
            header("Location: ../signup.php?signup=usertaken");
            exit();
          }else{
            //All tests have been passed successfully
            //Hashing the Password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            //Insert the user into the database
            //stmt execute
            $stmt->execute();
            header("Location: ../signup.php?signup=success");
            exit();
          }
        }

      }
    }
  }
}else{
  header("Location: ../signup.php");
  exit();
}
