<?php require_once __DIR__.DIRECTORY_SEPARATOR."dbConnection.php"; ?>
<?php 
	$website = "localhost/tecwebs/";
	 header("Content-Type: application/rss+xml; charset=UTF-8");
?>
<rss xmlns:atom="http://www.w3.org/2005/Atom" version="2.0">
    <channel>
        <title>Touhou Italia RSS</title>
        <description>Touhou Italia RSS - news</description>
		<link>http://<?php echo($website); ?></link>
		<language>it</language>
		<atom:link href="<?php echo($website.'/rss');?>" rel="self" type="application/rss+xml"/>
<?php
	$dbConnection = new DBAccess();
	$dbConnection->openDBConnection();
	$news = $dbConnection->getListNews(false, 500, 50);
	foreach($news as $notizia) 
	{
		echo '<item>';
		echo '	<title>'.$notizia['title'].'</title>';
		echo '	<link>http://'.$website.'/article?id='.$notizia['id'].'</link>';
		echo '	<text>'.$notizia['text'].'</text>';
		echo '	<pubDate>'.date("D, d M Y H:i:s O", strtotime($notizia['data'])).'</pubDate>';
		echo '</item>';
	}
	$dbConnection->closeDBConnection();
	?>
    </channel>
</rss>

