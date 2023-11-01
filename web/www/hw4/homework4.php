<?php
    /**
     * Homework 4 - PHP Introduction
     *
     * Computing ID: rsl7ej
     * Resources used: php.net, w3schools.com, geeksforgeeks.com
     */
     
    // Your functions here


function calculateGrade($scores, $drop) {

    $lowest_score = 0;
    $lowest_max = 0;
    $lowest_overall = INF;
    $total_score = 0;
    $total_max = 0;

    foreach ($scores as $key => $value) {
        $total_score += $value["score"];
        $total_max += $value["max_points"];
        if (($value["score"] / $value["max_points"]) < $lowest_overall) {
            $lowest_overall = ($value["score"] / $value["max_points"]);
            $lowest_score = $value["score"];
            $lowest_max = $value["max_points"];
        }
    }

    if ($drop == true) {
        $total_score -= $lowest_score;
        $total_max -= $lowest_max;
    }

    if ($total_max == 0) {
        return 0.0;
    }

    return round(100 * ($total_score / $total_max), 3);

}

function gridCorners($width, $height) {

    if (($width == 0) || ($height == 0)) {
        return "";
    }

    $return_string = "1";
    if (($width == 1) || ($height == 1)) {
        if (($width == 1) && ($height == 1)) {
            return $return_string;
        }
        if ($width > 1) {
            $condition = $width;
        } else {
            $condition = $height;
        }
        for ($i = 2; $i <= $condition; $i++) {
            $return_string .= ", $i";
        }
        return $return_string;
    }

    $corner1 = 1;
    $corner2 = $height;
    $corner3 = ($height * ($width - 1)) + 1;
    $corner4 = $height * $width;

    $corner_array = [];

    if ($height > 3) {
        array_push($corner_array, ($corner1 + 1));
    }
    if ($height > 2) {
        array_push($corner_array, ($corner2 - 1));
    }
    array_push($corner_array, $corner2);
    if ($width > 2) {
        array_push($corner_array, ($corner1 + $height));
    }
    if ($width > 2) {
        array_push($corner_array, ($corner2 + $height));
    }
    if ($width > 3) {
        array_push($corner_array, ($corner3 - $height));
    }
    if ($width > 3) {
        array_push($corner_array, ($corner4 - $height));
    }
    array_push($corner_array, $corner3);
    if ($height > 3) {
        array_push($corner_array, ($corner3 + 1));
    }
    if ($height > 2) {
        array_push($corner_array, ($corner4 - 1));
    }
    if ($height > 1) {
        array_push($corner_array, $corner4);
    }

    $length = count($corner_array);

    foreach ($corner_array as $value) {
        $return_string .= ", $value";
    }

    return $return_string;
    
}

function combineShoppingLists(...$lists) {

    $users = [];
    $return_list = [];

    foreach ($lists as $list) {
        if (!(array_key_exists("list", $list)) || !(array_key_exists("user", $list))) {
            continue;
        }
        $user = $list["user"];
        if (isset($users[$user])) {
            continue;
        }
        $users[$user] = "";
        foreach ($list["list"] as $item) {
            if (array_key_exists($item, $return_list)) {
                array_push($return_list[$item], $user);
            } else {
                $return_list[$item] = [ $user];
            }
        }  
    }

    ksort($return_list);

    return $return_list;
}

function validateEmail($email, $regex = "not assigned") {
    $baseline = "/^[a-zA-Z0-9+_\-]+(|[a-zA-Z0-9+_.\-]*[a-zA-Z0-9+_\-]+)@[a-zA-Z0-9]+[a-zA-Z0-9.\-]*\.[a-zA-Z0-9.\-]*[a-zA-Z0-9]+$/";
    if (preg_match($baseline, $email) == 0) {
        return false;
    }
    if ($regex != "not assigned") {
        if (preg_match($regex, $email) == 0) {
            return false;
        }
    }
    return true;
}



    // No closing php tag needed since there is only PHP in this file
