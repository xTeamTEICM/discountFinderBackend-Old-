<?php
/**
 * Created by PhpStorm.
 * User: paulkokos
 * Date: 17/10/2017
 * Time: 4:58 πμ
 */
class PostgreSQL implements DatabaseInterface
{
    protected $db;
    protected $queries;

    public function __construct()
    {
        $this->queries = array(
            'list_tables' => 'select
					"table_name",\'\' as "table_comment"
				from
					"information_schema"."tables"
				where
					"table_schema" = \'public\' and
					"table_catalog" = ?',
            'reflect_table' => 'select
					"table_name"
				from
					"information_schema"."tables"
				where
					"table_name" = ? and
					"table_schema" = \'public\' and
					"table_catalog" = ?',
            'reflect_pk' => 'select
					"column_name"
				from
					"information_schema"."table_constraints" tc,
					"information_schema"."key_column_usage" ku
				where
					tc."constraint_type" = \'PRIMARY KEY\' and
					tc."constraint_name" = ku."constraint_name" and
					ku."table_name" = ? and
					ku."table_schema" = \'public\' and
					ku."table_catalog" = ?',
            'reflect_belongs_to' => 'select
					cu1."table_name",cu1."column_name",
					cu2."table_name",cu2."column_name"
				from
					"information_schema".referential_constraints rc,
					"information_schema".key_column_usage cu1,
					"information_schema".key_column_usage cu2
				where
					cu1."constraint_name" = rc."constraint_name" and
					cu2."constraint_name" = rc."unique_constraint_name" and
					cu1."table_name" = ? and
					cu2."table_name" in ? and
					cu1."table_schema" = \'public\' and
					cu2."table_schema" = \'public\' and
					cu1."table_catalog" = ? and
					cu2."table_catalog" = ?',
            'reflect_has_many' => 'select
					cu1."table_name",cu1."column_name",
					cu2."table_name",cu2."column_name"
				from
					"information_schema".referential_constraints rc,
					"information_schema".key_column_usage cu1,
					"information_schema".key_column_usage cu2
				where
					cu1."constraint_name" = rc."constraint_name" and
					cu2."constraint_name" = rc."unique_constraint_name" and
					cu1."table_name" in ? and
					cu2."table_name" = ? and
					cu1."table_schema" = \'public\' and
					cu2."table_schema" = \'public\' and
					cu1."table_catalog" = ? and
					cu2."table_catalog" = ?',
            'reflect_habtm' => 'select
					cua1."table_name",cua1."column_name",
					cua2."table_name",cua2."column_name",
					cub1."table_name",cub1."column_name",
					cub2."table_name",cub2."column_name"
				from
					"information_schema".referential_constraints rca,
					"information_schema".referential_constraints rcb,
					"information_schema".key_column_usage cua1,
					"information_schema".key_column_usage cua2,
					"information_schema".key_column_usage cub1,
					"information_schema".key_column_usage cub2
				where
					cua1."constraint_name" = rca."constraint_name" and
					cua2."constraint_name" = rca."unique_constraint_name" and
					cub1."constraint_name" = rcb."constraint_name" and
					cub2."constraint_name" = rcb."unique_constraint_name" and
					cua1."table_catalog" = ? and
					cub1."table_catalog" = ? and
					cua2."table_catalog" = ? and
					cub2."table_catalog" = ? and
					cua1."table_schema" = \'public\' and
					cub1."table_schema" = \'public\' and
					cua2."table_schema" = \'public\' and
					cub2."table_schema" = \'public\' and
					cua1."table_name" = cub1."table_name" and
					cua2."table_name" = ? and
					cub2."table_name" in ?',
            'reflect_columns' => 'select
					"column_name", "column_default", "is_nullable", "data_type", "character_maximum_length"
				from 
					"information_schema"."columns" 
				where
					"table_name" = ? and
					"table_schema" = \'public\' and
					"table_catalog" = ?
				order by
					"ordinal_position"'
        );
    }

    public function getSql($name)
    {
        return isset($this->queries[$name]) ? $this->queries[$name] : false;
    }

    public function connect($hostname, $username, $password, $database, $port, $socket, $charset)
    {
        $e = function ($v) {
            return str_replace(array('\'', '\\'), array('\\\'', '\\\\'), $v);
        };
        $conn_string = '';
        if ($hostname || $socket) {
            if ($socket) $hostname = $e($socket);
            else $hostname = $e($hostname);
            $conn_string .= " host='$hostname'";
        }
        if ($port) {
            $port = ($port + 0);
            $conn_string .= " port='$port'";
        }
        if ($database) {
            $database = $e($database);
            $conn_string .= " dbname='$database'";
        }
        if ($username) {
            $username = $e($username);
            $conn_string .= " user='$username'";
        }
        if ($password) {
            $password = $e($password);
            $conn_string .= " password='$password'";
        }
        if ($charset) {
            $charset = $e($charset);
            $conn_string .= " options='--client_encoding=$charset'";
        }
        $db = pg_connect($conn_string);
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
                    return "encode(\"$key\",'hex') as \"$key\"";
                }
                if (is_object($param) && $param->type == 'wkt') {
                    return "ST_AsText(\"$key\") as \"$key\"";
                }
                return '"' . $key . '"';
            } else {
                if (is_array($param)) return '(' . implode(',', array_map(function ($v) use (&$db) {
                        return "'" . pg_escape_string($db, $v) . "'";
                    }, $param)) . ')';
                if (is_object($param) && $param->type == 'hex') {
                    return "'\x" . $param->value . "'";
                }
                if (is_object($param) && $param->type == 'wkt') {
                    return "ST_GeomFromText('" . pg_escape_string($db, $param->value) . "')";
                }
                if ($param === null) return 'NULL';
                return "'" . pg_escape_string($db, $param) . "'";
            }
        }, $sql);
        if (strtoupper(substr($sql, 0, 6)) == 'INSERT') {
            $sql .= ' RETURNING id;';
        }
        //echo "\n$sql\n";
        return @pg_query($db, $sql);
    }

    public function fetchAssoc($result)
    {
        return pg_fetch_assoc($result);
    }

    public function fetchRow($result)
    {
        return pg_fetch_row($result);
    }

    public function insertId($result)
    {
        list($id) = pg_fetch_row($result);
        return (int)$id;
    }

    public function affectedRows($result)
    {
        return pg_affected_rows($result);
    }

    public function close($result)
    {
        return pg_free_result($result);
    }

    public function fetchFields($table)
    {
        $result = $this->query('SELECT * FROM ! WHERE 1=2;', array($table));
        $keys = array();
        for ($i = 0; $i < pg_num_fields($result); $i++) {
            $field = array();
            $field['name'] = pg_field_name($result, $i);
            $field['type'] = pg_field_type($result, $i);
            $keys[$i] = (object)$field;
        }
        return $keys;
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
        return in_array($field->type, array('int2', 'int4', 'int8', 'float4', 'float8'));
    }

    public function isBinaryType($field)
    {
        return $field->type == 'bytea';
    }

    public function isGeometryType($field)
    {
        return $field->type == 'geometry';
    }

    public function isJsonType($field)
    {
        return in_array($field->type, array('json', 'jsonb'));
    }

    public function getDefaultCharset()
    {
        return 'UTF8';
    }

    public function beginTransaction()
    {
        return $this->query('BEGIN');
    }

    public function commitTransaction()
    {
        return $this->query('COMMIT');
    }

    public function rollbackTransaction()
    {
        return $this->query('ROLLBACK');
    }

    public function jsonEncode($object)
    {
        return json_encode($object);
    }

    public function jsonDecode($string)
    {
        return json_decode($string);
    }
}