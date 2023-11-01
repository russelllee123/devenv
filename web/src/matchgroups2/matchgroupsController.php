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
            case "stack":
                $this->showStack();
                break;
            case "createAccount":
                $this->createAccount();
            case "profile":
                $this->showProfile();
                break;
            case "displayLogin":
                $this->displayLogin();
                break;
            case "displayCreateAccount":
                $this->displayCreateAccount();
                break;
            case "matches":
                $this->showMatches();
                break;
            case "match":
                $this->displayMatch();
                break;
            case "logout":
                $this->logout();
            default:
                $this->showWelcome();
                break;
        }
    }

    /**
     * Show the welcome page to the user.
     */
    public function showWelcome() {
        include("templates/welcome.php");
    }

    public function displayLogin() {
        include("templates/login.php");
    }

}