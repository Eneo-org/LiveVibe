CREATE DATABASE eventi;
USE eventi;

CREATE TABLE categoria (
    IdCategoria INT PRIMARY KEY AUTO_INCREMENT,
    descrizione VARCHAR(255) NOT NULL
);

CREATE TABLE artista (
    IdArtista INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(64) NOT NULL,
    cognome VARCHAR(64) NOT NULL,
    nomeDarte VARCHAR(64) NOT NULL,
);

CREATE TABLE utente (
    IdUtente INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(64) UNIQUE NOT NULL,
    nome VARCHAR(64) NOT NULL,
    cognome VARCHAR(64) NOT NULL,
    email VARCHAR(64) NOT NULL,
    password VARCHAR(64) NOT NULL,
    codiceUnivoco VARCHAR(64),
);

CREATE TABLE commento (
    IdCommento INT PRIMARY KEY AUTO_INCREMENT,
    voto int not null  CHECK (voto >= 1 AND voto <= 5),
    descrizione TEXT,
    IdUtente INT,
    IdEvento INT,
    FOREIGN KEY (IdUtente) REFERENCES utente(IdUtente),
    FOREIGN KEY (IdEvento) REFERENCES Evento(IdEvento)
);

CREATE TABLE evento (
    IdEvento INT PRIMARY KEY AUTO_INCREMENT,
    immagine VARCHAR(255),
    data DATE,
    ora TIME,
    titolo VARCHAR(100),
    luogo VARCHAR(100),
    IdCategoria INT,
    IdArtista INT,
    FOREIGN KEY (IdCategoria) REFERENCES Categoria(IdCategoria),
    FOREIGN KEY (IdArtista) REFERENCES artista(IdArtista)
);
-- Inserimento delle categorie degli eventi
INSERT INTO categoria (descrizione) VALUES 
('Concerti'),
('Mostre'),
('Fiere'),
('Conferenze'),
('Spettacoli teatrali');

-- Inserimento degli eventi
-- Categoria: Concert

INSERT INTO evento (immagine, data, ora, titolo, luogo, via, numeroCivico, cap, IdCategoria)
VALUES ('nasong.jpg', '2026-04-16', '21:00:00', 'Inaugurazione miglior nasone del mondo', 'nel puzzo', 'via sandrong', '13', '03044', 6);

INSERT INTO evento (immagine, data, ora, titolo, luogo, via, numeroCivico, cap, IdCategoria)
VALUES ('darioMoccia.jpg', '2024-04-16', '21:00:00', 'Il moccione vuole incontrarti', 'scampia', 'via dal membro', '13', '03044', 6);


INSERT INTO evento (immagine, data, ora, titolo, luogo, via, numeroCivico, cap, IdCategoria)
VALUES ('concerto1.jpg', '2024-05-10', '20:00:00', 'Concerto Jazz in Piazza', 'Piazza Garibaldi', 'Via Roma', '12', '00100', 1);

INSERT INTO evento (immagine, data, ora, titolo, luogo, via, numeroCivico, cap, IdCategoria)
VALUES ('concerto2.jpg', '2024-06-15', '19:30:00', 'Festival Rock Summer Jam', 'Parco della Musica', 'Viale delle Idee', '5', '00123', 1);

-- Categoria: Mostre
INSERT INTO evento (immagine, data, ora, titolo, luogo, via, numeroCivico, cap, IdCategoria)
VALUES ('mostra1.jpg', '2024-07-20', '10:00:00', 'Mostra d\'Arte Contemporanea', 'Galleria Moderna', 'Via degli Artisti', '8', '00145', 2);

INSERT INTO evento (immagine, data, ora, titolo, luogo, via, numeroCivico, cap, IdCategoria)
VALUES ('mostra2.jpg', '2024-08-25', '11:30:00', 'Esposizione Fotografica Vintage', 'Museo Fotografico', 'Via del Cinema', '20', '00156', 2);

-- Categoria: Fiere
INSERT INTO evento (immagine, data, ora, titolo, luogo, via, numeroCivico, cap, IdCategoria)
VALUES ('fiera1.jpg', '2024-09-15', '09:00:00', 'Fiera del Libro', 'Centro Congressi', 'Piazza del Sapere', '30', '00134', 3);

INSERT INTO evento (immagine, data, ora, titolo, luogo, via, numeroCivico, cap, IdCategoria)
VALUES ('fiera2.jpg', '2024-10-20', '10:30:00', 'Fiera del Turismo', 'Fiera di Roma', 'Via dell\'Avventura', '50', '00148', 3);

-- Categoria: Conferenze
INSERT INTO evento (immagine, data, ora, titolo, luogo, via, numeroCivico, cap, IdCategoria)
VALUES ('conferenza1.jpg', '2024-11-05', '14:00:00', 'Conferenza sul Futuro della Tecnologia', 'Centro Convegni', 'Via della Scienza', '15', '00167', 4);

INSERT INTO evento (immagine, data, ora, titolo, luogo, via, numeroCivico, cap, IdCategoria)
VALUES ('conferenza2.jpg', '2024-12-10', '16:30:00', 'Conferenza sull\'Ambiente', 'Auditorium Verde', 'Piazza Ecologica', '2', '00189', 4);

-- Categoria: Spettacoli teatrali
INSERT INTO evento (immagine, data, ora, titolo, luogo, via, numeroCivico, cap, IdCategoria)
VALUES ('spettacolo1.jpg', '2025-01-15', '20:30:00', 'Commedia Musicale "Il Mago di Oz"', 'Teatro delle Marionette', 'Via delle Favole', '10', '00123', 5);

INSERT INTO evento (immagine, data, ora, titolo, luogo, via, numeroCivico, cap, IdCategoria)
VALUES ('spettacolo2.jpg', '2025-02-20', '19:00:00', 'Dramma Classico "Edipo Re"', 'Teatro Antico', 'Via dei Tragici', '3', '00156', 5);

-- Aggiornamento degli eventi con l'ID dell'artista corrispondente
UPDATE evento SET IdArtista = 1 WHERE IdEvento = 1; -- Associa l'evento 1 all'artista 1 (John Doe)
UPDATE evento SET IdArtista = 2 WHERE IdEvento = 2; -- Associa l'evento 2 all'artista 2 (Alice Smith)
UPDATE evento SET IdArtista = 3 WHERE IdEvento = 3; -- Associa l'evento 3 all'artista 3 (Bob Johnson)
UPDATE evento SET IdArtista = 4 WHERE IdEvento = 4; -- Associa l'evento 4 all'artista 4 (Emily Brown)
UPDATE evento SET IdArtista = 5 WHERE IdEvento = 5; -- Associa l'evento 5 all'artista 5 (Michael Williams)
UPDATE evento SET IdArtista = 6 WHERE IdEvento = 6; -- Associa l'evento 6 all'artista 6 (Sophia Jones)
UPDATE evento SET IdArtista = 1 WHERE IdEvento = 7; -- Associa l'evento 7 all'artista 1 (John Doe)
UPDATE evento SET IdArtista = 2 WHERE IdEvento = 8; -- Associa l'evento 8 all'artista 2 (Alice Smith)
UPDATE evento SET IdArtista = 3 WHERE IdEvento = 9; -- Associa l'evento 9 all'artista 3 (Bob Johnson)
UPDATE evento SET IdArtista = 4 WHERE IdEvento = 10; -- Associa l'evento 10 all'artista 4 (Emily Brown)

-- Inserimento degli artisti con i nomi
INSERT INTO artista (nome, cognome, nomeDarte) VALUES 
('John', 'Doe', 'John Doe Art'),
('Alice', 'Smith', 'Alice Smith Art'),
('Bob', 'Johnson', 'Bob Johnson Art'),
('Emily', 'Brown', 'Emily Brown Art'),
('Michael', 'Williams', 'Michael Williams Art'),
('Sophia', 'Jones', 'Sophia Jones Art');

INSERT INTO artista (nome, cognome, nomeDarte) VALUES 
('dario', 'moccia', 'Barbatus'),
('mario', 'sturniolo', 'Mariong');

UPDATE evento SET IdArtista = 7 WHERE IdEvento = 12; 
UPDATE evento SET IdArtista = 8 WHERE IdEvento = 11; 

--aggiunta fk
ALTER TABLE evento 
ADD COLUMN IdUtente INT;

-- Aggiungi la foreign key alla colonna IdUtente
ALTER TABLE evento
ADD CONSTRAINT FK_Evento_Utente
FOREIGN KEY (IdUtente) REFERENCES utente(IdUtente);

INSERT INTO artista (nome, cognome, nomeDarte) VALUES ('nessuno', 'nessuno','nessuno');
INSERT INTO artista (nome, cognome, nomeDarte) VALUES ('altro','altro','altro');


php_value upload_max_filesize 20M
php_value post_max_size 20M
php_value max_execution_time 300
php_value max_input_time 300