<?php

namespace App\Database;

use App\Database\Contracts\BaseModel;
use PDO;

class Database extends BaseModel
{
    protected string $db_name = "api_ticket";
    protected string $server_name = "localhost";
    protected string $username = "root";
    protected string $password = "";
    protected $connection;

    function __construct()
    {
        try {
            $this->connection = new PDO("mysql:host=$this->server_name;dbname=$this->db_name", $this->username, $this->password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public function create($fields, $values)
    {
        try {
            $fi = implode(',', $fields);
            $placeholders = implode(',', array_fill(0, count($values), '?'));

            $result = $this->connection->prepare("INSERT INTO $this->table ($fi) VALUES ($placeholders)");
            for ($i = 1; $i <= count($values); $i++)
                $result->bindValue($i, $values[$i - 1]);

            $result->execute();

        } catch (\PDOException $e) {
            return $e->getMessage();
        }
    }

    public function update($fields, $values, $id)
    {
        try {
            $fi = '';
            foreach ($fields as $field) {
                $fi .= $field . '=? ,';
            }
            $fi = rtrim($fi, ',');
            $fi .= ' WHERE id=' . $id;

            $result = $this->connection->prepare("UPDATE $this->table SET " . $fi);

            for ($i = 1; $i <= count($values); $i++)
                $result->bindValue($i, $values[$i - 1]);

            $result->execute();
            echo "Update OK";
        } catch (\PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public function delete($id)
    {
        try {
            $result = $this->connection->prepare("DELETE FROM $this->table WHERE id= $id");
            $result->execute();
        } catch (\PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public function get($id = '')
    {
        if (!empty($id)) {
            $result = $this->connection->prepare("SELECT * FROM $this->table where id= $id");
        } else {
            $result = $this->connection->prepare('SELECT * FROM '. $this->table);
        }
        $result->execute();

        $json = $result->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($json);
    }
}
