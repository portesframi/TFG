<?php
	session_start();
	if ($_SESSION['rol'] != 1)
	{
		header("location: ./");
	}
	
	include "../conexion.php";

	if (!empty($_POST)) 
	{
		if(empty($_POST['idalumno'])){
			header("Location: lista_alumno.php");
			mysqli_close($conection);
		}
		$codalumno = $_POST['idalumno'];

		$query_delete = mysqli_query($conection,"UPDATE alumno SET estatus = 0 WHERE idalumno= $codalumno"); // para desactivar alumnos sin eliminar.
		mysqli_close($conection);
		if($query_delete) {
			header("Location: lista_alumno.php");
		}else{
			echo "Error al eliminar registro";
		}

	}

	if (empty($_REQUEST['id'])) 
	{
		header("Location: lista_alumno.php");
		mysqli_close($conection);
	}else{

		$codalumno = $_REQUEST['id'];

		$query = mysqli_query($conection,"SELECT * FROM alumno WHERE idalumno = $codalumno ");

		mysqli_close($conection);

		$result = mysqli_num_rows($query);
		if($result >0){
			while ($data = mysqli_fetch_array($query)) {
				$nombre = $data['alumno'];
				$dni = $data['dni'];
			}
		}else{
			header("Location: lista_alumno.php");
		}
	}



?>



<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php"; ?>
	<title>Eliminar Alumno</title>
</head>
<body>
	<?php include "includes/header.php"; ?>
	<section id="container">
		<div class="data_delete">
			<h2>¿Está seguro que desea eliminar este registro?</h2>
			<p>Nombre del alumno: <span><?php echo $nombre; ?></span></p>
			<p>DNI:: <span><?php echo $dni; ?></span></p>

			<form method="post" accept="">
				<input type="hidden" name="idalumno" value="<?php echo $codalumno; ?>">
				<a href="lista_alumno.php" class="btn_cancel">Cancelar</a>
				<input type="submit" value="Eliminar" class="btn_ok">
			</form>
		</div>

	</section>
	<?php include "includes/footer.php"; ?>
</body>
</html>