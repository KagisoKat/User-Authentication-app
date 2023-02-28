<?php
session_start();

if (isset($_GET['author_id'])) {
  $authorId=$_GET['author_id'];
}

spl_autoload_register( function($class) {
  $path = 'classes/';
  require_once  $path . $class .'.php';
 });

if(isset($_SESSION['userType']) && $_SESSION['userType'] == 'librarian') {
  require('./config/db.php');
  $getstmt = $pdo -> prepare('SELECT author_name, author_age, author_genre FROM authors WHERE author_id = ?');
  $getstmt -> execute( [$authorId] );
  $currentAuthor = $getstmt->fetch();
} else {
  echo "Unauthorized!";
}

if(isset( $_POST['updateAuthor'])) {
 require('./config/db.php');


$authorName = filter_var($_POST["authorName"], FILTER_SANITIZE_STRING );
$authorAge = filter_var($_POST["authorAge"], FILTER_SANITIZE_EMAIL );
$authorGenre = filter_var($_POST["authorGenre"], FILTER_SANITIZE_STRING );


$stmt = $pdo -> prepare('UPDATE authors SET author_name = ?, author_age = ?, author_genre = ? WHERE author_id=?');
$stmt -> execute( [$authorName, $authorAge, $authorGenre, $authorId] );
header('Location: adminAuthors.php');
}
?>

 <?php require('./inc/header.html'); ?>


<div class="container">
 <div class="card">
   <div class="card-header bg-light mb-3">Edit/Update</div>
    <div class="card-body"mm
        <form action="editAuthor.php?author_id=<?php echo $authorId ?>" method="POST">
          <div class="form-group">
           <label for="authorName">Author Name</label>
            <input required type="text" name="authorName" class="form-control" value="<?php echo $currentAuthor->author_name ?>"/>
         </div>
         <div class="form-group">
           <label for="authorAge">Author Age</label>
            <input required type="text" name="authorAge" class="form-control" value="<?php echo $currentAuthor->author_age ?>"/>
            <br />
            <div class="form-group">
           <label for="authorGenre">Author Genre</label>
            <input required type="text" name="authorGenre" class="form-control" value="<?php echo $currentAuthor->author_genre ?>"/>
            <br />
         </div>



         <br/>
         <button name="updateAuthor" type="submit" class="btn btn-primary">Update Author</button>
       </form>
     </div>
    </div>
</div>
 
 <?php require('./inc/footer.html'); ?>