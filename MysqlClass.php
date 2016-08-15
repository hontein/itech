<?php
include_once "config.php";


/**
 * Class for work with Mysql
 * @author Roman Morozov <mrm1989@mail.ru>
 */
class MysqlClass
{

    private $server, $user, $pass, $dbname, $db, $mysqli;

    function __construct($server, $user, $pass, $dbname)
    {
        $this->server = $server;
        $this->user = $user;
        $this->pass = $pass;
        $this->dbname = $dbname;
        $this->openConnection();
    }

    private function openConnection()
    {
        if (!$this->db) {
            $this->mysqli = new mysqli($this->server, $this->user, $this->pass, $this->dbname);
            if ($this->mysqli->connect_errno) {
                return false;
            }

            $selectDB = $this->mysqli->select_db("$this->dbname");
            if ($selectDB) {
                $this->db = true;
                $this->mysqli->query('SET NAMES UTF8');
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }

    }

    public function select($what, $from, $where = null, $order = null)
    {

        $fetched = array();
        $sql = 'SELECT ' . $what . ' FROM ' . $from;
        if ($where != null) $sql .= ' WHERE ' . $where;
        if ($order != null) $sql .= ' ORDER BY ' . $order;

        $query = $this->mysqli->query($sql);
        if ($query && !empty($query)) {
            if (!($rows = mysqli_num_rows($query)))
                return false;
            for ($i = 0; $i < $rows; $i++) {
                $results = mysqli_fetch_assoc($query);
                $key = array_keys($results);
                $numKeys = count($key);
                for ($x = 0; $x < $numKeys; $x++) {
                    $fetched[$i][$key[$x]] = $results[$key[$x]];
                }
            }
            return $fetched;
        } else {
            return false;
        }
    }


    public function insert($table, $values, $rows = null)
    {

        $insert = 'INSERT INTO ' . $table;
        if ($rows != null) {
            $insert .= ' (' . $rows . ')';
        }
        $numValues = count($values);
        for ($i = 0; $i < $numValues; $i++) {
            if (is_string($values[$i])) $values[$i] = '"' . $values[$i] . '"';
        }
        $values = implode(',', $values);
        $insert .= ' VALUES (' . $values . ')';
        $ins = $this->mysqli->query($insert);
        return ($ins) ? true : false;

    }

    public function update($table, $rows, $where, $condition)
    {

        $where = implode($condition, $where);
        $update = 'UPDATE ' . $table . ' SET ';
        $keys = array_keys($rows);
        for ($i = 0; $i < count($rows); $i++) {
            if (is_string($rows[$keys[$i]])) {
                $update .= $keys[$i] . '="' . $rows[$keys[$i]] . '"';
            } else {
                $update .= $keys[$i] . '=' . $rows[$keys[$i]];
            }

            if ($i != count($rows) - 1) {
                $update .= ',';
            }
        }
        $update .= ' WHERE ' . $where;
        $query = $this->mysqli->query($update);
        if ($query) {
            return true;
        } else {
            return false;
        }

    }

    public
    function delete($table, $where = null)
    {

        $sql = 'DELETE FROM ' . $table . ' WHERE ' . $where;
        if ($where == null) {
            $sql = 'DELETE ' . $table;
        }
        $deleted = $this->mysqli->query($sql);
        return ($deleted) ? true : false;
    }

    public
    function closeConnection()
    {
        if ($this->db) {
            if ($this->mysqli->close()) {
                $this->db = false;
                return true;
            } else {
                return false;
            }
        }
    }

}

