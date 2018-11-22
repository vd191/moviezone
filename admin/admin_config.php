<?php
define('CMD_REQUEST',"request"); //The key to access via POST and GET
define('CMD_ADMIN_LOGIN',"cmd_admin_login"); 
define('CMD_ADMIN_LOGOUT',"cmd_admin_logout");
//error messages	
define ('ERR_SUCCESS', '_OK_'); //no error, command is successfully executed
define ('ERR_AUTHENTICATION', "Wrong username or password");

// $php_version = phpversion();
// if (floatval($php_version) >= 5.4) {	
//     if (session_status() == PHP_SESSION_NONE) {//need the session to start
//         session_start();
//     }
// } else {
//     if (session_id() == '') {
//         session_start();
//     }
// }

/*We use 'authorised' keyword to identify if the user hasn't logged in
  if the keyword has not been set check if this is the login session then continue
  if not simply terminate (a good security practice to check for eligibility 
  before execute any php code)
*/
// if(!isset($_SESSION['authorised'])) { 
//     echo 'You must login</br>';
//     echo "Go to login page <a href='admin_login.php'> Click Here </a>";
//     die(); 

// }


// define the connection 
define ('DB_CONNECTION_STRING', "mysql:host=localhost;dbname=vnguye24_movieDB");
define('DB_USER',"root");
define('DB_PASSWORD',"root");

//The maximum random movie will be shown
define ('MAX_RANDOM_MOVIE',6);
//The maximum new release movie will be shown
define ('MAX_NEW_RELEASE_MOVIE',12);

//The folder movies are stored 
define ('_MOVIES_PHOTO_FOLDER_', "../libs/");

//Request command via POST or GET

define('CMD_SHOW_ALL_REQUEST',"cmd_show_all_request"); 
define('CMD_NEW_RELEASE_REQUEST',"cmd_new_release_request"); 
define('CMD_NEW_MOVIE_REQUEST',"cmd_new_movie_request"); 
define('CMD_NEW_USER_REQUEST',"cmd_new_user_request"); 
define('CMD_ALL_USER_REQUEST','cmd_all_user_request'); 
define('CMD_ADD_NEW_MOVIE_REQUEST','cmd_add_new_movie_request'); 
define('CMD_SHOW_SELECT_BOX','cmd_show_select_box');
define('CMD_SHOW_ACTOR_SELECT_BOX','cmd_show_actor_select_box');


define('CMD_MEMBER_REGISTER','cmd_member_register');

define('CMD_DELETE_MOVIE','cmd_delete_movie');
define('CMD_EDIT_MOVIE','cmd_edit_movie');
define('CMD_EDIT_USER','cmd_edit_user');
define('CMD_DELETE_USER','cmd_delete_user');
define('CMD_EDIT_FORM','cmd_edit_form');
define('CMD_MEMBER_EDIT','cmd_member_edit');
define('CMD_EDIT_MOVIE_FORM','cmd_edit_movie_form');
define('CMD_EDIT_MOVIE_STOCK_REQUEST','cmd_edit_movie_stock_request');




require_once('admin_controller.php');
require_once('admin_model.php');
require_once('admin_view.php');
require_once('admin_dba.php');

?>

