<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Historique - Mobile Money</title>
    <link rel="stylesheet" href="<?= base_url('css/style.css?v=2') ?>">
</head>
<body>

    <nav class="navbar">
        <div class="container">
            <a href="<?= site_url('client/compte') ?>" class="navbar-brand">Mobile<span>Money</span></a>
        </div>
    </nav>

    <div class="container">
        <div class="card">
            <h2 class="card-title">Historique des transactions</h2>
            <p style="color:#888;">Compte : <strong><?= esc($client['phone']) ?></strong></p>
        </div>

        <?php if (empty($transactions)): ?>
            <div class="alert alert-warning">Aucune transaction pour le moment.</div>
        <?php else: ?>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Type</th>
                            <th>Expéditeur</th>
                            <th>Destinataire</th>
                            <th>Montant</th>
                            <th>Frais</th>
                            <th>Réf.</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($transactions as $t): ?>
                            <tr>
                                <td><?= date('d/m H:i', strtotime($t['created_at'])) ?></td>
                                <td>
                                    <?php if ($t['operation_name'] == 'Dépôt'): ?>
                                        <span class="badge badge-success">Dépôt</span>
                                    <?php elseif ($t['operation_name'] == 'Retrait'): ?>
                                        <span class="badge badge-warning">Retrait</span>
                                    <?php else: ?>
                                        <span class="badge badge-info">Transfert</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= $t['from_phone'] ? esc($t['from_phone']) : '-' ?></td>
                                <td><?= $t['to_phone'] ? esc($t['to_phone']) : '-' ?></td>
                                <td><?= number_format($t['amount'] / 100, 2) ?> Ar</td>
                                <td><?= number_format($t['fee'] / 100, 2) ?> Ar</td>
                                <td><small><?= esc($t['reference']) ?></small></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>

        <a href="<?= site_url('client/compte') ?>" class="btn btn-light btn-block mt-3">Retour au compte</a>
    </div>

    <div class="footer">
        Mobile Money &copy; 2026 - Projet S4
    </div>

</body>
</html>