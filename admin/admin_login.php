<?php

// $php_version = phpversion();
// if (floatval($php_version) >= 5.4) {	
//     if (session_status() == PHP_SESSION_NONE) {
//         session_start();
//     }
// } else {
//     if (session_id() == '') {
//         session_start();
//     }
// }
    
// if(isset($_SESSION['authorised'])) { 
//     header("Location: admin_index.php");
//     die();
// }

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Admin Page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="css/admin.css" />
    <!-- <script src="js/admin.js"></script> -->
    <script src="js/ajax.js"></script>

</head>
<body class="login-page">
    <!-- Login form -->
<form method='POST' name='adminform'>
    <div class="login-form">
        <div class="login-container">
            <h3 id="font-h3">ADMIN LOGIN</h3>
            <div id='id_error'></div>
                     
            <input class="text-field-login" type="text" name="username" placeholder="Enter Your Username" id="id-admin-username"  required autofocus>        
            <input class="text-field-login" type="password" name="password" placeholder="Enter Your Password" id="id-admin-password"  required><br>
       
            <button  class="login-button" onclick="admin_btnLogin();"> Login </button> </br> </br>
    
        </div>
    </div>
</form>

<script>

function admin_btnLogin(){

    var adminuser = document.getElementById('id-admin-username').value;
    var adminpass = document.getElementById('id-admin-password').value; 
    alert(adminuser);
    alert(adminpass);

     if(adminuser == 'admin'){
        if(adminpass == '123'){
            window.location.replace('admin_index.php');  
        }else{
            alert('Wrong password');
        }
    }else{
            alert('Wrong Username');
    }

    // params = '&username='+adminuser+'&password='+adminpass;
    // console.log(params);
    // makeAjaxPostRequest('admin_main.php','cmd_admin_login', params, success);
}

// function success(data){
//     // window.location.replace('admin_index.php'); 
//     document.getElementById('id_error').innerHTML = data;
// }

    
</script>

</body>
</html>