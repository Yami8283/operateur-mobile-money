<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mon compte</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2>Mon compte</h2>
            
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title"><?= esc($client['phone']) ?></h5>
                    <p class="card-text">
                        Solde : <strong><?= number_format($balance / 100, 2) ?> Ar</strong>
                    </p>
                </div>
            </div>

            <div class="d-grid gap-2">
                <a href="<?= site_url('client/depot') ?>" class="btn btn-success">Faire un dépôt</a>
                <a href="<?= site_url('client/retrait') ?>" class="btn btn-warning">Faire un retrait</a>
                <a href="<?= site_url('client/transfert') ?>" class="btn btn-info">Faire un transfert</a>
                <a href="<?= site_url('client/historique') ?>" class="btn btn-secondary">Voir l'historique</a>
                <a href="<?= site_url('client/logout') ?>" class="btn btn-danger">Déconnexion</a>
            </div>
        </div>
    </div>
</body>
</html>