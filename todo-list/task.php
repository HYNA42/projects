<?php

declare(strict_types=1);
error_reporting(-1);
ini_set("display_errors", 1);
////////////////////////////
require('database.php');
////////////////////////////

/**Récuprer les données envoyées via POST*/

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add_task']) && ($_POST['add_task']) === "add") {
        $content_task = $_POST['content_task'] ?? '';
        if (!empty($content_task)) {
            $sql = 'INSERT INTO task_lists (task_content) VALUES (?)';
            $stmt = Database::getInstance()->request($sql, [$content_task]);
            $taskId = Database::getInstance()->getPdo()->lastInsertId();
            echo json_encode(["id" => $taskId]);
        }
        //réponde avec un statut http 200 pour indiquer que la requette a réussi
        http_response_code(200);
    } elseif (isset($_POST['delete_task']) && ($_POST['delete_task']) === "delete") {
        $taskId = $_POST['task_id'] ?? '';
        if (!empty($taskId)) {
            $sql = 'DELETE FROM task_lists WHERE id = ?';
            $stmt = Database::getInstance()->request($sql, [$taskId]);
            http_response_code(200);
        }
    } else {
        //réponde avec un statut http 400 pour indiquer une erreur de requête
        http_response_code(400);
    }
} elseif ($_SERVER["REQUEST_METHOD"] == "GET") {

    $tasks = Database::getInstance()->getAllTask();
    echo json_encode($tasks);
    
} else {
    //réponde avec un statut http 400 pour indiquer une erreur de requête
    http_response_code(400);
}
