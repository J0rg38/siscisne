<?php 
	date_default_timezone_set('America/Lima');
	error_reporting(0);

	$FechaActual = date('Y-m-d H:i:s');

	$servidor="localhost";
	$user="root";
	$password = "";
	$database = "siscisne10";

	$conexion = mysqli_connect($servidor,$user,$password,$database);

	$codigogarantia = $_POST['codigogarantia'];

	$consulta = "
		SELECT
		tblfinfichaingreso.FinId, 
		tblfinfichaingreso.FinId2, 
		tblclicliente.CliNombreCompleto, 
		tblclicliente.CliNombre, 
		tblclicliente.CliApellidoPaterno, 
		tblclicliente.CliApellidoMaterno, 
		tblclicliente.CliNumeroDocumento, 
		tblclicliente.CliDireccion, 
		tbleinvehiculoingreso.EinPlaca, 
		tbleinvehiculoingreso.EinVIN, 
		tblfinfichaingreso.FinPlaca, 
		tblfinfichaingreso.FinVehiculoKilometraje, 
		tblvmovehiculomodelo.VmoNombre, 
		tblvmavehiculomarca.VmaNombre, 
		tbleinvehiculoingreso.EinColor,
		tblfinfichaingreso.FinFecha
		FROM
			tblfinfichaingreso
			INNER JOIN
			tblclicliente
			ON 
				tblfinfichaingreso.CliId = tblclicliente.CliId
			INNER JOIN
			tbleinvehiculoingreso
			ON 
				tblfinfichaingreso.EinId = tbleinvehiculoingreso.EinId
			INNER JOIN
			tblvvevehiculoversion
			ON 
				tbleinvehiculoingreso.VveId = tblvvevehiculoversion.VveId
			INNER JOIN
			tblvmovehiculomodelo
			ON 
				tblvvevehiculoversion.VmoId = tblvmovehiculomodelo.VmoId
			INNER JOIN
			tblvmavehiculomarca
			ON 
				tblvmovehiculomodelo.VmaId = tblvmavehiculomarca.VmaId
		WHERE
			tblfinfichaingreso.FinId2 = '".$codigogarantia."'
	";

	$resultado = mysqli_query($conexion,$consulta);

	while($data = mysqli_fetch_array($resultado)){
 ?>
 	<div class="col-6" style="border-color: black; border-width: 1px; border-style: solid;">
		<h6>PLACA: <?php 
			if($data['FinPlaca'] == ''){
				echo $data['EinPlaca']; 
			}else{
				echo $data['FinPlaca'];
			}
		?></h6>
		<h6>CHASIS: <?php echo $data['EinVIN']; ?></h6>
		<h6>KILOMETRAJE: <?php echo $data['FinVehiculoKilometraje']; ?></h6>
		<h6>FECHA: <?php echo date("d/m/Y", strtotime($data['FinFecha'])); ?></h6>
	</div>
	<div class="col-6" style="border-color: black; border-width: 1px; border-style: solid;">
		<h6>PROPIETARIO: <?php echo $data['CliNombreCompleto']; ?></h6>
		<h6>DOCUMENTO: <?php echo $data['CliNumeroDocumento']; ?></h6>
		<h6>DIRECCION: <?php echo $data['CliDireccion']; ?></h6>
	</div>
	<div class="col-12" style="border-color: black; border-width: 1px; border-style: solid;">
		<h6>MARCA: <?php echo $data['VmaNombre']; ?></h6>
		<h6>MODELO: <?php echo $data['VmoNombre']; ?></h6>
		<h6>COLOR: <?php echo $data['EinColor']; ?></h6>
	</div>

 <?php 
	}
 ?>












