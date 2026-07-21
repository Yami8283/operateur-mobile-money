<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mon Épargne</title>
    <link rel="stylesheet" href="<?= base_url('css/style.css?v=2') ?>">
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <a href="<?= site_url('client/compte') ?>" class="navbar-brand">Mobile<span>Money</span></a>
        </div>
    </nav>
    <div class="container">
        <div class="card solde-card">
            <p class="solde-label">Épargne disponible</p>
            <p class="solde-amount"><?= number_format(($savings['amount'] ?? 0) / 100, 2) ?> Ar</p>
            <p style="opacity:0.8;">Taux d'intérêt : <?= $savings['interest_rate'] ?? 0 ?>%</p>
        </div>
        <?php if (session()->has('error')): ?>
            <div class="alert alert-danger"><?= session('error') ?></div>
        <?php endif; ?>
        <?php if (session()->has('success')): ?>
            <div class="alert alert-success"><?= session('success') ?></div>
        <?php endif; ?>
        <div class="card">
            <form action="<?= site_url('client/do-epargne') ?>" method="get">
                <div class="form-group">
                    <label class="form-label">Montant à épargner (en centimes)</label>
                    <input type="number" class="form-control" name="amount" required>
                </div>
                <button type="submit" class="btn btn-success btn-block">Épargner</button>
            </form>
        </div>
        <a href="<?= site_url('client/compte') ?>" class="btn btn-light btn-block">Retour au compte</a>
    </div>
</body>
</html>