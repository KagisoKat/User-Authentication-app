<?php

if (isset($_POST['register'])) {
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
  $user->setName(filter_var($_POST["userName"], FILTER_SANITIZE_STRING));
  $user->setEmail(filter_var($_POST["userEmail"], FILTER_SANITIZE_EMAIL));
  $user->setPassword(filter_var($_POST["password"], FILTER_SANITIZE_STRING));
  $user->setRole(filter_var($_POST["userType"], FILTER_SANITIZE_STRING));

  $user->setPasswordHashed(password_hash($user->getPassword(), PASSWORD_DEFAULT));

  if (filter_var($user->getEmail(), FILTER_SANITIZE_STRING)) {
    $stmt = $pdo->prepare('SELECT * from users WHERE email = ? ');
    $stmt->execute([$user->getEmail()]);
    $totalUsers = $stmt->rowCount();

    // echo $totalUsers . '<br>';

    if ($totalUsers > 0) {
      // echo "Email already in use <br>";
      $emailTaken = "Email already been taken";
    } else {
      $stmt = $pdo->prepare('INSERT into users (name, email, password, role) VALUES (?, ?, ?, ?) ');
      $stmt->execute([$user->getName(), $user->getEmail(), $user->getPasswordHashed(), $user->getRole()]);
      header('Location: http://localhost/login/index.php');
    }
  }
}
?>
<!-- the register page for both members and librarians -->
<?php require('./inc/header.html'); ?>


<div class="container">
  <div class="card">
    <div class="card-header bg-light mb-3">Register</div>
    <div class="card-body">
      <form action="register.php" method="POST">
        <div class="form-group">
          <label for="userName">User Name</label>
          <input required type="text" name="userName" class="form-control" />
        </div>
        <div class="form-group">
          <label for="userEmail">User Email</label>
          <input required type="email" name="userEmail" class="form-control" />
          <br />
          <?php if (isset($emailTaken)) { ?>
            <p>
              <?php echo $emailTaken ?>
            <p>
            <?php }
          $emailTaken ?>
        </div>
        <div class="form-group">
          <select name="userType">
            <option value="member">Member</option>
            <option value="librarian">Librarian</option>
          </select>
        </div>
        <div class="form-group">
          <label for="password">Password</label>
          <input required type="password" name="password" class="form-control" />
        </div>
        <br />
        <button name="register" type="submit" class="btn btn-primary">Register</button>
      </form>
    </div>
  </div>
</div>

<?php require('./inc/footer.html'); ?>