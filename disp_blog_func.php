<?php

function display_blog($dbh, $blog_name) {
		
	blog_info($blog_name, $dbh);

	$query_blog_id = $dbh->prepare("SELECT id FROM blogs WHERE name = :name");

	$query_blog_id->bindValue('name', $_SESSION['blog'], PDO::PARAM_STR);
	$query_blog_id->execute();
	$blog_id = $query_blog_id->fetch(PDO::FETCH_ASSOC)['id'];

	$query_entries = $dbh->prepare("SELECT * FROM entries WHERE blog_id = :eblog_id");
	$query_entries->bindValue('eblog_id', $blog_id, PDO::PARAM_INT);
	$query_entries->execute();
	$entries = $query_entries->fetchAll();
	
	foreach( $entries as $entry) {
		echo "<section><div class=\"content\">";
		echo "<h3>".$entry['title']."</h3>";
		echo "<p>Data: ".$entry['create_date'];
		echo "<p>".$entry['content'];

		$entry_path = $_SESSION['blog']."/".
			preg_replace("/[-: ]/", "", $entry['create_date']).$entry['id'];

		read_attachments($entry_path);

		read_comments($dbh, $entry['id']);

		$entry_id = $entry['id'];

echo <<<EOL
<form action="comment_form.php" method="post">
<input type="hidden" name="entry" value="$entry_id">
<input type="submit" value="Dodaj komentarz">
</form>
EOL;
		echo "</div></section><hr>";
	}

}

function display_welcome_page() {

echo <<<EOL
<div id="welcome">
<div class="content">
	<h1>Witamy w naszym serwisie</h3>
	<p>Cieszymy się, że postanowiłeś odwiedzić naszą witrynę. Donec mattis condimentum mauris non sodales. Suspendisse eu ultricies nulla, pulvinar cursus nisi. Sed non efficitur nisl, a luctus odio. In hac habitasse platea dictumst. Nulla luctus ut ante ut scelerisque. Duis quis nisl a orci iaculis mattis. Ut quis arcu eget felis consequat suscipit ut eget nunc. Pellentesque efficitur augue lectus, in rhoncus urna euismod a. In hac habitasse platea dictumst. Proin feugiat id turpis at congue. Fusce ut egestas felis.</p> 
</div>
EOL;

}

function blog_info($blog_name, $dbh) {

	try{

		$query_blog = $dbh->prepare("SELECT * FROM blogs WHERE name = :blog_name");
		$query_blog->bindValue(':blog_name', $blog_name, PDO::PARAM_STR);
		$query_blog->execute();
		$blog_info = $query_blog->fetch(PDO::FETCH_ASSOC);

		$query_user = $dbh->prepare("SELECT * FROM users WHERE id = :bowner");
		$query_user->bindValue(':bowner', $blog_info['owner'], PDO::PARAM_INT);
		$query_user->execute();

	} catch (PDOException $e) {
	    print "Error!: " . $e->getMessage() . "<br/>";
	    die();
	}
	
	echo "<div id=\"blog-info\">";
	$author = $query_user->fetch(PDO::FETCH_ASSOC)['name'];
	$desc = $blog_info['description'];

	echo "<div class=\"content\">";
	echo "<h1>$blog_name</h1>";
	echo "<h3>Autor: $author</h3>";
	echo "<p>Opis: $desc</p></div>";

	echo "<div class=\"right-down\"><a href=\"entry_form.php\"><h2>Dodaj wpis</h2></a></div>";

	echo "</div>";
}


function read_attachments($path) {
	$attachments = glob($path.'*.*');
	$i=0;
	foreach($attachments as $attachment) {
		if(preg_match('/^([\d]+)\.([^k\.]+)$/', preg_split('/\//', $attachment)[1])) {
			++$i;
			if($i==1)
				echo "<h4>Załączniki: </h4>";

			echo "<a href=\"".$attachment."\">".preg_split('/\//', $attachment)[1]."</a><br/>";
		}

	}
	echo "<br/>";
}

function read_comments($dbh, $entry_id) {
	$comments = $dbh->query("SELECT * FROM comments WHERE entry_id =".$entry_id)->fetchAll();

	if(!empty($comments))
		echo "<div class=\"comments\"><h3>Komentarze</h3>";

	foreach($comments as $comment) {
		echo "<p>Rodzaj: ".$comment['type']."<br/>";
		echo "Nick: ".$comment['author']."<br/>";
		echo $comment['content']."</p>";
	}

	if(!empty($comments))
		echo "</div>";
}