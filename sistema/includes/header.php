<?php
	
	if(empty($_SESSION['active'])){

		header('location: ../'); // retrocede una carpeta atras para llegar al login
	}

?>
	<header>
		<div class="header">
			
			<h1>Bienvenido a Talento FP</h1>
			<div class="optionsBar">
				<p><?php echo fechaC(); ?></p>
				<span></span>
				<p>Copyright Aula mi2, S.L.</p>
				<span>|</span>
				<span class="user"><?php echo $_SESSION['user'].' -'.$_SESSION['rol'].' -'.$_SESSION['email']; ?></span>
				<img class="photouser" src="img/user.png" alt="Usuario">
				<a href="salir.php"><img class="close" src="img/salir.png" alt="Salir del sistema" title="Salir"></a>
			</div>
		</div>
		<?php include "nav.php"; ?>
	</header>