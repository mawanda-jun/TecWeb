<?php require_once "dbConnection.php";

$closeConnection = false;
if(!isset($dbConnection))
{
	$dbConnection = new DBAccess();
	$dbConnection->openDBConnection(true);
	$closeConnection = true;
}
if($dbConnection->failedConnection)
{
	echo('<div id="errorarticleside">Problema di connessione al database, impossibile ottenere gli articoli</div>');
}
else
{
	$news = $dbConnection->getListNews(false, 300, 3);
	if($news != null)
	{
		echo '<dl id="articleside">';

		foreach($news as $notizia)
		{
			echo '<dt><a href="article.php?id='.$notizia['id'].'">'.$notizia['title'].'</a></dt>';
			echo '<dd>';
			if(isset($notizia['image']) && strcmp($notizia['image'], "") != 0)
				echo '<img class="newsimageside" src="images/news/'.$notizia['image'].'" alt="'.$notizia['imgdescr'].'"/>';
			echo '<div class="newsdataside">'.strftime('%e %B %Y',strtotime($notizia['data'])).'</div><div class="newstextside">'.$notizia['text'].'</div></dd>';
		}
		echo '</dl>';
	}
	else
		echo '<p id="errorarticleside">Nessun articolo disponibile</p>';

	if(isset($close) && $close == true)
		$dbConnection->closeDBConnection();
}
if($closeConnection)
		$dbConnection->closeDBConnection();
?>
