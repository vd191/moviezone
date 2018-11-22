<?php

require_once('admin_main.php');


?> 

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Admin Page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" type="text/css" media="screen" href="css/admin.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="css/user.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="css/admin_main.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="css/movie_card.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="css/new-movie-form.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="css/new-user-form.css" />
    <script src="js/admin.js"></script>
    <script src="js/ajax.js"></script>
    <script src="js/validator.js"></script>

</head>
<body>
    <div class="container">

        <div class="left-menu">
            <div class="logo">
                <a href="#" id="page-title">Moviezone</a>       
            </div>

            <div class="menu">
                <p id="menu-title">Movie</p>
                <button class="btn-menu" onclick="adminNewMovieClick();"> <span id="menu-text">New Movie</span> </button>

                <button class="btn-menu" onclick="adminShowNewReleaseClick();"> <span id="menu-text">New Release</span></button>
                <button class="btn-menu" onclick="adminShowAllClick();"> <span id="menu-text">Show All</span></button>

                <p id="menu-title">User</p>
                <button class="btn-menu" onclick="adminNewUserClick();"> <span id="menu-text">New User</span></button>
                <button class="btn-menu" onclick="adminShowAllUserClick();"> <span id="menu-text">All User</span></button>

             
            </div>
        </div>

        <div class="right-content">
            <div class="title-content">
                <div id="id-title-content">
                    
                </div>

                <div id='id-delete-edit'>
                <?php if(isset($_SESSION['adminusername'])): ?>
                    <button class='btn-delete-edit' onclick='admin_btnLogout();' > <span id='edit-text'> Log Out </span> </button>
                <?php else: ?>   
                    <!-- <button class='btn-delete-edit' onclick='' > <span id='edit-text'> Log In </span> </button>                -->
                <?php endif;?>
                    <!-- 
                      -->
                </div>
            </div>

            <div id="id-content">
                
            </div>
        </div>

        <div id="footer">
             footer
        </div>
    </div>

    <footer> <br><br>
        <a style='text-decoration:none;color:white' href="../index.php"> LINK TO HOME PAGE </a><br><br><br><br>
 </footer>
   


    
</body>
</html>