<div class="container">
    <form action="" class="form" method="POST">
    <h1>login</h1>
    <?php if (isset($errors)) : ?>
        <div class="alert alert-danger text-center" role="alert">
            <?php foreach ($errors as $error) : ?>
                <p><?= $error ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
        <div class="mb-3">
            <label for="inputUsername" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username" aria-describedby="emailHelp">
            <div id="usernameInfo" class="form-text">Enter the username used when creating your account.</div>
        </div>
        <div class="mb-3">
            <label for="inputPassword" class="form-label">Password</label>
            <input type="password" class="form-control" id="userPassword" name="password">
        </div>
        <!-- <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="exampleCheck1">
            <label class="form-check-label" for="exampleCheck1">Remeber Me</label>
        </div> -->
        <input class="btn btn-primary mt-2" type="submit" name="loginBtn" value="logIn" />

        <!-- get user last location -->
        <input type="hidden" name="lastLocation" value="<?= $_SERVER['HTTP_REFERER'] ?>">
        <input type="hidden" name="token" value="<?= $token ?>">
    </form>
</div>