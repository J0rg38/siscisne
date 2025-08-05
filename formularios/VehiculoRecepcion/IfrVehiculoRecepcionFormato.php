<?php
session_start();
////PRINCIPALES
require_once('../../proyecto/ClsProyecto.php');
require_once('../../proyecto/ClsPoo.php');

$InsPoo->Ruta = '../../';
$InsProyecto->Ruta = '../../';

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
require_once($InsProyecto->MtdRutLibrerias().'PHPMailer_5.2.4/class.phpmailer.php');
require_once($InsProyecto->MtdRutClases().'ClsCorreo.php');

////CLASES GENERALES
require_once($InsProyecto->MtdRutConexiones().'ClsConexion.php');
require_once($InsProyecto->MtdRutClases().'ClsMysql.php');
////FUNCIONES GENERALES
require_once($InsProyecto->MtdRutFunciones().'FncGeneral.php');

//if($_GET['P']==2){
//	header("Content-type: application/vnd.ms-excel");
//	header("Content-Disposition:  filename=\"FORMATO_RECLAMO_".date('d-m-Y').".xls\";");
//}



$POST_finicio = isset($_POST['CmpFechaInicio'])?$_POST['CmpFechaInicio']:date("d/m/Y");
$POST_ffin = isset($_POST['CmpFechaFin'])?$_POST['CmpFechaFin']:date("d/m/Y");
$POST_VehiculoMarca = $_POST['CmpVehiculoMarca'];

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoRecepcion.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoRecepcionDetalle.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoRecepcionDetalleFoto.php');

$InsVehiculoRecepcionDetalle = new ClsVehiculoRecepcionDetalle();
//MtdObtenerVehiculoRecepcionDetalles($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'VrdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oVehiculoRecepcion=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oVehiculoMarca=NULL,$oVehiculoRecepcionEstado=NULL)
$ResVehiculoRecepcionDetalle = $InsVehiculoRecepcionDetalle->MtdObtenerVehiculoRecepcionDetalles(NULL,NULL,NULL,'EinVIN','ASC',NULL,NULL,NULL,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),$POST_VehiculoMarca,3);
$ArrVehiculoRecepcionDetalles = $ResVehiculoRecepcionDetalle['Datos'];



define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');
        
/** Include PHPExcel */
//require_once dirname(__FILE__) . '/../Classes/PHPExcel.php';
require_once($InsProyecto->MtdRutLibrerias().'ZipArchive.php');
require_once($InsProyecto->MtdRutLibrerias().'PHPExcel_1.8.0_doc/Classes/PHPExcel.php');
        

		
if($_GET['P'] == 2){
	
	$objPHPExcel = new PHPExcel();
	
	$objReader = PHPExcel_IOFactory::createReader('Excel5');
	// Set document properties
	$objPHPExcel->getProperties()->setCreator("C&C S.A.C.")
								 ->setLastModifiedBy("C&C S.A.C.")
								 ->setTitle("C&C S.A.C.")
								 ->setSubject("C&C S.A.C.")
								 ->setDescription("C&C S.A.C.")
								 ->setKeywords("C&C S.A.C.")
								 ->setCategory("C&C S.A.C.");
								 
	$objPHPExcel = $objReader->load("../../plantilla/TemFormatoReclamo.xls");
	

	

$fila = 6;	
$numeracion = 1;
if(!empty($ArrVehiculoRecepcionDetalles)){
	foreach($ArrVehiculoRecepcionDetalles as $DatVehiculoRecepcionDetalle){
		
		$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('B'.$fila, $numeracion);
			
			
		$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('C'.$fila, $DatVehiculoRecepcionDetalle->EinVIN);
			
			
		$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('D'.$fila, $DatVehiculoRecepcionDetalle->VmoNombre);
			
		$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('E'.$fila, $DatVehiculoRecepcionDetalle->EinColor);
			
		$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('F'.$fila, $DatVehiculoRecepcionDetalle->VrdZonaComprometida);
			
		$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('G'.$fila, $DatVehiculoRecepcionDetalle->VrdRepuestoDetalle);
			
		$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('H'.$fila, $DatVehiculoRecepcionDetalle->VreFecha);
			
			$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('I'.$fila, $DatVehiculoRecepcionDetalle->VreGuiaRemisionNumero);
			
			$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('J'.$fila, $DatVehiculoRecepcionDetalle->VreTieneGuia);
			
			$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('K'.$fila, $DatVehiculoRecepcionDetalle->VrdSolucion);
			
			
			$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('L'.$fila, $DatVehiculoRecepcionDetalle->VrdObservacion);
			

$InsVehiculoRecepcionDetalleFoto = new ClsVehiculoRecepcionDetalleFoto();
// MtdObtenerVehiculoRecepcionDetalleFotos($oCampo=NULL,$oFiltro=NULL,$oOrden = 'VrfId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVehiculoRecepcionDetalle=NULL) 
$ResVehiculoRecepcionDetalleFoto = $InsVehiculoRecepcionDetalleFoto->MtdObtenerVehiculoRecepcionDetalleFotos(NULL,NULL,'VrfId','ASC',NULL,$DatVehiculoRecepcionDetalle->VrdId);
$ArrVehiculoRecepcionDetalleFotos = $ResVehiculoRecepcionDetalleFoto['Datos'];
			
			$columna = 13;
			
			if($ArrVehiculoRecepcionDetalleFotos){
				foreach($ArrVehiculoRecepcionDetalleFotos as $DatVehiculoRecepcionDetalleFoto){
					
					$objDrawing = new PHPExcel_Worksheet_Drawing();
					$objDrawing->setName('Thumb');
					$objDrawing->setDescription('Thumbnail Image');
					$objDrawing->setPath('../../subidos/vehiculo_recepcion_fotos/'.$DatVehiculoRecepcionDetalleFoto->VrfArchivo);
					$objDrawing->setHeight(60);
					$objDrawing->setWidth(60);
					$objDrawing->setCoordinates(FncConvertirNumeroALetraExcel($columna).$fila);
					$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
					
					
					$columna ++;
				}
			}
			
		
		
		
		
		$fila++;
		$numeracion++;
	}
}

	// Rename worksheet
	$objPHPExcel->getActiveSheet()->setTitle('FORMATO RECLAMO '.date("d-m-Y"));
	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	$objPHPExcel->setActiveSheetIndex(0);
	
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	$objWriter->save("../../generados/vehiculo_recepcion/FORMATO_RECLAMO_".date("d-m-Y").".xls");
	
	header("Location: ../../generados/vehiculo_recepcion/FORMATO_RECLAMO_".date("d-m-Y").".xls");
	
			
}else{
?>


<html>
<head>

<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssReporte.css">
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.7.2.min.js"></script> 

</head>
<body>
<script type="text/javascript">

$().ready(function() {
<?php if($_GET['P']==1){?> 
	setTimeout("window.close();",2500);	
	window.print(); 

<?php }?>
});

</script>
<?php
//
//$POST_finicio = isset($_POST['CmpFechaInicio'])?$_POST['CmpFechaInicio']:date("d/m/Y");
//$POST_ffin = isset($_POST['CmpFechaFin'])?$_POST['CmpFechaFin']:date("d/m/Y");
//
//require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoRecepcion.php');
//require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoRecepcionDetalle.php');
//require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoRecepcionDetalleFoto.php');
//
//$InsVehiculoRecepcionDetalle = new ClsVehiculoRecepcionDetalle();
//
////MtdObtenerVehiculoIngresos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'EinId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oTipo=NULL,$oCliente=NULL,$oEstadoVehicular=NULL,$oVehiculoMarca=NULL,$oVehiculoModelo=NULL,$oVehiculoVersion=NULL,$oAnoModelo=NULL,$oAnoFabricacion=NULL,$oColor=NULL,$oConProforma=NULL,$oFecha="EinRecepcionFecha",$oFechaInicio=NULL,$oFechaFin=NULL) {
///*$ResVehiculoIngreso = $InsVehiculoIngreso->MtdObtenerVehiculoIngresos(NULL,NULL,NULL,'EinRecepcionFecha','ASC',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,"EinRecepcionFecha",FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin));
//$ArrVehiculoIngresos = $ResVehiculoIngreso['Datos'];*/
//
//
////MtdObtenerVehiculoRecepcionDetalles($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'VrdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oVehiculoRecepcion=NULL,$oFechaInicio=NULL,$oFechaFin=NULL)}}}}
//
//$ResVehiculoRecepcionDetalle = $InsVehiculoRecepcionDetalle->MtdObtenerVehiculoRecepcionDetalles(NULL,NULL,NULL,'VrdId','Desc',NULL,3,NULL,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin));
//$ArrVehiculoRecepcionDetalles = $ResVehiculoRecepcionDetalle['Datos'];


?>

<?php if($_GET['P']==1){?>
<table cellpadding="0" cellspacing="0" width="100%" border="0">
<tr>
  <td colspan="3" align="left"><span class="EstReporteCabecera"><?php echo $EmpresaNombre;?> - <?php echo $EmpresaCodigo;?></span></td>
</tr>
<tr>
  <td width="23%" align="left" valign="top">
  <?php
		if(!empty($SistemaLogo) and file_exists("../../imagenes/".$SistemaLogo)){
		?>
    <img src="../../imagenes/<?php echo $SistemaLogo;?>" width="271" height="92" />
    <?php
		}else{
		?>
    <img src="../../imagenes/logotipo.png" width="243" height="59" />
    <?php	
		}
		?>
  </td>
  <td width="54%" align="center" valign="top"><span class="EstReporteTitulo">CONSULTA DE PRODUCTO


 </span></td>
  <td width="23%" align="right" valign="top"><span class="EstReporteDatosImpresion"><?php echo date("d/m/Y");?> <?php echo date("H:i:s");?> <?php echo date("a");?></span> <br />

    <span class="EstReporteDatosImpresion"><?php echo $_SESSION['SesionUsuario'];?></span></td>
</tr>
</table>
<hr class="EstReporteLinea">

<?php }?>
        
        <table class="EstTablaReporte" width="100%" border="0" cellpadding="2" cellspacing="2">

        <thead class="EstTablaReporteHead">
        <tr>
            <th align="center">#</th>
            <th align="center">VIN</th>
            <th align="center">MODELO</th>
            <th align="center">COLOR</th>
            <th align="center">ZONA COMPROMETIA</th>
            <th align="center">REPUESTO DETALLE</th>
            <th align="center">FECHA DE RECEPCION</th>
            <th align="center">NRO. GUIA</th>
            <th align="center">¿REGISTRO EN GUIA?</th>
            <th align="center">SOLUCION</th>
            <th align="center">OBSERVACIONES</th>
            <th align="center">FOTOS</th>
          </tr>
          
        </thead>

        <tbody class="EstTablaReporteBody">
        	<?php
			$i = 1;
			if(!empty($ArrVehiculoRecepcionDetalles)){
				foreach($ArrVehiculoRecepcionDetalles as $DatVehiculoRecepcionDetalle){
			?>
          <tr>
            <td width="2%" align="right"><?php echo $i;?></td>
            <td width="3%" align="right"><?php echo $DatVehiculoRecepcionDetalle->EinVIN;?></td>
            <td width="7%" align="right"><?php echo $DatVehiculoRecepcionDetalle->VmoNombre;?></td>
            <td width="7%" align="right"><?php echo $DatVehiculoRecepcionDetalle->EinColor;?></td>
            <td width="24%" align="right"><?php echo $DatVehiculoRecepcionDetalle->VrdZonaComprometida;?>
            
            
            
            </td>
            <td width="8%" align="right"><?php echo $DatVehiculoRecepcionDetalle->VrdRepuestoDetalle;?></td>
            <td width="9%" align="right"><?php echo $DatVehiculoRecepcionDetalle->VreFecha;?></td>
            <td width="5%" align="right"><?php echo $DatVehiculoRecepcionDetalle->VreGuiaRemisionNumero;?></td>
            <td width="9%" align="right"><?php echo $DatVehiculoRecepcionDetalle->VreTieneGuia;?></td>
            <td width="8%" align="right"><?php echo $DatVehiculoRecepcionDetalle->VrdSolucion;?></td>
            <td width="13%" align="right"><?php echo $DatVehiculoRecepcionDetalle->VrdObservacion;?></td>
            <td width="5%" align="right">

<?php
$InsVehiculoRecepcionDetalleFoto = new ClsVehiculoRecepcionDetalleFoto();
// MtdObtenerVehiculoRecepcionDetalleFotos($oCampo=NULL,$oFiltro=NULL,$oOrden = 'VrfId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVehiculoRecepcionDetalle=NULL) 
$ResVehiculoRecepcionDetalleFoto = $InsVehiculoRecepcionDetalleFoto->MtdObtenerVehiculoRecepcionDetalleFotos(NULL,NULL,'VrfId','ASC',NULL,$DatVehiculoRecepcionDetalle->VrdId);
$ArrVehiculoRecepcionDetalleFotos = $ResVehiculoRecepcionDetalleFoto['Datos'];
?>

<?php
if(!empty($ArrVehiculoRecepcionDetalleFotos)){
?>

		<?php
			foreach($ArrVehiculoRecepcionDetalleFotos as $DatVehiculoRecepcionDetalleFoto){
		?>
        	<div  style="display:table-cell">
        	<img src="../../subidos/vehiculo_recepcion_fotos/<?php echo $DatVehiculoRecepcionDetalleFoto->VrfArchivo?>" width="50" height="50">
        	</div>
        <?php	
			}
		?>
<?php
}else{
?>
No hay fotos
<?php	
}
?>
            </td>
          </tr>
          
          <?php
		  			$i++;
				}
			}
		  ?>
          
          
          <tr>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
          </tr>
		</tbody>
        
        
		<tfoot class="EstTablaReporteFoot">
		</tfoot>
		</table>





</body>
</html>


<?php	
}
?>

