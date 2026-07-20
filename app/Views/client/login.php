<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mobile Money - Connexion</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <h2 class="text-center mb-4">Mobile Money</h2>
            
            <?php if (session()->has('error')): ?>
                <div class="alert alert-danger"><?= session('error') ?></div>
            <?php endif; ?>

            <p>Choisis un compte de test :</p>
            <a href="<?= site_url('client/do-login?phone=0330000001') ?>" class="btn btn-primary w-100 mb-2">Alice (0330000001)</a>
            <a href="<?= site_url('client/do-login?phone=0370000002') ?>" class="btn btn-primary w-100 mb-2">Bob (0370000002)</a>
            <a href="<?= site_url('client/do-login?phone=0341234567') ?>" class="btn btn-secondary w-100">Nouveau client (0341234567)</a>
        </div>
    </div>
</body>
</html>