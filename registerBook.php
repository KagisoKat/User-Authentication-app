<?php

if(isset( $_POST['register'])) {
 require('./config/db.php');

//  $userName = $_POST["userName"];
//  $userEmail = $_POST["userEmail"];
//  $password = $_POST["password"];
$userName = filter_var($_POST["userName"], FILTER_SANITIZE_STRING );
$userEmail = filter_var($_POST["userEmail"], FILTER_SANITIZE_EMAIL );
$password = filter_var($_POST["password"], FILTER_SANITIZE_STRING );
$userType = filter_var($_POST["userType"], FILTER_SANITIZE_STRING );

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
        $stmt = $pdo -> prepare('INSERT into users (name, email, password, role) VALUES (?, ?, ?, ?) ');
        $stmt -> execute( [$userName, $userEmail, $passwordHashed, $userType] );
        header('Location: http://localhost/login/index.php');
    }
 }
}
?>

 <?php require('./inc/header.html'); ?>


<div class="container">
 <div class="card">
   <div class="card-header bg-light mb-3">Register</div>
    <div class="card-body">
        <form action="registerBook.php" method="POST">
          <div class="form-group">
           <label for="bookName">Book Name</label>
            <input required type="text" name="bookName" class="form-control" />
         </div>
         <div class="form-group">
           <label for="bookYear">Book Year</label>
            <input required type="text" name="bookYear" class="form-control" />
            <br />

         </div>
         <div class="form-group">
           <label for="bookGenre">Book Genre</label>
            <input required type="text" name="bookGenre" class="form-control" />
            <br />

         </div>
         <div class="form-group">
           <label for="bookAgeGroup">Book Age Group</label>
            <input required type="text" name="bookAgeGroup" class="form-control" />
            <br />

         </div>
         <div class="form-group">
         <select name="author">
         <?php
                 $stmt = $pdo -> prepare('SELECT author_id, author_name FROM authors');
                 $stmt -> execute();
                 $books = $stmt->fetchAll(); 
         <option value="user">user</option>
         <option value="admin">admin</option>
         ?>
      </select>
         </div>
         <div class="form-group">

         <br/>
         <button name="register" type="submit" class="btn btn-primary">Register</button>
       </form>
     </div>
    </div>
</div>
 
 <?php require('./inc/footer.html'); ?>