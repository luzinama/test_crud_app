<?php

class Database
{
    private $dbHost = "localhost";
    private $dbUsername = "root";
    private $dbPassword = "";
    private $dbName = "test_crud_app";
    private $dbExists = true;

    public $db = null;
    public $result = null;

    public function __construct()
    {
        if (!isset($this->db)) {
            // Connect to the database
            try {
                $conn = new PDO("mysql:host=" . $this->dbHost . ";dbname=" . $this->dbName, $this->dbUsername, $this->dbPassword);
                $this->db = $conn;
            } catch (PDOException $e) {
                if ($e->getCode() === 1049) {
                    $this->dbExists = false;
                }
            }
        }
    }

    /**
     * Returns rows from the database based on the conditions
     * @param string $table name of the table
     * @param array $conditions select, where, order_by, limit and return_type conditions
     * @return array|int|mixed|string|bool
     */
    public function select($table, $conditions = [])
    {
        $sql = 'SELECT ';
        $sql .= array_key_exists("select", $conditions) ? $conditions['select'] : '*';
        $sql .= ' FROM ' . $table;
        if (array_key_exists("where", $conditions)) {
            $sql .= ' WHERE ';
            $i = 0;
            foreach ($conditions['where'] as $key => $value) {
                $pre = ($i > 0) ? ' AND ' : '';
                $sql .= $pre . $key . " = '" . $value . "'";
                $i++;
            }
        }

        if (array_key_exists("order_by", $conditions)) {
            $sql .= ' ORDER BY ' . $conditions['order_by'];
        }

        if (array_key_exists("start", $conditions) && array_key_exists("limit", $conditions)) {
            $sql .= ' LIMIT ' . $conditions['start'] . ',' . $conditions['limit'];
        } elseif (!array_key_exists("start", $conditions) && array_key_exists("limit", $conditions)) {
            $sql .= ' LIMIT ' . $conditions['limit'];
        }

        $query = $this->db->prepare($sql);
        $query->execute();

        if (array_key_exists("return_type", $conditions) && $conditions['return_type'] != 'all') {
            switch ($conditions['return_type']) {
                case 'count':
                    $data = $query->rowCount();
                    break;
                case 'single':
                    $data = $query->fetch(PDO::FETCH_ASSOC);
                    break;
                default:
                    $data = '';
            }
        } else {
            if ($query->rowCount() > 0) {
                $data = $query->fetchAll();
            }
        }
        return !empty($data) ? $data : false;
    }

    /**
     * Insert data into the database
     * @param string $table name of the table
     * @param array $data the data for inserting into the table
     * @return bool|string
     */
    public function insert($table, $data)
    {
        if (!empty($data) && is_array($data)) {
            if (!array_key_exists('created', $data)) {
                $data['created'] = date('Y-m-d H:i:s',time());
            }
            if (!array_key_exists('updated', $data)) {
                $data['updated'] = date('Y-m-d H:i:s',time());
            }

            $columnString = implode(',', array_keys($data));
            $valueString = ":" . implode(',:', array_keys($data));
            $sql = "INSERT INTO " . $table . " (" . $columnString . ") VALUES (" . $valueString . ")";
            $query = $this->db->prepare($sql);
            foreach ($data as $key => $val) {
                $query->bindValue(':' . $key, $val);
            }
            try {
                $insert = $query->execute();
            } catch (PDOException $e) {
                die('Произошла ошибка добавления данных: '.$e->getMessage());
            }
            return $insert ? $this->db->lastInsertId() : false;
        } else {
            return false;
        }
    }

    /**
     * Update data into the database
     * @param string $table name of the table
     * @param array $data the data for updating into the table
     * @param array $conditions where condition on updating data
     * @return bool|int
     */
    public function update($table, $data, $conditions)
    {
        if (!empty($data) && is_array($data)) {
            $colvalSet = '';
            $i = 0;
            if (!array_key_exists('updated', $data)) {
                $data['updated'] = date("Y-m-d H:i:s");
            }
            foreach ($data as $key => $val) {
                $pre = ($i > 0) ? ', ' : '';
                $colvalSet .= $pre . $key . "='" . $val . "'";
                $i++;
            }
            $whereSql = $this->getWhereSql($conditions);
            $sql = "UPDATE " . $table . " SET " . $colvalSet . $whereSql;
            $query = $this->db->prepare($sql);

            try {
                $update = $query->execute();
            } catch (PDOException $e) {
                die('Произошла ошибка обновления данных: '.$e->getMessage());
            }
            return $update ? $query->rowCount() : false;
        } else {
            return false;
        }
    }

    /**
     * Delete data from the database
     * @param string $table name of the table
     * @param array $conditions where condition on deleting data
     * @return bool|int
     */
    public function delete($table, $conditions)
    {
        $whereSql = $this->getWhereSql($conditions);
        $sql = "DELETE FROM " . $table . $whereSql;
        try {
            $delete = $this->db->exec($sql);
        } catch (PDOException $e) {
            die('Произошла ошибка удаления данных: '.$e->getMessage());
        }

        return $delete ? $delete : false;
    }

    /**
     * @param $conditions
     * @return string
     */
    public function getWhereSql($conditions) {
        $whereSql = '';
        if (!empty($conditions) && is_array($conditions)) {
            $whereSql .= ' WHERE ';
            $i = 0;
            foreach ($conditions as $key => $value) {
                $pre = ($i > 0) ? ' AND ' : '';
                $whereSql .= $pre . $key . " = '" . $value . "'";
                $i++;
            }
        }
        return $whereSql;
    }

    /**
     * @return bool
     */
    public function isDbExists()
    {
        return $this->dbExists;
    }

    /**
     * @param bool $dbExists
     */
    public function setDbExists($dbExists)
    {
        $this->dbExists = $dbExists;
    }
}