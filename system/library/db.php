<?php

final class DB {

    private $driver;

    public function __construct($driver, $hostname, $username, $password, $database) {
        if (file_exists(DIR_DATABASE . $driver . '.php')) {
            require_once(DIR_DATABASE . $driver . '.php');
        } else {
            exit('Error: Could not load database file ' . $driver . '!');
        }

        $this->driver = new $driver($hostname, $username, $password, $database);
    }

    public function query($sql) {

        //$time_start = microtime(true);

        $result = $this->driver->query($sql);
        //$time_end = microtime(true);
        //$time = $time_end - $time_start;
        //echo $sql . "--" . $time . "<br>";
        return $result;
    }

    public function escape($value) {
        return $this->driver->escape($value);
    }

    public function countAffected() {
        return $this->driver->countAffected();
    }

    public function getLastId() {
        return $this->driver->getLastId();
    }

}

?>