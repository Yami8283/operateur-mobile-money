<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Types d'opérations et barèmes</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-4">
    <h2>Types d'opérations et barèmes de frais</h2>
    <a href="<?= site_url('operateur/ajouter-bareme') ?>" class="btn btn-primary mb-3">+ Ajouter un barème</a>
    <?php if (session()->has('success')): ?>
    <div class="alert alert-success"><?= session('success') ?></div>
<?php endif; ?>

    <?php if (empty($groupedBands)): ?>
        <div class="alert alert-warning">Aucun barème défini pour le moment.</div>
    <?php else: ?>
        <?php foreach ($groupedBands as $opName => $bands): ?>
            <h4 class="mt-4"><?= esc($opName) ?></h4>
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Montant min</th>
                        <th>Montant max</th>
                        <th>Frais fixe</th>
                        <th>Frais (%)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($bands as $b): ?>
                        <tr>
                            <td><?= number_format($b['min_amount'] / 100, 2) ?> Ar</td>
                            <td><?= $b['max_amount'] >= 1000000000 ? 'Illimité' : number_format($b['max_amount'] / 100, 2) . ' Ar' ?></td>
                            <td><?= number_format($b['fee_flat'] / 100, 2) ?> Ar</td>
                            <td><?= $b['fee_percent'] ?>%</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endforeach; ?>
    <?php endif; ?>

    <a href="<?= site_url('operateur/prefixes') ?>" class="btn btn-secondary mt-3">← Retour aux préfixes</a>
</body>
</html>