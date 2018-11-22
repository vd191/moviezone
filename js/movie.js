
window.addEventListener("load", function(){
    makeAjaxGetRequest('main.php', 'cmd_movie_select_random', null, updateContent);
    // makeAjaxGetRequest('movie_main.php','cmd_signup_form', null, updateContent);
    // makeAjaxGetRequest('main.php','cmd_login_form', null, updateTopNav);
    // document.getElementById('logout-btn').style.display = "none";
    
});

function movieShowRandomClick() {	
    makeAjaxGetRequest('main.php', 'cmd_movie_select_random', null, updateContent);
}
/* Handles show all movies onlick event to show all movies */
function movieShowAllClick() {	
    makeAjaxGetRequest('main.php','cmd_movie_select_all', null, updateContent);
    document.getElementById('id-filter-nav').innerHTML = "<div class='title'><span id='title-text'>All movies</span></div>";
}


function showContactPage(){
    makeAjaxGetRequest('main.php','cmd_show_contact_page', null, updateContent);
    document.getElementById('id-filter-nav').innerHTML = "<div class='title'><span id='title-text'>About Us</span></div>";
}

/* Handles show new release movies onlick event to show new release movies */
function movieNewReleaseClick(){
    makeAjaxGetRequest('main.php','cmd_movie_new_release', null, updateContent);
    document.getElementById('id-filter-nav').innerHTML = "<div class='title'><span id='title-text'>New release</span></div>";
   
}

function filterNavClick(){
    makeAjaxGetRequest('main.php','cmd_show_filter_nav', null, updateTopNav);
}

function movieFilterChanged(){
    var genreName = document.getElementById('id-genre').value;
    var actorName = document.getElementById('id-actor').value; //value "actor_id" from select box
    var directorName = document.getElementById('id-director').value;  
    var studioName = document.getElementById('id-studio').value;
    var params= '';

    if (directorName != 'all')
        params += '&directorname=' +directorName; // params = params + '&actor=' + actor. ex: params = &actorid=6  (actor_id)
    
    if (actorName != 'all')
        params += '&actorname=' +actorName; 

    if (studioName != 'all')
        params += '&studioname=' +studioName; 

    if (genreName != 'all')
        params += '&genrename=' +genreName; 
        
	makeAjaxGetRequest('main.php', 'cmd_movie_filter', params, updateContent);  // ex: params = &actorid=6  (actor_id)
}


// parameter 'data' is the return variable 'this.responseText' from ajax
function updateTopNav(data){
    document.getElementById('id-filter-nav').innerHTML = data; 
}

function updateContent(data) {
	document.getElementById('content').innerHTML = data;
}




  
    
    
