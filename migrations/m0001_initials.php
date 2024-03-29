<?php

use Nirya\PhpMvcCore\Application;

class m0001_initials{

    public function up(){
        $db = Application::$app->db;

        $sql = "CREATE TABLE users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            email VARCHAR(255) NOT NULL,
            firstname VARCHAR(255) NOT NULL,
            lastname VARCHAR(255) NOT NULL,
            status TINYINT DEFAULT 0,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )  ENGINE=INNODB;";

        $db->pdo->exec($sql);
    }
    public function down(){
        $db = Application::$app->db;
        $SQL = "DROP TABLE users;";
        $db->pdo->exec($SQL);
    }

}