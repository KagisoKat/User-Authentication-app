<?php

session_start();

if(isset($_SESSION['userId'])) {
    $userId = $_SESSION['userId'];
    if(isset( $_POST['search'])) {
        require('./config/db.php');
        $searchString = "%" . filter_var($_POST["searchText"], FILTER_SANITIZE_STRING ) . "%";
        $stmt = $pdo -> prepare('SELECT authors.author_name, authors.author_age, authors.author_genre FROM  authors WHERE authors.author_name LIKE :ss ORDER BY author_name');
        $stmt->bindValue(':ss', $searchString);
        $stmt -> execute();

    } else {
 require('./config/db.php');



 $stmt = $pdo -> prepare('SELECT authors.author_name, authors.author_age, authors.author_genre FROM  authors ORDER BY author_name');
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
   <link rel="stylesheet" href="css/styles.css">

</head>
<body>
   
<div class="container">

   <div class="content">
   <form  method="post" name="searchForm" action="admin.php">

   <input type="text" name="searchText" class="form-control mt-2" />
   <button name="search" type="submit" class="btn btn-primary mt-3 mb-2"  >Search</button>
   </form>
  

      <h3>Hi, <span>Librarian</span></h3>
      <h1>Welcome <span><?php echo $_SESSION['userName'] ?></span></h1>
      <p>This is a Librarian page</p>

   </div>
  

   <div >
   <table border="1" width="100%">
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
      echo "<td><button>Edit</button></td>";
      echo "<td><button>Delete</button></td>";
      echo "</tr>";
    }
}
?>
</table>
</div>
</div>

</body>
</html>