<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un préfixe</title>
    <link rel="stylesheet" href="<?= base_url('css/style.css?v=2') ?>">
</head>
<body>

    <nav class="navbar">
        <div class="container">
            <a href="<?= site_url('operateur/prefixes') ?>" class="navbar-brand">Mobile<span>Money</span></a>
        </div>
    </nav>

    <div class="container">
        <div class="card" style="max-width:500px; margin:0 auto;">
            <h2 class="card-title">Ajouter un préfixe</h2>

            <?php if (session()->has('errors')): ?>
                <div class="alert alert-danger">
                    <?php foreach (session('errors') as $e): ?>
                        <p><?= esc($e) ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <form action="<?= site_url('operateur/ajouter-prefixe') ?>" method="post">
                <?= csrf_field() ?>
                <div class="form-group">
                    <label class="form-label">Opérateur</label>
                    <select class="form-control" name="operator_id" required>
                        <option value="">-- Choisir un opérateur --</option>
                        <?php 
                        $opModel = new \App\Models\OperatorModel();
                        $operators = $opModel->findAll();
                        foreach ($operators as $op): ?>
                            <option value="<?= $op['id'] ?>"><?= esc($op['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Préfixe (ex: 033, 037)</label>
                    <input type="text" class="form-control" name="prefix" placeholder="033" required maxlength="10">
                </div>
                <button type="submit" class="btn btn-primary btn-block">Ajouter</button>
                <a href="<?= site_url('operateur/prefixes') ?>" class="btn btn-light btn-block">Retour</a>
            </form>
        </div>
    </div>

    <div class="footer">
        Mobile Money &copy; 2026 - Projet S4
    </div>

</body>
</html>