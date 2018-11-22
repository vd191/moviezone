<?php

require_once('admin_config.php');

/**
 * Class Model
 */
class Model
{
    /**
     * @var Adapter
     */
    private $dbAdapter;

    /**
     * @var string
     */
    private $error;

    /**
     * When the object is created it will initialize the values that used for connect to the database
     */
    public function __construct()
    {
        $this->dbAdapter = new Adapter(DB_CONNECTION_STRING, DB_USER, DB_PASSWORD);
        // $this->dbAdapter->dbConnect();
        // $this->dbAdapter->dbDisconnect();
    }

    /**
     * Returns last error
     *
     * @return mixed
     */
    public function getError()
    {
        return $this->error;
    }

    public function userLogin($admin){
        
		//for now we simply accept anyone with webdev2 password
		if ($admin['password'] == '123') {
            if ($admin['username'] == 'admin'){
                $this->error = ERR_SUCCESS;			
                return true;
            }	
		} else {
			$this->error = ERR_AUTHENTICATION;
			return false;
		}
    }


    /**
     * @return array|null
     */
    public function selectAll()
    {
        $this->dbAdapter->dbConnect(); // Connect to database
        $result = $this->dbAdapter->movieSelectAll();
        $this->dbAdapter->dbDisconnect(); // Close the database
        $this->error = $this->dbAdapter->lastError(); // get the last error

        return $result;
    }

    /**
     * @return array|null
     */
    public function selectNewRelease()
    {
        $this->dbAdapter->dbConnect(); // Connect to database
        $result = $this->dbAdapter->movieSelectNewRealse();
        $this->dbAdapter->dbDisconnect(); // Close the database
        $this->error = $this->dbAdapter->lastError(); // get the last error

        return $result;
    }

    /**
     * @return array|null
     */
    public function selectAllUser()
    {
        $this->dbAdapter->dbConnect(); // Connect to database
        $result = $this->dbAdapter->userSelectAll();
        $this->dbAdapter->dbDisconnect(); // Close the database
        $this->error = $this->dbAdapter->lastError(); // get the last error

        return $result;
    }

    /**
     * @param $movies
     *
     * @return array|null
     */
    public function addNewMovie($movies)
    {
        //Run 3 function fetch director id, studio id, genre id by the name input. 
        //If doesnt exit, create new. 
        $this->dbAdapter->dbConnect(); // Connect to database
        $result = $this->dbAdapter->newMovieAdd($movies);
        $this->dbAdapter->dbDisconnect(); // Close the database
        $this->error = $this->dbAdapter->lastError(); // get the last error

        foreach($result as $key){
            $movieID = $key["movie_id"];
        }

        return $movieID;
       
    }

    public function addMovie($moviedata){
        $this->dbAdapter->dbConnect(); // Connect to database
        
        //Get DirectorID from its name or create a new Director
        $directorName = $moviedata['director'];
        $directorID = $this->selectDirector($directorName);	

		if ($directorID == null) {
            $newdirectorID = $this->addNewDirector($directorName);
            if($newdirectorID != null){
                $moviedata['directorID'] = $newdirectorID;
            }	
        }else{
            $moviedata['directorID'] = $directorID;
        } 

        //Get StudioID from its name or create a new Studio
        $studioName = $moviedata['studio'];
        $studioID = $this->selectStudio($studioName);
        if ($studioID == null) {
            $newstudioID = $this->addNewStudio($studioName);
            if($newstudioID != null){
                $moviedata['studioID'] = $newstudioID;
            }			
        } else{
            $moviedata['studioID'] = $studioID;
        } 
        
        //Get GenreID from its name or create a new Genre
        $genreName = $moviedata['genre'];
        $genreID = $this->selectGenre($genreName);
        if ($genreID == null) {
            $newgenreID = $this->addNewGenre($genreName);	
            if($newgenreID != null){
                $moviedata['genreID'] = $newgenreID;
            }		
        } else{
            $moviedata['genreID'] = $genreID;
        } 

        //Add new Movie without actor
        $movieID = $this->addNewMovie($moviedata);
        if ($movieID != null){
            //Add Actor
            $keys = array('star1', 'star2', 'star3','costar1', 'costar2', 'costar3');
            $actors = array();
            foreach($keys as $key){
                $actorsName = $moviedata[$key];
                $actorID = $this->selectActor($actorsName);
                if($actorID == null){
                    $newactorID = $this->addActor($actorsName);
                    if($newactorID != null){
                        $this->addMovieActor($movieID,$newactorID,$key);
                    }	
                }else{
                    $this->addMovieActor($movieID,$actorID,$key);
                }
            }

            //Add Photo
            $photo_file = $this->saveMoviePhoto('photo_loader', _MOVIES_PHOTO_FOLDER_, 'movie'.$movieID, true);
		
			$this->updatePhoto($photo_file,$movieID);
        }


        $this->dbAdapter->dbDisconnect(); // Close the database
        $this->error = $this->dbAdapter->lastError(); // get the last error

        return $movieID;
    }

    public function updatePhoto($photo_file,$movieID){
        $this->dbAdapter->dbConnect(); // Connect to database
        $result = $this->dbAdapter->movieUpdate($photo_file,$movieID); // select randomly movies 
        $this->dbAdapter->dbDisconnect(); // Close the database
        $this->error = $this->dbAdapter->lastError(); // get the last error
    }

    /**
     * @return null
     */
    public function selectActor($actorsName){
        $this->dbAdapter->dbConnect(); // Connect to database
        $result = $this->dbAdapter->actorsSelectAll($actorsName); // select randomly movies 
        $this->dbAdapter->dbDisconnect(); // Close the database
        $this->error = $this->dbAdapter->lastError(); // get the last error

        foreach($result as $key){
            $actorID = $key["actor_id"];
        }
        return $actorID;
    }


    public function addActor($newactorName){
        $this->dbAdapter->dbConnect(); // Connect to database
        $result = $this->dbAdapter->newActorAdd($newactorName);
        $this->dbAdapter->dbDisconnect(); // Close the database
        $this->error = $this->dbAdapter->lastError(); // get the last error

        foreach($result as $key){
            $actorID = $key["actor_id"];
        }
        return $actorID;
    }

    public function addMovieActor($newMovieID,$actorID,$actorRole){
        $this->dbAdapter->dbConnect(); // Connect to database
        $result = $this->dbAdapter->movieActorAdd($newMovieID,$actorID,$actorRole);
        $this->dbAdapter->dbDisconnect(); // Close the database
        $this->error = $this->dbAdapter->lastError(); // get the last error

        return $result;
    }

        /**
     * @return null
     */
    public function selectDirector($directorName)
    {
        $this->dbAdapter->dbConnect(); // Connect to database
        $result = $this->dbAdapter->directorsSelect($directorName); // select randomly movies 
        $this->dbAdapter->dbDisconnect(); // Close the database
        $this->error = $this->dbAdapter->lastError(); // get the last error
        foreach($result as $key){
            $directorID = $key["director_id"];
        }
        return $directorID;
    }

    public function addNewDirector($newdirector){
        $this->dbAdapter->dbConnect(); // Connect to database
        $result = $this->dbAdapter->newDirectorAdd($newdirector);
        $this->dbAdapter->dbDisconnect(); // Close the database
        $this->error = $this->dbAdapter->lastError(); // get the last error

        foreach($result as $key){
            $directorID = $key["director_id"];
        }
        
        return $directorID;
    }

    public function selectStudio($studioName)
    {
        $this->dbAdapter->dbConnect(); // Connect to database
        $result = $this->dbAdapter->studiosSelect($studioName); // select randomly movies 
        $this->dbAdapter->dbDisconnect(); // Close the database
        $this->error = $this->dbAdapter->lastError(); // get the last error
        foreach($result as $key){
            $studioID = $key["studio_id"];
        }
        return $studioID;

   
    }

    public function addNewStudio($newstudio){
        $this->dbAdapter->dbConnect(); // Connect to database
        $result = $this->dbAdapter->newStudioAdd($newstudio);
        $this->dbAdapter->dbDisconnect(); // Close the database
        $this->error = $this->dbAdapter->lastError(); // get the last error

        foreach($result as $key){
            $studioID = $key["studio_id"];
        }
        return $studioID;
    }

    /**
     * @return null
     */
    public function selectGenre($genreName)
    {
        $this->dbAdapter->dbConnect(); // Connect to database
        $result = $this->dbAdapter->genresSelect($genreName); // select randomly movies 
        $this->dbAdapter->dbDisconnect(); // Close the database
        $this->error = $this->dbAdapter->lastError(); // get the last error
        foreach($result as $key){
            $genreID = $key["genre_id"];
        }
        return $genreID;
         
    }

    public function addNewGenre($newgenre){
        $this->dbAdapter->dbConnect(); // Connect to database
        $result = $this->dbAdapter->newGenreAdd($newgenre);
        $this->dbAdapter->dbDisconnect(); // Close the database
        $this->error = $this->dbAdapter->lastError(); // get the last error
        
        foreach($result as $key){
            $genreID = $key["genre_id"];
        }
        return $genreID;
    }

    public function deleteMovie($movieID){
        $this->dbAdapter->dbConnect(); // Connect to database
        $result = $this->dbAdapter->movieDelete($movieID);
        $this->dbAdapter->dbDisconnect(); // Close the database
        $this->error = $this->dbAdapter->lastError(); // get the last error

        return $result;
    }

    public function deleteUser($userID){
        $this->dbAdapter->dbConnect(); // Connect to database
        $result = $this->dbAdapter->userDelete($userID);
        $this->dbAdapter->dbDisconnect(); // Close the database
        $this->error = $this->dbAdapter->lastError(); // get the last error

        return $result;
    }


    public function addMember($memberArray)
    {
        $this->dbAdapter->dbConnect();
        $result = $this->dbAdapter->insertMember($memberArray);
        $this->dbAdapter->dbDisconnect();

        $this->error = $this->dbAdapter->lastError(); // get the last error

        return $result;
    }

    public function editMember($memberArray){
        $this->dbAdapter->dbConnect();
        $result = $this->dbAdapter->memberEdit($memberArray);
        $this->dbAdapter->dbDisconnect();

        $this->error = $this->dbAdapter->lastError(); // get the last error

        return $result;
    }

    public function selectUserInfo($userID){
        $this->dbAdapter->dbConnect();
        $result = $this->dbAdapter->getUser($userID);
        $this->dbAdapter->dbDisconnect();
        $this->error = $this->dbAdapter->lastError(); // get the last error

        return $result; 
       
    }


    public function updateMovieStock($stockdata){
        $this->dbAdapter->dbConnect();
        $result = $this->dbAdapter->movieStockUpdate($stockdata);
        $this->dbAdapter->dbDisconnect();
        $this->error = $this->dbAdapter->lastError(); // get the last error

        return $result; 
    }

    /* This function receive the upload photo and save it to a directory on server 
	@params: 
 	+uploader: name of the file uploader (to be used with $_FILES
    +target_dir: the directory where the image will be saved
    +file_name: the target image file name
    +override: override the existing file if true
    +returns the destination filename is OK or default.jpg if error
	*/
	private function saveMoviePhoto($uploader, $target_dir, $filename, $override) {
		try {   
			// Undefined | Multiple Files | $_FILES Corruption Attack
			// If this request falls under any of them, treat it invalid.
			if (!isset($_FILES[$uploader]['error']) || is_array($_FILES[$uploader]['error'])) {
				throw new RuntimeException('Invalid parameters.');
			}
			// Check $_FILES[$uploader]['error'] value.
			switch ($_FILES[$uploader]['error']) {
				case UPLOAD_ERR_OK:
					break;
				case UPLOAD_ERR_NO_FILE:
					throw new RuntimeException('No file sent.');
				case UPLOAD_ERR_INI_SIZE:
				case UPLOAD_ERR_FORM_SIZE:
					throw new RuntimeException('Exceeded filesize limit.');
				default:
					throw new RuntimeException('Unknown errors.');
			}
			//should also check filesize here ( > 1 MegaBytes). 
			define ("MAX_FILE_SIZE", 10000000);
			if ($_FILES[$uploader]['size'] > MAX_FILE_SIZE) {
				throw new RuntimeException('Exceeded filesize limit.');
			}

			$finfo = new finfo(FILEINFO_MIME_TYPE);
			if (false === $ext = array_search(
				$finfo->file($_FILES[$uploader]['tmp_name']),
				array(
					'jpg' => 'image/jpeg',
					'png' => 'image/png',
					'gif' => 'image/gif',
				),
				true
			)) {
				throw new RuntimeException('Invalid file format.');
			}
			// Check if file already exists
			$target_file = $target_dir . $filename . "." . $ext; //get the fullpath to the file
			if ((!$override) && (file_exists($target_file))) {
				throw new RuntimeException('File already exists');
			}

			if (!move_uploaded_file($_FILES[$uploader]['tmp_name'], $target_file)) {
				throw new RuntimeException('Failed to move uploaded file.');
			}
		
			//return null for success
			return $filename . "." . $ext;
		
		} catch (RuntimeException $e) {

			return 'default.jpg';
		}
	}
    
}
