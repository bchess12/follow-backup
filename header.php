<?php
include_once 'includes/dbh.inc.php';
session_start();
 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  </head>
  <body>
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #25616E;">
      <a class="navbar-brand" href="#">Navbar</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" href="index.php">Home</a>
          </li>

          <li class="nav-item">
            <form action="search.php" method="post">
              <div class="input-group">
                <input type="text" name="header-search" class="form-control" placeholder="Search Users">
                <div class="input-group-append">
                  <button class="btn btn-outline-secondary" type="submit" name="header-search-submit">Search</button>
                </div>
              </div>
            </form>
          </li>
          <?php
          if(isset($_SESSION['user_id'])){
            echo'
            <li class="nav-item">
              <a class="nav-link" href="feed.php">Feed</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="createPost.php">Post</a>
            </li>
            <li class="ml-3 nav-item">
              <form action="includes/logout.inc.php" method="post">
                <button class="btn btn-outline-secondary" type="submit" name="header-logout-submit">Log Out</button>
              </form>
            </li>
            <li class="ml-3 nav-item">
              <form action="profile.php" method="get">
                <button class="btn btn-outline-secondary" type="submit" name="profile-id" value="'.$_SESSION['user_id'].'">My Profile</button>
              </form>
            </li>
            ';
          }
          else{
            echo'
            <li class="ml-3 nav-item">
              <form action="includes/login.inc.php" method="post">
                <div class="input-group">
                  <input type="text" name="header-login-username" class="form-control" placeholder="Username">
                  <input type="password" name="header-login-password" class="form-control" placeholder="Password">
                  <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit" name="header-login-submit">Log In</button>
                  </div>
                </div>
              </form>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="signup.php">Sign Up</a>
            </li>
            ';
          }
          ?>
        </ul>
      </div>
    </nav>
