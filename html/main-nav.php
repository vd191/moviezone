
<div class="header-nav">
    <div class="title-left">
        <a href="" onclick="movieShowRandomClick();">Movie<span style="color:tomato">zone</span></a>
       
    </div>
    
    <div class="nav-right">

        
        <button class="btn" onclick="movieShowAllClick();"> Show All </button>
        <button class="btn" onclick="movieNewReleaseClick();"> New Releases </button>
        <button class="btn" onclick="filterNavClick();"> Filter </button>
        <button class="btn" onclick="showContactPage();" > Contact Us </button>
        
    <?php if(!isset($_SESSION['username'])): ?>
        <button class="btn" onclick="signUpClick();" id="signup-btn"> Sign Up </button>
        <button class="btn" onclick="logInClick();" id="login-btn" style="background-color:#1991eb; color:white"> Log In </button>
    <?php else: ?>
        
        <button class="btn" onclick="checkoutClick();" id="checkout-btn" > CART</button>   
           
        <button class="btn" onclick="logOutClick();" id="logout-btn" style="background-color:tomato; color:white"> Log Out </button>                   
    <?php endif;?>
    </div>   
</div>




