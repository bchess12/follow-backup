<?php
include_once 'header.php';

//Globals
$username;
$id;
$found = false;
$resultFollowersList;
$followersList;
$followersDisplay = array();
$followsDisplay = array();
$postsDisplay = array();

//Convert username into id (from feed page), get target user's info
if(isset($_GET['profile-username'])){
  $username = $_GET['profile-username'];
  $sql = "SELECT * FROM users WHERE user_username = '$username';";
  $result = mysqli_query($conn, $sql);
  $numRows = mysqli_num_rows($result);
  if($numRows > 0){
    $row = mysqli_fetch_assoc($result);
    $id = $row['user_id'];
  }
}

//Get target user's info using id (from search page)
if(isset($_GET['profile-id'])){
  $id = $_GET['profile-id'];
  $sql = "SELECT * FROM users WHERE user_id = $id;";
  $result = mysqli_query($conn, $sql);
  $numRows = mysqli_num_rows($result);
  if($numRows > 0){
    $row = mysqli_fetch_assoc($result);
  }
}

//Get all followers of the target user
$sqlFollowers = "SELECT * FROM followers WHERE user_id = $id;";
$resultFollowers = mysqli_query($conn, $sqlFollowers);
$numFollowers = mysqli_num_rows($resultFollowers);
if($numFollowers > 0){
  while($followers = mysqli_fetch_assoc($resultFollowers)){
    //Get the username of each follower
    $current = $followers['user_follower'];
    $sqlFollowersList = "SELECT * FROM users WHERE user_id = $current;";
    $resultFollowersList = mysqli_query($conn, $sqlFollowersList);
    while($followersList = mysqli_fetch_assoc($resultFollowersList)){
      //Store followers names in an array
      array_push($followersDisplay, $followersList['user_username']);
    }
    //Check if the client is following the target user
    if(isset($_SESSION['user_id']) && $current == $_SESSION['user_id']){
      $found = true;
    }
  }
}

//Get all the users that the target user follows
$sqlFollows = "SELECT * FROM follows WHERE user_id = $id;";
$resultFollows = mysqli_query($conn, $sqlFollows);
$numFollows = mysqli_num_rows($resultFollows);
if($numFollows > 0){
  while($follows = mysqli_fetch_assoc($resultFollows)){
    //Get the username of each user that the target user follows
    $current = $follows['user_follows'];
    $sqlFollowsList = "SELECT * FROM users WHERE user_id = $current;";
    $resultFollowsList = mysqli_query($conn, $sqlFollowsList);
    while($followsList = mysqli_fetch_assoc($resultFollowsList)){
      //Store follows names in an array
      array_push($followsDisplay, $followsList['user_username']);
    }
  }
}






// $sqlPosts = "SELECT * FROM posts WHERE post_user_id = $id;";
// $resultPosts = mysqli_query($conn, $sqlPosts);
// $numPosts = mysqli_num_rows($resultPosts);
// if($numPosts > 0){
//   while($posts = mysqli_fetch_assoc($resultPosts)){
//     array_push($postsDisplay, $posts['post_body']);
//   }
// }

?>

<div class="container mt-5">
  <div class="row">
    <div class="col-6">

<?php

echo
'<h2>'.$row['user_username'].'</h2><br>'.
'<h4>'.$row['user_first'].' '.$row['user_last'].'</h4><br>'.
'<h6>'.$numFollowers.' followers '.
$numFollows.' follows'.'</h6><br>'.
'<img style="width:auto; max-height:100px" src="profile_pics/'.$row['user_profile_pic'].'" alt="image">';

//Determine if the user will see a follow or unfollow button
if(isset($_SESSION['user_id']) && !($id == $_SESSION['user_id']) && $found == false){
  echo'
  <form action="includes/follow.inc.php" method="get">
    <button type="submit" class="btn btn-primary active" name="follow" value="'.$row['user_id'].'">Follow</button>
  </form>
  ';
}elseif ($found == true) {
  echo'
  <form action="includes/unfollow.inc.php" method="get">
    <button type="submit" class="btn btn-primary active" name="unfollow" value="'.$row['user_id'].'">Unfollow</button>
  </form>
  ';
}

//If the user is viewing their own profile, display functions to edit it
if(isset($_SESSION['user_id']) && ($id == $_SESSION['user_id'])){
  echo'
  <form action="includes/profilePic.inc.php" method="POST" enctype="multipart/form-data">
  <div class="form-group">
    <input type="file" name="profile-pic">
  </div>
    <button type="submit" name="submit-profile-pic">Edit Profile Picture</button>
  </form>
  ';
}

//Display usernames of followers and follows, add limit and request
echo '<div class="float-right">'.'all followers: '.'<br>';
for ($i=0; $i < count($followersDisplay); $i++) {
  echo $followersDisplay[$i].'<br>';
}
echo '</div>';
echo '<div class="float-right">'.'user follows: '.'<br>';
for ($i=0; $i < count($followsDisplay); $i++) {
  echo $followsDisplay[$i].'<br>';
}
echo '</div>';

// for ($i=0; $i < count($postsDisplay); $i++) {
//   echo $row['user_username'].'<br>'.$postsDisplay[$i].'<br><br>';
// }

?>

</div>
</div>
</div>
