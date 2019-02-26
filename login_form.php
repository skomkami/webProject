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
		<title>Zaloguj</title>
		<link rel="stylesheet" type="text/css" href="css/menu.css" media="screen">
		<link rel="stylesheet" type="text/css" href="css/form.css" media="screen">
		<meta http-equiv="Content-Type" content="application/xhtml+xml;charset=UTF-8" />
	</head>
	<body>
		<div id="main">
			<div class="form">
				<?php
					if(isset($_SESSION['account_created'])){
							echo $_SESSION['account_created'];
							unset($_SESSION['account_created']);
						}
				?>
				<form action="login.php" method="post">
					<input type="text" name="nick" placeholder="Użytkownik"><?php
						if(isset($_SESSION['error_nick'])){
							echo "<br/>".$_SESSION['error_nick'];
							unset($_SESSION['error_nick']);
						}
					?><br/>
					<input type="password" name="password" placeholder="Hasło"><?php
						if(isset($_SESSION['error_password'])){
							echo "<br/>".$_SESSION['error_password'];
							unset($_SESSION['error_password']);
						}
					?><br/>			
					<input type="submit" value="Zaloguj"/>

				</form>
				Nie posiadasz jeszcze konta?<br/>
				<a href="account_form.php">Zarejestruj się</a><br/>
				</form>
			</div>
		</div>
	</body>
</html>
