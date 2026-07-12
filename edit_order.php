<?php
/**
 * edit_order.php
 * ------------------------------------------------
 * Formulaire pré-rempli permettant de modifier une commande existante.
 * Utilise PDO avec des requêtes préparées pour la sélection et la mise à jour.
 * ------------------------------------------------
 */

require "db.php";

$message = "";
$commande = null;

$id = isset($_GET["id"]) ? (int) $_GET["id"] : (isset($_POST["id"]) ? (int) $_POST["id"] : 0);

if ($id <= 0) {
    header("Location: index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $client = trim($_POST["client"]);
    $date_commande = trim($_POST["date_commande"]);
    $total = trim($_POST["total"]);
    $statut = trim($_POST["statut"]);

    if ($client !== "" && $date_commande !== "" && $total !== "" && $statut !== "") {

        $sql = "UPDATE commandes 
                SET client = :client, date_commande = :date_commande, total = :total, statut = :statut 
                WHERE id = :id";
        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            ":client" => $client,
            ":date_commande" => $date_commande,
            ":total" => $total,
            ":statut" => $statut,
            ":id" => $id
        ]);

        // Message de succès demandé
        $message = "Commande mise à jour avec succès";
    } else {
        $message = "Veuillez remplir tous les champs.";
    }
}

$stmt = $pdo->prepare("SELECT * FROM commandes WHERE id = :id");
$stmt->execute([":id" => $id]);
$commande = $stmt->fetch();

if (!$commande) {
    header("Location: index.php");
    exit;
}

$page_title = "Modifier la commande";
require "header.php";
?>

<div class="card">
    <div class="card-header">
        <div class="card-title-block">
            <div class="icon-badge">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
            </div>
            <div>
                <h1>Modifier la commande #<?php echo htmlspecialchars($commande['id']); ?></h1>
                <p>Mettez à jour les informations de la commande</p>
            </div>
        </div>
    </div>

    <?php if ($message !== ""): ?>
        <div class="message-succes"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>

    <form method="POST" action="edit_order.php">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($commande['id']); ?>">

        <label for="client">Client</label>
        <input type="text" id="client" name="client"
               value="<?php echo htmlspecialchars($commande['client']); ?>" required>

        <label for="date_commande">Date de commande</label>
        <input type="date" id="date_commande" name="date_commande"
               value="<?php echo htmlspecialchars($commande['date_commande']); ?>" required>

        <label for="total">Total (DH)</label>
        <input type="number" id="total" name="total" step="0.01" min="0"
               value="<?php echo htmlspecialchars($commande['total']); ?>" required>

        <label for="statut">Statut</label>
        <select id="statut" name="statut" required>
            <?php
            $statuts = ["En attente", "Validée", "Livrée", "Annulée"];
            foreach ($statuts as $s) {
                $selected = ($commande['statut'] === $s) ? "selected" : "";
                echo "<option value=\"$s\" $selected>$s</option>";
            }
            ?>
        </select>

        <br><br>
        <button type="submit" class="btn">Enregistrer les modifications</button>
    </form>

    <!-- Lien "Liste des commandes" demandé -->
    <a href="index.php" class="retour">← Liste des commandes</a>
</div>

<?php require "footer.php"; ?>
