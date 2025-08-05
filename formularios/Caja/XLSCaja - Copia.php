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
$POST_FormaPago = ($_GET['FormaPago']);
$POST_Sucursal = ($_GET['Sucursal']);


require_once($InsPoo->MtdPaqContabilidad().'ClsFactura.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsBoleta.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsPago.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsGasto.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsDesembolso.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoEntrada.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoEntradaDetalle.php');
require_once($InsPoo->MtdPaqEmpresa().'ClsSucursal.php');


$InsSucursal = new ClsSucursal();
$InsSucursal->SucId =  $POST_Sucursal;
$InsSucursal->MtdObtenerSucursal();
	
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
										   
			  $objPHPExcel = $objReader->load("../../plantilla/TemCaja.xls");
			  
			  

		
		
	
	
$TotalIngresos = 0;
$TotalEgresos = 0;


$InsPago = new ClsPago();
//MtdObtenerPagos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PagId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oVentaDirecta=NULL,$oOrdenVentaVehiculo=NULL,$oCondicionPago=NULL,$oMoneda=NULL,$oFactura=NULL,$oFacturaTalonario=NULL,$oBoleta=NULL,$oBoletaTalonario=NULL,$oArea=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oFecha="PagFecha",$oOrigen=NULL,$oFormaPago=NULL,$oSucursal=NULL) {
$ResPago = $InsPago->MtdObtenerPagos(NULL,NULL,NULL,"PagFecha","ASC",NULL,NULL,$GET_VdiId,NULL,$POST_CondicionPago,$POST_Moneda,NULL,NULL,NULL,NULL,NULL,FncCambiaFechaAMysql($POST_FechaInicio),FncCambiaFechaAMysql($POST_FechaFin),"PagFecha",NULL,$POST_FormaPago,$POST_Sucursal);
$ArrPagos = $ResPago['Datos'];
		
		$i=1;
		$Fila = 8;
		
		$TotalPagos = 0;
		
		if(!empty($ArrPagos)){
			foreach($ArrPagos as $DatPago){
			
				$DatPago->PagMonto = (($EmpresaMonedaId==$DatPago->MonId or empty($POST_Moneda))?$DatPago->PagMonto:($DatPago->PagMonto/$DatPago->CdiTipoCambio));
		
		
		
				$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue("A".$Fila, $i);
							
				$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue("B".$Fila, $DatPago->FpaNombre);
								
				$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue("C".$Fila, $DatPago->PagNumeroRecibo);
				
				$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue("D".$Fila, $DatPago->PagFecha);
								
				$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue("E".$Fila, $DatPago->PagId.' / '.$DatPago->PagConcepto);
						
				$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue("F".$Fila, $DatPago->PagObservacionCaja);
				
				$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue("G".$Fila, $DatPago->MonSimbolo);
								
				$objPHPExcel->setActiveSheetIndex(0)
				  				->setCellValue("H".$Fila, round($DatPago->PagMonto,2));
				  
			   $TotalEntradas += $DatPago->PagMonto;
			   
			   
				 
				$Fila++;
				$i++;				
			}	
		}
		
		
				
		$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue("A".$Fila,"TOTAL INGRESOS:");
				
				
		$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue("B".$Fila, round($TotalEntradas,2));
									
	



$InsDesembolso = new ClsDesembolso();
//MtdObtenerDesembolsos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'DesId',$oSentido = 'Desc',$oDesinacion = '0,10',$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oFecha="DesFecha",$oCuenta=NULL,$oMoneda=NULL,$oTipoDestino=NULL,$oArea=NULL,$oSucursal=NULL) {
$ResDesembolso = $InsDesembolso->MtdObtenerDesembolsos(NULL,NULL,NULL,"DesFecha","DESC",NULL,3,FncCambiaFechaAMysql($POST_FechaInicio),FncCambiaFechaAMysql($POST_FechaFin),"DesFecha","CUE-10000",$POST_Moneda,NULL,NULL,$POST_Sucursal);
$ArrDesembolsos = $ResDesembolso['Datos'];

$TotalDesembolsos = 0;

$j=1;
		$Fila2 = 8;
		if(!empty($ArrDesembolsos)){
			foreach($ArrDesembolsos as $DatDesembolso){
			
				$DatDesembolso->DesMonto = (($EmpresaMonedaId==$DatDesembolso->MonId or empty($POST_Moneda))?$DatDesembolso->DesMonto:($DatDesembolso->PagMonto/$DatPago->DesTipoCambio));
		
		
				$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue("J".$Fila2, $j);
							
				$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue("K".$Fila2, $DatDesembolso->FpaNombre);
								
				$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue("L".$Fila2, $DatDesembolso->DesReferencia);
				
				$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue("M".$Fila2, $DatDesembolso->DesFecha);
								
			$Concepto = "";				
			if(!empty($DatDesembolso->FinId)){
					
				$Concepto .= " / O.T.:".$DatDesembolso->FinId;			
		
			}
		  
		   if(!empty($DatDesembolso->VdiId)){
			   
			   $Concepto .= " / V.D.: ".$DatDesembolso->VdiId;			
		  
		   }
		  
		   if(!empty($DatDesembolso->OvvId)){
			   
			    $Concepto .= " / O.V.V.: ".$DatDesembolso->OvvId;
		 
		   }
		
		   if(!empty($DatDesembolso->PerNombre)){
			   
			    $Concepto .= " / Personal: ".$DatDesembolso->PerNombre." ".$DatDesembolso->PerApellidoPaterno." ".$DatDesembolso->PerApellidoMaterno;
				
		   }
		
		   if(!empty($DatDesembolso->CliNombre)){
			   
			   $Concepto .= " / Cliente: ".$DatDesembolso->CliNombre." ".$DatDesembolso->CliApellidoPaterno." ".$DatDesembolso->CliApellidoMaterno;
			
		   }
		  
		   if(!empty($DatDesembolso->PrvNombre)){
			   
			   $Concepto .= " / Proveedor: ".$DatDesembolso->PrvNombre." ".$DatDesembolso->PrvApellidoPaterno." ".$DatDesembolso->PrvApellidoMaterno;
			
		   }
		   
		   
				$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue("N".$Fila2, $DatDesembolso->DesId.' / '.$DatDesembolso->DesConcepto.' '.$Concepto);
						
				$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue("O".$Fila2, $DatDesembolso->PagObservacionCaja);
				
				$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue("P".$Fila2, $DatDesembolso->MonSimbolo);
								
				$objPHPExcel->setActiveSheetIndex(0)
				  				->setCellValue("Q".$Fila2, round($DatDesembolso->DesMonto,2));
				  
			   $TotalSalidas += $DatDesembolso->DesMonto;
			   
		  
				 
				$Fila2++;
				$j++;				
			}	
		}
	
		
		$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue("J".$Fila,"TOTAL EGRESOS:");
				
				
		$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue("K".$Fila, round($TotalSalidas,2));
									
			$Saldo = $TotalEntradas - $TotalSalidas;


		if($i>$j){
			$Fila = $Fila+2;
			
			$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue("A".$Fila, "SALDO:");
				
			$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue("B".$Fila, round($Saldo,2));
		}else{
			
			$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue("A".$Fila2, "SALDO:");
				
			$Fila2 = $Fila2+2;
			$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue("B".$Fila2, round($Saldo,2));
		}
		
		
									
					
				 
		
		$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue("B4", $InsSucursal->SucNombre);
		
		$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue("N4", date("d/m/Y"));
		
		$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue("E4", $POST_FechaInicio);
			
		$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue("H4", $POST_FechaFin);	
													
		$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue("K4", $_SESSION['SesionUsuario']);						
													
								
        // Rename worksheet
        //$objPHPExcel->getActiveSheet()->setTitle('COR - '.$InsVehiculoMarca->VmaNombre);
        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save("../../generados/reportes/CAJA_DIARIA_".str_replace("/","-",$POST_FechaInicio)."_".str_replace("/","-",$POST_FechaFin).".xls");
        
        //$objWriter->save(str_replace('.php', '.xls', __FILE__));
        /*
        <a href="<?php echo $InsOrdenCompra->OcoId;?>.xls">DESCARGAR: <?php echo $InsOrdenCompra->OcoId;?>.xls</a>
        */
        header("Location: ../../generados/reportes/CAJA_DIARIA_".str_replace("/","-",$POST_FechaInicio)."_".str_replace("/","-",$POST_FechaFin).".xls");
        // echo "MSI_".$InsVehiculoMarca->VmaNombre."_".$POST_Mes."_".$POST_Ano.".xls";
	exit();
		
?>