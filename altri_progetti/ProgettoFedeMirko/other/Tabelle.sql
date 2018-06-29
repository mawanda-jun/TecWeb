DROP DATABASE IF EXISTS OrtoBotanico;
CREATE DATABASE IF NOT EXISTS  OrtoBotanico;
USE OrtoBotanico;
SET foreign_key_checks = 0;
DROP TABLE IF EXISTS Gruppi;
DROP TABLE IF EXISTS Piante;
DROP TABLE IF EXISTS Foglie;
DROP TABLE IF EXISTS Principi;
DROP TABLE IF EXISTS PrincipiPiante;
DROP TABLE IF EXISTS UtilizziPiante;
DROP TABLE IF EXISTS Utenti;
DROP TABLE IF EXISTS ListePreferiti;
DROP TABLE IF EXISTS ListePiante;
DROP TABLE IF EXISTS Stagioni;
DROP TABLE IF EXISTS Semina;
DROP TABLE IF EXISTS Raccolta;
DROP TABLE IF EXISTS Fioritura;
DROP TABLE IF EXISTS Frutti;
DROP TABLE IF EXISTS Fiori;
DROP TABLE IF EXISTS PresenzeA;
DROP TABLE IF EXISTS PresenzeT;
DROP TABLE IF EXISTS BiomiAcquatici;
DROP TABLE IF EXISTS BiomiTerrestri;
DROP TABLE IF EXISTS Stati;


CREATE TABLE Gruppi (
    Id VARCHAR(3) PRIMARY KEY,
    Gruppo VARCHAR(20) NOT NULL,
    Divisione VARCHAR(20),
    Sottodivisione VARCHAR(20)
);

CREATE TABLE Piante (
    NomeScientifico VARCHAR(50) PRIMARY KEY,
    NomeComune VARCHAR(50),
    NumEsemplari SMALLINT(3) DEFAULT 0,
    AltezzaCm SMALLINT(5) DEFAULT 0,
    Descrizione VARCHAR(2000) DEFAULT NULL,
    Gruppo VARCHAR(3),
    Fusto ENUM('Eretto', 'Rampicante', 'Strisciante', 'Rampante'),
    Radice ENUM('Ramosa', 'Tuberiforme', 'Fascicolata', 'A fittone', 'Avventizia', 'Aerea'),
    FOREIGN KEY (Gruppo)
        REFERENCES Gruppi (Id)
        ON UPDATE CASCADE 
);

CREATE TABLE Foglie (
    Pianta VARCHAR(50) PRIMARY KEY,
    Forma ENUM('Aghiforme', 'Falcata', 'Orbicolare', 'Romboidale', 'Acuminata', 'Flabellata', 'Ovata', 'Rosetta', 'Alternata', 'Astata', 'Palmata', 'Spatolata', 'Aristata', 'Lanceolata', 'Pedata', 'Sagittata', 'Bipennata', 'Lineare', 'Peltata', 'Lesiniforme', 'Cordata', 'Lobulata', 'Amplessicaule', 'Tripartita', 'Cuneiforme', 'Obcordata', 'Impari-pennata', 'Tripennata', 'Triangolare', 'Obovata', 'Paripennata', 'Troncata', 'Digitata', 'Ottusa', 'Pennatisecta', 'Intera', 'Ellittica', 'Opposte', 'Reniforme', 'Verticillata'),
    Composizione ENUM('Composta', 'Semplice'),
    Margine ENUM('Ciliato', 'Crenato', 'Dentato', 'Denticolato', 'Doppiamente dentato', 'Intero', 'Lobato', 'Seghettato', 'Finemente seghettato', 'Sinuato', 'Spinoso', 'Ondulato'),
    Superficie ENUM('Coriacea', 'Tomentosa', 'Scabra'),
    FOREIGN KEY (Pianta)
        REFERENCES Piante (NomeScientifico)
        ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE Principi (
    Nome VARCHAR(20) PRIMARY KEY,
    Beneficio VARCHAR(500)
);

CREATE TABLE PrincipiPiante (
    Principio VARCHAR(20), 
    Pianta VARCHAR(50), 
    PRIMARY KEY (Principio , Pianta),
	FOREIGN KEY (Principio) REFERENCES Principi (Nome) ON UPDATE CASCADE,
    FOREIGN KEY (Pianta) REFERENCES Piante (NomeScientifico)
    ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE UtilizziPiante (
    Pianta VARCHAR(50),    
    Utilizzo ENUM('alimentare', 'aromatico', 'farmacologico', 'tessile', 'legname', 'ornamentale'),
    PRIMARY KEY (Pianta , Utilizzo),
	FOREIGN KEY (Pianta) REFERENCES Piante (NomeScientifico) ON UPDATE CASCADE ON DELETE CASCADE
);
	
CREATE TABLE Utenti (
    Username VARCHAR(20) PRIMARY KEY,
    Email VARCHAR(30) UNIQUE NOT NULL,
    Pass VARCHAR(41) NOT NULL,
    Nome VARCHAR(20) NOT NULL,
    Cognome VARCHAR(20) NOT NULL
);
	
CREATE TABLE ListePreferiti (
    Utente VARCHAR(30),
    Nome VARCHAR(20) NOT NULL,
    DataCreazione TIMESTAMP,
    PRIMARY KEY (Utente , Nome),
    FOREIGN KEY (Utente)
        REFERENCES Utenti (Username)
        ON UPDATE CASCADE ON DELETE CASCADE
);
	
CREATE TABLE ListePiante (
    Pianta VARCHAR(50),
    Utente VARCHAR(30),
    Lista VARCHAR(20),
    PRIMARY KEY (Pianta , Utente , Lista),
    FOREIGN KEY (Pianta)
        REFERENCES Piante (NomeScientifico)
        ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (Utente , Lista)
        REFERENCES ListePreferiti (Utente , Nome)
        ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE BiomiTerrestri (
    Nome VARCHAR(20) PRIMARY KEY,
    Clima ENUM('Mediterraneo', 'Tropicale', 'Equatoriale', 'Subtropicale', 'Temperato', 'Temperato Umido', 'Oceanico', 'Continentale', 'Subartico', 'Transiberiano', 'Polare', 'Nivale', 'Glaciale', 'Steppico', 'Desertico', 'Monsonico', 'Sinico', 'Della Savana', 'Alpino', 'Boreale', 'Boreale delle foreste', 'Della tundra'),
    Precipitazioni INT,
    Terreno ENUM('argilloso', 'sabbioso', 'limoso', 'torboso'),
    SezioneOrto VARCHAR(5)
);
	
CREATE TABLE BiomiAcquatici (
    Nome VARCHAR(20) PRIMARY KEY,
    Temperatura TINYINT,
    Salinità TINYINT,
    SezioneOrto VARCHAR(5)
);

CREATE TABLE Stati (
    Nome VARCHAR(20) PRIMARY KEY
);
	
CREATE TABLE PresenzeT (
    BiomaT VARCHAR(20), 
    Stato VARCHAR(20), 
    Pianta VARCHAR(50), 
    PRIMARY KEY (BiomaT , Stato , Pianta),
	FOREIGN KEY (BiomaT) REFERENCES BiomiTerrestri (Nome)
    ON UPDATE CASCADE,
	FOREIGN KEY (Stato) REFERENCES Stati (Nome)
    ON UPDATE CASCADE,
	FOREIGN KEY (Pianta) REFERENCES Piante (NomeScientifico)
    ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE PresenzeA (
    BiomaA VARCHAR(20),
    Stato VARCHAR(20), 
    Pianta VARCHAR(50), 
    PRIMARY KEY (BiomaA , Stato , Pianta),
	FOREIGN KEY(BiomaA)  REFERENCES BiomiAcquatici (Nome)
    ON UPDATE CASCADE,
	FOREIGN KEY (Stato) REFERENCES Stati (Nome)
    ON UPDATE CASCADE,
	FOREIGN KEY (Pianta) REFERENCES Piante (NomeScientifico)
    ON UPDATE CASCADE ON DELETE CASCADE
);
	
CREATE TABLE Fiori (
    Pianta VARCHAR(50) PRIMARY KEY, 
    Nome VARCHAR(20),
    NumPetali TINYINT,
    Colore ENUM('Rosso', 'Viola', 'Lilla', 'Giallo', 'Arancione', 'Bianco', 'Rosa', 'Azzurro', 'Blu', 'Verde'),
	FOREIGN KEY (Pianta) REFERENCES Piante (NomeScientifico) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE Frutti (
    Nome VARCHAR(20),
    Colore ENUM('Rosso', 'Viola', 'Lilla', 'Giallo', 'Arancione', 'Bianco', 'Rosa', 'Grigio', 'Verde', 'Marrone', 'Blu'),
    Pianta VARCHAR(50) PRIMARY KEY,
	FOREIGN KEY (Pianta) REFERENCES Fiori (Pianta)
    ON UPDATE CASCADE ON DELETE CASCADE
);
	
CREATE TABLE Stagioni (
    ID CHAR(2) PRIMARY KEY,
    Periodo ENUM('Inizio', 'Piena', 'Pieno', 'Fine'),
    Stagione ENUM('Primavera', 'Estate', 'Autunno', 'Inverno')
);


CREATE TABLE Semina (
    Pianta VARCHAR(50), 
    Periodo CHAR(2), 
    PRIMARY KEY (Pianta , Periodo),
	FOREIGN KEY (Pianta) REFERENCES Piante (NomeScientifico) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY (Periodo) REFERENCES Stagioni (ID)
    ON DELETE NO ACTION ON UPDATE CASCADE
);
     
     
CREATE TABLE Fioritura (
    Pianta VARCHAR(50),
    Periodo CHAR(2),
    PRIMARY KEY (Pianta , Periodo),
	FOREIGN KEY (Pianta)  REFERENCES Fiori (Pianta)
    ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY (Periodo) REFERENCES Stagioni (ID)
    ON DELETE NO ACTION ON UPDATE CASCADE
);

CREATE TABLE Raccolta (
    Pianta VARCHAR(50),
    Periodo CHAR(2),
    PRIMARY KEY (Pianta , Periodo),
	FOREIGN KEY (Pianta) REFERENCES Piante (NomeScientifico) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY (Periodo) REFERENCES Stagioni (ID)
    ON DELETE NO ACTION ON UPDATE CASCADE
);
     
SET foreign_key_checks = 1;



