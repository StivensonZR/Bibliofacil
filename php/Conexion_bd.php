<?php

session_start();

$dsn = 'mysql:dbname=bibliofacil;host=localhost';
$user = 'root';
$password = 'root';

try{

	$pdo = new PDO(	$dsn, 
					$user, 
					$password
					);
    //echo 'Conexión Exitosa';

}catch( PDOException $e ){
	echo 'Error al conectarnos: ' . $e->getMessage();
}



