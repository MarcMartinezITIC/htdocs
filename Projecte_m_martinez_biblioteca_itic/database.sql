DROP DATABASE IF EXISTS biblioteca_bd;

CREATE DATABASE biblioteca_bd;
USE biblioteca_bd;

-- Usuaris
CREATE TABLE usuaris (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    contrasenya VARCHAR(255) NOT NULL,
    rol ENUM('soci', 'bibliotecari') NOT NULL
);

-- Autors
CREATE TABLE autors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    biografia TEXT
);

-- Llibres
CREATE TABLE llibres (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titol VARCHAR(200) NOT NULL,
    autor_id INT NOT NULL,
    descripcio TEXT,
    data_publicacio DATE,
    estat ENUM('disponible', 'prestat') DEFAULT 'disponible',
    preu DECIMAL(5,2),
    FOREIGN KEY (autor_id) REFERENCES autors(id) ON DELETE CASCADE ON UPDATE CASCADE
);

-- Prestecs
CREATE TABLE prestecs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuari_id INT NOT NULL,
    llibre_id INT NOT NULL,
    data_prestec DATETIME DEFAULT CURRENT_TIMESTAMP,
    data_retorn DATE,
    estat ENUM('actiu', 'retornat') DEFAULT 'actiu',
    FOREIGN KEY (usuari_id) REFERENCES usuaris(id) ON DELETE CASCADE,
    FOREIGN KEY (llibre_id) REFERENCES llibres(id) ON DELETE CASCADE
);

-- Inserts
-- Inicia sesio amb aquestes dades o  registra't amb el teu correu i una contrasenya
INSERT INTO usuaris (nom, email, contrasenya, rol) VALUES 
('Soci de Prova', 'soci@exemple.com', '$2y$10$exemplehashaqui', 'soci'),
('Bibliotecari de Prova', 'bibliotecari@exemple.com', '$2y$10$exemplehashaqui', 'bibliotecari');

INSERT INTO autors (nom, biografia) VALUES 
('J.K. Rowling', 'Autora britànica, creadora de la saga Harry Potter.'),
('George R.R. Martin', 'Escriptor estatunidenc de fantasia, terror i ciència-ficció.'),
('Brandon Sanderson', 'Escriptor estatunidenc de literatura fantàstica i ciència-ficció.');

INSERT INTO llibres (titol, autor_id, descripcio, data_publicacio, preu) VALUES 
('Harry Potter i la pedra filosofal', 1, 'El primer llibre de la saga Harry Potter.', '1997-06-26', 20.00),
('Harry Potter i la cambra secreta', 1, 'El segon llibre de la saga Harry Potter.', '1998-07-02', 22.50),
('Joc de Trons', 2, 'El primer llibre de Cançó de gel i de foc.', '1996-08-06', 25.00),
('Xoc de Reis', 2, 'El segon llibre de Cançó de gel i de foc.', '1998-11-16', 25.00),
('L\'Imperi Final', 3, 'El primer llibre de la saga Nacidos de la Bruma.', '2006-07-17', 18.90);

INSERT INTO prestecs (usuari_id, llibre_id, data_retorn) VALUES 
(1, 1, '2026-02-15'),
(1, 3, NULL);