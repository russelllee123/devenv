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
        if (isset($this->input["command"]))
            $command = $this->input["command"];

        switch($command) {
            case "login":
                $this->login();
                break;
            case "createAccount":
                $this->createAccount();
                break;
            case "displayLogin":
                $this->displayLogin();
                break;
            case "displayCreateAccount":
                $this->displayCreateAccount();
                break;
            case "stack":
                $this->displayStack();
                break;
            case "profile":
                $this->displayProfile();
                break;
            case "matches":
                $this->displayMatches();
                break;
            case "match":
                $this->displayMatch();
                break;
            case "logout":
                $this->logout();
            default:
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
            $_SESSION["name"] = $res[0]["name"];
            $_SESSION["email"] = $res[0]["email"];
            $this->displayStack();
            return;
        } else {
            $this->displayLogin("Missing inputs");
            return;
        }
        // If something went wrong, show the welcome page again
        $this->displayWelcome();
    }

    public function createAccount() {
        // need a name, email, and password
        if(isset($_POST["name"]) && !empty($_POST["name"]) &&
        isset($_POST["email"]) && !empty($_POST["email"]) &&
        isset($_POST["passwd"]) && !empty($_POST["passwd"]) &&
        isset($_POST["passwd2"]) && !empty($_POST["passwd2"])) {
            // Check if user is already in database
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
            $this->db->query("insert into users (name, email, password) values ($1, $2, $3);",
                $_POST["name"], $_POST["email"], 
                password_hash($_POST["passwd"], PASSWORD_DEFAULT));
            $_SESSION["name"] = $_POST["name"];
            $_SESSION["email"] = $_POST["email"];
            $this->displayProfile();
            return;
        } else {
            $this->displayCreateAccount("Missing inputs");
            return;
        }
        // If something went wrong, show the welcome page again
        $this->displayWelcome();
    }

}