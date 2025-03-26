<?php
	session_start();
	if ($_SESSION['rol'] != 1)
	{
		header("location: ./");
	}
	
	include "../conexion.php";

	if (!empty($_POST)) 
	{
		if(empty($_POST['idseguimiento'])){
			header("Location: lista_seguimientos.php");
			mysqli_close($conection);
		}
		$idseguimiento = $_POST['idseguimiento'];

		$query_delete = mysqli_query($conection,"UPDATE seguimiento SET estatus = 0 WHERE idseguimiento= $idseguimiento"); // para desactivar usuarios sin eliminar.
		mysqli_close($conection);
		if($query_delete) {
			header("Location: lista_seguimientos.php");
		}else{
			echo "Error al eliminar el seguimiento";
		}

	}

	if (empty($_REQUEST['id'])) 
	{
		header("Location: lista_seguimientos.php");
		mysqli_close($conection);
	}else{

		$idseguimiento = $_REQUEST['id'];

		$query = mysqli_query($conection,"SELECT * FROM seguimiento WHERE idseguimiento = $idseguimiento");

		mysqli_close($conection);

		$result = mysqli_num_rows($query);
		if($result >0){
			while ($data = mysqli_fetch_array($query)) {
				$empresa = $data['empresa'];
				$alumno = $data['alumno'];
			}
		}else{
			header("Location: lista_seguimientos.php");
		}
	}



?>



<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php"; ?>
	<title>Eliminar Seguimiento</title>
</head>
<body>
	<?php include "includes/header.php"; ?>
	<section id="container">
		<div class="data_delete">
			<h2>¿Está seguro que desea eliminar este seguimiento?</h2>
			<p>Nombre de la empresa: <span><?php echo $empresa; ?></span></p>
			<p>Nombre del alumno: <span><?php echo $alumno; ?></span></p>

			<form method="post" accept="">
				<input type="hidden" name="idseguimiento" value="<?php echo $idseguimiento; ?>">
				<a href="lista_seguimientos.php" class="btn_cancel">Cancelar</a>
				<input type="submit" value="Eliminar" class="btn_ok">
			</form>
		</div>

	</section>
	<?php include "includes/footer.php"; ?>
</body>
</html>