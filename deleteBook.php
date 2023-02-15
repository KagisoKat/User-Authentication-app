<?php 
  session_start();
  if(isset($_SESSION['userType']) && $_SESSION['userType'] == 'librarian') {
    if(isset( $_GET['book_id'])) {
      $bookId = $_GET['book_id'];
      require('./config/db.php');
      echo "Delete book id " . $bookId;
      $stmt = $pdo -> prepare('DELETE FROM books WHERE book_id = ?');
      $stmt -> execute( [$bookId] );
      //header( "refresh:5;url=admin.php" );
      header( "Location: admin.php" );
    }
  } else {
    echo "Unauthorized";
    //header( "refresh:5;url=login.php" );
  }
?>