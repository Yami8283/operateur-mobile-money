<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Situation des gains</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-4">
    <h2>Situation des gains via les frais</h2>

    <?php if (empty($gains)): ?>
        <div class="alert alert-warning">Aucune transaction pour le moment.</div>
    <?php else: ?>
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Type d'opération</th>
                    <th>Nombre de transactions</th>
                    <th>Total frais perçus</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($gains as $g): ?>
                    <tr>
                        <td><?= esc($g['operation_name']) ?></td>
                        <td><?= $g['nombre'] ?></td>
                        <td><?= number_format($g['total_frais'] / 100, 2) ?> Ar</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot class="table-dark">
                <tr>
                    <th colspan="2">Total général</th>
                    <th><?= number_format($total / 100, 2) ?> Ar</th>
                </tr>
            </tfoot>
        </table>
    <?php endif; ?>

    <a href="<?= site_url('operateur/clients') ?>" class="btn btn-secondary mt-3">← Retour aux clients</a>
</body>
</html>