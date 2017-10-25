<?php
include_once 'IConnection.php';
include_once 'errorHandler.php';


class MySQL implements IConnection
{
    protected $db;
    protected $queries;

    public function __construct()
    {

    }

    public function getSql($name)
    {
        return isset($this->queries[$name]) ? $this->queries[$name] : false;
    }

    public function connect($hostname, $username, $password, $database, $port,$socket,$charset)
    {
        $db = mysqli_init();
        if (defined('MYSQLI_OPT_INT_AND_FLOAT_NATIVE')) {
            mysqli_options($db, MYSQLI_OPT_INT_AND_FLOAT_NATIVE, true);
        }
        $success = mysqli_connect($hostname, $username, $password, $database, $port);
        if (!$success) {
            throw new \Exception('Connect failed. ' . mysqli_connect_error());
        }
        if (!mysqli_set_charset($db, $charset)) {
            throw new \Exception('Error setting charset. ' . mysqli_error($db));
        }
        if (!mysqli_query($db, 'SET SESSION sql_mode = \'ANSI_QUOTES\';')) {
            throw new \Exception('Error setting ANSI quotes. ' . mysqli_error($db));
        }
        $this->db = $db;
    }
    public function connect_simple($hostname,$username,$password) {
        $db = mysqli_init();

        $this->db = $db;
    }

    public function query($sql, $params = array())
    {
        $db = $this->db;
        $sql = preg_replace_callback('/\!|\?/', function ($matches) use (&$db, &$params) {
            $param = array_shift($params);
            if ($matches[0] == '!') {
                $key = preg_replace('/[^a-zA-Z0-9\-_=<> ]/', '', is_object($param) ? $param->key : $param);
                if (is_object($param) && $param->type == 'hex') {
                    return "HEX(\"$key\") as \"$key\"";
                }
                if (is_object($param) && $param->type == 'wkt') {
                    return "ST_AsText(\"$key\") as \"$key\"";
                }
                return '"' . $key . '"';
            } else {
                if (is_array($param)) return '(' . implode(',', array_map(function ($v) use (&$db) {
                        return "'" . mysqli_real_escape_string($db, $v) . "'";
                    }, $param)) . ')';
                if (is_object($param) && $param->type == 'hex') {
                    return "x'" . $param->value . "'";
                }
                if (is_object($param) && $param->type == 'wkt') {
                    return "ST_GeomFromText('" . mysqli_real_escape_string($db, $param->value) . "')";
                }
                if ($param === null) return 'NULL';
                return "'" . mysqli_real_escape_string($db, $param) . "'";
            }
        }, $sql);
        //if (!strpos($sql,'INFORMATION_SCHEMA')) echo "\n$sql\n";
        //if (!strpos($sql,'INFORMATION_SCHEMA')) file_put_contents('log.txt',"\n$sql\n",FILE_APPEND);
        return mysqli_query($db, $sql);
    }

    public function fetchAssoc($result)
    {
        return mysqli_fetch_assoc($result);
    }

    public function fetchRow($result)
    {
        return mysqli_fetch_row($result);
    }

    public function insertId($result)
    {
        return mysqli_insert_id($this->db);
    }

    public function affectedRows($result)
    {
        return mysqli_affected_rows($this->db);
    }

    public function close($result)
    {
        return mysqli_free_result($result);
    }

    public function fetchFields($table)
    {
        $result = $this->query('SELECT * FROM ! WHERE 1=2;', array($table));
        return mysqli_fetch_fields($result);
    }

    public function addLimitToSql($sql, $limit, $offset)
    {
        return "$sql LIMIT $limit OFFSET $offset";
    }

    public function likeEscape($string)
    {
        return addcslashes($string, '%_');
    }

    public function convertFilter($field, $comparator, $value)
    {
        return false;
    }

    public function isNumericType($field)
    {
        return in_array($field->type, array(1, 2, 3, 4, 5, 6, 8, 9));
    }

    public function isBinaryType($field)
    {
        //echo "$field->name: $field->type ($field->flags)\n";
        return (($field->flags & 128) && (($field->type >= 249 && $field->type <= 252) || ($field->type >= 253 && $field->type <= 254 && $field->charsetnr == 63)));
    }

    public function isGeometryType($field)
    {
        return ($field->type == 255);
    }

    public function isJsonType($field)
    {
        return ($field->type == 245);
    }

    public function getDefaultCharset()
    {
        return 'utf8';
    }

    public function beginTransaction()
    {
        mysqli_query($this->db, 'BEGIN');
        //return mysqli_begin_transaction($this->db);
    }

    public function commitTransaction()
    {
        mysqli_query($this->db, 'COMMIT');
        //return mysqli_commit($this->db);
    }

    public function rollbackTransaction()
    {
        mysqli_query($this->db, 'ROLLBACK');
        //return mysqli_rollback($this->db);
    }

    public function jsonEncode($object)
    {
        return json_encode($object);
    }

    public function jsonDecode($string)
    {
        return json_decode($string);
    }

    public function insertQuery($username,$password)
    {
        $this->query($this->db,"insert into USER (email,password)VALUES '$username','$password';");
    }
}