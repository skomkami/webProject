<?php
require_once 'credentials.php';

try {
	$dbh = new PDO('mysql:host='.$db_host.';dbname='.$db_name, $db_user, $db_password);

	$blogs = blogs($dbh);

	echo "<nav id=\"menu\"><ul>";
	echo "<li><a href=\"blog_form.php\">Załóż blog</a></li>";

	if( !isset($_SESSION['logged_user']) )
		echo "<li><a href=\"login_form.php\">Zaloguj się</a></li>";
	else 
		echo "<li>".$_SESSION['logged_user']."[<a href=\"logout.php\">Wyloguj się</a>]</li>";

	echo "<li>Blogi <ul>";
	if(empty($blogs)){
		echo "<li>W naszym serwisie nie ma jeszcze blogów. Bądź pierwszy!</li>";
	} else {
		
		foreach($blogs as $blog)
		{
			echo "<li><a href=\"blog.php?nazwa=".$blog."\">".$blog."</a></li>";
		}
		echo "</ul>";
	}
	echo "</li></ul></nav>";

}catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}

function blogs($dbh) {
	try {
		    
	    $query = $dbh->query("SELECT * FROM blogs")->fetchAll();

		$blogs_list=[];

		foreach ($query as $row)
	    	$blogs_list[] = $row['name'];
		
	    $dbh = null;

	    return $blogs_list;

	} catch (PDOException $e) {
	    print "Error!: " . $e->getMessage() . "<br/>";
	    die();
	}
}

?>