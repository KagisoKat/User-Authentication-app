<?php
session_start();
if(isset( $_POST['registerBook'])) {

    require('./config/db.php');
//  $userName = $_POST["userName"];
//  $userEmail = $_POST["userEmail"];
//  $password = $_POST["password"];
$bookName = filter_var($_POST["bookName"], FILTER_SANITIZE_STRING );
$bookYear = filter_var($_POST["bookYear"], FILTER_SANITIZE_EMAIL );
$bookGenre = filter_var($_POST["bookGenre"], FILTER_SANITIZE_STRING );
$bookAgeGroup = filter_var($_POST["bookAgeGroup"], FILTER_SANITIZE_STRING );
$authorId = filter_var($_POST["authorId"], FILTER_SANITIZE_STRING );



        $stmt = $pdo -> prepare('INSERT into books (book_name, book_year, book_genre, book_age_group, author_id) VALUES (?, ?, ?, ?,?) ');
        $stmt -> execute( [$bookName, $bookYear, $bookGenre, $bookAgeGroup,$authorId] );
        header('Location: http://localhost/login/admin.php');

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
         <select name="authorId">
         <?php
            require('./config/db.php');
                 $stmt2 = $pdo -> prepare('SELECT author_id, author_name FROM authors');
                 $stmt2 -> execute();
                 $authors = $stmt2->fetchAll(); 
                 foreach($authors as $author) {
                 echo '<option value="' . $author->author_id . '">' .$author->author_name . '</option>';
                 }
         ?>
      </select>
         </div>
         <div class="form-group">

         <br/>
         <button name="registerBook" type="submit" class="btn btn-primary">Register Book</button>
       </form>
     </div>
    </div>
</div>
 
 <?php require('./inc/footer.html'); ?>