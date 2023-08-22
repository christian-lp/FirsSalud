<?php 
$listado = ControladorFormularios::ctrSelectRegistros();
//var_dump($listado);
?>
<table class="table table-striped">
	<h3>MEDICOS</h3>
	<thead>
		<tr>
			<th>Matricula</th>
			<th>Nombre</th>
			<th>Apellido</th>
			<th>Genero</th>	
			<th>Fecha</th>	
			<th>Email</th>
			<th>Telefono</th>	
			<th>Especialidad</th>
			<th>Acciones</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($listado as $value): ?>
			<tr>
				<td><?php echo $value['matricul'] ?></td>
				<td><?php echo $value['name'] ?></td>
				<td><?php echo $value['surname'] ?></td>
				<td><?php echo $value['gender_name'] ?></td>
				<td><?php echo $value['day_of_birth'] ?></td>
				<td><?php echo $value['email'] ?></td>
				<td><?php echo $value['phone'] ?></td>
				<td><?php echo $value['specialty_name'] ?></td>
				<td>
					<div class="btn-group">
						<div class="px-1">
							<a href="index.php?pagina=editar&id=<?php echo $value['medic_id']; ?>" class="btn btn-warning"><i class="fas fa-edit"> </i></a>	
						</div><div class="px-1">
							<a href="index.php?pagina=eliminar&id=<?php echo $value['medic_id']; ?>" class="btn btn-danger"><i class="fas fa-trash-alt"> </i></a>	
						</div>						
					</div>
				</td>
			</tr>
		<?php endforeach ?>		
	</tbody>
</table>


<?php 
$listado = ControladorFormularios::ctrSelectRegistrosPatients();
//var_dump($listado);
?>
<table class="table table-striped">
	<h3>PACIENTES</h3>
	<thead>
		<tr>
			<th>Dni</th>
			<th>Nombre</th>
			<th>Apellido</th>
			<th>Genero</th>	
			<th>Fecha</th>	
			<th>Email</th>
			<th>Telefono</th>	
			<th>Acciones</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($listado as $value): ?>
			<tr>
				<td><?php echo $value['dni'] ?></td>
				<td><?php echo $value['name'] ?></td>
				<td><?php echo $value['surname'] ?></td>
				<td><?php echo $value['gender_name'] ?></td>
				<td><?php echo $value['day_of_birth'] ?></td>
				<td><?php echo $value['email'] ?></td>
				<td><?php echo $value['phone'] ?></td>
				<td>
					<div class="btn-group">
						<div class="px-1">
							<a href="index.php?pagina=edit&id=<?php echo $value['patient_id']; ?>" class="btn btn-warning"><i class="fas fa-edit"> </i></a>	
						</div><div class="px-1">
							<a href="index.php?pagina=deletePatient&id=<?php echo $value['patient_id']; ?>" class="btn btn-danger"><i class="fas fa-trash-alt"> </i></a>	
						</div>						
					</div>
				</td>
			</tr>
		<?php endforeach ?>		
	</tbody>
</table>


<?php 
$listado = ControladorFormularios::ctrSelectRegistrosPatients();
//var_dump($listado);
?>
<table class="table table-striped">
	<h3>USUARIOS</h3>
	<thead>
		<tr>
			<th>Dni</th>
			<th>Nombre</th>
			<th>Apellido</th>
			<th>Genero</th>	
			<th>Fecha</th>	
			<th>Email</th>
			<th>Telefono</th>	
			<th>Acciones</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($listado as $value): ?>
			<tr>
				<td><?php echo $value['dni'] ?></td>
				<td><?php echo $value['name'] ?></td>
				<td><?php echo $value['surname'] ?></td>
				<td><?php echo $value['gender_name'] ?></td>
				<td><?php echo $value['day_of_birth'] ?></td>
				<td><?php echo $value['email'] ?></td>
				<td><?php echo $value['phone'] ?></td>
				<td>
					<div class="btn-group">
						<div class="px-1">
							<a href="index.php?pagina=edit&id=<?php echo $value['patient_id']; ?>" class="btn btn-warning"><i class="fas fa-edit"> </i></a>	
						</div><div class="px-1">
							<a href="index.php?pagina=deletePatient&id=<?php echo $value['patient_id']; ?>" class="btn btn-danger"><i class="fas fa-trash-alt"> </i></a>	
						</div>						
					</div>
				</td>
			</tr>
		<?php endforeach ?>		
	</tbody>
</table>