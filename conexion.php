<?php

	$host = 'localhost:3306';
	$user = 'root';
	$password = '';
	$db = 'if0_36596916_aulaempresa';
	
	// Intenta establecer la conexión a la base de datos
	$conection = @mysqli_connect($host,$user,$password,$db);

	// Verifica si hay errores de conexión
	if(!$conection){
		echo "Error en la conexión";
	}
    // Establecer la codificación de caracteres a UTF-8
    $conection->set_charset("utf8");
?>
