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
////MENSAJES GENERALES
require_once($InsProyecto->MtdRutMensajes().'MsjGeneral.php');
////CLASES GENERALES
require_once($InsProyecto->MtdRutClases().'ClsSesion.php');
require_once($InsProyecto->MtdRutClases().'ClsSesionObjeto.php');
require_once($InsProyecto->MtdRutClases().'ClsMensaje.php');
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
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutFunciones();?>FncGeneral.js"></script>



<!--
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






<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Moneda');?>JsMonedaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('TipoCambio');?>JsTipoCambioFunciones.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs("Producto");?>JsProductoListaPrecioFunciones.js"></script>



<?php

$POST_MonedaId = empty($_POST['CmpMonedaId'])?'MON-10001':$_POST['CmpMonedaId'];
$POST_TipoCambio = $_POST['CmpTipoCambio'];

require_once($InsPoo->MtdPaqAlmacen().'ClsProductoListaPrecio.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsTipoCambio.php');

$InsMoneda = new ClsMoneda();

$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","ASC",NULL);
$ArrMonedas = $ResMoneda['Datos'];




$InsTipoCambio = new ClsTipoCambio();
$InsTipoCambio->MonId = $POST_MonedaId;
$InsTipoCambio->TcaFecha = date("Y-m-d");
	
$InsTipoCambio->MtdObtenerTipoCambioActual();
	
if(empty($InsTipoCambio->TcaId)){
	$InsTipoCambio->MtdObtenerTipoCambioUltimo();
}
		
$POST_TipoCambio = $InsTipoCambio->TcaMontoComercial;
	
?>

<script type="text/javascript">

$(document).ready(function (){

	FncProductoListaPrecioEstablecerMoneda();

});

</script>
<form method="post" enctype="multipart/form-data" onsubmit="FncGuardar();">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
  <td width="10%" align="left" valign="top">
	
    Moneda: 

    
  </td>
  <td width="18%" align="left" valign="top"><select class="EstFormularioCombo" name="CmpMonedaId" id="CmpMonedaId">
    <option value="">Todos</option>
    <?php
			  foreach($ArrMonedas as $DatMoneda){
			  ?>
    <option value="<?php echo $DatMoneda->MonId?>" <?php if($POST_MonedaId==$DatMoneda->MonId){ echo 'selected="selected"';}?> ><?php echo $DatMoneda->MonNombre?> ( <?php echo $DatMoneda->MonSimbolo;?>)</option>
    <?php
			  }
			  ?>
  </select></td>
  <td width="12%" align="left" valign="top">Tipo de Cambio:</td>
  <td width="50%" align="left" valign="top"><table border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td><input name="CmpTipoCambio" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpTipoCambio" value="<?php if (empty($POST_TipoCambio)){ echo "";}else{ echo $POST_TipoCambio; } ?>" size="10" maxlength="10" readonly="readonly" /></td>
      <td><a href="javascript:FncProductoListaPrecioEstablecerMoneda();"><img src="../../../imagenes/recargar.jpg" width="20" height="20" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /></a></td>
    </tr>
  </table></td>
  <td width="10%" align="left" valign="top">&nbsp;</td>
</tr>
<tr>
  <td colspan="5" align="left" valign="top">

	<input type="file" id="CmpArchivo" name="CmpArchivo" />
    
    <input type="hidden" name="MAX_FILE_SIZE" value="5900000" />
	<input  name="BtnEnviar" id="BtnEnviar" type="submit" value="Importar Excel" />

    </td>
</tr>
<tr>
  <td colspan="5" align="left" valign="top">
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
  
  echo $tempFile." a<br>";
  echo $targetFile." a";
  
  $a =  move_uploaded_file($tempFile,$targetFile);
  
		//if ( move_uploaded_file($tempFile,$targetFile)){
		//deb($a);

		if ( $a ){

			$path = $targetFile;
			$ext = pathinfo($path, PATHINFO_EXTENSION);
	
			switch($ext){
		
			case "xls":


				$InsProductoListaPrecio = new ClsProductoListaPrecio();
				
				if(!$InsProductoListaPrecio->MtdEliminarTodoProductoListaPrecio()){
?>
					<span class="EstImportarRegistrarNo">No se pudo vaciar la tabla de disponibilidad.</span><br />
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
						
						if( $aux  == "MATERIAL" ){
							$inicio_columna = $j;
							$inicio_fila = $fila;
							break;
						}
					}
					$fila++;
				}

				

				$fila = 1;
				for ($i = 1; $i <= $data->sheets[0]['numRows']; $i++) {	
					  
					$InsProductoListaPrecio = new ClsProductoListaPrecio();
					  
					$InsProductoListaPrecio->PlpCodigo  = $data->sheets[0]['cells'][$i][$inicio_columna];
					$InsProductoListaPrecio->PlpCodigo  = str_replace("'", "&#8217;", $InsProductoListaPrecio->PlpCodigo);	
					  
					$InsProductoListaPrecio->PlpNombre  = $data->sheets[0]['cells'][$i][$inicio_columna+1];
					$InsProductoListaPrecio->PlpNombre  = str_replace("'", "&#8217;", $InsProductoListaPrecio->PlpNombre);	
					
					$InsProductoListaPrecio->PlpMarca  = $data->sheets[0]['cells'][$i][$inicio_columna+2];
					$InsProductoListaPrecio->PlpMarca  = str_replace("'", "&#8217;", $InsProductoListaPrecio->PlpMarca);	
					  
					$InsProductoListaPrecio->PlpPrecio  = $data->sheets[0]['cells'][$i][$inicio_columna+3];
					$InsProductoListaPrecio->PlpPrecio  = str_replace("'", "&#8217;", $InsProductoListaPrecio->PlpPrecio);	
					
					$InsProductoListaPrecio->PlpTiempoCreacion = date("Y-m-d H:i:s");
					
					
							
	
							
							
					if(!empty($InsProductoListaPrecio->PlpCodigo)){
			
						if($InsProductoListaPrecio->MtdRegistrarProductoListaPrecio()){
			?>
							<span class="EstImportarRegistrarSi">[Fila <?php echo $fila;?>]> <?php echo $InsProductoListaPrecio->PlpCodigo;?>, Se registro correctamente.</span><br />
			<?php
						}else{
			?>
							<span class="EstImportarRegistrarNo">[Fila <?php echo $fila;?>]> <?php echo $InsProductoListaPrecio->PlpCodigo;?>, No se pudo registrar.</span><br />
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

				$InsProductoListaPrecio = new ClsProductoListaPrecio();
				
				if(!$InsProductoListaPrecio->MtdEliminarTodoProductoListaPrecio()){
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
						
						$InsProductoListaPrecio = new ClsProductoListaPrecio();
						
						for( $i=0; $i < $num_cols; $i++ ) {
					
							if($i==$inicio_columna){
								echo $InsProductoListaPrecio->PlpCodigo  = ( (!empty($r[$i])) ? $r[$i] : '' );	
							}
							
							if($i == $inicio_columna + 1){
								$InsProductoListaPrecio->PlpNombre  = ( (!empty($r[$i])) ? $r[$i] : '' );	
							}
						
							if($i == $inicio_columna + 2){
								$InsProductoListaPrecio->PlpMarca  = ( (!empty($r[$i])) ? $r[$i] : '' );	
							}
							
							if($i == $inicio_columna + 3){
								$InsProductoListaPrecio->PlpPrecioReal  = ( (!empty($r[$i])) ? $r[$i] : '' );	
							}
						
						}

						$InsProductoListaPrecio->MonId  = $POST_MonedaId;
						$InsProductoListaPrecio->PlpTipoCambio  = $POST_TipoCambio;	
							
						if($InsProductoListaPrecio->MonId<>$EmpresaMonedaId ){
							$InsProductoListaPrecio->PlpPrecio = $InsProductoListaPrecio->PlpPrecioReal * $InsProductoListaPrecio->PlpTipoCambio;
						}else{
							$InsProductoListaPrecio->PlpPrecio = $InsProductoListaPrecio->PlpPrecioReal;
						}
		

						$InsProductoListaPrecio->PlpEstado = 1;
						$InsProductoListaPrecio->PlpTiempoCreacion = date("Y-m-d H:i:s");
						
						if(!empty($InsProductoListaPrecio->PlpCodigo)){
				
							if($InsProductoListaPrecio->MtdRegistrarProductoListaPrecio()){
				?>
								<span class="EstImportarRegistrarSi">[Fila <?php echo $fila;?>]> <?php echo $InsProductoListaPrecio->PlpCodigo;?>, Se registro correctamente.</span><br />
				<?php
							}else{
				?>
								<span class="EstImportarRegistrarNo">[Fila <?php echo $fila;?>]> <?php echo $InsProductoListaPrecio->PlpCodigo;?>, No se pudo registrar.</span><br />
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