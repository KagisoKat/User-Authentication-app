<!-- <?php
session_start();

spl_autoload_register( function($class) {
  $path = 'classes/';
  require_once  $path . $class .'.php';
 });

if(isset($_SESSION['userId'])) {
    session_destroy();
    header('Location: http://localhost/login/index.php');
}

?> -->