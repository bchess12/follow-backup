<?php

if(isset($_POST['header-login-submit'])){

session_start();

$username = $_POST['header-login-username'];
$password = $_POST['header-login-password'];

$url = '../data/users/'.$username.'.json';
$data = file_get_contents($url);
$user = json_decode($data, true);


  if (!empty($username) && !empty($password)) {
        $hashedPasswordCheck = password_verify($password, $user['password']);
        if($hashedPasswordCheck){
          $_SESSION['username'] = $user['username'];
          header("Location: ../index.php?login=success");
        }else{
          header("Location: ../index.php?login=password-incorrect");
        }
        exit();
      }else{
        header("Location: ../index.php?login=empty-field");
      }
    }else{
      header("Location: ../index.php?login=error");
    }
