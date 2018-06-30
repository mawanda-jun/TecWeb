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

	public function adminLogin($email, $password) {
		$query = 'SELECT pwd FROM users WHERE '.
			'email = "'.$this->escape($email).'"';
		$result = mysqli_query($this->connection, $query) or $this->showError();
		$dataDB = mysqli_fetch_row($result);
		return password_verify($password, $dataDB[0]);
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
    return(mysqli_fetch_row(mysqli_query($this->connection, $query))[0]);
  }

  public function getMachinePrice($id) {
    $dayPrice = 'SELECT prezzoGiorno FROM macchinari WHERE codice ='.$this->escape($id);
    return(mysqli_fetch_row(mysqli_query($this->connection, $query))[0]);
  }

  public function insertAdmin($email, $password) {
		$insert = 'INSERT INTO users (email, pwd) VALUES ("'.
      $this->escape($email).'", "'.
      $this->escape(password_hash($password, PASSWORD_DEFAULT)).'")';
  }
  
  public function insertClient($id, $name, $surname, $phone, $email) {
    $insert = 'INSERT INTO clienti (id, nome, cognome, telefono, email) VALUES ("'.
      $this->escape($id).'", "'.
      $this->escape($name).'", "'.
      $this->escape($surname).'", "'.
      $this->escape($phone).'", "'.
      $this->escape($email).'")';
    return mysqli_query($this->connection, $insert);
  }
  
  public function insertGrain($name, $description, $image, $price, $availability) {
		$insert = 'INSERT INTO grani (nome, descrizione, immagine, prezzo, disponibilità) VALUES ("'.
      $this->escape($name).'", "'.
      $this->escape($description).'", "'.
			$this->escape($image).'", "'.
      $this->escape($price).'", "'.
      $this->escape($availability).'")';
		return mysqli_query($this->connection, $insert);
  }

  public function insertMachine($id, $type, $name, $model, $power, $year, $image, $dayPrice) {
		$insert = 'INSERT INTO macchinari (codice, tipologia, nome, modello, potenzaKW, anno, immagine, prezzoGiorno) VALUES ("'.
      $this->escape($id).'", "'.
      $this->escape($type).'", "'.
      $this->escape($name).'", "'.
      $this->escape($model).'", "'.
      $this->escape($power).'", "'.
      $this->escape($year).'", "'.
			$this->escape($image).'", "'.
      $this->escape($dayPrice).'")';
		return mysqli_query($this->connection, $insert);
  }

  // serve un controllo sulla disponibilità alla prenotazione del macchinario
  public function insertPrenotation($clientId, $machineId, $firstDay, $lastDay) {
		$insert = 'INSERT INTO prenotazioni (idCliente, idMacchinario, dataInizio, dataFine) VALUES ("'.
      $this->escape($clientId).'", "'.
      $this->escape($machineId).'", "'.
      $this->escape($firstDay).'", "'.
      $this->escape($lastDay).'")';
		return mysqli_query($this->connection, $insert);
  }

  public function removeGrain($name) {
		$query = 'DELETE FROM grani WHERE nome='.$this->escape($name);
		return mysqli_query($this->connection, $query) === TRUE;
	}

  public function removeMachine($id) {
		$query = 'DELETE FROM macchinari WHERE codice='.$this->escape($id);
		return mysqli_query($this->connection, $query) === TRUE;
  }
  
  public function removeClient($id) {
		$query = 'DELETE FROM clienti WHERE id='.$this->escape($id);
		return mysqli_query($this->connection, $query) === TRUE;
	}

  // Rimuove l'amministratore indicato sse questo non è l'unico rimasto. Ritorna true se l'eliminazione è andata a buon fine, false altrimenti
	public function removeAdmin($email) {
		if(mysqli_num_rows(mysqli_query($this->connection, 'SELECT * FROM users')) > 1) {
			$query = 'DELETE FROM users WHERE email = "'.$this->escape($email).'"';
			return mysqli_query($this->connection, $query) === TRUE;
		}
		return false;
  }
  
  public function setGrainPrice($name, $price) {
    $query = 'UPDATE grani SET prezzo = '.$this->escape($price).'
              WHERE nome = "'.$this->escape($name).'"';
    return mysqli_query($this->connection, $query) === TRUE;
  }

  public function setGrainAvailability($name, $quantity) {
    $query = 'UPDATE grani SET disponibilita = '.$this->escape($quantity).'
              WHERE nome = "'.$this->escape($name).'"';
    return mysqli_query($this->connection, $query) === TRUE;
  }

  public function setMachinePrice($id, $price) {
    $query = 'UPDATE macchinari SET prezzoGiorno = '.$this->escape($price).'
              WHERE codice = "'.$this->escape($id).'"';
    return mysqli_query($this->connection, $query) === TRUE;
  }

  public function getMachineAvailability($id) {
    $query = 'SELECT dataFine FROM prenotazioni
              WHERE CURDATE() > dataInizio AND CURDATE() < dataFine AND ordine = "'.$this->escape($id).'"';
    return(mysqli_fetch_row(mysqli_query($this->connection, $query))[0]);
  }

  public function isClient($id) {
    $query = 'SELECT * FROM clienti WHERE id = "'.$this->escape($id).'"';
    return (mysqli_query($this->connection, $query) >= 1);
  }

	public function closeConnection() {
		if($this->connectionOpen)
			mysqli_close($this->connection);
		$this->connectionOpen = false;
	}
}

?>
