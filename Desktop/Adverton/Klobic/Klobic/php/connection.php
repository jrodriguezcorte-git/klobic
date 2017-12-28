<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/config/settings.php');
$dsn = 'mysql:host='.DB_HOST.';dbname='.DB_NAME;

$dsn_options = array(
    PDO::MYSQL_ATTR_INIT_COMMAND => 'set character set UTF8',
	PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
	); 
$connection = new PDO($dsn, DB_USER, DB_PASS, $dsn_options);

//-------------------DataBase functions-------------------------

function pdoEscape($var)
{
	global $connection;
	return $connection->quote($var);
}

function pdoSelect($query,$parameters)
{
	global $connection;
	try {
		//$connection->beginTransaction();
		$pdo_table = $connection->prepare($query);
		$pdo_table->execute($parameters);
		$pdo_list = $pdo_table->fetchAll(PDO::FETCH_ASSOC);
		if (count($pdo_list)==0) $pdo_list='empty';
		//$connection->commit();
		return $pdo_list;
		
	} catch(PDOExecption $e) {
		$connection->rollback();
		$error_text = getMessage();
		$error = $connection->errorInfo();
		$error = $error[2];
		return 'error';
	}	
}
	
function pdoSet($query,$parameters)
{
	global $connection;
	try {
		//$connection->beginTransaction();
		$pdo_table = $connection->prepare($query);
		$pdo_table->execute($parameters);
		$mysql_status=$pdo_table->rowCount();
		//$connection->commit();
		if ($mysql_status==0)
			{
				return 'error';
			} else {
				return $connection->lastInsertId();
			}
		}catch(PDOExecption $e) {
			$connection->rollback();
			$error_text=$e->getMessage();
			$error=$connection->errorInfo();
			$error=$error[2];
			return 'error';
		}
}
?>
