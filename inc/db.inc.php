<?php
$dbhost= 'localhost';
$dbuser= 'c2116544_dennis';
$dbpassword = 'c2116544_dennis';
$dbname = 'c2116544_drones';
$pdo = NULL;
$CONNECTIONSTRING = "mysql:host=localhost;dbname=c2116544_drones";//port=$port;

try
{  
   $pdo = new PDO($CONNECTIONSTRING, $dbuser,  $dbpassword);
   $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $e)
{
   echo 'Database connection failed.'. $e->getMessage();
   die();
}

?>
