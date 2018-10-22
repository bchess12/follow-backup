<?php
include_once 'header.php';

if(isset($_POST['header-search-submit'])){
  $search = mysqli_real_escape_string($conn, $_POST['header-search']);
  $sql = "SELECT * FROM users WHERE user_first LIKE '%$search%' OR user_last LIKE '%$search%' OR user_username LIKE '%$search%' LIMIT 10";
  $result = mysqli_query($conn, $sql);
  $queryResult = mysqli_num_rows($result);

  while ($row = mysqli_fetch_assoc($result)) {
    echo $row['user_first'].' '.$row['user_last'];
    echo '
    <form action="profile.php" method="GET">
      <button type="submit" class="btn btn-primary active" name="profile-id" value="'.$row['user_id'].'">View Profile</button>
    </form>
    ';
    echo '<br>';
  }
}else{
  echo 'No Search Field Entered';
}
