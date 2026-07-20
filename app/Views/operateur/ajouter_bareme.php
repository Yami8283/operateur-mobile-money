<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un barème</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-4">
    <h2>Ajouter un barème de frais</h2>

    <?php if (session()->has('errors')): ?>
        <div class="alert alert-danger">
            <?php foreach (session('errors') as $e): ?>
                <p><?= esc($e) ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form action="<?= site_url('operateur/ajouter-bareme') ?>" method="post">
        <?= csrf_field() ?>

        <div class="mb-3">
            <label for="operation_type_id" class="form-label">Type d'opération</label>
            <select class="form-control" id="operation_type_id" name="operation_type_id" required>
                <option value="">-- Choisir --</option>
                <?php foreach ($operationTypes as $type): ?>
                    <option value="<?= $type['id'] ?>"><?= esc($type['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="min_amount" class="form-label">Montant minimum (en centimes)</label>
            <input type="number" class="form-control" id="min_amount" name="min_amount" required value="0">
        </div>

        <div class="mb-3">
            <label for="max_amount" class="form-label">Montant maximum (en centimes)</label>
            <input type="number" class="form-control" id="max_amount" name="max_amount" required>
            <small class="text-muted">Mettre 1000000000 pour "illimité"</small>
        </div>

        <div class="mb-3">
            <label for="fee_flat" class="form-label">Frais fixe (en centimes)</label>
            <input type="number" class="form-control" id="fee_flat" name="fee_flat" value="0">
        </div>

        <div class="mb-3">
            <label for="fee_percent" class="form-label">Frais en pourcentage (%)</label>
            <input type="number" step="0.1" class="form-control" id="fee_percent" name="fee_percent" value="0">
        </div>

        <button type="submit" class="btn btn-primary">Ajouter</button>
        <a href="<?= site_url('operateur/operations') ?>" class="btn btn-secondary">Retour</a>
    </form>
</body>
</html>