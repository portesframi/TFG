<?php
		session_start();
		include "../conexion.php";

		// Funciones de creación de seguimientos de prácticas
		if(!empty($_POST)){
		
			$alert='';
			
			$empresa 				= $_POST['empresa']; // Obtener el valor de empresa 
			$alumno 				= $_POST['alumno']; // Obtener el valor de alumno 
			$fecha_contacto			= $_POST['fecha_contacto'];
			$profesor				= $_POST['profesor'];
			$curso					= $_POST['curso'];
			$Formacion_de_practicas	= $_POST['Formacion_de_practicas'];
			$comentario				= $_POST['comentario'];
			$usuario_id 			= $_SESSION['idUser'];
			$visita					= isset($_POST['visita']) ? 1 : 0;
			
			$result = 0;

			$query_insert = mysqli_query($conection,"INSERT INTO seguimiento(empresa,alumno,fecha_contacto,profesor,curso,Formacion_de_practicas,comentario,usuario_id, visita, practica) VALUES('$empresa','$alumno','$fecha_contacto','$profesor','$curso','$Formacion_de_practicas','$comentario','$usuario_id',$visita,1)");

			if($query_insert){
				$alert='<p class="msg_save">Seguimiento de práctica creado correctamente.</p>';
			}else{
				$alert='<p class="msg_error">Error al crear el seguimiento de práctica.</p>';
			}
					
			// ya tenemos el query y cierro la conexión
			mysqli_close($conection);
		}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts4.php"; ?>
	<title>Registro seguimientos de prácticas</title>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function(){
            // Actualizar el campo oculto empresa cuando se selecciona una empresa
            $('#empresa').change(function(){
                var selectedEmpresa = $(this).val();
                $('#practica_empresa').val(selectedEmpresa);
            });

            // Actualizar el campo oculto alumno cuando se selecciona un alumno
            $('#alumno').change(function(){
                var selectedAlumno = $(this).val();
                $('#practica_alumno').val(selectedAlumno);
            });
        });
    </script>
</head>
<body>
	<?php include "includes/header.php"; ?>

	<section id="container">
		<div class="title_page">
			<h1><i class="fas fa-cube"></i> Nuevo seguimiento de prácticas</h1>
		</div>
		<div class="datos_empresa">
			<div class="action_empresa">
			</div>
			<form name="form_new_empresa_practicas" id="form_new_empresa_practicas" class="datos">
				<input type="hidden" id="idempresa" name="idempresa" value="" required>
				<div class="wd30">
					<label>CIF empresa</label>
					<input type="text" name="cif" id="cif">
				</div>
				<div class="wd30">
					<label>Nombre empresa</label>
					<input type="text" name="empresa" id="empresa" required>
				</div>
				<div class="wd30">
					<label>Contacto empresa</label>
					<input type="text" name="contacto" id="contacto" disabled required>
				</div>
				<div class="wd30">
					<label>Teléfono de contacto</label>
					<input type="text" name="telefono_contacto" id="telefono_contacto" disabled required>
				</div>
				<div class="wd30">
					<label>Correo de contacto</label>
					<input type="email" name="correo_contacto" id="correo_contacto" disabled required>
				</div>
			</form>
		</div>

		<div class="datos_alumno">
			<form name="form_new_alumno_practicas" id="form_new_alumno_practicas" class="datos">
				<input type="hidden" id="idalumno" name="idalumno" value="">
				<div class="wd30">
					<label>DNI alumno</label>
					<input type="text" name="dni" id="dni">
				</div>
				<div class="wd30">
					<label>Nombre alumno</label>
					<input type="text" name="alumno" id="alumno">
				</div>
			</form>
		</div>

		<div class="datos_practica">
			<h4>Información del seguimiento de prácticas</h4>
 			<hr>
 		  	<div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>

   			<form action="" method="post" class="datos">
  
				<input type="hidden" id="practica_empresa" name="empresa" value="">
				<input type="hidden" id="practica_alumno" name="alumno" value="">
				<div class="wd30">
					<label for="distancia">Fecha del contacto</label>
					<input type="date" name="fecha_contacto" id="fecha_contacto" placeholder="Fecha del seguimmiento">
				</div>
				<div class="wd30">
					<label for="dedicacion">Profesor que contacta</label>
					<input type="text" name="profesor" id="profesor" placeholder="Profesor del seguimiento">
				</div>
				<div class="wd30">
					<label for="curso">Curso académico</label>
					<select style="width:250px" name="curso" id="curso">
						<option value=""></option>
						<option value="2020/2021">2020/2021</option>
						<option value="2021/2022">2021/2022</option>
						<option value="2022/2023">2022/2023</option>
						<option value="2023/2024">2023/2024</option>
						<option value="2024/2025">2024/2025</option>
						<option value="2025/2026">2025/2026</option>
						<option value="2026/2027">2026/2027</option>
						<option value="2027/2028">2027/2028</option>
						<option value="2028/2029">2028/2029</option>
						<option value="2029/2030">2029/2030</option>
					</select>
				</div>
				<div class="wd30">
					<label for="Formacion_de_practicas">Formación en prácticas</label>
					<select style="width:150px" name="Formacion_de_practicas" id="Formacion_de_practicas">
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
				</div>
				<div class="wd30">
				    <label for="comentario">Comentarios</label>
				    <textarea id="comentario" name="comentario" rows="10" cols="50" required></textarea>
				</div>

				<div class="wd30">
				    <label for="visita">Visita</label>
					    <input type="checkbox" name="visita" value="1">
  					</label>
				</div>
				
				<div class="wd100">
					<button type="submit" class="btn_save"><i class="far fa-save fa-lg"></i> Registrar seguimiento</button>
				</div>

			</form>
			

		</div>


	</section>

	<?php include "includes/footer.php"; ?>
</body>
</html>
