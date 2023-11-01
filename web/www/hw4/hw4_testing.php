<?php
    include("homework4.php");
?><!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">  
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="Russell Lee, rsl7ej">
  <meta name="description" content="Homework4 Testing File">  
    
  <title>Homework 4 Test File</title>
</head>
<body>
<h1>Homework 4 Test File</h1>

<h2>Problem 1</h2>
<?php

    echo "Tests for Problem 1: <br>";
    $test1 = [ [ "score" => 55, "max_points" => 100 ] ];
    echo "Should be 55: " . calculateGrade($test1, false) . "<br>";
    $test2 = [ [ "score" => 55, "max_points" => 100 ], [ "score" => 55, "max_points" => 100 ] ];
    echo "Should be 55: " . calculateGrade($test2, false) . "<br>";
    $test3 = [ [ "score" => 55, "max_points" => 100 ], [ "score" => 55, "max_points" => 100 ] ,  [ "score" => 55, "max_points" => 100 ], [ "score" => 55, "max_points" => 100 ] ];
    echo "Should be 55: " . calculateGrade($test3, true) . "<br>";
    $test4 = [ [ "score" => 55, "max_points" => 100 ], [ "score" => 55, "max_points" => 100 ] ,  [ "score" => 55, "max_points" => 100 ], [ "score" => 20, "max_points" => 100 ] ];
    echo "Should be 55: " . calculateGrade($test4, true) . "<br>";
    $test5 = [ [ "score" => 50, "max_points" => 100 ], [ "score" => 51, "max_points" => 99 ], [ "score" => 52, "max_points" => 98 ], [ "score" => 53, "max_points" => 97 ]];
    echo "Should be 52.304: " . calculateGrade($test5, false) . "<br>";
    $test5 = [ [ "score" => 50, "max_points" => 100 ], [ "score" => 51, "max_points" => 99 ], [ "score" => 52, "max_points" => 98 ], [ "score" => 53, "max_points" => 97 ]];
    echo "Should be 53.072: " . calculateGrade($test5, true) . "<br>";
    echo "<br>";
    echo "Tests for Problem 2: <br>";
    echo 'Should be "": "' . gridCorners(0, 1) . '" <br>';
    echo 'Should be "": "' . gridCorners(1, 0) . '" <br>';
    echo 'Should be "1": "' . gridCorners(1, 1) . '" <br>';
    echo 'Should be "1, 2": "' . gridCorners(1, 2) . '" <br>';
    echo 'Should be "1, 2": "' . gridCorners(2, 1) . '" <br>';
    echo 'Should be "1, 2, 3": "' . gridCorners(1, 3) . '" <br>';
    echo 'Should be "1, 2, 3": "' . gridCorners(3, 1) . '" <br>';
    echo 'Should be "1, 2, 3, 4, 5": "' . gridCorners(1, 5) . '" <br>';
    echo 'Should be "1, 2, 3, 4, 5": "' . gridCorners(5, 1) . '" <br>';
    echo 'Should be "1, 2, 3, 4, 5, 8, 9, 10, 11, 12": "' . gridCorners(3, 4) . '" <br>';
    echo 'Should be "": "' . gridCorners(1917, 1606) . '" <br>';
    echo "<br>";
    echo "Tests for Problem 3: <br>";
    $list1 = [ "user" => "Fred", 
           "list" => ["frozen pizza", "bread", "apples", "oranges"]
         ];
    $list2 = [ "user" => "Wilma",
           "list" => ["bread", "apples", "coffee"]
         ];
    $list3 = [
            "apples" => [ "Fred", "Wilma" ],
            "bread" => [ "Fred", "Wilma" ],
            "coffee" => [ "Wilma" ],
            "frozen pizza" => [ "Fred" ],
            "oranges" => [ "Fred" ]
          ];
    if (combineShoppingLists($list1, $list2) === $list3) {
      echo "Combined Correctly";
    } else {
      echo "Combined Incorrectly";
    }
    echo "<br>";
    $list1 = [ "user" => "Fred", 
        "list" => ["frozen pizza"]
      ];
    $list2 = [ "user" => "Wilma",
        "list" => ["frozen pizza"]
      ];
    $list3 = [ "user" => "John",
      "list" => ["frozen pizza"]
    ];
    $list4 = [
      "frozen pizza" => [ "Fred", "Wilma", "John" ]
    ];
    if (combineShoppingLists($list1, $list2, $list3) === $list4) {
    echo "Combined Correctly";
    } else {
    echo "Combined Incorrectly";
    }
    echo "<br>";
    $list1 = [ "user" => "Fred", 
        "list" => []
      ];
    $list2 = [ "user" => "Wilma",
        "list" => []
      ];
    $list3 = [
      ];
    if (combineShoppingLists($list1, $list2) === $list3) {
    echo "Combined Correctly";
    } else {
    echo "Combined Incorrectly";
    }
    echo "<br>";
    $list1 = [ "user" => "Fred", 
        "list" => ["frozen pizza"]
      ];
    $list2 = [ "user" => "Wilma",
        "list" => ["frozen pizza"]
      ];
    $list3 = [ "user" => "Fred",
      "list" => ["frozen pizza"]
    ];
    $list4 = [
      "frozen pizza" => [ "Fred", "Wilma"]
    ];
    if (combineShoppingLists($list1, $list2, $list3) === $list4) {
      echo "Combined Correctly";
    } else {
      echo "Combined Incorrectly";
    }
    echo "<br><br>";
    echo "Tests for Problem 4: <br>";
    echo "1: true: " . validateEmail("orange@virginia.edu") . "<br>"; // returns true
    echo "2: true: " . validateEmail("no-reply@google.com") . "<br>"; // returns true
    echo "3: true: " . validateEmail("orange.and.+blue@virginia.edu") . "<br>"; // returns true
    echo "4: false: " . validateEmail("google.com") . "<br>"; // returns false 
    echo "5: true: " . validateEmail("mst3k@virginia.edu", "/^[a-z][a-z][a-z]?[0-9][a-z][a-z]?[a-z]?@virginia.edu$/") . "<br>"; // returns true
    echo "6: false: " . validateEmail("orange@virginia.edu", "/^[a-z][a-z][a-z]?[0-9][a-z][a-z]?[a-z]?@virginia.edu$/") . "<br>"; // returns false
    echo "7: true: " . validateEmail("orange@blue.com", "/^[a-z\.@]+$/") . "<br>"; // returns true
    echo "8: false: " . validateEmail("orangeblue.com", "/^[a-z\.@]+$/") . "<br>"; // returns false (but matches this regex)
    echo "9: false: " . validateEmail("orange123@blue.com", "/^[a-z\.@]+$/") . "<br>"; // returns false
    echo "10: false: " . validateEmail("") . "<br>"; // returns false

?>

<p>...</p>
</body>
</html>
