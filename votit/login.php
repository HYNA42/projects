<?php

require_once('lib/required_files.php');

require_once('templates/header.php');

$errors = [];

if (isset($_POST['loginUser'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $user = verifyUserLoginAndPassword($pdo, $email, $password);

    if ($user) {
        //on veut connecter l'utilisateur
        session_regenerate_id(true);
        $_SESSION['user'] = $user;
        header('Location: index.php');
    } else {
        //erreur
        $errors[] = 'Email ou mot de passe incorrets';
    }
} else {
}

?>

<h1>Connexion</h1>

<?php if (isset($_SESSION['message'])) { ?>
    <div class="alert alert-success mt-2"><?= $_SESSION['message'] ?></div>
<?php } ?>

<?php foreach ($errors as $error) { ?>
    <div class="alert alert-danger" role="alert">
        <?= $error; ?>
    </div>
<?php } ?>

<form method="POST">
    <div class="mb-3">
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Mot de psse</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>

        <input type="submit" name="loginUser" class="btn btn-primary" value="Enregistrer">
</form>


<?php require_once('templates/footer.php'); ?>