<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un préfixe</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-4">
    <h2>Ajouter un préfixe</h2>

    <?php if (session()->has('errors')): ?>
        <div class="alert alert-danger">
            <?php foreach (session('errors') as $e): ?>
                <p><?= esc($e) ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form action="<?= site_url('operateur/ajouter-prefixe') ?>" method="post">
        <?= csrf_field() ?>
        <div class="mb-3">
            <label for="prefix" class="form-label">Préfixe (ex: 033, 037)</label>
            <input type="text" class="form-control" id="prefix" name="prefix" required>
        </div>
        <button type="submit" class="btn btn-primary">Ajouter</button>
        <a href="<?= site_url('operateur/prefixes') ?>" class="btn btn-secondary">Retour</a>
    </form>
</body>
</html>