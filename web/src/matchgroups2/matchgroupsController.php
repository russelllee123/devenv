<?php

class matchgroupsController {

    /**
     * Constructor
     */
    public function __construct($input) {
        session_start();
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
                $this->updateDescription();
                break;
            case "updateMembers":
                $this->updateMembers();
                break;
            case "updatePhoto":
                $this->updatePhoto();
                break;
            case "updatePhoto2":
                $this->updatePhoto2();
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
            case "like":
                $this->likeUser();
                $this->displayStack();
                break;
            case "dislike":
                $this->dislikeUser();
                $this->displayStack();
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
     * Show the welcome page to the user.
     */
    public function displayWelcome() {
        include("templates/welcome.php");
    }

    public function displayLogin($message = "") {
        include("templates/login.php");
    }

    public function displayCreateAccount($message = "") {
        include("templates/createAccount.php");
    }

    public function login() {
        // need a name, email, and password
        if(isset($_POST["email"]) && !empty($_POST["email"]) &&
        isset($_POST["passwd"]) && !empty($_POST["passwd"])) {
            // Check if user is in database
            $res = $this->db->query("select * from users where email = $1;", $_POST["email"]);
            if (empty($res)) {
                $this->displayLogin("Email was invalid");
                return;
            }
            // User was in database, check if password was incorrect
            if (password_verify($_POST["passwd"], $res[0]["password"]) == false) {
                $this->displayLogin("Password was invalid");
                return;
            }
            $_SESSION["id"] = $res[0]["id"];  
            $_SESSION["name"] = $res[0]["name"];
            $_SESSION["email"] = $res[0]["email"];
            $_SESSION["potentialMatch"] = false;
            $this->displayStack();
            return;
        } else {
            $this->displayLogin("Missing inputs");
            return;
        }
        // If something went wrong, show the welcome page again
        $this->displayWelcome();
    }

    function validateEmail($email) {
        $baseline = "/^[a-zA-Z0-9+_\-]+(|[a-zA-Z0-9+_.\-]*[a-zA-Z0-9+_\-]+)@[a-zA-Z0-9]+[a-zA-Z0-9.\-]*\.[a-zA-Z0-9.\-]*[a-zA-Z0-9]+$/";
        if (preg_match($baseline, $email) == 0)
            return false;
        return true; 
    }
    
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
            $this->displayProfile();
            return;
        } else {
            $this->displayCreateAccount("Missing inputs");
            return;
        }
        // If something went wrong, show the welcome page again
        $this->displayWelcome();
    }

    public function displayProfile(){
        $res = $this->db->query("select * from users where email = $1;", $_SESSION["email"]);

        $name = $res[0]["name"];
        $description = $res[0]["description"];
        $members = $res[0]["members"];
        $image1 = $res[0]["image1"];
        $image2 = $res[0]["image2"];
        include("templates/profile.php");
    }

    public function updateDescription() {
        if(isset($_POST["description"]) && !empty($_POST["description"])) {
            $this->db->query("update users set description = $1 where email = $2;", $_POST["description"], $_SESSION["email"]);
        }
        $this->displayProfile();
    }
    public function updateMembers(){
        if(isset($_POST["members"]) && !empty($_POST["members"])) {
            $this->db->query("update users set members = $1 where email = $2;", $_POST["members"], $_SESSION["email"]);
        }
        $this->displayProfile();;
    }

    public function updatePhoto(){
        
        $statusMsg = "";
        $targetDir = "images/"; 
        if(isset($_POST["submit"])){ 
            if(!empty($_FILES["image1"]["name"])){ 
                $fileName = basename($_FILES["image1"]["name"]); 
                $targetFilePath = $targetDir . $fileName; 
                $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION); 
     
                $types = array('jpg','png','jpeg'); 
                if(in_array($fileType, $types)){ 
            // Upload file to server 
                    if(move_uploaded_file($_FILES["image1"]["tmp_name"], $targetFilePath)){ 
                // Insert image file name into database 
                        $this->db->query("update users set image1 = $1 where email = $2;", $fileName, $_SESSION["email"]); 
                    }
                }
            }
        } 
        $this->displayProfile();
    }
    public function updatePhoto2(){
        
        $statusMsg = "";
        $targetDir = "images/"; 
        if(isset($_POST["submit"])){ 
            if(!empty($_FILES["image2"]["name"])){ 
                $fileName = basename($_FILES["image2"]["name"]); 
                $targetFilePath = $targetDir . $fileName; 
                $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION); 
     
                $types = array('jpg','png','jpeg'); 
                if(in_array($fileType, $types)){ 
            // Upload file to server 
                    if(move_uploaded_file($_FILES["image2"]["tmp_name"], $targetFilePath)){ 
                // Insert image file name into database 
                        $this->db->query("update users set image2 = $1 where email = $2;", $fileName, $_SESSION["email"]); 
                    }
                }
            }
        }
        $this->displayProfile();
    }

    public function displayStack(){

        /*
            Currently only displays one match other than the user themself, need to add
            the ability to like and dislike other users, remove those users from the stack
        */
        
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
            include("templates/emptyStack.php");
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

    public function displayMatches() {
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

    public function displayMatch() {
        if (isset($_POST["matchID"])) {
            $res = $this->db->query("select * from users where id = $1;", $_POST["matchID"]);
            if (empty($res)) {
                $this->displayMatches();
                return;
            }

            $match = $res[0];

            $name = $match["name"];
            $description = $match["description"];
            $members = $match["members"];
            $image1 = $match["image1"];
            $image2 = $match["image1"];

            include "templates/match.php";
        } else {
            $this->displayMatches();
        }
    }

    public function logout() {
        session_destroy();
        session_start();
    }

}