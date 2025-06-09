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
			$nombre 	= addslashes($_POST['empresa']);
			$cif 		= $_POST['cif'];
			$direccion 	= addslashes($_POST['direccion']);
			$localidad 	= addslashes($_POST['localidad']);
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
			$convenio_firmado	= $_POST['convenio_firmado'];
			$fecha_firma_convenio= $_POST['fecha_firma_convenio'];
			$usuario_id 		= $_SESSION['idUser'];
			$no_interesa		= isset($_POST['no_interesa']) ? 1 : 0;
			$estado				= $_POST['estado'];


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
															SET empresa='$nombre', cif='$cif', direccion='$direccion', localidad='$localidad', cp='$cp', provincia= '$provincia', telefono='$telefono', correo='$email', representante='$representante', dni_repre='$dni_repre', contacto='$contacto', cargo='$cargo', telefono_contacto='$telefono_contacto',correo_contacto='$correo_contacto', sector='$sector', origen='$origen', comentario='$comentario', convenio_firmado='$convenio_firmado', fecha_firma_convenio='$fecha_firma_convenio', usuario_id='$usuario_id', no_interesa=$no_interesa, estado='$estado' 
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
			$convenio_firmado = $data['convenio_firmado'];
			$fecha_firma_convenio = $data['fecha_firma_convenio'];
			$no_interesa = $data['no_interesa'];
			$estado = $data['estado'];
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
				<div class="wd100">
					<label for="cif">CIF empresa*</label>
					<input type="text" size="20" name="cif" id="cif" placeholder="CIF*" value="<?php echo $cif; ?>">
					<label for="empresa">Nombre empresa*</label>
					<input type="text" size="90" name="empresa" id="empresa" placeholder="Nombre completo*" value="<?php echo $nombre; ?>">
				</div>
				<div class="wd100">
				<label for="direccion">Dirección empresa</label>
				<input type="text" size="120" name="direccion" id="direccion" placeholder="Dirección" value="<?php echo $direccion; ?>">
				</div>
				<div class="wd100">
				<label for="localidad">Localidad empresa</label>
				<input type="text" size="30" name="localidad" id="localidad" placeholder="Localidad" value="<?php echo $localidad; ?>">
				<label for="cp">Código postal empresa</label>
				<input type="number" size="7" name="cp" id="cp" placeholder="Código postal" value="<?php echo $cp; ?>">
				<label for="provincia">Provincia empresa</label>
				<input type="text" size="20" name="provincia" id="provincia" placeholder="Provincia" value="<?php echo $provincia; ?>">
				</div>
				<div class="wd100">
				<label for="telefono">Teléfono empresa</label>
				<input type="number" size="50" name="telefono" id="telefono" placeholder="Teléfono" value="<?php echo $telefono; ?>">
				<label for="correo">Correo empresa</label>
				<input type="email" size="80" name="correo" id="correo" placeholder="Correo electrónico" value="<?php echo $email; ?>">
				</div>
				<div class="wd100">
				<label for="representante">Representante de la empresa</label>
				<input type="text" size="60" name="representante" id="representante" placeholder="Nombre y apellidos" value="<?php echo $representante; ?>">
				<label for="dni_repre">DNI representante de la empresa</label>
				<input type="text" name="dni_repre" id="dni_repre" placeholder="DNI" value="<?php echo $dni_repre; ?>">
				</div>
				<div class="wd100">
				<label for="contacto">Persona de contacto</label>
				<input type="text" size="60" name="contacto" id="contacto" placeholder="Nombre y apellidos" value="<?php echo $contacto; ?>">
				<label for="cargo">Cargo de la persona de contacto*</label>
				<input type="text" size="30" maxlength="200" name="cargo" id="cargo" placeholder="Cargo" value="<?php echo $cargo; ?>">
				</div>
				<div class="wd100">
				<label for="telefono_contacto">Teléfono del contacto</label>
				<input type="number" size="50" name="telefono_contacto" id="telefono_contacto" placeholder="Teléfono contacto" value="<?php echo $telefono_contacto; ?>">
				<label for="correo_contacto">Correo del contacto</label>
				<input type="email" size="70" name="correo_contacto" id="correo_contacto" placeholder="Correo electrónico contacto" value="<?php echo $correo_contacto; ?>">
				</div>
				<div class="wd100">
				<label for="sector">Sector empresarial</label>
				<input type="text" size="45" name="sector" id="sector" placeholder="Sector empresarial" value="<?php echo $sector; ?>">
				<label for="origen">Origen del contacto de la empresa</label>
				<input type="text" size="45" maxlength="200" name="origen" id="origen" placeholder="Origen empresa" value="<?php echo $origen; ?>">
				</div>
				<div class="wd30">
    			<label for="comentario">Comentarios</label><br>
    			<textarea id="comentario" name="comentario" rows="10" cols="150"><?php echo htmlspecialchars($comentario); ?></textarea>
				</div>
				<div class="wd30">
					<label for="convenio_firmado">Convenio firmado</label>
					<select name="convenio_firmado" id="convenio_firmado">
						<option value=""></option>
						<option value="SI" <?php echo ($convenio_firmado=="SI")?"selected":""; ?>>SI</option>
						<option value="NO" <?php echo ($convenio_firmado=="NO")?"selected":""; ?>>NO</option>
					</select>
					<label for="fecha_firma_convenio" style="margin-left: 30px;">Fecha firma</label>
					<input type="date" name="fecha_firma_convenio" id="fecha_firma_convenio" value="<?php echo $fecha_firma_convenio; ?>">
				</div>
				<div class="wd30">
				    <label for="no_interesa">No Interesa</label>
						<input type="checkbox" name="no_interesa" value="1" <?php if ($no_interesa) echo 'checked'; ?>>
					</label>
					<label style="margin-left:200px" for="estado">Estado</label>
					<select style="width:200px" name="estado" id="estado">
						<option value="No tratada" <?php if ($estado == 'No tratada') echo 'selected'; ?>>No tratada</option>
						<option value="Interesada" <?php if ($estado == 'Interesada') echo 'selected'; ?>>Interesada</option>
						<option value="Aceptada" <?php if ($estado == 'Aceptada') echo 'selected'; ?>>Aceptada</option>
						<option value="Colaboradora" <?php if ($estado == 'Colaboradora') echo 'selected'; ?>>Colaboradora</option>
						<option value="Fidelizada" <?php if ($estado == 'Fidelizada') echo 'selected'; ?>>Fidelizada</option>
						<option value="Rechazada" <?php if ($estado == 'Rechazada') echo 'selected'; ?>>Rechazada</option>
						<option value="No convertible"<?php if ($estado == 'No convertible') echo 'selected'; ?>>No convertible</option>
					</select>
  					</label>
				</div>
				<input type="submit" value="Actualizar empresa" class="btn_save">


			</form>
			

		</div>


	</section>
	<?php include "includes/footer.php"; ?>
</body>
</html>