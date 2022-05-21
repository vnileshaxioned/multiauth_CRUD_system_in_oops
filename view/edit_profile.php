<?php
  include('../controller/UserController.php');
  $userData->notLogin('id');
  include('../assets/includes/header.php');
  include('../assets/includes/nav.php');
?>
<div class="container">
  <div class="card">
  <h3>Profile Update</h3>
    <?php include('../assets/includes/message.php'); ?>
    <?php
        $id = $_GET['id'];
        if ($id == $_SESSION['id']) {
          $users = $userData->userDetails('users', 'i', 'id', $id);
          if ($users) {
      ?>
    <div class="card-body">
      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
        <div class="form-group">
          <input type="hidden" name="user_id" value="<?php echo $users['id']; ?>">
        </div>
        <div class="form-group">
          Name: <span>*</span><input type="text" name="name" class="form-control" value="<?php echo $users['name']; ?>" placeholder="Enter Name" />
          <span class="error-show"><?php echo isset($_GET['name']) ? $_GET['name'] : '' ; ?></span>
        </div>
        <div class="form-group">
          Email: <span>*</span><input type="text" name="email" class="form-control disabled" value="<?php echo $users['email']; ?>" placeholder="Enter Email" readonly/>
          <span class="error-show"><?php echo isset($_GET['email']) ? $_GET['email'] : '' ; ?></span>
        </div>
        <div class="form-group">
          Phone Number: <span>*</span><input type="text" name="phone_number" class="form-control" value="<?php echo $users['phone_number']; ?>" placeholder="Enter Phone Number" />
          <span class="error-show"><?php echo isset($_GET['phone_number']) ? $_GET['phone_number'] : '' ; ?></span>
        </div>
        <div class="form-group">
          Gender: <span>*</span>
          <?php
            $checked = "checked='checked'";
            $genders = array('Male', 'Female', 'Other');
            foreach ($genders as $gender_list) {
              if ($users['gender'] == $gender_list) {
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
          Profile Image: <input type="file" name="file">
          <span class="error-show"><?php echo isset($_GET['file']) ? $_GET['file'] : '' ; ?></span>
        </div>
        <div class="form-group">
          <input type="submit" name="user_update" class="btn btn-primary" value="Submit" />
        </div>
      </form>
      <?php
          }
        } else {
      ?>
        <h3>Please do not change url id</h3>
      <?php } ?>
    </div>
  </div>
</div>
<?php
  include('../assets/includes/footer.php');
?>