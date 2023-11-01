<?php

class TriviaController {

    private $questions = [];

    private $input = [];

    private $db;

    private $errorMessage = "";

    /**
     * Constructor
     */
    public function __construct($input) {
        session_start();
        $this->db = new Database();
        
        $this->input = $input;
    }

    /**
     * Get a question
     * 
     * By default, it returns a random question's id and text.  If given
     * a question id, it returns that question's text and answer.
     */
    public function getQuestion($id=null) {
    
        if ($id === null) {
            $res = $this->db->query("select * from questions order by random() limit 1;");
            
            return [ "id" => $res[0]["id"], "question" => $res[0]["question"]];
        }
        if (is_numeric($id)) {
            $res = $this->db->query("select * from questions where id = $1;", $id);
            if (empty($res)) {
                return false;
            }
            return $res[0];
        }
        return false;
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
            case "question":
                $this->showQuestion();
                break;
            case "answer":
                $this->answerQuestion();
                break;
            case "logout":
                $this->logout();
            default:
                $this->showWelcome();
                break;
        }
    }

    /**
     * Show a question to the user.  This function loads a
     * template PHP file and displays it to the user based on
     * properties of this object.
     */
    public function showQuestion($message = "") {
        $name = $_SESSION["name"];
        $email = $_SESSION["email"];
        $score = $_SESSION["score"];
        $question = $this->getQuestion();
        include("templates/question.php");
    }

    /**
     * Show the welcome page to the user.
     */
    public function showWelcome() {
        $message = "";
        if (!empty($this->errorMessage))
            $message .= "<p class='alert alert-danger'>".$this->errorMessage."</p>";
        include("templates/welcome.php");
    }

    /**
     * Check the user's answer to a question.
     */
    public function answerQuestion() {
        $message = "";
        if (isset($_POST["questionid"]) && is_numeric($_POST["questionid"])) {
            
            $question = $this->getQuestion($_POST["questionid"]);

            if (strtolower(trim($_POST["answer"])) === strtolower($question["answer"])) {
                $message = "<div class=\"alert alert-success\" role=\"alert\">
                Correct!
                </div>";
                $_SESSION["score"] += 5;
                $this->db->query("update users set score = $1 where email = $2;", $_SESSION["score"], $_SESSION["email"]);
            }
            else {
                $message = "<div class=\"alert alert-danger\" role=\"alert\">
                Incorrect! The correct answer was: {$question["answer"]}
                </div>";
            }
        }

        $this->showQuestion($message);
    }

    /**
     * Handle user registration and log-in
     */
    public function login() {
        // need a name, email, and password
        if(isset($_POST["fullname"]) && !empty($_POST["fullname"]) &&
            isset($_POST["email"]) && !empty($_POST["email"]) &&
            isset($_POST["passwd"]) && !empty($_POST["passwd"])) {

                // Check if user is in database
                $res = $this->db->query("select * from users where email = $1;", $_POST["email"]);
                if (empty($res)) {
                    // User was not there, so insert them
                    $this->db->query("insert into users (name, email, password, score) values ($1, $2, $3, $4);",
                        $_POST["fullname"], $_POST["email"],
                        password_hash($_POST["passwd"], PASSWORD_DEFAULT), 0);
                    $_SESSION["name"] = $_POST["fullname"];
                    $_SESSION["email"] = $_POST["email"];
                    $_SESSION["score"] = 0;
                    // Send user to the appropriate page (question)
                    header("Location: ?command=question");
                    return;
                } else {
                    // User was in the database, verify password
                    if (password_verify($_POST["passwd"], $res[0]["password"])) {
                        // Password was correct
                        $_SESSION["name"] = $res[0]["name"];
                        $_SESSION["email"] = $res[0]["email"];
                        $_SESSION["score"] = $res[0]["score"];
                        header("Location: ?command=question");
                        return;
                    } else {
                        $this->errorMessage = "Incorrect password.";
                    }
                }
        } else {
            $this->errorMessage = "Name, email, and password are required.";
        }
        // If something went wrong, show the welcome page again
        $this->showWelcome();
    }

    /**
     * Log out the user
     */
     public function logout() {
        // Udate the user's score before they log out, just in case
        $this->db->query("update users set score = $1 where email = $2;", $_SESSION["score"], $_SESSION["email"]);
        session_destroy();
        session_start();
    }


    /**
     * Load questions from a URL, store them as an array
     * in the current object.
     */
    public function loadQuestions() {
        $this->questions = json_decode(
            file_get_contents("http://www.cs.virginia.edu/~jh2jf/data/trivia.json"), true);

        if (empty($this->questions)) {
            die("Something went wrong loading questions");
        }
    }

}
