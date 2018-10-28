<?php

if (isset($_POST['submit-signup'])) {

  session_start();


  //Declare variables that will make up the user account
  $first = $_POST['first'];
  $last = $_POST['last'];
  $username = $_POST['username'];
  $password = $_POST['password'];
  $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
  $email = $_POST['email'];
  $pic = 'default.png';
  $followers = array();
  $following = array();

  //Create the new JSON file for this user account
  //User files are named by their username, which is a unique key
  $fileName = '../data/users/'.$username.'.json';
  $userFile = fopen($fileName, 'w');

  //Create the data element for this user
  $userData = [
    'first'=>$first,
    'last'=>$last,
    'username'=>$username,
    'password'=>$hashedPassword,
    'email'=>$email,
    'pic'=>$pic,
    'followers'=>$followers,
    'following'=>$following
  ];
  //Format the element as JSON and store that in our file contents variable
  $data = json_encode($userData, JSON_PRETTY_PRINT);


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
        //Check is username is taken
            //Write the user data to their file
            fwrite($userFile, $data);
            fclose($userFile);
            header("Location: ../signup.php?signup=success");
            exit();
          }
        }
      }
    }else{
  header("Location: ../signup.php");
  exit();
}
