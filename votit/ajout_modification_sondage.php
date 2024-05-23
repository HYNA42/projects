<?php
require_once('lib/required_files.php');
require_once('lib/poll.php');
require_once('lib/category.php');

// ajout_modification_sondage.php

if (empty($_SESSION['user'])) {
    header('Location: login.php');
}
require_once('templates/header.php');

$categories = getCategories($pdo);

$pollError = null;
$pollMessage = null;
$itemError = null;
$itemMessage = null;

$poll = [
    'title' => '',
    'description' => '',
    'category_id' => '',
];
$item = [
    'id' => null,
    'name' => '',
];


/**----------------------------------------------- */

if (isset($_POST['savePoll'])) {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
    } else {
        $id = null;
    }
    $res = savePoll($pdo, $_POST['title'], $_POST['description'], (int)$_SESSION['user']['id'], (int)$_POST['category_id'], $id);

    if ($res) {
        header('Location: ajout_modification_sondage.php?id=' . $res);
    } else {
        $pollError = "Le sondage n'a pas été sauvegardé";
    }
}

/**----------------------------------------------- */


if (isset($_POST['saveItem'])) {
    if (empty($_POST['name'])) {
        $itemError = 'Le nom ne doit pas être vide';
    } else {
        $res = savePollItem($pdo, (int)$_GET['id'], $_POST['name'], (int)$_POST['id']);
        if ($res) {
            $itemMessage = 'La proposition a bien été enregistrée';
        } else {
            $itemError =  "La proposiition n\'a pas été sauvegardée";
        }
    }
} else {
    if (isset($_GET['item_id']) && isset($_GET['action'])) {
        if ($_GET['action'] === 'edit') {
            $item = getPollItemById($pdo, $_GET['item_id']);
        } else if ($_GET['action'] === 'delete') {
            $res = deletePollItemById($pdo, $_GET['item_id']);
            if ($res) {
                $itemMessage = 'La proposition a bien été suprimée';
            } else {
                $itemError = 'Une erreur est survenue pendant la supression';
            }
        }
    }
}


/**----------------------------------------------- */
if (isset($_GET['id'])) {
    $poll = getPollByID($pdo, (int)$_GET['id']);

    if ((int)$poll['user_id'] !== (int)$_SESSION['user']['id']) {
        header('Location: sondages.php');
    }

    $items = getPollItems($pdo, (int)$_GET['id']);
}

?>



<h1>Sondage</h1>
<!--------------------- ALERTE pollError pollMessage --------------------->
<?php if ($pollMessage) { ?>
    <div class="alert alert-success">
        <?= $pollMessage; ?>
    </div>
<?php } ?>

<?php if ($pollError) { ?>
    <div class="alert alert-success">
        <?= $pollError; ?>
    </div>
<?php } ?>

<!--------------------- POST savePoll --------------------------------->
<form method="post">
    <div class="mb-3">
        <label for="title" class="form-label">Titre</label>
        <input type="text" name="title" id="title" class="form-control" value="<?= $poll['title'] ?>" ?>
    </div>
    <!-- ------------ -->
    <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea name="description" id="description" cols="30" rows="10" class="form-control"><?= $poll['description'] ?></textarea>
    </div>
    <!-- ------------ -->
    <div class="mb-3">
        <label for="category_id" class="form-label">Categorie</label>
        <select name="category_id" id="category_id" class="form-select">
            <!-- <option value="test">Test</option> -->
            <?php foreach ($categories as $category) { ?>
                <option <?php if ($category['id'] && $poll) {
                            echo 'selected=selected';
                        } ?> value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
            <?php } ?>
        </select>
    </div>
    <!-- ------------ -->
    <div class="mb-3">
        <input type="submit" value="Enregistrer" name="savePoll" class="btn btn-primary">
    </div>
    <!-- ------------ -->
</form>
<!-------------------------------------------------------------------------------------->
<?php if (!isset($_GET['id'])) { ?>
    <div class="alert alert-warning" role="alert">
        Après avoir enregistré le sondage, vous pourrez ajouter des propositions
    </div>
<?php } else { ?>

    <!-- /////////////////////////////////////// SUPPRESSION - MODIFICATION -->

    <div class="row m-4">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Nom</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $pollItem) { ?>
                    <tr>
                        <td><?= $pollItem['name'] ?></td>
                        <td><a href="ajout_modification_sondage.php?id=<?= $_GET['id'] ?>&item_id=<?= $pollItem['id'] ?>&action=edit">Modifier</a>
                            | <a href="ajout_modification_sondage.php?id=<?= $_GET['id'] ?>&item_id=<?= $pollItem['id'] ?>&action=delete" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet article ?')">Supprimer</a></td>
                    </tr>
                <?php } ?>


            </tbody>
        </table>
    </div>
    <!-- /////////////////////////////////////// ALERTE ITEMMESSAGE ITEMERROR -->
    <?php if ($itemMessage) { ?>
        <div class="alert alert-success">
            <?= $itemMessage; ?>
        </div>
    <?php } ?>

    <?php if ($itemError) { ?>
        <div class="alert alert-success">
            <?= $itemError; ?>
        </div>
    <?php } ?>

    <!-- /////////////////////////////////////// POST SAVEITEM -->
    <div class="row m-4">
        <form method="post" class="border">
            <h3>Proposition</h3>

            <div class="mb-3">
                <label for="name" class="form-label">Nom</label>
                <input type="text" name="name" id="name" class="form-control" value="<?= $item['name'] ?>">
            </div>
            <input type="hidden" value="<?= $item['id'] ?>" name="id">
            <div class="mb-3">
                <input type="submit" name="saveItem" class="btn btn-primary" value="Enregistrer">
            </div>
        </form>
    </div>

<?php } ?>

<!-- Lorem ipsum dolor, sit amet consectetur adipisicing elit. Dicta modi laborum porro dolores recusandae iste cupiditate ut hic quos molestiae quod, quidem, neque iusto tempora necessitatibus non dolor qui assumenda?
Cum quia labore voluptate quaerat laboriosam dolorem id fuga similique voluptatem nobis ullam, doloremque, perferendis excepturi saepe praesentium perspiciatis aliquam assumenda ab corrupti corporis quasi illero. Labore, iure quas! Quidem aspernatur sit recusandae doloribus eos hic officiis incidunt totam, quia, atque ipsam dolorum consequuntur molestias repudiandae aperiam sint sunt quisquam iusto quo.
Tempore maxime iste sed doloribus perspiciatis deleniti vero vitae in quas officia totam aliquam, nemo asperiores maiores veritatis dignissimos, excepturi consequuntur culpa cum adipisci quo cupiditate rerum numquam quisquam? In.um deleniti. Ullam, culpa minus.
Velit a doloribus lib -->



<?php require_once('templates/footer.php'); ?>