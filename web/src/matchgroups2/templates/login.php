<!DOCTYPE html>

<!--
Sources used: https://cs4640.cs.virginia.edu, geeksforgeeks.com, stackoverflow.com, w3schools.com, getbootstrap.com
URL: https://cs4640.cs.virginia.edu/rsl7ej/matchgroups
-->

<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1"> 

        <meta name="author" content="Russell Lee, rsl7ej, Luke Ostyn, lro3uck">
        <meta name="description" content="Mix with the group of your dreams!">
        <meta name="keywords" content="groups, match, friends, mix">   

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"  integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"  crossorigin="anonymous">

        <link rel="stylesheet" href="/matchgroups2/styles/main.css">

        <title>Login</title>     
    </head>  

    <!-- Page to log into your account -->
    
    <body>

      <div class="center">
        <div class="grid">
          <div class="row">
            <br>
            <br>
          </div>
          <div class="row text-center">
              <h2>Sign in to Match Groups</h2>
          </div>
          <div class="row">
            <br>
          </div>
          <div class="row general">
            <form action="?command=login" method="post">
              <div class="form-group">
                <label for="email" class="form-label">Email address</label>
                <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" placeholder="Enter email">
              </div>
              <div class="form-group">
                <label for="passwd" class="form-label">Password</label>
                <input type="password" class="form-control" id="passwd" name="passwd" placeholder="Enter password">
              </div>
              <br>
              <button type="submit" class="btn btn-primary">Submit</button>
            </form>
          </div>
          <div class="row">
            <br>  
            <?php 
              if ($message != "") {
                echo "<div class=\"alert alert-danger\" role=\"alert\">
                        $message
                      </div>";
              }
            ?>
            <br>
          </div>
          <div class="row text-center">
            <h6>Don't have an account?<h6>
            <form action="?command=displayCreateAccount" method="post"> 
              <button type="submit" class="btn btn-primary">Make One</button>
            </form>
          </div>
        </div>
      </div>

      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    </body>
</html>