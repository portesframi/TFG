<?php
		session_start();
		include "../conexion.php";

		// Funciones de creación de practicas
		if(!empty($_POST)){
		
			$alert='';
			
			$empresa 				= $_POST['empresa']; // Obtener el valor de empresa del formulario 1
			$alumno 				= $_POST['alumno']; // Obtener el valor de alumno del formulario 2
			$distancia				= $_POST['distancia'];
			$dedicacion				= $_POST['dedicacion'];
			$tarea					= $_POST['tarea'];
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
			$anexo1					= isset($_POST['anexo1']) ? 1 : 0;
			$anexo2					= isset($_POST['anexo2']) ? 1 : 0;
			$anexo3					= isset($_POST['anexo3']) ? 1 : 0;
			$anexo5					= isset($_POST['anexo5']) ? 1 : 0;

			$result = 0;

			$query_insert = mysqli_query($conection,"INSERT INTO practica(empresa,alumno,distancia,dedicacion,tarea,tipo_practica,curso,Formacion_de_practicas,fecha_inicio,fecha_fin,horas,horario,instructor,dni_instructor,titulacion_instructor,correo_instructor,telefono_instructor,usuario_id,anexo1, anexo2, anexo3, anexo5) VALUES('$empresa','$alumno','$distancia','$dedicacion','$tarea','$tipo_practica','$curso','$Formacion_de_practicas','$fecha_inicio','$fecha_fin','$horas','$horario','$instructor','$dni_instructor','$titulacion_instructor','$correo_instructor','$telefono_instructor','$usuario_id',$anexo1,$anexo2,$anexo3,$anexo5)");

			if($query_insert){
				$alert='<p class="msg_save">Práctica creada correctamente.</p>';
			}else{
				$alert='<p class="msg_error">Error al crear la práctica.</p>';
			}
					
			// ya tenemos el query y cierro la conexión
			mysqli_close($conection);
		}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts3.php"; ?>
	<title>Registro práctica</title>
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
			<h1><i class="fas fa-cube"></i> Nueva práctica</h1>
		</div>
		<div class="datos_empresa">
			<div class="action_empresa">
				<h4>Datos de la empresa</h4>
				<a href="#" class="btn_new btn_new_empresa"><i class="fas fa-plus"></i> Nueva empresa</a>
			</div>
			<form name="form_new_empresa_practicas" id="form_new_empresa_practicas" class="datos">
				<input type="hidden" name="action" value="addEmpresa">
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
					<label>Dirección empresa</label>
					<input type="text" name="dir_empresa" id="dir_empresa" disabled required>
				</div>
				<div class="wd30">
					<label>Localidad empresa</label>
					<input type="text" name="loc_empresa" id="loc_empresa" disabled required>
				</div>
				<div class="wd30">
					<label>Código postal empresa</label>
					<input type="number" name="cp_empresa" id="cp_empresa" disabled required>
				</div>
				<div class="wd30">
					<label>Provincia empresa</label>
					<input type="text" name="pro_empresa" id="pro_empresa" disabled required>
				</div>
				<div class="wd30">
					<label>Teléfono empresa</label>
					<input type="number" name="tel_empresa" id="tel_empresa" disabled required>
				</div>
				<div class="wd30">
					<label>Correo empresa</label>
					<input type="email" name="corr_empresa" id="corr_empresa" disabled required>
				</div>
				<div class="wd30">
					<label>Persona de contacto</label>
					<input type="text" name="cont_empresa" id="cont_empresa" disabled required>
				</div>

				<div id="div_registro_empresa" class="wd100">
					<button type="submit" class="btn_save"><i class="far fa-save fa-lg"></i> 
					Guardar empresa</button>
				</div>
			</form>
		</div>

		<div class="datos_alumno">
			<div class="action_alumno">
				<h4>Datos alumno</h4>
				<a href="#" class="btn_new btn_new_alumno"><i class="fas fa-plus"></i> Nuevo alumno</a>
			</div>
			<form name="form_new_alumno_practicas" id="form_new_alumno_practicas" class="datos">
				<input type="hidden" name="action" value="addAlumno">
				<input type="hidden" id="idalumno" name="idalumno" value="" required>
				<div class="wd30">
					<label>DNI alumno</label>
					<input type="text" name="dni" id="dni">
				</div>
				<div class="wd30">
					<label>Nombre alumno</label>
					<input type="text" name="alumno" id="alumno" required>
				</div>
				<div class="wd30">
					<label>Teléfono alumno</label>
					<input type="number" name="tel_alumno" id="tel_alumno" disabled required>
				</div>
				<div class="wd30">
					<label>Correo alumno</label>
					<input type="email" name="cor_alumno" id="cor_alumno" disabled required>
				</div>
				<div id="div_registro_alumno" class="wd100">
					<button type="submit" class="btn_save"><i class="far fa-save fa-lg"></i> Crear alumno</button>
				</div>
			</form>
		</div>

		<div class="datos_practica">
			<h4>Registro de práctica</h4>
 			<hr>
 		  	<div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>

   			<form action="" method="post" class="datos">
  
				<input type="hidden" id="practica_empresa" name="empresa" value="">
				<input type="hidden" id="practica_alumno" name="alumno" value="">
				<div class="wd30">
					<label for="distancia">Distancia empresa - centro</label>
					<input type="text" name="distancia" id="distancia" placeholder="Distancia">
				</div>
				<div class="wd30">
					<label for="dedicacion">Dedicación</label>
					<input type="text" name="dedicacion" id="dedicacion" placeholder="Dedicacion">
				</div>
				<div class="wd30">
					<label for="tarea">Tareas</label>
					<input type="text" name="tarea" id="tarea" placeholder="Tareas">
				</div>
				<div class="wd30">
					<label for="tipo_practica">Tipo de práctica</label>
					<select style="width:250px" name="tipo_practica" id="tipo_practica">
						<option value=""></option>
						<option value="FCT">FCT</option>
						<option value="DUAL">DUAL</option>
						<option value="PNL">PNL</option>
						<option value="FCT+DUAL">FCT+DUAL</option>
					</select>
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
					<label for="fecha_inicio">Fecha inicio de práctica</label>
					<input type="date" name="fecha_inicio" id="fecha_inicio" placeholder="Fecha de inicio">
				</div>
				<div class="wd30">
					<label for="fecha_fin">Fecha fin de práctica</label>
					<input type="date" name="fecha_fin" id="fecha_fin" placeholder="Fecha final">
				</div>
				<div class="wd30">
					<label for="horas">Horas realizadas</label>
					<input type="number" name="horas" id="horas" placeholder="Horas realizadas">
				</div>
				<div class="wd30">	
					<label for="horario">Horario de prácticas</label>
					<input type="text" name="horario" id="horario" placeholder="Por rango de horas">
				</div>
				<div class="wd30">
					<label for="instructor">Instructor de la empresa</label>
					<input type="text" name="instructor" id="instructor" placeholder="Nombre y apellidos">
				</div>
				<div class="wd30">
					<label for="dni_instructor">DNI instructor de la empresa</label>
					<input type="text" name="dni_instructor" id="dni_instructor" placeholder="DNI">
				</div>
				<div class="wd40">
					<label for="titulacion_instructor">Titulación del instructor de la empresa</label>
					<input type="text" name="titulacion_instructor" id="titulacion_instructor" placeholder="Titulación">
				</div>
				<div class="wd30">
					<label for="correo_instructor">Correo del instructor</label>
					<input type="email" name="correo_instructor" id="correo_instructor" placeholder="Correo electrónico">
				</div>
				<div class="wd30">
					<label for="telefono_instructor">Teléfono del instructor</label>
					<input type="number" name="telefono_instructor" id="telefono_instructor" placeholder="Teléfono">
				</div>

				<div class="wd100">
					<label for="Anexo1">Anexo 1</label>
					<input type="checkbox" name="anexo1" id="anexo_1" value="1">
					<label style="margin-left: 30px;" for="Anexo2">Anexo 2</label>
					<input type="checkbox" name="anexo2" id="anexo_2" value="1">
					<label style="margin-left: 30px;" for="Anexo3">Anexo 3</label>
					<input type="checkbox" name="anexo3" id="anexo_3" value="1">
					<label style="margin-left: 30px;" for="Anexo5">Anexo 5</label>
					<input type="checkbox" name="anexo5" id="anexo_5" value="1">
				</div>

				<div class="wd100">
					<button type="submit" class="btn_save"><i class="far fa-save fa-lg"></i> Crear practica</button>
				</div>

			</form>
			

		</div>


	</section>

	<?php include "includes/footer.php"; ?>
</body>
</html>
