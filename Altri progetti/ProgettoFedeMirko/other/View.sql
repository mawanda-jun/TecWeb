USE OrtoBotanico;

DROP VIEW IF EXISTS UseNomePro;
DROP VIEW IF EXISTS OvUnAlt;
DROP VIEW IF EXISTS PrinEff;
DROP VIEW IF EXISTS StAlim;
DROP VIEW IF EXISTS Conta;

/*1) Voglio trovare il nome scientifico e gli utilizzi delle diverse piante che compongono  le liste create da utenti che hanno creato almeno 2 liste composte da almeno 4 piante:*//*
*/
CREATE VIEW UseNomePro AS
SELECT DISTINCT(CONCAT(LP.pianta, ', utilizzo: ', U.utilizzo)) as Piante_Ricercate
FROM  ListePiante LP, UtilizziPiante U, ListePreferiti LPR
WHERE LP.pianta=U.pianta AND LPR.Utente=LP.Utente
      AND LPR.Utente IN(SELECT PR.Utente
                        FROM ListePreferiti PR
                        WHERE (PR.Nome, PR.Utente) IN(SELECT LP1.Lista, LP1.Utente
                                                      FROM ListePiante LP1
                                                      GROUP BY LP1.Lista, LP1.Utente
                                                      HAVING COUNT(LP1.Pianta) >= 4)
                         GROUP BY PR.Utente
                         HAVING COUNT(PR.Nome) >= 2);

/*Voglio trovare tutte le piante terrestri con un' altezza superiore a 200cm, 
che crescono in un clima Monsonico e producono un fiore di colore bianco; oltre a queste, 
voglio estrarre le piante di acqua dolce che stanno invece sotto i 100cm di altezza e crescono 
in un clima dalla temperatura superiore ai 20 gradi.
*/
CREATE VIEW OvUnAlt AS
SELECT PT.BiomaT AS Bioma, P.NomeScientifico, P.Altezzacm AS Altezza
FROM  Piante P, PresenzeT PT, BiomiTerrestri BT
WHERE P.NomeScientifico=PT.Pianta AND BT.Nome=PT.BiomaT AND BT.Clima='Temperato'
AND P.NomeScientifico IN (SELECT Pianta
                          FROM  Fiori
                          WHERE Colore='Bianco') AND P.Altezzacm>200
UNION SELECT PA.BiomaA AS Bioma, P.NomeScientifico, P.Altezzacm AS Altezza 
FROM Piante P, PresenzeA PA, BiomiAcquatici BA 
WHERE  Salinità=0 AND Temperatura>=20 AND Altezzacm<100 AND PA.BiomaA=BA.Nome 
       AND P.NomeScientifico=PA.Pianta;

/*Estrarre i principi e gli effetti delle piante il cui raccolto non avviene in estate e appartenenti alla sottodivisione piu' numerosa 
*/
CREATE VIEW Conta AS
SELECT G.Sottodivisione as Sottodivisione, COUNT(P.NomeScientifico) as Numero 
FROM Piante P JOIN Gruppi G ON (P.Gruppo=G.Id)
WHERE G.Sottodivisione IS NOT NULL
GROUP BY G.Sottodivisione;

CREATE VIEW PrinEff AS
SELECT P.Nome as Principio, P.Beneficio, I.NomeScientifico as Pianta
FROM Gruppi G, Conta, Piante I LEFT JOIN PrincipiPiante PP ON I.NomeScientifico=PP.Pianta JOIN Principi P ON P.Nome=PP.Principio
WHERE I.Gruppo=G.Id AND I.NomeScientifico not in (SELECT Raccolta.Pianta
FROM Raccolta JOIN Stagioni ON Raccolta.Periodo=Stagioni.ID
WHERE Stagioni.Stagione='Estate') AND Conta.Sottodivisione=G.Sottodivisione AND Conta.Numero=(SELECT MAX(Numero) 
FROM Conta)
ORDER BY Principio; 

/* Estrarre lo stato da cui provengono le piante che possiedono esattamente due principi e che hanno solo un utilizzo alimentare
*/
CREATE VIEW StAlim AS
SELECT DISTINCT(S.Nome)
FROM Stati S, PresenzeT T, PresenzeA A, Piante P 
WHERE ((S.Nome=T.Stato AND P.NomeScientifico=T.Pianta) OR (S.Nome=A.Stato AND P.NomeScientifico=A.Pianta)) AND P.NomeScientifico IN (
	SELECT U.Pianta
	FROM UtilizziPiante U 
	WHERE U.Utilizzo='alimentare' and U.Pianta not in (
		SELECT UT.Pianta
		FROM UtilizziPiante UT
		WHERE UT.Utilizzo<>'alimentare'
	)) AND P.NomeScientifico IN (
	SELECT Distinct(PP.Pianta)
	FROM PrincipiPiante PP 
	GROUP BY PP.Pianta
	HAVING COUNT(PP.Principio)=2
);






