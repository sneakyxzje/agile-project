<?php 

namespace App\models;

use PDO;

class BaseModel
{
    protected $conn = null;
    protected $table = ""; 
    protected $primaryKey = "id"; 
    protected $sqlBuilder; 
    protected $params = []; 

    public function __construct()
    {
        try {
            $this->conn = new PDO("mysql:host=" . HOST . "; dbname=" . DBNAME . "; charset=utf8; port=" . PORT, USERNAME, PASSWORD);

            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            throw $e;
        }
    }

    //Hàm all dùng để lấy toàn bộ dữ liệu của 1 bảng
    public static function all()
    {
        $model = new static;
        $sql = "SELECT * FROM {$model->table}";
        $stmt = $model->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_CLASS);
        return $result;
    }

    /**
     * @method find: lấy ra 1 bản ghi theo khóa chính
     * @param $id: giá trị của khóa cần lấy
     */
    public static function find($id)
    {
        $model = new static;
        $sql = "SELECT * FROM {$model->table} WHERE 
                    {$model->primaryKey} = :{$model->primaryKey}";
        $stmt = $model->conn->prepare($sql);
        $stmt->execute(["{$model->primaryKey}" => $id]); //truyền id vào tham số
        $result = $stmt->fetchAll(PDO::FETCH_CLASS);
        return $result[0] ?? null;
    }

    /**
     * @method create: thêm 1 bản ghi mới
     * @param $data: là 1 mảng dữ liệu bao gồm có key: tên cột và value
     */
    public static function create($data)
    {
        $model = new static;

        $columns = array_keys($data); //Lấy key của mảng data
        $columnNames = " `" . implode("`, `", $columns) . "` "; //Danh sách các cột
        $params = " :" . implode(", :", $columns); //Danh sách các tham số

        $sql = "INSERT INTO $model->table ({$columnNames} ) VALUES ({$params})";

        $stmt = $model->conn->prepare($sql);
        $stmt->execute($data);
        return $model->conn->lastInsertId();
    }

    /**
     * @method update: cập nhật dữ liệu
     * @param $id: cập nhật theo khóa chính
     * @param $data: dữ liệu
     */
    public static function update($id, $data)
    {
        $model = new static;

        $columns = array_keys($data);

        $sql = "UPDATE $model->table SET ";
        foreach ($data as $key => $value) {
            $sql .= "`{$key}`=:{$key}, ";
        }
        //Xóa dấu , ở cuối chuỗi
        $sql = rtrim($sql, ", ");
        $sql .= " WHERE `{$model->primaryKey}`=:{$model->primaryKey}";
        $stmt = $model->conn->prepare($sql);

        //Thêm id vào mảng data
        $data["$model->primaryKey"] = $id;
        $stmt->execute($data);
    }

    /**
     * @method delete: phương thức xóa dữ liệu theo id
     * @param $id: dữ liệu cần xóa
     */
    public static function delete($id)
    {
        $model = new static;
        $sql = "DELETE FROM {$model->table} WHERE {$model->primaryKey}=:{$model->primaryKey}";
        $stmt = $model->conn->prepare($sql);
        $stmt->execute(["{$model->primaryKey}" => $id]);
    }

}