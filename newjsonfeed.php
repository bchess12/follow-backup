<?php
include_once 'header.php';

if(isset($_SESSION['username'])){
  $files = [];
  $followingList = [];
  $time = time();
  $timeLimit = $time - 1209600;
  $id = $_SESSION['username'];
  $url = 'data/users/'.$id.'.json';
  $data = file_get_contents($url);
  $user = json_decode($data, true);

  foreach ($user['following'] as $following) {
    $username = $following['username'];
    array_push($followingList, $username);
  }

  $dir = 'data/posts/';
  if ($dh = opendir($dir)){
    while (($file = readdir($dh)) !== false){
      //echo '<br>'.$file;
      $fileName = explode('.',$file);
      if(in_array($fileName[0],$followingList)){
        if($fileName[1] > $timeLimit){
          array_push($files,$file);
        }
      }
    }
    closedir($dh);
  }


//array_reverse($files);
//print_r($files);
for ($i=sizeof($files) - 1; $i > -1; $i--) {
  $url = 'data/posts/'.$files[$i];
  $data = file_get_contents($url);
  $post = json_decode($data, true);
  echo '<br>'.$post['author'].'<br>'.$post['body'].'<br>';
}


}
else{
  echo 'please log in';
}
