<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transfert - Mobile Money</title>
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
</head>
<body>

    <nav class="navbar">
        <div class="container">
            <a href="<?= site_url('client/compte') ?>" class="navbar-brand">Mobile<span>Money</span></a>
        </div>
    </nav>

    <div class="container">
        <div class="card" style="max-width:500px; margin:0 auto;">
            <h2 class="card-title">Faire un transfert</h2>
            
            <?php if (session()->has('error')): ?>
                <div class="alert alert-danger"><?= session('error') ?></div>
            <?php endif; ?>

            <form action="<?= site_url('client/do-transfert') ?>" method="get">
                <div class="form-group">
                    <label class="form-label">Numéros destinataires</label>
                    <textarea class="form-control" name="destinataires" rows="3" 
                              placeholder="0330000001&#10;0330000002&#10;0330000003" required></textarea>
                    <small style="color:#888;">Un numéro par ligne (même opérateur uniquement)</small>
                </div>
                <div class="form-group">
                    <label class="form-label">Montant total (en centimes)</label>
                    <input type="number" class="form-control" name="amount" required>
                    <small style="color:#888;">Sera divisé équitablement</small>
                </div>
                <button type="submit" class="btn btn-info btn-block">Transférer</button>
                <a href="<?= site_url('client/compte') ?>" class="btn btn-light btn-block">Retour</a>
            </form>
        </div>
    </div>

    <div class="footer">
        Mobile Money &copy; 2026 - Projet S4
    </div>

</body>
</html>