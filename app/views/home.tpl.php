<!-- page content -->
  <!-- cards -->
  <div class="container mt-2">
    <section class="row">
        <?php if(is_array($courses) || is_object($courses)): ?>
        <?php foreach ($courses as $course) : ?>
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card mb-4">
                <a href="<?= $router->generate('course-id', ['id' => $cours->getId()]) ?>">
                    <img src="<?='/assets/images/' . $course->getPicture() ?>" class="card-img-top" alt="...">
                </a>
                    <div class="card-body">
                        <h5 class="card-title"><?= $course->getTitle() ?></h5>
                        <p class="card-text">
                            <?= substr($course->getShort_description(), 0, 150 ) ?> 
                            <a href="<?= $router->generate('course-id', ['id' => $course->getId()]) ?>"> 
                                ...
                            </a>
                        </p>
                        <a href="<?= $router->generate('course-id', ['id' => $course->getId()]) ?>" class="btn btn-primary">Lire</a>
                    </div>
                </div>
            </div>
        <?php endforeach ?>
        <?php else : ?>
            <!-- no courses -->
        <?php endif ?>
    </section>
</div>

<div class="container mt-2">
    <section class="row">
    <?php if ($results == null): ?>
         <!-- empty display -->
        <?php else : ?>
            <div class="alert alert-success text-center" role="alert">
                    <?php count($results) > 1 ? $value = count($results) . ' résultats' : $value = count($results) . ' résultat' ?>
                    <?= $value ?>
                </div>
            <?php if (is_array($results) || $results != 'Pas de résultat !'): ?>
            <?php foreach ($results as $result) : ?>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card mb-4">
                    <a href="<?= $router->generate('course-id', ['id' => $result['id']]) ?>">
                        <img src="<?='/assets/images/' . $result['picture'] ?>" class="card-img-top" alt="...">
                    </a>
                        <div class="card-body">
                            <h5 class="card-title"><?= $result['title'] ?></h5>
                            <p class="card-text">
                                <?= substr($result['short_description'], 0, 150 ) ?> 
                                <a href="<?= $router->generate('course-id', ['id' => $result['id']]) ?>"> 
                                    ...
                                </a>
                            </p>
                            <a href="<?= $router->generate('course-id', ['id' => $result['id']]) ?>" class="btn btn-primary">Lire</a>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
            <?php else : ?>
                <div class="alert alert-danger text-center" role="alert">
                    <?= $results ?>
                </div>
            <?php endif ?>
    <?php endif ?>
    </section>
</div>

</body>
</html>
