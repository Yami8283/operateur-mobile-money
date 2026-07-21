<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Configuration frais intra-opérateur</title>
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
            <h2 class="card-title">Frais de transfert intra-opérateur (%)</h2>
        </div>
        <?php if (session()->has('success')): ?>
            <div class="alert alert-success"><?= session('success') ?></div>
        <?php endif; ?>
        <?php foreach ($operators as $op): ?>
            <div class="card">
                <h4><?= esc($op['name']) ?></h4>
                <form action="<?= site_url('operateur/update-intra-fee') ?>" method="post">
                    <?= csrf_field() ?>
                    <input type="hidden" name="operator_id" value="<?= $op['id'] ?>">
                    <div class="form-group">
                        <label>Pourcentage actuel</label>
                        <input type="number" step="0.1" class="form-control" name="intra_fee_percent" value="<?= $op['intra_fee_percent'] ?? 0 ?>">
                    </div>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </form>
            </div>
        <?php endforeach; ?>
        <a href="<?= site_url('operateur/operations') ?>" class="btn btn-light mt-3">Retour</a>
    </div>
    <div class="footer">Mobile Money &copy; 2026</div>
</body>
</html>