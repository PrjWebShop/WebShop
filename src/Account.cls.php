<?php

require_once 'dbConfig.php';

class Account
{
    private $accountId;
    private $email;
    private $firstName;
    private $lastName;
    private $address;

    function __construct($accountId, $email, $firstName, $lastName, $address)
    {
        $this->accountId = $accountId;
        $this->email = $email;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->address = $address;
    }

    public function getAccountId() { return $this->accountId; }
    
    public function getEmail() { return $this->email; }
    public function setEmail($email) { $this->email = $email; }

    public function getFirstName() { return $this->firstName; }
    public function setFirstName($firstName) { $this->firstName = $firstName; }
    
    public function getLastName() { return $this->lastName; }
    public function setLastName($lastName) { $this->lastName = $lastName; }

    public function getAddress() { return $this->address; }
    public function setAddress($address) { $this->address = $address; }

    /**
     * Function that retrieves account info from the database with given identifier
     * @param mixed $identifier use either id or email
     * @return mixed returns Account object on success or false if no accounts exist with the given identifier
     */
    public static function getAccountInfo($identifier)
    {
        global $connection;
        
        if (is_numeric($identifier)) {
            $sqlStmt = "SELECT * FROM account WHERE account_id = $identifier";
        } else {
            $sqlStmt = "SELECT * FROM account WHERE email = '$identifier'";
        }
        
        $result = $connection->query($sqlStmt);

        if ($row = $result->fetch_assoc()) {
            $accountId = $row["account_id"];
            $email = $row["email"];
            $firstName = $row["first_name"];
            $lastName = $row["last_name"];
            $address = $row["address"];

            $account = new Account($accountId, $email, $firstName, $lastName, $address);
            return $account;
        }
        return false;
    }

    /**
     * This function creates the account in the database and returns true on success.
     *
     * @param string  $email
     * @param string  $password
     * @param string  $first_name
     * @param string  $last_name
     * @param string  $address
     *
     * @return bool returns true or false
     */
    public static function createAccount($email, $password, $first_name, $last_name, $address)
    {

        global $connection;

        $hashedPassword = hash("sha256", $password);

        $sqlStmt = "INSERT INTO account(email, password, first_name, last_name, address)
                    VALUES ('$email', '$hashedPassword', '$first_name', '$last_name', '$address');";

        $queryId = mysqli_query($connection, $sqlStmt);

        if ($queryId) //Checks if the query worked
            return true;
        else
            return false;
    }

    /**
     * This function returns true if the email and password entered match the ones in the database.
     *
     * @param string $email
     * @param string $password
     *
     * @return bool returns true or false
     */
    public static function checkLogin($email, $password)
    {
        global $connection;

        $sqlStmt = "SELECT * FROM account WHERE email = '$email'";
        $result = $connection->query($sqlStmt);

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $dbPassword = $row["password"];
            $hashedPassword = hash("sha256", $password);

            if ($dbPassword == $hashedPassword)
                return true;
        }
        return false;
    }
}
