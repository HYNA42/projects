<?php

function verifyUserLoginAndPassword($pdo, string $email, string $password = null): array|bool
{

    $query = $pdo->prepare('SELECT * FROM user WHERE email = :email');
    $query->bindValue(':email', $email, PDO::PARAM_STR);
    $query->execute();
    $user = $query->fetch(PDO::FETCH_ASSOC);


    if ($password) {
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        } else {
            return false;
        }
    } else {
        return $user;
    }
}

function addUser($pdo, string $emailUser, string $passwordUser, string $nicknameUser): bool
{

    $query = $pdo->prepare("INSERT INTO user (email, password, nickname) VALUES (:email, :password, :nickname)");

    $query->bindValue(':email', $emailUser, PDO::PARAM_STR);
    $query->bindValue(':password', password_hash($passwordUser, PASSWORD_BCRYPT), PDO::PARAM_STR);
    $query->bindValue(':nickname', $nicknameUser, PDO::PARAM_STR);
    $res = $query->execute();

    return $res;
    if($res){
        return $res;
    }
    throw new Error('Un probleme est survenu lors de votre insscription');

    // $user = $query->fetch(PDO::FETCH_ASSOC);

}
