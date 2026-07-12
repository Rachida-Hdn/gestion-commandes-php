<?php
/**
 * add_order.php
 * ------------------------------------------------
 * Formulaire permettant d'ajouter une nouvelle commande.
 * Utilise PDO avec des requêtes préparées pour l'insertion.
 * ------------------------------------------------
 */

require "db.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $client = trim($_POST["client"]);
    $date_commande = trim($_POST["date_commande"]);
    $total = trim($_POST["total"]);
    $statut = trim($_POST["statut"]);

    if ($client !== "" && $date_commande !== "" && $total !== "" && $statut !== "") {

        $sql = "INSERT INTO commandes (client, date_commande, total, statut) 
                VALUES (:client, :date_commande, :total, :statut)";
        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            ":client" => $client,
            ":date_commande" => $date_commande,
            ":total" => $total,
            ":statut" => $statut
        ]);

        // Message de succès demandé
        $message = "Nouvelle commande ajoutée avec succès";
    } else {
        $message = "Veuillez remplir tous les champs.";
    }
}

$page_title = "Ajouter une commande";
require "header.php";
?>

<div class="card">
    <div class="card-header">
        <div class="card-title-block">
            <div class="icon-badge">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
            </div>
            <div>
                <h1>Ajouter une commande</h1>
                <p>Remplissez le formulaire pour créer une nouvelle commande</p>
            </div>
        </div>
    </div>

    <?php if ($message !== ""): ?>
        <div class="message-succes"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>

    <form method="POST" action="add_order.php">
        <label for="client">Client</label>
        <input type="text" id="client" name="client" placeholder="Nom du client" required>

        <label for="date_commande">Date de commande</label>
        <input type="date" id="date_commande" name="date_commande" required>

        <label for="total">Total (DH)</label>
        <input type="number" id="total" name="total" step="0.01" min="0" placeholder="0.00" required>

        <label for="statut">Statut</label>
        <select id="statut" name="statut" required>
            <option value="En attente">En attente</option>
            <option value="Validée">Validée</option>
            <option value="Livrée">Livrée</option>
            <option value="Annulée">Annulée</option>
        </select>

        <br><br>
        <button type="submit" class="btn">Ajouter</button>
        <a href="index.php" class="btn btn-outline">Annuler</a>
    </form>
</div>

<?php require "footer.php"; ?>
