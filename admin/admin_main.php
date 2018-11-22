<?php

require_once('admin_config.php');

/* create the model, view and controller objects*/
$view = new View();
$model = new Model();
$controller = new Controller($view,$model); //

/* interacts with UI via GET/POST methods and process all requests */
if (!empty($_REQUEST[CMD_REQUEST])){ // check if there is a request to process
    $request = $_REQUEST[CMD_REQUEST];
    $controller->processRequest($request);
}

?>