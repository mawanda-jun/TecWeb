USE OrtoBotanico;

DROP PROCEDURE IF EXISTS AddPref;
DROP PROCEDURE IF EXISTS DelPref;
DROP PROCEDURE IF EXISTS AddList;
DROP PROCEDURE IF EXISTS DelList;
DROP PROCEDURE IF EXISTS Registrazione;
DROP PROCEDURE IF EXISTS DelUser;
DROP PROCEDURE IF EXISTS CountPlants;

DELIMITER ||

CREATE PROCEDURE AddPref(In Ut VARCHAR(20),In psw VARCHAR(20), IN listaI VARCHAR(20), IN piantaS VARCHAR(50))
BEGIN
IF(Control(Ut,psw)) THEN
	IF (piantaS IN (SELECT DISTINCT LP.Pianta
					FROM ListePiante LP
					WHERE LP.lista=listaI AND Ut=LP.utente)) THEN
	SIGNAL SQLSTATE VALUE '45000'
	SET MESSAGE_TEXT = 'Pianta gia'' presente nella lista indicata';
	ELSE
	INSERT INTO ListePiante values (piantaS, Ut, listaI);
    END IF;
ELSE
SIGNAL SQLSTATE VALUE '45000'
SET MESSAGE_TEXT = 'Username o password errati';
END IF;
END ||

CREATE PROCEDURE DelPref(In Ut VARCHAR(20), In psw VARCHAR(20),IN listaI VARCHAR(20), IN piantaS VARCHAR(50))
BEGIN
IF(Control(Ut,psw)) THEN

	IF(listaI NOT IN (SELECT DISTINCT LP.Lista
			          FROM ListePiante LP
					  WHERE Ut=LP.Utente)) THEN
	SIGNAL SQLSTATE VALUE '45000'
	SET MESSAGE_TEXT = 'La lista preferiti indicata non esiste';
	ELSEIF(piantaS NOT IN (SELECT DISTINCT LP.Pianta
							FROM ListePiante LP
							WHERE LP.lista=listaI AND Ut=LP.Utente)) THEN
	SIGNAL SQLSTATE VALUE '45000'
	SET MESSAGE_TEXT = 'Pianta non presente nella lista indicata';
	ELSE
	DELETE LP.* FROM ListePiante LP
	WHERE listaI=LP.lista and LP.Utente=Ut and LP.pianta=piantaS;
    END IF;
ELSE
SIGNAL SQLSTATE VALUE '45000'
SET MESSAGE_TEXT = 'Username o password errati';
END IF;
END ||

CREATE PROCEDURE DelList(In Ut VARCHAR(20), In psw VARCHAR(20),IN listaI VARCHAR(20))
BEGIN
IF(Control(Ut,psw)) THEN
IF(listaI NOT IN (SELECT DISTINCT LP.Nome
			          FROM ListePreferiti LP
					  WHERE Ut=LP.Utente)) THEN
		SIGNAL SQLSTATE VALUE '45000'
	SET MESSAGE_TEXT = 'La lista preferiti indicata non esiste';
ELSE
DELETE LP.* 
FROM ListePreferiti LP
WHERE listaI=LP.Nome and LP.Utente=Ut;
END IF;
ELSE
SIGNAL SQLSTATE VALUE '45000'
	SET MESSAGE_TEXT = 'Username o password errati';
END IF;
END||

CREATE PROCEDURE AddList(In Ut VARCHAR(20), In psw VARCHAR(20), IN listaI VARCHAR(20))
BEGIN
IF(Control(Ut,psw)) THEN
INSERT INTO ListePreferiti VALUES(Ut,listaI,current_timestamp());
ELSE
SIGNAL SQLSTATE VALUE '45000'
	SET MESSAGE_TEXT = 'Username o password errati';
END IF;
END ||

CREATE PROCEDURE Registrazione(IN Ut VARCHAR(20), IN mail VARCHAR(30), IN psw VARCHAR(20), IN nome VARCHAR(20), IN cognome VARCHAR(20))
BEGIN
INSERT INTO Utenti VALUES(Ut, mail, password(psw), nome, cognome);

END ||

CREATE PROCEDURE DelUser(IN Ut VARCHAR(20), IN psw VARCHAR(41))
BEGIN
IF(Control(Ut,psw)) THEN
DELETE Utenti.* FROM Utenti WHERE Ut=Username;
ELSE 
SIGNAL SQLSTATE VALUE '45000'
SET MESSAGE_TEXT = 'Username o password errati';
END IF;
END ||

/*Tramite questa procedura è possibile, dato in input il nome di una sezione dell'orto botanico, sapere quante specie di piante contenute in esso hanno il fusto eretto e quante invece diverso da eretto (dunque si considerano solo le piante tracheofite). Oltre a questi dati, la procedura mostra il nome della sezione ricercata e il bioma in essa rappresentato.*/

CREATE PROCEDURE CountPlants (IN sezorto varchar(5))
BEGIN
IF(sezorto NOT IN (SELECT SezioneOrto FROM BiomiTerrestri) AND sezorto NOT IN (SELECT SezioneOrto FROM BiomiAcquatici)) THEN
SIGNAL SQLSTATE VALUE '45000'
SET MESSAGE_TEXT = 'La sezione indicata non esiste.';
ELSE
(SELECT IFNULL(PianteFustoEretto, 0) AS PianteFustoEretto, IFNULL(PianteFustoNonEretto,0) AS PianteFustoNonEretto, Bioma, SezioneOrto
FROM (
SELECT COUNT(DISTINCT PT.Pianta) AS PianteFustoEretto, PT.BiomaT as Bioma, BT.SezioneOrto AS SezioneOrto
FROM BiomiTerrestri BT, PresenzeT PT, Piante P
WHERE BT.Nome=PT.BiomaT AND P.Fusto='Eretto' AND P.NomeScientifico=PT.Pianta AND BT.SezioneOrto=sezorto
GROUP BY Bioma
) AS TAB
LEFT JOIN (
SELECT COUNT(DISTINCT PT1.Pianta) AS PianteFustoNonEretto, PT1.BiomaT AS Bioma1
FROM PresenzeT PT1, Piante P1
WHERE P1.Fusto<>'Eretto' AND P1.NomeScientifico=PT1.Pianta
GROUP BY Bioma1) AS TAB1
ON Bioma=Bioma1)
UNION (SELECT IFNULL(PianteFustoEretto, 0) AS PianteFustoEretto, IFNULL(PianteFustoNonEretto,0) AS PianteFustoNonEretto, Bioma, SezioneOrto
FROM (
SELECT COUNT(DISTINCT PA.Pianta) AS PianteFustoEretto, PA.BiomaA as Bioma, BA.SezioneOrto AS SezioneOrto
FROM BiomiAcquatici BA, PresenzeA PA, Piante P
WHERE BA.Nome=PA.BiomaA AND P.Fusto='Eretto' AND P.NomeScientifico=PA.Pianta AND BA.SezioneOrto=sezorto
GROUP BY Bioma
) AS TABA
LEFT JOIN (
SELECT COUNT(DISTINCT PA1.Pianta) AS PianteFustoNonEretto, PA1.BiomaA AS Bioma1
FROM PresenzeA PA1, Piante P1
WHERE P1.Fusto<>'Eretto' AND P1.NomeScientifico=PA1.Pianta
GROUP BY Bioma1) AS TABA1
ON Bioma=Bioma1);
END IF;
END ||


DELIMITER ;




