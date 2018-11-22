<?php
/*-------------------------------------------------------------------------------------------------
dbAdapter: this module acts as the database abstraction layer for the application
@Author: Viet Duong Nguyen
@Modify by:
@Version: 1.0
--------------------------------------------------------------------------------------------------*/

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
     * Select ramdom movies from the movie table
     * Variable $max - the maximum number of cars will be selected
     *
     * @return array|null an array of matched movies
     */
    public function movieSelectRandom()
    {
        $result = null;
        $max = MAX_RANDOM_MOVIE;
        $this->dbError = null;
        if ($this->conn != null) {
            try {
                //SQL query
                $stmt = $this->conn->prepare(" SELECT * FROM movie_detail_view ORDER BY RAND()  LIMIT $max ");
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
     * Select all movies from the movie table
     *
     * @return array|null an array of matched movies
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
     * Select new release movies from the movie table
     * Variable $max - the maximum number of cars will be selected
     *
     * @return array|null an array of matched movies
     */
    public function movieSelectNewRelease()
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
    public function studiosSelectAll()
    {
        $result = null;
        $this->dbError = null; //reset the error message before any execution
        if ($this->conn != null) {
            try {
                //SQL query
                $smt = $this->conn->prepare('SELECT * FROM studio');
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
    public function genresSelectAll()
    {
        $result = null;
        $this->dbError = null; //reset the error message before any execution
        if ($this->conn != null) {
            try {
                //SQL query
                $smt = $this->conn->prepare('SELECT * FROM genre');
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
    public function actorsSelectAll()
    {
        $result = null;
        $this->dbError = null; //reset the error message before any execution
        if ($this->conn != null) {
            try {
                //SQL query
                $smt = $this->conn->prepare('SELECT * FROM actor');
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
    public function directorsSelectAll()
    {
        $result = null;
        $this->dbError = null; //reset the error message before any execution
        if ($this->conn != null) {
            try {
                //SQL query
                $smt = $this->conn->prepare('SELECT * FROM director');
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
     * Handle select by this format:
     * WHERE movie_id IN ( SELECT movie_id FROM movie_actor_view WHERE actor_name = 'Christian Bale' )
     * AND director IN ( SELECT director_name FROM director WHERE director_name = 'Christopher Nolan' )
     * AND genre IN ( SELECT genre_name FROM genre WHERE genre_name = 'Thriller' )
     * AND studio IN ( SELECT studio_name FROM studio WHERE studio_name = 'Warner Bros. Pictures' )
     *
     * @param $params
     *
     * @return string
     */
    protected function sqlBuildConditionalClause($params)
    {
        $clause = $columnSelect = $column = $table = '';
        $op = ' AND ';
        $and = false;

        if ($params != null) {
            foreach ($params as $key => $value) {
                if ($key == 'actor_name') {
                    $columnSelect = 'movie_id';
                    $column = 'movie_id';
                    $table = 'movie_actor_view';
                }
                if ($key == 'director_name') {
                    $columnSelect = 'director';
                    $column = 'director_name';
                    $table = 'director';
                }
                if ($key == 'genre_name') {
                    $columnSelect = 'genre';
                    $column = 'genre_name';
                    $table = 'genre';
                }
                if ($key == 'studio_name') {
                    $columnSelect = 'studio';
                    $column = 'studio_name';
                    $table = 'studio';
                }
                if (!empty($value)) {
                    if ($and) {
                        $clause .= "$op $columnSelect IN (SELECT $column FROM $table WHERE $key = '$value' )";
                    } else {
                        $clause = "WHERE $columnSelect IN (SELECT $column FROM $table WHERE $key = '$value' )";
                        $and = true;
                    }
                }
            }
        }

        return $clause;
    }

    /**
     * @param $conditions
     *
     * @return array|null
     */
    public function movieFilter($conditions)
    {
        $result = null;
        $this->dbError = null; //reset the error message before any execution
        if ($this->conn != null) {
            try {
                $where = $this->sqlBuildConditionalClause($conditions);

                $sql = <<<SQL
SELECT * 
FROM movie_detail_view 
$where;
SQL;

                //SQL query
                $stmt = $this->conn->prepare($sql);
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
}
