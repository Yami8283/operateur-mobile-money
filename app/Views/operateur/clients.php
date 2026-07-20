<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Situation des comptes clients</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-4">
    <h2>Situation des comptes clients</h2>

    <?php if (empty($clients)): ?>
        <div class="alert alert-warning">Aucun client trouvé.</div>
    <?php else: ?>
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
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
    <?php endif; ?>

    <a href="<?= site_url('operateur/operations') ?>" class="btn btn-secondary mt-3">← Retour aux opérations</a>
</body>
</html>