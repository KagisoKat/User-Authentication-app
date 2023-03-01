<?php
session_start();

spl_autoload_register( function($class) {
  $classSplit=explode('\\', $class);
  $path = 'classes/';
  require_once  $path . $classSplit[0] . '/' . $classSplit[1] .'.php';
 });

if (isset($_GET['book_id'])) {
  $bookId=$_GET['book_id'];
}

if(isset($_SESSION['userType']) && $_SESSION['userType'] == 'librarian') {
  require('./config/db.php');
  $getstmt = $pdo -> prepare('SELECT book_name, book_year, book_genre, book_age_group, author_id FROM books WHERE book_id = ?');
  $getstmt -> execute( [$bookId] );
  $currentBookItem = $getstmt->fetch();
  $currentBook = new Library\Book();
  $currentBook->setName($currentBookItem->book_name);
  $currentBook->setYear($currentBookItem->book_year);
  $currentBook->setGenre($currentBookItem->book_genre);
  $currentBook->setAgeGroup($currentBookItem->book_age_group);
  $currentBook->setAuthorId($currentBookItem->author_id);
} else {
  echo "Unauthorized!";
}

if(isset( $_POST['updateBook'])) {
  require('./config/db.php');
  
  $book = new Library\Book();
  $book->setId($bookId);
  $book->setName(filter_var($_POST["bookName"], FILTER_SANITIZE_STRING ));
  $book->setYear(filter_var($_POST["bookYear"], FILTER_SANITIZE_EMAIL ));
  $book->setGenre(filter_var($_POST["bookGenre"], FILTER_SANITIZE_STRING ));
  $book->setAgeGroup(filter_var($_POST["bookAgeGroup"], FILTER_SANITIZE_STRING ));
  $book->setAuthorId(filter_var($_POST["authorId"], FILTER_SANITIZE_STRING ));

  $stmt = $pdo -> prepare('UPDATE books SET book_name = ?, book_year = ?, book_genre = ?, book_age_group = ?, author_id = ? WHERE book_id= ?');
  $stmt -> execute( [$book->getName(), $book->getYear(), $book->getGenre(), $book->getAgeGroup(),$book->getAuthorId(), $bookId] );
  header('Location: admin.php');
}
?>

 <?php require('./inc/header.html'); ?>


<div class="container">
 <div class="card">
   <div class="card-header bg-light mb-3">Edit/Update</div>
    <div class="card-body">
        <form action="editBook.php?book_id=<?php echo $bookId ?>" method="POST">
          <div class="form-group">
           <label for="bookName">Book Name</label>
            <input required type="text" name="bookName" class="form-control" value="<?php echo $currentBook->getName() ?>"/>
         </div>
         <div class="form-group">
           <label for="bookYear">Book Year</label>
            <input required type="text" name="bookYear" class="form-control" value="<?php echo $currentBook->getYear() ?>"/>
            <br />

         </div>
         <div class="form-group">
           <label for="bookGenre">Book Genre</label>
            <input required type="text" name="bookGenre" class="form-control" value="<?php echo $currentBook->getGenre() ?>"/>
            <br />

         </div>
         <div class="form-group">
           <label for="bookAgeGroup">Book Age Group</label>
            <input required type="text" name="bookAgeGroup" class="form-control" value="<?php echo $currentBook->getAgeGroup() ?>"/>
            <br />

         </div>
         <div class="form-group">
         <select name="authorId">
         <?php
            require('./config/db.php');
                 $stmt2 = $pdo -> prepare('SELECT author_id, author_name FROM authors');
                 $stmt2 -> execute();
                 $authors = $stmt2->fetchAll(); 
                 foreach($authors as $author_item) {
                   $author = new Library\Author();
                   $author->setId($author_item->author_id);
                   $author->setName($author_item->author_name);
                   echo '<option value="' . $author_item->author_id . '"';
                   if ($author->getId() == $currentBook->getAuthorId()) echo " selected='selected'";
                   echo '">' . $author->getName() . '</option>';
                 }
         ?>
      </select>
         </div>
         <div class="form-group">

         <br/>
         <button name="updateBook" type="submit" class="btn btn-primary">Update Book</button>
       </form>
     </div>
    </div>
</div>
 
 <?php require('./inc/footer.html'); ?>