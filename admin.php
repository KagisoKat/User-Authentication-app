<?php

session_start();

if(isset($_SESSION['userId'])) {
 require('./config/db.php');

 $userId = $_SESSION['userId'];

 $stmt = $pdo -> prepare('SELECT * FROM users WHERE id = ? ');
 $stmt -> execute( [ $userId ]);

 $user = $stmt ->fetch(); 

 if ($user->role === 'admin' ) {
    $message = "Your role is admin";
}


}

?>

 <?php require('./inc/header.html'); ?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>admin page</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<div class="container">

   <div class="content">
      <h3>Hi, <span>Admin</span></h3>
      <h1>Welcome <span><?php echo $_SESSION['userName'] ?></span></h1>
      <p>This is an Admin page</p>

   </div>

</div>

</body>
</html>