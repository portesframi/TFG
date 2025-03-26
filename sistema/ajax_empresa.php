<?php

	include "../conexion.php";
	session_start();

	if(!empty($_POST)){

		// Buscar empresa
		if($_POST['action'] == 'searchEmpresa')
		{
			if(!empty($_POST['empresa'])){

				$cif = $_POST['empresa'];
				$query = mysqli_query($conection,"SELECT * FROM empresa WHERE cif LIKE '$cif' and estatus = 1");
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

		// Crear empresa en formulario de practicas
		if($_POST['action'] == 'addEmpresa')
		{
			$cif 		= $_POST['cif'];
			$nombre 	= $_POST['empresa'];
			$direccion 	= $_POST['dir_empresa'];
			$localidad 	= $_POST['loc_empresa'];
			$cp 		= $_POST['cp_empresa'];
			$provincia	= $_POST['pro_empresa'];
			$telefono	= $_POST['tel_empresa'];
			$email 		= $_POST['corr_empresa'];
			$contacto 	= $_POST['cont_empresa'];
			$usuario_id = $_SESSION['idUser'];

			$query_insert = mysqli_query($conection,"INSERT INTO empresa(cif,empresa,direccion,localidad,cp,provincia,telefono,correo,contacto,usuario_id) VALUES('$cif','$nombre','$direccion','$localidad','$cp','$provincia','$telefono','$email','$contacto','$usuario_id')");



			if($query_insert) {
				$idempresa = mysqli_insert_id($conection);
				$msg = $idempresa;
			}else{
				$msg='error';
			}
			// mysqli_close($conection);
			echo $msg;
			exit;
		}

	}

	exit;
?>