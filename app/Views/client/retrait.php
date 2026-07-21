<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Retrait - Mobile Money</title>
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
            <h2 class="card-title">Faire un retrait</h2>

            <?php if (session()->has('error')): ?>
                <div class="alert alert-danger"><?= session('error') ?></div>
            <?php endif; ?>

            <form action="<?= site_url('client/do-retrait') ?>" method="get">
                <div class="form-group">
                    <label class="form-label">Montant (en centimes)</label>
                    <input type="number" class="form-control" name="amount" required>
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="frais_inclus" name="frais_inclus" value="1">
                    <label for="frais_inclus">Inclure les frais dans le montant</label>
                </div>
                <small>Si coché, le montant reçu sera réduit des frais</small>

                <button type="submit" class="btn btn-warning btn-block mt-3">Retirer</button>
                <a href="<?= site_url('client/compte') ?>" class="btn btn-light btn-block">Retour</a>
            </form>
        </div>
    </div>

    <div class="footer">
        Mobile Money &copy; 2026 - Projet S4
    </div>

</body>
</html>