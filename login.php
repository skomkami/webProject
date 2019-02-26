<?php
session_start();

require_once('login_func.php');

if( isset($_POST['nick']) && isset($_POST['password']) 
	&& !empty($_POST['nick']) && !empty($_POST['password']) ) {

	$nick = filter_input(INPUT_POST, 'nick', FILTER_SANITIZE_STRING);
	$pass = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

	try{
		$dbh = new PDO('mysql:host='.$db_host.';dbname='.$db_name, $db_user, $db_password);
		login_user($dbh, $nick, $pass, 'login_form.php');
		
	    $dbh = null;
	} catch (PDOException $e) {
	    print "Error!: " . $e->getMessage() . "<br/>";
	    die();
	}


	header('Location:blog.php');
}

