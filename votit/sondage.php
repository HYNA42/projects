<?php
require_once('lib/required_files.php');
require_once('lib/poll.php');
// var_dump($poll);



$error404 = false;
$messages = [];
$errors = [];

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $poll = getPollByID($pdo, $id);

    if ($poll) {
        $pageTitle = $poll['title'];
        if (isset($_SESSION['user']) && isset($_POST['voteSubmit'])) {

            if (empty($_POST['items'])) {
                $errors[] = "Vous devez sélectionner au mois une proposition";
            } else {
                removeVoteByPollIdAnduserId($pdo, $id, (int)$_SESSION['user']['id']);
                $resAddVote = addVote($pdo, (int)$_SESSION['user']['id'], $_POST['items']);
                if ($resAddVote) {
                    $messages[] = "Votre vote a bien été prise en compte";
                } else {
                    $errors[] = "Une erreur est survenue pendant l'ajout du vote";
                }
            }
        }

        $totalUsers = getPollTotalUsersByPollId($pdo, $id);

        $results = getPollResultsByPollId($pdo, $id);

        $items = getPollItems($pdo, $id);


        // var_dump($items);
    } else {
        $error404 = true;
    }
} else {
    $error404 = true;
}

require_once('templates/header.php');


if (!$error404) {  ?>
    <div class="row align-items-center g-5 py-5">
        <div class="col-lg-6">
            <h1 class="display-5 fw-bold lh-1 mb-3"><?= $poll["title"] ?></h1>
            <p class="lead"><?= $poll["description"] ?></p>

        </div>

        <div class="col-10 col-sm-8 col-lg-6">
            <h2>Résultats</h2>
            <div class="resultats">
                <?php foreach ($results as $index => $result) {
                    if ($totalUsers) {
                        //calcul
                        $resultPercent = ($result['votes'] / $totalUsers) * 100;
                    } else {
                        $resultPercent = 0;
                    }
                ?>
                    <h3><?= $result['name'] ?></h3>
                    <div class="progress" role="progressbar" aria-label="<?= $result['name'] ?>" aria-valuenow="<?= $resultPercent; ?>" aria-valuemin="0" aria-valuemax="100">
                        <div class="progress-bar progress-bar-striped progress-color-<?= $index ?>" style="width: <?= $resultPercent; ?>%"><?= $result['name']; ?> <?= round($resultPercent, 2); ?>%</div>
                    </div>
                <?php } ?>
            </div>
            <div class="mt-5">
                <?php if (isset($_SESSION['user'])) { ?>
                    <form method="post">
                        <h2>Votez pour ce sondage : </h2>
                        <h3><?= $poll['title'] ?></h3>
                        <!-- ------------ -->

                        <div class="btn-group" role="group" aria-label="Basic checkbox toggle button group">
                            <?php foreach ($items as $key => $item) { ?>
                                <input type="checkbox" class="btn-check" id="<?= $item['id'] ?>" autocomplete="off" value="<?= $item['id'] ?>" name="items[]">
                                <label class="btn btn-outline-primary" for="<?= $item['id'] ?>"><?= $item['name'] ?></label>
                            <?php } ?>
                        </div>

                        <!-- ------------ -->
                        <?php if ($messages) { ?>
                            <?php foreach ($messages as $message) { ?>
                                <div class="alert alert-success mt-2" role="alert">
                                    <?= $message ?>
                                </div>
                            <?php } ?>
                        <?php } ?>
                        <!-- ------------ -->
                        <?php if ($errors) { ?>
                            <?php foreach ($errors as $error) { ?>
                                <div class="alert alert-danger mt-2" role="alert">
                                    <?= $error ?>
                                </div>
                            <?php } ?>
                        <?php } ?>


                        <!-- ------------ -->

                        <div class="mt-2">
                            <input type="submit" name="voteSubmit" class="btn btn-primary" value="Voter">
                        </div>
                    </form>
                    <!-- ------------ -->

                <?php } else { ?>
                    <div class="alert alert-warning">
                        vous devez etre connecté pour voter
                    </div>
                <?php } ?>

            </div>

        </div>

    </div>
<?php } else { ?>
    <h1>Le Sondage n'existe pas</h1>
<?php } ?>

<?php require_once('templates/footer.php'); ?>