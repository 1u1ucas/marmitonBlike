<?php require_once 'parts/header.php'; ?>

<div class="contain">
    <h1>Login page</h1>

    <form action="scripts/sign-in/sign-in.php" method="POST">
        <div class="mb-3">
            <input class="formControl" type="text" placeholder="Enter an username" name="username">
        </div>
        <div class="mb-3">
            <input type="submit" value="Sign-in" class="btn btn-primary w-100">
        </div>
    </form>

    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger">
            <?php echo $_GET['error']; ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success">
            <?php echo $_GET['success']; ?>
        </div>
    <?php endif; ?>

</div>

<?php require_once 'parts/footer.php'; ?>