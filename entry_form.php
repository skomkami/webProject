<?php
	session_start();

	require_once 'menu.php';
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="pl">
	<head>
		<title>PHP blog</title>
		<link rel="stylesheet" type="text/css" href="css/menu.css" media="screen">
		<link rel="stylesheet" type="text/css" href="css/form.css" media="screen">
		<meta http-equiv="Content-Type" content="application/xhtml+xml;charset=UTF-8" />
	</head>
	<body>
		<div id="main">
			<div class="form">
				<h1>Dodaj wpis</h1>
				<form action="create_entry.php" method="post" enctype="multipart/form-data">
					<?php
						if( !isset($_SESSION['logged_user']) ) {
							echo "<input type=\"text\" name=\"user\"
							placeholder=\"Użytkownik\"><br/>";
							if( isset($_SESSION['error_user']) ) {
								echo "<br/>".$_SESSION['error_user'];
								unset($_SESSION['error_user']);
							}
							echo "<input type=\"password\" name=\"password\"placeholder=\"Hasło\"><br/>";
							if( isset($_SESSION['error_password']) ) {
								echo "<br/>".$_SESSION['error_password'];
								unset($_SESSION['error_password']);
							}
						}
					?>
					<input type="text" name="title" placeholder="Tytuł"><?php
						if(isset($_SESSION['error_title'])){
							echo "<br/>".$_SESSION['error_title'];
							unset($_SESSION['error_title']);
						}
					?><br/>
					<textarea rows="4" cols="50" name="entry" placeholder="Tresc wpisu..."></textarea><br/>
					<?php
						if(isset($_SESSION['error_entry'])){
							echo "<br/>".$_SESSION['error_entry'];
							unset($_SESSION['error_entry']);
						}
					?>
					<input type="file" onchange="add_file_input(this)" name="file1"/><br/>

					<input type="submit" id="sub" value="Wyślij"/>
					<input type="reset" value="Wyczyść"/>

				</form>
			</div>
		</div>
	</body>

	<script src="js/upload_files.js"></script>
</html>
