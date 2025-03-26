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

				$nombre 	= $_POST['empresa'];
				$cif 		= $_POST['cif'];
				$direccion 	= $_POST['direccion'];
				$localidad 	= $_POST['localidad'];
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
				$usuario_id 		= $_SESSION['idUser'];

				$result = 0;

				if (is_string($cif))
				{
					$query = mysqli_query($conection,"SELECT * FROM empresa WHERE cif = '$cif' ");
					$result = mysqli_fetch_array($query);
				}

				if($result > 0){
					$alert='<p class="msg_error">El CIF ya existen.</p>';
				}else{
					$query_insert = mysqli_query($conection,"INSERT INTO empresa(empresa,cif,direccion,localidad,cp,provincia,telefono,correo,representante,dni_repre,contacto,cargo, telefono_contacto,correo_contacto,sector, origen, comentario, usuario_id) VALUES('$nombre','$cif','$direccion','$localidad','$cp','$provincia','$telefono','$email','$representante','$dni_repre','$contacto','$cargo','$telefono_contacto','$correo_contacto','$sector','$origen','$comentario','$usuario_id')");
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
				<p>
					<label for="empresa">Nombre empresa*</label>
					<input type="text" size="100" maxlength="150" name="empresa" id="empresa" placeholder="Nombre completo*">
					<label for="cif">CIF empresa*</label>
					<input type="text" size="25" maxlength="50" name="cif" id="cif" placeholder="CIF*">
				</p>
				<p>
					<label for="direccion">Dirección empresa</label>
					<input type="text" size="150" maxlength="300" name="direccion" id="direccion" placeholder="Dirección">
				</p>
				<p>
					<label for="localidad">Localidad empresa</label>
					<input type="text" size="35" maxlength="50" name="localidad" id="localidad" placeholder="Localidad">
					<label for="cp">Código postal empresa</label>
					<input type="number" size="7" maxlength="7" name="cp" id="cp" placeholder="Código postal">
					<label for="provincia">Provincia empresa</label>
					<input type="text" size="25" maxlength="50" name="provincia" id="provincia" placeholder="Provincia">
				</p>
				<p>
					<label for="telefono">Teléfono empresa</label>
					<input type="number" size="50" maxlength="100" name="telefono" id="telefono" placeholder="Teléfono">
					<label for="correo">Correo empresa</label>
					<input type="email" size="100" name="correo" id="correo" placeholder="Correo electrónico">
				</p>
				<p>
					<label for="representante">Representante de la empresa</label>
					<input type="text" size="60" maxlength="150" name="representante" id="representante" placeholder="Nombre y apellidos">
					<label for="dni_repre">DNI representante de la empresa</label>
					<input type="text" name="dni_repre" id="dni_repre" placeholder="DNI">
				</p>
				<p>
					<label for="contacto">Persona de contacto</label>
					<input type="text" size="145" maxlength="200" name="contacto" id="contacto" placeholder="Nombre y apellidos">
					<label for="cargo">Cargo de la persona de contacto</label>
					<input type="text" size="130" maxlength="200" name="cargo" id="cargo" placeholder="Cargo">
				</p>
				<p>
					<label for="telefono_contacto">Teléfono del contacto</label>
					<input type="number" size="50" maxlength="100" name="telefono_contacto" id="telefono_contacto" placeholder="Teléfono contacto">
					<label for="correo_contacto">Correo del contacto</label>
					<input type="email" size="90" name="correo_contacto" id="correo_contacto" placeholder="Correo electrónico contacto">
				</p>
				<p>	
					<label for="sector">Sector empresarial</label>
					<input type="text" size="150" maxlength="200" name="sector" id="sector" placeholder="Sector empresarial">
					<label for="origen">Origen del contacto de la empresa</label>
					<input type="text" size="130" maxlength="200" name="origen" id="origen" placeholder="Origen empresa">
				</p>
				<div class="wd30">
				    <label for="comentario">Comentarios</label>
				    <textarea id="comentario" name="comentario" rows="10" cols="150" required></textarea>
				</div>


				<input type="submit" value="Crear empresa" class="btn_save">


			</form>
			

		</div>


	</section>
	<?php include "includes/footer.php"; ?>
</body>
</html>