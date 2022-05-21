<?php
  include('../controller/UserController.php');
  $userData->notLogin('id');
  include('../assets/includes/header.php');
  include('../assets/includes/nav.php');
?>
<div class="container">
  <div class="card">
  <h3>Password Update</h3>
    <?php include('../assets/includes/message.php'); ?>
    <?php
      $id = $_GET['id'];
      $users = $userData->userDetails('users', 'i', 'id', $id);
      if ($users) {
    ?>
    <div class="card-body">
      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <div class="form-group">
          <input type="hidden" name="user_id" value="<?php echo $_GET['id']; ?>">
        </div>
        <div class="form-group">
          Current Password: <span>*</span><input type="password" name="current_password" class="form-control" placeholder="Enter Current Password" />
          <span class="error-show"><?php echo isset($_GET['current']) ? $_GET['current'] : '' ; ?></span>
        </div>
        <div class="form-group">
          New Password: <span>*</span><input type="password" name="new_password" class="form-control" placeholder="Enter New Password" />
          <span class="error-show"><?php echo isset($_GET['new']) ? $_GET['new'] : '' ; ?></span>
        </div>
        <div class="form-group">
          Confirm Password: <span>*</span><input type="password" name="confirm_password" class="form-control" placeholder="Enter Confirm Password" />
          <span class="error-show"><?php echo isset($_GET['confirm']) ? $_GET['confirm'] : '' ; ?></span>
        </div>
        <div class="form-group">
          <input type="submit" name="password_update" class="btn btn-primary" value="Submit" />
        </div>
      </form>
      <?php } ?>
    </div>
  </div>
</div>
<?php
  include('../assets/includes/footer.php');
?>