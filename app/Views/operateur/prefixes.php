<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Préfixes opérateurs</title>
    <link rel="stylesheet" href="<?= base_url('css/style.css?v=2') ?>">
</head>
<body>

    <nav class="navbar">
        <div class="container">
            <a href="<?= site_url('operateur/prefixes') ?>" class="navbar-brand">Mobile<span>Money</span></a>
        </div>
    </nav>

    <div class="container">
        <div class="card">
            <h2 class="card-title">Préfixes par opérateur</h2>
        </div>

        <?php if (session()->has('success')): ?>
            <div class="alert alert-success"><?= session('success') ?></div>
        <?php endif; ?>

        <?php foreach ($operators as $op): ?>
            <div class="card">
                <h4><?= esc($op['name']) ?></h4>
                <?php if (empty($op['prefixes'])): ?>
                    <p style="color:#888;">Aucun préfixe</p>
                <?php else: ?>
                    <ul class="list-group">
                        <?php foreach ($op['prefixes'] as $p): ?>
                            <li class="list-group-item"><?= esc($p['prefix']) ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>

        <a href="<?= site_url('operateur/ajouter-prefixe') ?>" class="btn btn-primary">Ajouter un préfixe</a>
        <a href="<?= site_url('operateur/operations') ?>" class="btn btn-light ml-2">Opérations</a>
    </div>

    <div class="footer">
        Mobile Money &copy; 2026 - Projet S4
    </div>

</body>
</html>