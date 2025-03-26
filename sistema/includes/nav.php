		<nav>
			<ul>
				<li><a href="index.php"><i class="fa-solid fa-house"></i> Inicio</a></li>
			<?php
				if($_SESSION['rol']  == 1){
			?>	
				<li class="principal">

					<a href="#">Usuarios</a>
					<ul>
						<li><a href="registro_usuario.php">Nuevo Usuario</a></li>
						<li><a href="lista_usuarios.php">Lista de Usuarios</a></li>
					</ul>
				</li>
			<?php } ?>
				<li class="principal">
					<a href="#">Empresas</a>
					<ul>
						<li><a href="registro_empresa.php">Nueva Empresa</a></li>
						<li><a href="lista_empresas.php">Lista de Empresas</a></li>
					</ul>
				</li>
				<li class="principal">
					<a href="#">Alumnos</a>
					<ul>
						<li><a href="registro_alumno.php">Nuevo Alumno</a></li>
						<li><a href="lista_alumno.php">Lista de Alumnos</a></li>
					</ul>
				</li>
				<li class="principal">
					<a href="#">Seguimiento empresas</a>
					<ul>
						<li><a href="registro_seguimiento_empresa.php">Nuevo Seguimiento empresa</a></li>
						<li><a href="lista_seguimientos_empresas.php">Listado de Seguimientos de empresas</a></li>
					</ul>
				</li>
				<li class="principal">
					<a href="#">Prácticas Empresa-Alumno</a>
					<ul>
						<li><a href="registro_practica.php">Nueva Práctica</a></li>
						<li><a href="lista_practicas.php">Listado de prácticas</a></li>
					</ul>
				</li>
				<li class="principal">
					<a href="#">Seguimiento prácticas</a>
					<ul>
						<li><a href="registro_seguimiento.php">Nuevo Seguimiento práctica</a></li>
						<li><a href="lista_seguimientos.php">Listado de Seguimientos de prácticas</a></li>
					</ul>
				</li>
			</ul>
		</nav>