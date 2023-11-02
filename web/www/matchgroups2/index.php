<?php

/**
 * Sources used: https://cs4640.cs.virginia.edu, geeksforgeeks.com, stackoverflow.com, w3schools.com, getbootstrap.com
 * URL: https://cs4640.cs.virginia.edu/rsl7ej/matchgroups2
 * Authors: Russell Lee, rsl7ej & Luke Ostyn, lro3uck
 */

$base = "/students/rsl7ej/students/rsl7ej";
if (is_file("/.dockerenv")) {
    $base = "/opt";
}

error_reporting(E_ALL);
ini_set("display_errors", 1);

spl_autoload_register(function ($classname) {
    global $base;
    include "$base/src/matchgroups2/$classname.php";
});   

$matchGroups = new matchgroupsController($_GET);

$matchGroups->run();