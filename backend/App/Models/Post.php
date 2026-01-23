<?php

    namespace App\Models;

    use App\Database\Database;
    use Exception;
    use PDO;
    use PDOException;

    class Post{
        private PDO $conn;

        public function __construct(){
            $this->conn = Database::getConnection();
        }

        public function all():array{
            try{
                $stmt = $this->conn->prepare("SELECT 
                        p.id AS post_id,
                        p.title,
                        p.content,
                        p.created_at,
                        p.updated_at,
                        u.id AS user_id,
                        u.name AS user_name,
                        u.avatar AS user_avatar
                    FROM posts p
                    INNER JOIN users u 
                        ON u.id = p.user_id
                    ORDER BY p.created_at DESC
                ");
                $stmt->execute();
                return $stmt->fetchAll();
            }
            catch(PDOException $e){
                throw new Exception("Erreur lors de la récupération des posts.");
            }
        }

        public function find(int $id):object|null{
            try{
                $stmt = $this->conn->prepare("SELECT 
                        p.id AS post_id,
                        p.title,
                        p.content,
                        p.created_at,
                        u.id AS user_id,
                        u.name,
                        u.avatar,
                        u.email
                    FROM posts p
                    INNER JOIN users u 
                        ON u.id = p.user_id
                    WHERE p.id = :id
                ");
                $stmt->execute([":id" => $id]);
                $result = $stmt->fetch();
                return $result ?: null;
            }
            catch(PDOException $e){
                throw new Exception("Erreur lors de la récupération du post");
            }
        }

        public function create(array $data):object{
            try{
                if(!isset($data['user_id']) || !isset($data['title']) || !isset($data['content'])){
                    throw new Exception("Les champs user_id, title et content sont requis");
                }
                
                $stmt = $this->conn->prepare("INSERT INTO posts (user_id, title, content) VALUES (?, ?, ?)");
                $stmt->execute([
                    $data['user_id'],
                    $data['title'],
                    $data['content']
                ]);
                return $this->find((int)$this->conn->lastInsertId());
            }
            catch(PDOException $e){
                throw new Exception("Erreur lors de la création du post");
            }
        }

        public function update(int $id, array $data):bool{
            try{
                if(!isset($data['title']) || !isset($data['content'])){
                    throw new Exception("Les champs title et content sont requis");
                }
                
                $stmt = $this->conn->prepare("UPDATE posts SET title = :title, content = :content, updated_at = CURRENT_TIMESTAMP WHERE id = :id");
                return $stmt->execute([
                    ":title" => $data['title'],
                    ":content" => $data['content'],
                    ":id" => $id
                ]);
            }
            catch(PDOException $e){
                throw new Exception("Erreur lors de la mise à jour du post");
            }
        }

        public function delete(int $id):bool{
            try{
                $stmt = $this->conn->prepare("DELETE FROM posts WHERE id = :id");
                return $stmt->execute([
                    ":id" => $id
                ]);
            }
            catch(PDOException $e){
                throw new Exception("Erreur lors de la suppression du post");
            }
        }

        public function getByUser(int $user_id):array{
            try{
                $stmt = $this->conn->prepare("SELECT * FROM posts WHERE user_id = :user_id ORDER BY created_at DESC");
                $stmt->execute([
                    ":user_id" => $user_id
                ]);
                return $stmt->fetchAll();
            }
            catch(PDOException $e){
                throw new Exception("Erreur lors de la récupération des posts de l'utilisateur");
            }
        }
    }