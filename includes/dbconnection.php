<?php session_start();	error_reporting(0);
define('DB_HOST','localhost');
define('DB_USER','root');   //isoftcare_hotel
define('DB_PASS','');    //hotel@123
define('DB_NAME','isoftcare_hbmsdb');
// Establish database connection.
try
{
$dbh = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME,DB_USER, DB_PASS,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
}
catch (PDOException $e)
{
exit("Error: " . $e->getMessage());
}
?>