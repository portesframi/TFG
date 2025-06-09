<?php
		session_start();

		include "../conexion.php";

		// Funciones de creación de empresas
		if(!empty($_POST))
		{
			$alert='';
			// para definir que campos son obligatorios
			if(empty($_POST['empresa']) || empty($_POST['cif']))
			{
				$alert='<p class="msg_error">Falta alguno de los campos obligatorios.</p>';
			}else{				

				$nombre 	= addslashes($_POST['empresa']);
				$cif 		= $_POST['cif'];
				$direccion 	= addslashes($_POST['direccion']);
				$localidad 	= addslashes($_POST['localidad']);
				$cp 		= $_POST['cp'];
				$provincia	= $_POST['provincia'];
				$telefono	= $_POST['telefono'];
				$email 		= $_POST['correo'];
				$representante	 	= $_POST['representante'];
				$dni_repre	     	= $_POST['dni_repre'];
				$contacto 		 	= $_POST['contacto'];
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

				if (is_string($cif))
				{
					$query = mysqli_query($conection,"SELECT * FROM empresa WHERE cif = '$cif' ");
					$result = mysqli_fetch_array($query);
				}

				if($result > 0){
					$alert='<p class="msg_error">El CIF ya existen.</p>';
				}else{
					$query_insert = mysqli_query($conection,"INSERT INTO empresa(empresa,cif,direccion,localidad,cp,provincia,telefono,correo,representante,dni_repre,contacto,cargo, telefono_contacto,correo_contacto,sector, origen, comentario, convenio_firmado, fecha_firma_convenio, usuario_id, no_interesa, estado) VALUES('$nombre','$cif','$direccion','$localidad','$cp','$provincia','$telefono','$email','$representante','$dni_repre','$contacto','$cargo','$telefono_contacto','$correo_contacto','$sector','$origen','$comentario', '$convenio_firmado', '$fecha_firma_convenio','$usuario_id', $no_interesa,'$estado')");
					if($query_insert){
						$alert='<p class="msg_save">Empresa creada correctamente.</p>';
					}else{
						$alert='<p class="msg_error">Error al crear la empresa.</p>';
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
	<title>Registro empresa</title>
</head>
<body>
	<?php include "includes/header.php"; ?>
	<section id="container">

		<div class="form_register">
			<h1>Registro de empresa</h1>
			<hr>
			<div class="alert"><?php echo isset($alert) ? $alert: ''; ?></div>

			<form action="" method="post">
				<div class="wd100">
					<label for="cif">CIF empresa*</label>
					<input type="text" size="20" maxlength="50" name="cif" id="cif" placeholder="CIF*">
					<label for="empresa">Nombre empresa*</label>
					<input type="text" size="90" maxlength="150" name="empresa" id="empresa" placeholder="Nombre completo*">
				</div>
				<div class="wd100">
					<label for="direccion">Dirección empresa</label>
					<input type="text" size="120" maxlength="300" name="direccion" id="direccion" placeholder="Dirección">
				</div>
				<div class="wd100">
					<label for="localidad">Localidad empresa</label>
					<input type="text" size="30" maxlength="50" name="localidad" id="localidad" placeholder="Localidad">
					<label for="cp">Código postal empresa</label>
					<input type="number" size="7" maxlength="7" name="cp" id="cp" placeholder="Código postal">
					<label for="provincia">Provincia empresa</label>
					<input type="text" size="20" maxlength="50" name="provincia" id="provincia" placeholder="Provincia">
				</div>
				<div class="wd100">
					<label for="telefono">Teléfono empresa</label>
					<input type="number" size="50" maxlength="100" name="telefono" id="telefono" placeholder="Teléfono">
					<label for="correo">Correo empresa</label>
					<input type="email" size="80" name="correo" id="correo" placeholder="Correo electrónico">
				</div>
				<div class="wd100">
					<label for="representante">Representante de la empresa</label>
					<input type="text" size="60" maxlength="150" name="representante" id="representante" placeholder="Nombre y apellidos">
					<label for="dni_repre">DNI representante de la empresa</label>
					<input type="text" name="dni_repre" id="dni_repre" placeholder="DNI">
				</div>
				<div class="wd100">
					<label for="contacto">Persona de contacto</label>
					<input type="text" size="60" maxlength="200" name="contacto" id="contacto" placeholder="Nombre y apellidos">
					<label for="cargo">Cargo de la persona de contacto</label>
					<input type="text" size="30" maxlength="200" name="cargo" id="cargo" placeholder="Cargo">
				</div>
				<div class="wd100">
					<label for="telefono_contacto">Teléfono del contacto</label>
					<input type="number" size="50" maxlength="100" name="telefono_contacto" id="telefono_contacto" placeholder="Teléfono contacto">
					<label for="correo_contacto">Correo del contacto</label>
					<input type="email" size="70" name="correo_contacto" id="correo_contacto" placeholder="Correo electrónico contacto">
				</div>
				<div class="wd100">	
					<label for="sector">Sector empresarial</label>
					<input type="text" size="45" maxlength="200" name="sector" id="sector" placeholder="Sector empresarial">
					<label for="origen">Origen del contacto de la empresa</label>
					<input type="text" size="45" maxlength="200" name="origen" id="origen" placeholder="Origen empresa">
				</div>
				<div class="wd30">
				    <label for="comentario">Comentarios</label><br>
				    <textarea id="comentario" name="comentario" rows="10" cols="150" required></textarea>
				</div>
				<div class="wd30">
					<label for="convenio_firmado">Convenio firmado</label>
					<select name="convenio_firmado" id="convenio_firmado">
						<option value=""></option>
						<option value="SI">SI</option>
						<option value="NO">NO</option>
					</select>
					<label for="fecha_firma_convenio" style="margin-left: 30px;">Fecha firma</label>
					<input type="date" name="fecha_firma_convenio" id="fecha_firma_convenio">
				</div>
				<div class="wd30">
				    <label for="no_interesa">No Interesa</label>
					    <input type="checkbox" name="no_interesa" value="1">
				    <label style="margin-left:200px" for="estado">Estado</label>
					<select style="width:200px" name="estado" id="estado">
						<option value="No tratada">No tratada</option>
						<option value="Interesada">Interesada</option>
						<option value="Aceptada">Aceptada</option>
						<option value="Colaboradora">Colaboradora</option>
						<option value="Fidelizada">Fidelizada</option>
						<option value="Rechazada">Rechazada</option>
						<option value="No convertible">No convertible</option>
					</select>

				</div>
				<div  class="wd100">
					<input type="submit" value="Crear empresa" class="btn_save">
				</div>

			</form>
			

		</div>


	</section>
	<?php include "includes/footer.php"; ?>
</body>
</html>