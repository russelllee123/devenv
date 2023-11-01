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
            <h1>Categories Game</h1>
            <h2>Hello <?=$name?>! (<?=$email?>) </h2>
        </div>
    </div>

    <div class="container">
        <br>
        <?php 
        $number = 1;
        $i = 0;
        foreach ($grid as $word) {
            if ($i === 0) {
                echo "<div class=\"row\">";
            }
            echo "<div class=\"col-sm\"> $number: $word </div>";
            if ($i === 3) {
                echo "</div>";
                $i = 0;
            } else {
                $i += 1;
            }
            $number += 1;
        }
        
        ?>
        <br>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <form action="?command=checkguess" method="post">
                <div class="mb-3">
                    <label for="guess" class="form-label">Trivia Answer (enter four space-seperated numeric ids of the words you are guessing): </label>
                    <input type="text" class="form-control" id="trivia-answer" name="guess">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <br>
            <?=$message?>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <br>
            <h4>Previous Guesses: <?=$num_guesses?></h4>
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
            <form action="?command=endGame" method="post">
                <button type="submit" class="btn btn-danger">End Game</button>
            </form>
        </div>
    </div>

</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
