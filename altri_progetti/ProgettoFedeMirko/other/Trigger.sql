/*USE OrtoBotanico;*/
/*Il Trigger ControlExist si attiva quando viene inserita una nuova pianta in una lista preferiti.
Ha tre controlli: prima verifica che la pianta inserita sia presente nel DB, poi che la pianta non sia già stata inserita,
poi crea la lista preferiti qualora non esistesse */

DROP TRIGGER IF EXISTS ControlExist;
DROP TRIGGER IF EXISTS ControlPref;
DROP TRIGGER IF EXISTS ControlUser;

DELIMITER $
CREATE TRIGGER ControlExist
BEFORE INSERT ON ListePiante
FOR EACH ROW
BEGIN
IF
(New.Lista NOT IN (SELECT DISTINCT LP.Nome
										FROM ListePreferiti LP
										WHERE LP.Utente=New.Utente)) THEN
INSERT INTO ListePreferiti VALUES (New.Utente,New.Lista,current_timestamp);
END IF;
END $

CREATE TRIGGER ControlPref
BEFORE INSERT ON ListePreferiti
FOR EACH ROW
BEGIN
DECLARE qta TINYINT;
SELECT COUNT(LP.Nome) INTO qta
FROM ListePreferiti LP
WHERE LP.Utente=New.Utente;
IF(qta>=5) THEN 
SIGNAL SQLSTATE VALUE '45000'
SET MESSAGE_TEXT = 'Non si possono inserire più di 5 liste preferiti per utente!';
END IF;
END$

CREATE TRIGGER ControlUser
BEFORE INSERT ON Utenti
FOR EACH ROW
BEGIN
IF(New.Username IN (SELECT Username FROM Utenti)) THEN
SIGNAL SQLSTATE VALUE '45000'
SET MESSAGE_TEXT = 'Username già utilizzato';
ELSEIF(New.Email IN (SELECT Email FROM Utenti)) THEN
SIGNAL SQLSTATE VALUE '45000'
SET MESSAGE_TEXT = 'Email già registrata';
END IF;
END$


DELIMITER ;
