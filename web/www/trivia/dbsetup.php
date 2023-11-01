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
    $res  = pg_query($dbHandle, "drop sequence if exists question_seq;");
    $res  = pg_query($dbHandle, "drop sequence if exists user_seq;");
    $res  = pg_query($dbHandle, "drop sequence if exists userquestion_seq;");
    $res  = pg_query($dbHandle, "drop table if exists questions;");
    $res  = pg_query($dbHandle, "drop table if exists users;");

    // Create sequences
    $res  = pg_query($dbHandle, "create sequence question_seq;");
    $res  = pg_query($dbHandle, "create sequence user_seq;");
    $res  = pg_query($dbHandle, "create sequence userquestion_seq;");

    // Create tablse
    $res  = pg_query($dbHandle, "create table questions (
            id  int primary key default nextval('question_seq'),
            question    text,
            answer      text
    );");
    $res  = pg_query($dbHandle, "create table users (
            id  int primary key default nextval('user_seq'),
            name text,
            email text,
            password text,
            score int);");

    // Read json and insert the trivia questions into the database
    // Note: the URL is updated due to changes on the CS web server
    $questions = json_decode(
        file_get_contents("http://www.cs.virginia.edu/~jh2jf/data/trivia.json"), true);

    $res = pg_prepare($dbHandle, "myinsert", "insert into questions (question, answer) values 
    ($1, $2);");
    foreach ($questions as $q) {
            $res = pg_execute($dbHandle, "myinsert", [$q["question"], $q["answer"]]);
    }

