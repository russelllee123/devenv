<?php

/**
 * Sources used: https://cs4640.cs.virginia.edu, geeksforgeeks.com, stackoverflow.com, w3schools.com, getbootstrap.com
 * URL: https://cs4640.cs.virginia.edu/rsl7ej/matchgroups2
 * Authors: Russell Lee, rsl7ej & Luke Ostyn, lro3uck
 */


error_reporting(E_ALL);
ini_set("display_errors", 1);

$base = "/students/rsl7ej/students/rsl7ej";
if (is_file("/.dockerenv")) {
    $base = "/opt";
}

spl_autoload_register(function ($classname) {
    global $base;
    include "$base/src/matchgroups2/$classname.php";
});   

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

$dbHandle = pg_connect("host=$host port=$port dbname=$database user=$user password=$password");

if ($dbHandle) {
    echo "Success connecting to database";
} else {
    echo "An error occurred connecting to the database";
}

// Drop tables and sequences
$res  = pg_query($dbHandle, "drop sequence if exists user_seq;");
$res  = pg_query($dbHandle, "drop table if exists users;");
$res  = pg_query($dbHandle, "drop sequence if exists likes_seq;");
$res  = pg_query($dbHandle, "drop table if exists likes;");
$res  = pg_query($dbHandle, "drop sequence if exists dislikes_seq;");
$res  = pg_query($dbHandle, "drop table if exists dislikes;");
$res  = pg_query($dbHandle, "drop sequence if exists messages_seq;");
$res  = pg_query($dbHandle, "drop table if exists messages;");

$res  = pg_query($dbHandle, "create sequence user_seq;");

$res  = pg_query($dbHandle, "create table users (
        id  int primary key default nextval('user_seq'),
        name text,
        email text,
        password text,
        description text,
        members text,
        image1 text,
        image2 text);");

$res  = pg_query($dbHandle, "create sequence likes_seq;");

$res = pg_query($dbHandle, "create table likes (
        id  int primary key default nextval('likes_seq'),
        requestor int REFERENCES users(id),
        reciever int REFERENCES users(id));");

$res  = pg_query($dbHandle, "create sequence dislikes_seq;");

$res = pg_query($dbHandle, "create table dislikes (
        id  int primary key default nextval('dislikes_seq'),
        requestor int REFERENCES users(id),
        reciever int REFERENCES users(id));");

$res  = pg_query($dbHandle, "create sequence messages_seq;");

$res = pg_query($dbHandle, "create table messages (
        id  int primary key default nextval('messages_seq'),
        sender int REFERENCES users(id),
        recipient int REFERENCES users(id),
        message text,
        time int);");


