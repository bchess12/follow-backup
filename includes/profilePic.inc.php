<?php

if (isset($_POST['submit-profile-pic'])) {

session_start();
include_once 'dbh.inc.php';
$id = $_SESSION['user_id'];
$file = $_FILES['profile-pic'];
$fileName = $file['name'];
$fileType = $file['type'];
$fileTempName = $file['tmp_name'];
$fileError = $file['error'];
$fileSize = $file['size'];
$fileExt = explode(".",$fileName);
$fileActualExt = strtolower(end($fileExt));
$allowed = array("jpg","jpeg","png");

if(in_array($fileActualExt, $allowed)){
  if($fileError === 0){
    if($fileSize < 20000000){
      $profilePic = $id . "." . $fileActualExt;
      $fileDestination = "../profile_pics/" . $profilePic;
      $sql = "UPDATE users SET user_profile_pic = '$profilePic' WHERE user_id = $id;";
      mysqli_query($conn, $sql);
      move_uploaded_file($fileTempName, $fileDestination);
      header("Location: ../index.php?profilePic=success");
      echo $sql;
      exit();
  }
}
}
}
