<?php

session_start();

if(isset($_GET['unfollow'])){
  include 'dbh.inc.php';

  $unfollow = $_GET['unfollow'];
  $unfollower = $_SESSION['user_id'];

  $sql = "DELETE FROM follows WHERE user_id = $unfollower AND user_follows = $unfollow;";
  mysqli_query($conn, $sql);

  $sqltwo = "DELETE FROM followers WHERE user_id = $unfollow AND user_follower = $unfollower;";
  mysqli_query($conn, $sqltwo);

  header("Location: ../index.php?unfollow=success");
}
