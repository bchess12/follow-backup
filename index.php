<?php include_once 'header.php'; ?>

<h2>hello</h2>

<?php
if(isset($_SESSION['user_id'])){
  echo $_SESSION['user_username'];
}
?>

<?php include_once 'footer.php'; ?>
