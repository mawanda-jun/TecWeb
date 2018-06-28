/*--- CREAZIONE TABLE ---*/

/*--- Contiene i grani coltivati ---*/
DROP TABLE IF EXISTS grani;
CREATE TABLE IF NOT EXISTS grani (
    nome VARCHAR(20) PRIMARY KEY,
    descrizione TEXT,
	  immagine VARCHAR(30),
    prezzo FLOAT(5,2) NOT NULL,
    disponibilità SMALLINT UNSIGNED NOT NULL
)
ENGINE=InnoDB;

/*--- Macchinari affittati dall'azienda ---*/
DROP TABLE IF EXISTS macchinari;
CREATE TABLE IF NOT EXISTS macchinari (
    codice CHAR(6) PRIMARY KEY,
    nome VARCHAR(20) NOT NULL,
    modello VARCHAR(20) NOT NULL,
	  immagine VARCHAR(30),
    prezzoGiorno FLOAT(5,2) NOT NULL
)
ENGINE=InnoDB;

/*--- Clienti che hanno affittato un macchinario ---*/
DROP TABLE IF EXISTS clienti;
CREATE TABLE IF NOT EXISTS clienti (
    id CHAR(9) PRIMARY KEY,
    nome VARCHAR(20) NOT NULL,
    cognome VARCHAR(20) NOT NULL,
    telefono CHAR(10) NOT NULL,
	  email VARCHAR(40)
)
ENGINE=InnoDB;

/*--- Prenotazioni dei macchinari ---*/
DROP TABLE IF EXISTS prenotazioni;
CREATE TABLE IF NOT EXISTS prenotazioni (
	  ordine MEDIUMINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    idCliente CHAR(9) NOT NULL,
    idMacchinario CHAR(6) NOT NULL,
    dataInizio DATE NOT NULL,
    dataFine DATE NOT NULL,
    FOREIGN KEY (idMacchinario) REFERENCES macchinari(codice) ON UPDATE CASCADE ON DELETE NO ACTION,
    FOREIGN KEY (idCliente) REFERENCES clienti(id) ON UPDATE CASCADE ON DELETE NO ACTION
)
ENGINE=InnoDB;

/*--- Utenti del sistema ---*/
DROP TABLE IF EXISTS users;
CREATE TABLE IF NOT EXISTS users (
	  username varchar(30) PRIMARY KEY,
    email varchar(60) DEFAULT NULL,
    password varchar(50) NOT NULL
)
ENGINE=InnoDB;


/*--- INSERIMENTO DATI ---*/

INSERT INTO grani (nome, descrizione, immagine, prezzo, disponibilità) VALUES 
('Timilia o grano marzuolo', "Grano duro siciliano già citato in epoca greca. È particolarmente apprezzato per la panificazione grazie al gusto dolce e al colore carico della farina. Se ne ricava tra l'altro il celebre pane Nero di Castelvetrano.", 'grano-timilia.jpg', 0, 0),
('Frassineto', "Nato nel 1922 nell'Aretino, è un grano tenero derivato dal Gentil Rosso (vedi). Vanta gusto e aroma intensi.", 'grano-frassineto.jpg', 0, 0),
('Senatore Cappelli', "Nato con l'intento di aumentare la produzione di frumento per la crescente popolazione, deve il nome al senatore abruzzese Raffaele Cappelli, nella cui tenuta il genetista Nazareno Strampelli compì gli incroci che lo portarono, dopo un'ibridazione con una cultivar tunisina, a produrre un grano di maggiore resa. Non per questo il Cappelli perse sotto il profilo nutrizionale e della digeribilità.", 'grano-senatore-cappelli.jpg', 0, 0),
('Dicocco o farro medio', "Proteico e ricco di antiossidanti, appartiene davvero a un'antica cultivar ed era il preferito dagli antichi romani.", 'grano-triticum-dicoccum.jpg', 0, 0),
('Gentil Rosso', "Nato in Toscana a metà '800, questo grano tenero ha spighe rossicce da cui si ricava una farina di colore carico. È ben fornito di minerali e proteine.", 'grano-gentil-rosso.jpg', 0, 0),
('Rieti', "Originario dell'omonima città laziale, era già coltivato nel '600, ma ebbe grande diffusione in Italia nell’800.", 'grano-rieti.jpg', 0, 0),
('Solina', "Grano tenero diffuso in Abruzzo già nel XVI secolo.", 'grano-solina.jpg', 0, 0),
('Russello', "Pregiata varietà di grano duro siciliano, deve il suo nome al colore rosso-dorato delle spighe. Ben digeribile, è molto apprezzato per la panificazione.", 'grano-russello.jpg', 0, 0),
('Verna', "Grano tenero originario della Toscana. Sottoposta ad analisi dall'università di Bologna, la farina ha mostrato un tenore di glutine dello 0,9\% contro il 14\% della media delle attuali cultivar, rispetto alle quali ha pure un miglior contenuto di antiossidanti, proteine totali, minerali.", 'grano_verna.jpg', 0, 0);

INSERT INTO macchinari (codice, nome, modello, immagine, prezzoGiorno) VALUES 
('TRAT01', 'Lamborghini', 'Mach 250 VRT', '', 107.95),
('TRAT02', 'Landini', '7-230 DT', '', 74.65),
('TRAT03', 'Goldoni', 'Q 110', '', 34.45),
('MIET01', 'Laverda', 'M400', '', 149.65),
('MIET02', 'New Holland', 'TC5.90', '', 165.70),
('VEND01', 'New Holland', 'BRAUD 9090L', '', 136.90);

INSERT INTO clienti (id, nome, cognome, telefono, email) VALUES
('AZ0123456', 'Mariano', 'Vanga', '3331234567', 'mariano@vanga.com'),
('BZ1234567', 'Guido', 'Baile', '3491234567', 'guido@baile.com'),
('CZ2345678', 'Fulvio', 'Motosapa', '3391234567', 'fulvio@motosapa.com'),
('DZ3456789', 'Giuseppina', 'Tajaerba', '3421234567', 'giuseppina@tajaerba.com'),
('EZ4567890', 'Mario', 'Forcon', '3401234567', 'mario@forcon.com');

INSERT INTO prenotazioni (idCliente, idMacchinario, dataInizio, dataFine) VALUES
('EZ4567890', 'MIET02', '2017-07-21', '2017-07-25'),
('DZ3456789', 'VEND01', '2017-09-28', '2017-09-30'),
('BZ1234567', 'MIET01', '2018-06-17', '2018-06-21'),
('DZ3456789', 'MIET02', '2018-07-01', '2017-07-10'),
('CZ2345678', 'TRAT01', '2018-07-02', '2018-07-09'),
('AZ0123456', 'TRAT03', '2018-07-04', '2018-07-15');

INSERT INTO users (username, email, pwd) VALUES
('admin', 'admin@admin.com', '$2y$10$F0B3IE4vRA0kXt74LkCcBO4qOOKnjSbQXxWT8LNMdswo6N7W8OGWi');