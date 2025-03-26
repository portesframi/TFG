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

		// Crear alumno en formulario de practicas
		if($_POST['action'] == 'addAlumno')
		{
			$dni 		= $_POST['dni'];
			$nombre 	= $_POST['alumno'];
			$telefono	= $_POST['tel_alumno'];
			$email 		= $_POST['cor_alumno'];
			$usuario_id = $_SESSION['idUser'];

			$query_insert = mysqli_query($conection,"INSERT INTO alumno(dni,alumno,telefono,correo,usuario_id) VALUES('$dni','$nombre','$telefono','$email','$usuario_id')");



			if($query_insert) {
				$idalumno = mysqli_insert_id($conection);
				$msg = $idalumno;
			}else{
				$msg='error';
			}
			mysqli_close($conection);
			echo $msg;
			exit;
		}

	}

	exit;
?>