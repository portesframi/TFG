<?php
	session_start();
	include "../conexion.php";

	// Verificar si se recibió un ID de empresa
	$idempresa = isset($_GET['id']) ? intval($_GET['id']) : 0;

	// Si no hay una empresa válida, redirigir a la lista de seguimientos
	if ($idempresa <= 0) {
		header("Location: lista_seguimientos_empresas.php");
		exit();
	}

	// Obtener el nombre de la empresa para buscar en la tabla seguimiento empresa
	$query_empresa = mysqli_query($conection, "SELECT empresa FROM empresa WHERE idempresa = $idempresa LIMIT 1");
	$data_empresa = mysqli_fetch_assoc($query_empresa);
	$nombre_empresa = $data_empresa ? $data_empresa['empresa'] : "";

	if (empty($nombre_empresa)) {
		header("Location: lista_seguimientos_empresas.php");
		exit();
	}

	// Paginación
	$por_pagina = 20;
	$pagina = isset($_GET['pagina']) ? intval($_GET['pagina']) : 1;
	if ($pagina <= 0) $pagina = 1;
	$desde = ($pagina - 1) * $por_pagina;

	// Obtener el total de registros
	$sql_registe = mysqli_query($conection, "SELECT COUNT(*) as total_registro FROM seguimiento_empresa WHERE empresa = '$nombre_empresa' AND estatus = 1");
	$result_register = mysqli_fetch_assoc($sql_registe);
	$total_registro = $result_register['total_registro'];
	$total_paginas = ceil($total_registro / $por_pagina);

	// Obtener los seguimientos de la empresa seleccionada con paginación
	$query = mysqli_query($conection, "SELECT * FROM seguimiento_empresa WHERE empresa = '$nombre_empresa' AND estatus = 1 ORDER BY fecha_contacto DESC LIMIT $desde, $por_pagina");

	mysqli_close($conection);
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php"; ?>
	<title>Seguimientos de <?php echo htmlspecialchars($nombre_empresa); ?></title>
</head>
<body>
	<?php include "includes/header.php"; ?>
	<section id="container">
		<h1>Seguimientos de <?php echo htmlspecialchars($nombre_empresa); ?></h1>
		<!-- <a href="registro_seguimiento_empresa.php?id=<?php echo $idempresa; ?>" class="btn_new">Nuevo Seguimiento</a> -->

		<table>
			<tr>
				<th>ID</th>
				<th>Fecha de Contacto</th>
				<th>Profesor</th>
				<th>Comentarios</th>
				<th>Tipo de Práctica</th>
				<th>Ciclo Relacionado</th>
				<th>Acciones</th>
			</tr>
			<?php
			if (mysqli_num_rows($query) > 0) {
				while ($data = mysqli_fetch_assoc($query)) {
			?>
			<tr>
				<td><?php echo $data["idseguimiento"]; ?></td>
				<td><?php echo $data["fecha_contacto"]; ?></td>
				<td><?php echo htmlspecialchars($data["profesor"]); ?></td>
				<td><?php echo htmlspecialchars($data["comentario"]); ?></td>
				<td><?php echo htmlspecialchars($data["tipo_practica"]); ?></td>
				<td><?php echo htmlspecialchars($data["ciclo"]); ?></td>
				<td>
					<a class="link_edit" href="editar_seguimiento_empresa.php?id=<?php echo $data['idseguimiento']; ?>">Editar</a>

					<?php if ($_SESSION['rol'] == 1) { ?>
					|
					<a class="link_delete" href="eliminar_seguimiento_empresa.php?id=<?php echo $data['idseguimiento']; ?>">Eliminar</a>
					<?php } ?>
				</td>
			</tr>
			<?php
				}
			} else {
				echo "<tr><td colspan='7'>No hay seguimientos registrados para esta empresa.</td></tr>";
			}
			?>
		</table>

		<div class="paginador">
			<ul>
			<?php if ($pagina > 1) { ?>
				<li><a href="?id=<?php echo $idempresa; ?>&pagina=1">|<</a></li>
				<li><a href="?id=<?php echo $idempresa; ?>&pagina=<?php echo $pagina - 1; ?>"><<</a></li>
			<?php } ?>
			<?php for ($i = 1; $i <= $total_paginas; $i++) {
				if ($i == $pagina) {
					echo '<li class="pageSelected">' . $i . '</li>';
				} else {
					echo '<li><a href="?id=' . $idempresa . '&pagina=' . $i . '">' . $i . '</a></li>';
				}
			} ?>
			<?php if ($pagina < $total_paginas) { ?>
				<li><a href="?id=<?php echo $idempresa; ?>&pagina=<?php echo $pagina + 1; ?>">>></a></li>
				<li><a href="?id=<?php echo $idempresa; ?>&pagina=<?php echo $total_paginas; ?>">>|</a></li>
			<?php } ?>
			</ul>
		</div>
	</section>
	<?php include "includes/footer.php"; ?>
</body>
</html>
