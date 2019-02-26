<?php

session_start();

if( !isset($_POST['blog_name']) || empty($_POST['blog_name']) 
	|| strlen($_POST['blog_name'])<5 || strlen($_POST['blog_name'])>20 ) {

	$_SESSION['error_blog_name'] = "Podaj nazwę bloga od 5 do 20 znaków";
	header('Location: blog_form.php');
	exit(0);
}

if( !isset($_POST['description']) || empty($_POST['description']) 
	|| strlen($_POST['description'])<20 || strlen($_POST['description'])>2000) {

	$_SESSION['error_description'] = "Dodaj opis od 20 do 2000 znaków";
	header('Location: blog_form.php');
	exit(0);
}

if( !isset($_SESSION['logged_user']) ) {
	if( !isset($_POST['user']) || empty($_POST['user']) ) {
		$_SESSION['error_nick'] = "Podaj nazwę użytkownika";
		header('Location: blog_form.php');
		exit(0);
	}

	if( !isset($_POST['password']) || empty($_POST['password']) ) {
		$_SESSION['error_password'] = "Podaj hasło";
		header('Location: blog_form.php');
		exit(0);
	}

	require_once('login_func.php');

	$user = filter_input(INPUT_POST, 'user', FILTER_SANITIZE_STRING);
	$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
	try {
		$dbh = new PDO('mysql:host='.$db_host.';dbname='.$db_name, $db_user, $db_password);
		login_user($dbh, $user, $password, 'blog_form.php');
		$dbh = null;
	} catch (PDOException $e) {
	    print "Error!: " . $e->getMessage() . "<br/>";
	    die();
	}
}

$blog_name = filter_input(INPUT_POST, 'blog_name', FILTER_SANITIZE_STRING);
$description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);

require_once('credentials.php');

try {
    $dbh = new PDO('mysql:host='.$db_host.';dbname='.$db_name, $db_user, $db_password);

    $query_check_exists = $dbh->prepare("SELECT * FROM blogs WHERE name = :bname");
   	$blog_name = filter_input(INPUT_POST, 'blog_name', FILTER_SANITIZE_STRING);

    $query_check_exists->bindValue(':bname', $blog_name, PDO::PARAM_STR);
    $query_check_exists->execute();

    if ($query_check_exists->rowCount() > 0) {
		$_SESSION['error_blog_name']="Blog o podanej nazwie już istnieje w serwisie. Wybierz inną nazwę";
		$dbh = null;
		header("Location:blog_form.php");
		exit(0);
	}
    
    $query = $dbh->prepare("SELECT * FROM users WHERE nick = :fnick");
    $query->bindValue(':fnick', $_SESSION['logged_user'], PDO::PARAM_STR);
    $query->execute();

    if ( $query->rowCount() < 1 ) {
		$dbh = null;
		die("Coś poszło nie tak");
	}

	$user_id = $query->fetch(PDO::FETCH_ASSOC)['id'];

	$add_blog_query = $dbh->prepare( "INSERT INTO blogs(name, description, owner) VALUES (:bname, :bdescription, :bowner)" );

	if(!$add_blog_query->execute([
	    'bname' => $blog_name,
	    'bdescription' => $description,
	    'bowner' => $user_id
		])) {

		echo "Nie udało się dodać blogu do bazy. Skontaktuj się z administratorem";	
		exit(0);
	}

    $dbh = null;

    header('Location:blog.php?name='.$blog_name);

} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}

?>
