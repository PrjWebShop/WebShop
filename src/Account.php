<?php

require_once 'dbConfig.php';


/**
 * This function returns true if the email and password entered match the ones in the database.
 * 
 * @param string $email
 * @param string $password
 * 
 * @return bool returns true or false
 */
function login($email, $password)
{
    global $connection;
        
    $sqlStmt = "SELECT * FROM account WHERE email = '$email'";
    $result = $connection->query($sqlStmt);
    
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $dbPassword = $row["password"];
        $hashedPassword = hash("sha256", $password);
        
        if ($dbPassword == $hashedPassword)
        {
            $connection->close();
            return true;
        }
    }
    $connection->close();
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
function create_account($email, $password, $first_name, $last_name, $address)
{
    
    global $connection;
    
    $hashedPassword = hash("sha256", $password);
    
    // SQL Insert Statement
    $sqlStmt = "INSERT INTO account(email, password, first_name, last_name, address) 
    VALUES ('$email', '$hashedPassword', '$first_name', '$last_name', '$address');";
    
    // Run the Query
    $queryId = mysqli_query($connection, $sqlStmt);
    
    if ($queryId) //Checks if the query worked
        return true;
    else 
        return false;
}















