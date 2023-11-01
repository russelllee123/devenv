<?php

// Site Link: https://cs4640.cs.virginia.edu/rsl7ej/hw5
// Sources used: https://cs4640.cs.virginia.edu, stackoverflow.com, php.net
// Russell Lee, rsl7ej

$base = "/students/rsl7ej/students/rsl7ej";
if (is_file("/.dockerenv")) {
    $base = "/opt";
}

error_reporting(E_ALL);
ini_set("display_errors", 1);

spl_autoload_register(function ($classname) {
    global $base;
    include "$base/src/hw5/$classname.php";
});   

$categories = new CategoryGameController($_GET);

$categories->run();
