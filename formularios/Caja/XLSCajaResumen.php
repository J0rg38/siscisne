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

require_once($InsPoo->MtdPaqContabilidad().'ClsFactura.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsBoleta.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsPago.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsGasto.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsCajaDiaria.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsDesembolso.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsIngreso.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoEntrada.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoEntradaDetalle.php');


$InsCajaDiaria = new ClsCajaDiaria();
//MtdObtenerCajaDiarias($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'DesId',$oSentido = 'Desc',$oDesinacion = '0,10',$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oFecha="DesFecha",$oCuenta=NULL,$oMoneda=NULL,$oTipoDestino=NULL,$oArea=NULL,$oSucursal=NULL) {
$ResCajaDiaria = $InsCajaDiaria->MtdObtenerCajaDiarias(NULL,NULL,NULL,"CdiFecha,CdiId","ASC",NULL,3,FncCambiaFechaAMysql($POST_FechaInicio),FncCambiaFechaAMysql($POST_FechaFin),"CdiFecha","CUE-10000",$POST_Moneda,NULL,NULL,$POST_Sucursal);
$ArrCajaDiarias = $ResCajaDiaria['Datos'];


	
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
										   
			  $objPHPExcel = $objReader->load("../../plantilla/TemCajaResumen.xls");
			  
			  

		
		$Fila = 7;
		
		$TotalEntradas = 0;
$TotalSalidas = 0;
$TotalSaldos = 0;

		$i=1;
		if(!empty($ArrCajaDiarias)){
			foreach($ArrCajaDiarias as $DatCajaDiaria){
			
					$DatCajaDiaria->CdiMonto = (($EmpresaMonedaId==$DatCajaDiaria->MonId or empty($POST_Moneda))?$DatCajaDiaria->CdiMonto:($DatCajaDiaria->CdiMonto/$DatCajaDiaria->CdiTipoCambio));
		
		
		
				$objPHPExcel->setActiveSheetIndex(3)
								->setCellValue("A".$Fila, $i);
							
				$objPHPExcel->setActiveSheetIndex(3)
								->setCellValue("B".$Fila, $DatCajaDiaria->CdiFecha);
								
				$objPHPExcel->setActiveSheetIndex(3)
								->setCellValue("C".$Fila, $DatCajaDiaria->CdiId);
				
				$objPHPExcel->setActiveSheetIndex(3)
								->setCellValue("D".$Fila, $DatCajaDiaria->CdiReferencia);
						
				$objPHPExcel->setActiveSheetIndex(3)
								->setCellValue("E".$Fila, $DatCajaDiaria->PerNombre." ".$DatCajaDiaria->PerApellidoPaterno." ".$DatCajaDiaria->PerApellidoMaterno." ".$DatCajaDiaria->CliNombre." ".$DatCajaDiaria->CliApellidoPaterno." ".$DatCajaDiaria->CliApellidoMaterno." ".$DatCajaDiaria->PrvNombre." ".$DatCajaDiaria->PrvApellidoPaterno." ".$DatCajaDiaria->PrvApellidoMaterno);
						
				$objPHPExcel->setActiveSheetIndex(3)
								->setCellValue("F".$Fila, $DatCajaDiaria->CdiConcepto."/ O.T.: ".$DatCajaDiaria->FinId." / V.D.: ".$DatCajaDiaria->VdiId." / O.V.V.: ".$DatCajaDiaria->OvvId);
								
				$objPHPExcel->setActiveSheetIndex(3)
								->setCellValue("G".$Fila, $DatCajaDiaria->CdiObservacionCaja);
								
			   if($DatCajaDiaria->CdiTipoCajaDiaria=="Entrada"){
					$TotalEntradas += $DatCajaDiaria->CdiMonto;
				  
					
				  $objPHPExcel->setActiveSheetIndex(3)
				  ->setCellValue("H".$Fila, $EmpresaMoneda." ".round($DatCajaDiaria->CdiMonto,2));
				  
			   
				}
					
				if($DatCajaDiaria->CdiTipoCajaDiaria=="Salida"){
					$TotalSalidas += $DatCajaDiaria->CdiMonto;
				  
					
				  $objPHPExcel->setActiveSheetIndex(3)
				  ->setCellValue("H".$Fila, $EmpresaMoneda." ".round($DatCajaDiaria->CdiMonto,2));
				  
			   
				}
		  
				 $Saldo = $TotalEntradas - $TotalSalidas;
				
				$objPHPExcel->setActiveSheetIndex(3)
								->setCellValue("J".$Fila, round($Saldo,2));
									
				 $TotalSaldos += $Saldo;
				 
				 
				$Fila++;
				$i++;				
			}	
		}
		
		
		
		$objPHPExcel->setActiveSheetIndex(1)
								->setCellValue("I4", date("d/m/Y"));
		
			$objPHPExcel->setActiveSheetIndex(1)
								->setCellValue("A4", "Del ".$POST_FechaInicio." al ".$POST_FechaFin);
			
								
								
								
        // Rename worksheet
        //$objPHPExcel->getActiveSheet()->setTitle('COR - '.$InsVehiculoMarca->VmaNombre);
        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save("../../generados/reportes/CAJA_CHICA_".str_replace("/","-",$POST_FechaInicio)."_".str_replace("/","-",$POST_FechaFin).".xls");
        
        //$objWriter->save(str_replace('.php', '.xls', __FILE__));
        /*
        <a href="<?php echo $InsOrdenCompra->OcoId;?>.xls">DESCARGAR: <?php echo $InsOrdenCompra->OcoId;?>.xls</a>
        */
        header("Location: ../../generados/reportes/CAJA_CHICA_".str_replace("/","-",$POST_FechaInicio)."_".str_replace("/","-",$POST_FechaFin).".xls");
        // echo "MSI_".$InsVehiculoMarca->VmaNombre."_".$POST_Mes."_".$POST_Ano.".xls";
	exit();
		
?>