<?php
	session_start();

	include "../conexion.php";

	if(!empty($_POST))
	{
		$alert='';
		// para definir que campos son obligatorios
		if(empty($_POST['alumno']) || empty($_POST['dni']) || empty($_POST['telefono']) || empty($_POST['correo']))

		{
			$alert='<p class="msg_error">Faltan campos obligatorios.</p>';
		}else{				
				$codalumno				= $_POST['id'];
				$nombre 				= $_POST['alumno'];
				$dni 					= $_POST['dni'];
				$telefono 				= $_POST['telefono'];
				$email 					= $_POST['correo'];
				$Formacion_de_practicas	= $_POST['Formacion_de_practicas'];
				$Otra_Formacion			= $_POST['Otra_Formacion'];
				$Mas_Formacion			= $_POST['Mas_Formacion'];
				$Nivel_de_ingles	 	= $_POST['Nivel_de_ingles'];
				$Habilidades			= $_POST['Habilidades'];
				$Vehiculo_propio	 	= $_POST['Vehiculo_propio'];
				$Observaciones			= $_POST['Observaciones'];
				$usuario_id				= $_SESSION['idUser'];

			$result = 0;

			if (is_string($dni) and $dni !=0)
			{
			$query = mysqli_query($conection,"SELECT * FROM alumno WHERE (dni = '$dni' AND idalumno != $codalumno) ");

			$result = mysqli_fetch_array($query);
			// $result = count($result);
			}

			if($result > 0){
				$alert='<p class="msg_error">El DNI ya existe, ingrese otro.</p>';
			}else{

				if ($dni == '') {
					$dni = 0;
				}

				$sql_update = mysqli_query($conection,"UPDATE alumno
															SET alumno= '$nombre', dni='$dni ', telefono='$telefono', correo='$email', Formacion_de_practicas='$Formacion_de_practicas', Otra_Formacion='$Otra_Formacion', Mas_Formacion= '$Mas_Formacion', Nivel_de_ingles='$Nivel_de_ingles', Habilidades='$Habilidades', Vehiculo_propio='$Vehiculo_propio', Observaciones='$Observaciones', usuario_id='$usuario_id'
															WHERE idalumno= $codalumno ");
								
				if($sql_update){
					$alert='<p class="msg_save">Alumno actualizado correctamente.</p>';
				}else{
					$alert='<p class="msg_error">Error al actualizar el alumno.</p>';
				}
			}
		}
	}
	// Mostrar datos
	if(empty($_REQUEST['id']))
	{
		header('Location: lista_alumno.php');
		// cierre de la conexión
		mysqli_close($conection);
	}
	$codalumno = $_REQUEST['id'];

	$sql = mysqli_query($conection, "SELECT * FROM alumno WHERE idalumno = $codalumno and estatus = 1");
	// cierre de la conexión
	mysqli_close($conection);
	$result_sql = mysqli_num_rows($sql);

	if($result_sql == 0){
		header('Location: lista_alumno.php');
	}else{
		
		while ($data = mysqli_fetch_array($sql)){
			$codalumno = $data['idalumno'];
			$nombre = $data['alumno'];
			$dni = $data['dni'];
			$telefono = $data['telefono'];
			$email = $data['correo'];
			$Formacion_de_practicas = $data['Formacion_de_practicas'];
			$Otra_Formacion 		= $data['Otra_Formacion'];
			$Mas_Formacion = $data['Mas_Formacion'];
			$Nivel_de_ingles = $data['Nivel_de_ingles'];
			$Habilidades = $data['Habilidades'];
			$Vehiculo_propio = $data['Vehiculo_propio'];
			$Observaciones	= $data['Observaciones'];
		}
	}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts2.php"; ?>
	<title>Actualizar alumno</title>
</head>
<body>
	<?php include "includes/header.php"; ?>
	<section id="container">

		<div class="form_register">
			<h1>Actualizar alumno</h1>
			<hr>
			<div class="alert"><?php echo isset($alert) ? $alert: ''; ?></div>

			<form action="" method="post">
					<input type='hidden' name='id' value="<?php echo $codalumno; ?>">
				<p>
					<label for="alumno">Nombre del alumno*</label>
					<input type="text" size="100" maxlength="200" name="alumno" id="alumno" placeholder="Nombre y apellidos*" value="<?php echo $nombre ?>">
					<label for="dni">DNI alumno*</label>
					<input type="text" size="25" maxlength="50" name="dni" id="dni" placeholder="DNI*" value="<?php echo $dni ?>">
				</p>
				<p>
					<label for="telefono">Teléfono del alumno*</label>
					<input type="number" size="50" maxlength="100" name="telefono" id="telefono" placeholder="Teléfono*" value="<?php echo $telefono ?>">
					<label for="correo">Correo del alumno*</label>
					<input type="email" size="90" name="correo" id="correo" placeholder="Correo electrónico*" value="<?php echo $email ?>">
				</p>
				<p>
					<label for="Formacion_de_practicas">Formación en prácticas</label>
					<select style="width:250px" name="Formacion_de_practicas" id="Formacion_de_practicas">
						<option value="" <?php if($Formacion_de_practicas == "") echo 'selected'; ?>></option>
						<option value="1FPB" <?php if($Formacion_de_practicas == "1FPB") echo 'selected'; ?>>1FPB</option>
						<option value="2FPB" <?php if($Formacion_de_practicas == "2FPB") echo 'selected'; ?>>2FPB</option>
						<option value="1SMR" <?php if($Formacion_de_practicas == "1SMR") echo 'selected'; ?>>1SMR</option>
						<option value="2SMR" <?php if($Formacion_de_practicas == "2SMR") echo 'selected'; ?>>2SMR</option>
						<option value="1ASIR" <?php if($Formacion_de_practicas == "1ASIR") echo 'selected'; ?>>1ASIR</option>
						<option value="2ASIR" <?php if($Formacion_de_practicas == "2ASIR") echo 'selected'; ?>>2ASIR</option>
						<option value="1DAM" <?php if($Formacion_de_practicas == "1DAM") echo 'selected'; ?>>1DAM</option>
						<option value="2DAM" <?php if($Formacion_de_practicas == "2DAM") echo 'selected'; ?>>2DAM</option>
						<option value="1DAW" <?php if($Formacion_de_practicas == "1DAW") echo 'selected'; ?>>1DAW</option>
						<option value="2DAW" <?php if($Formacion_de_practicas == "2DAW") echo 'selected'; ?>>2DAW</option>
						<option value="1DAW+DAM" <?php if($Formacion_de_practicas == "1DAW+DAM") echo 'selected'; ?>>1DAW+DAM</option>
						<option value="2DAW+DAM" <?php if($Formacion_de_practicas == "2DAW+DAM") echo 'selected'; ?>>2DAW+DAM</option>
						<option value="3DAW+DAM" <?php if($Formacion_de_practicas == "3DAW+DAM") echo 'selected'; ?>>3DAW+DAM</option>
					</select>
					<label for="Otra_Formacion">Otra formación</label>
					<input type="text" size="27" maxlength="50" name="Otra_Formacion" id="Otra_Formacion" placeholder="Otras formaciones" value="<?php echo $Otra_Formacion ?>">
					<label for="Mas_Formacion">Mas Formación</label>
					<input type="text" size="27" maxlength="50" name="Mas_Formacion" id="Mas_Formacion" placeholder="Otras formaciones" value="<?php echo $Mas_Formacion ?>">
				</p>
				<p>
					<label for="Nivel_de_ingles">Nivel de inglés</label>
					<input type="text" size="25" maxlength="35" name="Nivel_de_ingles" id="Nivel_de_ingles" placeholder="Nivel de inglés" value="<?php echo $Nivel_de_ingles ?>">
					<label for="Habilidades">Habilidades</label>
					<input type="text" size="65" maxlength="150" name="Habilidades" id="Habilidades" placeholder="Habilidades" value="<?php echo $Habilidades ?>">
					<label for="Vehiculo_propio">Vehículo propio</label>
					<select name="Vehiculo_propio" id="Vehiculo_propio">
        				<option value="" <?php if($Vehiculo_propio == "") echo 'selected'; ?>></option>
        				<option value="SI" <?php if($Vehiculo_propio == "SI") echo 'selected'; ?>>SI</option>
        				<option value="NO" <?php if($Vehiculo_propio == "NO") echo 'selected'; ?>>NO</option>
    				</select>
				</p>				
				<p>
					<label for="Observaciones">Observaciones</label>
					<input type="text" size="153" maxlength="500" name="Observaciones" id="Observaciones" placeholder="Observaciones" value="<?php echo $Observaciones ?>">
				</p>
				
				<input type="submit" value="Actualizar alumno" class="btn_save">


			</form>
			

		</div>


	</section>
	<?php include "includes/footer.php"; ?>
</body>
</html>