# AirTraffiControl
## Descrizione
Applicazione web per il controllo del traffico di uno spazio aereo con aeroporto: aerei generati casualmente o manualmente, l'utente comanda ad essi l'azione da fare (atterrare, decollare, rullare al parcheggio, aspettare in coda, rifornirsi di carburante, passeggeri).
## Che problema risolve?
La lenta velocità che hanno i controllori di volo utilizzando dei fogli per annotarsi le informazioni che vanno spesso aggiornate, come la posizione, di ogni singolo volo.
## A chi è rivolta?
Alle torri di controllo di qualsiasi tipo di aereporto 
## Tecnologie usate
- HTML
- JavaScript
- mySQL
- PHP
## Funzionalità
* Aeroporto
  * Registazione del profilo dell'aeroporto
    * <a href="https://it.wikipedia.org/wiki/Codice_aeroportuale_ICAO">ICAO</a> o <a href="https://en.wikipedia.org/wiki/IATA_airport_code">IATA</a>
    * Password
  * Accesso al profilo 
  * Uscita dal profilo
  * Recupero profilo se la password è stata smarrita
  * Parcheggi
    * Modifica numero
  * Piste
    * Aggiungi
    * Modifica
    * Elimina
* Aereo
  * Aggiunta manuale dei dati
    * <a href="https://it.wikipedia.org/wiki/Marche_d%27immatricolazione">Immatricolazione aereo</a>
    * Modello aereo
    * Compagnia
    * Passeggeri
    * Percentuale di carburante
    * Foto aggiunta automaticamente in base al modello
    * Posizione
    * Stato
  * Aggiunta casuale
  * Modifica
  * Eliminazione
  * Comandi
    * Decolla su pista XX
    * Atterra su pista XX
    * Rulla verso pista XX
    * Rulla verso parcheggio XX
    * Rifornisciti di carburante
    * Fai scendere/salire le persone
## Interfaccia
![alt text](interfacciaWEB.png)
## Schema ER
![alt text](ERN.jpg)
## Relazioni
AEROPORTO (<ins>ICAO</ins>, IATA, PASSWORD) <br>
AEREO (<ins>IMMATRICOLAZIONE</ins>, MODELLO, COMPAGNIA, PASSEGGERI, FOTO_AEREO, BANDIERA, FOTO_COMPAGNIA, POSIZIONE, STATO) <br>
PISTA (<ins>ID</ins>, STATO) <br>
PARCHEGGIO (<ins>ID</ins>, STATO) <br>
VOLO (<ins>ID</ins>, PARTENZA, DESTINAZIONE, DATA_PARTENZA, DATA_ARRIVO) <br>
