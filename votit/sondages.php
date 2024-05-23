<?php
require_once('lib/required_files.php');
require_once('lib/poll.php');
$polls = getPolls($pdo);
// echo '<pre>';
// echo print_r($polls);
// echo '</pre>';

// var_dump($polls);
require_once('templates/header.php');

?>

<h1>Les Sondages</h1>
<div class="row text-center">
    <?php foreach ($polls as $poll) {
        // var_dump($poll);
        require('templates/poll_part.php');
    } ?>
</div>

<?php require_once('templates/footer.php'); ?>