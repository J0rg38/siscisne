<?php 
	include "../config/conexion.php";

	$IdMarca= $_POST['IdMarca'];

	$consulta = "SELECT * FROM tblsucsucursal WHERE VmaId = '$IdMarca' OR VmaId2 = '$IdMarca'";

	$resultadoSucursales = mysqli_query($conexion,$consulta);


	
 ?>
 <div class="form-group">
	<label>Sucursal</label>
	<select class="form-control" name="sucursal" id="selectSucursal">
		<option value="todosSucursal">TODOS</option>
		<?php
			while ($dataSucursales = mysqli_fetch_array($resultadoSucursales)) {
		?>
		<option idsuc="<?php echo $dataSucursales['SucId']; ?>" value="<?php echo $dataSucursales['SucSiglas']; ?>"><?php echo utf8_encode($dataSucursales['SucNombre']); ?></option>
		<?php } ?>
	</select>
</div>
		
		<script>
              // OBTENER EL CAMBIO DE VALOR DE SUCURSAL
                $('#selectSucursal').change(function(){
					let valorSucursal = $('option:selected',this).val();
					let IdSucursal    = $('option:selected', this).attr('idsuc');
                    // let idMarca    = $(, this).attr('idsuc');
                    var rutaAsesor="IdSucursal="+IdSucursal;

                    $.ajax({
                        url: 'config/asesores.php',
                        type: 'POST',
                        data: rutaAsesor,
                    })
                    .done(function(res){
                        $('#asesorData').html(res)
                    })
                    
                    console.log(IdSucursal)
                    // console.log(idSucursal)
                });
        </script>