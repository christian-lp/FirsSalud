<!DOCTYPE html>
<html lang="es">
<head>
	<?php 
    include_once "./vistas/layouts/head.php";
    ?> 
</head>
<body>
	<div class="container-fluid bg-light">
		<h3 class="text-center py-3">MEDIC - 2023</h3>
	</div>
	<div class="container">
		<ul class="nav nav-justified py-2 nav-pills">
<?php 
/* 
Las variables GET se pasan con parámetros URL. También conocido como cadena
de consultas a través de URL cuando es la primera variable se separa con
signo de pregunta Las que siguen a continuación se separan con &.

*** NAVEGACION CON VARIABLE GET ***		
*/
?>
<?php if (isset($_GET['pagina'])): ?>						
	<?php if ($_GET['pagina'] == "registro"): ?>
		<li class="nav-item">
			<a class="nav-link active" href="index.php?pagina=registro">Cargar Medico</a>
		</li>
	<?php else: ?>
		<li class="nav-item">
			<a class="nav-link" href="index.php?pagina=registro">Cargar Medico</a>
		</li>
	<?php endif ?>


	<?php if ($_GET['pagina'] == "registerPatients"): ?>
		<li class="nav-item">
			<a class="nav-link active" href="index.php?pagina=registerPatients">Cargar Paciente</a>
		</li>
	<?php else: ?>
		<li class="nav-item">
			<a class="nav-link" href="index.php?pagina=registerPatients">Cargar Paciente</a>
		</li>
	<?php endif ?>


	<?php if ($_GET['pagina'] == "registerUser"): ?>
		<li class="nav-item">
			<a class="nav-link active" href="index.php?pagina=registerUser">Cargar usuario</a>
		</li>
	<?php else: ?>
		<li class="nav-item">
			<a class="nav-link" href="index.php?pagina=registerUser">Cargar usuario</a>
		</li>
	<?php endif ?>


	<?php if ($_GET['pagina'] == "index"): ?>
		<li class="nav-item">
			<a class="nav-link active" href="index.php?pagina=index">Index</a>
		</li>
	<?php else: ?>
		<li class="nav-item">
		<a class="nav-link" href="../index.php">Index</a>
		</li>		
	<?php endif ?>


	<?php if ($_GET['pagina'] == "inicio"): ?>
		<li class="nav-item">
			<a class="nav-link active" href="index.php?pagina=inicio">Inicio</a>
		</li>
	<?php else: ?>
		<li class="nav-item">
			<a class="nav-link" href="index.php?pagina=inicio">Inicio</a>
		</li>		
	<?php endif ?>


<?php else: ?>
	<li class="nav-item">
		<a class="nav-link" href="index.php?pagina=registro">Cargar Medico</a>
	</li>	

	<li class="nav-item">
		<a class="nav-link" href="index.php?pagina=inicio">Inicio</a>
	</li>
<?php endif ?>					
</ul>				
</div>
<div class="container-fluid bg-light">
	<div class="container py-5">
		<?php
		if(isset($_GET['pagina'])) {
			if( ($_GET['pagina'] == "registro") || ($_GET['pagina'] == "inicio") ||  ($_GET['pagina'] == "editar") ||  ($_GET['pagina'] == "edit")  || ($_GET['pagina'] == "eliminar")|| ($_GET['pagina'] == "deletePatient") || ($_GET['pagina'] == "registerPatients") || ($_GET['pagina'] == "registerUser") || ($_GET['pagina'] == "index") ) {

				include "paginas/".$_GET['pagina'].".php";		
			}else{
				include "paginas/error404.php";		
			}

		}else{
			include "paginas/inicio.php";	
		}				
		?>
	</div>
</div>
</body>
</html>