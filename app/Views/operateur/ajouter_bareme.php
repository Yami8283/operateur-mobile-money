<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un barème</title>
    <link rel="stylesheet" href="<?= base_url('css/style.css?v=2') ?>">
</head>
<body>

    <nav class="navbar">
        <div class="container">
            <a href="<?= site_url('operateur/operations') ?>" class="navbar-brand">Mobile<span>Money</span></a>
        </div>
    </nav>

    <div class="container">
        <div class="card" style="max-width:500px; margin:0 auto;">
            <h2 class="card-title">Ajouter un barème de frais</h2>

            <?php if (session()->has('errors')): ?>
                <div class="alert alert-danger">
                    <?php foreach (session('errors') as $e): ?>
                        <p><?= esc($e) ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <form action="<?= site_url('operateur/ajouter-bareme') ?>" method="post">
                <?= csrf_field() ?>

                <div class="form-group">
                    <label class="form-label">Type d'opération</label>
                    <select class="form-control" name="operation_type_id" required>
                        <option value="">-- Choisir --</option>
                        <?php foreach ($operationTypes as $type): ?>
                            <option value="<?= $type['id'] ?>"><?= esc($type['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Montant minimum (en centimes)</label>
                    <input type="number" class="form-control" name="min_amount" required value="0">
                </div>

                <div class="form-group">
                    <label class="form-label">Montant maximum (en centimes)</label>
                    <input type="number" class="form-control" name="max_amount" required>
                    <small>Mettre 1000000000 pour "illimité"</small>
                </div>

                <div class="form-group">
                    <label class="form-label">Frais fixe (en centimes)</label>
                    <input type="number" class="form-control" name="fee_flat" value="0">
                </div>

                <div class="form-group">
                    <label class="form-label">Frais en pourcentage (%)</label>
                    <input type="number" step="0.1" class="form-control" name="fee_percent" value="0">
                </div>

                <button type="submit" class="btn btn-primary btn-block">Ajouter</button>
                <a href="<?= site_url('operateur/operations') ?>" class="btn btn-light btn-block">Retour</a>
            </form>
        </div>
    </div>

    <div class="footer">
        Mobile Money &copy; 2026 - Projet S4
    </div>

</body>
</html>