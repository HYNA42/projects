<?php

declare(strict_types=1);
error_reporting(-1);
ini_set("display_errors", 1);
////////////////////////////
class Database
{
    private $pdo;
    private static $instance;

    public function __construct()
    {
        try {
            $dsn = 'mysql:host=localhost;dbname=db_tasksync';
            $user = 'root';
            $pass = '';

            $options = [
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES => false
            ];

            $this->pdo = new PDO($dsn, $user, $pass, $options);
        } catch (PDOException $e) {
            echo "Error de connexion avec la BDD : " . $e->getMessage();
        }
    }
    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    public function request($sql, $params = [])
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt; // Retourner le statement pour un traitement ultérieur si nécessaire
    }

    public function getPdo()
    {
        return $this->pdo;
    }

    public function getAllTask(){
        $req = 'SELECT * FROM `task_lists`';
        $stmt = $this->pdo->query($req);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
