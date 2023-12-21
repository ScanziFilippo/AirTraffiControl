CREATE TABLE `parcheggi` (
    id int(11) NOT NULL,
    stato varchar(255),
    aeroporto_icao varchar(255) NOT NULL,
    PRIMARY KEY(`id`, `aeroporto_icao`)
)