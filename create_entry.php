<?php
	
session_start();
require_once 'credentials.php';

if( !isset($_POST['title']) || empty($_POST['title']) 
	|| strlen($_POST['title'])<5 || strlen($_POST['title'])>30) {

	$_SESSION['error_title'] = "Podaj tytuł wpisu od 5 do 30 znaków";
	header('Location: entry_form.php');
	exit(0);
}

if( !isset($_POST['entry']) || empty($_POST['entry']) 
	|| strlen($_POST['entry'])<20 || strlen($_POST['entry'])>2000) {

	$_SESSION['error_entry'] = "Dodaj opis od 20 do 2000 znaków";
	header('Location: entry_form.php');
	exit(0);
}


if( !isset($_SESSION['logged_user']) ) {
	if( !isset($_POST['user']) || empty($_POST['user']) ) {
		$_SESSION['error_user'] = "Podaj nazwę użytkownika";
		header('Location: entry_form.php');
		exit(0);
	}

	if( !isset($_POST['password']) || empty($_POST['password']) ) {
		$_SESSION['error_password'] = "Podaj hasło";
		header('Location: entry_form.php');
		exit(0);
	}


	$user = filter_input(INPUT_POST, 'user', FILTER_SANITIZE_STRING);
	$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
	require_once 'login_func.php';
	try {
		$dbh = new PDO('mysql:host='.$db_host.';dbname='.$db_name, $db_user, $db_password);
		login_user($dbh, $user, $password, 'entry_form.php');

		$dbh = null;
	} catch (PDOException $e) {
	    print "Error!: " . $e->getMessage()."<br/>";
	    die();
	}
}

try {

	$title_sanitized = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
	$content_sanitized = filter_input(INPUT_POST, 'entry', FILTER_SANITIZE_STRING);
	$dbh = new PDO('mysql:host='.$db_host.';dbname='.$db_name, $db_user, $db_password);


	$query_blog_id = $dbh->prepare("SELECT id FROM blogs WHERE name = :name");

	$query_blog_id->bindValue('name', $_SESSION['blog'], PDO::PARAM_STR);
	$query_blog_id->execute();
	$blog_id = $query_blog_id->fetch(PDO::FETCH_ASSOC)['id'];
	

	$query_entry_exists = $dbh->prepare("SELECT * FROM entries WHERE blog_id = :eblog AND title=:etitle");

    $query_entry_exists->bindValue(':eblog', $blog_id, PDO::PARAM_INT);
    $query_entry_exists->bindValue(':etitle', $title_sanitized, PDO::PARAM_STR);
    $query_entry_exists->execute();

    if ($query_entry_exists->rowCount() > 0) {
		$_SESSION['error_title']="W tym blogu istnieje już wpis o takim tytule";
		$dbh = null;
		header("Location:entry_form.php");
		exit(0);
	}


	$date = $dbh->query("SELECT CURRENT_TIMESTAMP()");
	$insert_date = $date->fetch(PDO::FETCH_ASSOC)['CURRENT_TIMESTAMP()'];

	$add_entry_query = $dbh->prepare("INSERT INTO entries 
		(create_date, title, content, blog_id) 
		VALUES(:edate, :etitle, :econtent, :eblog_id)");

	$add_entry_query->execute([
		':edate' => $insert_date,
		':etitle' => $title_sanitized,
		':econtent' => $content_sanitized,
		':eblog_id' => $blog_id
	]);

	$filename = preg_replace("/[-: ]/", "", $insert_date).$dbh->lastInsertId();

	upload_files($_SESSION['blog'], $filename);

	$dbh = null;

	header("Location: blog.php?nazwa=".$_SESSION['blog']);

} catch (PDOException $e) {
    print "Error!: " . $e->getMessage()."<br/>";
    die();
}

function upload_files($blog, $file_name) {

	$semaphore = sem_get(9999, 1, 0666, 1);
	sem_acquire($semaphore);

	if( !is_dir($blog))
		mkdir($blog);

	$uploaded_files_counter = 0;
	
	for($i=1; $i<=count($_FILES); ++$i) {
		$name = $_FILES['file'.$i]['tmp_name'];	
        if( isset($_FILES['file'.$i]) && is_uploaded_file($name) ) {
	        ++$uploaded_files_counter;
	        $path_parts = pathinfo($_FILES["file".$i]["name"]);
			$ext = $path_parts['extension'];
		    move_uploaded_file($name, $blog.'/'.$file_name.$uploaded_files_counter.'.'.$ext);
		}
	}

	sem_release($semaphore);
}

?>
