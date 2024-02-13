<?php

namespace app\core\db;
use app\core\Application;

class Database{

    public \PDO $pdo;

    public function __construct(array $config)
    {
        $dsn = $config['dsn'] ?? '';
        $user = $config['user'] ?? '';
        $password = $config['password'] ?? '';
        $this->pdo = new \PDO($dsn, $user, $password);
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    public function applyMigrations(){
        $this->createMigrationsTable();
        $this->log("Creating the migration table");
        $appliedMigrations = $this->getAppliedMigrations();
        $this->log("Appling the migrations");
        $files = scandir(Application::$ROOT_DIR.'/migrations');
        $newMigration = [];

        $toAppliedMigrations = array_diff($files, $appliedMigrations);
        foreach($toAppliedMigrations as $migration){
            if($migration === '.' || $migration === '..'){
                continue;
            }
            require_once Application::$ROOT_DIR.'/migrations/'.$migration;
            $className = pathinfo($migration, PATHINFO_FILENAME);
            $instance = new $className;
            $instance->up();
            $newMigration[] = $migration;
            // var_dump("<pre>");
            // var_dump($instance);
            // exit;
        }
        if(!empty($newMigration)){
            $this->saveMigration($newMigration);
        }else{
            $this->log('All migration has been migrated...');
        }
    }

    public function createMigrationsTable(){
        $this->pdo->exec("CREATE TABLE IF NOT EXISTS `migrations` (
            `id` int(11) NOT NULL auto_increment PRIMARY KEY,   
            `migration` varchar(250)  NOT NULL default '',     
            `created_at`  TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE = INNODB;");
    }

    public function getAppliedMigrations(){
        $statement = $this->pdo->prepare("SELECT migration FROM migrations");
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_COLUMN);
    }

    public function saveMigration(array $migrations){
        // var_dump("<pre>");
        // var_dump($migrations);

        $str = implode(",",array_map(fn($m) => "('$m')", $migrations));
        
        $statement = $this->pdo->prepare("INSERT INTO migrations (migration) VALUES 
            $str
        ");
        $statement->execute();
    }

    public static function prepare($sql)
    {
        return Application::$app->db->pdo->prepare($sql);
    }

    protected function log($message){
        echo '['.date('Y-m-d H:i:s').'] - '.$message;
    }
}
