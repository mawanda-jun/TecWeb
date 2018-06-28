<?php
function imageupload($folder, $file_temp)
{
	$error = '';
	// controllo ci sia il file - potrebbe avere superato il file upload size limit ed essere assente
	if(!isset($file_temp["tmp_name"]) || !file_exists($file_temp["tmp_name"]) || !is_uploaded_file($file_temp["tmp_name"]))
		$error = 'Errore nel trasferimento del file';
	else
	{
		$file_target = $folder.basename($file_temp["name"]);
		$imageFileType = pathinfo($file_target,PATHINFO_EXTENSION);
		// controllo la dimensione
		if ($file_temp["size"] > 5242880) //5Mb
			$error = 'Il file è troppo pesante, non può superare i 5Mb';
		// controllo sia una immagine
		$check = getimagesize($file_temp["tmp_name"]);
		if($check == false)
			$error = 'Il file non è riconoscibile come immagine dal sistema';
		// controllo il nome non sia già usato
		if (file_exists($file_target))
			$error = 'Il file è già presente';

		// controllo non ci siano .. o /
		if (strrpos($file_temp["name"], '..') != FALSE || strrpos($file_temp["name"], '/') != FALSE)
			$error = 'Il nome contiene caratteri non accettati per motivi di sicurezza, come .. o /';
		// permetto determinati formati
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" )
			$error = 'Il formato non è accettato, usare solo jpg, gpeg, png e gif';

		if (strcmp($error, "") == 0)
			if (move_uploaded_file($file_temp["tmp_name"], $file_target))
			{
				return array(
					'text' => $file_temp["name"],
					'result' => true,
				);
			}
			else
				$error = 'errore in fase di upload';
	}
	return array(
		'text' => $error,
		'result' => false,
	);
}
?>

