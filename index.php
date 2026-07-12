<?php
/**
 * index.php
 * ------------------------------------------------
 * Affiche la liste de toutes les commandes dans un tableau
 * avec des liens "Modifier" et "Supprimer" pour chaque commande,
 * et un bouton "Ajouter une commande".
 * ------------------------------------------------
 */

require "db.php";

// Requête pour récupérer toutes les commandes, triées par id décroissant
$stmt = $pdo->query("SELECT * FROM commandes ORDER BY id DESC");
$commandes = $stmt->fetchAll();

// Titre de la page (utilisé dans header.php)
$page_title = "Liste des commandes";

/**
 * Fonction utilitaire : retourne la classe CSS du badge
 * selon le statut de la commande.
 */
function classeBadge($statut) {
    switch ($statut) {
        case "En attente": return "badge-attente";
        case "Validée":     return "badge-validee";
        case "Livrée":      return "badge-livree";
        case "Annulée":     return "badge-annulee";
        default:            return "badge-attente";
    }
}

require "header.php";
?>

<div class="card">
    <div class="card-header">
        <div class="card-title-block">
            <div class="icon-badge">
                <!-- Icône presse-papiers -->
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path><rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect></svg>
            </div>
            <div>
                <h1>Liste des commandes</h1>
                <p><?php echo count($commandes); ?> commande(s) au total</p>
            </div>
        </div>
        <a href="add_order.php" class="btn">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
            Ajouter une commande
        </a>
    </div>

    <table>
        <thead>
            <tr>
                <th>Numéro de commande</th>
                <th>Client</th>
                <th>Date de commande</th>
                <th>Total</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($commandes) > 0): ?>
                <?php foreach ($commandes as $commande): ?>
                    <tr>
                        <td class="numero">#<?php echo htmlspecialchars($commande['id']); ?></td>
                        <td><?php echo htmlspecialchars($commande['client']); ?></td>
                        <td><?php echo htmlspecialchars($commande['date_commande']); ?></td>
                        <td class="total"><?php echo htmlspecialchars(number_format($commande['total'], 2)); ?> DH</td>
                        <td>
                            <span class="badge <?php echo classeBadge($commande['statut']); ?>">
                                <?php echo htmlspecialchars($commande['statut']); ?>
                            </span>
                        </td>
                        <td>
                            <div class="actions">
                                <a href="edit_order.php?id=<?php echo $commande['id']; ?>" class="btn btn-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                    Modifier
                                </a>
                                <a href="delete_order.php?id=<?php echo $commande['id']; ?>" class="btn btn-sm btn-delete"
                                   onclick="return confirm('Voulez-vous vraiment supprimer cette commande ?');">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                                    Supprimer
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="empty-state">Aucune commande trouvée.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require "footer.php"; ?>
