<?php 

namespace App\models;


class User extends BaseModel {
    protected $table = "users";

    public static function findByEmail($email) {
        $model = new static;
        $query = "SELECT * FROM {$model->table} WHERE email = :email";
        $stmt = $model -> conn -> prepare($query);
        $stmt->execute(['email' => $email]);
        $rs = $stmt -> fetchAll(\PDO::FETCH_CLASS);
        return $rs[0] ?? null;
    }

    public static function countUser() {
        $model = new static;
        $query = "SELECT COUNT(*) FROM {$model->table}";
        $stmt = $model -> conn -> prepare($query);
        $stmt->execute();
        return (int)$stmt->fetchColumn();
    }

    public static function countBPlayer() {
        $model = new static;
        $query = "SELECT COUNT(*) FROM {$model->table} WHERE role = 'bplayer'";
        $stmt = $model -> conn -> prepare($query);
        $stmt->execute();
        return (int)$stmt->fetchColumn();
    }

    public static function findLatest($limit = 5)
    {
        $model = new static;
        $sql = "SELECT * FROM {$model->table} ORDER BY created_at DESC LIMIT :limit";
        $stmt = $model->conn->prepare($sql);
        $stmt->bindParam(':limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function getAllUsersWithBPlayerInfo(): array
    {
        $model = new static;

        $sql = "SELECT
                    u.*,
                    bp.nickname
                FROM
                    {$model->table} AS u
                LEFT JOIN
                    bplayers AS bp ON u.id = bp.user_id
                ORDER BY
                    u.created_at DESC";

        $stmt = $model->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function getChatInfo($userId) {
        $model = new static;
        
        $sql = "SELECT 
                    u.id, 
                    u.fullname, 
                    COALESCE(b.main_image, u.avatar, '/assets/images/default-avatar.png') as avatar
                FROM users u
                LEFT JOIN bplayers b ON u.id = b.user_id
                WHERE u.id = :id";

        $stmt = $model->conn->prepare($sql);
        $stmt->execute(['id' => $userId]);
        
        return $stmt->fetch(\PDO::FETCH_ASSOC); 
    }
    
    public static function findWithBPlayerInfo(int $id)
    {
        $model = new static;
        $sql = "SELECT
                    u.*,
                    bp.nickname
                FROM
                    {$model->table} AS u
                LEFT JOIN
                    bplayers AS bp ON u.id = bp.user_id
                WHERE
                    u.id = :id";
        $stmt = $model->conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
}