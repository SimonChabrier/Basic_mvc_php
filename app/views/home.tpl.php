<!-- page content -->
<?php ?>
  <!-- course/s card/s -->
  <div class="container mt-2">
    <section class="row">
        <?php if(!empty($courses)): ?>
            <?php foreach ($courses as $course) : ?>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card mb-4">
                    <a href="<?= $router->generate('course-id', ['id' => $course->getId()]) ?>">
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
        <?php endif ?>
        <!-- if no courses in database -->
        <?php if(empty($courses) && empty($_GET['searchInputValue'])): ?>
            <div class="alert alert-danger text-center" role="alert">
                Aucun cours dans la base de données !
            </div>
        <?php endif ?>
    </section>
</div>
<!-- search -->
<div class="container mt-2">
    <section class="row">
        <!-- alert result = false -->
        <?php if ($search_results == null && !empty($_GET['searchInputValue'])): ?>
            <div class="alert alert-danger text-center" role="alert">
                Aucun résultat pour votre recherche
            </div>
        <?php endif ?>
        <!-- alert result = true -->
        <?php if ($search_results >= 1): ?>
            <div class="alert alert-success text-center" role="alert">
                <?= count($search_results) > 1 ? $value = count($search_results) . ' résultats' : $value = count($search_results) . ' résultat' ?>  
            </div>
        <?php endif ?>      
        <!-- display search result/s course/s card/s -->
        <?php if (isset($search_results) && isset($_GET['searchInputValue'])): ?>
            <?php foreach ($search_results as $result) : ?>
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
        <?php endif ?>
    </section>
</div>
</body>
</html>
