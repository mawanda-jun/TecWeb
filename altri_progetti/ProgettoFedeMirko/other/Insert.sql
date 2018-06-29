USE OrtoBotanico;
SET foreign_key_checks = 0;

INSERT INTO Gruppi VALUES 	('B', 'Briofita', NULL, NULL), 
							('A', 'Alga', NULL, NULL), 
                            ('TP', 'Tracheofita', 'Pteridofita', NULL), 
                            ('TSG', 'Tracheofita', 'Spermatofita', 'Gimnosperma'),
                            ('TSA', 'Tracheofita', 'Spermatofita', 'Angiosperma');
                            
INSERT INTO Piante VALUES  ('Gossypium Herbaceum', 'Cotone', 5, 150,  'Una specie di cotone che viene coltivata e commercializzata per la fibra tessile', 'TSA', 'Eretto', 'A fittone'),
							('Juniperus Communis', 'Ginepro', 10, 250, 'Alberello o arbusto conosciuto per le sue bacche', 'TSG', 'Rampante', 'Ramosa'),
                            ('Porphyra Tenera', 'Ama-nori', 20,10, 'Alga rossa commercializzata col nome generico giapponese Nori', 'A', NULL, NULL),
                            ('Cedrus Libani', 'Cedro del Libano', 2, 4000, 'Pianta arborea distinguibile per alcuni rami che assumono un portamento a candelabro', 'TSG', 'Eretto', 'Ramosa'),
                            ('Eucalyptus','Eucalipto', 4, 300, 'Piante arboree sempreverdi oriiginarie dell Oceania', 'TSA', 'Eretto', 'Ramosa'),
                            ('Melaleuca Alternifolia', 'Albero del Te', 10, 600, 'Albero dalle cui foglie si estrae un olio essenziale, dal fortissimo odore e dal sapore assai intenso e caratteristico', 'TSA', 'Eretto', 'Ramosa'),
							('Eriobotrya Japonica', 'Nespolo del Giappone', 8, 500, 'Pianta di tipo arboreo coltivata a scopo ornamentale e per il suo frutto', 'TSA', 'Eretto', 'Ramosa'),
                            ('Elaeocarpus Angustifolius', 'Blue Marble Tree', 5, 350, 'Albero indiano sacro conosciuto per i suoi frutti blu brillante', 'TSA', 'Eretto', 'Ramosa'),
							('Vallisneria Gigantea', 'Vallisneria', 14, 50, 'Tipica pianta da acquario', 'TSA', 'Eretto', 'Ramosa');

INSERT INTO Foglie VALUES 	('Gossypium Herbaceum', 'Palmata', 'Semplice', 'Lobato', 'Scabra'),
							('Juniperus Communis', 'Aghiforme', 'Composta', 'Intero', 'Coriacea'),
                            ('Cedrus Libani', 'Aghiforme', 'Semplice', 'Intero', 'Coriacea'),
                            ('Eucalyptus', 'Lanceolata', 'Semplice', 'Intero', 'Coriacea'),
                            ('Melaleuca Alternifolia', 'Lanceolata', 'Composta', 'Intero', 'Coriacea'),
                            ('Eriobotrya Japonica', 'Lanceolata', 'Semplice', 'Ondulato', 'Coriacea'),
                            ('Elaeocarpus Angustifolius', 'Lanceolata', 'Semplice', 'Intero', 'Coriacea'),
                            ('Vallisneria Gigantea', 'Lanceolata', 'Semplice', 'Intero', 'Scabra')
;
INSERT INTO Principi VALUES ('Flavonoidi', 'Antiossidante'),
							('Acidi diterpenici', 'Diuretico'),
                            ('Olio Essenziale', 'Analgesico'),
                            ('Terpinolo', 'Antisettico'),
                            ('Cineolo', 'Antimicotico')
                            
;
INSERT INTO PrincipiPiante VALUES	('Flavonoidi', 'Juniperus Communis'),
									('Acidi Diterpenici', 'Juniperus Communis'),
                                    ('Olio Essenziale', 'Eucalyptus'),
                                    ('Olio Essenziale', 'Melaleuca Alternifolia'),
                                    ('Terpinolo', 'Melaleuca Alternifolia'),
                                    ('Cineolo', 'Melaleuca Alternifolia'),
                                    ('Flavonoidi', 'Eriobotrya Japonica'),
                                    ('Flavonoidi', 'Eucalyptus')
;
INSERT INTO UtilizziPiante VALUES	('Gossypium Herbaceum', 'Tessile'),
							        ('Juniperus Communis', 'Alimentare'),
                                    ('Porphyra Tenera', 'Alimentare'),
                                    ('Cedrus Libani', 'Ornamentale'),
                                    ('Eucalyptus', 'Farmacologico'),
                                    ('Eucalyptus', 'Legname'),
                                    ('Eucalyptus', 'Ornamentale'),
                                    ('Melaleuca Alternifolia', 'Farmacologico'),
                                    ('Eriobotrya Japonica', 'Alimentare'),
                                    ('Eriobotrya Japonica', 'Farmacologico'),
                                    ('Elaeocarpus Angustifolius','Ornamentale'),
                                    ('Elaeocarpus Angustifolius', 'Alimentare'),
                                    ('Vallisneria Gigantea', 'Ornamentale')
;
INSERT INTO Utenti VALUES ('marge','marco@marco.it',password('marco'), 'marco','gene'),
						  ('adda','aldo@aldo.it', password('aldo'),'aldo','odla'),
						  ('mamo', 'mario@mario.it', password('mario'),'mario','mimo'),
					('ale', 'ale@ale.com', password('ale'), 'ale', 'ela')
;
INSERT INTO ListePreferiti VALUES ('mamo','A',current_timestamp),
								  ('mamo','B',current_timestamp),
                                  ('mamo','C',current_timestamp),
                                  ('adda','piante1',current_timestamp),
                                  ('adda','piante2',current_timestamp),('ale','gigo',current_timestamp), ('ale','nina', current_timestamp),('ale','pinta',current_timestamp)								  
;
INSERT INTO ListePiante VALUES ('Gossypium Herbaceum','mamo','A'),
                               ('Juniperus Communis','mamo','A'),
							   ('Porphyra Tenera','mamo','A'),
                               ('Cedrus Libani','mamo','A'),
							   ('Eucalyptus', 'mamo','B'),
							   ('Melaleuca Alternifolia', 'mamo','B'),
							   ('Eriobotrya Japonica', 'mamo','B'),
							   ('Elaeocarpus Angustifolius','mamo','B'),
                               ('Eucalyptus', 'mamo','C'),
							   ('Eriobotrya Japonica', 'adda','piante1'),
							   ('Elaeocarpus Angustifolius','adda','piante1'),
							   ('Gossypium Herbaceum','adda','piante1'),
                               ('Juniperus Communis', 'adda','piante1'),
							   ('Eriobotrya Japonica', 'adda','piante2'),
							   ('Elaeocarpus Angustifolius','adda','piante2'),
							   ('Gossypium Herbaceum','adda','piante2'),
                               ('Juniperus Communis','adda','piante2'), ('Vallisneria Gigantea','ale','gigo'),('Eucalyptus','ale','gigo'),('Juniperus Communis','ale','gigo'),('Gossypium Herbaceum','ale','gigo')
;

INSERT INTO Stagioni VALUES('IP', 'Inizio', 'Primavera'),
		    	    ('IE', 'Inizio', 'Estate'),
			    ('IA', 'Inizio', 'Autunno'),
 			    ('II', 'Inizio', 'Inverno'),
 			    ('PP', 'Piena', 'Primavera'),
    			    ('PE', 'Piena', 'Estate'),
			    ('PA', 'Pieno', 'Autunno'),
			    ('PI', 'Pieno', 'Inverno'),
			    ('FP', 'Fine', 'Primavera'),
		            ('FE', 'Fine', 'Estate'),
			    ('FA', 'Fine', 'Autunno'),
			    ('FI', 'Fine', 'Inverno')
;


INSERT INTO Semina VALUES('Gossypium Herbaceum', 'IP')
;

INSERT INTO Fioritura VALUES('Gossypium Herbaceum', 'FP'),
				 ('Eriobotrya Japonica','FI'),
                                 ('Elaeocarpus Angustifolius','FP'),
				('Vallisneria Gigantea','IP')
;

INSERT INTO Raccolta VALUES('Gossypium Herbaceum','IE'),		
                             ('Eriobotrya Japonica','PP'),
			    ('Elaeocarpus Angustifolius','FE')
			     
;
INSERT INTO Frutti VALUES(NULL, 'Verde', 'Gossypium Herbaceum'),
						  (NULL, 'Grigio','Eucalyptus'),
                          (NULL, 'Marrone', 'Melaleuca Alternifolia'),
                          ('Nespola del Giappone', 'Arancione', 'Eriobotrya Japonica'),
                          ('Blue Marble', 'Blu', 'Elaeocarpus Angustifolius'),
                          (NULL,'Verde','Vallisneria Gigantea')
;
INSERT INTO Fiori VALUES('Gossypium Herbaceum', NULL, 5, 'Bianco'),
						('Eucalyptus', NULL, NULL, 'Bianco'),
                        ('Melaleuca Alternifolia', NULL, NULL, 'Bianco'),
                        ('Eriobotrya Japonica', NULL, 5, 'Giallo'),
                        ('Elaeocarpus Angustifolius', NULL, 5, 'Bianco'),
                        ('Vallisneria Gigantea', NULL ,NULL,'Verde')
;
INSERT INTO PresenzeA VALUES ('Oceano Indiano', 'Isole Mauritius', 'Porphyra Tenera'),
							 ('Oceano Pacifico', 'Giappone', 'Porphyra Tenera'),
                             ('Oceano Pacifico', 'Cina', 'Porphyra Tenera'),
				             ('Fiume Mississipi', 'Louisiana','Vallisneria Gigantea');
INSERT INTO PresenzeT VALUES('Foresta Monsonica', 'India', 'Gossypium Herbaceum'),
							('Foresta Temperata', 'Germania', 'Juniperus Communis'),
                            ('Foresta Temperata', 'Francia', 'Juniperus Communis'),
                            ('Macchia Mediterranea', 'Libano', 'Cedrus Libani'),
                            ('Macchia Mediterranea', 'Turchia', 'Cedrus Libani'),
                            ('Foresta Temperata', 'Australia', 'Eucalyptus'),
                            ('Foresta Temperata', 'Tasmania', 'Eucalyptus'),
                            ('Foresta Temperata', 'Nuova Guinea', 'Eucalyptus'),
                            ('Foresta Temperata', 'Australia', 'Melaleuca Alternifolia'),
                            ('Foresta Temperata', 'Giappone', 'Eriobotrya Japonica'),
                            ('Foresta Monsonica', 'India', 'Elaeocarpus Angustifolius'),
                            ('Foresta Temperata', 'Nuova Guinea', 'Elaeocarpus Angustifolius'),
                            ('Foresta Temperata', 'Australia', 'Elaeocarpus Angustifolius')
;
INSERT INTO BiomiAcquatici VALUES ('Oceano Indiano', 25, 33, 'OCEAN'),
							      ('Oceano Pacifico', 25, 33, 'OCEAN'),
								  ('Fiume Mississipi', 20, 0,'RIVER');

INSERT INTO BiomiTerrestri VALUES	('Foresta Monsonica', 'Monsonico', 1800, 'Torboso', 'TROP'),
									('Foresta Temperata', 'Temperato', 800, 'Torboso', 'TEMP'),
                                    ('Macchia Mediterranea', 'Mediterraneo', 1000, 'Sabbioso', 'MEDIT')
                                    
;
INSERT INTO Stati VALUES ('India'), ('Germania'), ('Francia'), ('Isole Mauritius'), ('Cina'), ('Giappone'), ('Libano'), ('Turchia'), ('Tasmania'), ('Australia'), ('Nuova Guinea'),
('Louisiana')
;


SET foreign_key_checks = 1; 
