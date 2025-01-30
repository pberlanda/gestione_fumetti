DROP TABLE IF EXISTS fumetti;
DROP TABLE IF EXISTS utenti;

CREATE TABLE fumetti (
    CODICE VARCHAR(5) NOT NULL,
    DESCRIZIONE VARCHAR(30) NOT NULL,
    
    CONSTRAINT PK_fumetto PRIMARY KEY (CODICE)
    
    );

CREATE TABLE utenti (
    username VARCHAR(30) NOT NULL,
    password VARCHAR(255) NOT NULL,
    
    CONSTRAINT PK_utenti PRIMARY KEY (username)
    
    )