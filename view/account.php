<?php
  include('../controller/UserController.php');
  $userData->notLogin('id');
  include('../assets/includes/header.php');
  include('../assets/includes/nav.php');
?>
<div class="container mt-4">
  <h3>Account Setting</h3>
  <?php include('../assets/includes/message.php'); ?>
  <?php
    $id = $_SESSION['id'];
    $users = $userData->userDetails('users', 'i', 'id', $id);
      if ($users) {
  ?>
  <div class="profile">
    <p>Name: <?php echo $users['name']; ?></p>
    <p>Email: <?php echo $users['email']; ?></p>
    <p>Phone Number: <?php echo $users['phone_number']; ?></p>
    <p>Gender: <?php echo $users['gender']; ?></p>
    <a href="edit_profile.php?id=<?php echo $users['id']; ?>" class="btn btn-success">Edit Profile</a>
    <a href="edit_password.php?id=<?php echo $users['id']; ?>" class="btn btn-success">Edit Password</a>
  </div>
  <?php } ?>
</div>
<?php
  include('../assets/includes/footer.php');
?>