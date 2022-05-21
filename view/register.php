<?php
  include('../controller/UserController.php');
  $userData->isLogin('id');
  include('../assets/includes/header.php');
?>
<div class="container">
  <div class="card">
    <?php include('../assets/includes/message.php'); ?>
    <div class="card-header">
        <h1>Register</h1>
    </div>
    <div class="card-body">
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
    <div class="form-group">
      Name: <span>*</span><input type="text" name="name" class="form-control" value="<?php echo $name; ?>" placeholder="Enter Name" />
      <span class="error-show"><?php echo isset($_GET['name']) ? $_GET['name'] : '' ; ?></span>
    </div>
    <div class="form-group">
      Email: <span>*</span><input type="text" name="email" class="form-control" value="<?php echo $email; ?>" placeholder="Enter Email" />
      <span class="error-show"><?php echo isset($_GET['email']) ? $_GET['email'] : '' ; ?></span>
    </div>
    <div class="form-group">
      Phone Number: <span>*</span><input type="text" name="phone_num" class="form-control" value="<?php echo $phone_num; ?>" placeholder="Enter Phone Number" />
      <span class="error-show"><?php echo isset($_GET['phone_number']) ? $_GET['phone_number'] : '' ; ?></span>
    </div>
    <div class="form-group">
      Gender: <span>*</span>
      <?php
        $checked = "checked='checked'";
        $genders = array('Male', 'Female', 'Other');
        foreach ($genders as $gender_list) {
          if ($gender == $gender_list) {
      ?>
      <input type="radio" name="gender" value="<?php echo $gender_list; ?>" <?php echo $checked; ?> />
      <?php echo $gender_list; ?>
      <?php } else { ?>
      <input type="radio" name="gender" value="<?php echo $gender_list; ?>"/>
      <?php echo $gender_list; ?>
      <?php } } ?>
      <span class="error-show"><?php echo isset($_GET['gender']) ? $_GET['gender'] : '' ; ?></span>
    </div>
    <div class="form-group">
      Password: <span>*</span><input type="password" name="pass" class="form-control" placeholder="Enter Password"/>
      <span class="error-show"><?php echo isset($_GET['password']) ? $_GET['password'] : '' ; ?></span>
    </div>
    <div class="form-group">
      Confirm Password: <span>*</span>
      <input type="password" name="c_pass" class="form-control" placeholder="Enter Confirm Password"/>
      <span class="error-show"><?php echo isset($_GET['confirm_password']) ? $_GET['confirm_password'] : '' ; ?></span>
    </div>
    <div class="form-group">
      <input type="file" name="file" />
      <span class="error-show"><?php echo isset($_GET['file']) ? $_GET['file'] : '' ; ?></span>
    </div>
    </div>
    <div class="card-footer">
        <a href="login.php">Already have an account?</a>
      <input type="submit" name="user_register" class="btn btn-primary" value="Register" />
    </form>
    </div>
  </div>
</div>