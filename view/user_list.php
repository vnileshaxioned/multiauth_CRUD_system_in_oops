<?php
  include('../controller/UserController.php');
  $userData->notLogin('id');
  include('../assets/includes/header.php');
  include('../assets/includes/nav.php');
?>
<div class="container mt-4">
  <?php include('../assets/includes/message.php'); ?>
  <ul class="table">
    <li class="thead">
      <div class="th id">Id</div>
      <div class="th">Name</div>
      <div class="th">Email</div>
      <div class="th">Phone Number</div>
      <div class="th">Gender</div>
      <div class="th">Profile Image</div>
      <div class="th action">Action</div>
    </li>
    <?php
      $users = $userData->userDetails('users');
      if ($users) {
        $i = 1;
        foreach ($users as $user) {
    ?>
    <li class="tbody">
      <div class="td"><?php echo $i++; ?></div>
      <div class="td"><?php echo $user['name']; ?></div>
      <div class="td"><?php echo $user['email']; ?></div>
      <div class="td"><?php echo $user['phone_number']; ?></div>
      <div class="td"><?php echo $user['gender']; ?></div>
      <div class="td">
        <img src="../assets/upload/<?php echo $user['profile_image']; ?>" alt="<?php echo $user['profile_image']; ?>">
      </div>
      <div class="td">
        <a href="edit_user.php?id=<?php echo $user['id']; ?>" class="btn btn-success">Edit</a>
        <a href="user_list.php?delete_id=<?php echo $user['id']; ?>" class="btn btn-danger">Delete</a>
      </div>
    </li>
    <?php
        }
      } else {
    ?>
      <li class="tbody">
        <div class="td">No data found</div>
      </li>
    <?php
      }
    ?>
  </ul>
</div>
<?php
  include('../assets/includes/footer.php');
?>