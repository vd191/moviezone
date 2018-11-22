<?php
//Start session
if (floatval(phpversion()) >= 5.4) {	
    if (session_status() == PHP_SESSION_NONE) {//need the session to start
        session_start();
    }
} else {
    if (session_id() == '') {
        session_start();
    }
}

/*Perform session checking, if already logged in then just put user through
otherwise, show login dialog */


//error messages	
define ('ERR_SUCCESS', '_OK_'); //no error, command is successfully executed
define ('ERR_AUTHENTICATION', "Wrong username or password");

// FOR MOVIE MVC
require_once('controller/movie_controller.php');
require_once('model/movie_model.php');
require_once('view/movie_view.php');
require_once('db/movie_db_adapter.php');

// define the connection 
define ('DB_CONNECTION_STRING', "mysql:host=localhost;dbname=vnguye24_movieDB");
define('DB_USER',"root");
define('DB_PASSWORD',"root");

//The maximum random movie will be shown
define ('MAX_RANDOM_MOVIE',9);
//The maximum new release movie will be shown
define ('MAX_NEW_RELEASE_MOVIE',12);

//The folder movies are stored 
define ('_MOVIES_PHOTO_FOLDER_', "libs/");

//Request command via POST or GET
define('CMD_REQUEST',"request"); //The key to access via POST and GET
define('CMD_MOVIE_SELECT_ALL',"cmd_movie_select_all"); 
define('CMD_MOVIE_SELECT_RANDOM',"cmd_movie_select_random");
define('CMD_MOVIE_NEW_RELEASE',"cmd_movie_new_release");
define('CMD_SHOW_FILTER_NAV',"cmd_show_filter_nav");  //The value to show Filter navigation 
define('CMD_MOVIE_FILTER',"cmd_movie_filter");  // The value to filter movie by submitted parameters
define('CMD_SHOW_CONTACT_PAGE','cmd_show_contact_page');




// FOR MEMBER MVC
require_once('controller/member_controller.php');
require_once('model/member_model.php');
require_once('view/member_view.php');
require_once('db/member_db_adapter.php');

define('CMD_MEMBER_REQUEST',"member_request"); 
define('CMD_MEMBER_REGISTER',"cmd_member_register"); 
define('CMD_SIGNUP_FORM',"cmd_signup_form");
define('CMD_LOGIN_FORM',"cmd_login_form");
define('CMD_LOGIN',"cmd_login");
define('CMD_LOGOUT',"cmd_logout");
define('CMD_BOOK_MOVIE',"cmd_book_movie");
define('CMD_CHECKOUT','cmd_checkout');




?>