<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
  <meta charset="UTF-8">  
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="CS4640 Fall 2023">
  <meta name="description" content="An example PHP Form page">  
  <title>PHP Form Example - Trivia</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"  integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"  crossorigin="anonymous">       
</head>

<body>
    
    <div class="container" style="margin-top: 15px;">
        <div class="row">
            <div class="col-xs-12">
                <h1>Game Over!</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12">
                <h4><?=$message?></h4>
                <br>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12">
                <ol class="list-group list-group-numbered">
                    <?php
                        echo "<li class=\"list-group-item\">" . $cat1 . ": " . $words1[0] . 
                        ", " . $words1[1] . ", " . $words1[2] . ", " . $words1[3] . "</li>";

                        echo "<li class=\"list-group-item\">" . $cat2 . ": " . $words2[0] . 
                        ", " . $words2[1] . ", " . $words2[2] . ", " . $words2[3] . "</li>";

                        echo "<li class=\"list-group-item\">" . $cat3 . ": " . $words3[0] . 
                        ", " . $words3[1] . ", " . $words3[2] . ", " . $words3[3] . "</li>";

                        echo "<li class=\"list-group-item\">" . $cat4 . ": " . $words4[0] . 
                        ", " . $words4[1] . ", " . $words4[2] . ", " . $words4[3] . "</li>";
                    ?>
                </ol>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12">
                <br>

                <h4>Previous Guesses:</h4>
                <ol class="list-group list-group-numbered">

                    <?php 
                        foreach ($previous_guesses as $guess) {
                            echo "<li class=\"list-group-item\"> $guess </li>";
                        }
                    ?>
                </ol>
            </div>
        </div>


        <div class="row">
            <div class="col-xs-12">
                <br>
                <form action="?command=instantiateGame" method="post">
                    <button type="submit" class="btn btn-primary">Play Again!</button>
                </form>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12">
                <br>
                <form action="?command=logout" method="post">
                    <button type="submit" class="btn btn-danger">Exit</button>
                </form>
            </div>
        </div>


    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
