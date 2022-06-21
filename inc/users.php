<?php
class User
{
	private $id;
	private $username;
	private $firstName;
	private $lastName;
	private $password;
	private $email;
	private $isActive;
	private $dateCreated;
	private $dateUpdated;
    private $isAuth;
	
	/* Public class methods (functions) */
	
	/* Constructor */
	public function __construct()
	{
	
			$this->isAuth = FALSE;
			$this->id = null;
			$this->username ;
			$this->firstName ;
			$this->lastName;
			$this->email;
			$this->dateCreated;
			$this->dateUpdated;
            $this->password = NULL;
			$this->isActive ;
        
        
	}
	/* Destructor */
	public function __destruct()
	{
		
	}
	public function getUsername(){
		return $this->username;
	}
	public function getId(){
		return $this->id;
	}
	public function getfullname(){
		return "$this->firstName  $this->lastName";
	}
	
    public static function addUser(string $username, $password, string $firstName, string $lastName, string $email): int
{
	/* Global $pdo object */
	global $pdo;
	global $dbname;
	/* Trim the strings to remove extra spaces */
    $id = myguidv4();
	$username = trim($username);
	$firstName = trim($firstName);
	$lastName = trim($lastName);
	$email = trim($email);
	

	if (!is_null(self::getUserFromUsername($username)))
	{
		throw new Exception('Username not available');
	}
	if (!is_null(self::getUserFromEmail($email)))
	{
		throw new Exception('Email Address already taken');
	}
	
	
	/* Insert new User */
	$query = "INSERT INTO $dbname.user (id, username, password, firstName, lastName, email, isActive) VALUES (:id, :username, :password, :firstName, :lastName, :email, :isActive)";
	

	$passwordHash = password_hash($password, PASSWORD_DEFAULT);
	

	$values = array(
        'id' => $id, 
        'username' => $username, 
        'password' => $passwordHash, 
        'firstName' => $firstName, 
        'lastName' => $lastName, 
        'email' => $email,
        'isActive'=> TRUE
    );
	
	
	try
	{
		$res = $pdo->prepare($query);
		$res->execute($values);
	}
	catch (PDOException $e)
	{
	 
	   throw new Exception('Database query error' . $e);
	}
	
	
	return $pdo->lastInsertId();
}

    public function updateUser(string $id, string $firstName, string $lastName): int
{
	
	global $pdo;
	global $dbname;
	
	$firstName = trim($firstName);
	$lastName = trim($lastName);
	$id = trim($id);
	
	
	$query = 'UPDATE $dbname.user SET firstname = :firstname, lastname = :lastname,  WHERE id = :id';
	

	
	$values = array(
        'firstName' => $firstName, 
        'lastName' => $lastName, 
        'id' => $id
    );
	
	
	try
	{
		$res = $pdo->prepare($query);
		$res->execute($values);
	}
	catch (PDOException $e)
	{
	
	   throw new Exception('Database query error');
	}
	
	
	return $pdo->lastInsertId();
}



public static function isUsernameValid(string $name): bool
{

	$isValid = TRUE;
	
	
	$len = mb_strlen($name);
	
	if (($len < 8) || ($len > 16))
	{
		$isValid = FALSE;
	}
	
	return $isValid;
}

public static function isEmailValid(string $email): bool
{

	$isValid = TRUE;
	
	
	 if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $isValid = FALSE;
    }
	
	return $isValid;
}


public static function isPasswordValid(string $passwd): bool
{

	$isValid = TRUE;
	
	$len = mb_strlen($passwd);
	
	if (($len < 8) || ($len > 16))
	{
		$isValid = FALSE;
	}

	
	return $isValid;
}


public static function getUserFromUsername(string $username)
{

	global $pdo;
	global $dbname;
	

	$user = NULL;
	

	$query = "SELECT * FROM $dbname.user WHERE username = :username";
	$values = array(':username' => $username);
	
	try
	{
		$res = $pdo->prepare($query);
		$res->execute($values);
	}
	catch (PDOException $e)
	{

	   throw new Exception('Database query error '. $e);
	}
	
	$row = $res->fetch(PDO::FETCH_ASSOC);
	

	if (is_array($row))
	{
		$user = $row;
	}
	
	return $user;
}


public static function getUserFromEmail(string $email)
{

	global $pdo;
	global $dbname;
	
	if (!self::isEmailValid($email))
	{
		throw new Exception('Invalid username');
	}
	

	$user = NULL;
	

	$query = "SELECT * FROM $dbname.user WHERE email = :email";
	$values = array(':email' => $email);
	
	try
	{
		$res = $pdo->prepare($query);
		$res->execute($values);
	}
	catch (PDOException $e)
	{

	   throw new Exception('Database query error '. $e);
	}
	
	$row = $res->fetch(PDO::FETCH_ASSOC);
	

	if (is_array($row))
	{
		$user = $row;
	}
	
	return $user;
}



/* Delete an user by their username) */
public static function deleteUser(int $username)
{
	/* Global $pdo object */
	global $pdo;
	global $dbname;
		
        $user = self::getUserFromUsername($username);
	
        if (is_null($user))
        {
            throw new Exception('User does not exist');
        }
	
	/* Query to delete */
	$query = "DELETE FROM $dbname.user WHERE username = :username";
	
	/* Values array for PDO */
	$values = array(':username' => $username);
	
	/* Execute the query */
	try
	{
		$res = $pdo->prepare($query);
		$res->execute($values);
	}
	catch (PDOException $e)
	{
	   /* If there is a PDO exception, throw a standard exception */
	   throw new Exception('Database query error ' .$e);
	}
}



/* Login by providing username and password */
public function login(string $username, string $password): bool
{
	/* Global $pdo object */
	global $pdo;	
	global $dbname;
	/* Trim the strings to remove extra spaces */
	$username = trim($username);
	$password = trim($password);
	
	
    //  Note: the user must be active  1*/
	$query = "SELECT * FROM $dbname.user WHERE (username = :username) AND (isActive = 1)";
	
	/* Values array for PDO */
	$values = array(':username' => $username);
	
	/* Execute the query */
	try
	{
		$res = $pdo->prepare($query);
		$res->execute($values);
	}
	catch (PDOException $e)
	{
	   /* If there is a PDO exception, throw a standard exception */
	   throw new Exception('Database query error');
	}
	
	$row = $res->fetch(PDO::FETCH_ASSOC);
	
	/* If there is a result, 
    comparing password using password_verify() */
	if (is_array($row))
	{
		if (password_verify($password, $row['password']))
		{
			/* Set the class properties 
             */
			$this->id = $row['id'];
			$this->username = $row['username'];
			$this->firstName = $row['firstName'];
			$this->lastName =$row['lastName'];
			$this->email =$row['email'];
			$this->dateCreated =$row['dateCreated'];
			$this->dateUpdated =$row['dateUpdate'];
            $this->password = '';
			$this->isActive = $row['isActive'];
            $this->isAuth = TRUE;
			
			/* Register the current Sessions on the database */
			$this->saveLoginSession();
			
			/* Finally, Return TRUE */
			return TRUE;
		}
	}
	
	return FALSE;
}

/* Saves the current Session ID with the user ID */
private function saveLoginSession()
{
	/* Global $pdo object */
	global $pdo;
	global $dbname;
	/* Has Session started */
	if (session_status() == PHP_SESSION_ACTIVE)
	{
		
		$query = "REPLACE INTO $dbname.loginSessions (sessionId, userId, LoginTime) VALUES (:sessionId, :userId, NOW())";
		$values = array(':sessionId' => session_id(), ':userId' => $this->id);
		
		/* Execute the query */
		try
		{
			$res = $pdo->prepare($query);
			$res->execute($values);
		}
		catch (PDOException $e)
		{
		   /* If there is a PDO exception, throw a standard exception */
		   throw new Exception('Database query error' . $e);
		}
	}
}



/* Login using Sessions */
public function sessionLogin(): bool
{
	/* Global $pdo object */
	global $pdo;
	global $dbname;	
	
	/* Check that the Session has been started */
	if (session_status() == PHP_SESSION_ACTIVE)
	{
		$query = 
		
		"SELECT * FROM $dbname.loginSessions, $dbname.user WHERE (loginSessions.sessionId = :sessionId) " . 
		"AND (loginSessions.loginTime >= (NOW() - INTERVAL 7 DAY)) AND (loginSessions.userId = user.id) " . 
		"AND (user.isActive = 1)";
		
		/* Values array for PDO */
		$values = array(':sessionId' => session_id());
		
		/* Execute the query */
		try
		{
			$res = $pdo->prepare($query);
			$res->execute($values);
		}
		catch (PDOException $e)
		{
		   /* If there is a PDO exception, throw a standard exception */
		   throw new Exception('Database query error' . $e);
		}
		
		$row = $res->fetch(PDO::FETCH_ASSOC);
		
		if (is_array($row))
		{
			/* Authentication succeeded. Set the class properties (id and name) and return TRUE*/
			$this->id = $row['id'];
			$this->username = $row['username'];
			$this->isAuth = TRUE;
			
			return TRUE;
		}
	}
	
	return FALSE;
}


/* Logout the current user */
public function logout()
{
	
	global $pdo;
	global $dbname;	
	
	/* If there is no logged in user, do nothing */
	if (is_null($this->id))
	{
		return;
	}
	
	/* Reset the account-related properties */
	        $this->id = NULL;
			$this->username = NULL;
			$this->firstName = NULL;
			$this->lastName =NULL;
			$this->email =NULL;
			$this->dateCreated =NULL;
			$this->dateUpdated =NULL;
            $this->password = NULL;
			$this->isActive = NULL;
            $this->isAuth = FALSE;
	
	/* If there is an open Session, remove it from the LoginSessions table */
	if (session_status() == PHP_SESSION_ACTIVE)
	{
		/* Delete query */
		$query = "DELETE FROM $dbname.loginSessions WHERE (sessionId = :sessionId)";
		
		/* Values array for PDO */
		$values = array(':sessionId' => session_id());
		
		/* Execute the query */
		try
		{
			$res = $pdo->prepare($query);
			$res->execute($values);
		}
		catch (PDOException $e)
		{
		   /* If there is a PDO exception, throw a standard exception */
		   throw new Exception('Database query error' . $e);
		}
	}
}

public function isUserAuthenticated(): bool
{
	return $this->isAuth;
}


/* A function to log the user out of other sessions */
public function deleteOtherSessions()
{
	/* Global $pdo object */
	global $pdo;
	global $dbname;	
	
	/* If there is no logged in user, do nothing */
	if (is_null($this->id))
	{
		return;
	}
	
	/* Check that a Session has been started */
	if (session_status() == PHP_SESSION_ACTIVE)
	{
		/* Delete all account Sessions with session_id different from the current one */
		$query = "DELETE FROM $dbname.loginSessions WHERE (sessionId != :sessionId) AND (userId = :userId)";
		
		/* Values array for PDO */
		$values = array(':sessionId' => session_id(), ':userId' => $this->id);
		
		/* Execute the query */
		try
		{
			$res = $pdo->prepare($query);
			$res->execute($values);
		}
		catch (PDOException $e)
		{
		   /* If there is a PDO exception, throw a standard exception */
		   throw new Exception('Database query error');
		}
	}
}
}