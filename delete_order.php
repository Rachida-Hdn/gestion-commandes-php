<?php
/**
 * delete_order.php
 * ------------------------------------------------
 * Supprime une commande de la base de données après confirmation.
 * ------------------------------------------------
 */

require "db.php";

$id = isset($_GET["id"]) ? (int) $_GET["id"] : 0;

if ($id <= 0) {
    header("Location: index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["confirmer"])) {

    $sql = "DELETE FROM commandes WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([":id" => $id]);

    header("Location: index.php");
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM commandes WHERE id = :id");
$stmt->execute([":id" => $id]);
$commande = $stmt->fetch();

if (!$commande) {
    header("Location: index.php");
    exit;
}

$page_title = "Supprimer la commande";
require "header.php";
?>

<div class="card">
    <div class="card-header">
        <div class="card-title-block">
            <div class="icon-badge">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
            </div>
            <div>
                <h1>Supprimer la commande</h1>
                <p>Cette action est irréversible</p>
            </div>
        </div>
    </div>

    <div class="confirm-box">
        <p>
            Êtes-vous sûr de vouloir supprimer la commande
            <strong>#<?php echo htmlspecialchars($commande['id']); ?></strong>
            du client <strong><?php echo htmlspecialchars($commande['client']); ?></strong> ?
        </p>

        <form method="POST" action="delete_order.php?id=<?php echo $commande['id']; ?>">
            <div class="confirm-actions">
                <button type="submit" name="confirmer" value="1" class="btn btn-delete">Oui, supprimer</button>
                <a href="index.php" class="btn btn-outline">Annuler</a>
            </div>
        </form>
    </div>
</div>

<?php require "footer.php"; ?>
