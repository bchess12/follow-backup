<?php

include_once 'commonFunctions.inc.php';
include_once 'dbh.inc.php';
session_start();

//Make sure user is logged in
if(isset($_SESSION['user_id'])){

$req = $_GET['req'];
$postsDisplay = array();
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

$sqlPostsCount = "SELECT post_id FROM posts;";
$resultPostsCount = mysqli_query($conn, $sqlPostsCount);
$numPostsCount = mysqli_num_rows($resultPostsCount);
if($numPostsCount < $req){
  $startIndex = 0;
  $req = $numPostsCount;
}
$startIndex = $numPostsCount - $req;

$sqlPosts = "SELECT * FROM posts LIMIT $startIndex, $req;";
$resultPosts = mysqli_query($conn, $sqlPosts);
$numPosts = mysqli_num_rows($resultPosts);
if($numPosts > 0){
  while($posts = mysqli_fetch_assoc($resultPosts)){
    if(in_array($posts['post_user_id'], $follows)){
      $postsUserId = $posts['post_user_id'];
      $postsId = $posts['post_id'];
      $sqlPostsUser = "SELECT * FROM users WHERE user_id = $postsUserId;";
      $resultPostsUser = mysqli_query($conn, $sqlPostsUser);
      $numPostsUser = mysqli_num_rows($resultPostsUser);
      $sqlLikes = "SELECT * FROM likes WHERE post_id = $postsId";
      $resultLikes = mysqli_query($conn, $sqlLikes);
      $numLikes = mysqli_num_rows($resultLikes);
      $sqlUserLikes = "SELECT * FROM likes WHERE post_id = $postsId AND user_id = $id";
      $resultUserLikes = mysqli_query($conn, $sqlUserLikes);
      $numUserLikes = mysqli_num_rows($resultUserLikes);
      if($numUserLikes == 0){
        $userLikes = false;
      }elseif ($numUserLikes == 1) {
        $userLikes = true;
      }
      if($numPostsUser > 0){
        $postsUser = mysqli_fetch_assoc($resultPostsUser);
        $postsData = array('id'=>$posts['post_id'],'body'=>$posts['post_body'],'user'=>$postsUser['user_username'],'profilePic'=>$postsUser['user_profile_pic'],'numLikes'=>$numLikes,'userLikes'=>$userLikes,'timestamp'=>$posts['post_timestamp']);
        array_push($postsDisplay, $postsData);
        array_push($postsTimestamps, $posts['post_timestamp']);
      }
    }
  }
}

array_multisort($postsTimestamps, SORT_DESC, $postsDisplay);

echo'
<div class="container">
  <div class="row">
  <div class="col-2"></div>
    <div class="col-6">
';

for ($i=0; $i < count($postsDisplay) ; $i++) {
  echo '
  <div class="card my-4" style="width:100%;">
    <div class="card-body">
    <div class="float-left">
  <img style="width:auto; max-height:50px" src="profile_pics/'.$postsDisplay[$i]['profilePic'].'" alt="image">
  <form action="profile.php" method="GET">
    <button type="submit" class="btn btn-primary active" name="profile-username" value="'.$postsDisplay[$i]['user'].'">'.$postsDisplay[$i]['user'].'</button>
  </form></div>
  <div class="float-right">'.
  $postsDisplay[$i]['body'].'<br>'.
  calcPostTimestamp($postsDisplay[$i]['timestamp']).
  '<br>'.'<button id="likeButton'.$postsDisplay[$i]['id'].'"
  onclick="likePost('.$postsDisplay[$i]['id'].','.$postsDisplay[$i]['userLikes'].')">
  '.calcLikeButton($postsDisplay[$i]['userLikes']).'
  </button>'.'<br>'.


  '<form action="post.php" method="POST">
  <input name="id" value="'.$postsDisplay[$i]['id'].'" type="hidden">
  <input name="body" value="'.$postsDisplay[$i]['body'].'" type="hidden">
  <input name="user" value="'.$postsDisplay[$i]['user'].'" type="hidden">
  <input name="profilePic" value="'.$postsDisplay[$i]['profilePic'].'" type="hidden">
  <input name="numLikes" value="'.$postsDisplay[$i]['numLikes'].'" type="hidden">
  <input name="userLikes" value="'.$postsDisplay[$i]['userLikes'].'" type="hidden">
  <input name="timestamp" value="'.$postsDisplay[$i]['timestamp'].'" type="hidden">
  <button name="viewPost" type="submit">view</button></form>'.'<br>'.

  '</div></div></div>';
}

echo
'</div>
</div>
</div>';

}
else{
  echo 'Please Log In';
}
