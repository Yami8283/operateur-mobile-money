
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Préfixes opérateur</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-4">
    <h2>Préfixes de l'opérateur "<?= esc($operator['name']) ?>"</h2>

    <?php if (session()->has('success')): ?>
        <div class="alert alert-success"><?= session('success') ?></div>
    <?php endif; ?>

    <?php if (empty($prefixes)): ?>
        <div class="alert alert-warning">Aucun préfixe pour le moment.</div>
    <?php else: ?>
        <ul class="list-group">
            <?php foreach ($prefixes as $p): ?>
                <li class="list-group-item"><?= esc($p['prefix']) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <a href="<?= site_url('operateur/ajouter-prefixe') ?>" class="btn btn-primary mt-3">Ajouter un préfixe</a>
</body>
</html>