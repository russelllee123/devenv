<?php

/**
 * Sources used: https://cs4640.cs.virginia.edu, geeksforgeeks.com, stackoverflow.com, w3schools.com, getbootstrap.com
 * URL: https://cs4640.cs.virginia.edu/rsl7ej/matchgroups2
 * Authors: Russell Lee, rsl7ej & Luke Ostyn, lro3uck
 */

class Database {
    
    private $dbConnector;

    /**
     * Reads configuration from the Config class above
     */
    public function __construct() {
        $host = Config::$db["host"];
        $user = Config::$db["user"];
        $database = Config::$db["database"];
        $password = Config::$db["pass"];
        $port = Config::$db["port"];

        if (!is_file("/.dockerenv")) {
            $host = ServerConfig::$db["host"];
            $user = ServerConfig::$db["user"];
            $database = ServerConfig::$db["database"];
            $password = ServerConfig::$db["pass"];
            $port = ServerConfig::$db["port"];
        }

        $this->dbConnector = pg_connect("host=$host port=$port dbname=$database user=$user password=$password");
    }

    public function query($query, ...$params) {
        // Use safe querying
        $res = pg_query_params($this->dbConnector, $query, $params);

        // If there was an error, print it out
        if ($res === false) {
            echo pg_last_error($this->dbConnector);
            return false;
        }

        // Return an array of associative arrays (the rows
        // in the database)
        return pg_fetch_all($res);
    }
}