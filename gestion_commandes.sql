-- ============================================
-- Script SQL : Base de données "gestion_commandes"
-- ============================================

-- Création de la base de données (si elle n'existe pas déjà)
CREATE DATABASE IF NOT EXISTS gestion_commandes CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Sélection de la base de données
USE gestion_commandes;

-- Création de la table "commandes"
CREATE TABLE IF NOT EXISTS commandes (
    id INT AUTO_INCREMENT PRIMARY KEY,       -- Identifiant unique de la commande
    client VARCHAR(100) NOT NULL,            -- Nom du client
    date_commande DATE NOT NULL,             -- Date de la commande
    total DECIMAL(10,2) NOT NULL,            -- Montant total de la commande
    statut VARCHAR(50) NOT NULL              -- Statut de la commande (En attente, Validée, Livrée, Annulée...)
) ENGINE=InnoDB;

-- Quelques données de test (optionnel)
INSERT INTO commandes (client, date_commande, total, statut) VALUES
('Ahmed Benali', '2026-07-01', 450.00, 'En attente'),
('Fatima Zahra', '2026-07-03', 1200.50, 'Validée'),
('Youssef El Amrani', '2026-07-05', 320.75, 'Livrée');
