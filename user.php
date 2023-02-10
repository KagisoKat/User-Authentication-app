<?php

session_start();

if(isset($_SESSION['userId'])) {
    $userId = $_SESSION['userId'];
    if(isset( $_POST['search'])) {
        require('./config/db.php');
        $searchString = "%" . filter_var($_POST["searchText"], FILTER_SANITIZE_STRING ) . "%";
        $stmt = $pdo -> prepare('SELECT book_name, book_year, book_genre, book_age_group FROM books WHERE book_name LIKE :ss GROUP BY book_genre ORDER BY book_name ');
        $stmt->bindValue(':ss', $searchString);
        $stmt -> execute();

    } else {
 require('./config/db.php');



 $stmt = $pdo -> prepare('SELECT book_name, book_year, book_genre, book_age_group FROM books ');
 $stmt -> execute();
}

 $books = $stmt->fetchAll(); 

 if ($_SESSION['userType'] === 'user' ) {
    $message = "Your role is user";
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
   <form  method="post" name="searchForm" action="user.php">

   <input type="text" name="searchText" class="form-control" />
   <button name="search" type="submit" class="btn btn-primary">Search</button>
   </form>

      <h3>Hi, <span>Member</span></h3>
      <h1>Welcome <span><?php echo $_SESSION['userName'] ?></span></h1>
      <p>This is a Members page</p>

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
      echo "<tr>";
      echo "<td>" . $book->book_name . "</td>";
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