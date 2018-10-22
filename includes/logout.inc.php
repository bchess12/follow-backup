<?php

if(isset($_POST['header-logout-submit'])){
  session_start();
  session_unset();
  session_destroy();
  header("Location: ../index.php");
  exit();
}
