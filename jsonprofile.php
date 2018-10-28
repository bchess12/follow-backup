<?php
include_once 'header.php';

if(isset($_GET['username'])){

  $id = $_SESSION['username'];
  $username = $_GET['username'];

  $isAFollower;
  $isOwnProfile;

  $url = 'data/users/'.$username.'.json';
  $data = file_get_contents($url);
  $user = json_decode($data, true);

  if($id == $username){
    $isOwnProfile = true;
  }else{
    $isOwnProfile = false;
  }

if($isOwnProfile == false){
  foreach ($user['followers'] as $follower) {
    if($follower['username'] == $id){
      $isAFollower = true;
    }else{
      $isAFollower = false;
    }
  }
}

  //print_r($user);
  echo $user['username'].'<br>'.
  $user['first'].' '.$user['last'].'<br>';

if($isOwnProfile == false){
  if($isAFollower == true){
    echo
    '<form action="includes/jsonfollow.inc.php">
    <button name="username" value="'.$user['username'].'">Unfollow</button>
    </form>';
  }elseif($isAFollower == false){
    echo
    '<form action="includes/jsonfollow.inc.php">
    <button name="username" value="'.$user['username'].'">Follow</button>
    </form>';
  }
}



  echo sizeof($user['following']).' following:';
  foreach ($user['following'] as $following) {
    echo '<br>'.$following['username'];
  }
  echo '<br>'.sizeof($user['followers']).' followers:';
  foreach ($user['followers'] as $follower) {
    echo '<br>'.$follower['username'];
  }
}
