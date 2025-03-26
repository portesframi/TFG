<?php

// conectar a la base de datos
$alert = '';
session_start();	

// comprueba si la sesión está abierta
if(!empty($_SESSION['active'])){
	header('location: sistema/');
// si esta cerrada solicita credenciales
}else{

	if(!empty($_POST)){
		if(empty($_POST['usuario']) or empty($_POST['clave'])){
			$alert = 'Debe introducir su usuario y contraseña';
		}else {
			require_once "conexion.php";
			$user = mysqli_real_escape_string($conection,$_POST['usuario']);
			$pass = md5(mysqli_real_escape_string($conection,$_POST['clave']));

			$query = mysqli_query($conection,"SELECT * FROM usuario WHERE usuario = '$user' AND clave = '$pass'");
			
			// cierre de la conexión a la bbdd
			mysqli_close($conection);

			$result = mysqli_num_rows($query);

			if ($result >0) {
				$data = mysqli_fetch_array($query);
				$_SESSION['active'] = true;
				$_SESSION['idUser'] = $data['idusuario'];
				$_SESSION['nombre'] = $data['nombre'];
				$_SESSION['email'] = $data['correo'];
				$_SESSION['user'] = $data['usuario'];
				$_SESSION['rol'] = $data['rol'];

				header('location: sistema/');
			}else{
				$alert = 'El usuario o la contraseña son incorrectos';
				session_destroy();
				
			}
		}
	}
}

?>



<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Sistema Campus & Empresa</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
	<section id="container">

		<form action="" method="post">

			<h3>Iniciar sesión</h3>
			<img src="img/iconlogin.png" alt="Login">

			<input type="text" name="usuario" placeholder="Usuario">
			<input type="password" name="clave" placeholder="Contraseña">
			<div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>
			<input type="submit" value="ENTRAR">
		</form>
	</section>


</body>
</html>