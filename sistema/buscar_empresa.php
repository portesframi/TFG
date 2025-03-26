<?php
	session_start();

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

		<?php
			$busqueda = strtolower($_REQUEST['busqueda']);
			if (empty($busqueda)) 
			{
				header("location: lista_empresas.php");
				mysqli_close($conection);
			}

		?>

		<h1>Lista de empresas</h1>
		<a href="registro_empresa.php" class="btn_new">Nueva empresa</a>
		
		<form action="buscar_empresa.php" method="get" class="form_search">
			<input type="text" name="busqueda" id="busqueda" placeholder="Buscar" value="<?php echo $busqueda; ?>">
			<input type="submit" value="Buscar" class="btn_search">
		</form>


		<table>
			<tr>
				<th>ID</th>
				<th>Nombre empresa</th>
				<th>CIF empresa</th>
				<th>Dirección empresa</th>
				<th>Localidad</th>
				<th>Provincia</th>
				<th>Teléfono empresa</th>
				<th>Correo empresa</th>
				<th>Persona de Contacto</th>
				<th>Teléfono del contato</th>
				<th>Correo del contacto</th>
				<th>Sector empresarial</th>
				<th>Origen empresa</th>
			</tr>
		<?php
			// Paginador

			$sql_registe = mysqli_query($conection,"SELECT count(*) as total_registro FROM empresa 
										WHERE (idempresa LIKE '%$busqueda%' OR 
												empresa LIKE '%$busqueda%' OR 
												cif LIKE '%$busqueda%' OR 
												direccion LIKE '%$busqueda%' OR
												localidad LIKE '%$busqueda%' OR
												cp LIKE '%$busqueda%' OR 
												provincia LIKE '%$busqueda%' OR 
												telefono LIKE '%$busqueda%' OR
												correo LIKE '%$busqueda%' OR
												representante LIKE '%$busqueda%' OR
												dni_repre LIKE '%$busqueda%' OR
												contacto LIKE '%$busqueda%' OR 
												telefono_contacto LIKE '%$busqueda%' OR
												correo_contacto LIKE '%$busqueda%' OR 
												sector LIKE '%$busqueda%' OR
												origen LIKE '%$busqueda%') 
										AND estatus = 1");

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

			$query = mysqli_query($conection,"SELECT * FROM empresa WHERE 
											(idempresa LIKE '%$busqueda%' OR 
												empresa LIKE '%$busqueda%' OR 
												cif LIKE '%$busqueda%' OR 
												direccion LIKE '%$busqueda%' OR
												localidad LIKE '%$busqueda%' OR
												cp LIKE '%$busqueda%' OR 
												provincia LIKE '%$busqueda%' OR 
												telefono LIKE '%$busqueda%' OR
												correo LIKE '%$busqueda%' OR
												representante LIKE '%$busqueda%' OR
												dni_repre LIKE '%$busqueda%' OR 
												contacto LIKE '%$busqueda%' OR 
												telefono_contacto LIKE '%$busqueda%' OR
												correo_contacto LIKE '%$busqueda%' OR 
												sector LIKE '%$busqueda%' OR
												origen LIKE '%$busqueda%' ) 
											AND
											estatus = 1 ORDER BY idempresa ASC LIMIT $desde,$por_pagina ");

			mysqli_close($conection);
			$result = mysqli_num_rows($query);
			if($result > 0){
				while ($data = mysqli_fetch_array($query)){

			?>
				<tr>
					<td><?php echo $data["idempresa"]; ?></td>
					<td><?php echo $data["empresa"]; ?></td>
					<td><?php echo $data["cif"]; ?></td>
					<td><?php echo $data["direccion"]; ?></td>
					<td><?php echo $data["localidad"]; ?></td>
					<td><?php echo $data["provincia"]; ?></td>
					<td><?php echo $data["telefono"]; ?></td>
					<td><?php echo $data["correo"]; ?></td>
					<td><?php echo $data["contacto"]; ?></td>
					<td><?php echo $data["telefono_contacto"]; ?></td>
					<td><?php echo $data["correo_contacto"]; ?></td>
					<td><?php echo $data['sector'] ?></td>
					<td><?php echo $data['origen'] ?></td>
					<td>
						<a class="link_edit" href="editar_empresa.php?id=<?php echo $data["idempresa"] ?>">Editar</a>
						
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