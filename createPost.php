<?php include_once 'header.php';
if(isset($_SESSION['user_id'])){
?>

<div class="container">
  <div class="row justify-content-center">
    <div class="col-5">
      <h3 class="my-3">Write a Post</h3>
      <form action="includes/createPost.inc.php" method="POST">
        <div class="form-group">
          <input class="form-control" type="text" name="post-body" placeholder="Enter post here">
        </div>
        <div style="text-align: center;" class="form-actions">
          <button type="submit" class="btn btn-dark" name="post-submit">Post</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php
}else{
  echo 'Please Log In';
}
include_once 'footer.php'; ?>
