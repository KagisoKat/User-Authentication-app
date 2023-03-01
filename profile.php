<?php
session_start();

spl_autoload_register( function($class) {
  $classSplit=explode('\\', $class);
  $path = 'classes/';
  require_once  $path . $classSplit[0] . '/' . $classSplit[1] .'.php';
 });


if  (isset($_SESSION['userId'])) {
    require('./config/db.php');
    
    $userId = $_SESSION['userId'];

    $stmt = $pdo ->prepare('SELECT * from users WHERE id = ?');
    $stmt->execute([$userId]);

    $user_item = $stmt -> fetch();
    $user = new Library\User();
    $user->setId($user_item->id);
    $user->setName($user_item->name);
    $user->setEmail($user_item->email);
    $user->setPassword($user_item->password);
    $user->setRole($user_item->role);
}
if(isset( $_POST['profile'])) {
 

//  $userName = $_POST["userName"];
//  $userEmail = $_POST["userEmail"];
//  $password = $_POST["password"];
$user = new Library\User();
$user->setId($_SESSION['userId']);
$user->setName(filter_var($_POST["userName"], FILTER_SANITIZE_STRING ));
$user->setEmail(filter_var($_POST["userEmail"], FILTER_SANITIZE_EMAIL ));
$user->setPassword(filter_var($_POST["password"], FILTER_SANITIZE_STRING ));
$user->setPasswordHashed(password_hash($password, PASSWORD_DEFAULT));

$stmt = $pdo -> prepare('UPDATE users SET name = ?, email = ? password = ? WHERE id = ?');
$stmt -> execute( [$user->getPassword(), $user->getEmail(), $user->getPasswordHashed(), $user->getId()] );
}
  //if( filter_var($userEmail, FILTER_SANITIZE_STRING) ) {
  //  $stmt = $pdo -> prepare('SELECT * from users WHERE email = ? ');
  //  $stmt -> execute( [$userEmail] );
  //  $totalUsers = $stmt -> rowCount();

    // echo $totalUsers . '<br>';

    //if( $totalUsers > 0 ) {
    //    // echo "Email already in use <br>";
    //    $emailTaken = "Email already been taken";
    //} else {
    //    $stmt = $pdo -> prepare('INSERT into users (name, email, password) VALUES(? , ?, ? ) ');
    //    $stmt -> execute( [$userName, $userEmail, $passwordHashed] );
    //    header('Location: http://localhost/login/index.php');
    //}
 //}

?>

 <?php require('./inc/header.html'); ?>


<div class="container">
 <div class="card">
   <div class="card-header bg-light mb-3">Update Your Details</div>
    <div class="card-body">
        <form action="profile.php" method="POST">
          <div class="form-group">
           <label for="userName">User Name</label>
            <input required type="text" name="userName" class="form-control"  value="<?php echo $user->getName() ?>" />
         </div>
         <div class="form-group">
           <label for="userEmail">User Email</label>
            <input required type="email" name="userEmail" class="form-control" value="<?php echo $user->getEmail() ?>" />
            <br />
            <?php if(isset($emailTaken)) { ?>
             <p><?php echo $emailTaken ?><p>
            <?php } $emailTaken ?>
         </div>
         <button name="edit" type="submit" class="btn btn-primary">Update the details</button>
       </form>
     </div>
    </div>
</div>
 
 <?php require('./inc/footer.html'); ?>