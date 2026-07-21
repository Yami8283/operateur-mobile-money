<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mobile Money - Connexion</title>
    <link rel="stylesheet" href="<?= base_url('css/style.css?v=2') ?>">
</head>
<body>

    <div class="login-container">
        <div class="login-logo">💸</div>
        
        <div class="card">
            <h2 class="card-title text-center">Mobile Money</h2>
            <p class="text-center" style="color:#888; margin-bottom:20px;">Accédez à votre compte</p>
            
            <?php if (session()->has('error')): ?>
                <div class="alert alert-danger"><?= session('error') ?></div>
            <?php endif; ?>

            <p style="font-weight:600; margin-bottom:15px;">Choisissez un compte :</p>
            
            <a href="<?= site_url('client/do-login?phone=0330000001') ?>" class="btn btn-primary btn-block">
                Alice (0330000001)
            </a>
            <a href="<?= site_url('client/do-login?phone=0370000002') ?>" class="btn btn-info btn-block">
                Bob (0370000002)
            </a>
            <a href="<?= site_url('client/do-login?phone=0341234567') ?>" class="btn btn-light btn-block">
                Nouveau client (0341234567)
            </a>
        </div>
    </div>

    <div class="footer">
        Mobile Money &copy; 2026 - Projet S4
    </div>

</body>
</html>