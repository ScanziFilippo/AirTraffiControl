CREATE TABLE `aerei` (
    immatricolazione varchar(255) NOT NULL PRIMARY KEY,
    modello varchar(255),
    compagnia varchar(255),
    passeggeri int(11),
    foto_aereo varchar(255),
    foto_compagnia varchar(255),
    posizione varchar(255),
    stato varchar(255),
    pista_id int(11),
    parcheggio_id int(11),
    aeroporto_icao varchar(255)
)