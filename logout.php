<?php
session_start();

if( isset($_SESSION['logged_user']) ) {
	unset($_SESSION['logged_user']);
}
if( isset($_SESSION['blog']))
	header('Location:blog.php?nazwa='.$_SESSION['blog']);
else
	header('Location:blog.php');