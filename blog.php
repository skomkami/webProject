 <?php
 session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="pl-PL">
	<head>
		<title>Lab PHP form</title>
		<link rel="stylesheet" type="text/css" href="css/main.css" media="screen">
		<link rel="stylesheet" type="text/css" href="css/menu.css" media="screen">
		<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700&amp;subset=latin-ext" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="css/comm.css" media="screen">
		<meta charset="UTF-8">
		<meta http-equiv="Content-Type" content="application/xhtml+xml;charset=UTF-8" />
	</head>
<body>

	<?php
	require_once 'menu.php';
	require_once 'disp_blog_func.php';

	try {
		$dbh = new PDO('mysql:host='.$db_host.';dbname='.$db_name, $db_user, $db_password);

		$blogs_list = blogs($dbh);

		if(isset($_GET['nazwa'])){

			$name = $_GET['nazwa'];
			$exists = false;
			foreach($blogs_list as $blog)
			{
				if($blog === $name)
					$exists = true;
			}

			if($exists) {
				$_SESSION['blog'] = $name;
				display_blog($dbh, $name);
			} else {
				echo 'Blog o podanej nazwie nie istnieje!<br/>';
			}

		} else {
			display_welcome_page();
		}

		$dbh = null;
	} catch (PDOException $e) {
	    print "Error!: " . $e->getMessage() . "<br/>";
	    die();
	}

	?>
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/1.18.2/TweenMax.min.js"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/ScrollMagic/2.0.5/ScrollMagic.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/ScrollMagic/2.0.5/plugins/animation.gsap.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/ScrollMagic/2.0.5/plugins/debug.addIndicators.min.js"></script>
<script src="js/main.js"></script>
</html>
