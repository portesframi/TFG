<?php
		session_start();
		include "../conexion.php";

		// Funciones de actualización de practicas
		if(!empty($_POST)){
		
			$alert='';
			
			$idPractica = $_POST['id'];
			$empresa 	= $_POST['empresa']; 
			$alumno 	= $_POST['alumno']; 
			$distancia	= $_POST['distancia'];
			$dedicacion	= $_POST['dedicacion'];
			$tarea		= $_POST['tarea'];
			$tipo_practica 			= $_POST['tipo_practica'];
			$curso					= $_POST['curso'];
			$Formacion_de_practicas	= $_POST['Formacion_de_practicas'];
			$fecha_inicio			= $_POST['fecha_inicio'];
			$fecha_fin	 			= $_POST['fecha_fin'];
			$horas					= $_POST['horas'];
			$horario				= $_POST['horario'];
			$instructor				= $_POST['instructor'];
			$dni_instructor			= $_POST['dni_instructor'];
			$titulacion_instructor	= $_POST['titulacion_instructor'];
			$correo_instructor		= $_POST['correo_instructor'];
			$telefono_instructor	= $_POST['telefono_instructor'];
			$usuario_id 			= $_SESSION['idUser'];

			$result = 0;

			$sql_update = mysqli_query($conection,"UPDATE practica
															SET empresa='$empresa', alumno='$alumno', distancia='$distancia', dedicacion='$dedicacion', tarea='$tarea', tipo_practica= '$tipo_practica', curso= '$curso',Formacion_de_practicas= '$Formacion_de_practicas', fecha_inicio='$fecha_inicio', fecha_fin='$fecha_fin', horas='$horas', horario='$horario', instructor='$instructor', dni_instructor='$dni_instructor',titulacion_instructor='$titulacion_instructor',correo_instructor='$correo_instructor', telefono_instructor='$telefono_instructor',usuario_id='$usuario_id'
															WHERE idpractica= $idPractica ");

			if($sql_update){
				$alert='<p class="msg_save">Práctica actualizada correctamente.</p>';
			}else{
				$alert='<p class="msg_error">Error al actualizar la práctica.</p>';
			}
					
		}

	// Mostrar datos
	if(empty($_REQUEST['id']))
	{
		header('Location: lista_practicas.php');
		// cierre de la conexión
		mysqli_close($conection);
	}
	$idpractica = $_REQUEST['id'];

	$sql = mysqli_query($conection, "SELECT * FROM practica WHERE idpractica = $idpractica and estatus = 1");
	// cierre de la conexión
	mysqli_close($conection);
	$result_sql = mysqli_num_rows($sql);

	if($result_sql == 0){
		header('Location: lista_practicas.php');
	}else{
		
		while ($data = mysqli_fetch_array($sql)){
			$Formacion_de_practicas	= $data['idpractica'];
			$empresa 	= $data['empresa'];
			$alumno	 = $data['alumno'];
			$distancia = $data['distancia'];
			$dedicacion = $data['dedicacion'];
			$tarea 		= $data['tarea'];
			$tipo_practica = $data['tipo_practica'];
			$curso = $data['curso'];
			$Formacion_de_practicas = $data['Formacion_de_practicas'];
			$fecha_inicio = $data['fecha_inicio'];
			$fecha_fin = $data['fecha_fin'];
			$horas = $data['horas'];
			$horario	= $data['horario'];
			$instructor = $data['instructor'];
			$dni_instructor = $data['dni_instructor'];
			$titulacion_instructor = $data['titulacion_instructor'];
			$correo_instructor = $data['correo_instructor'];
			$telefono_instructor	 = $data['telefono_instructor'];
			
		}
	}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts2.php"; ?>
	<title>Actualizar práctica</title>
</head>
<body>
	<?php include "includes/header.php"; ?>
	<section id="container">

		<div class="form_register">
			<h1>Actualizar práctica</h1>
			<hr>
			<div class="alert"><?php echo isset($alert) ? $alert: ''; ?></div>

			<form action="" method="post">
				<input type="hidden" name="id" value="<?php echo $idpractica; ?>">
				<p>
				<label for="empresa">Empresa de prácticas</label>
				<input type="text" size="57" name="empresa" id="empresa" placeholder="Nombre completo" value="<?php echo $empresa; ?>">
				<label for="alumno">Alumno en prácticas</label>
				<input type="text" size="57" name="alumno" id="alumno" placeholder="Alumno" value="<?php echo $alumno; ?>">
				</p>
				<p>
				<label for="distancia">Distancia empresa - centro estudios</label>
				<input type="text" name="distancia" id="distancia" placeholder="Distancia" value="<?php echo $distancia; ?>">
				<label for="dedicacion">Dedicacion</label>
				<input type="text" size="87" name="dedicacion" id="dedicacion" placeholder="Dedicacion*" value="<?php echo $dedicacion; ?>">
				</p>
				<p>
				<label for="tarea">Tareas</label>
				<input type="text" size="169" name="tarea" id="tarea" placeholder="Tareas" value="<?php echo $tarea; ?>">
				</p>
				<p>
				<label for="tipo_practica">Tipo de práctica</label>
					<select style="width:250px" name="tipo_practica" id="tipo_practica" 
						<option value="" <?php if($tipo_practica == "") echo 'selected'; ?>></option>
						<option value="FCT" <?php if($tipo_practica == "FCT") echo 'selected'; ?>>FCT</option>
						<option value="DUAL" <?php if($tipo_practica == "DUAL") echo 'selected'; ?>>DUAL</option>
						<option value="PNL" <?php if($tipo_practica == "PNL") echo 'selected'; ?>>PNL</option>
						<option value="FCT+DUAL" <?php if($tipo_practica == "FCT+DUAL") echo 'selected'; ?>>FCT+DUAL</option>
					</select>
				<div class="wd30">
					<label for="curso">Curso académico</label>
					<select style="width:250px" name="curso" id="curso">
						<option value="" <?php if($curso == "") echo 'selected'; ?>></option>
						<option value="2020/2021" <?php if($curso == "2020/2021") echo 'selected'; ?>>2020/2021</option>
						<option value="2021/2022" <?php if($curso == "2021/2022") echo 'selected'; ?>>2021/2022</option>
						<option value="2022/2023" <?php if($curso == "2022/2023") echo 'selected'; ?>>2022/2023</option>
						<option value="2023/2024" <?php if($curso == "2023/2024") echo 'selected'; ?>>2023/2024</option>
						<option value="2024/2025" <?php if($curso == "2024/2025") echo 'selected'; ?>>2024/2025</option>
						<option value="2025/2026" <?php if($curso == "2025/2026") echo 'selected'; ?>>2025/2026</option>
						<option value="2026/2027" <?php if($curso == "2026/2027") echo 'selected'; ?>>2026/2027</option>
						<option value="2027/2028" <?php if($curso == "2027/2028") echo 'selected'; ?>>2027/2028</option>
						<option value="2028/2029" <?php if($curso == "2028/2029") echo 'selected'; ?>>2028/2029</option>
						<option value="2029/2030" <?php if($curso == "2029/2030") echo 'selected'; ?>>2029/2030</option>
					</select>
				</div>
				<div class="wd30">
					<label for="Formacion_de_practicas">Formación en prácticas</label>
					<select style="width:150px" name="Formacion_de_practicas" id="Formacion_de_practicas">
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
				</div>
				<label for="fecha_inicio">Fecha inicio</label>
				<input type="date" name="fecha_inicio" id="fecha_inicio" placeholder="Fecha inicio de la práctica" value="<?php echo $fecha_inicio; ?>">
				<label for="fecha_fin">Fecha fin</label>
				<input type="date" name="fecha_fin" id="fecha_fin" placeholder="Fecha finalización de la práctica" value="<?php echo $fecha_fin; ?>">
				<label for="horas">Horas</label>
				<input type="text" size="10" name="horas" id="horas" placeholder="Horas realizadas durante la práctica" value="<?php echo $horas; ?>">
				<label for="horario">Horario</label>
				<input type="text" size="36" name="horario" id="horario" placeholder="Horario durante la practicas" value="<?php echo $horario; ?>">
				</p>
				<p>
				<label for="instructor">Instructor de la empresa</label>
				<input type="text" size="100" name="instructor" id="instructor" placeholder="Nombre y apellidos*" value="<?php echo $instructor; ?>">
				<label for="dni_instructor">DNI del instructor</label>
				<input type="text" size="13" name="dni_instructor" id="dni_instructor" placeholder="DNI del instructor de la empresa" value="<?php echo $dni_instructor; ?>">
				</p>
				<p>
				<label for="titulacion_instructor">Titulación del instructor de la empresa</label>
				<input type="text" size="50" name="titulacion_instructor" id="titulacion_instructor" placeholder="Titulación">
				</p>
				<p>
				<label for="correo_instructor">Correo del instructor</label>
				<input type="email" size="50" name="correo_instructor" id="correo_instructor" placeholder="Correo electrónico instructor" value="<?php echo $correo_instructor; ?>">
				<label for="telefono_instructor">Teléfono del instructor</label>
				<input type="number" size="25" name="telefono_instructor" id="telefono_instructor" placeholder="Teléfono del instructor" value="<?php echo $telefono_instructor; ?>">
				</p>

				<input type="submit" value="Actualizar práctica" class="btn_save">


			</form>
			

		</div>


	</section>
	<?php include "includes/footer.php"; ?>
</body>
</html>