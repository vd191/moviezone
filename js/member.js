

//Show Register member form
function signUpClick(){
    makeAjaxGetMemberRequest('main.php','cmd_signup_form', null, updateContent);
    document.getElementById('id-filter-nav').innerHTML = "<div class='title'><span id='title-text'></span></div>";

}

function logInClick(){
    makeAjaxGetMemberRequest('main.php','cmd_login_form', null, updateContent);
    document.getElementById('id-filter-nav').innerHTML = "<div class='title'><span id='title-text'></span></div>";

}

function logOutClick(){
    makeAjaxGetMemberRequest('main.php','cmd_logout', null, windowReplace);
}   

function windowReplace(){
    window.location.replace('index.php');
}

function autoLogin(){
    alert('auto login');
}

function login_btnOKClicked(){
    err = '';
    prams = '';
    var username = document.getElementById('id-login-username').value;
    var password = document.getElementById('id-login-password').value;
    
    if(username != ''){
        prams += '&username=' +username;
    }else{
        err += "Login field blank"; 
    }
        
    if (password != ''){
        prams += '&password=' +password;
    }else{
        err += "Pass blank";
    }

    if(err == ""){
        makeAjaxPostMemberRequest('main.php','cmd_login', prams, windowReplace);

    }   else{
        alert("fill the form");
    } 
}

function checkoutClick(){
    makeAjaxGetMemberRequest('main.php','cmd_checkout', null, updateContent);
    document.getElementById('id-filter-nav').innerHTML = "<div class='title'><span id='title-text'>Checkout</span></div>";
}

function selectmovie(movieID){
    params = '&movieid=' +movieID;
    makeAjaxGetMemberRequest('main.php','cmd_book_movie', params, test);
}

function test(){
    alert('Check your Cart');

  
}
