<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

spl_autoload_register(function ($classname) {
    include "/opt/src/matchgroups2/$classname.php";
});
        

$matchGroups = new matchgroupsController($_GET);

$matchGroups->run();