<?php
session_start();
////PRINCIPALES
require_once('../../../proyecto/ClsProyecto.php');
require_once('../../../proyecto/ClsPoo.php');

$InsPoo->Ruta = '../../../';
$InsProyecto->Ruta = '../../../';

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
//	header("Content-Disposition:  filename=\"REPORTE_GENERAL_MOTOR_KPI_".date('d-m-Y').".xls\";");
//}


define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');
        
/** Include PHPExcel */
//require_once dirname(__FILE__) . '/../Classes/PHPExcel.php';
require_once($InsProyecto->MtdRutLibrerias().'ZipArchive.php');
require_once($InsProyecto->MtdRutLibrerias().'PHPExcel_1.8.0_doc/Classes/PHPExcel.php');
    
	
$POST_Id = ($_GET['Id']);

//deb($POST_Mes);
if(empty($POST_Id)){
	die("No ha ingresado un codigo identificador");
}
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculo.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoCondicionVenta.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoObsequio.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoLlamada.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoVersionCaracteristica.php');

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoPropietario.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoMantenimiento.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsPago.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsPagoComprobante.php');
	
	
	$InsPago = new ClsPago();
$InsOrdenVentaVehiculoPropietario = new ClsOrdenVentaVehiculoPropietario();

$InsOrdenVentaVehiculo = new ClsOrdenVentaVehiculo();
$InsOrdenVentaVehiculo->OvvId = $POST_Id;
$InsOrdenVentaVehiculo->MtdObtenerOrdenVentaVehiculo(false);


$ResPago = $InsPago->MtdObtenerPagos(NULL,NULL,NULL,"PagFecha","ASC",NULL,NULL,NULL,$InsOrdenVentaVehiculo->OvvId,NULL,NULL);
$ArrPagos = $ResPago['Datos'];


$ResOrdenVentaVehiculoPropietario = $InsOrdenVentaVehiculoPropietario->MtdObtenerOrdenVentaVehiculoPropietarios(NULL,NULL,'OvpId', 'Desc',NULL,$InsOrdenVentaVehiculo->OvvId,NULL);
$ArrOrdenVentaVehiculoPropietarios = $ResOrdenVentaVehiculoPropietario['Datos'];


if($InsOrdenVentaVehiculo->MonId<>$EmpresaMonedaId){

		$InsOrdenVentaVehiculo->OvvPrecio = round($InsOrdenVentaVehiculo->OvvPrecio / $InsOrdenVentaVehiculo->OvvTipoCambio,3);
		$InsOrdenVentaVehiculo->OvvDescuento = round($InsOrdenVentaVehiculo->OvvDescuento / $InsOrdenVentaVehiculo->OvvTipoCambio,3);
		
		$InsOrdenVentaVehiculo->OvvBonoGM = round($InsOrdenVentaVehiculo->OvvBonoGM / $InsOrdenVentaVehiculo->OvvTipoCambio,3);
		$InsOrdenVentaVehiculo->OvvBonoDealer = round($InsOrdenVentaVehiculo->OvvBonoDealer / $InsOrdenVentaVehiculo->OvvTipoCambio,3);
		
		$InsOrdenVentaVehiculo->OvvDescuentoGerencia = round($InsOrdenVentaVehiculo->OvvDescuentoGerencia / $InsOrdenVentaVehiculo->OvvTipoCambio,3);
		
		$InsOrdenVentaVehiculo->OvvTotal = round($InsOrdenVentaVehiculo->OvvTotal / $InsOrdenVentaVehiculo->OvvTipoCambio,3);
		$InsOrdenVentaVehiculo->OvvImpuesto = round($InsOrdenVentaVehiculo->OvvImpuesto / $InsOrdenVentaVehiculo->OvvTipoCambio,3);
		$InsOrdenVentaVehiculo->OvvSubTotal = round($InsOrdenVentaVehiculo->OvvSubTotal / $InsOrdenVentaVehiculo->OvvTipoCambio,3);
		
		
		$InsOrdenVentaVehiculo->CveTotal = round($InsOrdenVentaVehiculo->CveTotal / $InsOrdenVentaVehiculo->OvvTipoCambio,3);
			
	}	
	
 // Create new PHPExcel object
  $objPHPExcel = new PHPExcel();
  
  $objReader = PHPExcel_IOFactory::createReader('Excel5');
			  // Set document properties
			  $objPHPExcel->getProperties()->setCreator($EmpresaNombre)
										   ->setLastModifiedBy($EmpresaNombre)
										   ->setTitle("Formato Inmatriculacion")
										   ->setSubject("")
										   ->setDescription("")
										   ->setKeywords("")
										   ->setCategory("");
										   
			  $objPHPExcel = $objReader->load("../../../plantilla/TemFormatoInmatriculacionFI2.xls");
			  
			  


//DATOS CONCESIONARIO
$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('J12',strtoupper($InsOrdenVentaVehiculo->CliNombre.' '.$InsOrdenVentaVehiculo->CliApellidoPaterno.' '.$InsOrdenVentaVehiculo->CliApellidoMaterno));
								
$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('F13', $InsOrdenVentaVehiculo->CliDireccion.' '.$InsOrdenVentaVehiculo->CliDepartamento.' '.$InsOrdenVentaVehiculo->CliProvincia.' '.$InsOrdenVentaVehiculo->CliDistrito);										

$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('X15',($InsOrdenVentaVehiculo->CliNumeroDocumento));
				
	
	if($InsOrdenVentaVehiculo->TdoId == "TDO-10001"){
		$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('O15', 'X');										
	
	}
	
	if($InsOrdenVentaVehiculo->TdoId == "TDO-10002"){
		$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('U15', 'X');	
	}
	
			switch($InsOrdenVentaVehiculo->CliEstadoCivil){
				case "Soltero":
					$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('I17', 'X');				
				break;
				
				case "Casado":
					$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('M17', 'X');		
				break;
				
				case "Viudo":
						$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('Q17', 'X');		
				break;
				
				case "Divorciado":
						$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('V17', 'X');		
				break;

			}
	
	
	
$propietario=1;
if(!empty($ArrOrdenVentaVehiculoPropietarios)){
	foreach($ArrOrdenVentaVehiculoPropietarios as $DatOrdenVentaVehiculoPropietario){
	
		if($DatOrdenVentaVehiculoPropietario->CliId <> $InsOrdenVentaVehiculo->CliId){
			
			if($propietario==2){
				
				$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('L19',strtoupper($DatOrdenVentaVehiculoPropietario->CliNombre.' '.$DatOrdenVentaVehiculoPropietario->CliApellidoPaterno.' '.$DatOrdenVentaVehiculoPropietario->CliApellidoMaterno));
				$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('X21',($DatOrdenVentaVehiculoPropietario->CliNumeroDocumento));		
				
					if($DatOrdenVentaVehiculoPropietario->TdoId == "TDO-10001"){
						$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue('O21', 'X');										
					
					}
					
					if($DatOrdenVentaVehiculoPropietario->TdoId == "TDO-10002"){
						$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue('U21', 'X');	
					}	
			}
		
			$propietario++;
		}

	}
}
	
	
$propietario=1;
if(!empty($ArrOrdenVentaVehiculoPropietarios)){
	foreach($ArrOrdenVentaVehiculoPropietarios as $DatOrdenVentaVehiculoPropietario){
	
		if($DatOrdenVentaVehiculoPropietario->CliId <> $InsOrdenVentaVehiculo->CliId){
			
			if($propietario==3){
				
				$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('L22',strtoupper($DatOrdenVentaVehiculoPropietario->CliNombre.' '.$DatOrdenVentaVehiculoPropietario->CliApellidoPaterno.' '.$DatOrdenVentaVehiculoPropietario->CliApellidoMaterno));
				$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('X23',($DatOrdenVentaVehiculoPropietario->CliNumeroDocumento));		
				
					if($DatOrdenVentaVehiculoPropietario->TdoId == "TDO-10001"){
						$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue('O23', 'X');										
					
					}
					
					if($DatOrdenVentaVehiculoPropietario->TdoId == "TDO-10002"){
						$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue('U23', 'X');	
					}	
			}
		
			$propietario++;
		}

	}
}
	
							
/*
* CARACTERISTICAS
*/				

switch($InsOrdenVentaVehiculo->OvvTipoPlaca){
	case "PARTICULAR":
		
		$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('I29',"PARTICULAR");	
	break;

	case "TAXISTA":
		
		$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('I29', "TAXISTA");						
	break;
	

}

	
$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('I30', $InsOrdenVentaVehiculo->EinCaracteristica20);	
			
$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('I31', $InsOrdenVentaVehiculo->VmaNombre);	
			
$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('I32', $InsOrdenVentaVehiculo->VmoNombre);	
							
$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('I33', $InsOrdenVentaVehiculo->EinAnoModelo);	
	
$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('I34', $InsOrdenVentaVehiculo->EinAnoFabricacion);	
						
$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('I35', $InsOrdenVentaVehiculo->VveNombre);									
						
$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('I36', $InsOrdenVentaVehiculo->EinCaracteristica8);	
				
$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('I37', $InsOrdenVentaVehiculo->EinColor);	

$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('I40', $InsOrdenVentaVehiculo->EinVIN);				

$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('I41', $InsOrdenVentaVehiculo->EinVIN);							

$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('I42', $InsOrdenVentaVehiculo->EinNumeroMotor);	
									
$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('I43', $InsOrdenVentaVehiculo->EinCaracteristica19);	
			
			
			
						
$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('Y29', $InsOrdenVentaVehiculo->EinCaracteristica10);		
				
$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('Y30', $InsOrdenVentaVehiculo->EinCaracteristica1);	
					
$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('Y31', $InsOrdenVentaVehiculo->EinCaracteristica3);	
			
$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('Y32', $InsOrdenVentaVehiculo->EinCaracteristica15);				
					
$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('Y33', $InsOrdenVentaVehiculo->EinCaracteristica16);				
					
$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('Y34', $InsOrdenVentaVehiculo->EinCaracteristica14);	
			
$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('Y35', $InsOrdenVentaVehiculo->EinCaracteristica5);	
						
$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('Y36', $InsOrdenVentaVehiculo->EinCaracteristica4);	
			
$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('Y37', $InsOrdenVentaVehiculo->EinCaracteristica2);	
						
$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('Y38', $InsOrdenVentaVehiculo->EinCaracteristica9);	
			
$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('Y39', $InsOrdenVentaVehiculo->EinCaracteristica18);	
													
$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('Y40', $InsOrdenVentaVehiculo->EinCaracteristica13);				
			
$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('Y41', $InsOrdenVentaVehiculo->EinCaracteristica12);	
						
$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('Y42', $InsOrdenVentaVehiculo->EinCaracteristica11);					
				
														
        // Rename worksheet
        //$objPHPExcel->getActiveSheet()->setTitle('COR - '.$InsVehiculoMarca->VmaNombre);
        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save("../../../generados/FI2_".$InsOrdenVentaVehiculo->OvvId.".xls");
        
        //$objWriter->save(str_replace('.php', '.xls', __FILE__));
        /*
        <a href="<?php echo $InsOrdenCompra->OcoId;?>.xls">DESCARGAR: <?php echo $InsOrdenCompra->OcoId;?>.xls</a>
        */
        header("Location: ../../../generados/FI2_".$InsOrdenVentaVehiculo->OvvId.".xls");
        // echo "MSI_".$InsVehiculoMarca->VmaNombre."_".$POST_Mes."_".$POST_Ano.".xls";
	exit();
		
?>