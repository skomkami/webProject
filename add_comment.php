<?php

session_start();

if( isset($_SESSION['entry']) && !empty($_SESSION['entry'])
	&& isset($_SESSION['blog']) && !empty($_SESSION['blog']) ) {

	if( !isset($_POST['commentator']) || empty($_POST['commentator']) ) {
		$_SESSION['commentator_empty']="Podaj imie/nazwisko/pseudonim.<br/>";
		header("Location: comment_form.php");
		exit();
	}

	if( !isset($_POST['comment']) || empty($_POST['comment']) 
		|| strlen($_POST['comment']) < 5 || strlen($_POST['comment']) > 200) {
		$_SESSION['comment_error']="Komentarz może zawierać od 5 do 200 znaków<br/>";
		header("Location: comment_form.php");
		exit();
	}

	require_once 'credentials.php';

	try {
		$dbh = new PDO('mysql:host='.$db_host.';dbname='.$db_name, $db_user, $db_password);

		$add_comment_query = $dbh->prepare("INSERT INTO comments (author, type, content, entry_id) VALUES (:cauthor, :ctype, :ccontent, :centry_id)");

		$add_comment_query->execute([
		    ':cauthor' => filter_input(INPUT_POST, 'commentator', FILTER_SANITIZE_STRING),
		    ':ctype' => filter_input(INPUT_POST, 'comment_type', FILTER_SANITIZE_STRING),
		    ':ccontent' => filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_STRING),
		    ':centry_id' => $_SESSION['entry']
		]);

		$dbh = null;
	} catch (PDOException $e) {
	    print "Error!: " . $e->getMessage() . "<br/>";
	    die();
	}

	header("Location: blog.php?nazwa=".$_SESSION['blog']);

} else {
	echo 'Błąd skryptu';
}
?>
