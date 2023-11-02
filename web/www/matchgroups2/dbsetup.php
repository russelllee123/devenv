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


