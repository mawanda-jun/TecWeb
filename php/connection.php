<?php
setlocale(LC_TIME, "it_IT");

class DBConnection {

	const host = 'localhost';
	const user = 'root';
	const pwd = '';
	const db = 'azienda';
	/*public $connectionErrorPage = ''; DA DEFINIRE UNA PAGINA DI ERRORE PER IL DB */

	public $connectionOpen = false;
	public $failedConnection = false;
	private $connection;

	/* Apre una connessione con il db con le variabili impostate precedentemente */
	public function openConnection() {
		if($this->failedConnection)
			return false;
		$this->connection = @mysqli_connect(static::host, static::user, static::pwd, static::db);
		if(!$this->connection)
		{
			$this->failedConnection = true;
			$this->showError();
			return false;
		}
		$this->connectionOpen = true;
		return true;
	}

	private function showError() {
		header('Location: /'.$this->connectionErrorPage);
		exit();
	}

	private function getAllQuery($query) {
		$result = mysqli_query($this->connection, $query) or $this->showError();
		return mysqli_fetch_all($result, MYSQLI_ASSOC);
	}
	
	private function getAssArrayQuery($query)	{
		return mysqli_fetch_assoc(mysqli_query($this->connection, $query));
	}
  
  // Utilizzato per prevenire SQL
	private function escape($string) {
		return mysqli_real_escape_string($this->connection, $string);
	}

	public function adminLogin($username, $password) {
		$query = 'SELECT pwd FROM users WHERE '.
			'username = "'.$this->escape($username).'"';
		$result = mysqli_query($this->connection, $query) or $this->showError();
		$dataDB = mysqli_fetch_row($result);
		return password_verify($password, $dataDB[0]);
	}
	
	// Rimuove l'amministratore indicato sse questo non è l'unico rimasto. Ritorna true se l'eliminazione è andata a buon fine, false altrimenti
	public function removeAdmin($username) {
		if(mysqli_num_rows(mysqli_query($this->connection, 'SELECT * FROM users')) > 1) {
			$query = 'DELETE FROM users WHERE username = "'.$this->escape($username).'"';
			return mysqli_query($this->connection, $query) == 1;
		}
		return false;
	}
	
	// Inserisce un nuovo admin con i dati indicati. Ritorna true se l'inserimento è andato a buon fine, false altrimenti
	public function insertAdmin($username, $email, $password) {
		$query = 'SELECT * FROM users WHERE username= "'.$this->escape($username).'"';
		if(mysqli_num_rows(mysqli_query($this->connection, $query)) == 0)
		{
			$insert = 'INSERT INTO users (username, email, pwd) VALUES ("'.
				$this->escape($username).'", "'.
				$this->escape($email).'", "'.
				$this->escape(password_hash($password, PASSWORD_DEFAULT)).'")';
			return mysqli_query($this->connection, $insert) == 1;
		}
		return false;
	}
          
  public function getListGrains() {
    return $this->getAllQuery('SELECT * FROM grani');
  }

  public function getListMachinery() {
    return $this->getAllQuery('SELECT * FROM macchinari ORDER BY codice');
  }

  public function getGrain($name) {
		return $this->getAssArrayQuery('SELECT * FROM grani WHERE nome ='.$this->escape($name));
  }

  public function getMachine($id) {
		return $this->getAssArrayQuery('SELECT * FROM macchinari WHERE codice ='.$this->escape($id));
  }

  public function getListAdmins() {
		return $this->getAllQuery('SELECT username, email FROM users');
  }
  
  public function getListClients() {
		return $this->getAllQuery('SELECT * FROM clienti');
  }

  public function getClient($id) {
		return $this->getAssArrayQuery('SELECT * FROM clienti WHERE codice ='.$this->escape($id));
  }

  public function getPrenotationClient($order) {
    $query = 'SELECT idCliente FROM prenotazioni WHERE ordine ='.$this->escape($order);
    return($days * mysqli_fetch_row(mysqli_query($this->connection, $query))[0]);
  }

  // da spostare dove serve realmente
  public function getMachinePrice($id, $days) {
    $dayPrice = 'SELECT prezzoGiorno FROM macchinari WHERE codice ='.$this->escape($id);
    return($days * mysqli_fetch_row(mysqli_query($this->connection, $query))[0]);
  }

  public function insertClient($id, $name, $surname, $phone, $email) {
		$query = 'INSERT INTO clienti (id, nome, cognome, telefono, email) VALUES ("'.
      $this->escape($id).'", "'.
      $this->escape($name).'", "'.
      $this->escape($surname).'", "'.
      $this->escape($phone).'", "'.
      $this->escape($email).'", "';
		return mysqli_query($this->connection, $query);
  }
  
  public function insertGrain($name, $description, $image, $price, $availability) {
		$query = 'INSERT INTO grani (nome, descrizione, immagine, prezzo, disponibilità) VALUES ("'.
      $this->escape($name).'", "'.
      $this->escape($description).'", "'.
			$this->escape($image).'", "'.
      $this->escape($price).'", "'.
      $this->escape($availability).'", "';
		return mysqli_query($this->connection, $query);
  }

  public function insertMachine($id, $name, $model, $image, $dayPrice) {
		$query = 'INSERT INTO macchinari (codice, nome, modello, immagine, prezzoGiorno) VALUES ("'.
      $this->escape($id).'", "'.
      $this->escape($name).'", "'.
      $this->escape($model).'", "'.
			$this->escape($image).'", "'.
      $this->escape($dayPrice).'", "';
		return mysqli_query($this->connection, $query);
  }

  // serve un controllo sulla disponibilità alla prenotazione del macchinario
  public function insertPrenotation($order, $clientId, $machineId, $firstDay, $lastDay) {
		$query = 'INSERT INTO prenotazioni (ordine, idCliente, idMacchinario, dataInizio, dataFine) VALUES ("'.
      $this->escape($order).'", "'.
      $this->escape($clientId).'", "'.
      $this->escape($machineId).'", "'.
      $this->escape($firstDay).'", "'.
      $this->escape($lastDay).'", "';
		return mysqli_query($this->connection, $query);
  }

	/* 

	public function getListNews($withHidden = false, $charLimit = false, $entryLimit = false, $fromEntry = false ) {
		$query = 'Select id, title, image, imgdescr, data, hidden, ';
	   	if($charLimit != false)
			$query.= ' CONCAT(SUBSTRING(text, 1, 300), "...") as text ';
		else
			$query.= ' text ';
		$query.= ' from news ';
	   	if(!$withHidden)
			$query.= 'where hidden = false ';
		$query.= ' ORDER BY data desc ';
		if($entryLimit != false && $fromEntry == false) //prendo i primi TOT		
			$query.= ' LIMIT '.$this->escape($entryLimit);
		if($entryLimit != false && $fromEntry != false) //prendo da TOT per TOT		
			$query.= ' LIMIT '.$this->escape($fromEntry).', '.$this->escape($entryLimit);
		return $this->getAllQuery($query);
	}

	//ritorna username e email di tutti gli utenti tranne quelli esclusi
	public function getListAdminsData($excludeAdmin) {
		$query = 'SELECT username, email FROM admins WHERE '.'username <> "'.$this->escape($excludeAdmin).'"';
		return $this->getAllQuery($query);
	}

	//Ritorna l'email dell'amministratore passato
	public function getAdminEmail($admin) {
  		$query = 'SELECT email FROM admins WHERE username = "'.$this->escape($admin).'"';
  		return mysqli_fetch_row(mysqli_query($this->connection, $query))[0];
	}

	//data una nuova email e una password, l'email viene aggiornata e la password viene modificata solamente se non vuota, ritorna true se non ci sono stati problemi
	public function changeAdminData($admin, $newEmail, $newPassword) {
		if($admin!=null && $newEmail!=null && $newEmail!=null) {
			$query = 'UPDATE admins SET ';
			if(strcmp($newEmail, '') != 0)
				$query.= 'email = "'.$this->escape($newEmail).'"';
			if(strcmp($newPassword, '') != 0)
				$query.=', password = "'.$this->escape(password_hash($newPassword, PASSWORD_DEFAULT)).'"';
			$query.=' WHERE username = "'.$this->escape($admin).'"';
		//	die($query);
			return mysqli_query($this->connection, $query) == 1;
		}
				 
	}

	public function getListComments($idNews, $limit=false, $reverseOrder=false) {
		$query = 'Select * from comment';
		if($idNews != null)
			$query .= ' where news_id = '.$this->escape($idNews);
		if($limit != false)
			$query.= ' order by data asc';
		else
			$query.= ' order by data desc';
		if($limit != false)
			$query.= ' limit '.$limit;
		return $this->getAllQuery($query);
	}

	public function getListBan() {
		return $this->getAllQuery('Select * from ban order by date desc');
	}

	public function getNumberNews($withHidden = false) {
		$query = 'Select * from news ';
	   	if(!$withHidden)
			$query.= 'where hidden = false';
		$result = mysqli_query($this->connection, $query) or $this->showError();
		return mysqli_num_rows($result);
	}
	
	public function getIpFromComment($idpost) {
		$query = 'SELECT ip FROM comment where id = '.
			$this->escape($idpost);
		$result = $this->getAssArrayQuery($query) or $this->showError();
		return $result['ip'];
	}


	public function getArticle($id) {
		return $this->getAssArrayQuery('Select * from news where id='.$this->escape($id));
	}
	
	public function removeBan($id) {
		$query = 'delete from ban where ip="'.$this->escape($id).'"';
		return mysqli_query($this->connection, $query) or $this->showError();
	}
	public function removeChapter($id) {
		$query = 'delete from chapters where id='.$this->escape($id);
		return mysqli_query($this->connection, $query) == 1;
	}
	public function removeNews($id) {
		$query = 'delete from news where id='.$this->escape($id);
		return mysqli_query($this->connection, $query) == 1;
	}
	public function removeComment($id) {
		$query = 'delete from comment where id='.$this->escape($id);
		return mysqli_query($this->connection, $query) == 1;
	}

	public function insertComment($name, $email, $message, $id, $ip) {
		$query = 'INSERT INTO comment (nick, email, message, news_id, ip) VALUES (\''.
			htmlentities($this->escape($name)).'\',\''.
			htmlentities($this->escape($email)).'\',\''.
			htmlentities($this->escape($message)).'\','.
			$this->escape($id).', "'.
			$this->escape($ip).'")';
		return mysqli_query($this->connection, $query) == 1;
	}

	public function insertChapter($number, $year, $title, $image, $imagedescr, $titleeng, $titleita, $plot) {
		$query = 'INSERT INTO chapters (number, year, title, image, imagedescr, titleeng, titleita, plot) VALUES ("'.
			$this->escape($number).'", "'.
			$this->escape($year).'", "'.
			$this->escape($title).'", "'.
			$image.'", "'.
			$imagedescr.'", "'.
			$this->escape($titleeng).'", "'.
			$this->escape($titleita).'", "'.
			$this->escape($plot).'")';
		return mysqli_query($this->connection, $query);
	}

	public function insertNews($title, $image, $hidden, $text, $imgdescr) {
		$query = 'INSERT INTO news (title, image, hidden, text, imgdescr) VALUES ("'.
			$this->escape($title).'", "'.
			$image.'", '.
			$hidden.', "'.
			html_entity_decode($this->escape($text)).'", "'.
			$this->escape($imgdescr).'")';
		return mysqli_query($this->connection, $query) == 1;
	}

	public function insertBan($ip, $reason) {
		$query = 'INSERT INTO ban (ip, motivo) VALUES (\''.
			$this->escape($ip).'\', \''.
			$this->escape($reason).'\')';
		return mysqli_query($this->connection, $query) == 1;
	}

	public function updateNewsVisibility($id, $hidden) {
		if($hidden == true)
			$hiddenbinary = 1;
		else
			$hiddenbinary = 0;
		$query = 'UPDATE news SET hidden='.
			$hiddenbinary.' WHERE id='.
			$this->escape($id);
		return mysqli_query($this->connection, $query) == 1;
	}

	public function updateNews($title, $image, $hidden, $text, $imgdescr, $id) {
		$query = 'UPDATE news set title="'.
			$title.'", image="'.
			$image.'", hidden="'.
			$hidden.'", imgdescr ="'.
			$this->escape($imgdescr).'", text="'.
			html_entity_decode($this->escape($text)).'" WHERE id='.
			$this->escape($id);
		return mysqli_query($this->connection, $query) == 1;
	}

	public function checkBannedIp($ip) {
		return (mysqli_query($this->connection, 'SELECT * FROM ban WHERE ip = '.$this->escape($ip)) >= 1);
	}
	*/

	public function closeConnection() {
		if($this->connectionOpen)
			mysqli_close($this->connection);
		$this->connectionOpen = false;
	}
}

?>
