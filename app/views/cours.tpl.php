<div class="container mt-2">
  <section class="row">
      <div class="col-lg-6 col-sm-6 col-xs-6 mb-4">
        <h1><?= $course->getTitle() ?></h1>
      </div>
      <div class="col-lg-6 col-sm-6 col-xs-6 mb-4">
        <span class="badge bg-success float-end align-top"><?= $course->getDuration() ?> h</span>
        <span class="mx-1 badge bg-warning float-end align-top"><?= $course->getPrice() ?> €</span>
      </div>
  </section>
<!-- text and picture -->
  <section class="row">
        <div class="col-sm-12 col-lg-6 mb-4">
            <img class="card-img-top" src="<?= '/assets/images/' . $course->getPicture() ?>" alt="Card image cap">
            <a class="btn btn-primary mt-1" href="<?= $router->generate('update-course', ['id' => $course->getId()]) ?>">Modifier le cours</a>
            <a class="btn btn-primary mt-1" href="<?= $router->generate('delete-course', ['id' => $course->getId()]) ?>">Supprimer le cours</a>
            <p class="mt-2"><?= $date ?></p>
        </div>
        <div class="col-sm-12 col-lg-6 mb-4">
          <article>
            <p class="cours"><?= $course->getDescription() ?></p>
          </article>
        </div>
  </section>
<!-- end section text and picture -->
<!-- table -->
  <section class="row">
      <div class="col-sm-12 col-lg-6 mb-4">
        <h2>Le Programme</h2>    
        <ol>
        <?php foreach ($program as $program_item) : ?>  
          <li><?= $program_item ?></li>
          <?php endforeach; ?>
        </ol>
      </div>
  </section>
    <section class="row">
      <div class="col-sm-12 col-lg-6 mb-4">
        <h2>Caractéristiques</h2>
        <table class="table table-striped">
          <tbody>
            <tr>
              <td>Dates</td>
              <td>12/12/22</td>
            </tr>
            <tr>
              <td>Votre profil</td>
              <td>Pierre C</td>
            </tr>
            <tr>
              <td>Durée</td>
              <td>70h</td>
            </tr>
            <tr>
              <td>Modalité</td>
              <td>A distance</td>
            </tr>
            <tr>
              <td>Niveau requis</td>
              <td>Débutant</td>
            </tr>
          </tbody>
        </table>
      </div>
  </section>
</div>
</body>
</html>