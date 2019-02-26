<?php
session_start();

if((isset($_POST['entry']) && !empty($_POST['entry']))) {
	$_SESSION['entry'] = $_POST['entry'];
} else {
	echo "Blad skryptu. Brak informacji o wpisie do ktorego utworzyc komentarz";
}

require_once 'menu.php';

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="pl">
	<head>
		<title>Dodaj komentarz</title>
		<link rel="stylesheet" type="text/css" href="css/menu.css" media="screen">
		<link rel="stylesheet" type="text/css" href="css/form.css" media="screen">
		<meta http-equiv="Content-Type" content="application/xhtml+xml;charset=UTF-8" />
	</head>
	<body>
		<div id="main">
			<div class="form">
				<form action="add_comment.php" method="post">
					<h1>Dodaj komentarz</h1>
					Rodzaj komentarza:
					<select name="comment_type">
					  <option value="pozytywny">pozytywny</option>
					  <option value="negatywny">negatywny</option>
					  <option value="neutralny">neutralny</option>
					</select><br/>
					 <textarea rows="4" cols="50" name="comment" placeholder="Twoj komentarz..."></textarea><?php
						if(isset($_SESSION['comment_error'])){
							echo "<br/>".$_SESSION['comment_error'];
							unset($_SESSION['comment_error']);
						}
					?><br/>
					<input type="text" name="commentator" placeholder="Imie/Nazwisko/Pseudonim"><br/>
					<?php
						if(isset($_SESSION['commentator_empty'])){
							echo "<br/>".$_SESSION['commentator_empty'];
							unset($_SESSION['commentator_empty']);
						}
					?>
					<input type="submit" value="Wyślij"/>
					<input type="reset" value="Wyczyść"/>

				</form>
			</div>
		</div>
	</body>
</html>
