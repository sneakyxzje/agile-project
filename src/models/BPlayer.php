<?php 

namespace App\models;


class BPlayer extends BaseModel {
    protected $table = "bplayers";   

    public static function findAllBPlayer() {
        $model = new static;
        $query = "SELECT id, nickname, price_per_hour, games, main_image, description, voice, created_at, status FROM {$model->table}";
        $stmt = $model->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }


    public static function findBPlayerById($id) {
        $model = new static;
        $query = "SELECT id, nickname, price_per_hour, games, main_image, description, voice, media FROM {$model->table} WHERE id = :id";
        $stmt = $model -> conn -> prepare($query);
        $stmt -> execute(['id' => $id]);
        return $stmt -> fetch(\PDO::FETCH_OBJ);
    }

    public static function findByUserId($user_id) {
        $model = new static;
        $stmt = $model->conn->prepare("SELECT * FROM {$model->table} WHERE user_id = :user_id LIMIT 1");
        $stmt->execute(['user_id' => $user_id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public static function findLatest($limit = 5)
    {
        $model = new static;
        $query = "SELECT b.*, u.fullname 
                FROM {$model->table} b
                JOIN users u ON b.user_id = u.id
                ORDER BY b.created_at DESC 
                LIMIT :limit";
        $stmt = $model->conn->prepare($query);
        $stmt->bindParam(':limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function findTopByRent($limit = 3)
    {
        $model = new static;
        $query = "SELECT
                    bp.nickname,
                    bp.main_image,
                    COUNT(r.id) AS rent_count,
                    SUM(r.amount) AS total_earnings
                FROM
                    bplayers AS bp
                JOIN
                    rents AS r ON bp.id = r.bplayer_id
                WHERE
                    r.status = 'completed'
                GROUP BY
                    bp.id, bp.nickname, bp.main_image
                ORDER BY
                    rent_count DESC, total_earnings DESC
                LIMIT :limit";

        $stmt = $model->conn->prepare($query);
        $stmt->bindParam(':limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function findAllBPlayerWithStatus($status) {
        $model = new static;
        $query = "SELECT id, nickname, price_per_hour, games, main_image, description, voice, created_at, status FROM {$model->table} WHERE status = :status";

        $stmt = $model -> conn -> prepare($query);
        $stmt-> execute(['status' => $status]);
        return $stmt -> fetchAll(\PDO::FETCH_ASSOC);
    }
}