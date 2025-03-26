<?php

	include "../conexion.php";
	session_start();

	if(!empty($_POST)){

		// Buscar alumno
		if($_POST['action'] == 'searchAlumno')
		{
			if(!empty($_POST['alumno'])){

				$dni = $_POST['alumno'];
				$query = mysqli_query($conection,"SELECT * FROM alumno WHERE dni LIKE '$dni' and estatus = 1");
				mysqli_close($conection);
				$result = mysqli_num_rows($query);

				$data = '';
				if($result > 0){
					$data = mysqli_fetch_assoc($query);
				}else{
					$data = 0;
				}
				echo json_encode($data,JSON_UNESCAPED_UNICODE);
			}
			exit;
		}

	}

	exit;
?>