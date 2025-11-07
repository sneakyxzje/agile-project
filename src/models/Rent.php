<?php 

namespace App\models;


class Rent extends BaseModel {
    protected $table = "rents";   

    public static function findAllByUserId($user_id) {
    $model = new static;
    $sql = "SELECT r.*, b.nickname AS bplayer_name, b.main_image as bplayer_image, b.games as bplayer_game 
            FROM {$model->table} r
            JOIN bplayers b ON r.bplayer_id = b.id
            WHERE r.user_id = :user_id
            ORDER BY r.created_at DESC";
    $stmt = $model->conn->prepare($sql);
    $stmt->execute(['user_id' => $user_id]);
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function findAllByBPlayerId($bplayer_id) {
    $model = new static;
    $sql = "SELECT r.*, 
                   u.username AS user_name, u.fullname AS user_fullname, u.avatar AS user_avatar,
                   b.nickname AS bplayer_nickname, b.main_image AS bplayer_image
            FROM {$model->table} r
            JOIN users u ON r.user_id = u.id
            JOIN bplayers b ON r.bplayer_id = b.id
            WHERE r.bplayer_id = :bplayer_id
            ORDER BY r.created_at DESC";
    $stmt = $model->conn->prepare($sql);
    $stmt->execute(['bplayer_id' => $bplayer_id]);
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function findAllByBPlayerIdAndStatus($bplayer_id, $status = null) {
        $model = new static;
        $sql = "SELECT r.*, 
                    u.username AS user_name, u.fullname AS user_fullname, u.avatar AS user_avatar,
                    b.nickname AS bplayer_nickname, b.main_image AS bplayer_image
                FROM {$model->table} r
                JOIN users u ON r.user_id = u.id
                JOIN bplayers b ON r.bplayer_id = b.id
                WHERE r.bplayer_id = :bplayer_id";

        if ($status) {
            $sql .= " AND r.status = :status";
        }

        $sql .= " ORDER BY r.created_at DESC";

        $stmt = $model->conn->prepare($sql);
        $params = ['bplayer_id' => $bplayer_id];
        if ($status) $params['status'] = $status;

        $stmt->execute($params);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function countByUserId(int $userId): int
    {
        $model = new static;
        $sql = "SELECT COUNT(*) FROM {$model->table} WHERE user_id = :user_id";

        $stmt = $model->conn->prepare($sql);
        $stmt->execute(['user_id' => $userId]);

        return $stmt->fetchColumn();
    }

    public static function findPaginatedByUserId(int $userId, int $page, int $perPage): array
    {
        $model = new static;
        $offset = ($page - 1) * $perPage;
        $sql = "SELECT
                    r.*,
                    bp.nickname AS bplayer_name,
                    bp.main_image AS bplayer_image,
                    bp.games AS bplayer_game
                FROM
                    {$model->table} AS r
                JOIN
                    bplayers AS bp ON r.bplayer_id = bp.id
                WHERE
                    r.user_id = :user_id
                ORDER BY
                    r.created_at DESC
                LIMIT :limit OFFSET :offset";

        $stmt = $model->conn->prepare($sql);
        $stmt->bindParam(':user_id', $userId, \PDO::PARAM_INT);
        $stmt->bindParam(':limit', $perPage, \PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    public static function countByStatus($status)
    {
        $model = new static;
        $sql = "SELECT COUNT(*) FROM {$model->table} WHERE status = :status";

        $stmt = $model->conn->prepare($sql);
        $stmt->execute(['status' => $status]);
        
        return (int)$stmt->fetchColumn();
    }

    public static function findAllByStatus($status)
    {
        $model = new static;
        $sql = "SELECT 
                r.*, 
                u.fullname AS user_fullname,
                u.avatar AS user_avatar,   
                b.nickname AS bplayer_nickname,
                b.main_image AS bplayer_image  
            FROM {$model->table} r
            JOIN users u ON r.user_id = u.id
            JOIN bplayers b ON r.bplayer_id = b.id
            WHERE r.status = :status
            ORDER BY r.created_at DESC";

        $stmt = $model->conn->prepare($sql);
        $stmt->execute(['status' => $status]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    public static function findLatestCompleted(int $limit = 5): array
    {
        $model = new static;
        $sql = "SELECT r.*, u.fullname as user_fullname, bp.nickname as bplayer_name
                FROM {$model->table} r
                JOIN users u ON r.user_id = u.id
                JOIN bplayers bp ON r.bplayer_id = bp.id
                WHERE r.status = 'completed'
                ORDER BY r.updated_at DESC 
                LIMIT :limit";
        $stmt = $model->conn->prepare($sql);
        $stmt->bindParam(':limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}