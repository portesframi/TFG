<?php
	session_start();
	if ($_SESSION['rol'] != 1)
	{
		header("location: ./");
	}
	
	include "../conexion.php";

	if (!empty($_POST)) 
	{
		if(empty($_POST['idempresa'])){
			header("Location: lista_empresas.php");
			mysqli_close($conection);
		}
		$idempresa = $_POST['idempresa'];

		// $query_delete = mysqli_query($conection,"DELETE FROM empresa WHERE idempresa = $idempresa"); para eliminar empresas
		$query_delete = mysqli_query($conection,"UPDATE empresa SET estatus = 0 WHERE idempresa= $idempresa"); // para desactivar usuarios sin eliminar.
		mysqli_close($conection);
		if($query_delete) {
			header("Location: lista_empresas.php");
		}else{
			echo "Error al eliminar registro";
		}

	}

	if (empty($_REQUEST['id'])) 
	{
		header("Location: lista_empresas.php");
		mysqli_close($conection);
	}else{

		$idempresa = $_REQUEST['id'];

		$query = mysqli_query($conection,"SELECT * FROM empresa WHERE idempresa = $idempresa ");

		mysqli_close($conection);

		$result = mysqli_num_rows($query);
		if($result >0){
			while ($data = mysqli_fetch_array($query)) {
				$nombre = $data['empresa'];
				$cif = $data['cif'];
			}
		}else{
			header("Location: lista_empresas.php");
		}
	}



?>



<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php"; ?>
	<title>Eliminar Empresa</title>
</head>
<body>
	<?php include "includes/header.php"; ?>
	<section id="container">
		<div class="data_delete">
			<h2>¿Está seguro que desea eliminar este registro?</h2>
			<p>Nombre de la empresa: <span><?php echo $nombre; ?></span></p>
			<p>CIF: <span><?php echo $cif; ?></span></p>

			<form method="post" accept="">
				<input type="hidden" name="idempresa" value="<?php echo $idempresa; ?>">
				<a href="lista_empresas.php" class="btn_cancel">Cancelar</a>
				<input type="submit" value="Eliminar" class="btn_ok">
			</form>
		</div>

	</section>
	<?php include "includes/footer.php"; ?>
</body>
</html>