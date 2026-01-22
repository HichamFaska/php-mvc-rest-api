<?php
    namespace App\Database;
    use App\Core\Env;
    use PDO;
    use PDOException;
    use Exception;

    class Database {
        private static ?PDO $conn = null;

        public static function getConnection(){
            if (self::$conn !== null) {
                return self::$conn;
            }
            try{
                $host = Env::get("DB_HOST");
                $port = Env::get("DB_PORT");
                $username = Env::get("DB_USER");
                $password = Env::get("DB_PASSWORD");
                $dbname = Env::get("DB_NAME");
                
                $options = [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
                ];
                self::$conn = new PDO("mysql:host={$host};port={$port};dbname={$dbname};charset=utf8mb4", $username, $password, $options);
                return self::$conn;
            }
            catch (PDOException $e) {
                throw new Exception("Erreur de connexion à la base de données");
            }
        }
    }