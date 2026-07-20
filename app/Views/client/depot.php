<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dépôt</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <h2>Faire un dépôt</h2>
            
            <?php if (session()->has('error')): ?>
                <div class="alert alert-danger"><?= session('error') ?></div>
            <?php endif; ?>

            <form action="<?= site_url('client/do-depot') ?>" method="get">
                <div class="mb-3">
                    <label for="amount" class="form-label">Montant (en centimes)</label>
                    <input type="number" class="form-control" id="amount" name="amount" required>
                    <small class="text-muted">Ex: 50000 = 500 Ar</small>
                </div>
                <button type="submit" class="btn btn-success w-100">Déposer</button>
                <a href="<?= site_url('client/compte') ?>" class="btn btn-secondary w-100 mt-2">Retour</a>
            </form>
        </div>
    </div>
</body>
</html>