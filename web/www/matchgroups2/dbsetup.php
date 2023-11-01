<?php

    $host = "db";
    $port = "5432";
    $database = "example";
    $user = "localuser";
    $password = "cs4640LocalUser!"; 

    $dbHandle = pg_connect("host=$host port=$port dbname=$database user=$user password=$password");

    if ($dbHandle) {
        echo "Success connecting to database";
    } else {
        echo "An error occurred connecting to the database";
    }

    // Drop tables and sequences
    $res  = pg_query($dbHandle, "drop sequence if exists user_seq;");
    $res  = pg_query($dbHandle, "drop table if exists users;");

    // Create sequences
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



