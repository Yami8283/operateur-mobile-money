<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dépôt - Mobile Money</title>
    <link rel="stylesheet" href="<?= base_url('css/style.css?v=2') ?>">
</head>
<body>

    <nav class="navbar">
        <div class="container">
            <a href="<?= site_url('client/compte') ?>" class="navbar-brand">Mobile<span>Money</span></a>
        </div>
    </nav>

    <div class="container">
        <div class="card" style="max-width:450px; margin:0 auto;">
            <h2 class="card-title">Faire un dépôt</h2>

            <?php if (session()->has('error')): ?>
                <div class="alert alert-danger"><?= session('error') ?></div>
            <?php endif; ?>

            <form action="<?= site_url('client/do-depot') ?>" method="get">
                <div class="form-group">
                    <label class="form-label">Montant (en centimes)</label>
                    <input type="number" class="form-control" name="amount" placeholder="Ex: 50000 = 500 Ar" required>
                </div>
                <button type="submit" class="btn btn-success btn-block">Déposer</button>
                <a href="<?= site_url('client/compte') ?>" class="btn btn-light btn-block">Retour</a>
            </form>
        </div>
    </div>

    <div class="footer">
        Mobile Money &copy; 2026 - Projet S4
    </div>

</body>
</html>