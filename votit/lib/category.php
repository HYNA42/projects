<?php

function getCategories(PDO $pdo)
{
    $query = $pdo->prepare("SELECT * FROM category");
    $query->execute();
    return $query->fetchAll(PDO::FETCH_ASSOC);
}
