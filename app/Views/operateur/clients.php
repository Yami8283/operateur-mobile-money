<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Situation des comptes clients</title>
    <link rel="stylesheet" href="<?= base_url('css/style.css?v=2') ?>">
</head>
<body>

    <nav class="navbar">
        <div class="container">
            <a href="<?= site_url('operateur/clients') ?>" class="navbar-brand">Mobile<span>Money</span></a>
        </div>
    </nav>

    <div class="container">
        <div class="card">
            <h2 class="card-title">Situation des comptes clients</h2>
        </div>

        <?php if (empty($clients)): ?>
            <div class="alert alert-warning">Aucun client trouvé.</div>
        <?php else: ?>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Téléphone</th>
                            <th>Nom</th>
                            <th>Solde</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($clients as $c): ?>
                            <tr>
                                <td><?= $c['id'] ?></td>
                                <td><?= esc($c['phone']) ?></td>
                                <td><?= esc($c['name'] ?? '-') ?></td>
                                <td><?= number_format($c['balance'] / 100, 2) ?> Ar</td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>

        <a href="<?= site_url('operateur/operations') ?>" class="btn btn-light mt-3">Retour aux opérations</a>
    </div>

    <div class="footer">
        Mobile Money &copy; 2026 - Projet S4
    </div>

</body>
</html>