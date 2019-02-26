<?php
session_start();

if((isset($_POST['user']) && !empty($_POST['user']))) {
	header("Location:blog.php");
	exit(0);
}

require_once 'menu.php';
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="pl">
	<head>
		<title>Rejestracja</title>
		<link rel="stylesheet" type="text/css" href="css/menu.css" media="screen">
		<link rel="stylesheet" type="text/css" href="css/form.css" media="screen">
		<meta http-equiv="Content-Type" content="application/xhtml+xml;charset=UTF-8" />
	</head>
	<body>
		<div id="main">
			<div class="form">
				<form action="create_account.php" method="post">
					<input type="text" name="nick" placeholder="Nazwa użytkownika">
					<?php
						if(isset($_SESSION['error_nick'])){
							echo "<br/>".$_SESSION['error_nick'];
							unset($_SESSION['error_nick']);
						}
					?><br/>
					<input type="password" name="password1" placeholder="Hasło"><br/>
					<input type="password" name="password2" placeholder="Powtórz hasło"><?php
						if(isset($_SESSION['error_password'])){
							echo "<br/>".$_SESSION['error_password'];
							unset($_SESSION['error_password']);
						}
					?><br/>
					<input type="text" name="name" placeholder="Imie i nazwisko">
					<?php
						if(isset($_SESSION['error_name'])){
							echo "<br/>".$_SESSION['error_name'];
							unset($_SESSION['error_name']);
						}
					?><br/>
					<input type="number" name="age" placeholder="Wiek"><?php
						if(isset($_SESSION['error_age'])){
							echo "<br/>".$_SESSION['error_age'];
							unset($_SESSION['error_age']);
						}
					?><br/>
					<input type="email" name="email" placeholder="Email"><?php
						if(isset($_SESSION['error_email'])){
							echo "<br/>".$_SESSION['error_email'];
							unset($_SESSION['error_email']);
						}
					?><br/>
					
					<input type="submit" value="Wyślij"/>
					<input type="reset" value="Wyczyść"/>
				</form>
			</div>
		</div>
		
	</body>
</html>
