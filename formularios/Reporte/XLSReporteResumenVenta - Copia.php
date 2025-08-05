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

//if($_GET['P']==2){
//	header("Content-type: application/vnd.ms-excel");
//	header("Content-Disposition:  filename=\"REPORTE_GENERAL_MOTOR_KPI_".date('d-m-Y').".xls\";");
//}


define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');
        
/** Include PHPExcel */
//require_once dirname(__FILE__) . '/../Classes/PHPExcel.php';
require_once($InsProyecto->MtdRutLibrerias().'ZipArchive.php');
require_once($InsProyecto->MtdRutLibrerias().'PHPExcel_1.8.0_doc/Classes/PHPExcel.php');
    
	



$POST_FechaInicio = empty($_GET['FechaInicio'])?date("d/m/Y"):$_GET['FechaInicio'];
$POST_FechaFin = empty($_GET['FechaFin'])?date("d/m/Y"):$_GET['FechaFin'];
$POST_Moneda = (empty($_GET['Moneda'])?$EmpresaMonedaId:$_GET['Moneda']);
$POST_Sucursal = (($_GET['Sucursal']));

require_once($InsPoo->MtdPaqReporte().'ClsReporteResumenVenta.php');

$InsReporteResumenVenta = new ClsReporteResumenVenta();
//MtdObtenerReporteResumenVentaes($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'RveId',$oSentido = 'Desc',$oPaginacion = '0,10',$oAno=NULL,$oMes=NULL,$oSucursal=NULL,$oFechaInicio=NULL,$oFechaFin=NULL)
$ResReporteResumenVenta = $InsReporteResumenVenta->MtdObtenerReporteResumenVentas(NULL,NULL,NULL,"RvrFecha","ASC",NULL,NULL,NULL,$POST_Sucursal,FncCambiaFechaAMysql($POST_FechaInicio),FncCambiaFechaAMysql($POST_FechaFin));
$ArrReporteResumenVentas = $ResReporteResumenVenta['Datos'];


	
 // Create new PHPExcel object
  $objPHPExcel = new PHPExcel();
  
  $objReader = PHPExcel_IOFactory::createReader('Excel5');
			  // Set document properties
			  $objPHPExcel->getProperties()->setCreator($EmpresaNombre)
										   ->setLastModifiedBy($EmpresaNombre)
										   ->setTitle($EmpresaNombre)
										   ->setSubject($EmpresaNombre)
										   ->setDescription($EmpresaNombre)
										   ->setKeywords($EmpresaNombre)
										   ->setCategory($EmpresaNombre);
										   
			  $objPHPExcel = $objReader->load("../../plantilla/TemResumenVentaDetallado.xls");
			  
			  

		
		$Fila = 5;
		
		$i=1;
		if(!empty($ArrReporteResumenVentas)){
			foreach($ArrReporteResumenVentas as $DatReporteResumenVenta){
			
		
				$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue("A".$Fila, $i);
							
				$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue("B".$Fila, $DatReporteResumenVenta->RvrDoc);
								
				$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue("C".$Fila, $DatReporteResumenVenta->RvrFecha);
				
				$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue("D".$Fila, $DatReporteResumenVenta->RvrTipoMoneda);
						
				$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue("E".$Fila, $DatReporteResumenVenta->RvrOrdenTrabajo);
						
				$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue("F".$Fila, $DatReporteResumenVenta->RvrCliente);
								
				$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue("G".$Fila, $DatReporteResumenVenta->RvrLocal);
			
				$objPHPExcel->setActiveSheetIndex(0)
				 				->setCellValue("H".$Fila,($DatReporteResumenVenta->RvrMarca));
				  
			    $objPHPExcel->setActiveSheetIndex(0)
								->setCellValue("I".$Fila, ($DatReporteResumenVenta->RvrResumen));
								
				 $objPHPExcel->setActiveSheetIndex(0)
								->setCellValue("J".$Fila, ($DatReporteResumenVenta->RvrTipo));
								
				 $objPHPExcel->setActiveSheetIndex(0)
								->setCellValue("K".$Fila, ($DatReporteResumenVenta->RvrServicios));
								
				 $objPHPExcel->setActiveSheetIndex(0)
								->setCellValue("L".$Fila, ($DatReporteResumenVenta->RvrTipoDetalle));
				 $objPHPExcel->setActiveSheetIndex(0)
								->setCellValue("M".$Fila, ($DatReporteResumenVenta->RvrVendedor));
				 $objPHPExcel->setActiveSheetIndex(0)
								->setCellValue("N".$Fila, ($DatReporteResumenVenta->RvrAsesorAccesorio));
				 $objPHPExcel->setActiveSheetIndex(0)
								->setCellValue("O".$Fila, ($DatReporteResumenVenta->RvrCodigo));
				 $objPHPExcel->setActiveSheetIndex(0)
								->setCellValue("P".$Fila, ($DatReporteResumenVenta->RvrDescripcion));
				 $objPHPExcel->setActiveSheetIndex(0)
								->setCellValue("Q".$Fila, ($DatReporteResumenVenta->RvrCantidad));
				 $objPHPExcel->setActiveSheetIndex(0)
								->setCellValue("R".$Fila, ($DatReporteResumenVenta->RvrCostoUs));
				 $objPHPExcel->setActiveSheetIndex(0)
								->setCellValue("S".$Fila, ($DatReporteResumenVenta->RvrCostoIgv));
				 $objPHPExcel->setActiveSheetIndex(0)
								->setCellValue("T".$Fila, ($DatReporteResumenVenta->RvrTipoCambio));
								 $objPHPExcel->setActiveSheetIndex(0)
								->setCellValue("U".$Fila, ($DatReporteResumenVenta->RvrCostoTotal1));
								 $objPHPExcel->setActiveSheetIndex(0)
								->setCellValue("V".$Fila, ($DatReporteResumenVenta->RvrCostoIGVSoles));
								 $objPHPExcel->setActiveSheetIndex(0)
								->setCellValue("W".$Fila, ($DatReporteResumenVenta->RvrCostoTotal2));
								 $objPHPExcel->setActiveSheetIndex(0)
								->setCellValue("X".$Fila, ($DatReporteResumenVenta->RvrCostoGeneral));
								 $objPHPExcel->setActiveSheetIndex(0)
								->setCellValue("Y".$Fila, ($DatReporteResumenVenta->RvrPrecioUs));
								 $objPHPExcel->setActiveSheetIndex(0)
								->setCellValue("Z".$Fila, ($DatReporteResumenVenta->RvvrPrecioS));
								 $objPHPExcel->setActiveSheetIndex(0)
								->setCellValue("AA".$Fila, ($DatReporteResumenVenta->RvrPrecioUnitario));
								 $objPHPExcel->setActiveSheetIndex(0)
								->setCellValue("AB".$Fila, ($DatReporteResumenVenta->RvrPrecioCliente));
								 $objPHPExcel->setActiveSheetIndex(0)
								->setCellValue("AC".$Fila, ($DatReporteResumenVenta->RvrGanancia));
								 $objPHPExcel->setActiveSheetIndex(0)
								->setCellValue("AD".$Fila, ($DatReporteResumenVenta->RvrMargen));
								
								 $objPHPExcel->setActiveSheetIndex(0)
								->setCellValue("AE".$Fila, ($DatReporteResumenVenta->RvrUnidadMedida));
								 
								 $objPHPExcel->setActiveSheetIndex(0)
								->setCellValue("AF".$Fila, ($DatReporteResumenVenta->RvrPrecioSFinal));
								
								 $objPHPExcel->setActiveSheetIndex(0)
								 ->setCellValue("AG".$Fila, ($DatReporteResumenVenta->RvrDescuentoSFinal));
								 
								 $objPHPExcel->setActiveSheetIndex(0)								 
								->setCellValue("AH".$Fila, ($DatReporteResumenVenta->RvrImporteSFinal));
								
								 $objPHPExcel->setActiveSheetIndex(0)								 
								->setCellValue("AH".$Fila, ($DatReporteResumenVenta->RvrImporteDescuentoSFinal));
								
								
								
								 
								 $objPHPExcel->setActiveSheetIndex(0)
								->setCellValue("AI".$Fila, ($DatReporteResumenVenta->RvrPrecioUSFinal));
								
								 $objPHPExcel->setActiveSheetIndex(0)
								 ->setCellValue("AJ".$Fila, ($DatReporteResumenVenta->RvrDescuentoUSFinal));
								 
								 $objPHPExcel->setActiveSheetIndex(0)								 
								->setCellValue("AK".$Fila, ($DatReporteResumenVenta->RvrImporteUSFinal));
								
									 $objPHPExcel->setActiveSheetIndex(0)								 
								->setCellValue("AK".$Fila, ($DatReporteResumenVenta->RvrImporteUSFinal));
								
								
								
								 
								 $objPHPExcel->setActiveSheetIndex(0)								 
								->setCellValue("AL".$Fila, ($DatReporteResumenVenta->RvrModalidad));

						 $objPHPExcel->setActiveSheetIndex(0)								 
								->setCellValue("AM".$Fila, ($DatReporteResumenVenta->RvrNotaCredito));


				 
				$Fila++;
				$i++;				
			}	
		}
		
		
		
		$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue("E2", "Generado el ".date("d/m/Y"));
		
		$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue("I2", "Filtrado de Fechas: ".$POST_FechaInicio." al ".$POST_FechaFin);
					
        // Rename worksheet
        //$objPHPExcel->getActiveSheet()->setTitle('COR - '.$InsVehiculoMarca->VmaNombre);
        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save("../../generados/reportes/RESUMEN_POST_VENTA_DETALLADO_".str_replace("/","-",$POST_FechaInicio)."_".str_replace("/","-",$POST_FechaFin).".xls");
        
        //$objWriter->save(str_replace('.php', '.xls', __FILE__));
        /*
        <a href="<?php echo $InsOrdenCompra->OcoId;?>.xls">DESCARGAR: <?php echo $InsOrdenCompra->OcoId;?>.xls</a>
        */
        header("Location: ../../generados/reportes/RESUMEN_POST_VENTA_DETALLADO_".str_replace("/","-",$POST_FechaInicio)."_".str_replace("/","-",$POST_FechaFin).".xls");
        // echo "MSI_".$InsVehiculoMarca->VmaNombre."_".$POST_Mes."_".$POST_Ano.".xls";
	exit();
		
?>