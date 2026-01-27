
DROP DATABASE IF EXISTS biblioteca;
CREATE DATABASE biblioteca;
USE biblioteca;


CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50) NOT NULL
);


CREATE TABLE usuaris (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    rol ENUM('admin', 'lector') NOT NULL
);


CREATE TABLE llibres (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titol VARCHAR(100) NOT NULL,
    autor VARCHAR(100) NOT NULL,
    id_categoria INT,
    FOREIGN KEY (id_categoria) REFERENCES categories(id) ON DELETE CASCADE
);


CREATE TABLE prestecs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_usuari INT,
    id_libro INT,
    fecha_prestec DATE NOT NULL,
    FOREIGN KEY (id_usuari) REFERENCES usuaris(id),
    FOREIGN KEY (id_libro) REFERENCES llibres(id),
    estat ENUM('pendent', 'retornat') DEFAULT 'pendent'
);

-- Insercio
INSERT INTO categories (nom) VALUES ('Novel·la'), ('Ciència'), ('Història');
INSERT INTO usuaris (nom, email, password, rol) VALUES 
('Admin', 'admin@test.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin'), -- pw: password
('Joan', 'joan@test.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'lector');
INSERT INTO llibres (titol, autor, id_categoria) VALUES 
('Don Quijote', 'Cervantes', 1), ('Sapiens', 'Harari', 2), ('1984', 'Orwell', 1), ('Mundo Anillo', 'Niven', 2), ('Roma', 'Saylor', 3);
INSERT INTO prestecs (id_usuari, id_llibre, data_prestec) VALUES (2, 1, '2023-10-01'), (2, 3, '2023-10-05');