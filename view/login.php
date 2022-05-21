<?php
  include('../controller/UserController.php');
  $userData->isLogin('id');
  include('../assets/includes/header.php');
?>
<div class="container">
  <div class="card">
    <?php include('../assets/includes/message.php'); ?>
    <div class="card-header">
        <h1>Login</h1>
    </div>
    <div class="card-body">
      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <div class="form-group">
          Email: <span>*</span>
          <input type="text" name="email" class="form-control"
            value="<?php
              if (isset($_COOKIE['email'])) {
                echo $_COOKIE['email'];
              } else {
                echo $email;
              }
              ?>" placeholder="Enter Email" />
          <span class="error-show"><?php echo isset($_GET['email']) ? $_GET['email'] : NULL; ?></span>
        </div>
        <div class="form-group">
          Password: <span>*</span>
          <input type="password" name="pass" class="form-control"
          value="<?php
              if (isset($_COOKIE['password'])) {
                echo $_COOKIE['password'];
              }
              ?>" placeholder="Enter Password" />
          <span class="error-show"><?php echo isset($_GET['password']) ? $_GET['password'] : NULL; ?></span>
        </div><div class="form-group">
          <input type="checkbox" name="remember" <?php if(isset($_COOKIE["email"])) { ?> checked <?php } ?>/> Remember me
        </div>
    </div>
      <div class="card-footer">
          <a href="register.php">Create a new account?</a>
          <input type="submit" name="user_login" class="btn btn-primary" value="Submit" />
        </form>
      </div>
    </div>
  </div>
</div>