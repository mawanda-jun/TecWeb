<?php
function uploadImage($fileName, $tmpFileName, $fileSize)
{
	$target_dir = "../../images/";
	$target_file = $target_dir . basename($fileName);
	$uploadOk = 1;
	$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
	$error = null;
	$ok = null;

	// $_SESSION['fileName'] = (basename($fileName) ? basename($fileName) : "niente");
	// $_SESSION['file'] = ($fileName ? $fileName : "niente");

// Check if image file is a actual image or fake image

	// $check = getimagesize($tmpFileName);
	// if ($check == true) {
	// 	$error = "Il file non &egrave; un'immagine.";
	// 	$uploadOk = 0;
	// }
	
// Check if file already exists
	if (file_exists($target_file)) {
		$_SESSION['already'] = true;
		$error = "L'immagine esiste gi&agrave;. Per favore cambia l'immagine.";
		$uploadOk = 0;
	}
// Check file size
	if ($fileSize > 500000) {
		$error = "L'immagine supera la dimensione consentita";
		$uploadOk = 0;
	}
// Allow certain file formats
	if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
		&& $imageFileType != "gif") {
		$error = "Attenzione: solamente le estensioni JPG, JPEG, PNG e GIF sono consentite.";
		$uploadOk = 0;
	}
	// check if the file upladed contains some char not accepted for security
	if (strrpos(basename($fileName), '..') != false || strrpos(basename($fileName), '/') != false)
		$error = 'Il nome contiene caratteri non accettati per motivi di sicurezza, come .. o /';

// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 1) {
		if (move_uploaded_file($tmpFileName, $target_file)) {
			$ok = "Il file " . basename($fileName) . " &grave; stato caricato.";
		}
	}
	return array(
		'error' => $error,
		'ok' => $ok
	);
}

// function imageupload($folder, $file_temp)
// {
// 	$error = '';
// 	// controllo ci sia il file - potrebbe avere superato il file upload size limit ed essere assente
// 	if(!isset($file_temp["tmp_name"]) || !file_exists($file_temp["tmp_name"]) || !is_uploaded_file($file_temp["tmp_name"]))
// 		$error = 'Errore nel trasferimento del file';
// 	else
// 	{
// 		$file_target = $folder.basename($file_temp["name"]);
// 		$imageFileType = pathinfo($file_target,PATHINFO_EXTENSION);
// 		// controllo la dimensione
// 		if ($file_temp["size"] > 5242880) //5Mb
// 			$error = 'Il file è troppo pesante, non può superare i 5Mb';
// 		// controllo sia una immagine
// 		$check = getimagesize($file_temp["tmp_name"]);
// 		if($check == false)
// 			$error = 'Il file non è riconoscibile come immagine dal sistema';
// 		// controllo il nome non sia già usato
// 		if (file_exists($file_target))
// 			$error = 'Il file è già presente';

// 		// controllo non ci siano .. o /
// 		if (strrpos($file_temp["name"], '..') != FALSE || strrpos($file_temp["name"], '/') != FALSE)
// 			$error = 'Il nome contiene caratteri non accettati per motivi di sicurezza, come .. o /';
// 		// permetto determinati formati
// 		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" )
// 			$error = 'Il formato non è accettato, usare solo jpg, gpeg, png e gif';

// 		if (strcmp($error, "") == 0)
// 			if (move_uploaded_file($file_temp["tmp_name"], $file_target))
// 			{
// 				return array(
// 					'text' => $file_temp["name"],
// 					'result' => true,
// 				);
// 			}
// 			else
// 				$error = 'errore in fase di upload';
// 	}
// 	return array(
// 		'text' => $error,
// 		'result' => false,
// 	);
// }
?>
