<?php

/**
 * MemberController handle the requests of member domain and all it related behaviors
 */
Class MemberController
{
    /**
     * @var MemberView
     */
    private $memberView;

    /**
     * @var MemberModel
     */
    private $memberModel;

    /**
     * @param MemberView  $memberView
     * @param MemberModel $memberModel
     */
    public function __construct(MemberView $memberView, MemberModel $memberModel)
    {
        $this->memberView = $memberView;
        $this->memberModel = $memberModel;
    }

    /**
     * Accept a HTTP Request and pick the right handler for it
     *
     * @param $request
     */
    public function processMemberRequest($request)
    {
        switch ($request) {
            case CMD_MEMBER_REGISTER:
                $this->handleMemberRegister();
                break;
            case CMD_SIGNUP_FORM:
                $this->handleShowSignUpForm();
                break;
            case CMD_LOGIN_FORM:
                $this->handleShowLogInForm();
                break;
            case CMD_LOGIN:
                $this->handleLoginRequest();
                break;
            case CMD_LOGOUT:
                $this->handleLogoutRequest();
                break;
            case CMD_BOOK_MOVIE:
                $this->handleBookRequest();
                break;
            case CMD_CHECKOUT:
                $this->handleCheckoutRequest();
                break;
        }
    }

    /**
     * Print out the notification code for now
     * but in the future JSON can be used to encode the
     * communication protocol between client and server
     *
     * @param $code
     */
    private function notifyClient($code)
    {
        print $code;
    }

    /**
     * Allow member to checkout their movies
     */
    private function handleCheckoutRequest()
    {
        $movies = [];
        if (isset($_SESSION['movie'])) {
            foreach ($_SESSION['movie'] as $key) {
                $movies[] = $key;
            }

            if (!empty($movies)) {
                $result = $this->memberModel->bookMovie($movies);
                if ($result != null) {
                    $this->memberView->showMovie($result);
                } else {
                    $error = $this->memberModel->getError();
                    if (!empty($error)) {
                        $this->memberView->showError($error);
                    }
                }
            }
        } else {
            $err = 'Please Select Something';
            $this->memberView->showStatus($err);
        }

    }

    /**
     * Allow member to book a movie
     */
    private function handleBookRequest()
    {
        if (!empty($_GET['movieid'])) {
            $id = $_GET['movieid'];
            $_SESSION['movie'][] = $id;
        }

        if (isset($id)) {
            $this->notifyClient(ERR_SUCCESS);
        }
    }

    /**
     * Logout user/member
     */
    private function handleLogoutRequest()
    {
        if ($_SESSION['username']) {
            session_destroy();
            $this->notifyClient(ERR_SUCCESS);
        }
    }

    /**
     * Login user/member by their username and password
     */
    private function handleLoginRequest()
    {
        //take username and password and perform authentication
        //if successful, initialize the user session
        $username = !empty($_POST['username']) ? $_POST['username'] : null;
        $password = !empty($_POST['password']) ? $_POST['password'] : null;
        $result = $this->memberModel->userLogin($username, $password); // $result = true/false

        if ($result) {
            //authorise user with the username to access
            $_SESSION['username'] = $username;

            /*and notify the caller about the successful login
			 the notification protocol should be predefined so
			 the client and server can understand each other
            */
            $this->notifyClient(ERR_SUCCESS);
        } else {
            //not successful show error to user
            $error = $this->memberModel->getError();
            if (!empty($error)) {
                $this->memberView->showError($error);
            }
        }
    }

    /**
     * Render sign up form
     */
    private function handleShowSignUpForm()
    {
        $this->memberView->showSignUpForm();
    }

    /**
     * Render login form
     */
    private function handleShowLogInForm()
    {
        $this->memberView->showLogInForm();
    }

    /**
     *  Register user/member
     */
    private function handleMemberRegister()
    {
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
        $userProfiles = $this->memberModel->addMember($members);

        if ($userProfiles != null) {
            foreach ($userProfiles as $userProfile) {
                $username = $userProfile['username'];
                $password = $userProfile['password'];
                $this->memberView->showMessage($username, $password);
            }
        } else {
            $error = $this->memberModel->getError();
            if (!empty($error)) {
                $this->memberView->showError($error);
            }
        }
    }
}
