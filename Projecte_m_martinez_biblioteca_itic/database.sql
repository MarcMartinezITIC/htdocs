DROP DATABASE IF EXISTS biblioteca_bd;

CREATE DATABASE biblioteca_bd;
USE biblioteca_bd;

-- Taula: usuaris
CREATE TABLE usuaris (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    contrasenya VARCHAR(255) NOT NULL,
    rol ENUM('soci', 'bibliotecari') NOT NULL
);

-- Taula: autors
CREATE TABLE autors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    biografia TEXT
);

-- Taula: llibres
CREATE TABLE llibres (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titol VARCHAR(200) NOT NULL,
    autor_id INT NOT NULL,
    descripcio TEXT,
    data_publicacio DATE,
    estat ENUM('disponible', 'prestat') DEFAULT 'disponible',
    preu DECIMAL(5,2),
    FOREIGN KEY (autor_id) REFERENCES autors(id) ON DELETE CASCADE
);

-- Taula: prestecs
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

-- Dades d'exemple (més de 10 registres)
INSERT INTO usuaris (nom, email, contrasenya, rol) VALUES 
('Soci de Prova', 'soci@exemple.com', '$2y$10$exemplehashaqui', 'soci'),  -- hashed 'contrasenya123'
('Bibliotecari de Prova', 'bibliotecari@exemple.com', '$2y$10$exemplehashaqui', 'bibliotecari');

INSERT INTO autors (nom, biografia) VALUES 
('Autor Un', 'Biografia de l\'autor un.'),
('Autor Dos', 'Biografia de l\'autor dos.'),
('Autor Tres', 'Biografia de l\'autor tres.');

INSERT INTO llibres (titol, autor_id, descripcio, data_publicacio, preu) VALUES 
('Llibre 1', 1, 'Descripció del llibre 1.', '2020-01-01', 10.99),
('Llibre 2', 1, 'Descripció del llibre 2.', '2021-02-02', 12.50),
('Llibre 3', 2, 'Descripció del llibre 3.', '2019-03-03', 15.00),
('Llibre 4', 3, 'Descripció del llibre 4.', '2022-04-04', 9.99),
('Llibre 5', 3, 'Descripció del llibre 5.', '2018-05-05', 11.00);

INSERT INTO prestecs (usuari_id, llibre_id, data_retorn) VALUES 
(1, 1, '2026-02-15'),
(1, 2, NULL);