<?php
session_start();

if(isset($_SESSION['userType']) && $_SESSION['userType'] == 'librarian') {
  if(isset( $_POST['registerAuthor'])) {
 require('./config/db.php');

spl_autoload_register( function($class) {
  $path = 'classes/';
  require_once  $path . $class .'.php';
 });

//  $userName = $_POST["userName"];
//  $userEmail = $_POST["userEmail"];
//  $password = $_POST["password"];
$author = new Library\Author();
$author->setName(filter_var($_POST["authorName"], FILTER_SANITIZE_STRING ));
$author->setAge(filter_var($_POST["authorAge"], FILTER_SANITIZE_EMAIL ));
$author->setGenre(filter_var($_POST["authorGenre"], FILTER_SANITIZE_STRING ));


        $stmt = $pdo -> prepare('INSERT into authors (author_name, author_age, author_genre) VALUES (?, ?, ?) ');
        $stmt -> execute( [$author->getName(), $author->getAge(), $author->getGenre()] );
        header('Location: adminAuthors.php');
    
 }
} else {
    echo "Unauthorized!";
}
?>

 <?php require('./inc/header.html'); ?>


<div class="container">
 <div class="card">
   <div class="card-header bg-light mb-3">Register</div>
    <div class="card-body">
        <form action="registerAuthor.php" method="POST">
          <div class="form-group">
           <label for="authorName">Author Name</label>
            <input required type="text" name="authorName" class="form-control" />
         </div>
         <div class="form-group">
           <label for="authorAge">Author Age</label>
            <input required type="text" name="authorAge" class="form-control" />
            <br />
            <div class="form-group">
           <label for="authorGenre">Author Genre</label>
            <input required type="text" name="authorGenre" class="form-control" />
            <br />
         </div>



         <br/>
         <button name="registerAuthor" type="submit" class="btn btn-primary">Register Author</button>
       </form>
     </div>
    </div>
</div>
 
 <?php require('./inc/footer.html'); ?>