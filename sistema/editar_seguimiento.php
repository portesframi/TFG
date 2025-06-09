<?php
		session_start();
		include "../conexion.php";

		// Funciones de actualización de seguimientos de prácticas
		if(!empty($_POST)){
		
			$alert='';
			
			$idSeguimiento  		= $_POST['id'];
			$empresa 				= $_POST['empresa']; 
			$alumno 				= $_POST['alumno']; 
			$fecha_contacto			= $_POST['fecha_contacto'];
			$profesor				= $_POST['profesor'];
			$curso					= $_POST['curso'];
			$Formacion_de_practicas	= $_POST['Formacion_de_practicas'];
			$comentario				= $_POST['comentario'];
			$usuario_id 			= $_SESSION['idUser'];
			$visita			= isset($_POST['visita']) ? 1 : 0;
			

			$result = 0;

			$sql_update = mysqli_query($conection,"UPDATE seguimiento
															SET empresa='$empresa', alumno='$alumno', fecha_contacto='$fecha_contacto', profesor='$profesor', curso='$curso', Formacion_de_practicas='$Formacion_de_practicas', comentario='$comentario',usuario_id='$usuario_id', visita=$visita 
															WHERE idseguimiento= $idSeguimiento ");

			if($sql_update){
				$alert='<p class="msg_save">Seguimiento de práctica actualizado correctamente.</p>';
			}else{
				$alert='<p class="msg_error">Error al actualizar el seguimiento de práctica.</p>';
			}
					
		}

	// Mostrar datos
	if(empty($_REQUEST['id']))
	{
		header('Location: lista_seguimientos.php');
		// cierre de la conexión
		mysqli_close($conection);
	}
	$idseguimiento  = $_REQUEST['id'];

	$sql = mysqli_query($conection, "SELECT * FROM seguimiento WHERE idseguimiento = $idseguimiento and estatus = 1 AND practica=1");
	// cierre de la conexión
	mysqli_close($conection);
	$result_sql = mysqli_num_rows($sql);

	if($result_sql == 0){
		header('Location: lista_seguimientos.php');
	}else{
		
		while ($data = mysqli_fetch_array($sql)){
			$idseguimiento 			= $data['idseguimiento'];
			$empresa 				= $data['empresa'];
			$alumno 				= $data['alumno'];
			$fecha_contacto 		= $data['fecha_contacto'];
			$profesor 				= $data['profesor'];
			$curso 					= $data['curso'];
			$Formacion_de_practicas = $data['Formacion_de_practicas'];
			$comentario 			= $data['comentario'];		
			$visita					= $data['visita'];				
		}
	}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts2.php"; ?>
	<title>Actualizar seguimiento de práctica</title>
</head>
<body>
	<?php include "includes/header.php"; ?>
	<section id="container">

		<div class="form_register">
			<h1>Actualizar seguimiento de práctica</h1>
			<hr>
			<div class="alert"><?php echo isset($alert) ? $alert: ''; ?></div>

			<form action="" method="post">
				<input type="hidden" name="id" value="<?php echo $idseguimiento; ?>">
				<p>
				<label for="empresa">Empresa de prácticas</label>
				<input type="text" size="57" name="empresa" id="empresa" placeholder="Nombre completo" value="<?php echo $empresa; ?>">
				<label for="alumno">Alumno en prácticas</label>
				<input type="text" size="57" name="alumno" id="alumno" placeholder="Alumno" value="<?php echo $alumno; ?>">
				</p>
				<p>
				<label for="fecha_contacto">Fecha de contacto</label>
				<input type="date" name="fecha_contacto" id="fecha_contacto" placeholder="Fecha" value="<?php echo $fecha_contacto; ?>">
				<label for="profesor">Profesor que contacta</label>
				<input type="text" size="87" name="profesor" id="profesor" placeholder="Profesor" value="<?php echo $profesor; ?>">
				</p>
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
				<p>
				<label for="comentario">Comentarios</label>
    			<textarea id="comentario" name="comentario" rows="10" cols="150"><?php echo htmlspecialchars($comentario); ?></textarea>
				</p>

				<div class="wd30">
				    <label for="visita">Visita</label>
					<input type="checkbox" name="visita" value="1" <?php if ($visita) echo 'checked'; ?>>
  					</label>
				</div>

				<input type="submit" value="Actualizar seguimiento" class="btn_save">


			</form>
			

		</div>


	</section>
	<?php include "includes/footer.php"; ?>
</body>
</html>