<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Situation des gains</title>
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
            <h2 class="card-title">Situation des gains via les frais</h2>
        </div>

        <!-- Opérateur local -->
        <h4 style="color:#a5b4fc; margin-bottom:10px;">Opérateur local</h4>
        <?php if (empty($gainsLocal)): ?>
            <div class="alert alert-warning">Aucune transaction locale.</div>
        <?php else: ?>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Type</th>
                            <th>Nombre</th>
                            <th>Total frais</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($gainsLocal as $g): ?>
                            <tr>
                                <td><?= esc($g['operation_name']) ?></td>
                                <td><?= $g['nombre'] ?></td>
                                <td><?= number_format($g['total_frais'] / 100, 2) ?> Ar</td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="2">Total local</th>
                            <th><?= number_format($totalLocal / 100, 2) ?> Ar</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        <?php endif; ?>

        <!-- Autres opérateurs -->
        <h4 style="color:#fbbf24; margin: 25px 0 10px;">Autres opérateurs</h4>
        <?php if (empty($gainsAutres)): ?>
            <div class="alert alert-warning">Aucune transaction vers d'autres opérateurs.</div>
        <?php else: ?>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Type</th>
                            <th>Nombre</th>
                            <th>Total frais</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($gainsAutres as $g): ?>
                            <tr>
                                <td><?= esc($g['operation_name']) ?></td>
                                <td><?= $g['nombre'] ?></td>
                                <td><?= number_format($g['total_frais'] / 100, 2) ?> Ar</td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="2">Total autres</th>
                            <th><?= number_format($totalAutres / 100, 2) ?> Ar</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        <?php endif; ?>

        <a href="<?= site_url('operateur/commissions') ?>" class="btn btn-info mt-3">Voir les commissions</a>
        <a href="<?= site_url('operateur/clients') ?>" class="btn btn-light mt-3">Retour aux clients</a>
    </div>

    <div class="footer">
        Mobile Money &copy; 2026 - Projet S4
    </div>

</body>
</html>