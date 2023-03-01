<!-- this is a members page where they get access to books -->
<?php

session_start();

spl_autoload_register( function($class) {
  $path = 'classes/';
  require_once  $path . $class .'.php';
 });

$sortMethod="name";
if (isset($_GET['sorting'])) {
    if ($_GET['sorting'] == 'name') {
        $sortMethod="name";
    } elseif ($_GET['sorting'] == 'genre') {
        $sortMethod="genre";
    }
}

if(isset($_SESSION['userId'])) {
    $userId = $_SESSION['userId'];
    if(isset( $_POST['search'])) {
        require('./config/db.php');
        $searchString = "%" . filter_var($_POST["searchText"], FILTER_SANITIZE_STRING ) . "%";

        if ($sortMethod == 'name') {
            $stmt = $pdo -> prepare('SELECT book_name, book_year, book_genre, book_age_group FROM books WHERE book_name LIKE :ss ORDER BY book_name');
        } elseif  ($sortMethod == 'genre') {
            $stmt = $pdo -> prepare('SELECT book_name, book_year, book_genre, book_age_group FROM books WHERE book_name LIKE :ss ORDER BY book_genre ');
        }

        $stmt->bindValue(':ss', $searchString);
        $stmt -> execute();

    } else {
 require('./config/db.php');



 if ($sortMethod == 'name') {
    $stmt = $pdo -> prepare('SELECT book_name, book_year, book_genre, book_age_group FROM books  ORDER BY book_name');
 } elseif  ($sortMethod == 'genre') {
    $stmt = $pdo -> prepare('SELECT book_name, book_year, book_genre, book_age_group FROM books  ORDER BY book_genre');
 }
 $stmt -> execute();

}

 $books = $stmt->fetchAll();

 if ($_SESSION['userType'] === 'member' ) {
    $message = "Your role is Member";
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

   <input type="text" name="searchText" class="form-control mt-2" />
   <button name="search" type="submit" class="btn btn-primary mt-2 mb-2" >Search</button>
   <br/>
   </form>

      <h3>Hi, <span>Member</span></h3>
      <h1>Welcome <span><?php echo $_SESSION['userName'] ?></span></h1>
      <p>This is a Members page</p>

   </div>

    <div>
        Sorting:
        <a href="user.php?sorting=name">Name</a>
        <a href="user.php?sorting=genre">Genre</a>
    </div>
   
   <div>
   <table border="1" width="100%">
    <tr>
        <th>Name</th>
        <th>Year</th>
        <th>Genre</th>
        <th>Age Group</th>
    </tr>


<?php
    // output data of each row
    foreach($books as $book_item) {
      $book = new Book();
      $book->setName($book_item->book_name);
      $book->setYear($book_item->book_year);
      $book->setGenre($book_item->book_genre);
      $book->setAgeGroup($book_item->book_age_group);
      echo "<tr>";
      echo "<td>" . $book->getName() . "</td>";
      echo "<td>" . $book->getYear() . "</td>";
      echo "<td>" . $book->getGenre() . "</td>";
      echo "<td>" . $book->getAgeGroup() . "</td>";
      echo "</tr>";
    }
}
?>
</table>
</div>
</div>

</body>
</html>