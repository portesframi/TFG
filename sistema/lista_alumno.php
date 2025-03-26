<?php
	session_start();
	
	include "../conexion.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php"; ?>
	<title>Lista de alumnos</title>
</head>
<body>
	<?php include "includes/header.php"; ?>
	<section id="container">

		<h1>Lista de alumnos</h1>
		<a href="registro_alumno.php" class="btn_new">Nuevo alumno</a>
		
		<form action="buscar_alumno.php" method="get" class="form_search">
			<input type="text" name="busqueda" id="busqueda" placeholder="Buscar">
			<input type="submit" value="Buscar" class="btn_search">
		</form>


		<table>
			<tr>
				<th>ID</th>
				<th>Nombre del alumno</th>
				<th>DNI del alumno</th>
				<th>Teléfono del alumno</th>
				<th>Correo del alumno</th>
				<th>Formación en prácticas</th>
				<th>Otra formación</th>
				<th>Mas Formación</th>
				<th>Nivel de inglés</th>
				<th>Habilidades</th>
				<th>Vehículo propio</th>
				<th>Observaciones</th>
				<th>Fecha alta</th>
				<th>Acciones</th>
			</tr>
		<?php
			// Paginador
			$sql_registe = mysqli_query($conection,"SELECT count(*) as total_registro FROM alumno WHERE estatus = 1");
			$result_register = mysqli_fetch_array($sql_registe);
			$total_registro = $result_register['total_registro'];
			$por_pagina = 20;

			if(empty($_GET['pagina']))
			{
				$pagina = 1;				
			}else{
				$pagina = $_GET['pagina'];
			}

			$desde = ($pagina-1) * $por_pagina;
			$total_paginas = ceil($total_registro / $por_pagina);

			$query = mysqli_query($conection,"SELECT * FROM alumno WHERE estatus = 1 ORDER BY idalumno LIMIT $desde,$por_pagina");

			// cierre de la conexión
			mysqli_close($conection);

			$result = mysqli_num_rows($query);
			if($result > 0){
				while ($data = mysqli_fetch_array($query)){

					$formato = 'Y-m-d H:i:s';
					$fecha = DateTime::createFromFormat($formato,$data["dateadd"])

			?>
				<tr>
					<td><?php echo $data["idalumno"] ?></td>
					<td><?php echo $data["alumno"] ?></td>
					<td><?php echo $data["dni"] ?></td>
					<td><?php echo $data["telefono"] ?></td>
					<td><?php echo $data["correo"] ?></td>
					<td><?php echo $data["Formacion_de_practicas"] ?></td>
					<td><?php echo $data["Otra_Formacion"] ?></td>
					<td><?php echo $data["Mas_Formacion"] ?></td>
					<td><?php echo $data["Nivel_de_ingles"] ?></td>
					<td><?php echo $data["Habilidades"] ?></td>
					<td><?php echo $data["Vehiculo_propio"] ?></td>
					<td><?php echo $data["Observaciones"] ?></td>
					<td><?php echo $fecha->format('d-m-Y'); ?></td>

					<td>
						<a class="link_edit" href="editar_alumno.php?id=<?php echo $data["idalumno"] ?>">Editar</a>
					<?php if ($_SESSION['rol'] == 1) { ?>
						|
						<a class="link_delete" href="eliminar_alumno.php?id=<?php echo $data["idalumno"] ?>">Eliminar</a>
					<?php } ?>
					</td>
				</tr>
		<?php
				}
			}
		?>
			
		</table>
		<div class="paginador">
			<ul>
			<?php
				if ($pagina != 1)
				{
			?>
				<li><a href="?pagina=<?php echo 1; ?>">|<</a></li>
				<li><a href="?pagina=<?php echo $pagina-1; ?>"><<<</a></li>
			<?php
				}
				for ($i=1; $i <= $total_paginas; $i++) {
					if ($i == $pagina) 
					{
						echo '<li class="pageSelected">'.$i.'</li>';
					}else{
						echo '<li><a href="?pagina='.$i.'">'.$i.'</a></li>';
					}
				}
				if ($pagina != $total_paginas) 
				{	
			?>
				<li><a href="?pagina=<?php echo $pagina+1; ?>">>>></a></li>
				<li><a href="?pagina=<?php echo $total_paginas; ?> ">>|</a></li>
			<?php } ?>
			</ul>
		</div>
	</section>
	<?php include "includes/footer.php"; ?>
</body>
</html>