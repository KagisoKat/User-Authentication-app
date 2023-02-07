<?php
session_start();

if  (isset($_SESSION['userId'])) {
    require('./config/db.php');
    
    $userId = $_SESSION['userId'];

    $stmt = $pdo ->prepare('SELECT * from users WHERE id = ?');
    $stmt->execute([$userId]);

    $user = $stmt -> fetch();
}
if(isset( $_POST['profile'])) {
 

//  $userName = $_POST["userName"];
//  $userEmail = $_POST["userEmail"];
//  $password = $_POST["password"];
$userName = filter_var($_POST["userName"], FILTER_SANITIZE_STRING );
$userEmail = filter_var($_POST["userEmail"], FILTER_SANITIZE_EMAIL );
$password = filter_var($_POST["password"], FILTER_SANITIZE_STRING );
$passwordHashed = password_hash($password, PASSWORD_DEFAULT);

 if( filter_var($userEmail, FILTER_SANITIZE_STRING) ) {
    $stmt = $pdo -> prepare('SELECT * from users WHERE email = ? ');
    $stmt -> execute( [$userEmail] );
    $totalUsers = $stmt -> rowCount();

    // echo $totalUsers . '<br>';

    if( $totalUsers > 0 ) {
        // echo "Email already in use <br>";
        $emailTaken = "Email already been taken";
    } else {
        $stmt = $pdo -> prepare('INSERT into users (name, email, password) VALUES(? , ?, ? ) ');
        $stmt -> execute( [$userName, $userEmail, $passwordHashed] );
        header('Location: http://localhost/login/index.php');
    }
 }
}
?>

 <?php require('./inc/header.html'); ?>


<div class="container">
 <div class="card">
   <div class="card-header bg-light mb-3">Update Your Details</div>
    <div class="card-body">
        <form action="profile.php" method="POST">
          <div class="form-group">
           <label for="userName">User Name</label>
            <input required type="text" name="userName" class="form-control"  value="<?php echo $user->name ?>" />
         </div>
         <div class="form-group">
           <label for="userEmail">User Email</label>
            <input required type="email" name="userEmail" class="form-control" value="<?php echo $user->email ?>" />
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