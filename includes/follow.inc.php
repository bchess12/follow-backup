<?php

session_start();

if(isset($_GET['follow'])){
  include 'dbh.inc.php';

  $follow = $_GET['follow'];
  $follower = $_SESSION['user_id'];

  $sql = "INSERT INTO follows (user_id, user_follows) VALUES ($follower, $follow);";
  mysqli_query($conn, $sql);

  $sqltwo = "INSERT INTO followers (user_id, user_follower) VALUES ($follow, $follower);";
  mysqli_query($conn, $sqltwo);

  header("Location: ../index.php?follow=success");
}
