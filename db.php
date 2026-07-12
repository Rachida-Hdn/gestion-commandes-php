<?php
/**
 * db.php
 * ------------------------------------------------
 * Fichier de connexion à la base de données
 * "gestion_commandes" en utilisant PDO (MySQL).
 * Ce fichier sera inclus dans toutes les autres pages.
 * ------------------------------------------------
 */

// Informations de connexion (à adapter selon ton environnement)
$host = "localhost";          // Nom du serveur (souvent "localhost")
$dbname = "gestion_commandes"; // Nom de la base de données
$username = "root";           // Nom d'utilisateur MySQL (change si besoin)
$password = "";                // Mot de passe MySQL (change si besoin)

try {
    // Création de l'objet PDO pour se connecter à MySQL
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $username,
        $password
    );

    // Configuration de PDO pour qu'il affiche les erreurs sous forme d'exceptions
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Mode de récupération par défaut : tableau associatif
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    // En cas d'erreur de connexion, on arrête le script et on affiche le message
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}
