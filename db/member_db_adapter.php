<?php

/**
 * Class MemberDb
 */
Class MemberDb
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
     * @return mixed
     */
    public function lastError()
    {
        return $this->dbError;
    }

    /**
     * @param $username
     * @param $password
     *
     * @return bool
     */
    public function checkUser($username, $password)
    {

        if ($this->conn != null) {
            try {
                $smt = $this->conn->prepare("SELECT * FROM member WHERE username = '$username' ");

                $smt->execute();
                $userGot = $smt->fetchall(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                //Return the error message to the caller
                $this->dbError = $e->getMessage();
                $userGot = null;
            }
        } else {
            $this->dbError = 'Open connection to the database first';
        }

        foreach ($userGot as $member) {
            $memberID = $member['member_id'];
            $usernameGot = $member['username'];
            $passwordGot = $member['password'];
        }

        if ($username == $usernameGot) {
            if ($password == $passwordGot) {
                $this->dbError = "OK";

                return true;
            }
        } else {
            $this->error = "NOT MATCHED";

            return false;
        }
    }

    /**
     * @param $movies
     *
     * @return null
     */
    public function movieBook($movies)
    {
        $result = null;
        if ($this->conn != null) {
            try {
                $in = '('.implode(',', $movies).')';
                $sql = 'SELECT * FROM movie_detail_view WHERE movie_id IN '.$in;
                $stmt = $this->conn->prepare($sql);
                //Execute the query
                $stmt->execute();

                $result = $stmt->fetchall(PDO::FETCH_ASSOC);

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
     * @param $memberArray
     *
     * @return null
     */
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
}
