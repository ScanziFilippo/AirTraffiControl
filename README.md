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
    * <a href="https://it.wikipedia.org/wiki/Codice_aeroportuale_ICAO">ICAO</a> e <a href="https://en.wikipedia.org/wiki/IATA_airport_code">IATA (se esistente)</a>
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
    * Foto aereo
    * Foto bandiera (automatico in base all'immatricolazione)
    * Posizione
    * Stato (automatico in base a posizione inizialmente. Poi modificato in base alle azioni utente)
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
### Accesso
![alt text](IMG/ACCESSO.svg)
### Sala di controllo
![alt text](IMG/SALACONTROLLO.svg)
### Aggiunta aereo
![alt text](IMG/AEREO.svg)
### Profilo
![alt text](IMG/PROFILO.svg)

## Schema ER
![alt text](IMG/ERN.jpg)
## Relazioni
AEROPORTO (<ins>ICAO</ins>, IATA) <br>
CONTROLLORE (<ins>ID</ins>, <ins>NOME_UTENTE</ins>, CODICE, AMMINISTRATORE?, AEROPORTO_ICAO) <br>
AEREO (<ins>IMMATRICOLAZIONE</ins>, MODELLO, COMPAGNIA, PASSEGGERI, FOTO_AEREO, BANDIERA, FOTO_COMPAGNIA, POSIZIONE, STATO, PISTA_ID, PARCHEGGIO_ID, AEROPORTO_ID) <br>
PISTA (<ins>ID</ins>, STATO, AEROPORTO_ID) <br>
PARCHEGGIO (<ins>ID</ins>, STATO, AEROPORTO_ID) <br>
VOLO (<ins>ID</ins>, PARTENZA, DESTINAZIONE, DATA_PARTENZA, DATA_ARRIVO, AEREO_ID) <br>
