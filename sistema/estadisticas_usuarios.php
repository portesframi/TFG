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
	<title>Lista de usuarios</title>
</head>
<body>
	<?php include "includes/header.php"; ?>
	<section id="container">
		<h1>Lista de usuarios</h1>
		<a href="registro_usuario.php" class="btn_new">Nuevo usuario</a>
		<form action="estadisticas_buscar_usuario.php" method="get" class="form_search">
			<label for="desde" style="margin-left: 20px;">Inicio: </label><input  style="margin-left: 10px;" type="date" name="inicio">
			<label for="hasta" style="margin-left: 20px;">Fin: </label><input  style="margin-left: 10px;" type="date" name="fin">
			<input type="text" style="margin-left: 30px;" name="busqueda" id="busqueda" placeholder="Buscar">
			<input type="submit" value="Buscar" class="btn_search">
		</form>

		<table>
			<tr>
				<th>ID</th>
				<th>Nombre</th>
				<th>Correo</th>
				<th>Usuario</th>
				<th>Rol</th>
				<th>Seguimientos</th>
			</tr>
		<?php
			// Paginador
			$sql_registe = mysqli_query($conection,"SELECT u.idusuario, u.nombre, u.correo, u.usuario, r.rol, COUNT(s.idseguimiento) AS total_seguimientos FROM usuario u INNER JOIN rol r ON u.rol = r.idrol
			 LEFT JOIN seguimiento s ON u.idusuario = s.usuario_id AND s.estatus = 1 WHERE u.estatus = 1 GROUP BY u.idusuario, u.nombre, u.correo, u.usuario, r.rol ORDER BY u.nombre");
			$total_registro = mysqli_num_rows($sql_registe);;
			$por_pagina = 10;

			if(empty($_GET['pagina']))
			{
				$pagina = 1;				
			}else{
				$pagina = $_GET['pagina'];
			}

			$desde = ($pagina-1) * $por_pagina;
			$total_paginas = ceil($total_registro / $por_pagina);

			$query = mysqli_query($conection,"SELECT u.idusuario, u.nombre, u.correo, u.usuario, r.rol, COUNT(s.idseguimiento) AS total_seguimientos FROM usuario u INNER JOIN rol r ON u.rol = r.idrol
			 LEFT JOIN seguimiento s ON u.idusuario = s.usuario_id AND s.estatus = 1 WHERE u.estatus = 1 GROUP BY u.idusuario, u.nombre, u.correo, u.usuario, r.rol ORDER BY u.nombre LIMIT $desde, $por_pagina;");

			// cierre de la conexión
			mysqli_close($conection);

			$result = mysqli_num_rows($query);
			if($result > 0){
				while ($data = mysqli_fetch_array($query)){

			?>
				<tr>
					<td><?php echo $data["idusuario"] ?></td>
					<td><?php echo $data["nombre"] ?></td>
					<td><?php echo $data["correo"] ?></td>
					<td><?php echo $data["usuario"] ?></td>
					<td><?php echo $data["rol"] ?></td>
					<td><?php echo $data["total_seguimientos"] ?></td>
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