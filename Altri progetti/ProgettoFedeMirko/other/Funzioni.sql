/*USE OrtoBotanico;*/
/*Funzione che restituisce il numero di piante appartenenti ad un gruppo, famiglia o divisione (in base
 all'input fornito: G=gruppo, D=divisione, S=sottodivisione) dato in input. 
 */
DROP FUNCTION IF EXISTS QtaGrup;
DROP FUNCTION IF EXISTS Control;

DELIMITER $

CREATE FUNCTION QtaGrup(gr char(1), fm VARCHAR(20))
RETURNS SMALLINT UNSIGNED 
BEGIN 

DECLARE Quantita SMALLINT UNSIGNED;
IF(gr='G') THEN
	SELECT COUNT(Piante.NomeScientifico) INTO Quantita
	FROM Piante, Gruppi
	WHERE Gruppi.Gruppo=fm and Piante.Gruppo=Gruppi.Id;
ELSEIF (gr='D') THEN
	SELECT COUNT(Piante.NomeScientifico) INTO Quantita
	FROM Piante, Gruppi 
	WHERE Gruppi.Divisione=fm and Piante.Gruppo=Gruppi.Id;
ELSEIF(gr='S') THEN
	SELECT COUNT(Piante.NomeScientifico) INTO Quantita
	FROM Piante, Gruppi
	WHERE Gruppi.Sottodivisione=fm and Piante.Gruppo=Gruppi.Id; 
ELSE
SET Quantita=0;
SIGNAL SQLSTATE VALUE '45000'
SET MESSAGE_TEXT = 'Errore nell''indicazione di Gruppo, Famiglia, Divisione';
END IF;
RETURN Quantita;

END $


CREATE FUNCTION Control(UT VARCHAR(20), psw VARCHAR(20))
RETURNS BOOL
BEGIN 

DECLARE a BOOL;
DECLARE pss VARCHAR(41);
SET pss=password(psw);
IF((Ut NOT IN (SELECT Username
			  FROM Utenti)) OR 
  (pss<>(SELECT Pass
		 FROM Utenti
		 WHERE Username=Ut))) THEN
  SET a=0;
ELSE
  SET a=1;
END IF;
RETURN a;

END$

DELIMITER ;

 
