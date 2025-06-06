<?php
	session_start();

	include "../conexion.php";

	if(!empty($_POST))
	{
		$alert='';
		// para definir que campos son obligatorios
		if(empty($_POST['empresa']) || empty($_POST['cif']))
		{
			$alert='<p class="msg_error">Faltan campos obligatorios.</p>';
		}else{				
			$idEmpresa  = $_POST['id'];
			$nombre 	= $_POST['empresa'];
			$cif 		= $_POST['cif'];
			$direccion 	= $_POST['direccion'];
			$localidad 	= $_POST['localidad'];
			$cp 		= $_POST['cp'];
			$provincia	= $_POST['provincia'];
			$telefono	= $_POST['telefono'];
			$email 		= $_POST['correo'];
			$representante		= $_POST['representante'];
			$dni_repre			= $_POST['dni_repre'];
			$contacto 			= $_POST['contacto'];
			$cargo				= $_POST['cargo'];
			$telefono_contacto	= $_POST['telefono_contacto'];
			$correo_contacto 	= $_POST['correo_contacto'];
			$sector				= $_POST['sector'];
			$origen				= $_POST['origen'];
			$comentario			= $_POST['comentario'];
			$usuario_id 		= $_SESSION['idUser'];

			$result = 0;

			if (is_string($cif) and $cif !=0)
			{
			$query = mysqli_query($conection,"SELECT * FROM empresa WHERE (cif = '$cif' AND idempresa != $idEmpresa) ");

			$result = mysqli_fetch_array($query);
			// $result = count($result);
			}

			if($result > 0){
				$alert='<p class="msg_error">El CIF ya existe, ingrese otro.</p>';
			}else{

				if ($cif == '') {
					$cif = 0;
				}

				$sql_update = mysqli_query($conection,"UPDATE empresa
															SET empresa='$nombre', cif='$cif', direccion='$direccion', localidad='$localidad', cp='$cp', provincia= '$provincia', telefono='$telefono', correo='$email', representante='$representante', dni_repre='$dni_repre', contacto='$contacto', cargo='$cargo', telefono_contacto='$telefono_contacto',correo_contacto='$correo_contacto', sector='$sector', origen='$origen', comentario='$comentario', usuario_id='$usuario_id'
															WHERE idempresa= $idEmpresa ");
								
				if($sql_update){
					$alert='<p class="msg_save">Empresa actualizada correctamente.</p>';
				}else{
					$alert='<p class="msg_error">Error al actualizar la empresa.</p>';
				}
			}
		}
	}
	// Mostrar datos
	if(empty($_REQUEST['id']))
	{
		header('Location: lista_empresas.php');
		// cierre de la conexión
		mysqli_close($conection);
	}
	$idempresa = $_REQUEST['id'];

	$sql = mysqli_query($conection, "SELECT * FROM empresa WHERE idempresa = $idempresa and estatus = 1");
	// cierre de la conexión
	mysqli_close($conection);
	$result_sql = mysqli_num_rows($sql);

	if($result_sql == 0){
		header('Location: lista_empresas.php');
	}else{
		
		while ($data = mysqli_fetch_array($sql)){
			$idempresa = $data['idempresa'];
			$nombre = $data['empresa'];
			$cif = $data['cif'];
			$direccion = $data['direccion'];
			$localidad = $data['localidad'];
			$cp 		= $data['cp'];
			$provincia = $data['provincia'];
			$telefono = $data['telefono'];
			$email = $data['correo'];
			$representante = $data['representante'];
			$dni_repre	= $data['dni_repre'];
			$contacto = $data['contacto'];
			$cargo = $data['cargo'];
			$telefono_contacto = $data['telefono_contacto'];
			$correo_contacto = $data['correo_contacto'];
			$sector	 = $data['sector'];
			$origen = $data['origen'];
			$comentario = $data['comentario'];

			
		}
	}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts2.php"; ?>
	<title>Actualizar empresa</title>
</head>
<body>
	<?php include "includes/header.php"; ?>
	<section id="container">

		<div class="form_register">
			<h1>Actualizar empresa</h1>
			<hr>
			<div class="alert"><?php echo isset($alert) ? $alert: ''; ?></div>

			<form action="" method="post">
				<input type="hidden" name="id" value="<?php echo $idempresa; ?>">
				<p>
				<label for="empresa">Nombre empresa*</label>
				<input type="text" size="100" name="empresa" id="empresa" placeholder="Nombre completo*" value="<?php echo $nombre; ?>">
				<label for="cif">CIF empresa*</label>
				<input type="text" size="25" name="cif" id="cif" placeholder="CIF*" value="<?php echo $cif; ?>">
				</p>
				<p>
				<label for="direccion">Dirección empresa</label>
				<input type="text" size="150" name="direccion" id="direccion" placeholder="Dirección" value="<?php echo $direccion; ?>">
				</p>
				<p>
				<label for="localidad">Localidad empresa</label>
				<input type="text" size="35" name="localidad" id="localidad" placeholder="Localidad" value="<?php echo $localidad; ?>">
				<label for="cp">Código postal empresa</label>
				<input type="number" size="7" name="cp" id="cp" placeholder="Código postal" value="<?php echo $cp; ?>">
				<label for="provincia">Provincia empresa</label>
				<input type="text" size="25" name="provincia" id="provincia" placeholder="Provincia" value="<?php echo $provincia; ?>">
				</p>
				<p>
				<label for="telefono">Teléfono empresa</label>
				<input type="number" size="50" name="telefono" id="telefono" placeholder="Teléfono" value="<?php echo $telefono; ?>">
				<label for="correo">Correo empresa</label>
				<input type="email" size="100" name="correo" id="correo" placeholder="Correo electrónico" value="<?php echo $email; ?>">
				</p>
				<p>
				<label for="representante">Representante de la empresa</label>
				<input type="text" size="60" name="representante" id="representante" placeholder="Nombre y apellidos" value="<?php echo $representante; ?>">
				<label for="dni_repre">DNI representante de la empresa</label>
				<input type="text" name="dni_repre" id="dni_repre" placeholder="DNI" value="<?php echo $dni_repre; ?>">
				</p>
				<p>
				<label for="contacto">Persona de contacto</label>
				<input type="text" size="145" name="contacto" id="contacto" placeholder="Nombre y apellidos" value="<?php echo $contacto; ?>">
				<label for="cargo">Cargo de la persona de contacto*</label>
				<input type="text" size="130" maxlength="200" name="cargo" id="cargo" placeholder="Cargo" value="<?php echo $cargo; ?>">
				</p>
				<p>
				<label for="telefono_contacto">Teléfono del contacto</label>
				<input type="number" size="50" name="telefono_contacto" id="telefono_contacto" placeholder="Teléfono contacto" value="<?php echo $telefono_contacto; ?>">
				<label for="correo_contacto">Correo del contacto</label>
				<input type="email" size="90" name="correo_contacto" id="correo_contacto" placeholder="Correo electrónico contacto" value="<?php echo $correo_contacto; ?>">
				</p>
				<p>
				<label for="sector">Sector empresarial</label>
				<input type="text" size="150" name="sector" id="sector" placeholder="Sector empresarial" value="<?php echo $sector; ?>">
				<label for="origen">Origen del contacto de la empresa</label>
				<input type="text" size="130" maxlength="200" name="origen" id="origen" placeholder="Origen empresa" value="<?php echo $origen; ?>">
				<div class="wd30">
    			<label for="comentario">Comentarios</label>
    			<textarea id="comentario" name="comentario" rows="10" cols="150"><?php echo htmlspecialchars($comentario); ?></textarea>
				</div>
				</p>

				<input type="submit" value="Actualizar empresa" class="btn_save">


			</form>
			

		</div>


	</section>
	<?php include "includes/footer.php"; ?>
</body>
</html>