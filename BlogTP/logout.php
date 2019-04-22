<?php 
//author : Younes zaidi
session_start();
session_destroy();
header('Location: /BlogTp/index.php');
exit;
?>