<?php
include_once 'header.php';

if(isset($_GET['search'])){
  $username = $_GET['search'];
  $url = 'data/users/'.$username.'.json';
  if(file_exists($url)){
    $data = file_get_contents($url);
    $user = json_decode($data, true);

    echo $user['username'].'<br>'.
    $user['first'].' '.$user['last'].'<br>'.
    '<form action="jsonprofile.php">
    <button name="username" value="'.$user['username'].'">View</button>
    </form>';
  }else{
    echo 'no user found';
  }
}else{
  echo 'no search field entered';
}
