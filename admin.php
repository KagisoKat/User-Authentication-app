<!-- for librarians to login and view books and authors, etc -->

<?php

session_start();

$sortMethod="name";
if (isset($_GET['sorting'])) {
    if ($_GET['sorting'] == 'name') {
        $sortMethod="name";
    } elseif ($_GET['sorting'] == 'author') {
        $sortMethod="author";
    } elseif ($_GET['sorting'] == 'genre') {
        $sortMethod="genre";
    }
}

spl_autoload_register( function($class) {
  echo "$class";
  $classSplit=explode('\\', $class);
  $path = 'classes/';
  require_once  $path . $classSplit[0] . '/' . $classSplit[1] .'.php';
 });

 $book1 = new Library\Book();

if (isset($_SESSION['userId'])) {
    $userId = $_SESSION['userId'];
    if (isset($_POST['search'])) {
        require('./config/db.php');
        $searchString = "%" . filter_var($_POST["searchText"], FILTER_SANITIZE_STRING) . "%";
        if ($sortMethod == 'name') {
            $stmt = $pdo->prepare('SELECT books.book_id, books.book_name, authors.author_name ,books.book_year, books.book_genre, books.book_age_group, books.loan_user_id FROM books INNER JOIN authors ON books.author_id=authors.author_id WHERE books.book_name LIKE :ss OR authors.author_name LIKE :ss ORDER BY book_name');
        } elseif ($sortMethod == 'author') {
            $stmt = $pdo->prepare('SELECT books.book_id, books.book_name, authors.author_name ,books.book_year, books.book_genre, books.book_age_group, books.loan_user_id FROM books INNER JOIN authors ON books.author_id=authors.author_id WHERE books.book_name LIKE :ss OR authors.author_name LIKE :ss ORDER BY author_name');
        } elseif ($sortMethod == 'genre') {
            $stmt = $pdo->prepare('SELECT books.book_id, books.book_name, authors.author_name ,books.book_year, books.book_genre, books.book_age_group, books.loan_user_id FROM books INNER JOIN authors ON books.author_id=authors.author_id WHERE books.book_name LIKE :ss OR authors.author_name LIKE :ss ORDER BY book_genre ');
        }
        $stmt->bindValue(':ss', $searchString);
        $stmt->execute();

    } else {
        require('./config/db.php');

        if ($sortMethod == 'name') {
        $stmt = $pdo->prepare('SELECT books.book_id, books.book_name, authors.author_name ,books.book_year, books.book_genre, books.book_age_group, books.loan_user_id FROM books INNER JOIN authors ON books.author_id=authors.author_id ORDER BY book_name');
        } elseif ($sortMethod == 'author') {
        $stmt = $pdo->prepare('SELECT books.book_id, books.book_name, authors.author_name ,books.book_year, books.book_genre, books.book_age_group, books.loan_user_id FROM books INNER JOIN authors ON books.author_id=authors.author_id ORDER BY author_name');
        } elseif ($sortMethod == 'genre') {
        $stmt = $pdo->prepare('SELECT books.book_id, books.book_name, authors.author_name ,books.book_year, books.book_genre, books.book_age_group, books.loan_user_id FROM books INNER JOIN authors ON books.author_id=authors.author_id ORDER BY book_genre');
        }
        $stmt->execute();
    }

    $books = $stmt->fetchAll();

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
                Sorting:
                <a href="admin.php?sorting=name">Name</a>
                <a href="admin.php?sorting=author">Author</a>
                <a href="admin.php?sorting=genre">Genre</a>
            </div>
            <div>

                <table border="1" width="100%">
                    <tr>
                        <th>Name</th>
                        <th>author</th>
                        <th>Year</th>
                        <th>Genre</th>
                        <th>Age Group</th>
                        <th>Loan</th>
                        <th>Return</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>


                    <?php
                    // output data of each row
                    foreach ($books as $book_item) {
                        $book = new Library\Book();
                        $book->setId($book_item->book_id);
                        $book->setName($book_item->book_name);
                        $book->setYear($book_item->book_year);
                        $book->setGenre($book_item->book_genre);
                        $book->setAgeGroup($book_item->book_age_group);
                        $book->setAuthorName($book_item->author_name);
                        $book->setLoanUserId($book_item->loan_user_id);
                        echo "<tr>";
                        echo "<td>" . $book->getName() . "</td>";
                        echo "<td>" . $book->getAuthorName() . "</td>";
                        echo "<td>" . $book->getYear() . "</td>";
                        echo "<td>" . $book->getGenre() . "</td>";
                        echo "<td>" . $book->getAgeGroup() . "</td>";
                        if ($book->getLoanUserId() == -1) echo '<td><a href="loanBook.php?book_id=' . $book->getId() . '">Loan</a></td>'; else echo "<td></td>";
                        if ($book->getLoanUserId() == $userId)
                            echo '<td><a href="returnBook.php?book_id=' . $book->getId() . '">Return</a></td>';
                        elseif  ($book->getLoanUserId() == -1)
                            echo "<td></td>";
                        elseif ($book->getLoanUserId() != $userId) {
                            $userStmt = $pdo->prepare('SELECT email FROM users WHERE id = ?');
                            $userStmt->execute([$book->getLoanUserId()]);
                            $user_item = $userStmt->fetch();
                            $userEmail = $user_item->email;
                            echo "<td>Out: " . $userEmail . "</td>";
                        }
                        echo "<td><a href='editBook.php?book_id=" . $book->getId() . "'>Edit</a></td>";
                        echo "<td><a href='deleteBook.php?book_id=" . $book->getId() . "'>Delete</a></td>";
                        echo "</tr>";
                    }
}
?>
            </table>
        </div>
    </div>

</body>

</html>