<?php
require_once('credentials.php');

function login_user($dbh, $nick, $pass, $relocation) {

	try {
	    
	    $query = $dbh->prepare("SELECT * FROM users WHERE nick = :fnick");
	    $query->bindValue(':fnick', $nick, PDO::PARAM_STR);
	    $query->execute();

	    if ( $query->rowCount() < 1 ) {
			$_SESSION['error_nick']="W tym serwisie nie ma konta o podanym nicku";
			$dbh = null;
			header("Location:".$relocation);
			exit(0);
		}

    	$result = $query->fetch(PDO::FETCH_ASSOC);

		if( !password_verify($pass, $result['password'])) {
			$_SESSION['error_password']="Niepoprawne hasło";
			$dbh = null;
			header("Location:".$relocation);
			exit(0);
		}

		$_SESSION['logged_user'] = $nick;

	} catch (PDOException $e) {
	    print "Error!: " . $e->getMessage() . "<br/>";
	    die();
	}
}