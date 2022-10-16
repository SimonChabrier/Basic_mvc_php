<div class="container mt-3">
<div class="alert alert-danger text-center" role="alert">
    <h1>RESSOURCE NON AUTORISEE !!!</h1>
</div>
<?php if (!empty($_SESSION['role']) && $_SESSION['role'] == 'ROLE_USER'): ?>   
    <a href="<?= $router->generate('main-home') ?>" class="btn btn-primary">retour à l'accueil</a>
    <?php exit(); ?>
<?php else: ?>
    <a href="<?= $router->generate('user-login') ?>" class="btn btn-success">connectez vous</a>
    <?php exit(); ?>
<?php endif; ?>
</div>  