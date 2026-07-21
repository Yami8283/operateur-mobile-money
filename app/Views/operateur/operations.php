<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Types d'opérations et barèmes</title>
    <link rel="stylesheet" href="<?= base_url('css/style.css?v=2') ?>">
</head>
<body>

    <nav class="navbar">
        <div class="container">
            <a href="<?= site_url('operateur/operations') ?>" class="navbar-brand">Mobile<span>Money</span></a>
        </div>
    </nav>

    <div class="container">
        <div class="card">
            <h2 class="card-title">Types d'opérations et barèmes de frais</h2>
        </div>

        <a href="<?= site_url('operateur/ajouter-bareme') ?>" class="btn btn-primary mb-3">+ Ajouter un barème</a>

        <?php if (session()->has('success')): ?>
            <div class="alert alert-success"><?= session('success') ?></div>
        <?php endif; ?>

        <?php if (empty($groupedBands)): ?>
            <div class="alert alert-warning">Aucun barème défini.</div>
        <?php else: ?>
            <?php foreach ($groupedBands as $opName => $bands): ?>
                <h4 style="color:#a5b4fc; margin-top:25px;"><?= esc($opName) ?></h4>
                <div class="table-container">
                    <table>
                        <thead>
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
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <a href="<?= site_url('operateur/prefixes') ?>" class="btn btn-light mt-3">Retour aux préfixes</a>
    </div>

    <div class="footer">
        Mobile Money &copy; 2026 - Projet S4
    </div>

</body>
</html>