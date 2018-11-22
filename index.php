<?php
/*-------------------------------------------------------------------------------------------------
@Module: index.php
This server-side module provides main UI for the application.

@Author: Viet Duong Nguyen
@Modified by: 
@Date: 16/07/2018
-------------------------------------------------------------------------------------------------*/

require_once('main.php');
?>

<!DOCTYPE html>
<html>
<head>
    <title>Moviezone</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">    <link rel="stylesheet" type="text/css" media="screen" href="css/movie_card.css" />
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" type="text/css" media="screen" href="css/movie_main.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="css/form.css" />
    <script src="js/movie.js"></script>
    <script src="js/member.js"></script>
    <script src="js/ajax.js"></script>
    <script src="js/validator.js"></script>
</head>
<body class="container">
       
    <!--Main Mavigation -->
    <div id="id-header">
        
        <?php $movieController->loadMainNav(); ?>  
                            
    </div>

    <!--Content -->  
    <div class="content-container">
        
        <div id="id-filter-nav">
             <!-- Filter navigation loaded here --> 
        
            <?php
            if (isset($_SESSION['username'])) {
                $username = $_SESSION['username'];
                
                // echo 'you already logged in as ' .$username ;    
            }
            
            ?>
        </div>

        <div id="content"> <!-- Movies loaded here --> </div>

    </div>    
    
    <!-- Footer --> 
    <footer> 
        <div class='footer-container'>
           <p> <br><br> <a href="http://http://infotech.scu.edu.au/~vnguye24"> Link to the InfoTech site</a> <br> <br>

           A big thanks to the Internet Movie Database (IMDb) as that's were I "borrowed" most images from.</p> 
           
           
        <a style='text-decoration:none;color:white' href="admin/admin_login.php"> LINK TO ADMIN PAGE </a><br><br><br><br>

        </div>
        
    
    
    
    
    </footer>
    
</body>
</html>