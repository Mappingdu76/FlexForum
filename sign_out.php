<?php
require_once 'root.php';
if(isset($_SESSION['id']))
{
    session_destroy();
    header('location:index.php');
}
else
{
    header('location:index.php');
}
?>
