
var contactMethod = '';
var magazine = 2;

function contactIsChecked(){ 
    var phoneMethod = document.getElementById('id-signup-phone-contact');
    var landlineMethod = document.getElementById('id-signup-landline-contact');
    var emailMethod = document.getElementById('id-signup-email-contact');  
 

    //Check contact method
    if(phoneMethod.checked == true){
        document.getElementById('id-signup-phone').placeholder = "Enter Your Phone Number";
        document.getElementById('id-signup-phone').disabled = false;
        document.getElementById('id-signup-landline').disabled = true;
        document.getElementById('id-signup-landline').placeholder = "Do Not Enter Here";
        document.getElementById('id-signup-email').disabled = true;
        document.getElementById('id-signup-email').placeholder = "Do Not Enter Here";
        contactMethod = "phone";    
    }

    if(landlineMethod.checked == true){
        document.getElementById('id-signup-landline').placeholder = "Enter Your Landline Number";
        document.getElementById('id-signup-landline').disabled = false;
        document.getElementById('id-signup-phone').disabled = true;
        document.getElementById('id-signup-phone').placeholder = "Do Not Enter Here";
        document.getElementById('id-signup-email').disabled = true;
        document.getElementById('id-signup-email').placeholder = "Do Not Enter Here";
        contactMethod = "landline"; 
    }

    if(emailMethod.checked == true){
        document.getElementById('id-signup-landline').disabled = true;
        document.getElementById('id-signup-landline').placeholder = "Do Not Enter Here";
        document.getElementById('id-signup-phone').disabled = true;
        document.getElementById('id-signup-phone').placeholder = "Do Not Enter Here";
        document.getElementById('id-signup-email').disabled = false;
        document.getElementById('id-signup-email').placeholder = "Enter Your Email";
        contactMethod = "email"; 
    }
}

function magazineIsChecked(){
    var managinzeMethod = document.getElementById('id-signup-magazine');
    if (managinzeMethod.checked==true){
        document.getElementById('id-signup-street').placeholder = "Enter Your Street Adrress";
        document.getElementById('id-signup-suburb').placeholder = "Enter Your Suburb and State";
        document.getElementById('id-signup-postcode').placeholder = "Enter Your Postcode";
        document.getElementById('id-signup-street').disabled = false;
        document.getElementById('id-signup-suburb').disabled = false;
        document.getElementById('id-signup-postcode').disabled = false;
        magazine = 1;
    }
    
    if (managinzeMethod.checked==false){
        document.getElementById('id-signup-street').placeholder = "Do Not Enter Here";
        document.getElementById('id-signup-suburb').placeholder = "Do Not Enter Here";
        document.getElementById('id-signup-postcode').placeholder = "Do Not Enter Here";
        document.getElementById('id-signup-street').disabled = true;
        document.getElementById('id-signup-suburb').disabled = true;
        document.getElementById('id-signup-postcode').disabled = true;  
        magazine = 2;
    }   
}

//Validation Sign up form
function validateSignUpForm(){
    //Define regex
    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; // ___@___.___   
    var passRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.{3,})/; //Must contain a number, a capital, a lowercase, min 3 chars
    var phoneRegex = /[0][45][-\s]?\d{2}[-\s]?\d{2}[-\s]?\d[-\s]?\d{3}/ ;  // 0[4 or 5] XXXX-XXXX, 0[4 or 5]XXXXXXXX, 0[4 or 5]XXXX-XXXX, 0[4 or 5]XXXX XXXX

    var landlineRegex =  /[0][236789][-\s]?\d{2}[-\s]?\d{2}[-\s]?\d[-\s]?\d{3}/ ; // 0[2,3,6,7,8,9] XXXX-XXXX, 0[2,3,6,7,8,9]XXXXXXXX, 0[2,3,6,7,8,9]XXXX-XXXX, 0[2,3,6,7,8,9]XXXX XXXX
    var charRegex = /[a-zA-Z]/; //Chars only 
    var postcodeRegex = /[0-9]{4}/;//Number only
    var streetRegex = /[a-zA-X0-9]/; //Chars and numbers
    var userNameRegex =/[a-zA-X0-9]/;//Chars and numbers

    var params = "";
    var err="";

    //Selecting all text elements
    var surname = document.getElementById('id-signup-surname').value;
    var othername = document.getElementById('id-signup-other-name').value;
    var occupation = document.getElementById('id-signup-occupation').value;

    var phone = document.getElementById('id-signup-phone').value;
    var landline = document.getElementById('id-signup-landline').value;
    var email = document.getElementById('id-signup-email').value;

    var street = document.getElementById('id-signup-street').value;
    var suburb = document.getElementById('id-signup-suburb').value;
    var postcode = document.getElementById('id-signup-postcode').value;

    var username = document.getElementById('id-signup-username').value;
    var pass = document.getElementById('id-signup-password').value;
    var verifyPass = document.getElementById('id-signup-verify-password').value;

    // Validation surname
    if (surname.match(charRegex) ){
        params += '&surname='+surname;
    }else{
        err = err + "Surname Format Err ";
    }

    // Validation othername
    if (othername.match(charRegex) ){
        params += '&othername='+othername;
    }else{
        err = err + "Othername Format Err ";
    }

    // Validation Occupation
    if (occupation.match(charRegex) ){
        params += '&occupation='+occupation;
    }else{
        err = err + "Occupation Format Err ";
    }
    
    // Validation phone
    if(contactMethod == "phone"){
        if (phone.match(phoneRegex) ){
            params +='&contactmethod='+contactMethod+ '&phone='+phone ;  
        }else{
            err= err + " Phone Err";
        }    
    }
    
    // Validation landline
    if(contactMethod == "landline"){
        if (landline.match(landlineRegex) ){
            params += '&contactmethod='+contactMethod+ '&landline='+landline ;
        }else{
            err = err + "Landline Format Err ";
        }
    }
    
    // Validation email
    if(contactMethod == "email"){
        if (email.match(emailRegex) ){
            params += '&contactmethod='+contactMethod+ '&email='+email;
        }else{
            err = err + "Email Format Err ";
        }
    }

    if(magazine == 1){
        // Validation street
        if (street.match(streetRegex)) {
            params +='&magazine='+magazine + '&street='+street ;
        } else{
            err = err + "street Format Err ";
        }

        // Validation suburb
        if (suburb.match(charRegex) ){
            params += '&suburb='+suburb;
        } else{
            err = err + "suburb Format Err ";
        }
        
        // Validation postcode
        if (postcode.match(postcodeRegex)){
            params += '&postcode='+postcode;
        } else{
            err = err + "postcode Format Err ";
        }
    }
    
    if(magazine == 2){
        params +='&magazine='+magazine ;
    }
    
    // Validation username
    if (username.match(userNameRegex) ){
        params += '&username='+username;
    }else{
        err = err + "username Format Err ";
    }
    
    // Validation pass
    if (pass.match(passRegex) ){
        
    }else{
        err= err + "Password Format Err ";
    }

    // Validation verify
    if (verifyPass == pass){  
        params += '&verifiedpass='+verifyPass; 
    }else{
        err= err + "Verify Password Err ";
    }

    if(err == ""){
        makeAjaxGetMemberRequest('main.php', 'cmd_member_register', params, logInClick);
        
    }else{
        document.getElementById('signup-mess').innerHTML = err;
    }

}

   