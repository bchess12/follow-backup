<?php include_once 'header.php'; ?>

<div class="container">
  <div class="row justify-content-center">
    <div class="col-5">
      <h3 class="my-3">Make Account</h3>
      <form action="includes/signup.inc.php" method="POST">
        <div class="form-group">
          <input class="form-control" type="text" name="first" placeholder="First Name">
        </div>
        <div class="form-group">
          <input class="form-control" type="text" name="last" placeholder="Last Name">
        </div>
        <div class="form-group">
          <input class="form-control" type="text" name="username" placeholder="Username">
        </div>
        <div class="form-group">
          <input class="form-control" type="password" name="password" placeholder="Password">
        </div>
        <div class="form-group">
          <input class="form-control" type="email" name="email" placeholder="Email">
        </div>
        <div style="text-align: center;" class="form-actions">
          <button type="submit" class="btn btn-dark" name="submit-signup">Get Started</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php include_once 'footer.php'; ?>
