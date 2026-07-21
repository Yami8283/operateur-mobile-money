<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Commissions - Mobile Money</title>
    <link rel="stylesheet" href="<?= base_url('css/style.css?v=2') ?>">
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <a href="<?= site_url('operateur/gains') ?>" class="navbar-brand">Mobile<span>Money</span></a>
        </div>
    </nav>

    <div class="container">
        <div class="card">
            <h2 class="card-title">Montants à envoyer à chaque opérateur</h2>
        </div>

        <?php if (empty($commissions)): ?>
            <div class="alert alert-warning">Aucun transfert vers d'autres opérateurs.</div>
        <?php else: ?>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Opérateur</th>
                            <th>Transferts</th>
                            <th>Total transféré</th>
                            <th>Commission (%)</th>
                            <th>Montant commission</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($commissions as $c): 
                            $montantCommission = $c['total_transfere'] * ($c['commission_percent'] / 100);
                        ?>
                            <tr>
                                <td><?= esc($c['operateur_name']) ?></td>
                                <td><?= $c['nombre'] ?></td>
                                <td><?= number_format($c['total_transfere'] / 100, 2) ?> Ar</td>
                                <td><?= $c['commission_percent'] ?>%</td>
                                <td><?= number_format($montantCommission / 100, 2) ?> Ar</td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>

        <a href="<?= site_url('operateur/gains') ?>" class="btn btn-light btn-block mt-3">Retour aux gains</a>
    </div>

    <div class="footer">
        Mobile Money &copy; 2026 - Projet S4
    </div>
</body>
</html>