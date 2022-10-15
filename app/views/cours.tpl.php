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
          <?php if($items_array): ?>
          <?php foreach ($items_array as $program_item) : ?>  
            <li><?= $program_item ?></li>
          <?php endforeach; ?>
          <?php else: ?>
            <li>Pas de valeur dans la base de données</li>
          <?php endif; ?>
        </ol>
      </div>
  </section>
    <section class="row">
      <div class="col-sm-12 col-lg-6 mb-4">
        <h2>Caractéristiques</h2>
        <table class="table table-striped">
          <tbody>
            <tr>
              <td>Date</td>
              <td><?= $course->getDate() == null ? 'non renseigné' : $course->getDate() ?></td>
            </tr>
            <tr>
              <td>Enseignant</td>
              <td><?= $teacher_name == null ? 'non renseigné' : $teacher_name  ?></td>
            </tr>
            <tr>
              <td>Durée</td>
              <td><?= $course->getDuration() == null ? 'non renseigné': $course->getDuration() . ' h' ?></td>
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