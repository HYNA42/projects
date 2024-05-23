<?php
require_once('lib/required_files.php');
require_once('lib/user.php');


// $poll = getPollByID($pdo, $id);
// $pageTitle = $poll['title'];

$mainMenu = [
    'index.php' => 'Accueil',
    'sondages.php' => 'Liste des sondages',
    'ajout_modification_sondage.php' => 'Créer un sondage',
];

$LoginSignUP = [
    'login.php' => 'Connexion',
    'signup.php' => "S'inscrire",
];


// echo "<pre>";
// var_dump(basename($_SERVER['SCRIPT_NAME']));
// echo "</pre>";

?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/override-bootstrap.css">
    <link rel="icon" type="image/x-icon" href="/favicon.ico">


    <title>
        <?php
        if (isset($mainMenu[basename($_SERVER['SCRIPT_NAME'])])) {
            echo $mainMenu[basename($_SERVER['SCRIPT_NAME'])] . ' - ' . SITE_NAME;
        } elseif (isset($pageTitle)) {
            echo $pageTitle . SITE_NAME;
        } else {
            echo SITE_NAME;
        }

        ?>
    </title>

</head>

<body>
    <div class="container d-flex flex-column min-vh-100">
        <header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom">
            <div class="col-md-3 mb-2 mb-md-0">
                <a href="index.php" class="d-inline-flex link-body-emphasis text-decoration-none">
                    <!-- <img src="/assets/images/logo-votit.png" alt="logo" width="200"> -->
                    <img src="<?= PATH_ASSETS_IMAGES ?>logo-votit.png" alt="Logo" width="150">

                </a>
            </div>

            <ul class="nav nav-pills">
                <?php foreach ($mainMenu as $page => $titre) { ?>
                    <li class="nav-item"><a href="<?= $page ?>" class="nav-link 
                        <?php
                        if (basename($_SERVER['SCRIPT_NAME']) === $page) {
                            echo 'active';
                        }
                        ?>
                    " aria-current="<?= $page ?>"><?= $titre ?></a></li>
                <?php
                } ?>
            </ul>


            <div class="col-md-3 text-end">
                <?php if (isset($_SESSION['user'])) { ?>
                    <a href="logout.php" class="btn btn-primary ">Déconnexion</a>
                <?php } else { ?>
                    <a href="login.php" class="btn btn-primary">Connexion</a>
                    <a href="signup.php" class="btn btn-primary">S'inscrire</a>
                <?php } ?>
            </div>


        </header>

        <main>