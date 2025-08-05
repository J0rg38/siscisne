<?php
session_start();
require_once('../../../proyecto/ClsProyecto.php');
require_once('../../../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../../../';
$InsPoo->Ruta = '../../../';

/*
*Clases de Conexion
*/
require_once($InsProyecto->MtdRutConexiones().'ClsConexion.php');
require_once($InsProyecto->MtdRutClases().'ClsMysql.php');
/*
*Funciones
*/
require_once($InsProyecto->MtdRutFunciones().'FncGeneral.php');
?>

<!--
Libreria leer excel
-->
<?php require_once($InsProyecto->MtdRutLibrerias().'excel/OLERead.php');?>
<?php require_once($InsProyecto->MtdRutLibrerias().'excel/reader.php');?>

<?php
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngreso.php');
?>
	<form method="post" enctype="multipart/form-data">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
  <td align="left" valign="top">

	<input type="file" id="CmpArchivo" name="CmpArchivo" />
	<input name="BtnEnviar" id="BtnEnviar" type="submit" value="Importar Excel" />

  
  </td>
</tr>
<tr>
	<td align="left" valign="top">


</td>
  </tr>
<tr>
  <td align="left" valign="top">
    <?php
if (!empty($_FILES)) {
	$tempFile = $_FILES['CmpArchivo']['tmp_name'];
	$file_name = strtolower($_FILES['CmpArchivo']['name']);	
	$targetPath = '../../../subidos/vehiculos/';
	$targetFile =  str_replace('//','/',$targetPath) . date("d-m-Y").'_P_'.($file_name);	
?>
Nombre de Archivo: <?php echo $file_name;?><br />
<?php
	if (move_uploaded_file($tempFile,$targetFile)){

		$data = new Spreadsheet_Excel_Reader();	
		$data->setOutputEncoding('CP1251');				
		$data->read($targetFile);

		$fila = 1;
		$InsVehiculoIngreso = new ClsVehiculoIngreso();

		for ($i = 2; $i <= $data->sheets[0]['numRows']; $i++) {	

			$InsVehiculoIngreso->VcaId = "VCA-10000";

			$InsVehiculoIngreso->EinCodigoSAP  = $data->sheets[0]['cells'][$i][2];
			$InsVehiculoIngreso->EinCodigoSAP  = str_replace("'", "&#8217;", $InsVehiculoIngreso->EinCodigoSAP);	
	
			$InsVehiculoIngreso->EinModelo  = $data->sheets[0]['cells'][$i][3];
			$InsVehiculoIngreso->EinModelo  = str_replace("'", "&#8217;", $InsVehiculoIngreso->EinModelo);	
			
			$InsVehiculoIngreso->EinTransmision  = $data->sheets[0]['cells'][$i][4];
			$InsVehiculoIngreso->EinTransmision  = str_replace("'", "&#8217;", $InsVehiculoIngreso->EinTransmision);	
	
			$InsVehiculoIngreso->EinColor  = $data->sheets[0]['cells'][$i][5];
			$InsVehiculoIngreso->EinColor  = str_replace("'", "&#8217;", $InsVehiculoIngreso->EinColor);	
	
			$InsVehiculoIngreso->EinColorAduana  = $data->sheets[0]['cells'][$i][6];
			$InsVehiculoIngreso->EinColorAduana  = str_replace("'", "&#8217;", $InsVehiculoIngreso->EinColorAduana);	
	
			$InsVehiculoIngreso->EinVIN  = $data->sheets[0]['cells'][$i][7];
			$InsVehiculoIngreso->EinVIN  = str_replace("'", "&#8217;", $InsVehiculoIngreso->EinVIN);	
	
			$InsVehiculoIngreso->EinNumeroMotor  = $data->sheets[0]['cells'][$i][8];
			$InsVehiculoIngreso->EinNumeroMotor  = str_replace("'", "&#8217;", $InsVehiculoIngreso->EinNumeroMotor);	
	
			$InsVehiculoIngreso->EinAnoFabricacion  = $data->sheets[0]['cells'][$i][9];
			$InsVehiculoIngreso->EinAnoFabricacion  = str_replace("'", "&#8217;", $InsVehiculoIngreso->EinAnoFabricacion);	
	
			$InsVehiculoIngreso->EinAnoMY  = $data->sheets[0]['cells'][$i][10];
			$InsVehiculoIngreso->EinAnoMY  = str_replace("'", "&#8217;", $InsVehiculoIngreso->EinAnoMY);	
	
			$InsVehiculoIngreso->EinFechaLlegadaEmbarque  = $data->sheets[0]['cells'][$i][11];
			$InsVehiculoIngreso->EinFechaLlegadaEmbarque  = str_replace("'", "&#8217;", $InsVehiculoIngreso->EinFechaLlegadaEmbarque);	
			$InsVehiculoIngreso->EinFechaLlegadaEmbarque = FncCambiaFechaAMysql($InsVehiculoIngreso->EinFechaLlegadaEmbarque,true);
	
			$InsVehiculoIngreso->EinPrecioDealer  = $data->sheets[0]['cells'][$i][12];
			$InsVehiculoIngreso->EinPrecioDealer  = str_replace("'", "&#8217;", $InsVehiculoIngreso->EinPrecioDealer);	
	
			$InsVehiculoIngreso->EinPrecioIGV  = $data->sheets[0]['cells'][$i][13];
			$InsVehiculoIngreso->EinPrecioIGV  = str_replace("'", "&#8217;", $InsVehiculoIngreso->EinPrecioIGV);	
	
			$InsVehiculoIngreso->EinDealer  = $data->sheets[0]['cells'][$i][14];
			$InsVehiculoIngreso->EinDealer  = str_replace("'", "&#8217;", $InsVehiculoIngreso->EinDealer);	
	
			$InsVehiculoIngreso->EinPedido  = $data->sheets[0]['cells'][$i][15];
			$InsVehiculoIngreso->EinPedido  = str_replace("'", "&#8217;", $InsVehiculoIngreso->EinPedido);	
	
			$InsVehiculoIngreso->EinTipo = 1;
			$InsVehiculoIngreso->EinEstado = 1;
			$InsVehiculoIngreso->EinTiempoCreacion = date("Y-m-d H:i:s");
			$InsVehiculoIngreso->EinTiempoModificacion = date("Y-m-d H:i:s");
			$InsVehiculoIngreso->EinEliminado = 1;		
	
			if(!empty($InsVehiculoIngreso->EinVIN)){

				$InsVehiculoIngreso->MtdVerificarExisteVehiculoIngreso();

				if(empty($InsVehiculoIngreso->EinId)){
					
					if(!$InsVehiculoIngreso->MtdRegistrarVehiculoIngreso()){
?>
						Fila No. <b><?php echo $i;?></b>: <b><?php echo $InsVehiculoIngreso->EinVIN;?></b> No se pudo registrar. <br />
<?php
					}else{
?>
						Fila No. <b><?php echo $i;?></b>: <b><?php echo $InsVehiculoIngreso->EinVIN;?></b> Se registro correctamente. <br />
<?php
					}
				}else{
?>
					Fila No. <b><?php echo $i;?></b>: <b><?php echo $InsVehiculoIngreso->EinVIN;?></b> ya se encuentra registrado. <br />
<?php				
				}
			}else{
?>
				Fila No. <b><?php echo $i;?></b>: <b><?php echo $InsVehiculoIngreso->EinVIN;?></b> no se identifico codigo VIN. <br />
<?php	
			}

?>
<hr />
<?php					
				$fila++;
			}			

		} else {
?>
		Hubo un error al subir el archivo
<?php		
		}

	
}
?></td>
</tr>
</table>

	</form>



