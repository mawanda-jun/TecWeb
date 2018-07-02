/*--- CREAZIONE TABLE ---*/

/*--- Contiene i grani coltivati ---*/
CREATE TABLE grani (
  nome VARCHAR(50) PRIMARY KEY,
  descrizione TEXT,
	immagine VARCHAR(50),
  prezzo FLOAT(5,2) UNSIGNED NOT NULL,
  disponibilita SMALLINT UNSIGNED NOT NULL
)
ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO grani (nome, descrizione, immagine, prezzo, disponibilita) VALUES 
('Timilia o grano marzuolo', 'Grano duro siciliano gi&agrave; citato in epoca greca. &Egrave; particolarmente apprezzato per la panificazione grazie al gusto dolce e al colore carico della farina. Se ne ricava tra l''altro il celebre pane Nero di Castelvetrano.', 'grano_timilia.jpg', 0, 0),
('Frassineto', 'Nato nel 1922 nell''Aretino, &Egrave; un grano tenero derivato dal Gentil Rosso. Vanta gusto e aroma intensi.', 'grano_frassineto.jpg', 0, 0),
('Senatore Cappelli', 'Nato con l''intento di aumentare la produzione di frumento per la crescente popolazione, deve il nome al senatore abruzzese Raffaele Cappelli, nella cui tenuta il genetista Nazareno Strampelli comp&igrave; gli incroci che lo portarono, dopo un''ibridazione con una cultivar tunisina, a produrre un grano di maggiore resa. Non per questo il Cappelli perse sotto il profilo nutrizionale e della digeribilit&agrave;.', 'grano_senatore_cappelli.jpg', 0, 0),
('Dicocco o farro medio', 'Proteico e ricco di antiossidanti, appartiene davvero a un''antica cultivar ed era il preferito dagli antichi romani.', 'grano_triticum_dicoccum.jpg', 0, 0),
('Gentil Rosso', 'Nato in Toscana a met&agrave; &rsquo;800, questo grano tenero ha spighe rossicce da cui si ricava una farina di colore carico. &Egrave; ben fornito di minerali e proteine.', 'grano_gentil_rosso.jpg', 0, 0),
('Rieti', 'Originario dell''omonima citt&agrave; laziale, era gi&agrave; coltivato nel &rsquo;600, ma ebbe grande diffusione in Italia nell&rsquo;800.', 'grano_rieti.jpg', 0, 0),
('Solina', 'Grano tenero diffuso in Abruzzo gi&agrave; nel XVI secolo.', 'grano_solina.jpg', 0, 0),
('Russello', 'Pregiata variet&agrave; di grano duro siciliano, deve il suo nome al colore rosso-dorato delle spighe. Ben digeribile, &Egrave; molto apprezzato per la panificazione.', 'grano_russello.jpg', 0, 0),
('Verna', 'Grano tenero originario della Toscana. Sottoposta ad analisi dall''universit&agrave; di Bologna, la farina ha mostrato un tenore di glutine dello 0,9% contro il 14% della media delle attuali <span xml:lang=\"en\">cultivar</span>, rispetto alle quali ha pure un miglior contenuto di antiossidanti, proteine totali, minerali.', 'grano_verna.jpg', 0, 0);

/*--- Macchinari affittati dall'azienda ---*/
CREATE TABLE macchinari (
  codice CHAR(6) PRIMARY KEY,
  tipologia VARCHAR(50) NOT NULL,
  nome VARCHAR(50) NOT NULL,
  modello VARCHAR(30) NOT NULL,
  potenzaKW FLOAT(5,2) NOT NULL,
  anno SMALLINT(4) NOT NULL,
  immagine VARCHAR(50),
  prezzoGiorno FLOAT(6,2) NOT NULL
)
ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO macchinari (codice, tipologia, nome, modello, potenzaKW, anno, immagine, prezzoGiorno) VALUES 
('TRAT01', 'Trattore', 'Lamborghini', 'Mach 250 VRT', 194.00, '2017', 'lamborghini_mach_250_vrt.jpg', 107.95),
('TRAT02', 'Trattore', 'Landini', '7-230 DT',  	151.00, '2014', 'landini_7_230_dt.jpg', 74.65),
('TRAT03', 'Trattore', 'Goldoni', 'Q 110',  89.48, '2017', 'goldoni_q_110.jpg', 34.45),
('MIET01', 'Mietitrebbia', 'Laverda', 'M400', 225.06, '2016', 'laverda_M400.jpg', 149.65),
('MIET02', 'Mietitrebbia', 'New Holland', 'TC5.90', 190.00, '2013', 'new_holland_tc_90.jpg', 165.70),
('VEND01', 'Vendemmiatrice', 'New Holland', 'BRAUD 9090L', 129.00, '2015', 'new_holland_braud_9090l.jpg', 136.90),
('VEND02', 'Vendemmiatrice', 'Pellenc', '890/SP2', 128.71, '2016', 'pellenc_890sp2.jpg', 147.85);

/*--- Clienti che hanno affittato un macchinario ---*/
CREATE TABLE clienti (
  id CHAR(9) PRIMARY KEY,
  nome VARCHAR(50) NOT NULL,
  cognome VARCHAR(50) NOT NULL,
  telefono CHAR(10) NOT NULL,
	email VARCHAR(60)
)
ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO clienti (id, nome, cognome, telefono, email) VALUES
('AZ0123456', 'Mariano', 'Vanga', '3331234567', 'mariano@vanga.com'),
('BZ1234567', 'Guido', 'Baile', '3491234567', 'guido@baile.com'),
('CZ2345678', 'Fulvio', 'Motosapa', '3391234567', 'fulvio@motosapa.com'),
('DZ3456789', 'Giuseppina', 'Tajaerba', '3421234567', 'giuseppina@tajaerba.com'),
('EZ4567890', 'Mario', 'Forcon', '3401234567', 'mario@forcon.com');

/*--- Prenotazioni dei macchinari ---*/
CREATE TABLE prenotazioni (
	ordine MEDIUMINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  idCliente CHAR(9) NOT NULL,
  idMacchinario CHAR(6) NOT NULL,
  dataInizio DATE NOT NULL,
  dataFine DATE NOT NULL,
  FOREIGN KEY (idMacchinario) REFERENCES macchinari(codice) ON UPDATE CASCADE ON DELETE NO ACTION,
  FOREIGN KEY (idCliente) REFERENCES clienti(id) ON UPDATE CASCADE ON DELETE NO ACTION
)
ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO prenotazioni (idCliente, idMacchinario, dataInizio, dataFine) VALUES
('EZ4567890', 'MIET02', '2017-07-21', '2017-07-25'),
('DZ3456789', 'VEND01', '2017-09-28', '2017-09-30'),
('BZ1234567', 'MIET01', '2018-06-17', '2018-06-21'),
('DZ3456789', 'MIET02', '2018-07-01', '2017-07-10'),
('CZ2345678', 'TRAT01', '2018-07-02', '2018-07-09'),
('AZ0123456', 'TRAT03', '2018-07-04', '2018-07-15');

/*--- Utenti del sistema (operatori dell'azienda/admin) ---*/
CREATE TABLE users (
  email varchar(60) PRIMARY KEY,
  pwd varchar(80) NOT NULL
)
ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO users (email, pwd) VALUES
('admin@admin.com', '$2y$10$F0B3IE4vRA0kXt74LkCcBO4qOOKnjSbQXxWT8LNMdswo6N7W8OGWi');