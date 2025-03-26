<?php

	$host = 'localhost';
	$user = 'root';
	$password = '';
	$db = 'aula';

	// Intenta establecer la conexión a la base de datos
	$conection = @mysqli_connect($host,$user,$password,$db);

	// Verifica si hay errores de conexión
	if(!$conection){
		echo "Error en la conexión";
	}

?>
