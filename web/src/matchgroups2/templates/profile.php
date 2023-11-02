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

        <title>Profile</title>     
    </head>  

    <!-- Page to display and change profile information -->
    
    <body>
        <nav class="navbar navbar-expand-lg bg-body-secondary">
            <div class="container-fluid">
              <a class="navbar-brand" href="../home">MatchGroups</a>
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                  <li class="nav-item">
                    <a class="nav-link" href="../home">Stack </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="../matches">Matches </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">Profile </a>
                  </li>
                </ul>
                <ul class="navbar-nav pull-right">
                    <li class="nav-item">
                      <a class="nav-link" href="../login">Log Out</a>
                    </li>
                  </ul>
              </div>
            </div>
        </nav>

          <br>

          <div class="invisible-box text-box">
            <h1 class="display-6">Update your profile:</h1> <br>
          </div>
          
          <form action="../profile">
            <div class="invisible-box text-box">
              <div class="form-group input-box">
                <label for="name">Group Name:</label>
                <input type="email" class="form-control" id="name" placeholder="Swing Dance">
              </div>
            </div>
          
            <div class="invisible-box text-box">
                <div class="form-group input-box">
                  <label for="description">Group Description:</label>
                  <textarea class="form-control" id="description" rows = 4 placeholder="The University of Virginia's foremost swing dance club and team. We hold biweekly socials and compete once a semester."></textarea>
                </div>
            </div>

            <div class="invisible-box text-box">
              <div class="form-group input-box">
                <label for="members">Group Members:</label>
                <textarea class="form-control" id="members" rows = 3 placeholder="Katie Foster, Amy Beauchamp, Sarah Lewis, Rand Goshen, Paul Vaguely "></textarea>
              </div>
            </div>

            <br>

            <div class="box contain-image">
              <img src="../images/swingDanceMany.jpg" alt="Team of frisbee players">
            </div>

            <div class="invisible-box text-box">
              <div class="mb-3">
                <label for="image1" class="form-label">Profile Photo:</label>
                <input class="form-control" type="file" id="image1">
              </div>
            </div>

            <br>

            <div class="box contain-image">
              <img src="../images/swingDanceFew.jpg" alt="Team of frisbee players">
            </div>

            <div class="invisible-box text-box">
              <div class="mb-3">
                <label for="image2" class="form-label">Second photo:</label>
                <input class="form-control" type="file" id="image2">
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
                  <li class="nav-item"><a href="../home" class="nav-link px-2 text-muted">Stack</a></li>
                  <li class="nav-item"><a href="../matches" class="nav-link px-2 text-muted">Matches</a></li>
                  <li class="nav-item"><a href="../profile" class="nav-link px-2 text-muted">Profile</a></li>
                </ul>
              </footer>
            </div>
          </div>

      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    </body>
</html>