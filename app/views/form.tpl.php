<?php 
//dump(empty($course));
// dump($course);
//dump($errors);
?>

<div class="container mt-2">
  <section class="row">
      <div class="col-sm-6 col-lg-12 mb-2">
        <h1>Créer un cours</h1>
        <?php if (isset($errors)) : ?>
        <div class="alert alert-danger text-center" role="alert">
            <?php foreach ($errors as $error) : ?>
                <p><?= $error ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
      </div>
  </section>
<!-- form -->
    <section class="row">
        <div class="col-sm-12 col-lg-12 mb-4">
        <form form enctype="multipart/form-data" action="" method="POST">
          <div class="form-group">
      
            <label for="title">Titre</label>
              <input type="input" name="title" id="title" class="form-control" placeholder="" maxlength="150" value="<?= $course === false ? '' : $course->getTitle()  ?>">

            <label for="picture" class="mt-2">Image</label>
              <input type="file" name="picture" id="picture" accept="image/png, image/gif, image/jpeg" class="form-control">

            <label for="description" class="mt-2">Description courte</label>
              <input type="input" name="short_description"  id="shortDescription" class="form-control"  placeholder="" value="<?= $course === false ? '' : $course->getShort_description() ?>">

            <label for="description" class="mt-2">Description</label>
              <textarea class="form-control" rows="5" name="description" id="description" placeholder=""><?= $course === false ? '' : $course->getDescription() ?></textarea>

            <!-- <label for="program" class="mt-2">Le programme</label>
              <textarea class="form-control" rows="5" id="program"></textarea> -->

            <label for="duration" class="mt-2">Nombre d'heures</label>
              <input type="number" name="duration" id="duration" class="form-control" placeholder="" value="<?= $course === false ? '' : $course->getDuration() ?>">

            <label for="price" class="mt-2">Tarif</label>
              <input type="number" name="price" id="price" class="form-control" placeholder="" value="<?= $course === false ? '' : $course->getPrice() ?>">

            <!-- <label for="time" class="mt-2">Date</label>
              <input type="date" id="date" class="form-control">

            <label for="teacher" class="mt-2">Professeur</label>
              <select type="choice" id="choice teacher" class="form-control">
                <option value="choiceinfo" disable>Choisir un professeur</option>
                <option value="prof1">Prof 1</option>
                <option value="prof2">Prof 2</option>
                <option value="prof3">Prof 3</option>
              </select>

            <label for="teacher" class="mt-2">Modalité</label>
              <select type="choice" id="modality" class="form-control">
                <option value="choiceinfo" disable>Choisir la modalité</option>
                <option value="modalité1">modalité 1</option>
                <option value="modalité2">modalité 2</option>
                <option value="modalité3">modalité 3</option>
              </select>

            <label for="teacher" class="mt-2">Niveau Requis</label>
              <select type="choice" id="level" class="form-control">
                <option value="levelinfo" disable>Choisir la niveau</option>
                <option value="niveau1">niveau 1</option>
                <option value="niveau2">niveau 2</option>
                <option value="niveau3">niveau 3</option>
              </select>
          </div> -->

          <div class="form-check mt-2">
          <input class="form-check-input" type="radio" value="true" name="published" id="radio1" <?= $course === false || $course->getIs_published() === true   ? 'checked' : '' ?>>
            <label class="form-check-label" for="radio1">
              Publié
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" value="false" name="published" id="radio2" <?= $course === false || $course->getIs_published() === false ? 'checked' : '' ?>>
            <label class="form-check-label" for="radio2">
              En attente
            </label>
        </div>
        
          <button type="submit" value="upload" name="publishCourseBtn" class="btn btn-primary btn-sm mt-2"><?= $course === false ?  'Créer' : 'Mettre à jour'  ?></button>  
          
        <!-- get user last location -->
        <input type="hidden" name="lastLocation" value="<?= $_SERVER['HTTP_REFERER'] ?>">
      </div>
  </section>
</div>
</body>
</html>