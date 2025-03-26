<?php
	session_start();
	
	include "../conexion.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php"; ?>
	<title>Listado de seguimientos de las empresas</title>
</head>
<body>
	<?php include "includes/header.php"; ?>
	<section id="container">

		<h1>Listado de seguimientos empresas</h1>
		<a href="registro_seguimiento_empresa.php" class="btn_new">Nuevo seguimiento empresa</a>
		
		<form action="buscar_seguimiento_empresa.php" method="get" class="form_search">
			<input type="text" name="busqueda" id="busqueda" placeholder="Buscar">
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
				<th>Convenio firmado</th>
				<th>Fecha firma</th>
				<th>Medio de contacto</th>				
				<th>Acciones</th>
			</tr>
		<?php
			// Paginador
			$sql_registe = mysqli_query($conection,"SELECT count(*) as total_registro FROM seguimiento_empresa WHERE estatus = 1");
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

			$query = mysqli_query($conection,"SELECT * FROM seguimiento_empresa WHERE estatus = 1 ORDER BY fecha_contacto DESC LIMIT $desde,$por_pagina");

			// cierre de la conexión
			mysqli_close($conection);

			$result = mysqli_num_rows($query);
			if($result > 0){
				while ($data = mysqli_fetch_array($query)){

					$formato = 'Y-m-d H:i:s';
					$fecha = DateTime::createFromFormat($formato,$data["dateadd"])

			?>
				<tr>
					<td><?php echo $data["idseguimiento"] ?></td>
					<td><?php echo $data["empresa"] ?></td>
					<td><?php echo $data["fecha_contacto"] ?></td>
					<td><?php echo $data["profesor"] ?></td>
					<td><?php echo $data["comentario"] ?></td>
					<td><?php echo $data["tipo_practica"] ?></td>
					<td><?php echo $data["ciclo"] ?></td>
					<td><?php echo $data["sector"] ?></td>
					<td><?php echo $data["convenio_firmado"] ?></td>
					<td><?php echo $data["fecha_firma_convenio"] ?></td>
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