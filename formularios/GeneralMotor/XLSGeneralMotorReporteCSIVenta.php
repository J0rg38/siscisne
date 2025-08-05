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
    
	


$POST_Mes = empty($_GET['CmpMes'])?date("m"):$_GET['CmpMes'];
$POST_Ano = empty($_GET['CmpAno'])?date("Y"):$_GET['CmpAno'];

$POST_finicio = isset($_GET['FechaInicio'])?$_GET['FechaInicio']:"01/".date("m/Y");
$POST_ffin = isset($_GET['FechaFin'])?$_GET['FechaFin']:"15/".date("m/Y");

$POST_ord = isset($_GET['Orden'])?$_GET['Orden']:"CliNombre";
$POST_sen = isset($_GET['Sentido'])?$_GET['Sentido']:"ASC";
$POST_VehiculoMarca = ($_GET['VehiculoMarca']);
//$POST_Sucursal = empty($_GET['Sucursal'])?$_SESSION['SesionSucursal']:$_GET['Sucursal'];
$POST_Sucursal = ($_GET['Sucursal']);

require_once($InsPoo->MtdPaqReporte().'ClsReporteOrdenVentaVehiculo.php');

$InsReporteOrdenVentaVehiculo = new ClsReporteOrdenVentaVehiculo();

//MtdObtenerReporteOrdenVentaVehiculos($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'OvvId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oCSIVentaIncluir=NULL) {
$ResReporteOrdenVentaVehiculo = $InsReporteOrdenVentaVehiculo->MtdObtenerReporteOrdenVentaVehiculoClientes(NULL,NULL,NULL ,$POST_ord ,$POST_sen,NULL,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),$POST_VehiculoMarca,$POST_Sucursal);
$ArrReporteOrdenVentaVehiculos = $ResReporteOrdenVentaVehiculo['Datos'];

	
 // Create new PHPExcel object
  $objPHPExcel = new PHPExcel();
  
  $objReader = PHPExcel_IOFactory::createReader('Excel5');
			  // Set document properties
			  $objPHPExcel->getProperties()->setCreator( $EmpresaNombre)
										   ->setLastModifiedBy( $EmpresaNombre)
										   ->setTitle( $EmpresaNombre)
										   ->setSubject( $EmpresaNombre)
										   ->setDescription( $EmpresaNombre)
										   ->setKeywords( $EmpresaNombre)
										   ->setCategory( $EmpresaNombre);
											   
		$objPHPExcel = $objReader->load("../../plantilla/TemCSIVenta.xls");
			  

		//DATOS 
		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('D2', $EmpresaNombre);
							
		$fila = 8;
		if(!empty($ArrReporteOrdenVentaVehiculos)){
			foreach($ArrReporteOrdenVentaVehiculos as $DatReporteOrdenVentaVehiculo){
			 
			 	$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue(FncConvertirNumeroALetraExcel(3).$fila, $DatReporteOrdenVentaVehiculo->OvvFacturaNumero."".$DatReporteOrdenVentaVehiculo->OvvBoletaNumero);

			 	$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue(FncConvertirNumeroALetraExcel(6).$fila, $EmpresaNombre);
								
				$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue(FncConvertirNumeroALetraExcel(7).$fila, $DatReporteOrdenVentaVehiculo->SucDepartamento);
								
								
								$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue(FncConvertirNumeroALetraExcel(8).$fila, $DatReporteOrdenVentaVehiculo->OvvFechaEntrega);
								
								$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue(FncConvertirNumeroALetraExcel(9).$fila, $DatReporteOrdenVentaVehiculo->EinVIN);
								
								$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue(FncConvertirNumeroALetraExcel(10).$fila, $DatReporteOrdenVentaVehiculo->CliNombre);
								
								$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue(FncConvertirNumeroALetraExcel(11).$fila, $DatReporteOrdenVentaVehiculo->CliApellidoPaterno." ".$DatReporteOrdenVentaVehiculo->CliApellidoMaterno);
								
								$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue(FncConvertirNumeroALetraExcel(15).$fila, $DatReporteOrdenVentaVehiculo->VmoNombre);

								$Emails = "";
								if(!empty($DatReporteOrdenVentaVehiculo->CliEmail)){
									$Emails .= $DatReporteOrdenVentaVehiculo->CliEmail;	
								}else if(!empty($DatReporteOrdenVentaVehiculo->CliContactoEmail1)){
									$Emails .= $DatReporteOrdenVentaVehiculo->CliContactoEmail1;	
								}else if(!empty($DatReporteOrdenVentaVehiculo->CliContactoEmail2)){
									$Emails .= $DatReporteOrdenVentaVehiculo->CliContactoEmail2;
								}else if(!empty($DatReporteOrdenVentaVehiculo->CliContactoEmail3)){
									$Emails .= $DatReporteOrdenVentaVehiculo->CliContactoEmail3;	
								}else if(!empty($DatReporteOrdenVentaVehiculo->CliEmailFacturacion)){
									$Emails .= $DatReporteOrdenVentaVehiculo->CliEmailFacturacion;	
								}

								$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue(FncConvertirNumeroALetraExcel(16).$fila, $Emails);
								
								$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue(FncConvertirNumeroALetraExcel(17).$fila, $DatReporteOrdenVentaVehiculo->CliTelefono);
								
								$Celular = "";
								if(!empty($DatReporteOrdenVentaVehiculo->CliCelular)){
									$Celular .= $DatReporteOrdenVentaVehiculo->CliCelular;	
								}else if(!empty($DatReporteOrdenVentaVehiculo->CliContactoCelular1)){
									$Celular .= $DatReporteOrdenVentaVehiculo->CliContactoCelular1;	
								}else if(!empty($DatReporteOrdenVentaVehiculo->CliContactoCelular2)){
									$Celular .= $DatReporteOrdenVentaVehiculo->CliContactoCelular2;
								}else if(!empty($DatReporteOrdenVentaVehiculo->CliContactoCelular3)){
									$Celular .= $DatReporteOrdenVentaVehiculo->CliContactoCelular3;
								}

								$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue(FncConvertirNumeroALetraExcel(18).$fila, $Celular);
								
								$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue(FncConvertirNumeroALetraExcel(19).$fila, $DatReporteOrdenVentaVehiculo->CliDireccion);
								
								$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue(FncConvertirNumeroALetraExcel(21).$fila, $DatReporteOrdenVentaVehiculo->CliDepartamento);
								
								$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue(FncConvertirNumeroALetraExcel(22).$fila, $DatReporteOrdenVentaVehiculo->CliProvincia);
								
								$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue(FncConvertirNumeroALetraExcel(23).$fila, $DatReporteOrdenVentaVehiculo->PerNumeroDocumento);
								
								$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue(FncConvertirNumeroALetraExcel(24).$fila, $DatReporteOrdenVentaVehiculo->PerNombre);
								
								$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue(FncConvertirNumeroALetraExcel(25).$fila, $DatReporteOrdenVentaVehiculo->PerApellidoPaterno." ".$DatReporteOrdenVentaVehiculo->PerApellidoMaterno);


				$fila++;
			}	
		}

								
        // Rename worksheet
        //$objPHPExcel->getActiveSheet()->setTitle('COR - '.$InsVehiculoMarca->VmaNombre);
        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save("../../generados/reportes/CSI_VENTA_".date("Y")."_".date("m")."_".date("d").".xls");
        
        //$objWriter->save(str_replace('.php', '.xls', __FILE__));
        /*
        <a href="<?php echo $InsOrdenCompra->OcoId;?>.xls">DESCARGAR: <?php echo $InsOrdenCompra->OcoId;?>.xls</a>
        */
        header("Location: ../../generados/reportes/CSI_VENTA_".date("Y")."_".date("m")."_".date("d").".xls");
        // echo "MSI_".$InsVehiculoMarca->VmaNombre."_".$POST_Mes."_".$POST_Ano.".xls";
		exit();
		
?>