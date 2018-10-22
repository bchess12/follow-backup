<?php
include_once 'includes/commonFunctions.inc.php';
include_once 'header.php';

if(isset($_POST['viewPost'])){
  $id = $_POST['id'];
  $body = $_POST['body'];
  $user = $_POST['user'];
  $profilePic = $_POST['profilePic'];
  $numLikes = $_POST['numLikes'];
  $userLikes = $_POST['userLikes'];
  $timestamp = $_POST['timestamp'];

  echo $body.'<br>'.
  $user.'<br>'.'<img style="width:auto; max-height:50px" src="profile_pics/'.
  $profilePic.'" alt="image">'.'<br>'.
  $numLikes.' likes<br>'.
  $userLikes.'<br>'.calcPostTimestamp($timestamp).'<br>'.
  '<button id="likeButton'.$id.'"
  onclick="likePost('.$id.','.$userLikes.')">
  '.calcLikeButton($userLikes).'
  </button>';

  //echo calcPostTimestamp($timestamp);
}
