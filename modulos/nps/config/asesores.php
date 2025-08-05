<?php 
	include "../config/conexion.php";

	$sucId = $_POST['IdSucursal'];

	$consulta = "SELECT * FROM tblperpersonal WHERE PerVenta = 1 AND PerEstado = 1 AND SucId = '".$sucId."'";

	$resultadoAsesores = mysqli_query($conexion,$consulta);

	
 ?>
 <div class="form-group">
	<label>Asesor de Ventas</label>
	<select class="form-control" name="asesor" id="selectAsesor">
		<option value="todosAsesor">TODOS</option>
		<?php
			while ($dataAsesores = mysqli_fetch_array($resultadoAsesores)) {
		?>
		<option value="<?php echo $dataAsesores['PerId']; ?>"><?php echo utf8_encode($dataAsesores['PerNombre']." ".$dataAsesores['PerApellidoPaterno']." ".$dataAsesores['PerApellidoMaterno']); ?></option>
		<?php } ?>
	</select>
</div>