<?php
	session_start();
	
	include "../conexion.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts5.php"; ?>
	<title>Listado de prácticas</title>
</head>
<body>
	<?php include "includes/header.php"; ?>
	<section id="container">

		<!-- Valida si los campos de busqueda y filtro están vacios y en caso afirmativo muestra la lista comleta -->
		<?php
			$busqueda= '';
			$search_curso= '';
			if(empty($_REQUEST['busqueda']) && empty($_REQUEST['curso']))
			{
				header("location: lista_practicas.php");
			}
			if(!empty($_REQUEST['busqueda'])){
				$busqueda = strtolower($_REQUEST['busqueda']);
				// $where = ""; no es necsario porque el buscador utiliza buscar_practica.php y no buscar_curso.php
			}
			if(!empty($_REQUEST['curso'])){
				$search_curso = $_REQUEST['curso'];
				$where = "p.curso LIKE '$search_curso' AND p.estatus = 1";
				$buscar = 'curso='.$search_curso;
			}

		?>

		<h1>Listado de prácticas</h1>
		<a href="registro_practica.php" class="btn_new">Nueva práctica</a>
		
		<form action="buscar_practica.php" method="get" class="form_search">
			<input type="text" name="busqueda" id="busqueda" placeholder="Buscar">
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
				<th>Curso
				<?php
				// Para que en el filtro del curso aparezca siempe el valor filtrado
					$cur = 0;
					if(!empty($_REQUEST['curso'])){
							$cur = $_REQUEST['curso'];
					}
					// Busca los cursos en la base de datos en tabla practica
					$query_curso = mysqli_query($conection,"SELECT * FROM cursos WHERE estatus = 1 ORDER BY curso ASC");

					$result_curso = mysqli_num_rows($query_curso);
				?>
				<select name="curso" id="search_curso">
				<option value="" selected>Todos</option>
				<?php

					if($result_curso > 0){
						while ($curso = mysqli_fetch_array($query_curso)) {
							if($cur == $curso["curso"])
							{
							
				?>
					<option value="<?php echo $curso["curso"]; ?>" selected><?php echo $curso["curso"] ?></option>
				<?php
							}else{
				?>
					<option value="<?php echo $curso["curso"]; ?>"><?php echo $curso["curso"] ?></option>
				<?php				
							}
						}
					}
			    ?>                         
				</select>
				</th>
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
			$sql_registe = mysqli_query($conection,"SELECT count(*) as total_registro FROM practica as p
											WHERE $where ");

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

			$query = mysqli_query($conection,"SELECT p.idpractica, p.empresa, p.alumno, p.distancia, p.dedicacion, p.tarea, p.tipo_practica, c.curso, p.Formacion_de_practicas, p.fecha_inicio, p.fecha_fin, p.horas, p.horario, p.instructor FROM practica p INNER JOIN cursos c ON p.curso = c.curso WHERE $where ORDER BY fecha_inicio ASC LIMIT $desde,$por_pagina ");

			// cierre de la conexión
			mysqli_close($conection);

			$result = mysqli_num_rows($query);
			if($result > 0){
				while ($data = mysqli_fetch_array($query)){

					$formato = 'Y-m-d H:i:s';
					// $fecha = DateTime::createFromFormat($formato,$data["dateadd"])

			?>
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
	if($total_paginas != 0)
	{

?>
		<div class="paginador">
			<ul>
			<?php
				if ($pagina != 1)
				{
			?>
				<li><a href="?pagina=<?php echo 1; ?>&<?php echo $buscar; ?>">|<</a></li>
				<li><a href="?pagina=<?php echo $pagina-1; ?>&<?php echo $buscar; ?>"><<<</a></li>
			<?php
				}
				for ($i=1; $i <= $total_paginas; $i++) {
					if ($i == $pagina) 
					{
						echo '<li class="pageSelected">'.$i.'</li>';
					}else{
						echo '<li><a href="?pagina='.$i.'&'.$buscar.'">'.$i.'</a></li>';
					}
				}
				if ($pagina != $total_paginas) 
				{	
			?>
				<li><a href="?pagina=<?php echo $pagina+1; ?>&<?php echo $buscar; ?>">>>></a></li>
				<li><a href="?pagina=<?php echo $total_paginas; ?>&<?php echo $buscar; ?> ">>|</a></li>
			<?php } ?>
			</ul>
		</div>
<?php } ?>

	</section>
	<?php include "includes/footer.php"; ?>
</body>
</html>