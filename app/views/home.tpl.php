<!-- page content -->
  <!-- cards -->
  <div class="container mt-2">
    <section class="row">
        <?php if($courses): ?>
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
            <div class="alert alert-danger text-center" role="alert">
                Aucun cours disponible !
            </div>
        <?php endif ?>
        
<!-- end section card -->
    </section>
</div>
</body>
</html>
