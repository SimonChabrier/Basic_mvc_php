<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav" aria-controls="nav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <section class="collapse navbar-collapse mt-2 mb-2" id="nav">
      <a class="navbar-brand" href="<?= $router->generate('main-home') ?>">O'Programme</a>
      <ul class="navbar-nav me-auto mb-lg-0">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <?= count($navValues) ?> Cours
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <?php foreach($navValues as $cours) : ?>
            <li><a class="dropdown-item" href="<?= $router->generate('course-id', ['id' => $cours->getId()]) ?>"><?= $cours->getTitle() ?></a></li>
            <?php endforeach; ?>
          </ul>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?= $router->generate('course-form') ?>">Créer un cours</a>
        </li>
        <li class="nav-item">
        <?php if (isset($_SESSION['username'])) : ?>
        <a class="nav-link" href="<?= $router->generate('user-logout') ?>">Logout</a>
        </li>
        <?php else : ?>
        <li class="nav-item">
        <a class="nav-link" href="<?= $router->generate('user-authenticate') ?>">Login</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?= $router->generate('user-register') ?>">Register</a>
        </li>
        <?php endif; ?>
        <li class="nav-item my-2">
          <?= isset($_SESSION['username']) ? '<span class="badge bg-primary"> Utilisateur connecté : ' . $_SESSION['username'] . '</span>' : '' ?> 
        </li>
        <li class="nav-item my-2">
        <?php if($users) : ?>
        <?php $users = $users['COUNT(*)']; ?>
        <span class="badge bg-primary" style="margin-left: .5rem;">
          <?= $users > 1 ? $users . ' utilisateurs enregistré ' : $users . ' utilisateur enregistré ' ?>  
        </span>
      <?php endif; ?>
        </li>
      </ul>

   
      
      <form class="d-flex" method="GET">
        <input class="form-control me-2 ml-2" name="searchInputValue" type="search" placeholder="Recherche" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Chercher</button>
      </form>
    </section>
  </div>
</nav>