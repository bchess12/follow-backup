<?php

session_start();

if(isset($_GET['req'])){
  include 'dbh.inc.php';

  $postId = $_GET['req'];
  $userId = $_SESSION['user_id'];

  $sql = "DELETE FROM likes WHERE user_id = $userId AND post_id = $postId;";
  mysqli_query($conn, $sql);
}
