<?php

session_start();

if(isset($_SESSION['userId'])) {
    $userId = $_SESSION['userId'];
    if(isset( $_POST['search'])) {
        require('./config/db.php');
        $searchString = "%" . filter_var($_POST["searchText"], FILTER_SANITIZE_STRING ) . "%";
        $stmt = $pdo -> prepare('SELECT books.book_name, authors.author_name ,books.book_year, books.book_genre, books.book_age_group FROM books INNER JOIN authors ON books.author_id=authors.author_id WHERE books.book_name LIKE :ss OR authors.author_name LIKE :ss ORDER BY book_name,author_name, book_genre ');
        $stmt->bindValue(':ss', $searchString);
        $stmt -> execute();

    } else {
 require('./config/db.php');



 $stmt = $pdo -> prepare('SELECT books.book_name, authors.author_name ,books.book_year, books.book_genre, books.book_age_group FROM books INNER JOIN authors ON books.author_id=authors.author_id ORDER BY book_name,author_name, book_genre');
 $stmt -> execute();
}

 $books = $stmt->fetchAll(); 

 if ($_SESSION['userType'] === 'admin' ) {
    $message = "Your role is Librarian";
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
   <form  method="post" name="searchForm" action="admin.php">

   <input type="text" name="searchText" class="form-control" />
   <button name="search" type="submit" class="btn btn-primary">Search</button>
   </form>

      <h3>Hi, <span>Librarian</span></h3>
      <h1>Welcome <span><?php echo $_SESSION['userName'] ?></span></h1>
      <p>This is a Librarian page</p>

   </div>
   <div>
   <table>
    <tr>
        <th>Name</th>
        <th>author</th>
        <th>Year</th>
        <th>Genre</th>
        <th>Age Group</th>
    </tr>


<?php
    // output data of each row
    foreach($books as $book) {
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