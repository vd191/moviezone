<?php

require_once('admin_config.php');

/**
 * Class Controller
 */
Class Controller
{
    /**
     * @var
     */
    private $view;

    /**
     * @var
     */
    private $model;

    /**
     * @param $view
     * @param $model
     */
    public function __construct($view, $model)
    {
        $this->view = $view;
        $this->model = $model;
    }

    /* Notifies client machine about the outcome of operations
    This is used for M2M communication when Ajax is used.
	*/
	private function notifyClient($code) {
		/*simply print out the notification code for now
		but in the future JSON can be used to encode the
		communication protocol between client and server
		*/		
        print $code;
	}


    /**
     * @param $request
     */
    public function processRequest($request)
    {
        switch ($request) {
            case CMD_ADMIN_LOGIN:
                $this->handleAdminLoginRequest();
                break;
            case CMD_ADMIN_LOGOUT:
                $this->handleAdminLogoutRequest();
                break;    
            case CMD_SHOW_ALL_REQUEST:
                $this->handleShowAllRequest();
                break;
            case CMD_NEW_RELEASE_REQUEST:
                $this->handleShowNewReleaseRequest();
                break;
            case CMD_NEW_MOVIE_REQUEST:
                $this->handleAdminNewMovieRequest();
                break;
            case CMD_NEW_USER_REQUEST:
                $this->handleAdminNewUserRequest();
                break;
            case CMD_ALL_USER_REQUEST:
                $this->handleShowAllUserRequest();
                break;
            case CMD_ADD_NEW_MOVIE_REQUEST:
                $this->handleAddNewMovieRequest();
                break;
            case CMD_SHOW_SELECT_BOX:
                $this->handleShowSelectBox();
                break;
            case CMD_SHOW_ACTOR_SELECT_BOX:
                $this->handleShowActorSlectBox();
                break;
            case CMD_DELETE_MOVIE:
                $this->handleDeleteMovie();
                break;
            case CMD_DELETE_USER:
                $this->handleDeleteUser();
                break;
            case CMD_MEMBER_REGISTER:
                $this->handleMemberRegister();  
                break;  
            case CMD_EDIT_FORM:
                $this->handleShowEditForm();
                break;   
            case CMD_MEMBER_EDIT:
                $this->handleEditMember();
                break; 
            case CMD_EDIT_MOVIE_FORM:
                $this->showEditMovieForm();
                break;
            case CMD_EDIT_MOVIE_STOCK_REQUEST:
                $this->handleUpdateMovieStock();
                break;
            
        }
    }

    public function handleUpdateMovieStock(){
        $keys = array('movieid',
        'dvd_rental_price', 'dvd_purchase_price', 'numdvdout', 
        'bluray_rental_price', 'bluray_purchase_price', 'numblurayout');
        //retrive submiteed data
        
		$stockdata = array();
		foreach ($keys as $key) {
			if (!empty($_REQUEST[$key])) {
				$stockdata[$key] = $_REQUEST[$key];
			} else {
				$this->view->showError($key.' cannot be blank');
				return;
			}
        }	

		$result= $this->model->updateMovieStock($stockdata);
		if ($result)
			$this->notifyClient(ERR_SUCCESS);
		else {
			$error = $this->model->getError();
			if (!empty($error))
				$this->view->showError($error);			
		}
    }

    public function showEditMovieForm(){
        if(!empty($_REQUEST['movieID'])){
            $movieID  = $_REQUEST['movieID'];
        }
        $this->view->showEditMovieForm($movieID);
    }



    public function handleAdminLogoutRequest(){
        if ($_SESSION['authorised']) {
            session_destroy();
            $this->notifyClient(ERR_SUCCESS);
        }
    }

    /**
     * Handle login as an admin user
     */
    public function handleAdminLoginRequest()
    {
        $adminusername = !empty($_REQUEST['username']) ? $_REQUEST['username'] : null;
        $adminpassword = !empty($_REQUEST['password']) ? $_REQUEST['password'] : null;

        // $adminusername = $_REQUEST['username'];
        // $adminpassword = $_REQUEST['password'];
        $this->view->showAdminIndex();
        if ($adminusername == 'admin'){           
            if ($adminpassword == '123'){
                $_SESSION['authorised'] = 'admin';
                $this->view->showAdminIndex();
                // var_dump($_SESSION['authorised']);
            }else{
                $this->view->showError('Wrong password');
            }  
        }else{
            $this->view->showError('Wrong admin username');
        }

        // //take username and password and perform authentication
		// //if successful, initialize the user session
		// //echo 'OK';
		// $keys = array('username','password');
		// //retrive submiteed data
		// $admin = array();
		// foreach ($keys as $key) {
		// 	if (!empty($_REQUEST[$key])) {
		// 		//more server side checking can be done here
		// 		$admin[$key] = $_REQUEST[$key];
		// 	} else {
		// 		//check required field
		// 		$this->view->showError($key.' cannot be blank');
		// 		return;
        //     }
        // }
        	
        // //Check that username pass correct?
        // $result = $this->model->userLogin($admin); // $result = true/false

        // if ($result) {
        //     //If the input user pass correct.
        //     //authorise user with the username to access
        //     $_SESSION['adminusername'] = $_REQUEST['username'];
        //     $_SESSION['adminpass'] = $_REQUEST['password'];

        //     $this->notifyClient(ERR_SUCCESS);
        // } else {
        //     //not successful show error to user
        //     $error = $this->memberModel->getError();
        //     if (!empty($error)) {
        //         $this->memberView->showError($error);
        //     }
        // }
    }

    public function handleShowEditForm(){
        $userID  = $_POST['memberid'];
        $user = $this->model->selectUserInfo($userID);
        if($user!=null){
            $this->view->showEditUserForm($user);
        }
    }

    public function handleEditMember(){
        $members = [];
        if (!empty($_REQUEST['edituserid'])) {
            $members['edituserid'] = $_REQUEST['edituserid'];
        }

        if (!empty($_REQUEST['surname'])) {
            $members['surname'] = $_REQUEST['surname'];
        }

        if (!empty($_REQUEST['othername'])) {
            $members['othername'] = $_REQUEST['othername'];
        }

        if (!empty($_REQUEST['occupation'])) {
            $members['occupation'] = $_REQUEST['occupation'];
        }

        if (!empty($_REQUEST['contactmethod'])) {
            $members['contactmethod'] = $_REQUEST['contactmethod'];
        }

        if (!empty($_REQUEST['username'])) {
            $members['username'] = $_REQUEST['username'];
        }

        if (!empty($_REQUEST['verifiedpass'])) {
            $members['verifiedpass'] = $_REQUEST['verifiedpass'];
        }

        if (!empty($_REQUEST['magazine'])) {
            $members['magazine'] = $_REQUEST['magazine'];
        }

        $members['phone'] = !empty($_REQUEST['phone']) ? $_REQUEST['phone'] : null;
        $members['landline'] = !empty($_REQUEST['landline']) ? $_REQUEST['landline'] : null;
        $members['email'] = !empty($_REQUEST['email']) ? $_REQUEST['email'] : null;
        $members['street'] = !empty($_REQUEST['street']) ? $_REQUEST['street'] : null;
        $members['suburb'] = !empty($_REQUEST['suburb']) ? $_REQUEST['suburb'] : null;
        $members['postcode'] = !empty($_REQUEST['postcode']) ? $_REQUEST['postcode'] : 'NULL';

        
 
        $this->model->editMember($members);
        
    }


    public function handleMemberRegister(){
        $members = [];

        if (!empty($_REQUEST['surname'])) {
            $members['surname'] = $_REQUEST['surname'];
        }

        if (!empty($_REQUEST['othername'])) {
            $members['othername'] = $_REQUEST['othername'];
        }

        if (!empty($_REQUEST['occupation'])) {
            $members['occupation'] = $_REQUEST['occupation'];
        }

        if (!empty($_REQUEST['contactmethod'])) {
            $members['contactmethod'] = $_REQUEST['contactmethod'];
        }

        if (!empty($_REQUEST['username'])) {
            $members['username'] = $_REQUEST['username'];
        }

        if (!empty($_REQUEST['verifiedpass'])) {
            $members['verifiedpass'] = $_REQUEST['verifiedpass'];
        }

        if (!empty($_REQUEST['magazine'])) {
            $members['magazine'] = $_REQUEST['magazine'];
        }

        $members['phone'] = !empty($_REQUEST['phone']) ? $_REQUEST['phone'] : null;
        $members['landline'] = !empty($_REQUEST['landline']) ? $_REQUEST['landline'] : null;
        $members['email'] = !empty($_REQUEST['email']) ? $_REQUEST['email'] : null;
        $members['street'] = !empty($_REQUEST['street']) ? $_REQUEST['street'] : null;
        $members['suburb'] = !empty($_REQUEST['suburb']) ? $_REQUEST['suburb'] : null;
        $members['postcode'] = !empty($_REQUEST['postcode']) ? $_REQUEST['postcode'] : 'NULL';

        // pass the $members array to Model for handling
        $userProfiles = $this->model->addMember($members);

        if ($userProfiles != null) {
            foreach ($userProfiles as $userProfile) {
                $username = $userProfile['username'];
                $password = $userProfile['password'];
                $this->memberView->showMessage($username, $password);
            }
        } else {
            $error = $this->meodel->getError();
            if (!empty($error)) {
                $this->view->showError($error);
            }
        }
    }
    

    public function handleDeleteUser(){
        $userID = $_POST['userid'];
        $this->model->deleteUser($userID);
    }

    public function showUserEditForm(){
        if(isset($_POST['userid'])){
            $userID = $_POST['userid'];
            $user = $this->model->getUserInfo($userID);
            
            if($user){
                $this->view->showEditUserForm($user);
            }else {
                $error = $this->model->getError();
                if (!empty($error)) {
                    $this->view->showError($error);
                }
            }
        }else{
            echo " userid is not set ";
        }
          
    }

    public function handleDeleteMovie(){
        $movieID = $_POST['movieid'];
        $this->model->deleteMovie($movieID);
    }

    public function handleShowActorSlectBox(){
        $actors = $this->model->selectAllActors();

        if($actors != null){
            $this->view->actorsSelectBoxPanel($actors);
        }else {
            $error = $this->model->getError();
            if (!empty($error)) {
                $this->view->showError($error);
            }
        }
    }

    public function handleShowSelectBox(){
        
        $directors = $this->model->selectAllDirectors();
        $genres = $this->model->selectAllGenres();
        $studios = $this->model->selectAllStudios();


        //Check if the return data from model class is not null then show the navigation, else show error
        if (($directors != null) && ($studios != null) && ($genres != null)) {
            $this->view->selectBoxPanel($directors, $studios, $genres);
        } else {
            $error = $this->model->getError();
            if (!empty($error)) {
                $this->view->showError($error);
            }
        }
    }

    

    /**
     * Add new movie
     */
    public function handleAddNewMovieRequest()
    {
        $keys = array('title', 'year', 'tagline', 'plot', 'classification', 'director', 
        'studio', 'genre', 'rental_period', 
        'star1', 'star2', 'star3','costar1', 'costar2', 'costar3', 

        'dvd_rental_price', 'dvd_purchase_price', 'numdvd', 
        'bluray_rental_price', 'bluray_purchase_price', 'numbluray');
		//retrive submiteed data
		$moviedata = array();
		foreach ($keys as $key) {
			if (!empty($_REQUEST[$key])) {
				$moviedata[$key] = $_REQUEST[$key];
			} else {
				$this->view->showError($key.' cannot be blank');
				return;
			}
        }		
		$movieID = $this->model->addMovie($moviedata);
		if ($movieID != null)
			$this->notifyClient(ERR_SUCCESS);
		else {
			$error = $this->model->getError();
			if (!empty($error))
				$this->view->showError($error);			
		}
        
    }


    /**
     * Get all users
     */
    public function handleShowAllUserRequest()
    {
        $users = $this->model->selectAllUser();
        if ($users != null) {
            $this->view->showUser($users);
        } else {
            $error = $this->model->getError();
            if (!empty($error)) {
                $this->view->showError($error);
            }
        }
    }

    /**
     * Render new movie view
     */
    public function handleAdminNewMovieRequest()
    {
        $this->view->showNewMovieForm();
    }

    /**
     * Render new user form
     */
    public function handleAdminNewUserRequest()
    {
        $this->view->showNewUserForm();
    }

    /**
     * Render all
     */
    public function handleShowAllRequest()
    {
        $movies = $this->model->selectAll();
        if ($movies != null) {
            $this->view->showMovie($movies);
        } else {
            $error = $this->model->getError();
            if (!empty($error)) {
                $this->view->showError($error);
            }
        }
    }

    /**
     * Render new release
     */
    public function handleShowNewReleaseRequest()
    {
        $movies = $this->model->selectNewRelease();
        if ($movies != null) {
            $this->view->showMovie($movies);
        } else {
            $error = $this->model->getError();
            if (!empty($error)) {
                $this->view->showError($error);
            }
        }
    }




}
