<?php

session_start();

if(isset($_SESSION['userId'])) {
 require('./config/db.php');

 $userId = $_SESSION['userId'];

 $stmt = $pdo -> prepare('SELECT books.book_name, authors.author_name, books.book_year, books.book_genre, books.book_age_group FROM books INNER JOIN authors ON books.author_id = authors.author_id');
 $stmt -> execute();

 $books = $stmt ->fetchAll(); 

 if ($_SESSION['userType'] === 'admin' ) {
    $message = "Your role is admin";
}

?>

 <?php require('./inc/header.html'); ?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>admin page</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<div class="container">

   <div class="content">
      <h3>Hi, <span>Admin</span></h3>
      <h1>Welcome <span><?php echo $_SESSION['userName'] ?></span></h1>
      <p>This is an Admin page</p>


      
   </div>
   <div>
   <table>
    <tr>
        <th>Name</th>
        <th>Year</th>
        <th>Genre</th>
        <th>Age Group</th>
    </tr>


<?php
    // output data of each row
    foreach($books as $book) {
    //   var_dump($book);
      echo "<tr>";
      echo "<td>" . $book->book_name . "</td>";
      echo "<td>" . $book->author_name . "</td>";
      echo "<td>" . $book->book_year . "</td>";
      echo "<td>" . $book->book_genre . "</td>";
      echo "<td>" . $book->book_age_group . "</td>";
      echo "</tr>";
    }
}
?>
</table>
</div>
</div>

</body>
</html>