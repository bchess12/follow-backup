<?php

function calcLikeButton($userLikes){
  if($userLikes){
    $likeButtonText = 'unlike';
    //change button graphic instead
  }else if(!$userLikes){
    $likeButtonText = 'like';
  }
  return $likeButtonText;
}

function calcPostTimestamp($timestamp){
  $currentTime = time();
  $timePassed = "";
  $difference = $currentTime - $timestamp;
  if($difference > 31556952){
    $timePassed = floor($difference/31556952)."y";
  }elseif ($difference > 2629746) {
    $timePassed = floor($difference/2629746)."m";
  }elseif ($difference > 604800) {
    $timePassed = floor($difference/604800)."w";
  }elseif ($difference > 86400) {
    $timePassed = floor($difference/86400)."d";
  }elseif ($difference > 3600) {
    $timePassed = floor($difference/3600)."h";
  }elseif ($difference > 60) {
    $timePassed = floor($difference/60)."m";
  }elseif ($difference < 60) {
    $timePassed = $difference."s";
  }
  return $timePassed;
}
