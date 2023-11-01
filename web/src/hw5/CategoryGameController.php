<?php

class CategoryGameController {

    private $categories = [];

    private $input = [];

    /**
     * Constructor
     */
    public function __construct($input) {
        session_start();
        $this->input = $input;
        $this->loadCategories();
    }

    /**
     * Load questions from a URL, store them as an array
     * in the current object.
     */
    public function loadCategories() {
        $this->categories = json_decode(
            file_get_contents("https://www.cs.virginia.edu/~jh2jf/data/categories.json"), true);

        if (empty($this->categories)) {
            die("Something went wrong loading categories");
        }
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
            case "instantiateGame":
                $this->instantiateGame();
            case "displayGame":
                $this->displayGame();
                break;
            case "checkguess":
                $this->checkGuess();
                break;
            case "endGame":
                $this->endGame();
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

    /**
     * Handle user registration and log-in
     */
    public function login() {

        if(isset($_POST["fullname"])) {
            $_SESSION["name"] = $_POST["fullname"];
        }

        if(isset($_POST["email"])) {
            $_SESSION["email"] = $_POST["email"];
        }

    }

    /**
     * Instantiate a new category guessing game
     */
    public function instantiateGame($message = "") {
        // Initialize generic session data
        $_SESSION["num_guesses"] = 0;
        $_SESSION["previous_guesses"] = array();

        // Select four new categories at random
        if (isset($_SESSION["id1"]) && isset($_SESSION["id2"]) && isset($_SESSION["id3"]) && isset($_SESSION["id4"])) {
            $tmp_categories = $this->categories;
            unset($tmp_categories[$_SESSION["id1"]]);
            unset($tmp_categories[$_SESSION["id2"]]);
            unset($tmp_categories[$_SESSION["id3"]]);
            unset($tmp_categories[$_SESSION["id4"]]);
            $id_array = array_rand($tmp_categories, 4);
        } else {
            $id_array = array_rand($this->categories, 4);
        }

        // Set lots of session data on selected categories
        $id1 = $id_array[0];
        $id2 = $id_array[1];
        $id3 = $id_array[2];
        $id4 = $id_array[3];
        $_SESSION["id1"] = $id1;
        $_SESSION["id2"] = $id2;
        $_SESSION["id3"] = $id3;
        $_SESSION["id4"] = $id4;
        $_SESSION["cat1"] = $this->categories[$id1]["category"];
        $_SESSION["cat2"] = $this->categories[$id2]["category"];
        $_SESSION["cat3"] = $this->categories[$id3]["category"];
        $_SESSION["cat4"] = $this->categories[$id4]["category"];
        $_SESSION["cat1complete"] = false;
        $_SESSION["cat2complete"] = false;
        $_SESSION["cat3complete"] = false;
        $_SESSION["cat4complete"] = false;
        $_SESSION["words1"] = $this->categories[$id1]["words"];
        $_SESSION["words2"] = $this->categories[$id2]["words"];
        $_SESSION["words3"] = $this->categories[$id3]["words"];
        $_SESSION["words4"] = $this->categories[$id4]["words"];

        // Create randomized grid
        $grid = array_merge($this->categories[$id1]["words"], $this->categories[$id2]["words"], 
            $this->categories[$id3]["words"], $this->categories[$id4]["words"]);
        shuffle($grid);
        $_SESSION["grid"] = $grid;
    }


    /**
     * Display game at a point in time
     */
    public function displayGame($message = "") {
        // Take to welcome menu if session data isn't set
        if (!isset($_SESSION["name"]) || !isset($_SESSION["email"]) || 
        !isset($_SESSION["num_guesses"]) || !isset($_SESSION["grid"]) || 
        !isset($_SESSION["previous_guesses"])) {
            $this->showWelcome();
            return;
        }

        // Get needed session data
        $name = $_SESSION["name"];
        $email = $_SESSION["email"];
        $num_guesses = $_SESSION["num_guesses"];
        $grid = $_SESSION["grid"];
        $previous_guesses = $_SESSION["previous_guesses"];

        // Go to game end if all categories have been guessed
        if ($_SESSION["cat1complete"] === true && $_SESSION["cat2complete"] === true && 
        $_SESSION["cat3complete"] === true && $_SESSION["cat4complete"] === true) {
            $this->endGame();
            return;
        }

        // End game if grid array is an improper size
        if (count($grid) != 4 && count($grid) != 8 && count($grid) != 12 && count($grid) != 16) {
            die("Something went wrong loading categories");
        }

        include("templates/game.php");

    }

    /**
     * Check the user's category guess
     */
    public function checkGuess() {

        if ($_SESSION["cat1complete"] === true && $_SESSION["cat2complete"] === true && 
        $_SESSION["cat3complete"] === true && $_SESSION["cat4complete"] === true) {
            $this->endGame();
            return;
        }

        $message = "";
        
        // Check if guess was made
        if (!isset($_POST["guess"])) {
            $message = "<div class=\"alert alert-danger\" role=\"alert\">
            No guess inputted
            </div>";
            $this->displayGame($message);
            return;
        }

        // Trim input, turn into array
        $guess = trim($_POST["guess"]);
        $guessArray = explode(" ", $guess);

        // Check length of input array
        if (count($guessArray) != 4) {
            $message = "<div class=\"alert alert-danger\" role=\"alert\">
            Incorrect number of guesses
            </div>";
            $this->displayGame($message);
            return;
        }

        // Check that all input array values are valid numbers, add associated words in grid to an array
        $guessWordArray = array();
        foreach ($guessArray as $value) {
            if (is_numeric($value) == false) {
                $message = "<div class=\"alert alert-danger\" role=\"alert\">
                Invalid input
                </div>";
                $this->displayGame($message);
                return;
            }
            if (($value - 1 < 0) || ($value - 1 >= count($_SESSION["grid"]))) {
                $message = "<div class=\"alert alert-danger\" role=\"alert\">
                Something went wrong reading user input
                </div>";
                $this->displayGame($message);
                return;
            }
            array_push($guessWordArray, $_SESSION["grid"][$value - 1]);
        }

        $_SESSION["num_guesses"] += 1;
        $statement = "Your words were: ";

        // Check number of words in each remaining category
        $cat1vals = 0;
        $cat2vals = 0;
        $cat3vals = 0;
        $cat4vals = 0;
        foreach ($guessWordArray as $value) {
            $statement .= $value . ", ";
            if (in_array($value, $_SESSION["words1"]) && $_SESSION["cat1complete"] === false) {
                $cat1vals += 1;
                continue;
            } elseif (in_array($value, $_SESSION["words2"]) && $_SESSION["cat2complete"] === false) {
                $cat2vals += 1;
                continue;
            } elseif (in_array($value, $_SESSION["words3"]) && $_SESSION["cat3complete"] === false) {
                $cat3vals += 1;
                continue;
            } elseif (in_array($value, $_SESSION["words4"]) && $_SESSION["cat4complete"] === false) {
                $cat4vals += 1;
                continue;
            }
        }

        // Handle guess based on number of correct words
        if ($cat1vals === 4 || $cat2vals === 4 || $cat3vals === 4 || $cat4vals === 4) {
            if ($cat1vals == 4) {
                $category = $_SESSION["cat1"];
                $_SESSION["cat1complete"] = true;
            } elseif ($cat2vals == 4) {
                $category = $_SESSION["cat2"];
                $_SESSION["cat2complete"] = true;
            } elseif ($cat3vals == 4) {
                $category = $_SESSION["cat3"];
                $_SESSION["cat3complete"] = true;
            } else {
                $category = $_SESSION["cat4"];
                $_SESSION["cat4complete"] = true;
            }
            $message = "<div class=\"alert alert-success\" role=\"alert\">
            You guessed correctly! The category was $category
            </div>";
            $statement .= "You guessed $category correctly!";
            // Update grid to remove words
            $grid = $_SESSION["grid"];
            foreach ($guessWordArray as $word) {
                foreach ($grid as $key => $value) {
                    if ($word === $value) {
                        unset($grid[$key]);
                        break;
                    }
                }
            }
            sort($grid, SORT_NUMERIC);
            $_SESSION["grid"] = $grid;
        } elseif ($cat1vals === 3 || $cat2vals === 3 || $cat3vals === 3 || $cat4vals === 3) {
            $message = "<div class=\"alert alert-success\" role=\"alert\">
            1 of your words was not in the category!
            </div>";
            $statement .= "1 of your words was not in the category!";
        } elseif ($cat1vals === 2 || $cat2vals === 2 || $cat3vals === 2 || $cat4vals === 2) {
            $message = "<div class=\"alert alert-success\" role=\"alert\">
            2 of your words were not in the category!
            </div>";
            $statement .= "2 of your words were not in the category!";
        } else {
            $message = "<div class=\"alert alert-danger\" role=\"alert\">
            Incorrect guess!
            </div>";
            $statement .= "Incorrect guess!";
        }

        // Add guess to your array of previous guesses
        array_push($_SESSION["previous_guesses"], $statement);

        // If all categories have been guessed, end game
        if ($_SESSION["cat1complete"] === true && $_SESSION["cat2complete"] === true && 
        $_SESSION["cat3complete"] === true && $_SESSION["cat4complete"] === true) {
            $this->endGame();
            return;
        }

        $this->displayGame($message);
    }

    /**
     * Show the user the correct answer, congratulate them if they guessed the categories correctly
     */
    public function endGame() {

        // Check if number of guesses, previous guesses, and ids were set
        if (!isset($_SESSION["num_guesses"]) || !isset($_SESSION["previous_guesses"]) ||
            !isset($_SESSION["id1"]) || !isset($_SESSION["id2"]) ||
            !isset($_SESSION["id3"]) || !isset($_SESSION["id4"])) {
            $this->showWelcome();
            return;
        }

        // Check if user guessed categories correctly
        if ($_SESSION["cat1complete"] === true && $_SESSION["cat2complete"] === true && 
        $_SESSION["cat3complete"] === true && $_SESSION["cat4complete"] === true) {
            $message = "Congratulations! You guessed the correct categories in " . $_SESSION["num_guesses"] . " guesses!";
        } else {
            $message = "You failed to find the correct categories. View the correct categories below.";
        }

        // Grab session data
        $previous_guesses = $_SESSION["previous_guesses"];
        $cat1 = $_SESSION["cat1"];
        $cat2 = $_SESSION["cat2"];
        $cat3 = $_SESSION["cat3"];
        $cat4 = $_SESSION["cat4"];
        $words1 = $_SESSION["words1"];
        $words2 = $_SESSION["words2"];
        $words3 = $_SESSION["words3"];
        $words4 = $_SESSION["words4"];

        include("templates/gameOver.php");
    }

    /**
     * Log out the user
     */
     public function logout() {
        session_destroy();
        session_start();
    }

}
