<?php

namespace common\models;

use common\config;
use Exception;

/**
 * This is the model class for table "user".
 */
class UserModel
{
    public $name;
    public $email;
    public $image;
    public $terms_of_service;

    private $conn;

    /**
     * construct
     */
    public function __construct()
    {
        $this->conn = config\getConnection();
    }

    /**
     * @return string
     */
    public static function getTableName(): string
    {
        return 'user';
    }

    /**
     * @return string
     */
    public function getInsertCommand(): string
    {
        return "INSERT INTO " . self::getTableName() . " (name, email, image) VALUES (?, ?, ?)";
    }

    /**
     * @return void
     * @throws Exception
     */
    public function uploadImage()
    {
        $uploadDir = 'web/images/';

        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $tempFilePath = $_FILES['image']['tmp_name'];

        $destinationFilePath = $uploadDir . $this->image;

        if (!move_uploaded_file($tempFilePath, $destinationFilePath)) {
            throw new Exception('Can not upload image');
        }
    }

    /**
     * @return bool
     * @throws Exception
     */
    public function save(): bool
    {
        $this->validate();

        $stmt = $this->conn->prepare($this->getInsertCommand());
        $stmt->bind_param('sss', $this->name, $this->email, $this->image);

        if (!$stmt->execute()) {
            throw new Exception($stmt->error, 400);
        }

        $stmt->close();
        return true;
    }

    /**
     * @return void
     * @throws Exception
     */
    public function validate()
    {
        if ($this->image !== null && (int)$this->terms_of_service === 0) {
            throw new Exception('If you have selected an image you should accept terms of service', 400);
        }
    }

    /**
     * @return array
     */
    public function getAllWithPagination()
    {
        $recordsPerPage = 10;

        $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;

        $startFrom = ($currentPage - 1) * $recordsPerPage;

        $sql = "SELECT * FROM " . self::getTableName();
        if (isset($_GET['sortBy'])) {
            $sql .= " ORDER BY " . $_GET['sortBy'] . " " . ($_GET['sort'] ?? 'asc');
        }
        $sql .= " LIMIT {$startFrom}, {$recordsPerPage}";

        $result = $this->conn->query($sql);

        $users = [];
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }

        $totalRecords = $this->conn->query("SELECT COUNT(*) FROM " . self::getTableName())->fetch_row()[0];

        $totalPages = ceil($totalRecords / $recordsPerPage);

        return [
            'users' => $users,
            'totalPages' => $totalPages,
            'currentPage' => $currentPage,
        ];
    }

    /**
     * @return array
     */
    public function getAll()
    {
        $query = "SELECT * FROM " . self::getTableName();

        return $this->conn->query($query)->fetch_all(MYSQLI_ASSOC);
    }
}