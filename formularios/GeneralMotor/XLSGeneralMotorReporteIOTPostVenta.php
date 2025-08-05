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
$POST_Sucursal = ($_GET['Sucursal']);
$POST_IncluirCSI = ($_GET['IncluirCSI']);
require_once($InsPoo->MtdPaqReporte().'ClsReporteFichaIngreso.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoModalidad.php');

$InsReporteFichaIngreso = new ClsReporteFichaIngreso();

////MtdObtenerReporteFichaIngresos($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'FinId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oModalidadIngreso=NULL,$oAgrupar=NULL,$oIOTIncluir=NULL,$oCliente=NULL,$oUnicos=false,$oVehiculoMarca=NULL,$oModalidadIngresoUnico=false,$oSucursal=NULL)
//$ArrReporteFichaIngresos = $ResReporteFichaIngreso['Datos'];
$ResReporteFichaIngreso = $InsReporteFichaIngreso->MtdObtenerReporteFichaIngresos(NULL,NULL,NULL ,$POST_ord ,$POST_sen,NULL,FncCambiaFechaAMysql($POST_finicio),FncCambiaFechaAMysql($POST_ffin),NULL,"fin.FinId",$POST_IncluirCSI,NULL,true,$POST_VehiculoMarca,false,$POST_Sucursal);
$ArrReporteFichaIngresos = $ResReporteFichaIngreso['Datos'];

	
 // Create new PHPExcel object
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
										   
			  $objPHPExcel = $objReader->load("../../plantilla/TemIOTPostVenta.xls");
			  
			  

		//DATOS 
		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('D2', $EmpresaNombre);
							
		$fila = 5;
		if(!empty($ArrReporteFichaIngresos)){
			foreach($ArrReporteFichaIngresos as $DatReporteFichaIngreso){
				
				$DatReporteFichaIngreso->CliProvincia = trim($DatReporteFichaIngreso->CliProvincia);
					 
					 
			 	$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue(FncConvertirNumeroALetraExcel(1).$fila, $DatReporteFichaIngreso->FinId);

			 	$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue(FncConvertirNumeroALetraExcel(4).$fila, $EmpresaNombre);
								
				$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue(FncConvertirNumeroALetraExcel(5).$fila, $EmpresaDepartamento);
								
								$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue(FncConvertirNumeroALetraExcel(6).$fila, $DatReporteFichaIngreso->FinFecha);	
								 
						  list($Fecha,$Hora) = explode(" ",$DatReporteFichaIngreso->FinTiempoTrabajoTerminado);
						   	
																
								$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue(FncConvertirNumeroALetraExcel(7).$fila, $Fecha);
								
								
								$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue(FncConvertirNumeroALetraExcel(8).$fila, $DatReporteFichaIngreso->EinVIN);
								
								//Placa

								$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue(FncConvertirNumeroALetraExcel(9).$fila, $DatReporteFichaIngreso->EinPlaca);
								
								//Cliente _ Nombre
								$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue(FncConvertirNumeroALetraExcel(10).$fila, $DatReporteFichaIngreso->CliNombre);
								
								
								//Cliente _ Apellido
								$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue(FncConvertirNumeroALetraExcel(11).$fila, $DatReporteFichaIngreso->CliApellidoPaterno." ".$DatReporteFichaIngreso->CliApellidoMaterno);
								
								
								////Cliente _ Apellido
								$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue(FncConvertirNumeroALetraExcel(12).$fila, $DatReporteFichaIngreso->CliNumeroDocumento);
								
								$Tipo = "";
								
								if($DatReporteFichaIngreso->MinSigla == "MA"){
$Tipo = "1";	  
}else if($DatReporteFichaIngreso->MinSigla == "GA"){
 	  
	$Tipo = "2"; 
}else{
	$Tipo = "3";
 	  
}


								//Tipo de Evento
								$objPHPExcel->setActiveSheetIndex(0)
								//->setCellValue(FncConvertirNumeroALetraExcel(13).$fila, $DatReporteFichaIngreso->MinNombre." (".$DatReporteFichaIngreso->FinMantenimientoKilometraje." km)");
								->setCellValue(FncConvertirNumeroALetraExcel(13).$fila, $Tipo);
								
								//Descripcion Trabajo
								$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue(FncConvertirNumeroALetraExcel(14).$fila, $DatReporteFichaIngreso->FinNota);
								
								//Kilometraje
								$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue(FncConvertirNumeroALetraExcel(15).$fila, $DatReporteFichaIngreso->FinVehiculoKilometraje);
													
								//Descripción del Modelo
								$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue(FncConvertirNumeroALetraExcel(18).$fila, $DatReporteFichaIngreso->VmoNombre);
								
								//Modelo_Año
								$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue(FncConvertirNumeroALetraExcel(19).$fila, $DatReporteFichaIngreso->EinAnoModelo);
	
									
								
								$Emails = "";
								if(!empty($DatReporteFichaIngreso->CliEmail)){
									$Emails .= $DatReporteFichaIngreso->CliEmail;	
								}else if(!empty($DatReporteFichaIngreso->CliContactoEmail1)){
									$Emails .= $DatReporteFichaIngreso->CliContactoEmail1;	
								}else if(!empty($DatReporteFichaIngreso->CliContactoEmail2)){
									$Emails .= $DatReporteFichaIngreso->CliContactoEmail2;
								}else if(!empty($DatReporteFichaIngreso->CliContactoEmail3)){
									$Emails .= $DatReporteFichaIngreso->CliContactoEmail3;	
								}else if(!empty($DatReporteFichaIngreso->CliEmailFacturacion)){
									$Emails .= $DatReporteFichaIngreso->CliEmailFacturacion;	
								}
														
								//$Emails = "";
								//$Emails .= $DatReporteFichaIngreso->CliEmail;
								//
								//$Emails .= (!empty($DatReporteFichaIngreso->CliContactoEmail1)?"/":"").$DatReporteFichaIngreso->CliContactoEmail1;
								//$Emails .= (!empty($DatReporteFichaIngreso->CliContactoEmail2)?"/":"").$DatReporteFichaIngreso->CliContactoEmail2;
								//$Emails .= (!empty($DatReporteFichaIngreso->CliContactoEmail3)?"/":"").$DatReporteFichaIngreso->CliContactoEmail3;
								//$Emails .= (!empty($DatReporteFichaIngreso->CliEmailFacturacion)?"/":"").$DatReporteFichaIngreso->CliEmailFacturacion;

								//E-mail
								$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue(FncConvertirNumeroALetraExcel(20).$fila,$Emails);
								
								//Nº Teléfono Residencia
								$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue(FncConvertirNumeroALetraExcel(21).$fila, $DatReporteFichaIngreso->CliTelefono);


								$Celular = "";
								if(!empty($DatReporteFichaIngreso->CliCelular)){
									$Celular .= $DatReporteFichaIngreso->CliCelular;	
								}else if(!empty($DatReporteFichaIngreso->CliContactoCelular1)){
									$Celular .= $DatReporteFichaIngreso->CliContactoCelular1;	
								}else if(!empty($DatReporteFichaIngreso->CliContactoCelular2)){
									$Celular .= $DatReporteFichaIngreso->CliContactoCelular2;
								}else if(!empty($DatReporteFichaIngreso->CliContactoCelular3)){
									$Celular .= $DatReporteFichaIngreso->CliContactoCelular3;
								}
								
								//Nº Teléfono Celular
								$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue(FncConvertirNumeroALetraExcel(22).$fila, $Celular);
								
								//Dirección del Comprador
								$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue(FncConvertirNumeroALetraExcel(23).$fila, $DatReporteFichaIngreso->CliDireccion);
															
								//Ciudad
								$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue(FncConvertirNumeroALetraExcel(24).$fila, ( empty($DatReporteFichaIngreso->CliDepartamento)?$DatReporteFichaIngreso->SucDepartamento:$DatReporteFichaIngreso->CliDepartamento));
								
								//Provincia
								$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue(FncConvertirNumeroALetraExcel(25).$fila, empty($DatReporteFichaIngreso->CliProvincia)?$DatReporteFichaIngreso->SucDepartamento:$DatReporteFichaIngreso->CliProvincia);
								
								//DNI Técnico
								$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue(FncConvertirNumeroALetraExcel(26).$fila, $DatReporteFichaIngreso->PerNumeroDocumento);
									
								//Nombre Técnico							
								$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue(FncConvertirNumeroALetraExcel(27).$fila, $DatReporteFichaIngreso->PerNombre);
								
								//Apellido Técnico
								$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue(FncConvertirNumeroALetraExcel(28).$fila, $DatReporteFichaIngreso->PerApellidoPaterno." ".$DatReporteFichaIngreso->PerApellidoMaterno);
								
								
							
								
								
								$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue(FncConvertirNumeroALetraExcel(29).$fila, $DatReporteFichaIngreso->RfiRepuestos);
								
								$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue(FncConvertirNumeroALetraExcel(30).$fila, $DatReporteFichaIngreso->RfiManoObra);
								
								$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue(FncConvertirNumeroALetraExcel(31).$fila, $DatReporteFichaIngreso->RfiLubricantes);
								
								$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue(FncConvertirNumeroALetraExcel(32).$fila, $DatReporteFichaIngreso->RfiOtros);
								
									$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue(FncConvertirNumeroALetraExcel(33).$fila, $DatReporteFichaIngreso->RfiTotales);
								
								
								


				$fila++;
			}	
		}

								
        // Rename worksheet
        //$objPHPExcel->getActiveSheet()->setTitle('COR - '.$InsVehiculoMarca->VmaNombre);
        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save("../../generados/reportes/IOT_POST_VENTA_".date("Y")."_".date("m")."_".date("d").".xls");
        
        //$objWriter->save(str_replace('.php', '.xls', __FILE__));
        /*
        <a href="<?php echo $InsOrdenCompra->OcoId;?>.xls">DESCARGAR: <?php echo $InsOrdenCompra->OcoId;?>.xls</a>
        */
        header("Location: ../../generados/reportes/IOT_POST_VENTA_".date("Y")."_".date("m")."_".date("d").".xls");
        // echo "MSI_".$InsVehiculoMarca->VmaNombre."_".$POST_Mes."_".$POST_Ano.".xls";
		exit();
		
?>