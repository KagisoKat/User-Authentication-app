<!-- for librarians to edit and add authors -->

<?php

session_start();

spl_autoload_register( function($class) {
  $path = 'classes/';
  require_once  $path . $class .'.php';
 });

if (isset($_SESSION['userId'])) {
   $userId = $_SESSION['userId'];
   if (isset($_POST['search'])) {
      require('./config/db.php');
      $searchString = "%" . filter_var($_POST["searchText"], FILTER_SANITIZE_STRING) . "%";
      $stmt = $pdo->prepare('SELECT authors.author_id, authors.author_name, authors.author_age, authors.author_genre FROM  authors WHERE authors.author_name LIKE :ss ORDER BY author_name');
      $stmt->bindValue(':ss', $searchString);
      $stmt->execute();

   } else {
      require('./config/db.php');



      $stmt = $pdo->prepare('SELECT authors.author_id, authors.author_name, authors.author_age, authors.author_genre FROM  authors ORDER BY author_name');
      $stmt->execute();
   }

   $authors = $stmt->fetchAll();

   if ($_SESSION['userType'] === 'librarian') {
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
            <form method="post" name="searchForm" action="admin.php">

               <input type="text" name="searchText" class="form-control mt-2" />
               <button name="search" type="submit" class="btn btn-primary mt-3 mb-2">Search</button>
            </form>


            <h3>Hi, <span>Librarian</span></h3>
            <h1>Welcome <span>
                  <?php echo $_SESSION['userName'] ?>
               </span></h1>
            <p>This is a Librarian page</p>

         </div>


         <div>
            <table border="1" width="100%">
               <tr>
                  <th>Name</th>
                  <th>Age</th>
                  <th>Genre</th>
               </tr>


               <?php
               // output data of each row
               foreach ($authors as $author_item) {
                  $author = new Library\Author();
                  $author->setName($author_item->author_name);
                  $author->setAge($author_item->author_age);
                  $author->setGenre($author_item->author_genre);
                  $author->setId($author_item->author_id);
                  echo "<tr>";
                  echo "<td>" . $author->getName() . "</td>";
                  echo "<td>" . $author->getAge() . "</td>";
                  echo "<td>" . $author->getGenre() . "</td>";
                  echo "<td><a href='editAuthor.php?author_id=" . $author->getId() . "'>Edit</a></td>";
                  echo "<td><a href='deleteAuthor.php?author_id=" . $author->getId() . "'>Delete</a></td>";
                  echo "</tr>";
               }
}
?>
         </table>
      </div>
   </div>

</body>

</html>