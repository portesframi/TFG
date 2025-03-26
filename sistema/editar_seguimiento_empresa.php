<?php
		session_start();
		include "../conexion.php";

		// Funciones de actualización de seguimientos de las empresas
		if(!empty($_POST)){
		
			$alert='';
			
			$idSeguimiento 			= $_POST['id'];
			$empresa 				= $_POST['empresa']; 
			$fecha_contacto			= $_POST['fecha_contacto'];
			$profesor				= $_POST['profesor'];
			$tipo_practica 			= $_POST['tipo_practica'];
			$ciclo		 			= $_POST['ciclo'];
			$sector					= $_POST['sector'];
			$convenio_firmado 		= $_POST['convenio_firmado'];
			$fecha_firma_convenio	= $_POST['fecha_firma_convenio'];
			$medio		 			= $_POST['medio'];
			$comentario				= $_POST['comentario'];
			$usuario_id 			= $_SESSION['idUser'];

			$result = 0;

			$sql_update = mysqli_query($conection,"UPDATE seguimiento_empresa
															SET empresa='$empresa', fecha_contacto='$fecha_contacto', profesor='$profesor', tipo_practica='$tipo_practica', ciclo='$ciclo', sector='$sector', convenio_firmado='$convenio_firmado', fecha_firma_convenio='$fecha_firma_convenio', medio='$medio', comentario='$comentario',usuario_id='$usuario_id'
															WHERE idseguimiento= $idSeguimiento ");

			if($sql_update){
				$alert='<p class="msg_save">Seguimiento de la empresa actualizado correctamente.</p>';
			}else{
				$alert='<p class="msg_error">Error al actualizar el seguimiento de la empresa.</p>';
			}
					
		}

	// Mostrar datos
	if(empty($_REQUEST['id']))
	{
		header('Location: lista_seguimientos_empresas.php');
		// cierre de la conexión
		mysqli_close($conection);
	}
	$idseguimiento  = $_REQUEST['id'];

	$sql = mysqli_query($conection, "SELECT * FROM seguimiento_empresa WHERE idseguimiento = $idseguimiento and estatus = 1");
	// cierre de la conexión
	mysqli_close($conection);
	$result_sql = mysqli_num_rows($sql);

	if($result_sql == 0){
		header('Location: lista_seguimientos_empresas.php');
	}else{
		
		while ($data = mysqli_fetch_array($sql)){
			$idseguimiento 			= $data['idseguimiento'];
			$empresa 				= $data['empresa'];
			$fecha_contacto 		= $data['fecha_contacto'];
			$profesor 				= $data['profesor'];
			$tipo_practica 			= $data['tipo_practica'];
			$ciclo		 			= $data['ciclo'];
			$sector					= $data['sector'];
			$convenio_firmado 		= $data['convenio_firmado'];
			$fecha_firma_convenio	= $data['fecha_firma_convenio'];
			$medio		 			= $data['medio'];
			$comentario 			= $data['comentario'];	

		}
	}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts2.php"; ?>
	<title>Actualizar seguimiento empresa</title>
</head>
<body>
	<?php include "includes/header.php"; ?>
	<section id="container">

		<div class="form_register">
			<h1>Actualizar seguimiento empresa</h1>
			<hr>
			<div class="alert"><?php echo isset($alert) ? $alert: ''; ?></div>

			<form action="" method="post">
				<input type="hidden" name="id" value="<?php echo $idseguimiento; ?>">
				<p>
				<label for="empresa">Empresa de prácticas</label>
				<input type="text" size="57" name="empresa" id="empresa" placeholder="Nombre completo" value="<?php echo $empresa; ?>">
				</p>
				<p>
				<label for="fecha_contacto">Fecha de contacto</label>
				<input type="date" name="fecha_contacto" id="fecha_contacto" placeholder="Fecha" value="<?php echo $fecha_contacto; ?>">
				<label for="profesor">Profesor que contacta</label>
				<input type="text" size="87" name="profesor" id="profesor" placeholder="Profesor" value="<?php echo $profesor; ?>">
				</p>
				<p>				
				<div class="wd30">
					<label for="tipo_practica">Tipo de práctica</label>
					<select style="width:250px" name="tipo_practica" id="tipo_practica" 
						<option value="" <?php if($tipo_practica == "") echo 'selected'; ?>></option>
						<option value="FCT" <?php if($tipo_practica == "FCT") echo 'selected'; ?>>FCT</option>
						<option value="DUAL" <?php if($tipo_practica == "DUAL") echo 'selected'; ?>>DUAL</option>
						<option value="PNL" <?php if($tipo_practica == "PNL") echo 'selected'; ?>>PNL</option>
						<option value="FCT+DUAL" <?php if($tipo_practica == "FCT+DUAL") echo 'selected'; ?>>FCT+DUAL</option>
					</select>
				</div>
				<div class="wd30">
					<label for="ciclo">Ciclo relacionado</label>
					<select style="width:250px" name="ciclo" id="ciclo" 
						<option value="" <?php if($ciclo == "") echo 'selected'; ?>></option>
						<option value="FPB" <?php if($ciclo == "FPB") echo 'selected'; ?>>FPB</option>
						<option value="SMR" <?php if($ciclo == "SMR") echo 'selected'; ?>>SMR</option>
						<option value="ASIR" <?php if($ciclo == "ASIR") echo 'selected'; ?>>ASIR</option>
						<option value="DAM" <?php if($ciclo == "DAM") echo 'selected'; ?>>DAM</option>
						<option value="DAW" <?php if($ciclo == "DAW") echo 'selected'; ?>>DAW</option>
					</select>
				</div>
				<div class="wd30">
    				<label for="convenio_firmado">Convenio firmado</label>
    				<select name="convenio_firmado" id="convenio_firmado">
        				<option value="" <?php if($convenio_firmado == "") echo 'selected'; ?>></option>
        				<option value="SI" <?php if($convenio_firmado == "SI") echo 'selected'; ?>>SI</option>
        				<option value="NO" <?php if($convenio_firmado == "NO") echo 'selected'; ?>>NO</option>
    				</select>
				</div>

				<div class="wd30">
					<label for="fecha_firma_convenio">Fecha firma</label>
					<input type="date" name="fecha_firma_convenio" id="fecha_firma_convenio" value="<?php echo $fecha_firma_convenio; ?>">
				</div>
				</p>
				<p>	
					<label for="sector">Sector empresarial</label>
					<input type="text" size="150" maxlength="200" name="sector" id="sector" placeholder="Sector empresarial" value="<?php echo $sector; ?>">
				</p>
				<div class="wd60">
					<label for="medio">Medio de contacto</label>
					<select style="width:250px" name="medio" id="medio">
						<option value="" <?php if($medio == "") echo 'selected'; ?>></option>
						<option value="Telefono" <?php if($medio == "Telefono") echo 'selected'; ?>>Teléfono</option>
						<option value="Email" <?php if($medio == "Email") echo 'selected'; ?>>Email</option>
						<option value="Visita" <?php if($medio == "Visita") echo 'selected'; ?>>Visita</option>
						<option value="Linkedin" <?php if($medio == "Linkedin") echo 'selected'; ?>>Linkedin</option>
					</select>
				</div>
				<p>
				<label for="comentario">Comentarios</label>
    			<textarea id="comentario" name="comentario" rows="10" cols="150"><?php echo htmlspecialchars($comentario); ?></textarea>
				</p>
				
				<input type="submit" value="Actualizar seguimiento" class="btn_save">


			</form>
			

		</div>


	</section>
	<?php include "includes/footer.php"; ?>
</body>
</html>