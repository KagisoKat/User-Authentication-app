<!-- <?php
session_start();

spl_autoload_register( function($class) {
  $classSplit=explode('\\', $class);
  $path = 'classes/';
  require_once  $path . $classSplit[0] . '/' . $classSplit[1] .'.php';
 });


if(isset($_SESSION['userId'])) {
    session_destroy();
    header('Location: http://localhost/login/index.php');
}

?> -->