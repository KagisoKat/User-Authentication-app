<?php

if (isset($_POST['reset'])) {
  require('./config/db.php');

spl_autoload_register( function($class) {
  $classSplit=explode('\\', $class);
  $path = 'classes/';
  require_once  $path . $classSplit[0] . '/' . $classSplit[1] .'.php';
 });


  //  $userName = $_POST["userName"];
//  $userEmail = $_POST["userEmail"];
//  $password = $_POST["password"];
  $user = new Library\User();
  $user->setEmail(filter_var($_POST["userEmail"], FILTER_SANITIZE_EMAIL));
  $user->setPassword(filter_var($_POST["password"], FILTER_SANITIZE_STRING));

  $user->setPasswordHashed(password_hash($user->getPassword(), PASSWORD_DEFAULT));

  if (filter_var($user->getEmail(), FILTER_SANITIZE_STRING)) {
    $stmt = $pdo->prepare('SELECT * from users WHERE email = ? ');
    $stmt->execute([$user->getEmail()]);
    $totalUsers = $stmt->rowCount();

    // echo $totalUsers . '<br>';

    if ($totalUsers != 1) {
      // echo "Email already in use <br>";
      $emailNotExist = "Email does not exist";
    } else {
      $stmt = $pdo->prepare('UPDATE users SET password = ? WHERE email = ?');
      $stmt->execute([$user->getPasswordHashed(), $user->getEmail()]);
      header('Location: login.php');
    }
  }
}
?>
<!-- the register page for both members and librarians -->
<?php require('./inc/header.html'); ?>


<div class="container">
  <div class="card">
    <div class="card-header bg-light mb-3">Reset Password</div>
    <div class="card-body">
      <form action="forgot.php" method="POST">
        <div class="form-group">
          <label for="userEmail">User Email</label>
          <input required type="email" name="userEmail" class="form-control" />
          <br />
          <?php if (isset($emailNotExist)) { ?>
            <p>
              <?php echo $emailNotExist ?>
            <p>
            <?php }
          $emailEmailNotExist ?>
        </div>
        <div class="form-group">
          <label for="password">Password</label>
          <input required type="password" name="password" class="form-control" />
        </div>
        <br />
        <button name="reset" type="submit" class="btn btn-primary">Reset</button>
      </form>
    </div>
  </div>
</div>

<?php require('./inc/footer.html'); ?>