<?php
/*-------------------------------------------------------------------------------------------------
dbAdapter: this module acts as the database abstraction layer for the application
@Author: Viet Duong Nguyen
@Modify by:
@Version: 1.0
--------------------------------------------------------------------------------------------------*/

require_once('admin_config.php');

/**
 * Class Adapter
 */
class Adapter
{
    /**
     * @var string
     */
    private $connectionString;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * Holds connection object
     *
     * @var \PDO
     */
    private $conn;

    /**
     * Holds error message
     *
     * @var string
     */
    private $dbError;

    /**
     * @param $connectionString
     * @param $username
     * @param $password
     */
    public function __construct($connectionString, $username, $password)
    {
        $this->connectionString = $connectionString;
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * Connect to the database function
     */
    public function dbConnect()
    {
        try {
            $this->conn = new PDO($this->connectionString, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->dbError = null;
        } catch (PDOException $e) {
            $this->dbError = $e->getMessage();
            $this->conn = null;
        }
    }

    /**
     * Disconnect to the database function
     */
    public function dbDisconnect()
    {
        $this->conn = null;
    }

    /**
     * Get the error function
     *
     * @return string
     */
    public function lastError()
    {
        return $this->dbError;
    }

    /**
     * Helper functions:
     * Build SQL AND conditional clause from the array of condition parameters
     *
     * @param $params
     * @param $condition
     *
     * @return string
     */
    protected function sqlBuildConditionalClause($params, $condition)
    {
        $clause = '';
        $and = false; //so we know when to add AND in the sql statement
        if ($params != null) {
            foreach ($params as $key => $value) {
                $op = '='; //comparison operator
                if ($key == 'price') {
                    $op = '<=';
                }
                if (!empty($value)) {
                    if ($and) {
                        $clause .= " $condition $key $op '$value'";
                    } else {
                        //the first AND condition
                        $clause = "WHERE $key $op '$value'";
                        $and = true;
                    }
                }
            }
        }

        return $clause;
    }

    public function movieActorAdd($newMovieID,$actorID,$actorRole){
        $result = null;
        $this->dbError = null; //reset the error message before any execution
        if ($this->conn != null) {
            try {
                $sql = " INSERT INTO `movie_actor` (`movie_id`, `actor_id`, `role`) VALUES ('$newMovieID', '$actorID', '$actorRole')";
                
                //SQL query
                $stmt = $this->conn->prepare($sql);
                //Execute the query
                $result= $stmt->execute();

            } catch (PDOException $e) {
                //Return the error message to the caller
                $this->dbError = $e->getMessage();
                $result = null;
            }
        } else {
            $this->dbError = "Open connection to the database first";
        }

        return $result;
    }

    public function newActorAdd($newactorName){
        $result = null;
        $this->dbError = null; //reset the error message before any execution
        if ($this->conn != null) {
            //Try and insert the movie, if there is a DB exception return
            //the error message to the caller.
            try {

                $sql = "
                    INSERT INTO `actor` (`actor_id`, `actor_name`) VALUES (NULL, '$newactorName');
                ";

                //Make a prepared query so that we can use data binding and avoid SQL injections.
                $smt = $this->conn->prepare($sql);
                //Execute the query and thus insert the movie
                $smt->execute();
                
                //Get actorID
                //SQL query
                $stmt = $this->conn->prepare(" SELECT actor_id from actor WHERE actor_name = '$newactorName' ");
                //Execute the query
                $stmt->execute();

                $result = $stmt->fetchall(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                //Return the error message to the caller
                $this->dbError = $e->getMessage();
                $result = null;
            }
        } else {
            $this->dbError = MSG_ERR_CONNECTION;
        }

        return $result;
    }


    public function movieUpdate($photo_file,$movieID){
        $this->dbError = null; //reset the error message before any execution
        if ($this->conn != null) {
            try {

                $sql = "UPDATE `movie` 
                SET thumbpath = '$photo_file'
                WHERE movie_id = $movieID
                ";

  
                $smt = $this->conn->prepare($sql);
                //Execute the query
                $result = $smt->execute();


            } catch (PDOException $e) {
                //Return the error message to the caller
                $this->dbError = $e->getMessage();
                $result = null;
            }
        } else {
            $this->dbError = "Open connection to the database first";
        }

        return $result; 
    }

    /**
     * @param $movies
     *
     * @return null|string
     */
    public function newMovieAdd($movies)
    {
        $result = null;
        $this->dbError = null; //reset the error message before any execution
        if ($this->conn != null) {
            //Try and insert the movie, if there is a DB exception return
            //the error message to the caller.
            try {
               
                $sql = "
                    INSERT INTO `movie` 
                    (`movie_id`, `title`, `tagline`, `plot`, `thumbpath`, 
                    `director_id`, `studio_id`, `genre_id`, `classification`, `rental_period`, 
                    `year`, `DVD_rental_price`, `DVD_purchase_price`, `numDVD`, `numDVDout`, 
                    `BluRay_rental_price`, `BluRay_purchase_price`, `numBluRay`, `numBluRayOut`) 

                    VALUES (NULL, '{$movies['title']}', '{$movies['tagline']}','{$movies['plot']}', '', 
                    {$movies['directorID']}, {$movies['studioID']}, {$movies['genreID']}, '{$movies['classification']}', 
                    '{$movies['rental_period']}', {$movies['year']},

                    {$movies['dvd_rental_price']}, {$movies['dvd_purchase_price']}, {$movies['numdvd']},  0, 
                    {$movies['bluray_rental_price']}, {$movies['bluray_purchase_price']}, {$movies['numbluray']}, 0);

                ";
              

                //Make a prepared query so that we can use data binding and avoid SQL injections.
                $smt = $this->conn->prepare($sql);
                //Execute the query and thus insert the movie
                $smt->execute();

                $sqlgetID = "
                    SELECT movie_id FROM movie WHERE title = '{$movies['title']}'
                ";

                //SQL query
                $stmtID = $this->conn->prepare($sqlgetID);
                //Execute the query
                $stmtID->execute();

                $result = $stmtID->fetchall(PDO::FETCH_ASSOC);

            } catch (PDOException $e) {
                //Return the error message to the caller
                $this->dbError = $e->getMessage();
                $result = null;
            }
        } else {
            $this->dbError = MSG_ERR_CONNECTION;
        }

        return $result;
    }

    public function newDirectorAdd($newdirector){
        $result = null;
        $this->dbError = null; //reset the error message before any execution
        if ($this->conn != null) {
            try {
                //SQL query
                $sql= "
                    INSERT INTO `director` (`director_id`, `director_name`) VALUES (NULL, '$newdirector');
                ";
                
                $smt = $this->conn->prepare($sql);
                //Execute the query
                $smt->execute();
               
                //Get StudioID
                $sqlSelectID = " SELECT director_id FROM director WHERE director_name= '$newdirector' ";
                $smtID = $this->conn->prepare($sqlSelectID);
                //Execute the query
                $smtID->execute();
                $result = $smtID->fetchAll(PDO::FETCH_ASSOC);


            } catch (PDOException $e) {
                //Return the error message to the caller
                $this->dbError = $e->getMessage();
                $result = null;
            }
        } else {
            $this->dbError = "Open connection to the database first";
        }

        return $result;
    }


    public function newStudioAdd($newstudio){
        $result = null;
        $this->dbError = null; //reset the error message before any execution
        if ($this->conn != null) {
            try {
                //SQL query
                $sql= "
                    INSERT INTO `studio` (`studio_id`, `studio_name`) VALUES (NULL, '$newstudio');
                ";
              
                $smt = $this->conn->prepare($sql);
                //Execute the query
                $smt->execute();
               
                //Get StudioID
                $sqlSelectID = "SELECT studio_id from studio WHERE studio_name= '$newstudio' ";
                $smt = $this->conn->prepare($sqlSelectID);
                //Execute the query
                $smt->execute();
                $result = $smt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                //Return the error message to the caller
                $this->dbError = $e->getMessage();
                $result = null;
            }
        } else {
            $this->dbError = "Open connection to the database first";
        }

        return $result;
    }

    public function newGenreAdd($newgenre){
        $result = null;
        $this->dbError = null; //reset the error message before any execution
        if ($this->conn != null) {
            try {
                //SQL query
                $sql= "
                    INSERT INTO `genre` (`genre_id`, `genre_name`) VALUES (NULL, '$newgenre');
                ";
            
                $smt = $this->conn->prepare($sql);
                //Execute the query
                $smt->execute();
               
                //Get StudioID
                $sqlSelectID = "SELECT genre_id from genre WHERE genre_name= '$newgenre' ";
                $smt = $this->conn->prepare($sqlSelectID);
                //Execute the query
                $smt->execute();
                $result = $smt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                //Return the error message to the caller
                $this->dbError = $e->getMessage();
                $result = null;
            }
        } else {
            $this->dbError = "Open connection to the database first";
        }

        return $result;
    }

    

    /**
     * @return array|null
     */
    public function movieSelectAll()
    {
        $result = null;
        $this->dbError = null; //reset the error message before any execution
        if ($this->conn != null) {
            try {
                //SQL query
                $stmt = $this->conn->prepare(" SELECT * FROM movie_detail_view ");
                //Execute the query
                $stmt->execute();

                $result = $stmt->fetchall(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                //Return the error message to the caller
                $this->dbError = $e->getMessage();
                $result = null;
            }
        } else {
            $this->dbError = "Open connection to the database first";
        }

        return $result;
    }

    /**
     * @return array|null
     */
    public function movieSelectNewRealse()
    {
        $result = null;
        $max = MAX_NEW_RELEASE_MOVIE;
        $this->dbError = null; //reset the error message before any execution
        if ($this->conn != null) {
            try {
                //SQL query
                $stmt = $this->conn->prepare(" SELECT * FROM movie_detail_view ORDER BY movie_id DESC LIMIT $max  ");
                //Execute the query
                $stmt->execute();

                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                //Return the error message to the caller
                $this->dbError = $e->getMessage();
                $result = null;
            }
        } else {
            $this->dbError = 'Open connection to the database first';
        }

        return $result;
    }

    /**
     * @return array|null
     */
    public function userSelectAll()
    {
        $result = null;
        $this->dbError = null; //reset the error message before any execution
        if ($this->conn != null) {
            try {
                //SQL query
                $stmt = $this->conn->prepare(' SELECT * FROM member');
                //Execute the query
                $stmt->execute();

                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                //Return the error message to the caller
                $this->dbError = $e->getMessage();
                $result = null;
            }
        } else {
            $this->dbError = 'Open connection to the database first';
        }

        return $result;
    }



    /**
     * @return array|null
     */
    public function studiosSelect($studioName)
    {
        $result = null;
        $this->dbError = null; //reset the error message before any execution
        if ($this->conn != null) {
            try {
                $sql = "
                SELECT studio_id FROM studio WHERE studio_name =  '$studioName'
            ";
            //SQL query
            $smt = $this->conn->prepare($sql);
                //Execute the query
                $smt->execute();
                $result = $smt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                //Return the error message to the caller
                $this->dbError = $e->getMessage();
                $result = null;
            }
        } else {
            $this->dbError = "Open connection to the database first";
        }

        return $result;
    }

    /**
     * @return array|null
     */
    public function genresSelect($genreName)
    {
        $result = null;
        $this->dbError = null; //reset the error message before any execution
        if ($this->conn != null) {
            try {
                $sql = "
                SELECT genre_id FROM genre WHERE genre_name =  '$genreName'
            ";
            //SQL query
            $smt = $this->conn->prepare($sql);
                //Execute the query
                $smt->execute();
                $result = $smt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                //Return the error message to the caller
                $this->dbError = $e->getMessage();
                $result = null;
            }
        } else {
            $this->dbError = "Open connection to the database first";
        }

        return $result;
    }


    /**
     * @return array|null
     */
    public function directorsSelect($directorName)
    {
        $result = null;
        $this->dbError = null; //reset the error message before any execution
        if ($this->conn != null) {
            try {
                $sql = "
                    SELECT director_id FROM director WHERE director_name =  '$directorName'
                ";
                //SQL query
                $smt = $this->conn->prepare($sql);
                //Execute the query
                $smt->execute();
                $result = $smt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                //Return the error message to the caller
                $this->dbError = $e->getMessage();
                $result = null;
            }
        } else {
            $this->dbError = "Open connection to the database first";
        }

        return $result;
    }

    

    public function actorsSelectAll($actorsName)
    {
        $result = null;
        $this->dbError = null; //reset the error message before any execution
        if ($this->conn != null) {
            try {
                $sql = "
                    SELECT actor_id FROM actor WHERE actor_name =  '$actorsName'
                ";
                //SQL query
                $smt = $this->conn->prepare($sql);
                //Execute the query
                $smt->execute();
                $result = $smt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                //Return the error message to the caller
                $this->dbError = $e->getMessage();
                $result = null;
            }
        } else {
            $this->dbError = "Open connection to the database first";
        }

        return $result;

    }


    public function movieDelete($movieID){
        $result = null;
        $this->dbError = null; //reset the error message before any execution
        if ($this->conn != null) {
            try {
                $sql = "
                    DELETE FROM `movie` WHERE `movie`.`movie_id` = $movieID
                ";
                //SQL query
                $smt = $this->conn->prepare($sql);
                //Execute the query
                $smt->execute();
                
            } catch (PDOException $e) {
                //Return the error message to the caller
                $this->dbError = $e->getMessage();
                $result = null;
            }
        } else {
            $this->dbError = "Open connection to the database first";
        }

        return $result;
    }

    public function userDelete($userID){
        $result = null;
        $this->dbError = null; //reset the error message before any execution
        if ($this->conn != null) {
            try {
                $sql = "
                    DELETE FROM `member` WHERE `member`.`member_id` = $userID
                ";
                //SQL query
                $smt = $this->conn->prepare($sql);
                //Execute the query
                $smt->execute();
                
            } catch (PDOException $e) {
                //Return the error message to the caller
                $this->dbError = $e->getMessage();
                $result = null;
            }
        } else {
            $this->dbError = "Open connection to the database first";
        }

        return $result;
    }

    public function insertMember($memberArray)
    {
        $result = null;
        $surname = $memberArray['surname'];
        $othername = $memberArray['othername'];
        $contactmethod = $memberArray['contactmethod'];
        $phone = $memberArray['phone'];
        $landline = $memberArray['landline'];
        $email = $memberArray['email'];
        $street = $memberArray['street'];
        $magazine = $memberArray['magazine'];
        $suburb = $memberArray['suburb'];
        $postcode = $memberArray['postcode'];
        $username = $memberArray['username'];
        $occupation = $memberArray['occupation'];
        $verifiedpass = $memberArray['verifiedpass'];
        $date = date("Y M D");

        $this->dbError = null; //reset the error message before any execution
        if ($this->conn != null) {
            try {

                $sql = "INSERT INTO `member` 
                (`member_id`, `surname`, `other_name`,
                `contact_method`, `email`, `mobile`,
                `landline`, `magazine`, `street`, `suburb`,
                `postcode`, `username`, `password`, `occupation`, `join_date`) 
                VALUES 
                (NULL, '$surname', '$othername', '$contactmethod', '$email', 
                '$phone', '$landline', $magazine, '$street', '$suburb', 
                $postcode, '$username', '$verifiedpass', '$occupation', '2018-09-04');";

                $smt = $this->conn->prepare($sql);
                //Execute the query
                $smt->execute();

                $getuser = $this->conn->prepare("SELECT * FROM member WHERE username = '$username'");
                $getuser->execute();
                $result = $getuser->fetchall(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                //Return the error message to the caller
                $this->dbError = $e->getMessage();
                $result = null;
            }
        } else {
            $this->dbError = "Open connection to the database first";
        }

        return $result;
    }

    public function memberEdit($memberArray)
    {
        $result = null;
        $edituserid = $memberArray['edituserid'];
        $surname = $memberArray['surname'];
        $othername = $memberArray['othername'];
        $contactmethod = $memberArray['contactmethod'];
        $phone = $memberArray['phone'];
        $landline = $memberArray['landline'];
        $email = $memberArray['email'];
        $street = $memberArray['street'];
        $magazine = $memberArray['magazine'];
        $suburb = $memberArray['suburb'];
        $postcode = $memberArray['postcode'];
        $username = $memberArray['username'];
        $occupation = $memberArray['occupation'];
        $verifiedpass = $memberArray['verifiedpass'];
        $date = date("Y M D");

        $this->dbError = null; //reset the error message before any execution
        if ($this->conn != null) {
            try {

                $sql = "
                UPDATE member 
                SET surname = '$surname' , other_name  = '$othername',
                contact_method = '$contactmethod', email  = '$email', mobile  = '$phone',
                landline  = '$landline', magazine  = $magazine, street  = '$street', suburb  = '$suburb',
                postcode  = $postcode, username  = '$username', password = '$verifiedpass', occupation  = '$occupation', join_date  = '2018-09-04'
                
                WHERE member_id = $edituserid
                ";

               

                $smt = $this->conn->prepare($sql);
                //Execute the query
                $smt->execute();
                $result = true;
            } catch (PDOException $e) {
                //Return the error message to the caller
                $this->dbError = $e->getMessage();
                $result = null;
            }
        } else {
            $this->dbError = "Open connection to the database first";
        }

        return $result;
    }

    public function getUser($userID){
        $result = null;
        $this->dbError = null; //reset the error message before any execution
        if ($this->conn != null) {
            try {
                $sql = "
                    SELECT * FROM MEMBER WHERE member_id = $userID
                ";
                //SQL query
                $smt = $this->conn->prepare($sql);
                //Execute the query
                $smt->execute();
                $result = $smt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                //Return the error message to the caller
                $this->dbError = $e->getMessage();
                $result = null;
            }
        } else {
            $this->dbError = "Open connection to the database first";
        }

        return $result;
    }

    public function movieStockUpdate($stockdata){
        $result = null;
        $this->dbError = null; //reset the error message before any execution
        if ($this->conn != null) {
            try {
                $sql = "
                UPDATE movie 
                SET 
                DVD_rental_price = {$stockdata['dvd_rental_price']}, 
                DVD_purchase_price = {$stockdata['dvd_purchase_price']}, 
                numDVDOut = {$stockdata['numdvdout']}, 
                BluRay_rental_price = {$stockdata['bluray_rental_price']}, 
                BluRay_purchase_price = {$stockdata['bluray_purchase_price']}, 
                numBluRayOut ={$stockdata['numblurayout']}  

                WHERE movie_id = {$stockdata['movieid']};
                ";
                //SQL query
                $smt = $this->conn->prepare($sql);
                //Execute the query
                $smt->execute();
   
            } catch (PDOException $e) {
                //Return the error message to the caller
                $this->dbError = $e->getMessage();
                $result = null;
            }
        } else {
            $this->dbError = "Open connection to the database first";
        }

        return $result;
    }
}
