<?php
session_start();
if(isset($_GET['username'])){
  //Get the current user username
  $id = $_SESSION['username'];
  //Get the user we want to follow
  $username = $_GET['username'];
  //Find the path for their user file
  $url = '../data/users/'.$username.'.json';
  //If the user exists
  if(file_exists($url)){
    //Get the user info
    $data = file_get_contents($url);
    //Decode info and store in associative array $user
    $user = json_decode($data, true);
    //Create the element to be added to the followers array (inside $user)
    $newFollower = [
      "username"=>$id
    ];
    //Add the user to the array of followers
    array_push($user['followers'], $newFollower);
    //Encode the data, replace the file contents
    $data = json_encode($user, JSON_PRETTY_PRINT);
    //Store the updated followers list to the users file
    file_put_contents($url, $data);
  }else{
    //Dont know how this would happen but if they try to follow someone that doesnt exist
    echo 'user does not exist';
    exit();
  }
  //Now we have to update the following array in the current users file
  //Find the path for the current users file
  $url = '../data/users/'.$id.'.json';
  //Make sure their file is found
  if(file_exists($url)){
    //Get the user info
    $data = file_get_contents($url);
    //Decode info and store in associative array $user
    $user = json_decode($data, true);
    //Create the element to be added to the following array (inside $user)
    $newFollowing = [
      "username"=>$username
    ];
    //Add the followed user to the array of following
    array_push($user['following'], $newFollowing);
    //Encode the data, replace the file contents
    $data = json_encode($user, JSON_PRETTY_PRINT);
    //Store the updated following list to the users file
    file_put_contents($url, $data);
  }else{
    echo 'this shouldnt even be possible to get here';
    exit();
  }
  //Followers and following have been updated, now we are done
  header('Location:../index.php?follow=success');
}
