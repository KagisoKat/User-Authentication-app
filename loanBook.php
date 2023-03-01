<?php 
  session_start();
  
spl_autoload_register( function($class) {
  $path = 'classes/';
  require_once  $path . $class .'.php';
 });

    if(isset($_SESSION['userId'])) {
        $userId=$_SESSION['userId'];
        $userType=$_SESSION['userType'];
        if(isset( $_GET['book_id'])) {
          $bookId = $_GET['book_id'];
          require('./config/db.php');
          echo "Loaning Book " . $bookId;
          $stmt = $pdo -> prepare('UPDATE books SET loan_user_id = ? WHERE book_id = ?');
          $stmt -> execute( [$userid, $bookId] );
          //header( "refresh:5;url=admin.php" );
          if ($userType="librarian") {
            header( "Location: admin.php" );
          } elseif  ($userType="member") {
            header( "Location: user.php" );
          }
        }
    } else {
      echo "Not logged in"
    }
?>