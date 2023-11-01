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

        <link rel="stylesheet" href="/opt/www/matchgroups2/styles/main.css">

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
              <form action="../home/">
                <div class="form-group">
                  <label for="emailInput">Email address</label>
                  <input type="email" class="form-control" id="emailInput" placeholder="Enter email">
                </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                  </div>
                  <br>
                  <button type="submit" class="btn btn-primary">Submit</button>
              </form>
          </div>
          <div class="row">
            <br>
            <br>
          </div>
          <div class="row text-center">
            <h6>Don't have an account?<a href="../createAccount/"> Make one</a></h6>
          </div>
        </div>
      </div>

      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    </body>
</html>