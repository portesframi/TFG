<?php
	session_start();

	include "../conexion.php";

?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php"; ?>
	<title>Listado de seguimientos de las empresa</title>
</head>
<body>
	<?php include "includes/header.php"; ?>
	<section id="container">

		<?php
			$busqueda = strtolower($_REQUEST['busqueda']);
			$inicio = $_REQUEST['inicio']; 
			$fin = $_REQUEST['fin'];
			if (($busqueda=="") && ($inicio=="") && ($fin=="")) 
			{
				header("location: lista_seguimientos_empresas.php");
				mysqli_close($conection);
			}

		?>

		<h1>Listado de seguimientos empresas</h1>
		<a href="registro_seguimiento_empresa.php" class="btn_new">Nuevo seguimiento empresa</a>
		
		<form action="buscar_seguimiento_empresa.php" method="get" class="form_search">
			<label for="desde" style="margin-left: 20px;">Inicio: </label><input  style="margin-left: 10px;" type="date" name="inicio" value="<?php echo $inicio ?>">
			<label for="hasta" style="margin-left: 20px;">Fin: </label><input  style="margin-left: 10px;" type="date" name="fin" value="<?php echo $fin ?>">
			<input type="text" style="margin-left: 30px;" name="busqueda" id="busqueda" placeholder="Buscar" value="<?php echo $busqueda; ?>">
			<input type="submit" value="Buscar" class="btn_search">
		</form>


		<table>
			<tr>
				<th>ID</th>
				<th>Nombre empresa</th>
				<th>Fecha de contacto</th>
				<th>Profesor</th>
				<th>Comentarios</th>
				<th>Tipo de práctica</th>
				<th>Ciclo relacionado</th>
				<th>Sector</th>
				<th>Medio de contacto</th>				
				<th>Acciones</th>
			</tr>
		<?php
			// Paginador
			if($inicio==""){
				$inicio='1970-01-01';
			}

			if($fin==""){
				$fin = date('Y-m-d');
			}
			
			$sql_registe = mysqli_query($conection,"SELECT count(*) as total_registro FROM seguimiento 
										WHERE (idseguimiento LIKE '%$busqueda%' OR 
												empresa LIKE '%$busqueda%' OR 
												fecha_contacto LIKE '%$busqueda%' OR
												profesor LIKE '%$busqueda%' OR
												comentario LIKE '%$busqueda%' OR
												tipo_practica LIKE '%$busqueda%' OR 
												ciclo LIKE '%$busqueda%' OR
												sector LIKE '%$busqueda%' OR
												medio LIKE '%$busqueda%') 
												AND fecha_contacto BETWEEN '$inicio' AND '$fin'  
												AND estatus = 1 AND practica=0" );

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

			$query = mysqli_query($conection,"SELECT * FROM seguimiento WHERE 
											(idseguimiento LIKE '%$busqueda%' OR 
												empresa LIKE '%$busqueda%' OR 
												alumno LIKE '%$busqueda%' OR 
												fecha_contacto LIKE '%$busqueda%' OR
												profesor LIKE '%$busqueda%' OR
												comentario LIKE '%$busqueda%'OR 
												tipo_practica LIKE '%$busqueda%' OR 
												ciclo LIKE '%$busqueda%' OR
												sector LIKE '%$busqueda%' OR
												medio LIKE '%$busqueda%') 
												AND fecha_contacto BETWEEN '$inicio' AND '$fin' 
												AND estatus = 1 AND practica=0 ORDER BY fecha_contacto DESC LIMIT $desde,$por_pagina ");

			mysqli_close($conection);
			$result = mysqli_num_rows($query);
			if($result > 0){
				while ($data = mysqli_fetch_array($query)){

			?>
				<tr>
<tr>
					<td><?php echo $data["idseguimiento"] ?></td>
					<td><?php echo $data["empresa"] ?></td>
					<td><?php echo $data["fecha_contacto"] ?></td>
					<td><?php echo $data["profesor"] ?></td>
					<td><?php echo $data["comentario"] ?></td>
					<td><?php echo $data["tipo_practica"] ?></td>
					<td><?php echo $data["ciclo"] ?></td>
					<td><?php echo $data["sector"] ?></td>
					<td><?php echo $data["medio"] ?></td>
					<td>
						<a class="link_edit" href="editar_seguimiento_empresa.php?id=<?php echo $data["idseguimiento"] ?>">Editar</a>
						
					<?php if ($_SESSION['rol'] == 1) { ?>
						|
						<a class="link_delete" href="eliminar_seguimiento_empresa.php?id=<?php echo $data["idseguimiento"] ?>">Eliminar</a>
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
				<li><a href="?pagina=<?php echo 1; ?>&busqueda=<?php echo $busqueda; ?>&inicio=<?php echo $inicio; ?>&fin=<?php echo $fin; ?>">|<</a></li>
				<li><a href="?pagina=<?php echo $pagina-1; ?>&busqueda=<?php echo $busqueda; ?>&inicio=<?php echo $inicio; ?>&fin=<?php echo $fin; ?>"><<</a></li>
			<?php
				}
				for ($i=1; $i <= $total_paginas; $i++) {
					if ($i == $pagina) 
					{
						echo '<li class="pageSelected">'.$i.'</li>';
					}else{
						echo '<li><a href="?pagina='.$i.'&busqueda='.$busqueda.'&inicio='.$inicio.'&fin='.$fin.'">'.$i.'</a></li>';
					}
				}
				if ($pagina != $total_paginas) 
				{	
			?>
				<li><a href="?pagina=<?php echo $pagina+1; ?>&busqueda=<?php echo $busqueda; ?>&inicio=<?php echo $inicio; ?>&fin=<?php echo $fin; ?>">>></a></li>
				<li><a href="?pagina=<?php echo $total_paginas; ?>&busqueda=<?php echo $busqueda; ?>&inicio=<?php echo $inicio; ?>&fin=<?php echo $fin; ?>">>|</a></li>
			<?php } ?>
			</ul>
		</div>
<?php } ?>
	</section>
	<?php include "includes/footer.php"; ?>
</body>
</html>