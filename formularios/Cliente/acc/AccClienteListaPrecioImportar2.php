<?php
session_start();
require_once('../../../proyecto/ClsProyecto.php');
require_once('../../../proyecto/ClsPoo.php');

$InsPoo->Ruta= '../../../';
$InsProyecto->Ruta= '../../../';

////CONFIGURACIONES GENERALES
require_once($InsProyecto->MtdRutConfiguraciones().'CnfSistema.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfEmpresa.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfConexion.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfNotificacion.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfFormularioNota.php');
////MENSAJES GENERALES
require_once($InsProyecto->MtdRutMensajes().'MsjGeneral.php');
////CLASES GENERALES
require_once($InsProyecto->MtdRutClases().'ClsSesion.php');
require_once($InsProyecto->MtdRutClases().'ClsSesionObjeto.php');
require_once($InsProyecto->MtdRutClases().'ClsMensaje.php');
require_once($InsProyecto->MtdRutLibrerias().'PHPMailer_5.2.4/class.phpmailer.php');
require_once($InsProyecto->MtdRutClases().'ClsCorreo.php');

////CLASES GENERALES
require_once($InsProyecto->MtdRutConexiones().'ClsConexion.php');
require_once($InsProyecto->MtdRutClases().'ClsMysql.php');
////FUNCIONES GENERALES
require_once($InsProyecto->MtdRutFunciones().'FncGeneral.php');


require_once($InsPoo->MtdPaqConfiguracion().'ClsConfiguracionEmpresa.php');

$InsConfiguracionEmpresa = new ClsConfiguracionEmpresa();
$InsConfiguracionEmpresa->CemId = "CEM-10000";
$InsConfiguracionEmpresa->MtdObtenerConfiguracionEmpresa();	

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">


<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<!--
Estilos
-->
<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssGeneral.css">

<!--
Nombre: JQUERY
Descripcion: 
-->
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.7.2.min.js"></script>

<!--
Funciones Generales
-->
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutFunciones();?>FncGeneral.js"></script><!--
Libreria leer excel
-->
<?php require_once($InsProyecto->MtdRutLibrerias().'excel/OLERead.php');?>
<?php require_once($InsProyecto->MtdRutLibrerias().'excel/reader.php');?>
<?php require_once($InsProyecto->MtdRutLibrerias().'simplexlsx.class.php');?>
</head>


<body>


<script type="text/javascript">

//Pasando variables genrales PHP a Javascript	

var CalificacionCosto = <?php echo empty($InsConfiguracionEmpresa->CalCosto)?0:$InsConfiguracionEmpresa->CalCosto;?>;
var CalificacionTipoCambio = <?php echo empty($InsConfiguracionEmpresa->CalTipoCambio)?0:$InsConfiguracionEmpresa->CalTipoCambio;?>;
var CalificacionMargen = <?php echo empty($InsConfiguracionEmpresa->CalMargen)?0:$InsConfiguracionEmpresa->CalMargen;?>;

var MonedaSimbolo = "<?php echo $InsConfiguracionEmpresa->MonSimbolo;?>";
var EmpresaMonedaId = "<?php echo $InsConfiguracionEmpresa->MonId;?>";
var FechaHoy = "<?php echo date("d/m/Y");?>";


var Ruta = "<?php echo $InsProyecto->Ruta; ?>";
		 
var RutLibrerias = "librerias/";
var RutComunes = "comunes/";

</script>



<?php

deb($_POST);

$POST_MonedaId = empty($_POST['CmpMonedaId'])?'MON-10001':$_POST['CmpMonedaId'];
$POST_TipoCambio = $_POST['CmpTipoCambio'];
$POST_ClienteId = $_POST['CmpClienteId'];
$POST_Fecha = $_POST['CmpFecha'];

if(empty($POST_ClienteId)){
	exit("No ha escogido un cliente");
}

if(empty($POST_MonedaId)){
	exit("No ha escogido una moneda");
}

if($POST_MonedaId<>$EmpresaMonedaId){
	if(empty($POST_TipoCambio)){
		exit("No ha ingresad el tipo de cambio");
	}
}


require_once($InsPoo->MtdPaqLogistica().'ClsCliente.php');
require_once($InsPoo->MtdPaqLogistica().'ClsClienteListaPrecio.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsTipoCambio.php');

$InsMoneda = new ClsMoneda();
$InsMoneda->MonId = $POST_MonedaId;
$InsMoneda->MtdObtenerMoneda();

$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","ASC",NULL,1);
$ArrMonedas = $ResMoneda['Datos'];

$InsTipoCambio = new ClsTipoCambio();
$InsTipoCambio->MonId = $POST_MonedaId;
$InsTipoCambio->TcaFecha = date("Y-m-d");

$InsTipoCambio->MtdObtenerTipoCambioActual();


if(empty($InsTipoCambio->TcaId)){
	$InsTipoCambio->MtdObtenerTipoCambioUltimo();
}

$POST_TipoCambio = $InsTipoCambio->TcaMontoComercial;

$InsCliente = new ClsCliente();
$InsCliente->CliId = $POST_ClienteId;
$InsCliente->MtdObtenerCliente();
	
?><!-- onsubmit="FncGuardar();" -->

<form name="ClienteListaPrecioImportar" id="ClienteListaPrecioImportar" method="POST" enctype="multipart/form-data" action="AccClienteListaPrecioImportar.php">

<table class="EstFormulario" width="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
  <td width="13%" align="left" valign="top" class="EstFormularioEtiqueta">Cliente escogido:</td>
  <td width="39%" align="left" valign="top" class="EstFormularioContenido"><?php echo $InsCliente->CliNombreCompleto;?></td>
  <td width="7%" align="left" valign="top" class="EstFormularioEtiqueta">Moneda:</td>
  <td width="17%" align="left" valign="top" class="EstFormularioContenido"><?php echo $InsMoneda->MonNombre;?></td>
  <td width="5%" align="left" valign="top" class="EstFormularioEtiqueta">T.C.:</td>
  <td width="3%" align="left" valign="top" class="EstFormularioContenido"><?php echo $POST_TipoCambio;?></td>
  <td width="16%" align="left" valign="top">&nbsp;</td>
</tr>
<tr>
  <td colspan="7" align="left" valign="top">
    

<input name="CmpClienteId" type="text" id="CmpClienteId" value="<?php echo $InsCliente->CliId;?>" size="3" />
<input name="CmpFecha" type="hidden" id="CmpFecha" value="<?php echo date("d/m/Y");?>" size="3" />
<input name="CmpMonedaId" type="hidden" id="CmpMonedaId" value="<?php echo $InsMoneda->MonId;?>" size="3" />
<input name="CmpTipoCambio" type="hidden" id="CmpTipoCambio" value="<?php echo $POST_TipoCambio;?>" size="3" />


	<input type="file" id="CmpArchivo" name="CmpArchivo" />
    
    <input type="hidden" name="MAX_FILE_SIZE" value="5900000" />
    <input  name="BtnEnviar" id="BtnEnviar" type="submit" value="Importar Excel" />
    
    </td>
</tr>
<tr>
  <td colspan="7" align="left" valign="top">
    <?php
	
//	deb($_FILES);
	
if (!empty($_FILES)) {
	$tempFile = $_FILES['CmpArchivo']['tmp_name'];
	//$file_name = strtolower($_FILES['CmpArchivo']['name']);	
	$file_name = iconv("UTF-8","WINDOWS-1251",$_FILES['CmpArchivo']['name']);
	$targetPath = '../../../subidos/producto_excel/';

	$targetFile =  str_replace('//','/',$targetPath) . ($file_name);	
	
	$ext = pathinfo($targetFile, PATHINFO_EXTENSION);
	$file_name = date("d-m-Y")."_ARCHIVO1_".$Identificador.".".$ext;
	
	$targetFile =  str_replace('//','/',$targetPath) . $file_name;	
	
	
	
//	$targetFile =  str_replace('//','/',$targetPath) . date("d-m-Y").'_P_'.(($file_name));	
?>
    Nombre de Archivo: <?php echo $file_name;?><br />
  <?php
  
 // echo $tempFile." a<br>";
 // echo $targetFile." a";
  
  $a =  move_uploaded_file($tempFile,$targetFile);
  
		//if ( move_uploaded_file($tempFile,$targetFile)){
		//deb($a);

		if ( $a ){

			$path = $targetFile;
			$ext = pathinfo($path, PATHINFO_EXTENSION);
	
			switch($ext){
		
			case "xls":

				$InsClienteListaPrecio = new ClsClienteListaPrecio();
				
				if(!$InsClienteListaPrecio->MtdEliminarTodoClienteListaPrecio($InsCliente->CliId)){
?>
					<span class="EstImportarRegistrarNo">No se pudo vaciar la tabla de precios de cliente.</span><br />
<?php					
				}

				$data = new Spreadsheet_Excel_Reader();	
				$data->setOutputEncoding('CP1251');				
				$data->read($targetFile);
				
				$fila = 0;
				$inicio_fila = 0;
				$inicio_columna = 0;
				
				for ($i = 1; $i <= $data->sheets[0]['numRows']; $i++) {	

					for($j = 1; $j<20; $j++){

						$aux  = $data->sheets[0]['cells'][$i][$j];
						$aux  = str_replace("'", "&#8217;", $aux);	
						
						if( strtoupper($aux)  == "MATERIAL" ){
							$inicio_columna = $j;
							$inicio_fila = $fila;
							break;
						}
					}
					$fila++;
				}

				
?>
<b>Ubicacion de Cabecera <?php echo $inicio_columna." - ".$inicio_fila;?></b>
<hr/>

<?php
				$fila = 1;
				for ($i = 1; $i <= $data->sheets[0]['numRows']; $i++) {	
					  
					$InsClienteListaPrecio = new ClsClienteListaPrecio();
					
					$InsClienteListaPrecio->CliId  = $InsCliente->CliId;
					$InsClienteListaPrecio->MonId  = $POST_MonedaId;
					$InsClienteListaPrecio->ClpTipoCambio  = $POST_TipoCambio;	

					$InsClienteListaPrecio->ClpCodigo  = $data->sheets[0]['cells'][$i][$inicio_columna];
					$InsClienteListaPrecio->ClpCodigo  = str_replace("'", "&#8217;", $InsClienteListaPrecio->ClpCodigo);	
					  
					$InsClienteListaPrecio->ClpNombre  = $data->sheets[0]['cells'][$i][$inicio_columna+1];
					$InsClienteListaPrecio->ClpNombre  = str_replace("'", "&#8217;", $InsClienteListaPrecio->ClpNombre);	
					
					$InsClienteListaPrecio->ClpMarca  = $data->sheets[0]['cells'][$i][$inicio_columna+2];
					$InsClienteListaPrecio->ClpMarca  = str_replace("'", "&#8217;", $InsClienteListaPrecio->ClpMarca);	
					  
					$InsClienteListaPrecio->ClpPrecioReal  = $data->sheets[0]['cells'][$i][$inicio_columna+3];
					$InsClienteListaPrecio->ClpPrecioReal  = str_replace("'", "&#8217;", $InsClienteListaPrecio->ClpPrecioReal);	

					if($InsClienteListaPrecio->MonId<>$EmpresaMonedaId ){
						$InsClienteListaPrecio->ClpPrecio = $InsClienteListaPrecio->ClpPrecioReal * $InsClienteListaPrecio->ClpTipoCambio;
					}else{
						$InsClienteListaPrecio->ClpPrecio = $InsClienteListaPrecio->ClpPrecioReal;
					}
					
					$InsClienteListaPrecio->ClpEstado = 1;
					$InsClienteListaPrecio->ClpTiempoCreacion = date("Y-m-d H:i:s");
					

					if(!empty($InsClienteListaPrecio->ClpCodigo)){
			
						if($InsClienteListaPrecio->MtdRegistrarClienteListaPrecio()){
			?>
							<span class="EstImportarRegistrarSi">[Fila <?php echo $fila;?>]> <?php echo $InsClienteListaPrecio->ClpCodigo;?>, Se registro correctamente.</span><br />
			<?php
						}else{
			?>
							<span class="EstImportarRegistrarNo">[Fila <?php echo $fila;?>]> <?php echo $InsClienteListaPrecio->ClpCodigo;?>, No se pudo registrar.</span><br />
			<?php	
						}
									
					}else{
			?>
						<span class="EstImportarRegistrarNo">[Fila <?php echo $fila;?>]> No se pudo registrar, codigo vacio</span><br />
			<?php
					}
			
					?>
					
					<hr />
					<?php					
					  $fila++;
					}			
			


			break;
			
			case "xlsx":

				$InsClienteListaPrecio = new ClsClienteListaPrecio();
				
				if(!$InsClienteListaPrecio->MtdEliminarTodoClienteListaPrecio()){
?>
					<span class="EstImportarRegistrarNo">No se pudo vaciar la tabla de lista de precios.</span><br />
<?php					
				}
				
				$xlsx = new SimpleXLSX($targetFile); 

				list($num_cols, $num_rows) = $xlsx->dimension(); 

				$fila = 0;
				$inicio_fila = 0;
				$inicio_columna = 0;

				foreach( $xlsx->rows() as $r ) { 

					for( $i = 0; $i < $num_cols; $i++ ) {

						if( strtoupper($r[$i]) == "MATERIAL" ){
							$inicio_columna = $i;
							$inicio_fila = $fila;
							break;
						}

					}
					$fila++;
				}

?>

				<b>Ubicacion de Cabecera <?php echo $inicio_columna." - ".$inicio_fila;?></b>
<hr/>
<?php		

		
			//exit();
				$fila = 1;
				foreach( $xlsx->rows() as $r ) { 
					
					if($inicio_fila <= $fila){
						
						$InsClienteListaPrecio = new ClsClienteListaPrecio();
						
						for( $i=0; $i < $num_cols; $i++ ) {
					
							if($i==$inicio_columna){
								echo $InsClienteListaPrecio->ClpCodigo  = ( (!empty($r[$i])) ? $r[$i] : '' );	
							}
							
							if($i == $inicio_columna + 1){
								$InsClienteListaPrecio->ClpNombre  = ( (!empty($r[$i])) ? $r[$i] : '' );	
							}
						
							if($i == $inicio_columna + 2){
								$InsClienteListaPrecio->ClpMarca  = ( (!empty($r[$i])) ? $r[$i] : '' );	
							}
							
							if($i == $inicio_columna + 3){
								$InsClienteListaPrecio->ClpPrecioReal  = ( (!empty($r[$i])) ? $r[$i] : '' );	
							}
						
						}
						
						$InsClienteListaPrecio->CliId  = $InsCliente->CliId;
						$InsClienteListaPrecio->MonId  = $POST_MonedaId;
						$InsClienteListaPrecio->ClpTipoCambio  = $POST_TipoCambio;	
							
						if($InsClienteListaPrecio->MonId<>$EmpresaMonedaId ){
							$InsClienteListaPrecio->ClpPrecio = $InsClienteListaPrecio->ClpPrecioReal * $InsClienteListaPrecio->ClpTipoCambio;
						}else{
							$InsClienteListaPrecio->ClpPrecio = $InsClienteListaPrecio->ClpPrecioReal;
						}
		

						$InsClienteListaPrecio->ClpEstado = 1;
						$InsClienteListaPrecio->ClpTiempoCreacion = date("Y-m-d H:i:s");
						
						if(!empty($InsClienteListaPrecio->ClpCodigo)){
				
							if($InsClienteListaPrecio->MtdRegistrarClienteListaPrecio()){
				?>
								<span class="EstImportarRegistrarSi">[Fila <?php echo $fila;?>]> <?php echo $InsClienteListaPrecio->ClpCodigo;?>, Se registro correctamente.</span><br />
				<?php
							}else{
				?>
								<span class="EstImportarRegistrarNo">[Fila <?php echo $fila;?>]> <?php echo $InsClienteListaPrecio->ClpCodigo;?>, No se pudo registrar.</span><br />
				<?php	
							}
										
						}else{
				?>
							<span class="EstImportarRegistrarNo">[Fila <?php echo $fila;?>]> No se pudo registrar, codigo vacio</span><br />
				<?php
						}
					
						
				?>
				
				<hr />
				<?php	
					}
						
					 $fila++;
				} 
				

			break;
			
			default:
			
			break;
			
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
</body></html>