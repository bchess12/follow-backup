<?php

session_start();

if(isset($_GET['req'])){
  include 'dbh.inc.php';

  $postId = $_GET['req'];
  $userId = $_SESSION['user_id'];

  $sql = "INSERT INTO likes (post_id, user_id) VALUES ($postId, $userId);";
  mysqli_query($conn, $sql);
}
