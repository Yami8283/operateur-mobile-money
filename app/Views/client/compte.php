<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon compte - Mobile Money</title>
    <link rel="stylesheet" href="<?= base_url('css/style.css?v=2') ?>">
</head>
<body>

    <nav class="navbar">
        <div class="container">
            <a href="<?= site_url('client/compte') ?>" class="navbar-brand">Mobile<span>Money</span></a>
            <a href="<?= site_url('client/logout') ?>" class="btn btn-danger" style="padding:8px 16px;">Déconnexion</a>
        </div>
    </nav>

    <div class="container">
        
        <?php if (session()->has('success')): ?>
            <div class="alert alert-success"><?= session('success') ?></div>
        <?php endif; ?>

        <?php if (session()->has('error')): ?>
            <div class="alert alert-danger"><?= session('error') ?></div>
        <?php endif; ?>

        <div class="card solde-card">
            <p class="solde-label">Solde disponible</p>
            <p class="solde-amount"><?= number_format($balance / 100, 2) ?> Ar</p>
            <p style="opacity:0.8;"><?= esc($client['phone']) ?></p>
        </div>

        <div class="row">
            <div class="col-md-4">
                <a href="<?= site_url('client/depot') ?>" class="btn btn-success btn-block">Dépôt</a>
            </div>
            <div class="col-md-4">
                <a href="<?= site_url('client/retrait') ?>" class="btn btn-warning btn-block">Retrait</a>
            </div>
            <div class="col-md-4">
                <a href="<?= site_url('client/transfert') ?>" class="btn btn-info btn-block">Transfert</a>
            </div>
        </div>

        <a href="<?= site_url('client/historique') ?>" class="btn btn-light btn-block mt-3">Historique</a>

    </div>

    <div class="footer">
        Mobile Money &copy; 2026 - Projet S4
    </div>

</body>
</html>