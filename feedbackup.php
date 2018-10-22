<?php
include_once 'header.php';

$postsDisplay = array();
$postsDisplayUser = array();
$postsTimestamps = array();
$id = $_SESSION['user_id'];
$follows = array();

$sqlFollows = "SELECT * FROM follows WHERE user_id = $id;";
$resultFollows = mysqli_query($conn, $sqlFollows);
$numFollows = mysqli_num_rows($resultFollows);
if($numFollows > 0){
  while($followsList = mysqli_fetch_assoc($resultFollows)){
    array_push($follows, $followsList['user_follows']);
  }
}

for ($i=0; $i < count($follows); $i++) {
$sqlPosts = "SELECT * FROM posts WHERE post_user_id = $follows[$i];";
$resultPosts = mysqli_query($conn, $sqlPosts);
$numPosts = mysqli_num_rows($resultPosts);
if($numPosts > 0){
  while($posts = mysqli_fetch_assoc($resultPosts)){
    array_push($postsDisplay, $posts['post_body']);
    array_push($postsTimestamps, $posts['post_timestamp']);
    $postsUserId = $posts['post_user_id'];
    $sqlPostsUser = "SELECT * FROM users WHERE user_id = $postsUserId;";
    $resultPostsUser = mysqli_query($conn, $sqlPostsUser);
    $numPostsUser = mysqli_num_rows($resultPostsUser);
    if($numPostsUser > 0){
      $postsUser = mysqli_fetch_assoc($resultPostsUser);
      array_push($postsDisplayUser, $postsUser['user_username']);
    }
  }
}
}
rsort($postsTimestamps);
for ($i=0; $i < count($postsDisplay); $i++) {
  echo $postsDisplayUser[$i].'<br>'.$postsDisplay[$i].'<br><br>';
}
