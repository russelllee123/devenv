<?php

/**
 * Sources used: https://cs4640.cs.virginia.edu, geeksforgeeks.com, stackoverflow.com, w3schools.com, getbootstrap.com
 * URL: https://cs4640.cs.virginia.edu/rsl7ej/matchgroups2
 * Authors: Russell Lee, rsl7ej & Luke Ostyn, lro3uck
 */

class matchgroupsController {


    /**
     * Constructor
     */
    public function __construct($input) {

        session_start();

        if (is_file("/.dockerenv")) {
            $_SESSION["CSSPATH"] = "/matchgroups2/styles/main.css";
        } else {
            $_SESSION["CSSPATH"] = "/rsl7ej/matchgroups2/styles/main.css";
        }

        $this->db = new Database();
        
        $this->input = $input;
    }
    
    /**
     * Run the server
     * 
     * Given the input (usually $_GET), then it will determine
     * which command to execute based on the given "command"
     * parameter.  Default is the welcome page.
     */
    public function run() {
        // Get the command
        $command = "welcome";
        if (isset($this->input["command"])){
            $command = $this->input["command"];
        }   

        $possibilities = array("displayLogin", "displayCreateAccount", "login", "createAccount");
        if (!in_array($command, $possibilities) and !isset($_SESSION["email"])){
            $command = "welcome";
        }
        if(($command == "login" or $command == "createAccount")  and !isset($_POST["email"])){
            $command = "welcome";
        }

        switch($command) {
            case "login":
                $this->login();
                break;
            case "createAccount":
                $this->createAccount();
                break;
            case "displayLogin":
                $this->logout();
                $this->displayLogin();
                break;
            case "displayCreateAccount":
                $this->logout();
                $this->displayCreateAccount();
                break;
            case "stack":
                $this->displayStack();
                break;
            case "updateDescription":
                $this->updateContent("description");
                break;
            case "updateMembers":
                $this->updateContent("members");
                break;
            case "updatePhoto":
                $this->updatePhoto("image1");
                break;
            case "updatePhoto2":
                $this->updatePhoto("image2");
                break;
            case "updateProfile":
                $this->updateProfile();
            case "profile":
                $this->displayProfile();
                break;
            case "matches":
                $this->displayMatches();
                break;
            case "match":
                $this->displayMatch();
                break;
            case "getMyInformation":
                $this->getMyInformation();
                break;
            case "like":
                $this->likeUser();
                $this->displayStack();
                break;
            case "dislike":
                $this->dislikeUser();
                $this->displayStack();
                break;
            case "sendMessage":
                $this->sendMessage();
                break;
            case "logout":
                $this->logout();
            default:
                $this->logout();
                $this->displayWelcome();
                break;
        }
    }

    /** 
     * Determine image path
     */
    public function returnImagePath() {
        if (is_file("/.dockerenv")) {
            return "";
        } else {
            return "/rsl7ej/matchgroups2/";
        }
    }

    /**
     * Determine CSS path
     */
    public function returnPath() {
        if (is_file("/.dockerenv")) {
            return "/matchgroups2/styles/main.css";
        } else {
            return "/rsl7ej/matchgroups2/styles/main.css";
        }
    }

    /**
     * Show the welcome page to the user
     */
    public function displayWelcome() {
        $cssPath = $this->returnPath();
        include("templates/welcome.php");
    }

    /**
     * Show the login page to the user
     */
    public function displayLogin($message = "") {
        $cssPath = $this->returnPath();
        include("templates/login.php");
    }

    /**
     * Show the account creation page to the user
     */
    public function displayCreateAccount($message = "") {
        $cssPath = $this->returnPath();
        include("templates/createAccount.php");
    }

    /**
     * Log user into system, establish user session
     */
    public function login() {
        // Need a name, email, and password
        if(isset($_POST["email"]) && !empty($_POST["email"]) &&
        isset($_POST["passwd"]) && !empty($_POST["passwd"])) {
            // Check if user is in database
            $res = $this->db->query("select * from users where email = $1;", $_POST["email"]);
            if (empty($res)) {
                $this->displayLogin("Email was invalid");
                return;
            }
            // If user was in database, check if password was incorrect
            if (password_verify($_POST["passwd"], $res[0]["password"]) == false) {
                $this->displayLogin("Password was invalid");
                return;
            }
            $_SESSION["id"] = $res[0]["id"];  
            $_SESSION["name"] = $res[0]["name"];
            $_SESSION["email"] = $res[0]["email"];
            $_SESSION["potentialMatch"] = false;
            $_SESSION["lastMessage"] = "";
            $_SESSION["lastPerson"] = -1;
            $this->displayStack();
            return;
        } else {
            $this->displayLogin("Missing inputs");
            return;
        }
        // If something went wrong, show the welcome page again
        $this->displayWelcome();
    }

    /**
     * Validate inputted email with regex
     */
    function validateEmail($email) {
        $baseline = "/^[a-zA-Z0-9+_\-]+(|[a-zA-Z0-9+_.\-]*[a-zA-Z0-9+_\-]+)@[a-zA-Z0-9]+[a-zA-Z0-9.\-]*\.[a-zA-Z0-9.\-]*[a-zA-Z0-9]+$/";
        if (preg_match($baseline, $email) == 0)
            return false;
        return true; 
    }
    
    /**
     * Create a user account
     */
    public function createAccount() {
        // need a name, email, and password
        if(isset($_POST["name"]) && !empty($_POST["name"]) &&
        isset($_POST["email"]) && !empty($_POST["email"]) &&
        isset($_POST["passwd"]) && !empty($_POST["passwd"]) &&
        isset($_POST["passwd2"]) && !empty($_POST["passwd2"])) {
            // Check if user is already in database
            if(!$this->validateEmail($_POST["email"])){
                $this->displayCreateAccount("Invalid Email Format");
                return;
            }
            $res = $this->db->query("select * from users where email = $1;", $_POST["email"]);
            if (empty($res) == false) {
                $this->displayCreateAccount("User already exists");
                return;
            }
            // Check if passwords don't match
            if($_POST["passwd"] != $_POST["passwd2"]) {
                $this->displayCreateAccount("Passwords don't match");
                return;
            }
            $this->db->query("insert into users (name, email, password, description, 
            members, image1, image2) values ($1, $2, $3, $4, $5, $6, $7);",
            $_POST["name"], $_POST["email"], 
            password_hash($_POST["passwd"], PASSWORD_DEFAULT), "", "", "", "");

            $res = $this->db->query("select * from users where email = $1;", $_POST["email"]);
            
            $_SESSION["id"] = $res[0]["id"];
            $_SESSION["name"] = $_POST["name"];
            $_SESSION["email"] = $_POST["email"];
            $_SESSION["potentialMatch"] = false;
            $_SESSION["lastMessage"] = "";
            $_SESSION["lastPerson"] = -1;
            $this->displayProfile();
            return;
        } else {
            $this->displayCreateAccount("Missing inputs");
            return;
        }
        // If something went wrong, show the welcome page again
        $this->displayWelcome();
    }

    /**
     * Display user profile page
     */
    public function displayProfile($message = ""){
        
        $cssPath = $this->returnPath();
        $res = $this->db->query("select * from users where email = $1;", $_SESSION["email"]);

        $name = $res[0]["name"];
        $description = $res[0]["description"];
        $members = $res[0]["members"];
        $image1 = $res[0]["image1"];
        $image2 = $res[0]["image2"];
        include("templates/profile.php");
    }

    /**
     * Change user description or members
     */
    public function updateContent($attribute = "") {
        if(!isset($_POST[$attribute]) || empty($_POST[$attribute])) {
            $this->displayProfile("$attribute submission blank");
            return;
        }
        if(strlen($_POST[$attribute]) > 300) {
            $this->displayProfile("$attribute submission too long");
            return;
        } 
        $this->db->query("update users set $attribute = $1 where email = $2;", $_POST[$attribute], $_SESSION["email"]);
        $this->displayProfile();
    }

    /**
     * Update user's photos
     */
    public function updatePhoto($image = ""){
        $imagePath = $this->returnImagePath();
        if(!isset($_POST["submit"])){ 
            $this->displayProfile("Photo submission failed");
            return;
        }
        if(!empty($_FILES[$image]["name"])){ 
            $fileName = basename($_FILES[$image]["name"]); 
            $targetFilePath = $imagePath . "images/" . $fileName; 
            $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION); 
    
            $types = array('jpg','png','jpeg'); 
            if(in_array($fileType, $types)){ 
                if(move_uploaded_file($_FILES[$image]["tmp_name"], $targetFilePath)){ 
                    $this->db->query("update users set $image = $1 where email = $2;", $fileName, $_SESSION["email"]); 
                }
            }
        }
        $this->displayProfile();
    }

    /**
     * Function to return user information
     */
    public function getMyInformation() {
        $info = $this->db->query("select * from users where email = $1;", $_SESSION["email"]);
        $json = json_encode([$info[0]["name"], $info[0]["email"], $info[0]["description"], 
        $info[0]["members"], $info[0]["image1"], $info[0]["image2"]], JSON_PRETTY_PRINT);
        include "templates/returnJSON.php";
    }

    /**
     * Display user stack with any unseen groups
     */
    public function displayStack(){   
        if (is_file("/.dockerenv")) {
            $rsl7ej = "";
        } else {
            $rsl7ej = "/rsl7ej";
        }
        $cssPath = $this->returnPath();
        $res = $this->db->query("select * from users where id != $1 order by random();", $_SESSION["id"]);
        $likes_tmp = $this->db->query("select * from likes where requestor = $1;", $_SESSION["id"]);
        $dislikes_tmp = $this->db->query("select * from dislikes where requestor = $1;", $_SESSION["id"]);
        $remove = [];
        foreach ($likes_tmp as $value) {
            $remove[$value["reciever"]] = "";
        }
        foreach ($dislikes_tmp as $value) {
            $remove[$value["reciever"]] = "";
        }
        foreach ($res as $key => $value) {
            if (array_key_exists($value["id"], $remove)) {
                unset($res[$key]);
            }
        }
        if(sizeof($res) == 0){
            $name = "";
            include("templates/stack.php");
        }
        else {
            $potential_match = reset($res);
            $_SESSION["potentialMatch"] = $potential_match["id"]; 
            
            $name = $potential_match["name"];
            $description = $potential_match["description"];
            $members = $potential_match["members"];
            $image1 = $potential_match["image1"];
            $image2 = $potential_match["image2"];
            include("templates/stack.php");
        }
    }

    /**
     * Like another user
     */
    public function likeUser() {
        if ($_SESSION["potentialMatch"] !== false) {
            // Check if user has already liked or disliked this potential match
            $res = $this->db->query("select * from likes where requestor = $1 and reciever = $2;", $_SESSION["id"], $_SESSION["potentialMatch"]);
            if (empty($res) == false) {
                return;
            }
            $res = $this->db->query("select * from dislikes where requestor = $1 and reciever = $2;", $_SESSION["id"], $_SESSION["potentialMatch"]);
            if (empty($res) == false) {
                return;
            }
            // Add potential match to user's liked users
            $this->db->query("insert into likes (requestor, reciever) values ($1, $2);",
            $_SESSION["id"], $_SESSION["potentialMatch"]);
        }
    }

    /**
     * Dislike another user
     */
    public function dislikeUser() {
        if ($_SESSION["potentialMatch"] !== false) {
            // Check if user has already liked or disliked this potential match
            $res = $this->db->query("select * from likes where requestor = $1 and reciever = $2;", $_SESSION["id"], $_SESSION["potentialMatch"]);
            if (empty($res) == false) {
                return;
            }
            $res = $this->db->query("select * from dislikes where requestor = $1 and reciever = $2;", $_SESSION["id"], $_SESSION["potentialMatch"]);
            if (empty($res) == false) {
                return;
            }
            // Add potential match to user's disliked users
            $this->db->query("insert into dislikes (requestor, reciever) values ($1, $2);",
            $_SESSION["id"], $_SESSION["potentialMatch"]);
        }
    }

    /**
     * Display users who user has liked and who have, reciprocally, liked the current session user
     */
    public function displayMatches() {
        $cssPath = $this->returnPath();
        // Create and pass an associative array of reciprocal likes
        $likes = $this->db->query("select * from likes where requestor = $1;", $_SESSION["id"]);
        $reciprocal_likes_tmp = $this->db->query("select * from likes where reciever = $1;", $_SESSION["id"]);
        $reciprocal_likes = [];
        foreach ($reciprocal_likes_tmp as $value) {
            $reciprocal_likes[$value["requestor"]] = "";
        }
        foreach ($likes as $key => $value) {
            if (!array_key_exists($value["reciever"], $reciprocal_likes)) {
                unset($likes[$key]);
            }
        }
        $matches = [];
        foreach ($likes as $value) {
            $res = $this->db->query("select * from users where id = $1;", $value["reciever"]);
            array_push($matches, $res[0]);
        }

        include "templates/matches.php";
    }

    /**
     * Display a particular match's page
     */
    public function displayMatch($errorMessage = "") {
        $cssPath = $this->returnPath();
        if (!isset($_POST["matchID"])) {
            $this->displayMatches();
            return;
        }
        $liker = $this->db->query("select * from likes where requestor = $1 and reciever = $2;", $_SESSION["id"], $_POST["matchID"]);
        $liked = $this->db->query("select * from likes where requestor = $1 and reciever = $2;", $_POST["matchID"], $_SESSION["id"]);
        if (empty($liker) || empty($liked)) {
            $this->displayMatches();
            return;
        }

        $res = $this->db->query("select * from users where id = $1;", $_POST["matchID"]);
        if (empty($res)) {
            $this->displayMatches();
            return;
        }
        $match = $res[0];

        $id = $match["id"];
        $name = $match["name"];
        $description = $match["description"];
        $members = $match["members"];
        $image1 = $match["image1"];
        $image2 = $match["image1"];

        $idMine = $_SESSION["id"];

        $res = $this->db->query("select * from messages where 
        recipient = $1 and sender = $2;", $_POST["matchID"], $_SESSION["id"]);

        $res2 = $this->db->query("select * from messages where 
        recipient = $2 and sender = $1;", $_POST["matchID"], $_SESSION["id"]);

        $messages = array_merge($res, $res2);
        $timeSent = array();
        foreach ($messages as $key => $row){
            $timeSent[$key] = $row['time'];
        }
        array_multisort($timeSent, SORT_ASC, $messages);

        include "templates/match.php";
    }

    /**
     * Send messages to a partiular match
     */
    public function sendMessage() {
        if (!isset($_POST["matchID"]) || !isset($_POST["message"])) {
            $this->displayMatch("Something went wrong");
            return;
        }
        $liker = $this->db->query("select * from likes where requestor = $1 and reciever = $2;", $_SESSION["id"], $_POST["matchID"]);
        $liked = $this->db->query("select * from likes where requestor = $1 and reciever = $2;", $_POST["matchID"], $_SESSION["id"]);
        if (empty($liker) || empty($liked)) {
            $this->displayMatches();
            return;
        }
        if (empty($_POST["message"])) {
            $this->displayMatch("Message was blank");
            return;
        }
        if (strlen($_POST["message"]) > 80) {
            $this->displayMatch("Message was too long");
            return;
        }
        if (($_POST["message"] === $_SESSION["lastMessage"]) && ($_POST["matchID"] === $_SESSION["lastPerson"])) {
            $this->displayMatch("Cannot send the same message twice");
            return;
        }

        $this->db->query("insert into messages (sender, recipient, message, time) 
        values ($1, $2, $3, $4);", $_SESSION["id"], $_POST["matchID"], $_POST["message"], time());
        $_SESSION["lastMessage"] = $_POST["message"];
        $_SESSION["lastPerson"] = $_POST["matchID"];
        
        $this->displayMatch();
    }

    /**
     * Log out of account, end current session
     */
    public function logout() {
        session_destroy();
        session_start();
    }

}