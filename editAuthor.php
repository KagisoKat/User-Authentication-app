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
  $currentAuthorItem = $getstmt->fetch();
  $currentAuthor = new Library\Author();
  $currentAuthor->setName($currentAuthorItem->author_name);
  $currentAuthor->setAge($currentAuthorItem->author_age);
  $currentAuthor->setGenre($currentAuthorItem->author_genre);
} else {
  echo "Unauthorized!";
}

if(isset( $_POST['updateAuthor'])) {
 require('./config/db.php');


$author = new Library\Author();
$author->setId($authorId);
$author->setName(filter_var($_POST["authorName"], FILTER_SANITIZE_STRING ));
$author->setAge(filter_var($_POST["authorAge"], FILTER_SANITIZE_EMAIL ));
$author->setGenre(filter_var($_POST["authorGenre"], FILTER_SANITIZE_STRING ));


$stmt = $pdo -> prepare('UPDATE authors SET author_name = ?, author_age = ?, author_genre = ? WHERE author_id=?');
$stmt -> execute( [$author->getName(), $author->getAge(), $author->getGenre(), $author->getId()] );
header('Location: adminAuthors.php');
}
?>

 <?php require('./inc/header.html'); ?>


<div class="container">
 <div class="card">
   <div class="card-header bg-light mb-3">Edit/Update</div>
    <div class="card-body">
        <form action="editAuthor.php?author_id=<?php echo $authorId ?>" method="POST">
          <div class="form-group">
           <label for="authorName">Author Name</label>
            <input required type="text" name="authorName" class="form-control" value="<?php echo $currentAuthor->getName() ?>"/>
         </div>
         <div class="form-group">
           <label for="authorAge">Author Age</label>
            <input required type="text" name="authorAge" class="form-control" value="<?php echo $currentAuthor->getAge() ?>"/>
            <br />
            <div class="form-group">
           <label for="authorGenre">Author Genre</label>
            <input required type="text" name="authorGenre" class="form-control" value="<?php echo $currentAuthor->getGenre() ?>"/>
            <br />
         </div>



         <br/>
         <button name="updateAuthor" type="submit" class="btn btn-primary">Update Author</button>
       </form>
     </div>
    </div>
</div>
 
 <?php require('./inc/footer.html'); ?>