<?php
    namespace App\Database;
    use PDO;
    use PDOException;
    use Exception;

    class Database {
        private static ?PDO $conn;

        public static function getConnection(){
            if (self::$conn !== null) {
                return self::$conn;
            }
            try{
                $host = getenv("DB_HOST");
                $port = getenv("DB_PORT");
                $username = getenv("DB_USER");
                $password = getenv("DB_PASSWORD");
                $dbname = getenv("DB_NAME");
                
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