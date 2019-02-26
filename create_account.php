<?php
session_start();

if( !isset($_POST['nick']) || empty($_POST['nick']) ) {
	$_SESSION['error_nick']="Wpisz nick";
	header("Location:account_form.php");
	exit(0);
}

if( !isset($_POST['password1']) || empty($_POST['password1']) ) {
	$_SESSION['error_password']="Wpisz hasło o długości od 8 do 20 znaków";
	header("Location:account_form.php");
	exit(0);
}

if( strlen($_POST['password1'])<8 || strlen($_POST['password1'])>20 ) {
	$_SESSION['error_password']="Hasło musi posiadać od 8 do 20 znaków";
	header("Location:account_form.php");
	exit(0);
}

if( !isset($_POST['password2']) ) {
	$_SESSION['error_password']="Potwierdz hasło";
	header("Location:account_form.php");
	exit(0);
}

if( $_POST['password1'] != $_POST['password2'] ) {
	$_SESSION['error_password']="Hasła się nie zgadzają";
	header("Location:account_form.php");
	exit(0);
}

if( !isset($_POST['name']) || empty($_POST['name']) || strlen($_POST['name'])>30 ) {
	$_SESSION['error_name']="Podaj imie i nazwisko o maksymalnej łącznej długości 30 znaków";
	header("Location:account_form.php");
	exit(0);
}

if( !isset($_POST['age']) || empty($_POST['age']) ) {
	$_SESSION['error_age']="Podaj wiek";
	header("Location:account_form.php");
	exit(0);
}

if( !isset($_POST['email']) || empty($_POST['email']) || !filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL)) {
	$_SESSION['error_email']="Podaj poprawny email";
	header("Location:account_form.php");
	exit(0);
}

require_once('credentials.php');

try {
    $dbh = new PDO('mysql:host='.$db_host.';dbname='.$db_name, $db_user, $db_password);
    
    $query = $dbh->prepare("SELECT * FROM users WHERE nick = :fnick");
   	$nick = filter_input(INPUT_POST, 'nick', FILTER_SANITIZE_STRING);

    $query->bindValue(':fnick', $nick, PDO::PARAM_STR);
    $query->execute();

    if ($query->rowCount() > 0) {
		$_SESSION['error_nick']="Nick zajęty";
		$dbh = null;
		header("Location:account_form.php");
		exit(0);
	}

	$statement = $dbh->prepare('INSERT INTO users (nick, password, name, age, email) VALUES (:nick, :password, :name, :age, :email)');

	$statement->execute([
	    'nick' => $nick,
	    'password' => password_hash(filter_input(INPUT_POST, 'password2', FILTER_SANITIZE_STRING), PASSWORD_DEFAULT),
	    'name' => filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING),
	    'age' => filter_input(INPUT_POST, 'age', FILTER_SANITIZE_NUMBER_INT),
	    'email' => $_POST['email']
	]);

    $dbh = null;
	$_SESSION['account_created']="Udało się utworzyć konto. Możesz się teraz na nie zalogować";
	header("Location:login_form.php");

} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}