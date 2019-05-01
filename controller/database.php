<?php
require_once 'config.php';
class Database
{
    private $connection;
    function __construct($config){
        $this->connection =  mysqli_connect($config['host'], $config['user'], $config['pass'], $config['database']) or die ("Error:: ".mysqli_connect_error());
    	mysqli_query($this->connection, "SET NAMES utf8");
    }
    
    function exec($sql){
        return mysqli_query($this->connection, $sql);
    }

    function insert($sql){
        if(!$this->exec($sql)) return false;
        return mysqli_insert_id($this->connection);
    }
    function fetchOne($sql){
        $result = Array();
        $query = $this-> exec($sql);
        if($query)  $result = mysqli_fetch_assoc($query);
        return $result;
    }

    function fetchAll($sql){
        $result = Array();
        $query = $this -> exec($sql);
        if(!$query) return $result;
        while($row = mysqli_fetch_assoc($query)){
            $result[] = $row;
        }
        return $result;
    }
}
if (!isset($database)) {
    $database = new Database($__config['database']);
}
    

?>