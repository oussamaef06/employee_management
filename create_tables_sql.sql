-- SQL script to create and populate 'utilisateur' and 'employe' tables

-- Create the 'utilisateur' table
CREATE TABLE utilisateur (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    prenom VARCHAR(255) NOT NULL,
    login VARCHAR(255) NOT NULL UNIQUE,
    mot_de_passe LONGTEXT NOT NULL,
    role INT NOT NULL CHECK (role IN (1, 2)) -- 1: Admin, 2: User
);

-- Create the 'employe' table
CREATE TABLE employe (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    prenom VARCHAR(255) NOT NULL,
    mail VARCHAR(255),
    adresse LONGTEXT,
    telephone VARCHAR(50),
    poste INT NOT NULL CHECK (poste IN (1, 2, 3)) -- 1: Gérant, 2: Livreur, 3: Cuisinier
);

-- Insert sample data into 'employe'
INSERT INTO employe (nom, prenom, mail, adresse, telephone, poste) VALUES
('Ali', 'Smith', 'ali.smith@example.com', '123 Main St', '0623456789', 1),
('Sara', 'Johnson', 'sara.johnson@example.com', '456 Oak Ave', '0612345678', 2),
('Mohamed', 'Hadi', 'mohamed.hadi@example.com', '789 Pine Rd', '0678901234', 3);
