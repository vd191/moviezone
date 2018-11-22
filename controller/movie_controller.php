<?php
/*-------------------------------------------------------------------------------------------------
@Module: movie_controller.php
This server-side module provides all required functionality to format and display movies in html

@Author: Viet Duong Nguyen
@Modified by: 
@Date: 16/07/2018
--------------------------------------------------------------------------------------------------*/

/**
 * Class Controller handle the requests of other domain and all it related behaviors
 */
class Controller
{
    private $view;

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

    public function loadMainNav()
    {
        $this->view->mainNav();
    }

    /**
     * Accept a HTTP Request and pick the right handler for it
     *
     * @param $request
     */
    public function processRequest($request)
    {
        switch ($request) {
            case CMD_MOVIE_SELECT_ALL:
                $this->handleSelectAllRequest();
                break;
            case CMD_MOVIE_SELECT_RANDOM:
                $this->handleSelectRandomRequest();
                break;
            case CMD_MOVIE_NEW_RELEASE:
                $this->handleSelectNewReleaseRequest();
                break;
            case CMD_SHOW_FILTER_NAV:
                $this->handleShowFilterNav();
                break;
            case CMD_MOVIE_FILTER:
                $this->handleFilterMovieRequest();
                break;
            case CMD_SHOW_CONTACT_PAGE:
                $this->handleShowContactPage();
                break;    
            default:
                $this->handleSelectRandomRequest();
                break;
        }
    }

    public function handleShowContactPage(){
        $this->view->showContactPage();
    }

    /**
     * Handles select all movies request
     */
    private function handleSelectAllRequest()
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
     * Handles select random movies request
     */
    private function handleSelectRandomRequest()
    {
        $movies = $this->model->selectRandom();
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
     * Handles select new release movies request
     */
    private function handleSelectNewReleaseRequest()
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

    /**
     * Loads Filter navigation panel
     */
    public function handleShowFilterNav()
    {

        $directors = $this->model->selectAllDirectors();
        $actors = $this->model->selectAllActors();
        $genres = $this->model->selectAllGenres();
        $studios = $this->model->selectAllStudios();


        //Check if the return data from model class is not null then show the navigation, else show error
        if (($directors != null) && ($actors != null) && ($studios != null) && ($genres != null)) {
            $this->view->topNavPanel($directors, $actors, $studios, $genres);
        } else {
            $error = $this->model->getError();
            if (!empty($error)) {
                $this->view->showError($error);
            }
        }
    }

    /**
     * Handle filter movie request
     */
    private function handleFilterMovieRequest()
    {
        $condition = []; //$condition array including 4 values actor_id, director_id, genre_id, studio_id

        if (!empty($_REQUEST['actorname'])) {
            $condition['actor_name'] = $_REQUEST['actorname'];
        }

        if (!empty($_REQUEST['directorname'])) {
            $condition['director_name'] = $_REQUEST['directorname'];
        }

        if (!empty($_REQUEST['genrename'])) {
            $condition['genre_name'] = $_REQUEST['genrename'];
        }

        if (!empty($_REQUEST['studioname'])) {
            $condition['studio_name'] = $_REQUEST['studioname'];
        }

        // pass the $condition array to Model for handling
        $movies = $this->model->filterMovies($condition);
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
