<?php
	session_start();

	include "../conexion.php";

?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php"; ?>
	<title>Lista de prácticas</title>
</head>
<body>
	<?php include "includes/header.php"; ?>
	<section id="container">

		<?php
			$busqueda = strtolower($_REQUEST['busqueda']);
			if (empty($busqueda)) 
			{
				header("location: lista_practicas.php");
				mysqli_close($conection);
			}

		?>

		<h1>Lista de prácticas</h1>
		<a href="registro_practica.php" class="btn_new">Nueva practica</a>
		
		<form action="buscar_practica.php" method="get" class="form_search">
			<input type="text" name="busqueda" id="busqueda" placeholder="Buscar" value="<?php echo $busqueda; ?>">
			<input type="submit" value="Buscar" class="btn_search">
		</form>


		<table>
			<tr>
				<th>ID</th>
				<th>Nombre empresa</th>
				<th>Nombre alumno en prácticas</th>
				<th>Distancia empresa - centro estudios</th>
				<th>Dedicación</th>
				<th>Tareas</th>
				<th>Tipo de práctica</th>
				<th>Curso</th>
				<th>Formación de prácticas</th>
				<th>Fecha inicio</th>
				<th>Fecha fin</th>
				<th>Horas realizadas</th>
				<th>Horario de prácticas</th>
				<th>Instructor de la empresa</th>
				<th>Acciones</th>
			</tr>
		<?php
			// Paginador

			$sql_registe = mysqli_query($conection,"SELECT count(*) as total_registro FROM practica 
										WHERE (idpractica LIKE '%$busqueda%' OR 
												empresa LIKE '%$busqueda%' OR 
												alumno LIKE '%$busqueda%' OR 
												distancia LIKE '%$busqueda%' OR
												dedicacion LIKE '%$busqueda%' OR
												tarea LIKE '%$busqueda%' OR 
												tipo_practica LIKE '%$busqueda%' OR
												curso LIKE '%$busqueda%' OR
												Formacion_de_practicas LIKE '%$busqueda%' OR 
												fecha_inicio LIKE '%$busqueda%' OR
												fecha_fin LIKE '%$busqueda%' OR
												horas LIKE '%$busqueda%' OR
												horario LIKE '%$busqueda%' OR
												instructor LIKE '%$busqueda%' OR 
												dni_instructor LIKE '%$busqueda%' OR
												correo_instructor LIKE '%$busqueda%' OR 
												telefono_instructor LIKE '%$busqueda%' ) 
										AND estatus = 1");

			$result_register = mysqli_fetch_array($sql_registe);
			$total_registro = $result_register['total_registro'];

			echo "<strong>Registros encontrados:</strong> " . $total_registro;
			
			$por_pagina = 20;

			if(empty($_GET['pagina']))
			{
				$pagina = 1;				
			}else{
				$pagina = $_GET['pagina'];
			}

			$desde = ($pagina-1) * $por_pagina;
			$total_paginas = ceil($total_registro / $por_pagina);

			$query = mysqli_query($conection,"SELECT * FROM practica WHERE 
											(idpractica LIKE '%$busqueda%' OR 
												empresa LIKE '%$busqueda%' OR 
												alumno LIKE '%$busqueda%' OR 
												distancia LIKE '%$busqueda%' OR
												dedicacion LIKE '%$busqueda%' OR
												tarea LIKE '%$busqueda%' OR 
												tipo_practica LIKE '%$busqueda%' OR 
												curso LIKE '%$busqueda%' OR
												Formacion_de_practicas LIKE '%$busqueda%' OR
												fecha_inicio LIKE '%$busqueda%' OR
												fecha_fin LIKE '%$busqueda%' OR
												horas LIKE '%$busqueda%' OR
												horario LIKE '%$busqueda%' OR 
												instructor LIKE '%$busqueda%' ) 
											AND
											estatus = 1 ORDER BY fecha_inicio ASC LIMIT $desde,$por_pagina ");

			mysqli_close($conection);
			$result = mysqli_num_rows($query);
			if($result > 0){
				while ($data = mysqli_fetch_array($query)){

			?>
				<tr>
<tr>
					<td><?php echo $data["idpractica"] ?></td>
					<td><?php echo $data["empresa"] ?></td>
					<td><?php echo $data["alumno"] ?></td>
					<td><?php echo $data["distancia"] ?></td>
					<td><?php echo $data["dedicacion"] ?></td>
					<td><?php echo $data["tarea"] ?></td>
					<td><?php echo $data["tipo_practica"] ?></td>
					<td><?php echo $data["curso"] ?></td>
					<td><?php echo $data["Formacion_de_practicas"] ?></td>
					<td><?php echo $data["fecha_inicio"] ?></td>
					<td><?php echo $data["fecha_fin"] ?></td>
					<td><?php echo $data["horas"] ?></td>
					<td><?php echo $data["horario"] ?></td>
					<td><?php echo $data["instructor"] ?></td>
					<td>
						<a class="link_edit" href="editar_practica.php?id=<?php echo $data["idpractica"] ?>">Editar</a>
						
					<?php if ($_SESSION['rol'] == 1) { ?>
						|
						<a class="link_delete" href="eliminar_practica.php?id=<?php echo $data["idpractica"] ?>">Eliminar</a>
					<?php } ?>

					</td>
				</tr>
		<?php
				}
			}
		?>
			
		</table>
<?php
	if($total_registro != 0)
	{

?>
		<div class="paginador">
			<ul>
			<?php
				if ($pagina != 1)
				{
			?>
				<li><a href="?pagina=<?php echo 1; ?>&busqueda=<?php echo $busqueda; ?>">|<</a></li>
				<li><a href="?pagina=<?php echo $pagina-1; ?>&busqueda=<?php echo $busqueda; ?>"><<</a></li>
			<?php
				}
				for ($i=1; $i <= $total_paginas; $i++) {
					if ($i == $pagina) 
					{
						echo '<li class="pageSelected">'.$i.'</li>';
					}else{
						echo '<li><a href="?pagina='.$i.'&busqueda='.$busqueda.'">'.$i.'</a></li>';
					}
				}
				if ($pagina != $total_paginas) 
				{	
			?>
				<li><a href="?pagina=<?php echo $pagina+1; ?>&busqueda=<?php echo $busqueda; ?>">>></a></li>
				<li><a href="?pagina=<?php echo $total_paginas; ?>&busqueda=<?php echo $busqueda; ?>">>|</a></li>
			<?php } ?>
			</ul>
		</div>
<?php } ?>
	</section>
	<?php include "includes/footer.php"; ?>
</body>
</html>