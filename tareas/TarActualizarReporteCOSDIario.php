<?php
session_start();
if(empty($_SESSION['MysqlDeb'])){$_SESSION['MysqlDeb'] = false;}
if(empty($_SESSION['MysqlDeb'])){$_SESSION['MysqlDebLevel'] = 0;}
if(!empty($_GET['d']) and !empty($_GET['v'])){if(($_GET['d']==1)){$_SESSION['MysqlDeb']=true;}else{$_SESSION['MysqlDeb']=false;}$_SESSION['MysqlDebLevel']=$_GET['v'];}


require_once('../proyecto/ClsProyecto.php');
require_once('../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../';
$InsPoo->Ruta = '../';

////CONFIGURACIONES GENERALES
require_once($InsProyecto->MtdRutConfiguraciones().'CnfSistema.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfEmpresa.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfConexion.php');
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




require_once($InsPoo->MtdPaqReporte().'ClsReporteCOSDiario.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsTallerPedido.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsTallerPedidoDetalle.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVentaConcretada.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVentaConcretadaDetalle.php');


require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoEntrada.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoEntradaDetalle.php');

require_once($InsPoo->MtdPaqActividad().'ClsFichaIngreso.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccion.php');

require_once($InsPoo->MtdPaqRRHH().'ClsPersonal.php');
require_once($InsPoo->MtdPaqActividad().'ClsPlanMantenimiento.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionProducto.php');
require_once($InsPoo->MtdPaqActividad().'ClsCita.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoMarca.php');
require_once($InsPoo->MtdPaqReporte().'ClsReporteFacturacion.php');
require_once($InsPoo->MtdPaqReporte().'ClsReporteFichaIngreso.php');
require_once($InsPoo->MtdPaqReporte().'ClsReporteCOSDiario.php');
require_once($InsPoo->MtdPaqEmpresa().'ClsSucursal.php');

require_once($InsPoo->MtdPaqEmpresa().'ClsSucursalDatoReporte.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsTipoCambio.php');


//$GET_VehiculoMarcaId = (empty($_GET['VehiculoMarcaId'])?"VMA-10017":$_GET['VehiculoMarcaId']);
$GET_Ano = (empty($_GET['Ano'])?date("Y"):$_GET['Ano']);
$GET_Mes = (empty($_GET['Mes'])?date("m"):$_GET['Mes']);
$GET_Dia = (empty($_GET['Dia'])?date("d"):$_GET['Dia']);

$GET_VehiculoMarca = (empty($_GET['VehiculoMarca'])?"VMA-10017":$_GET['VehiculoMarca']);
$GET_Sucursal = (empty($_GET['Sucursal'])?(($_SESSION['SesionSucursal'])):$_GET['Sucursal']);

if(empty($GET_VehiculoMarca) or empty($GET_Ano) or empty($GET_Mes)){
	die("No se ha especificado el año, mes o marca de vehiculo.");
}



$InsVehiculoMarca = new ClsVehiculoMarca();
$InsVehiculoMarca->VmaId = $GET_VehiculoMarca;
$InsVehiculoMarca->MtdObtenerVehiculoMarca();


$InsTipoCambio = new ClsTipoCambio();
$TipoCambioPromedioMensual = $InsTipoCambio->MtdObtenerTipoCambioPromedioMensual($GET_Ano,$GET_Mes,"MON-10001");
		 


$InsSucursal = new ClsSucursal();
$RepSucursal = $InsSucursal->MtdObtenerSucursales("SucId",$GET_Sucursal,"SucNombre","ASC",NULL);
$ArrSucursales = $RepSucursal['Datos'];

if(!empty($ArrSucursales)){
	foreach($ArrSucursales as $DatSucursal){
		
		echo "<br>";
		echo "<br>";
		
		echo "Sucursal: ".$DatSucursal->SucNombre;		
		echo "<br>";
		
		$InsReporteCOSDiario = new ClsReporteCOSDiario();
		//MtdObtenerReporteCOSDiarios($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'RcdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oAno=NULL,$oMes=NULL,$oVehiculoMarca=NULL,$oSucursal=NULL,$oDia=NULL)
		$ResReporteCOSDiario = $InsReporteCOSDiario->MtdObtenerReporteCOSDiarios(NULL,NULL,NULL,'RcdId','Desc','1',$GET_Ano,$GET_Mes,$GET_VehiculoMarca,$DatSucursal->SucId,$GET_Dia);
		$ArrReporteCOSDiarios = $ResReporteCOSDiario['Datos'];
		
		$ReporteCOSDiarioId = "";
		
		if(!empty($ArrReporteCOSDiarios)){
			foreach($ArrReporteCOSDiarios as $DatReporteCOSDiario){
				$ReporteCOSDiarioId = $DatReporteCOSDiario->RcdId;
			}
		}
		
		
		echo "Marca Id: ".$InsVehiculoMarca->VmaNombre;
		echo "<br>";
		echo "Año: ".$GET_Ano;
		echo "<br>";
		echo "Mes: ".$GET_Mes ;
		echo "<br>";
		echo "Dia: ".$GET_Dia ;
		echo "<br>";	
		
												
		//RcdNumeroCitas
		$InsCita = new ClsCita();
		//MtdObtenerCitasValor($oFuncion="SUM",$oParametro="FinId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'CitId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oCliente=NULL,$oPersonal=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oFecha="CitFecha",$oSinFichaIngreso=false,$oVehiculoIngresoId=NULL,$oVehiculoMarca=NULL,$oHoraInicio=NULL,$oHoraFin=NULL,$oSucursal=NULL,$oDia=NULL)
		$RcdNumeroCitas = $InsCita->MtdObtenerCitasValor("COUNT","CitId",$GET_Mes,$GET_Ano,NULL,NULL,NULL,"CitId","ASC",NULL,NULL,NULL,NULL,$GET_Ano."-".$GET_Mes."-".$GET_Dia,$GET_Ano."-".$GET_Mes."-".$GET_Dia,"CitFecha",false,NULL,$GET_VehiculoMarca,NULL,NULL,$DatSucursal->SucId,$GET_Dia);                            
		$RcdNumeroCitas = (empty($RcdNumeroCitas)?0:$RcdNumeroCitas);
		
		//RcdClientesParticulares
		$InsFichaIngreso = new ClsFichaIngreso();
		//MtdObtenerFichaIngresosTotal($oFuncion="SUM",$oParametro="FacId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'FinId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oPrioridad=NULL,$oModalidadIngreso=NULL,$oVIN=NULL,$oClienteId=NULL,$oPersonalId=NULL,$oTrabajoConcluido=0,$oCampana=NULL,$oClienteTipo=NULL,$oVehiculoMarca=NULL,$oTipo=NULL,$oVehiculoTipo=NULL,$oVehiculoModelo=NULL,$oIgnorarReparacionesSinCosto=false,$oSucursal=NULL,$oDia=NULL)
		$RcdClientesParticulares = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$GET_Mes,$GET_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,$GET_Ano."-".$GET_Mes."-".$GET_Dia,$GET_Ano."-".$GET_Mes."-".$GET_Dia,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,"LTI-10011",$GET_VehiculoMarca,1,NULL,NULL,false,$DatSucursal->SucId,$GET_Dia) ;
		$RcdClientesParticulares = (empty($RcdClientesParticulares)?0:$RcdClientesParticulares);
							
		//RcdClientesFlotas
		$InsFichaIngreso = new ClsFichaIngreso();
		//MtdObtenerFichaIngresosTotal($oFuncion="SUM",$oParametro="FacId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'FinId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oPrioridad=NULL,$oModalidadIngreso=NULL,$oVIN=NULL,$oClienteId=NULL,$oPersonalId=NULL,$oTrabajoConcluido=0,$oCampana=NULL,$oClienteTipo=NULL,$oVehiculoMarca=NULL,$oTipo=NULL,$oVehiculoTipo=NULL,$oVehiculoModelo=NULL,$oIgnorarReparacionesSinCosto=false,$oSucursal=NULL,$oDia=NULL)
		$RcdClientesFlotas = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$GET_Mes,$GET_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,$GET_Ano."-".$GET_Mes."-".$GET_Dia,$GET_Ano."-".$GET_Mes."-".$GET_Dia,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,"LTI-10010",$GET_VehiculoMarca,1,NULL,NULL,false,$DatSucursal->SucId,$GET_Dia) ;
		$RcdClientesFlotas = (empty($RcdClientesFlotas)?0:$RcdClientesFlotas);
					
		//RcdPromedioPermanencia
		$InsReporteFichaIngreso = new ClsReporteFichaIngreso();
		//MtdObtenerReporteFichaIngresoPromedioTiempoTrabajoTerminadoBruto($oAno=NULL,$oMes=NULL,$oVehiculoMarca=NULL,$oFichaIngresoModalidadIngreso=NULL,$oSucursal=NULL,$oDia=NULL)
		$RcdPromedioPermanencia = $InsReporteFichaIngreso->MtdObtenerReporteFichaIngresoPromedioTiempoTrabajoTerminadoBruto($GET_Ano,$GET_Mes,$GET_VehiculoMarca,NULL,$DatSucursal->SucId,$GET_Dia);
		$RcdPromedioPermanencia = $RcdPromedioPermanencia/86400;
						
		//RcdParalizados
		$RcdParalizados = 0;
		
		//RcdPersonalMecanicos
		$RcdPersonalMecanicos = 3;
		
		//RcdPersonalAsesores
		$RcdPersonalAsesores = 1;
		
		//RcdPersonalOtros
		$RcdPersonalOtros = 0;
		
		//RcdDiasLaborados
		$CantidadDiasMensual = cal_days_in_month(CAL_GREGORIAN, $GET_Mes, $GET_Ano); // 31
		//$RcdDiasLaborados = $CantidadDiasMensual - 4;
		$RcdDiasLaborados = 1;
		
		//RcdHoraDisponibles
		$RcdHoraDisponibles = $RcdDiasLaborados * 8;
		
		//RcdHoraLaboradas
		//MtdObtenerReporteFichaIngresoPromedioTrabajo($oAno=NULL,$oMes=NULL,$oVehiculoMarca=NULL,$oFichaIngresoModalidadIngreso=NULL) {
		$InsReporteFichaIngreso = new ClsReporteFichaIngreso();
		//MtdObtenerReporteFichaIngresoPromedioTiempoTallerConcluido($oAno=NULL,$oMes=NULL,$oVehiculoMarca=NULL,$oFichaIngresoModalidadIngreso=NULL,$oSucursal=NULL,$oDia=NULL)
		$RcdHoraLaboradas = $InsReporteFichaIngreso->MtdObtenerReporteFichaIngresoPromedioTiempoTallerConcluido($GET_Ano,$GET_Mes,$GET_VehiculoMarca,NULL,$DatSucursal->SucId,$GET_Dia);
		$RcdHoraLaboradas = (empty($RcdHoraLaboradas)?0:$RcdHoraLaboradas);
		
		//RcdTarifaMO
		$RcdTarifaMO = 30;
		
		//RcdHoraMOVendidas
		//MtdObtenerReporteFichaIngresoSumaTiempoConcluido($oAno=NULL,$oMes=NULL,$oVehiculoMarca=NULL,$oFichaIngresoModalidadIngreso=NULL)
		$InsReporteFichaIngreso = new ClsReporteFichaIngreso();
		//MtdObtenerReporteFichaIngresoSumaTiempoConcluido($oAno=NULL,$oMes=NULL,$oVehiculoMarca=NULL,$oFichaIngresoModalidadIngreso=NULL,$oSucursal=NULL,$oDia=NULL)
		$RcdHoraMOVendidas = $InsReporteFichaIngreso->MtdObtenerReporteFichaIngresoSumaTiempoConcluido($GET_Ano,$GET_Mes,$GET_VehiculoMarca,NULL,$DatSucursal->SucId,$GET_Dia);
		$RcdHoraMOVendidas = (empty($RcdHoraMOVendidas)?0:$RcdHoraMOVendidas);
		
		//RcdVentaManoObra
		$InsFichaAccion = new ClsFichaAccion();
		
		//MtdObtenerFichaAccionesTotal($oFuncion="SUM",$oParametro="FacId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'FccId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFichaIngresoModalidad=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oFichaIngresoEstado=NULL,$oPorFacturar=false,$oPorGenerarGarantia=false,$oFichaIngresoModalidadIngreso=NULL,$oVehiculoMarca=NULL,$oSucursal=NULL,$oDia=NULL)
		
		$RcdVentaManoObra = $InsFichaAccion->MtdObtenerFichaAccionesTotal("SUM","FccManoObra",$GET_Mes,$GET_Ano,NULL,NULL,NULL,'fcc.FccId','ASC',NULL,NULL,$GET_Ano."-".$GET_Mes."-".$GET_Dia,$GET_Ano."-".$GET_Mes."-".$GET_Dia,NULL,NULL,false,false,NULL,$GET_VehiculoMarca,$DatSucursal->SucId,$GET_Dia);
		$RcdVentaManoObra = (empty($RcdVentaManoObra)?0:$RcdVentaManoObra);
		 
		//RcdVentaRepuestos
		//$InsReporteFacturacion = new ClsReporteFacturacion();
//function MtdObtenerFacturacionTaller($oFuncion="SUM",$oParametro="FacTotal",$oAno=NULL,$oMes=NULL,$oVehiculoMarca=NULL,$oProductoTipo=NULL,$oFichaIngresoModalidadIngreso=NULL,$oOrden=NULL,$oSentido=NULL,$oPaginacion=NULL,$oSucursal=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oDia=NULL)
		//$RcdVentaRepuestos = $InsReporteFacturacion->MtdObtenerFacturacionTaller("SUM","FdeImporte",$GET_Ano,$GET_Mes,$GET_VehiculoMarca,"RTI-10000","MIN-10001,MIN-10003,MIN-10007","fde.FdeId","DESC",NULL,$DatSucursal->SucId,NULL,NULL,$GET_Dia) ;
		//$RcdVentaRepuestos = (empty($RcdVentaRepuestos)?0:$RcdVentaRepuestos);
		
		
		//RcdVentaRepuestos
		$InsReporteFacturacion = new ClsReporteFacturacion();
		
		//MtdObtenerFacturacionTallerFacturas($oFuncion="SUM",$oParametro="FacTotal",$oAno=NULL,$oMes=NULL,$oVehiculoMarca=NULL,$oProductoTipo=NULL,$oFichaIngresoModalidadIngreso=NULL,$oOrden=NULL,$oSentido=NULL,$oPaginacion=NULL,$oSucursal=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oDia=NULL)
		$Facturas = $InsReporteFacturacion->MtdObtenerFacturacionTallerFacturas("SUM","FdeImporte",$GET_Ano,$GET_Mes,$GET_VehiculoMarca,"RTI-10000","MIN-10001,MIN-10003,MIN-10007","fde.FdeId","DESC",NULL,$DatSucursal->SucId,NULL,NULL,$GET_Dia) ;
		$Boletas = $InsReporteFacturacion->MtdObtenerFacturacionTallerBoletas("SUM","BdeImporte",$GET_Ano,$GET_Mes,$GET_VehiculoMarca,"RTI-10000","MIN-10001,MIN-10003,MIN-10007","bde.BdeId","DESC",NULL,$DatSucursal->SucId,NULL,NULL,$GET_Dia) ;

		$RcdVentaRepuestos = $Facturas + $Boletas;
		$RcdVentaRepuestos = $RcdVentaRepuestos/$TipoCambioPromedioMensual;
		$RcdVentaRepuestos = (empty($RcdVentaRepuestos)?0:$RcdVentaRepuestos);
		
		
		
		
		
		
		//$DatSucursal->SucId
		
		//RcdTicketPromedio              
		//$RcdTicketPromedio = ($RcdVentaManoObra + $RcdVentaRepuestos)/$TotalIngresoTipoMensual[$mes];
		
		//RcdTicketPromedio
		$RcdTicketPromedio = 0;
		
		//RcdVentaGarantiaFA
		$RcdVentaGarantiaFA = 0;
		
		
		
		echo "ReporteCOSDiarioId: ".$ReporteCOSDiarioId ;
		echo "<br>";	
		
		echo "RcdNumeroCitas: ".$RcdNumeroCitas;
		echo "<br>";	
		
		echo "RcdClientesParticulares: ".$RcdClientesParticulares;
		echo "<br>";	
		
		echo "RcdClientesFlotas: ".$RcdClientesFlotas;
		echo "<br>";	
		
		echo "RcdPromedioPermanencia: ".$RcdPromedioPermanencia;
		echo "<br>";	
		
		echo "RcdParalizados: ".$RcdParalizados;
		echo "<br>";	
		
		
		echo "RcdPersonalMecanicos: ".$RcdPersonalMecanicos;
		echo "<br>";	
		
		echo "RcdPersonalAsesores: ".$RcdPersonalAsesores;
		echo "<br>";	
		
		echo "RcdPersonalOtros: ".$RcdPersonalOtros;
		echo "<br>";	
		
		echo "RcdDiasLaborados: ".$RcdDiasLaborados;
		echo "<br>";	
		
		echo "RcdHoraDisponibles: ".$RcdHoraDisponibles;
		echo "<br>";	
		
		echo "RcdHoraLaboradas: ".$RcdHoraLaboradas;
		echo "<br>";	
		
		echo "RcdTarifaMO: ".$RcdTarifaMO;
		echo "<br>";	
		
		echo "RcdHoraMOVendidas: ".$RcdHoraMOVendidas;
		echo "<br>";	
		
		echo "RcdVentaManoObra: ".$RcdVentaManoObra;
		echo "<br>";	
		
		echo "RcdVentaRepuestos: ".$RcdVentaRepuestos;
		echo "<br>";	
		
		echo "RcdTicketPromedio: ".$RcdTicketPromedio;
		echo "<br>";
		
		echo "RcdVentaGarantiaFA: ".$RcdVentaGarantiaFA;
		echo "<br>";	
		
		echo "RcdNumeroCitas: ".$RcdNumeroCitas;
		echo "<br>";	
		
		if(empty($ReporteCOSDiarioId)){
			
			$InsReporteCOSDiario = new ClsReporteCOSDiario();
			$InsReporteCOSDiario->RcdId = NULL;
			$InsReporteCOSDiario->SucId = $DatSucursal->SucId;			
			
			$InsReporteCOSDiario->VmaId = $GET_VehiculoMarca;
			$InsReporteCOSDiario->RcdMes = $GET_Mes;
			$InsReporteCOSDiario->RcdAno = $GET_Ano;
			$InsReporteCOSDiario->RcdDia = $GET_Dia;
			
			$InsReporteCOSDiario->RcdNumeroCitas = $RcdNumeroCitas;
			$InsReporteCOSDiario->RcdClientesParticulares = $RcdClientesParticulares;
			$InsReporteCOSDiario->RcdClientesFlotas = $RcdClientesFlotas;
			$InsReporteCOSDiario->RcdPromedioPermanencia = $RcdPromedioPermanencia;
			$InsReporteCOSDiario->RcdParalizados = $RcdParalizados;
			
			$InsReporteCOSDiario->RcdPersonalMecanicos = $RcdPersonalMecanicos;
			$InsReporteCOSDiario->RcdPersonalAsesores = $RcdPersonalAsesores;
			$InsReporteCOSDiario->RcdPersonalOtros = $RcdPersonalOtros;
			$InsReporteCOSDiario->RcdDiasLaborados = $RcdDiasLaborados;
			$InsReporteCOSDiario->RcdHoraDisponibles = $RcdHoraDisponibles;
			$InsReporteCOSDiario->RcdHoraLaboradas = $RcdHoraLaboradas;
			$InsReporteCOSDiario->RcdTarifaMO = $RcdTarifaMO;
			
			$InsReporteCOSDiario->RcdHoraMOVendidas = $RcdHoraMOVendidas;
			$InsReporteCOSDiario->RcdVentaManoObra = $RcdVentaManoObra;
			$InsReporteCOSDiario->RcdVentaRepuestos = $RcdVentaRepuestos;
			$InsReporteCOSDiario->RcdTicketPromedio = $RcdTicketPromedio;			
			$InsReporteCOSDiario->RcdVentaGarantiaFA = $RcdVentaGarantiaFA;
			
			$InsReporteCOSDiario->RcdTiempoCreacion = date("Y-m-d H:i:s");
			$InsReporteCOSDiario->RcdTiempoModificacion = date("Y-m-d H:i:s");
		
			
			if($InsReporteCOSDiario->MtdRegistrarReporteCOSDiario()){				
				echo "Se registro los archivos COS";	
				echo "<br>";				
			}else {
				echo "No se pudo registrar los archivos COS";	
				echo "<br>";	
			}
			
		}else{
			
			
			echo "Se edito los archivos COS";	
			echo "<br>";	
		
			$InsReporteCOSDiario = new ClsReporteCOSDiario();
			$InsReporteCOSDiario->MtdEditarReporteCOSDiarioDato("RcdNumeroCitas",$RcdNumeroCitas,$ReporteCOSDiarioId);
			$InsReporteCOSDiario->MtdEditarReporteCOSDiarioDato("RcdClientesParticulares",$RcdClientesParticulares,$ReporteCOSDiarioId);
			$InsReporteCOSDiario->MtdEditarReporteCOSDiarioDato("RcdClientesFlotas",$RcdClientesFlotas,$ReporteCOSDiarioId);
			$InsReporteCOSDiario->MtdEditarReporteCOSDiarioDato("RcdPromedioPermanencia",$RcdPromedioPermanencia,$ReporteCOSDiarioId);
			$InsReporteCOSDiario->MtdEditarReporteCOSDiarioDato("RcdParalizados",$RcdParalizados,$ReporteCOSDiarioId);
			
			$InsReporteCOSDiario->MtdEditarReporteCOSDiarioDato("RcdPersonalMecanicos",$RcdPersonalMecanicos,$ReporteCOSDiarioId);
			$InsReporteCOSDiario->MtdEditarReporteCOSDiarioDato("RcdPersonalAsesores",$RcdPersonalAsesores,$ReporteCOSDiarioId);
			$InsReporteCOSDiario->MtdEditarReporteCOSDiarioDato("RcdPersonalOtros",$RcdPersonalOtros,$ReporteCOSDiarioId);
			$InsReporteCOSDiario->MtdEditarReporteCOSDiarioDato("RcdDiasLaborados",$RcdDiasLaborados,$ReporteCOSDiarioId);
			$InsReporteCOSDiario->MtdEditarReporteCOSDiarioDato("RcdHoraDisponibles",$RcdHoraDisponibles,$ReporteCOSDiarioId);
			$InsReporteCOSDiario->MtdEditarReporteCOSDiarioDato("RcdHoraLaboradas",$RcdHoraLaboradas,$ReporteCOSDiarioId);
			$InsReporteCOSDiario->MtdEditarReporteCOSDiarioDato("RcdTarifaMO",$RcdTarifaMO,$ReporteCOSDiarioId);
			
			$InsReporteCOSDiario->MtdEditarReporteCOSDiarioDato("RcdHoraMOVendidas",$RcdHoraMOVendidas,$ReporteCOSDiarioId);
			$InsReporteCOSDiario->MtdEditarReporteCOSDiarioDato("RcdVentaManoObra",$RcdVentaManoObra,$ReporteCOSDiarioId);
			$InsReporteCOSDiario->MtdEditarReporteCOSDiarioDato("RcdVentaRepuestos",$RcdVentaRepuestos,$ReporteCOSDiarioId);
			$InsReporteCOSDiario->MtdEditarReporteCOSDiarioDato("RcdTicketPromedio",$RcdTicketPromedio,$ReporteCOSDiarioId);
			$InsReporteCOSDiario->MtdEditarReporteCOSDiarioDato("RcdVentaGarantiaFA",$RcdVentaGarantiaFA,$ReporteCOSDiarioId);
			
		}




		
		
	}
}

echo "<hr>";
echo "PROCESO TERMINADO";
echo "<br>";
echo date("d/m/Y H:i:s");


?>