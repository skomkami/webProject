<?php
	session_start();
	require_once 'menu.php';
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="pl-PL">
	<head>
		<title>Utwórz blog</title>
		<link rel="stylesheet" type="text/css" href="css/form.css" media="screen">
		<link rel="stylesheet" type="text/css" href="css/menu.css" media="screen">
		<!-- <link rel="stylesheet" type="text/css" href="css/comm.css" media="screen"> -->
		<meta charset="UTF-8">
		<meta http-equiv="Content-Type" content="application/xhtml+xml;charset=UTF-8" />
	</head>
	<body>
		<div id="main">
			<div class="form">
				<h1>Załóż bloga:</h1>
				<form action="create_blog.php" method="post">
					<?php
						if( !isset($_SESSION['logged_user']) ) {
							echo "<input type=\"text\" placeholder=\"Użytkownik\" name=\"user\"/><br/>";
							if( isset($_SESSION['error_user']) ) {
								echo "<br/>".$_SESSION['error_user'];
								unset($_SESSION['error_user']);
							}
							echo "<input type=\"password\" placeholder=\"Hasło\" name=\"password\"/><br/>";
							if( isset($_SESSION['error_password']) ) {
								echo "<br/>".$_SESSION['error_password'];
								unset($_SESSION['error_password']);
							}
						}
					?>
					<input type="text" placeholder="Nazwa blogu" name="blog_name"/><?php
						if( isset($_SESSION['error_blog_name']) ) {
							echo "<br/>".$_SESSION['error_blog_name'];
							unset($_SESSION['error_blog_name']);
						}
					?><br/>
					
					 <textarea rows="4" cols="50" name="description" placeholder="Opis blogu..."></textarea> <br/>
					 <?php
						if( isset($_SESSION['error_description']) ) {
							echo "<br/>".$_SESSION['error_description'];
							unset($_SESSION['error_description']);
						}
					?>
					<input type="submit" value="Wyślij"/>
					<input type="reset" value="Wyczyść"/>

				</form>
			</div>
		</div>
		<!-- <div id="communicator">
			<form>
				Active: <input type="checkbox" id="active_box"><br>
				<textarea id="messages_field" disabled></textarea><br>
				Nick:  <input type="text" id="nick_field"><br>

				<textarea id="message_field">Wpisz wiadomość..</textarea><br>
				<button type="button" onclick="send()">Wyślij</button>
			</form>
		</div> -->
	</body>
	<!-- <script src="js/communicator.js"></script> -->
</html>
