<?php
class Drone
{
	/* Class properties (variables) */
	private $serialNumber;
	private $model;
	private $state;
	private $weightLimit;
	private $currentLoad;
	private $batteryLevel;
	private $dateCreated;
	private $dateUpdated;
	private $userId;
	/* Public class methods (functions) */
	
	/* Constructor */
	public function __construct()
	{
	$this->serialNumber= Null;
	$this->model= Null;
	$this->state= Null;
	$this->weightLimit= Null;
	$this->currentLoad= Null;
	$this->batteryLevel= Null;
	$this->dateCreated= Null;
	$this->dateUpdated= Null;
	$this->userId= Null;
		        
	}
	
	/* Destructor */
	public function __destruct()
	{
		
	}
    public static function addDrone(string $id, string $model, string $state, string $weightLimit, string $batteryLevel): int
{
	/* Global $pdo object */
	global $pdo;
	
	global $dbname;
	/* Trim the strings to remove extra spaces */
	$model = trim($model);
	$state = trim($state);
	$weightLimit = trim($weightLimit);
    $serialNumber =trim(bin2hex(random_bytes(10)));
    $currentLoad = 0;
    $userId = trim($id);
    
	
	/* Check if the model is valid. If not, throw an exception */
	if (!self::isModelValid($model))
	{
		throw new Exception('Drone can not have such model');
	}
	
	/* Check if the battery Level is valid. If not, throw an exception */
	if (!self::isBatteryLevelValid($batteryLevel))
	{
		throw new Exception('BatteryLevel is invalid');
	}
	
	/* Check if the state is valid. If not, throw an exception */
	if (!self::isStateValid($state))
	{
		throw new Exception('Drone can not be in such state');
	}
	

	/* Finally, add the new Drone */
		$query = "INSERT INTO $dbname.drones (serialNumber, model, state, currentLoad, batteryLevel, weightLimit, userId) VALUES (:serialNumber, :model, :state, :currentLoad, :batteryLevel, :weightLimit, :userId)";
	
	
	/* Values array for PDO */
	$values = array(
    'serialNumber' => $serialNumber, 
    'model'=>$model, 
    'state'=>$state, 
    'currentLoad'=>$currentLoad,
    'batteryLevel' => $batteryLevel,
    'weightLimit' => $weightLimit, 
    'userId' => $userId
);
	
	/* Execute the query */
	try
	{
		$res = $pdo->prepare($query);
		$res->execute($values);
	}
	catch (PDOException $e)
	{
	   /* If there is a PDO exception, throw a standard exception */
	   throw new Exception('Database query error'. $e);
	}
	
	/* Return the new ID */
	return $pdo->lastInsertId();
}


/* A sanitization check for the drone model */
public static function isModelValid(string $model): bool
{
	/* Initialize the return variable */
	$isValid= FALSE;

    
    	/* Convert to lower case */
	$model = strtolower($model);

	/* check if the value is in the possible values for drone model */
	$DroneModel = array(
        'LIGHTWEIGHT' => 'lightweight',
        'MIDDLEWEIGHT' => 'middleweight',
        'CRUISERWEIGHT' => 'cruiserweight',
        'HEAVYWEIGHT' => 'heavyweight'
    );
	
	if (in_array($model, $DroneModel))
	{
		$isValid= TRUE;
	}
	
	
	
	return $isValid;
}
/* A sanitization check for the drone model */
public static function isBatteryLevelValid(string $batteryLevel): bool
{
	/* Initialize the return variable */
	$isValid= FALSE;
	if (is_numeric($batteryLevel) && ($batteryLevel > 0) && ($batteryLevel <= 100))
	{
		$isValid= TRUE;
	}
	return $isValid;
}

/* A sanitization check for the drone model */
public static function isStateValid(string $state): bool
{
	/* Initialize the return variable */
	$isValid= FALSE;

    	/* Convert to lower case */
	$state = strtolower($state);

	/* check if the value is in the possible values for drone model */
	$DroneState = array(
        'IDLE' => 'idle',
        'LOADING' => 'loading',
        'LOADED' => 'loaded',
        'DELIVERING' => 'delivering',
        'DELIVERED' => 'delivered',
        'RETURNING' => 'returning'
    );	
	if (in_array($state, $DroneState))
	{
		$isValid= TRUE;
	}
	return $isValid;
}
/* Returns the Drone having the given serial Number or an empty array if it's not found */
public static function getDroneDetailsFromSerial(string $serialNumber): array
{
	/* Global $pdo object */
	global $pdo;
	global $dbname;
	
    $drone = array();

	/* Search the serialNumber on the database */
	$query = "SELECT * FROM $dbname.drones WHERE (serialNumber = :serialNumber)";
	$values = array(':serialNumber' => $serialNumber);
	
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
	
	if (is_array($row))
	{
		$drone =$row;
	}
	
	return $drone;
}


public static function getAllDronesByModel(string $model): array
{
	/* Global $pdo object */
	global $pdo;
	$model = trim($model);
    $drone = array();

	global $dbname;
	
	if (!self::isModelValid($model))
	{
		throw new Exception('Invalid Model');
	}
	
	/* Search the model on the database */
	$query = "SELECT * FROM $dbname.drones WHERE (model = :model)";
	$values = array('model' => $model);

	
	try
	{
		$res = $pdo->prepare($query);
		$res->execute($values);
	}
	catch (PDOException $e)
	{
	   
	   throw new Exception('Database query error '.$e);
	}
	
	$row = $res->fetchAll(PDO::FETCH_ASSOC);

	if (is_array($row))
	{
		$drone =$row;
	}
	
	return $drone;
}

public static function getAllDronesByUserId(string $userId):array
{
	/* Global $pdo object */
	global $pdo;
	global $dbname;
	
	$userId = trim($userId);
    $drone = array();

	/* Search the serialNumber on the database */
	$query = "SELECT * FROM $dbname.drones WHERE (userId = :userId)";
	$values = array('userId' => $userId);
	
	try
	{
		$res = $pdo->prepare($query);
		$res->execute($values);
	}
	catch (PDOException $e)
	{
	   throw new Exception('Database query error'. $e);
	}
	
	$row = $res->fetchAll(PDO::FETCH_ASSOC);
	
	if (is_array($row))
	{
		$drone =$row;
	}
	
	return $drone;
}

public static function getAllDronesByState(string $state):array
{
	/* Global $pdo object */
	global $pdo;
	global $dbname;
	
	$state = trim($state);
    $drone = array();

	if (!self::isStateValid($state))
	{
		throw new Exception('Drone can not be in such state');
	}

	/* Search the serialNumber on the database */
	$query = "SELECT * FROM $dbname.drones WHERE (state = :state)";
	$values = array('state' => $state);
	
	try
	{
		$res = $pdo->prepare($query);
		$res->execute($values);
	}
	catch (PDOException $e)
	{
	   
	   throw new Exception('Database query error');
	}
	
	$row = $res->fetchAll(PDO::FETCH_ASSOC);
	
	
	if (is_array($row))
	{
		$drone =$row;
	}
	
	return $drone;
}


public  static function getAllDrones():array
{
	/* Global $pdo object */
	global $pdo;
	global $dbname;
	
    $drone = array();


	$query = "SELECT * FROM $dbname.drones order by dateCreated desc";
	
	try
	{
		$res = $pdo->prepare($query);
		$res->execute();
	
	}
	catch (PDOException $e)
	{
	   
	   throw new Exception('Database query error');
	}
	
	$row = $res->fetchAll(PDO::FETCH_ASSOC);
	
	
	if (is_array($row))
	{
		$drone =$row;
	}
	
	return $drone;
}


/* 
Edit a drone state given its serialNumber */
public static function updateDroneState(string $serialNumber, string $state)
{
	/* Global $pdo object */
	global $pdo;
	global $dbname;
	
	/* Trim the strings to remove extra spaces */
	$serialNumber = trim($serialNumber);
	$state = trim($state);
	
	/* Check if the state. If not, throw an exception */
	if (!self::isStateValid($state))
	{
		throw new Exception('Drone can not be in such state');
	}
	
	
	/* Check if a drone with the serialNumber exist to be updated */
	$drone = self::getDroneDetailsFromSerial($serialNumber);
	
	if (is_null($drone))
	{
		throw new Exception('Drone does not exist');
	}
	
	/* Finally, edit the drone state */
	
	$query = "UPDATE $dbname.drones SET state = :state WHERE serialNumber = :serialNumber";
	
	/* Values array for PDO */
	$values = array(':state' => $state, ':serialNumber' => $serialNumber);
	
	/* Execute the query */
	try
	{
		$res = $pdo->prepare($query);
		$res->execute($values);
	}
	catch (PDOException $e)
	{
	   /* If there is a PDO exception, throw a standard exception */
	   throw new Exception('Database query error'.$e);
	}
}
/*
Edit a drone batteryLevel given its serialNumber */
public static function updateDroneBatteryLevel(string $serialNumber, string $batteryLevel)
{
	/* Global $pdo object */
	global $pdo;
	global $dbname;
	
	/* Trim the strings to remove extra spaces */
	$serialNumber = trim($serialNumber);
	$batteryLevel = trim($batteryLevel) ;
	
/* Check if the battery level is valid. If not, throw an exception */
	if (!self::isBatteryLevelValid($batteryLevel))
	{
		throw new Exception('Invalid Value for battery Level (0 < n <= 100)');
	}
	
	/* Check if a drone with the serialNumber exist to be updated */
	$drone = self::getDroneDetailsFromSerial($serialNumber);
	
	if (empty($drone))
	{
		throw new Exception('Drone does not exist');
	}
	
	/* Finally, edit the drone */
	
	$query = "UPDATE $dbname.drones SET batteryLevel = :batteryLevel WHERE serialNumber = :serialNumber";

	/* Values array for PDO */
	$values = array(':batteryLevel' => $batteryLevel, 'serialNumber'=>$serialNumber);
	
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


/* Delete an Drone (selected by its serialNumber) */
public static function deleteDrone(string $serialNumber, string $userId)
{
	/* Global $pdo object */
	global $pdo;
	global $dbname;
	
		/* Check if a drone with the serialNumber exist to be updated */
        $drone = self::getDroneDetailsFromSerial($serialNumber);
	
        if (empty($drone))
        {
            throw new Exception('Drone does not exist');
        }
	
	/* Query to delete */
	$query = "DELETE FROM $dbname.drones WHERE (serialNumber = :serialNumber) and (userId = :userId)";
	
	/* Values array for PDO */
	$values = array(
		'serialNumber' => $serialNumber,
		'userId' => $userId
	);
	
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