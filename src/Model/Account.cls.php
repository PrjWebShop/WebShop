<?php

require_once 'src/dbConfig.php';

class Account
{
    private $accountId;
    private $email;
    private $firstName;
    private $lastName;
    private $address;
    private $theme;

    function __construct($accountId, $email, $firstName, $lastName, $address, $theme)
    {
        $this->accountId = $accountId;
        $this->email = $email;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->address = $address;
        $this->theme = $theme;
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

    public function getTheme() { return $this->theme; }
    public function setTheme($theme) { $this->theme = $theme; }

    /**
     * Function that retrieves account info from the database with given identifier
     * @param int|string $identifier use either id or email
     * @return Account returns Account object on success or false if no accounts exist with the given identifier
     */
    public static function getAccountInfo($identifier)
    {
        global $connection;
        
        if (is_numeric($identifier)) {
            $sqlStmt = $connection->prepare("SELECT * FROM account WHERE account_id = :identifier");
        } else {
            $sqlStmt = $connection->prepare("SELECT * FROM account WHERE email = :identifier");
        }
        
        $sqlStmt->bindParam(':identifier', $identifier);

        $sqlStmt->execute();
        
        if ($row = $sqlStmt->fetch()) {
            $accountId = $row["account_id"];
            $email = $row["email"];
            $firstName = $row["first_name"];
            $lastName = $row["last_name"];
            $address = $row["address"];
            $theme = $row["theme"];

            $account = new Account($accountId, $email, $firstName, $lastName, $address, $theme);
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
    public static function createAccount(string $email, string $password, string $first_name, string $last_name, string $address)
    {

        global $connection;

        $hashedPassword = hash("sha256", $password);

        $sqlStmt = $connection->prepare("INSERT INTO account(email, password, first_name, last_name, address)
                    VALUES (:email, :hashedPassword, :first_name, :last_name, :address);");
        
        $sqlStmt->bindParam(':email', $email);
        $sqlStmt->bindParam(':hashedPassword', $hashedPassword);
        $sqlStmt->bindParam(':first_name', $first_name);
        $sqlStmt->bindParam(':last_name', $last_name);
        $sqlStmt->bindParam(':address', $address);

        $queryId = $sqlStmt->execute();

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
    public static function checkLogin(string $email, string $password)
    {
        global $connection;

        $sqlStmt = $connection->prepare("SELECT * FROM account WHERE email = :email");

        $sqlStmt->bindParam(':email', $email);

        $sqlStmt->execute();

        if ($row = $sqlStmt->fetch()) {
            
            $dbPassword = $row["password"];
            $hashedPassword = hash("sha256", $password);

            if ($dbPassword == $hashedPassword)
                return true;
        }
        return false;
    }
}
