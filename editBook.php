<?php
session_start();

spl_autoload_register( function($class) {
  $path = 'classes/';
  require_once  $path . $class .'.php';
 });

if (isset($_GET['book_id'])) {
  $bookId=$_GET['book_id'];
}

if(isset($_SESSION['userType']) && $_SESSION['userType'] == 'librarian') {
  require('./config/db.php');
  $getstmt = $pdo -> prepare('SELECT book_name, book_year, book_genre, book_age_group, author_id FROM books WHERE book_id = ?');
  $getstmt -> execute( [$bookId] );
  $currentBook = $getstmt->fetch();
} else {
  echo "Unauthorized!";
}

if(isset( $_POST['updateBook'])) {
  require('./config/db.php');
  
  $bookName = filter_var($_POST["bookName"], FILTER_SANITIZE_STRING );
  $bookYear = filter_var($_POST["bookYear"], FILTER_SANITIZE_EMAIL );
  $bookGenre = filter_var($_POST["bookGenre"], FILTER_SANITIZE_STRING );
  $bookAgeGroup = filter_var($_POST["bookAgeGroup"], FILTER_SANITIZE_STRING );
  $authorId = filter_var($_POST["authorId"], FILTER_SANITIZE_STRING );

  $stmt = $pdo -> prepare('UPDATE books SET book_name = ?, book_year = ?, book_genre = ?, book_age_group = ?, author_id = ? WHERE book_id= ?');
  $stmt -> execute( [$bookName, $bookYear, $bookGenre, $bookAgeGroup,$authorId, $bookId] );
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
            <input required type="text" name="bookName" class="form-control" value="<?php echo $currentBook->book_name ?>"/>
         </div>
         <div class="form-group">
           <label for="bookYear">Book Year</label>
            <input required type="text" name="bookYear" class="form-control" value="<?php echo $currentBook->book_year ?>"/>
            <br />

         </div>
         <div class="form-group">
           <label for="bookGenre">Book Genre</label>
            <input required type="text" name="bookGenre" class="form-control" value="<?php echo $currentBook->book_genre ?>"/>
            <br />

         </div>
         <div class="form-group">
           <label for="bookAgeGroup">Book Age Group</label>
            <input required type="text" name="bookAgeGroup" class="form-control" value="<?php echo $currentBook->book_age_group ?>"/>
            <br />

         </div>
         <div class="form-group">
         <select name="authorId">
         <?php
            require('./config/db.php');
                 $stmt2 = $pdo -> prepare('SELECT author_id, author_name FROM authors');
                 $stmt2 -> execute();
                 $authors = $stmt2->fetchAll(); 
                 foreach($authors as $author) {
                 echo '<option value="' . $author->author_id . '"';
                 if ($author->author_id == $currentBook->author_id) echo " selected='selected'";
                 echo '">' . $author->author_name . '</option>';
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