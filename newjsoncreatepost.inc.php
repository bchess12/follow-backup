<?php

session_start();

if(isset($_SESSION['username'])){
if(isset($_POST['post-submit'])){

  //Declare variables that make up the post
  $username = $_SESSION['username'];
  $body = $_POST['post-body'];
  $timestamp = time();
  $id = $username.'.'.$timestamp;

  //Create the new JSON file for this post
  //Post files are named by their author plus a unique key
  $fileName = '../data/posts/'.$id.'.json';
  $postFile = fopen($fileName, 'w');

  //Create the data element for this user
  $postData = [
    'author'=>$username,
    'body'=>$body,
    'timestamp'=>$timestamp
  ];
  //Format the array as JSON and store that in our file contents variable
  $data = json_encode($postData, JSON_PRETTY_PRINT);


  //Error handlers
  //Check if inputs are empty
  if (empty($body)) {
    header("Location: ../createPost.php?body=empty");
    exit();
  }else{
    //Write the user data to their file once all errors have been passed
    fwrite($postFile, $data);
    fclose($postFile);
    header("Location: ../index.php?post=success");
    exit();
    }
  }else{
    header("Location: ../createPost.php?post=error");
    exit();
  }
}else{
  header("Location: ../createPost.php?post=error");
  exit();
}
