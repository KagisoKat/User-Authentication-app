<?php

session_start();

spl_autoload_register( function($class) {
  $path = 'classes/';
  require_once  $path . $class .'.php';
 });

if(isset($_SESSION['userId'])) {
 require('./config/db.php');

 $userId = $_SESSION['userId'];

 $stmt = $pdo -> prepare('SELECT * FROM users WHERE id = ? ');
 $stmt -> execute( [ $userId ]);

 $user = $stmt ->fetch(); 

 if ($user->role === 'guest' ) {
    $message = "Your role is guest";
}


}

?>

 <?php require('./inc/header.html'); ?>



 <div class="container">
  <div class= "card bg-light mb-3">
   <div class="card-header">
    <?php  if (isset($user)) { ?>
        <h5>Welcome <?php echo $user->name ?></h5>
        <?php } else { ?> 
    <h5>Welcome Guest</h5>
    <?php } ?>
   </div>
   <div class="card-body">

    <?php  if (isset($user)) { ?>
        <h5>Only Logged in users can enjoy this content</h5>
    <?php } else { ?> 
    <h4>Please Login/Register to unlock all the content</h4>
    <?php } ?>
   </div>
  </div>
 </div>
 <?php require('./inc/footer.html'); ?>
    