CREATE TABLE `voli` (
    id int(11) NOT NULL PRIMARY KEY,
    partenza varchar(255),
    destinazione varchar(255),
    data_partenza timestamp,
    data_arrivo timestamp,
    aereo_immatricolazione varchar(255)
)