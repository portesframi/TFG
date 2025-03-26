<?php
		session_start();
		include "../conexion.php";

		// Funciones de creación de seguimientos de empresas
		if(!empty($_POST)){
		
			$alert='';
			
			$empresa 				= $_POST['empresa']; // Obtener el valor de empresa 
			$fecha_contacto			= $_POST['fecha_contacto'];
			$profesor				= $_POST['profesor'];
			$tipo_practica 			= $_POST['tipo_practica'];
			$ciclo		 			= $_POST['ciclo'];
			$sector					= $_POST['sector'];
			$convenio_firmado 		= $_POST['convenio_firmado'];
			$fecha_firma_convenio	= $_POST['fecha_firma_convenio'];
			$medio					= $_POST['medio'];
			$comentario				= $_POST['comentario'];
			$usuario_id 			= $_SESSION['idUser'];

			$result = 0;

			$query_insert = mysqli_query($conection,"INSERT INTO seguimiento_empresa(empresa,fecha_contacto,profesor,comentario,tipo_practica,ciclo,sector,convenio_firmado,fecha_firma_convenio,medio,usuario_id) VALUES('$empresa','$fecha_contacto','$profesor','$comentario','$tipo_practica','$ciclo','$sector','$convenio_firmado','$fecha_firma_convenio','$medio','$usuario_id')");

			if($query_insert){
				$alert='<p class="msg_save">Seguimiento de la empresa creado correctamente.</p>';
			}else{
				$alert='<p class="msg_error">Error al crear el seguimiento de la empresa.</p>';
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
	<title>Registro seguimientos empresas</title>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function(){
            // Actualizar el campo oculto empresa cuando se selecciona una empresa
            $('#empresa').change(function(){
                var selectedEmpresa = $(this).val();
                $('#practica_empresa').val(selectedEmpresa);
            });
        });
    </script>
</head>
<body>
	<?php include "includes/header.php"; ?>

	<section id="container">
		<div class="title_page">
			<h1><i class="fas fa-cube"></i> Nuevo seguimiento empresa</h1>
		</div>
		<div class="datos_empresa">
			<div class="action_empresa">
			</div>
			<form name="form_new_seguimiento_empresa" id="form_new_seguimiento_empresa" class="datos">
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

		<div class="datos_seguimiento_empresa">
			<h4>Información del seguimiento de la empresa</h4>
 			<hr>
 		  	<div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>

   			<form action="" method="post" class="datos">
  
				<input type="hidden" id="practica_empresa" name="empresa" value="">
				
				<div class="wd30">
					<label for="distancia">Fecha del contacto</label>
					<input type="date" name="fecha_contacto" id="fecha_contacto" placeholder="Fecha del seguimmiento">
				</div>
				<div class="wd30">
					<label for="dedicacion">Profesor que contacta</label>
					<input type="text" name="profesor" id="profesor" placeholder="Profesor del seguimiento">
				</div>
				<p>				
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
					<label for="ciclo">Ciclo relacionado</label>
					<select style="width:250px" name="ciclo" id="ciclo">
						<option value=""></option>
						<option value="FPB">FPB</option>
						<option value="SMR">SMR</option>
						<option value="ASIR">ASIR</option>
						<option value="DAM">DAM</option>
						<option value="DAW">DAW</option>
					</select>
				</div>
				<div class="wd30">
					<label for="convenio_firmado">Convenio firmado</label>
					<select name="convenio_firmado" id="convenio_firmado">
						<option value=""></option>
						<option value="SI">SI</option>
						<option value="NO">NO</option>
					</select>
				</div>
				<div class="wd30">
					<label for="fecha_firma_convenio">Fecha firma</label>
					<input type="date" name="fecha_firma_convenio" id="fecha_firma_convenio">
				</div>
				</p>
				<p>	
					<label for="sector">Sector empresarial</label>
					<input type="text" size="150" maxlength="200" name="sector" id="sector" placeholder="Sector empresarial">
				<div class="wd60">
					<label for="medio">Medio de contacto</label>
					<select style="width:250px" name="medio" id="medio">
						<option value=""></option>
						<option value="Telefono">Teléfono</option>
						<option value="Email">Email</option>
						<option value="Visita">Visita</option>
						<option value="Linkedin">Linkedin</option>
					</select>
				</div>
				</p>
				<div class="wd60">
				    <label for="comentario">Comentarios</label>
				    <textarea id="comentario" name="comentario" rows="10" cols="100" required></textarea>
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
