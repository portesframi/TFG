<?php
		session_start();

		include "../conexion.php";

		// Funciones de creación de alumno
		if(!empty($_POST))
		{
			$alert='';
			// para definir que campos son obligatorios
			if(empty($_POST['alumno']) || empty($_POST['dni']) || empty($_POST['telefono']) || empty($_POST['correo']))
			{
				$alert='<p class="msg_error">Faltan campos obligatorios.</p>';
			}else{				

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

				if (is_string($dni))
				{
					$query = mysqli_query($conection,"SELECT * FROM alumno WHERE dni = '$dni' ");
					$result = mysqli_fetch_array($query);
				}

				if($result > 0){
					$alert='<p class="msg_error">El DNI ya existe.</p>';
				}else{
					$query_insert = mysqli_query($conection,"INSERT INTO alumno(alumno,dni,telefono,correo,Formacion_de_practicas,Otra_Formacion,Mas_Formacion,Nivel_de_ingles,Habilidades,Vehiculo_propio,Observaciones,usuario_id) VALUES('$nombre','$dni','$telefono','$email','$Formacion_de_practicas','$Otra_Formacion','$Mas_Formacion','$Nivel_de_ingles','$Habilidades','$Vehiculo_propio','$Observaciones','$usuario_id')");
				
					if($query_insert){
						$alert='<p class="msg_save">Alumno creado correctamente.</p>';
					}else{
						$alert='<p class="msg_error">Error al crear el alumno.</p>';
					}
				}
			}
			// ya tenemos el query y cierro la conexión
			mysqli_close($conection);
		} 
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts2.php"; ?>
	<title>Registro alumno</title>
</head>
<body>
	<?php include "includes/header.php"; ?>
	<section id="container">

		<div class="form_register">
			<h1>Registro de alumno</h1>
			<hr>
			<div class="alert"><?php echo isset($alert) ? $alert: ''; ?></div>

			<form action="" method="post">
				<p>
					<label for="alumno">Nombre del alumno*</label>
					<input type="text" size="100" maxlength="200" name="alumno" id="alumno" placeholder="Nombre y apellidos*">
					<label for="dni">DNI alumno*</label>
					<input type="text" size="25" maxlength="50" name="dni" id="dni" placeholder="DNI*">
				</p>
				<p>
					<label for="telefono">Teléfono del alumno*</label>
					<input type="number" size="50" maxlength="100" name="telefono" id="telefono" placeholder="Teléfono*">
					<label for="correo">Correo del alumno*</label>
					<input type="email" size="90" name="correo" id="correo" placeholder="Correo electrónico*">
				</p>
				<p>
					<label for="Formacion_de_practicas">Formación en prácticas</label>
					<select style="width:250px" name="Formacion_de_practicas" id="Formacion_de_practicas">
						<option value=""></option>
						<option value="1FPB">1FPB</option>
						<option value="2FPB">2FPB</option>
						<option value="1SMR">1SMR</option>
						<option value="2SMR">2SMR</option>
						<option value="1ASIR">1ASIR</option>
						<option value="2ASIR">2ASIR</option>
						<option value="1DAM">1DAM</option>
						<option value="2DAM">2DAM</option>
						<option value="1DAW">1DAW</option>
						<option value="2DAW">2DAW</option>
						<option value="1DAW+DAM">1DAW+DAM</option>
						<option value="2DAW+DAM">2DAW+DAM</option>
						<option value="3DAW+DAM">3DAW+DAM</option>
					</select>
					<label for="Otra_Formacion">Otra formación</label>
					<input type="text" size="27" maxlength="50" name="Otra_Formacion" id="Otra_Formacion" placeholder="Otras formaciones">
					<label for="Mas_Formacion">Mas Formación</label>
					<input type="text" size="27" maxlength="50" name="Mas_Formacion" id="Mas_Formacion" placeholder="Otras formaciones">
				</p>
				<p>
					<label for="Nivel_de_ingles">Nivel de inglés</label>
					<input type="text" size="25" maxlength="35" name="Nivel_de_ingles" id="Nivel_de_ingles" placeholder="Nivel de inglés">
					<label for="Habilidades">Habilidades</label>
					<input type="text" size="65" maxlength="150" name="Habilidades" id="Habilidades" placeholder="Habilidades">
					<label for="Vehiculo_propio">Vehículo propio</label>
					<select name="Vehiculo_propio" id="Vehiculo_propio">
						<option value=""></option>
						<option value="SI">SI</option>
						<option value="NO">NO</option>
					</select>
					
				</p>				
				<p>
					<label for="Observaciones">Observaciones</label>
					<input type="text" size="153" maxlength="500" name="Observaciones" id="Observaciones" placeholder="Observaciones">
				</p>
				
				<input type="submit" value="Crear alumno" class="btn_save">


			</form>
			

		</div>


	</section>
	<?php include "includes/footer.php"; ?>
</body>
</html>