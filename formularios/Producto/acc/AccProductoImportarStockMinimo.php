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
$POST_ListaNueva = $_POST['CmpListaNueva'];

require_once($InsPoo->MtdPaqAlmacen().'ClsProductoListaPrecio.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProducto.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsTipoCambio.php');

$InsMoneda = new ClsMoneda();
$InsProducto = new ClsProducto();


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
	
?>

<script type="text/javascript">

$(document).ready(function (){

	FncProductoListaPrecioEstablecerMoneda();

});

</script>
<form method="post" enctype="multipart/form-data" onsubmit="FncGuardar();">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
  <td width="100%" colspan="5" align="left" valign="top">
    
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
	$file_name_original = iconv("UTF-8","WINDOWS-1251",$_FILES['CmpArchivo']['name']);
	$targetPath = '../../../subidos/producto_excel/';

	$targetFile =  str_replace('//','/',$targetPath) . ($file_name_original);	
	
	$ext = pathinfo($targetFile, PATHINFO_EXTENSION);
	$file_name = date("d-m-Y")."_ARCHIVO1_".$Identificador.".".$ext;
	
	$targetFile =  str_replace('//','/',$targetPath) . $file_name;	
	
	
//	$targetFile =  str_replace('//','/',$targetPath) . date("d-m-Y").'_P_'.(($file_name));	
?>
       Nombre de Archivo: <?php echo $file_name;?><br />
    Nombre de Archivo Original: <?php echo $file_name_original;?><br />
	Nombre de Archivo Temporal: <?php echo $tempFile;?><br />
    Nombre de Archivo Destino: <?php echo $targetFile;?><br />
    
  <?php
  
 // echo $tempFile." a<br>";
  //echo $targetFile." a";
  
  $a =  move_uploaded_file($tempFile,$targetFile);
  
		//if ( move_uploaded_file($tempFile,$targetFile)){
		//deb($a);

		if ( $a ){

			$path = $targetFile;
			$ext = pathinfo($path, PATHINFO_EXTENSION);
	
			switch($ext){
		
			case "xlsx":

				$InsProducto = new ClsProductoListaPrecio();
				
				if($POST_ListaNueva=="1"){
					if(!$InsProducto->MtdEliminarTodoProductoListaPrecio()){
	?>
						<span class="EstImportarRegistrarNo">No se pudo vaciar la tabla de lista de precios.</span><br />
	<?php					
					}
				}
				
				$xlsx = new SimpleXLSX($targetFile); 

				list($num_cols, $num_rows) = $xlsx->dimension(); 

				$fila = 0;
		
?>

				
<?php		

		
			//exit();
				$fila = 1;
				foreach( $xlsx->rows() as $r ) { 
					
					if($inicio_fila <= $fila){
						
						$InsProducto = new ClsProducto();
						
						$Codigo = "";
						$Nombre = "";
						$Marca = "";
						$StockMinimo = 0;
						
						for( $i=0; $i < $num_cols; $i++ ) {
					
							if($i==0){
								$Codigo  = ( (!empty($r[$i])) ? $r[$i] : '' );	
								$Codigo = trim($Codigo);
							}
							
							if($i == 1){
								$Nombre  = ( (!empty($r[$i])) ? $r[$i] : '' );	
								$Nombre = trim($Nombre);
							}
						
							if($i == 2){
								$StockMinimo  = ( (!empty($r[$i])) ? $r[$i] : '' );	
								$StockMinimo = trim($StockMinimo);
							
								
							}
						
						}
						 
						
						if(!empty($Codigo)){
							
							
							$ProductoId = "";
							
							$ProductoId = $InsProducto->MtdIdentificarProductoCampo("ProCodigoOriginal",$Codigo);
//							deb($ProductoId);
							
							
							$InsProducto->ProId  = $ProductoId;
							$InsProducto->ProStockMinimo  = $StockMinimo;
							$InsProducto->ProTiempoModificacion = date("Y-m-d H:i:s");
							
							if(!empty($InsProducto->ProId)){
					
								if($InsProducto->MtdEditarProductoStockMinimo()){
									
									
					?>
									<span class="EstImportarRegistrarSi">[Fila <?php echo $fila;?>]> <?php echo $Codigo;?> [<?php echo $ProductoId;?>], Se registro correctamente.</span><br />
					<?php
								}else{
					?>
									<span class="EstImportarRegistrarNo">[Fila <?php echo $fila;?>]> <?php echo $Codigo;?>  [<?php echo $ProductoId;?>], No se pudo registrar.</span><br />
					<?php	
								}
											
							}else{
					?>
								<span class="EstImportarRegistrarNo">[Fila <?php echo $fila;?>]> No se pudo registrar, codigo no identificado  / Codigo: <?php echo $Codigo;?> Nombre: <?php echo $Nombre;?> Stk. Min.: <?php echo $StockMinimo;?></span><br />
					<?php
							}
							
							
							
						}else{
					?>
								<span class="EstImportarRegistrarNo">[Fila <?php echo $fila;?>]> No se pudo registrar, codigo vacio / Codigo: <?php echo $Codigo;?> Nombre: <?php echo $Nombre;?> Stk. Min.: <?php echo $StockMinimo;?></span><br />
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
    
    
      
    PROCESO TERMINADO<br />
<?php echo date("d/m/Y H:i:s");?><br />
    </body></html>
    
    