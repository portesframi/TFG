<?php
	session_start();
	if ($_SESSION['rol'] != 1)
	{
	header("location: ./");
	}	
	include "../conexion.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php"; ?>
	<title>Lista de empresas</title>
</head>
<body>
	<?php include "includes/header.php"; ?>
	<section id="container">
		<h1>Lista de empresas</h1>
		<a href="registro_empresa.php" class="btn_new">Nueva empresa</a>
		
		<form action="estadisticas_buscar_empresa.php" method="get" class="form_search">
			<label for="desde" style="margin-left: 20px;">Inicio: </label><input  style="margin-left: 10px;" type="date" name="inicio">
			<label for="hasta" style="margin-left: 20px;">Fin: </label><input  style="margin-left: 10px;" type="date" name="fin">
			<input type="text" style="margin-left: 30px;" name="busqueda" id="busqueda" placeholder="Buscar">
			<input type="submit" value="Buscar" class="btn_search">
		</form>


		<table>
			<tr>
				<th>ID</th>
				<th>Nombre empresa</th>
				<th>CIF empresa</th>
				<th>Persona de Contacto</th>
				<th>Teléfono del contato</th>
				<th>Correo del contacto</th>
				<th>Último Contacto</th>
				<th>Profesor Último Contacto</th>
				<th>Número Contactos</th>
				<th>Acciones</th>
			</tr>
		<?php
			// Paginador
			$sql_registe = mysqli_query($conection,"SELECT e.idempresa,e.empresa,e.cif,e.contacto,e.telefono_contacto,e.correo_contacto,s1.profesor,s1.fecha_contacto AS ultima_fecha_contacto, 
    			total_seguimientos.total AS total_seguimientos FROM empresa e JOIN seguimiento s1 ON s1.empresa = e.empresa JOIN (SELECT empresa, MAX(fecha_contacto) AS max_fecha
    			FROM seguimiento WHERE estatus = 1 GROUP BY empresa) ultimos ON s1.empresa = ultimos.empresa AND s1.fecha_contacto = ultimos.max_fecha LEFT JOIN (SELECT empresa, COUNT(*) AS total
    			FROM seguimiento WHERE estatus = 1 GROUP BY empresa) total_seguimientos ON total_seguimientos.empresa = e.empresa WHERE e.estatus = 1 AND s1.estatus = 1 GROUP BY e.idempresa, e.empresa, e.cif, e.contacto, e.telefono_contacto, e.correo_contacto, 
    			s1.profesor, s1.fecha_contacto, total_seguimientos.total");

			$total_registro = mysqli_num_rows($sql_registe);
			$por_pagina = 20;

			if(empty($_GET['pagina']))
			{
				$pagina = 1;				
			}else{
				$pagina = $_GET['pagina'];
			}

			$desde = ($pagina-1) * $por_pagina;
			$total_paginas = ceil($total_registro / $por_pagina);

			$query = mysqli_query($conection,"SELECT e.idempresa,e.empresa,e.cif,e.contacto,e.telefono_contacto,e.correo_contacto,s1.profesor,s1.fecha_contacto AS ultima_fecha_contacto, 
    			total_seguimientos.total AS total_seguimientos FROM empresa e JOIN seguimiento s1 ON s1.empresa = e.empresa JOIN (SELECT empresa, MAX(fecha_contacto) AS max_fecha
    			FROM seguimiento WHERE estatus = 1 GROUP BY empresa) ultimos ON s1.empresa = ultimos.empresa AND s1.fecha_contacto = ultimos.max_fecha LEFT JOIN (SELECT empresa, COUNT(*) AS total
    			FROM seguimiento WHERE estatus = 1 GROUP BY empresa) total_seguimientos ON total_seguimientos.empresa = e.empresa WHERE e.estatus = 1 AND s1.estatus = 1 GROUP BY e.idempresa, e.empresa, e.cif, e.contacto, e.telefono_contacto, e.correo_contacto, 
    			s1.profesor, s1.fecha_contacto, total_seguimientos.total LIMIT $desde,$por_pagina");

			// cierre de la conexión
			mysqli_close($conection);

			$result = mysqli_num_rows($query);
			if($result > 0){
				while ($data = mysqli_fetch_array($query)){

			?>
				<tr>
					<td><?php echo $data["idempresa"] ?></td>
					<td><?php echo $data["empresa"] ?></td>
					<td><?php echo $data["cif"] ?></td>
					<td><?php echo $data["contacto"] ?></td>
					<td><?php echo $data["telefono_contacto"] ?></td>
					<td><?php echo $data["correo_contacto"] ?></td>
					<td><?php echo $data["profesor"] ?></td>
					<td><?php echo $data["ultima_fecha_contacto"] ?></td>
					<td><?php echo $data["total_seguimientos"] ?></td>
					<td>
						<a class="link_edit" href="editar_empresa.php?id=<?php echo $data["idempresa"] ?>">Editar</a>

						<a class="link_seguimiento" href="buscar_seguimiento_de_esta_empresa.php?id=<?php echo $data["idempresa"] ?>">Seguimientos</a>
						
					<?php if ($_SESSION['rol'] == 1) { ?>
						|
						<a class="link_delete" href="eliminar_empresa.php?id=<?php echo $data["idempresa"] ?>">Eliminar</a>
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