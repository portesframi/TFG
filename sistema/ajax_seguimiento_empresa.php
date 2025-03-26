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

	}

	exit;
?>