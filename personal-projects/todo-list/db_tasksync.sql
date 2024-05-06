DROP DATABASE IF EXISTS db_tasksync;
DROP TABLE IF EXISTS `task_lists`;

CREATE DATABASE IF NOT EXISTS db_tasksync;

USE db_tasksync;

CREATE TABLE IF NOT EXISTS `task_lists`(
    `id` INT NOT NULL AUTO_INCREMENT,
    `task_content` VARCHAR(255) NOT NULL,

    PRIMARY KEY(`id`)
);

INSERT INTO `task_lists`(task_content)
VALUES ('Task1'),('Task2'),('Task3');

INSERT INTO `task_lists`(id, task_content)
VALUES (1,'RDV chez le médecin'),(0,'Faire les courses'),(2,'Salle de sport');

SELECT * FROM `task_lists`;



-- SOURCE C:/myWAMP/apache/htdocs/TP/Perso - ToDoList/db_tasksync.sql;
    -- `id` INT NOT NULL,






