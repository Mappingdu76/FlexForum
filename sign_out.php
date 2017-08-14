<?php
require_once 'root.php';
if(isset($_SESSION['id']))
{
    session_destroy();
    header('location:home');
}
else
{
    header('location:home');
}
?>
