<?php

require_once('lib/required_files.php');
require_once('lib/user.php');
require_once('templates/header.php');

echo "<title>signup - VotIt</title>";

$errors404 = false;
$errors = [];

if (isset($_POST['signupUser'])) {
    $emailUser = $_POST['email'] ?? '';
    $passwordUser = $_POST['password'] ?? '';
    $nicknameUser = $_POST['nickname'] ?? '';
    if (empty($emailUser) || empty($passwordUser) || empty($nicknameUser)) {
        $errors404 = true;
    } else {
        if (verifyUserLoginAndPassword($pdo, $emailUser)) {
            $errors[] = "L'utilisateur existe déjà, veuillez vous connecter";
        } else {
            $user = addUser($pdo, $emailUser, $passwordUser, $nicknameUser);
            if ($user) {
                session_regenerate_id(true);
                $_SESSION['message'] = 'Votre inscription est bien effectuée, vous pouvez maintenant vous connecter';
                var_dump($_SESSION);
                header('Location: login.php');
            } else {
                $errors[] = "Un problème est survenu lors de l'inscription, veuillez réessayer";
            }
            // var_dump($user);
        }
        // var_dump($_POST);
    }
} else {
    $errors404 = true;
}

?>

<h1>S'inscrire</h1>
<!-- ------- -->
<?php if ($errors404) { ?>
    <div class="alert alert-warning mt-2">Tous les champs doivent être renseignés</div>
<?php } ?>
<!-- ------- -->
<?php if ($errors) { ?>

    <?php foreach ($errors as $error) { ?>

        <div class="alert alert-danger mt-2">
            <?= $error ?>
        </div>

    <?php } ?>

<?php  } ?>
<!-- ------- -->

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

        <div class="mb-3">
            <label for="nickname" class="form-label">Pseudo</label>
            <input type="text" class="form-control" id="nickname" name="nickname">
        </div>

        <input type="submit" name="signupUser" class="btn btn-primary" value="Soumettre">

</form>

<?php require_once('templates/footer.php'); ?>