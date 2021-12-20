<?php

namespace Silkstream\EreborClay\Core;

// Requires mysqlnd

use mysqli;
use mysqli_result;
use mysqli_stmt;
use Silkstream\EreborClay\Common\Utility;

class DatabaseConnection {
    //static mysqli objects
    static private $_connections = array();
    //new class variables
    private $_name;
    private $_host;
    private $_username;
    private $_password;
    private $_database;

    //connection link
    public $mysqli;
    public $connection_error;

    function __construct($host = '', $username = '', $password = '', $database = '', $name = '') {
        //a name must be specified
        $this->connection_error = true;

        if ($host || $name) {
            $this->setConnection($host, $username, $password, $database, $name);
        }
    }

    private function setSettings() {
        if ($this->mysqli instanceof mysqli) {
            $this->mysqli->query("SET NAMES 'utf8';");
            $this->mysqli->set_charset('utf8');
            $this->mysqli->query("SET time_zone = '+00:00';"); // UTC
        }
    }

    public static function pushConnection($host = '', $username = '', $password = '', $database = '', $name = '') {
        if (!$name || !is_string($name)) $name = 'default';

        if (is_string($host) && is_string($username) && is_string($password) && is_string($database) && $name != '' && $host != '' && $username != '' && $password != '') {
            self::$_connections[$name] = array(
                'host' => $host,
                'username' => $username,
                'password' => $password,
                'database' => $database,
                'link' => false
            );
        }
    }

    public function setConnection($host = '', $username = '', $password = '', $database = '', $name = '') {
        if (!$name || !is_string($name)) $name = 'default';

        if ($host && is_string($host) && (!$username || !is_string($username))) {
            $name = $host;
            $host = false;
            $username = false;
            $password = false;
            $database = false;
        }

        $this->_name = $name;

        if (array_key_exists($name, self::$_connections) && is_array(self::$_connections[$name])) {
            $this->_host = self::$_connections[$name]['host'];
            $this->_username = self::$_connections[$name]['username'];
            $this->_password = self::$_connections[$name]['password'];
            $this->_database = self::$_connections[$name]['database'];

            if (self::$_connections[$name]['link'] instanceof mysqli && !self::$_connections[$name]['link']->connect_errno) {
                $this->mysqli = &self::$_connections[$name]['link'];
                return !($this->connection_error = false);
            }
        } else if ($host && $username && $password) {
            self::$_connections[$name] = array();

            $this->_host = self::$_connections[$name]['host'] = $host;
            $this->_username = self::$_connections[$name]['username'] = $username;
            $this->_password = self::$_connections[$name]['password'] = $password;
            $this->_database = self::$_connections[$name]['database'] = $database;
        }

        if ($this->_host && $this->_username && $this->_password) {
            self::$_connections[$name]['link'] = new mysqli($this->_host, $this->_username, $this->_password, $this->_database);
            $this->mysqli = &self::$_connections[$name]['link'];

            if ($this->mysqli && !$this->mysqli->connect_errno) {
                $this->setSettings();
                return !($this->connection_error = false);
            }
        }

        return !($this->connection_error = true);
    }

    public function errno() {
        return $this->mysqli->errno;
    }

    public function error() {
        return $this->mysqli->errno . ': ' . $this->mysqli->error;
    }

    public function setQuery($query) {
        if ($this->mysqli instanceof mysqli && $query) return $this->mysqli->query($query);
        return false;
    }

    public function setMultipleQueries($queries) {
        if ($this->mysqli instanceof mysqli && $queries) {
            $result = $this->mysqli->multi_query($queries);
            if ($result) while ($this->mysqli->more_results() && $this->mysqli->next_result()) {;}
        }
    }

    public function setHandle($handle) {
        if ($handle && $handle instanceof mysqli_stmt) {
            return $handle->execute();
        }
        return false;
    }

    public function prepare($query, $values = array()) {
        $handle = false;
        if ($this->mysqli instanceof mysqli && is_string($query)) {
            $handle = $this->mysqli->prepare($query);

            if ($handle && $handle instanceof mysqli_stmt) {

                //if $values is not set and is empty array then return with base handle
                if ((is_array($values) && count($values) == 0) || !$values) return $handle;

                //if $values is set but is a single value, place it in an array
                if ($values && !is_array($values)) $values = array($values);

                //References ($params, $types) are used for the call_user_func_array. Can't use static variables.

                if (!empty($values)) {
                    $params = array();
                    $types = '';
                    foreach ($values as &$value) {
                        if (is_int($value)) {
                            $types .= 'i';
                        } else if (is_double($value)) {
                            $types .= 'd';
                        } else {
                            $types .= 's';
                            $value = (string)$value;
                        }
                        $params[] = &$value;
                    }

                    //prepend the $params array with a temporary value.
                    array_unshift($params, 'tmp');
                    //Replace this value with the types reference.
                    $params[0] = &$types;

                    //USE BIND RESULT WHEN GETTING DATA (USE THE METHOD BELOW WITH BIND_RESULT)
                    call_user_func_array(array($handle, 'bind_param'), $params);
                }
            }
        }

        return $handle;
    }

    public function debugPrepare($query, $values = array()) {
        if ($this->mysqli instanceof mysqli && is_string($query)) {
            if (!is_array($values)) $values = array($values);
            $query = str_replace('%', '%%', $query);
            $query = preg_replace("/([^'])\?([^'])/","$1'?'$2",$query);
            foreach ($values as &$value) {
                if (is_array($value)) return '';
                $value = $this->mysqli->real_escape_string((string)$value);
            }
            $query = str_replace('?', '%s', $query);
            return vsprintf($query, $values);
        }
        return $query;
    }

    public function total($handle) {
        $rt = 0;
        if ($handle instanceof mysqli_stmt) {
            $handle->execute();
            $handle->store_result();
            $rt = $handle->num_rows;
        }
        return $rt;
    }

    public function getFieldNames($handle) {
        $rt = null;
        if ($handle instanceof mysqli_stmt) {
            $handle->execute();
            $meta = $handle->result_metadata();
            $fields_handle = $meta->fetch_fields();
            $fields = array();
            foreach ($fields_handle as $val) {
                $fields[] = $val->name;
            }
            $rt = $fields;
        }
        return $rt;
    }

    public function value($handle) {
        $rt = null;
        if ($handle instanceof mysqli_stmt) {
            $handle->execute();
            $handle->bind_result($trt);
            if ($handle->fetch()) {
                $rt = $trt;
            }
            $handle->free_result();
        }
        return $rt;
    }

    public function values($handle) {
        $rt = array();
        if ($handle instanceof mysqli_stmt) {
            $handle->execute();
            $handle->bind_result($trt);
            while ($handle->fetch()) {
                $rt[] = $trt;
            }
            $handle->free_result();
        }
        return $rt;
    }

    public function one($handle) {
        $rt = null;
        if ($handle instanceof mysqli_stmt) {
            $handle->execute();

            $values = array();
            $fields = array();
            $meta = $handle->result_metadata();

            while($field = $meta->fetch_field())
                $values[] = &$fields[$field->name]; // pass by reference

            call_user_func_array(array($handle, 'bind_result'), $values);

            if ($handle->fetch()) {
                $rt = array();
                foreach ($fields as $k=>$v)
                    $rt[$k] = $v;
            }

            $handle->free_result();
        }
        return $rt;
    }

    public function all($handle) {
        $rt = array();
        if ($handle instanceof mysqli_stmt) {
            $handle->execute();

            $values = array();
            $fields = array();
            $meta = $handle->result_metadata();

            while($field = $meta->fetch_field())
                $values[] = &$fields[$field->name]; // pass by reference

            call_user_func_array(array($handle, 'bind_result'), $values);

            $i=0;
            while ($handle->fetch())
            {
                $rt[$i] = array();
                foreach ($fields as $k=>$v)
                    $rt[$i][$k] = $v;
                $i++;
            }

            $handle->free_result();
        }
        return $rt;
    }

    public function time($unix_timestamp = false) {
        $datetime = $this->value($this->prepare("SELECT NOW();"));
        if ($unix_timestamp) return strtotime($datetime);
        else return $datetime;
    }

    public function insertId() {
        return $this->mysqli->insert_id;
    }

    public function enumColumnValues($table,$field) {
        $rt = array();
//        $table = Utility::alphaStrict($table,'LOWERCASE|UPPERCASE|NUMBER|_');
//        $field = Utility::alphaStrict($field,'LOWERCASE|UPPERCASE|NUMBER|_');
        if ($this->mysqli instanceof mysqli && $table && $field) {
            $query_result = $this->mysqli->query("SHOW COLUMNS FROM `{$table}` LIKE '{$field}'");
            if ($query_result instanceof mysqli_result) {
                $row = $query_result->fetch_array();
                $query_result->free_result();

                preg_match_all('/\'(.*?)\'/', $row[1], $enum_array);
                if (!empty($enum_array[1]))
                {
                    foreach ($enum_array[1] as $mkey => $mval) $rt[$mkey + 1] = $mval;
                }
            }
        }
        return $rt;
    }
}
