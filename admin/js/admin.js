
window.addEventListener("load", function(){
    makeAjaxGetRequest('admin_main.php','cmd_new_release_request', null, updateContent);
    document.getElementById('id-title-content').innerHTML = "<span id='content-text'>New release</span>";
});

function admin_btnLogout(){
    makeAjaxGetRequest('admin_main.php','cmd_admin_logout', null, windowReplace);
}


function windowReplace(){
    window.location.replace('../index.php');
}

function adminShowAllClick(){
    makeAjaxGetRequest('admin_main.php','cmd_show_all_request', null, updateContent);
    document.getElementById('id-title-content').innerHTML = "<span id='content-text'>Show all movies</span>";
}

function adminShowNewReleaseClick(){
    makeAjaxGetRequest('admin_main.php','cmd_new_release_request', null, updateContent);
    document.getElementById('id-title-content').innerHTML = "<span id='content-text'>New release</span>";
}


function updateActorForm(actor){
    document.getElementById('id-star1-box').innerHTML = actor;
    document.getElementById('id-star2-box').innerHTML = actor;
    document.getElementById('id-star3-box').innerHTML = actor;
    document.getElementById('id-costar1-box').innerHTML = actor;
    document.getElementById('id-costar2-box').innerHTML = actor;
    document.getElementById('id-costar3-box').innerHTML = actor;
}

function updateNewMovieForm(data){
    document.getElementById('id-select-box-content').innerHTML = data;
}


function adminShowAllUserClick(){
    makeAjaxGetRequest('admin_main.php','cmd_all_user_request', null, updateContent);
    document.getElementById('id-title-content').innerHTML = "<span id='content-text'>All User</span>";
}

function adminNewUserClick(){
    makeAjaxGetRequest('admin_main.php','cmd_new_user_request', null, updateContent);
    document.getElementById('id-title-content').innerHTML = "<span id='content-text'>New User</span>";
}


function addNewMovieExitBtn(){
    alert('exit new movie test');
}

function updateContent(data){
    document.getElementById('id-content').innerHTML = data;
}

function editmovie(movieID){
    params = '&movieID='+movieID ;
    makeAjaxPostRequest('admin_main.php','cmd_edit_movie_form', params, updateContent);
    document.getElementById('id-title-content').innerHTML = "<span id='content-text'> EDIT STOCK INFORMATION</span>";
}

function deletemovie(movieID){
    var params = '&movieid='+movieID;
    makeAjaxPostRequest('admin_main.php', 'cmd_delete_movie', params, function(){
        adminShowNewReleaseClick();
    });
}

function reloadWindow(){
    location.reload();
} 

function deleteUser(userID){
    var params = '&userid='+userID;

    makeAjaxPostRequest('admin_main.php', 'cmd_delete_user', params, function(){
        adminShowAllUserClick();
    });
}

function editUser(memberid){
    //Call the Edit User Form.
    var params = '&memberid='+memberid;
    makeAjaxPostRequest('admin_main.php', 'cmd_edit_form', params, updateContent );
    document.getElementById('id-title-content').innerHTML = "<span id='content-text'>Edit User</span>";
}

/*Loads photo from local system to input form
*/
function loadPhoto(fileSelector) {
	var files = fileSelector.files;
    // FileReader support
    if (FileReader && files && files.length) {
        var fr = new FileReader();
        fr.onload = function () {
            document.getElementById('id_photo_frame').src = fr.result;
        }
        fr.readAsDataURL(files[0]);
    }
    // Not supported
    else {
        
    }
}

function adminNewMovieClick(){
    //Show new Movie Form
    makeAjaxGetRequest('admin_main.php','cmd_new_movie_request', null, function(data){
        updateContent(data); // Load the New Movie Form to Browser
        updateMovieForm();
    });
    //Update title
    document.getElementById('id-title-content').innerHTML = "<span id='content-text'>New Movie</span>";
}

function updateMovieForm(movieID){
    // //Show the list of director, genre, classification , studio.
    // makeAjaxGetRequest('admin_main.php','cmd_show_select_box', null, updateNewMovieForm );
    // //Show actor list
    // makeAjaxGetRequest('admin_main.php','cmd_show_actor_select_box', null, updateActorForm);
     
    if(movieID == null){
        document.movie.btnSubmit.onclick = function() {
            btnAddEditCarSubmitClick('cmd_add_new_movie_request');
        }
    }
    
}


function btnAddEditCarSubmitClick(command){
    if (!validate(document.movie))
        return;
    var moviedata = new FormData(document.movie);
    //command = cmd_add_new_movie_request
    makeAjaxPostRequest('admin_main.php', command, moviedata, updateContent);  
}

function editStock(){
    if(!validateStock(document.editMovieStock))
    return;
    var stockdata = new FormData(document.editMovieStock);
    makeAjaxPostRequest('admin_main.php', 'cmd_edit_movie_stock_request', stockdata, updateContent);  
}


//validate movie stock
function validateStock(stockform){
    var regex = [
        /[0-9]{1,}/, // movieid
        /[+-]?([0-9]*[.])?[0-9]+$/, //dvd_rental_price
        /[+-]?([0-9]*[.])?[0-9]+$/, //dvd_purchase_price
        /[0-9]{1,}/, // numdvdout
        /[+-]?([0-9]*[.])?[0-9]+$/, //bluray_rental_price
        /[+-]?([0-9]*[.])?[0-9]+$/, //bluray_purchase_price
        /[0-9]{1,}/, // numblurayout
    ];
    
    	//error messages
	var errors = [
        'movieid should contain number only',
        'dvd_rental_price should contain number only', 
        'dvd_purchase_price should contain number only', 
        'numdvdOut should contain number only', 
        'bluray_rental_price should contain number only', 
        'bluray_purchase_price should contain number only', 
        'numblurayOut should contain number only'
    ];
    
    var names = ['movieid',
        'dvd_rental_price', 'dvd_purchase_price', 'numdvdout', 
        'bluray_rental_price', 'bluray_purchase_price', 'numblurayout'
	];
	//perform the validation
	for (var i = 0; i < names.length; i++) {
		if (!regex[i].test(stockform.elements[names[i]].value)) {
            alert (errors[i]);

			return false;
		}
	}
	return true;

}


//validate submitted data
function validate(movieform) {
	//regex
	var regex = [
        /[a-zA-X0-9]/, //title
        /^\d{4}$/, //year
        /[a-zA-X0-9]/, //tagline 
        /[a-zA-X0-9]/, //plot
        /[a-zA-X0-9]/, //classification
        // /[a-zA-X0-9]/, //new director
        // /[a-zA-X0-9]/, //new studio
        // /[a-zA-X0-9]/, //new genre
        /[a-zA-X0-9]/, //rentalPeriod
        // /[a-zA-X0-9]/, //box star1
        // /[a-zA-X0-9]/, //box star2
        // /[a-zA-X0-9]/, //box star3
        // /[a-zA-X0-9]/, //box costar1
        // /[a-zA-X0-9]/, //box costar2
        // /[a-zA-X0-9]/, //box costar3
        /[a-zA-X0-9]/, //star1
        /[a-zA-X0-9]/, //star2
        /[a-zA-X0-9]/, //star3
        /[a-zA-X0-9]/, //costar1
        /[a-zA-X0-9]/, //costar2
        /[a-zA-X0-9]/, //costar3
        /[a-zA-X0-9]/, //new director
        /[a-zA-X0-9]/, //new genre
        /[a-zA-X0-9]/, //new studio
        /[+-]?([0-9]*[.])?[0-9]+$/, //dvd_rental_price
        /[+-]?([0-9]*[.])?[0-9]+$/, //dvd_purchase_price
        /[0-9]{1,}/, // numdvd
        /[+-]?([0-9]*[.])?[0-9]+$/, //bluray_rental_price
        /[+-]?([0-9]*[.])?[0-9]+$/, //bluray_purchase_price
        /[0-9]{1,}/, // numbluray
	];
	//error messages
	var errors = [
        'title begins with letter and number', 
        'year should have 4 digits ', 
        'tagline should contain characters', 
        'plot should contain characters', 
        'classification should contain characters', 
        'director should contain characters only', 
        'studio should contain characters', 
        ' genre should contain characters', 
        'rental_period should contain charcter or number',  
        'star1 should contain characters only', 
        'star2 should contain characters only', 
        'star3 should contain characters only', 
        'costar1 should contain characters only', 
        'costar2 should contain characters only', 
        'costar3 should contain characters only', 
        'dvd_rental_price should contain number only', 
        'dvd_purchase_price should contain number only', 
        'numdvd should contain number only', 
        'bluray_rental_price should contain number only', 
        'bluray_purchase_price should contain number only', 
        'numbluray should contain number only'
	];
	var names = [
        'title', 'year', 'tagline', 'plot', 'classification', 'director', 
        'studio', 'genre', 'rental_period', 
         'star1', 'star2', 'star3', 'costar1', 'costar2', 'costar3', 
        'dvd_rental_price', 'dvd_purchase_price', 'numdvd', 
        'bluray_rental_price', 'bluray_purchase_price', 'numbluray'
	];
	//perform the validation
	for (var i = 0; i < names.length; i++) {
		if (!regex[i].test(movieform.elements[names[i]].value)) {
            alert (errors[i]);
			return false;
		}
	}
	return true;
}


