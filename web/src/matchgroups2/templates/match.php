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

        <title>Home</title>     
    </head> 
    
    <!-- Page to display a match you've made and message them -->
    
    <body>
        <nav class="navbar navbar-expand-lg bg-body-secondary">
            <div class="container-fluid">
              <a class="navbar-brand" href="?command=stack">MatchGroups</a>
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                  <li class="nav-item">
                    <a class="nav-link active" href="?command=stack">Stack </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="?command=matches">Matches </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="?command=profile">Profile </a>
                  </li>
                </ul>
                <ul class="navbar-nav pull-right">
                    <li class="nav-item">
                      <a class="nav-link" href="?command=logout">Log Out</a>
                    </li>
                  </ul>
              </div>
            </div>
        </nav>

        <br>

          <div class="invisible-box text-box">
            <h1 class="display-6"><?=$name?></h1> <br>
          </div>

          <?php if ($image1 != "") {?>
            <div class="box contain-image">
              <p><?=$image1?></p>
              <!-- <img src="../../images/football.jpeg"> -->
            </div>
          <?php }?>
          
          <?php if ($description != "") {?>
            <div class="box text-box">
              <p>Description: <?=$description?></p>
            </div>
          <?php }?>

          <?php if ($image2 != "") {?>
            <div class="box contain-image">
              <p><?=$image2?></p>
              <!-- <img src="../../images/football-player.jpeg"> -->
            </div>
          <?php }?>

          <?php if ($members != "") {?>
            <div class="box text-box">
              <p>Members: <?=$members?></p>
            </div>
          <?php }?>

          <br>

          <div class="invisible-box text-box">
            <h1 class="display-6">Messages:</h1> <br>
          </div>

          <div class="box row">
            <div class="column">
                <br>
            </div>
            <div class="column d-flex flex-row justify-content-start">
                    <p class="small p-2 ms-3 mb-1 rounded-3" style="background-color: #f5f6f7;">Hi, we have an event this weekend!</p>
            </div>
            <div class="column d-flex flex-row justify-content-end mb-4 pt-1">
                    <p class="small p-2 me-3 mb-1 text-white rounded-3 bg-primary">Cool, we'll be there!</p>
            </div>
            <div class="column d-flex flex-row justify-content-start">
                <p class="small p-2 ms-3 mb-1 rounded-3" style="background-color: #f5f6f7;">Sick!</p>
            </div>
            <div class="column">
                <br>
            </div>
          </div>

            <form action="#">
                <div class="invisible-box text-box">
                    <div class="form-group input-box">
                    <input type="email" class="form-control" id="name" placeholder="Write messages here...">
                    </div>
                </div>
                <div class="invisible-box text-box">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>

          <div class="d-flex flex-column">
            <div class="wrapper flex-grow-1"></div>
            <div class="container">
              <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">
                <p class="col-md-4 mb-0 text-muted">&copy; 2023 Russell & Luke, Inc</p>
                <ul class="nav col-md-4 justify-content-end">
                <li class="nav-item"><a href="?command=stack" class="nav-link px-2 text-muted">Stack</a></li>
                  <li class="nav-item"><a href="?command=matches" class="nav-link px-2 text-muted">Matches</a></li>
                  <li class="nav-item"><a href="?command=profile" class="nav-link px-2 text-muted">Profile</a></li>
                </ul>
              </footer>
            </div>
          </div>

      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    </body>
</html>