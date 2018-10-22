<?php

session_start();

if(isset($_SESSION['user_id'])){
if(isset($_POST['post-submit'])){
  include 'dbh.inc.php';

  $stmt = $conn->prepare("INSERT INTO posts (post_user_id, post_body, post_timestamp) VALUES (?, ?, ?);");
  $stmt->bind_param("sss", $userId, $postBody, $timestamp);

  $timestamp = time();
  $postBody = mysqli_real_escape_string($conn, $_POST['post-body']);
  $userId = $_SESSION['user_id'];
  //Error handlers
  //Check if inputs are empty
  if (empty($postBody)) {
    header("Location: ../createPost.php?body=empty");
    exit();
  }else{
    $stmt->execute();
    header("Location: ../index.php?post=success");
    exit();
    }
  }else{
    header("Location: ../createPost.php?post=error");
    exit();
  }
}else{
  header("Location: ../createPost.php?post=error");
  exit();
}
