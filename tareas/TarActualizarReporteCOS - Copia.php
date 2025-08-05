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




require_once($InsPoo->MtdPaqReporte().'ClsReporteCOS.php');

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
require_once($InsPoo->MtdPaqReporte().'ClsReporteCOS.php');
require_once($InsPoo->MtdPaqEmpresa().'ClsSucursal.php');

//$GET_VehiculoMarcaId = (empty($_GET['VehiculoMarcaId'])?"VMA-10017":$_GET['VehiculoMarcaId']);
$GET_Ano = (empty($_GET['Ano'])?date("Y"):$_GET['Ano']);
$GET_Mes = (empty($_GET['Mes'])?date("m"):$_GET['Mes']);
$GET_VehiculoMarca = (empty($_GET['VehiculoMarca'])?"VMA-10017":$_GET['VehiculoMarca']);
$GET_Sucursal = (empty($_GET['Sucursal'])?(($_SESSION['SesionSucursal'])):$_GET['Sucursal']);

if(empty($GET_VehiculoMarca) or empty($GET_Ano) or empty($GET_Mes)){
	die("No se ha especificado el año, mes o marca de vehiculo.");
}



$InsVehiculoMarca = new ClsVehiculoMarca();
$InsVehiculoMarca->VmaId = $GET_VehiculoMarca;
$InsVehiculoMarca->MtdObtenerVehiculoMarca();



$InsSucursal = new ClsSucursal();
$RepSucursal = $InsSucursal->MtdObtenerSucursales("SucId",$GET_Sucursal,"SucNombre","ASC",NULL);
$ArrSucursales = $RepSucursal['Datos'];

if(!empty($ArrSucursales)){
	foreach($ArrSucursales as $DatSucursal){
		
		echo "<br>";
		echo "<br>";
		
		echo "Sucursal: ".$DatSucursal->SucNombre;		
		echo "<br>";
		
		$InsReporteCOS = new ClsReporteCOS();
		//MtdObtenerReporteCOSs($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'RcoId',$oSentido = 'Desc',$oPaginacion = '0,10',$oAno=NULL,$oMes=NULL,$oVehiculoMarca=NULL,$oSucursal=NULL)
		$ResReporteCOS = $InsReporteCOS->MtdObtenerReporteCOSs(NULL,NULL,NULL,'RcoId','Desc','1',$GET_Ano,$GET_Mes,$GET_VehiculoMarca,$DatSucursal->SucId);
		$ArrReporteCOSs = $ResReporteCOS['Datos'];
		
			
		$ReporteCOSId = "";
		
		if(!empty($ArrReporteCOSs)){
			foreach($ArrReporteCOSs as $DatReporteCOS){
				$ReporteCOSId = $DatReporteCOS->RcoId;
			}
		}
		
		
		echo "Marca Id: ".$InsVehiculoMarca->VmaNombre;
		echo "<br>";
		echo "Año: ".$GET_Ano;
		echo "<br>";
		echo "Mes: ".$GET_Mes ;
		echo "<br>";	
		
												
		//RcoNumeroCitas
		$InsCita = new ClsCita();
		//MtdObtenerCitasValor($oFuncion="SUM",$oParametro="FinId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'CitId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oCliente=NULL,$oPersonal=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oFecha="CitFecha",$oSinFichaIngreso=false,$oVehiculoIngresoId=NULL,$oVehiculoMarca=NULL,$oHoraInicio=NULL,$oHoraFin=NULL,$oSucursal=NULL) 
		$RcoNumeroCitas = $InsCita->MtdObtenerCitasValor("COUNT","CitId",$GET_Mes,$GET_Ano,NULL,NULL,NULL,"CitId","ASC",NULL,NULL,NULL,NULL,NULL,NULL,"CitFecha",false,NULL,$GET_VehiculoMarca,NULL,NULL,$DatSucursal->SucId);                            
		$RcoNumeroCitas = (empty($RcoNumeroCitas)?0:$RcoNumeroCitas);
		
		//RcoClientesParticulares
		$InsFichaIngreso = new ClsFichaIngreso();
		//MMtdObtenerFichaIngresosTotal($oFuncion="SUM",$oParametro="FacId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'FinId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oPrioridad=NULL,$oModalidadIngreso=NULL,$oVIN=NULL,$oClienteId=NULL,$oPersonalId=NULL,$oTrabajoConcluido=0,$oCampana=NULL,$oClienteTipo=NULL,$oVehiculoMarca=NULL,$oTipo=NULL,$oVehiculoTipo=NULL,$oVehiculoModelo=NULL,$oIgnorarReparacionesSinCosto=false,$oSucursal=NULL)
		$RcoClientesParticulares = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$GET_Mes,$GET_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,"LTI-10011",$GET_VehiculoMarca,1,NULL,NULL,false,$DatSucursal->SucId) ;
		$RcoClientesParticulares = (empty($RcoClientesParticulares)?0:$RcoClientesParticulares);
							
		//RcoClientesFlotas
		$InsFichaIngreso = new ClsFichaIngreso();
		//MMtdObtenerFichaIngresosTotal($oFuncion="SUM",$oParametro="FacId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'FinId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oPrioridad=NULL,$oModalidadIngreso=NULL,$oVIN=NULL,$oClienteId=NULL,$oPersonalId=NULL,$oTrabajoConcluido=0,$oCampana=NULL,$oClienteTipo=NULL,$oVehiculoMarca=NULL,$oTipo=NULL,$oVehiculoTipo=NULL,$oVehiculoModelo=NULL,$oIgnorarReparacionesSinCosto=false,$oSucursal=NULL)
		$RcoClientesFlotas = $InsFichaIngreso->MtdObtenerFichaIngresosTotal("COUNT","fin.FinId",$GET_Mes,$GET_Ano,NULL,NULL,NULL,'fin.FinId','ASC',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,"LTI-10010",$GET_VehiculoMarca,1,NULL,NULL,false,$DatSucursal->SucId) ;
		$RcoClientesFlotas = (empty($RcoClientesFlotas)?0:$RcoClientesFlotas);
					
		//RcoPromedioPermanencia
		$InsReporteFichaIngreso = new ClsReporteFichaIngreso();
		//MtdObtenerReporteFichaIngresoPromedioTiempoTrabajoTerminadoBruto($oAno=NULL,$oMes=NULL,$oVehiculoMarca=NULL,$oFichaIngresoModalidadIngreso=NULL,$oSucursal=NULL)
		$RcoPromedioPermanencia = $InsReporteFichaIngreso->MtdObtenerReporteFichaIngresoPromedioTiempoTrabajoTerminadoBruto($GET_Ano,$GET_Mes,$GET_VehiculoMarca,NULL,$DatSucursal->SucId);
		$RcoPromedioPermanencia = $RcoPromedioPermanencia/86400;
						
		//RcoParalizados
		$RcoParalizados = 0;
		
		//RcoPersonalMecanicos
		$RcoPersonalMecanicos = 3;
		
		//RcoPersonalAsesores
		$RcoPersonalAsesores = 1;
		
		//RcoPersonalOtros
		$RcoPersonalOtros = 0;
		
		//RcoDiasLaborados
		$CantidadDiasMensual = cal_days_in_month(CAL_GREGORIAN, $GET_Mes, $GET_Ano); // 31
		$RcoDiasLaborados = $CantidadDiasMensual - 4;
		
		//RcoHoraDisponibles
		$RcoHoraDisponibles = $RcoDiasLaborados * 8;
		
		//RcoHoraLaboradas
		//MtdObtenerReporteFichaIngresoPromedioTrabajo($oAno=NULL,$oMes=NULL,$oVehiculoMarca=NULL,$oFichaIngresoModalidadIngreso=NULL) {
		$InsReporteFichaIngreso = new ClsReporteFichaIngreso();
		//MtdObtenerReporteFichaIngresoPromedioTiempoTallerConcluido($oAno=NULL,$oMes=NULL,$oVehiculoMarca=NULL,$oFichaIngresoModalidadIngreso=NULL,$oSucursal=NULL) 
		$RcoHoraLaboradas = $InsReporteFichaIngreso->MtdObtenerReporteFichaIngresoPromedioTiempoTallerConcluido($GET_Ano,$GET_Mes,$GET_VehiculoMarca,NULL,$DatSucursal->SucId);
		$RcoHoraLaboradas = (empty($RcoHoraLaboradas)?0:$RcoHoraLaboradas);
		
		//RcoTarifaMO
		$RcoTarifaMO = 30;
		
		//RcoHoraMOVendidas
		//MtdObtenerReporteFichaIngresoSumaTiempoConcluido($oAno=NULL,$oMes=NULL,$oVehiculoMarca=NULL,$oFichaIngresoModalidadIngreso=NULL)
		$InsReporteFichaIngreso = new ClsReporteFichaIngreso();
		//MtdObtenerReporteFichaIngresoSumaTiempoConcluido($oAno=NULL,$oMes=NULL,$oVehiculoMarca=NULL,$oFichaIngresoModalidadIngreso=NULL,$oSucursal=NULL)
		$RcoHoraMOVendidas = $InsReporteFichaIngreso->MtdObtenerReporteFichaIngresoSumaTiempoConcluido($GET_Ano,$GET_Mes,$GET_VehiculoMarca,NULL,$DatSucursal->SucId);
		$RcoHoraMOVendidas = (empty($RcoHoraMOVendidas)?0:$RcoHoraMOVendidas);
		
		//RcoVentaManoObra
		$InsFichaAccion = new ClsFichaAccion();
		//MtdObtenerFichaAccionesTotal($oFuncion="SUM",$oParametro="FacId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'FccId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFichaIngresoModalidad=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oFichaIngresoEstado=NULL,$oPorFacturar=false,$oPorGenerarGarantia=false,$oFichaIngresoModalidadIngreso=NULL,$oVehiculoMarca=NULL,$oSucursal=NULL)
		$RcoVentaManoObra = $InsFichaAccion->MtdObtenerFichaAccionesTotal("SUM","FccManoObra",$GET_Mes,$GET_Ano,NULL,NULL,NULL,'fcc.FccId','ASC',NULL,NULL,NULL,NULL,NULL,NULL,false,false,NULL,$GET_VehiculoMarca,$DatSucursal->SucId);
		$RcoVentaManoObra = (empty($RcoVentaManoObra)?0:$RcoVentaManoObra);
		 
		//RcoVentaRepuestos
		$InsReporteFacturacion = new ClsReporteFacturacion();
//MtdObtenerFacturacionTaller($oFuncion="SUM",$oParametro="FacTotal",$oAno=NULL,$oMes=NULL,$oVehiculoMarca=NULL,$oProductoTipo=NULL,$oFichaIngresoModalidadIngreso=NULL,$oOrden=NULL,$oSentido=NULL,$oPaginacion=NULL,$oSucursal=NULL)
		$RcoVentaRepuestos = $InsReporteFacturacion->MtdObtenerFacturacionTaller("SUM","FdeImporte",$GET_Ano,$GET_Mes,$GET_VehiculoMarca,"RTI-10000","MIN-10001,MIN-10003,MIN-10007","fde.FdeId","DESC",NULL,$DatSucursal->SucId) ;
		$RcoVentaRepuestos = (empty($RcoVentaRepuestos)?0:$RcoVentaRepuestos);
		
		
		//$DatSucursal->SucId
		
		//RcoTicketPromedio              
		//$RcoTicketPromedio = ($RcoVentaManoObra + $RcoVentaRepuestos)/$TotalIngresoTipoMensual[$mes];
		
		//RcoTicketPromedio
		$RcoTicketPromedio = 0;
		
		//RcoVentaGarantiaFA
		$RcoVentaGarantiaFA = 0;
		
		
		
		echo "ReporteCOSId: ".$ReporteCOSId ;
		echo "<br>";	
		
		echo "RcoNumeroCitas: ".$RcoNumeroCitas;
		echo "<br>";	
		
		echo "RcoClientesParticulares: ".$RcoClientesParticulares;
		echo "<br>";	
		
		echo "RcoClientesFlotas: ".$RcoClientesFlotas;
		echo "<br>";	
		
		echo "RcoPromedioPermanencia: ".$RcoPromedioPermanencia;
		echo "<br>";	
		
		echo "RcoParalizados: ".$RcoParalizados;
		echo "<br>";	
		
		
		echo "RcoPersonalMecanicos: ".$RcoPersonalMecanicos;
		echo "<br>";	
		
		echo "RcoPersonalAsesores: ".$RcoPersonalAsesores;
		echo "<br>";	
		
		echo "RcoPersonalOtros: ".$RcoPersonalOtros;
		echo "<br>";	
		
		echo "RcoDiasLaborados: ".$RcoDiasLaborados;
		echo "<br>";	
		
		echo "RcoHoraDisponibles: ".$RcoHoraDisponibles;
		echo "<br>";	
		
		echo "RcoHoraLaboradas: ".$RcoHoraLaboradas;
		echo "<br>";	
		
		echo "RcoTarifaMO: ".$RcoTarifaMO;
		echo "<br>";	
		
		echo "RcoHoraMOVendidas: ".$RcoHoraMOVendidas;
		echo "<br>";	
		
		echo "RcoVentaManoObra: ".$RcoVentaManoObra;
		echo "<br>";	
		
		echo "RcoVentaRepuestos: ".$RcoVentaRepuestos;
		echo "<br>";	
		
		echo "RcoTicketPromedio: ".$RcoTicketPromedio;
		echo "<br>";
		
		echo "RcoVentaGarantiaFA: ".$RcoVentaGarantiaFA;
		echo "<br>";	
		
		echo "RcoNumeroCitas: ".$RcoNumeroCitas;
		echo "<br>";	
		
		if(empty($ReporteCOSId)){
			
			$InsReporteCOS = new ClsReporteCOS();
			$InsReporteCOS->RcoId = NULL;
			$InsReporteCOS->SucId = $DatSucursal->SucId;			
			
			$InsReporteCOS->VmaId = $GET_VehiculoMarca;
			$InsReporteCOS->RcoMes = $GET_Mes;
			$InsReporteCOS->RcoAno = $GET_Ano;
			
			$InsReporteCOS->RcoNumeroCitas = $RcoNumeroCitas;
			$InsReporteCOS->RcoClientesParticulares = $RcoClientesParticulares;
			$InsReporteCOS->RcoClientesFlotas = $RcoClientesFlotas;
			$InsReporteCOS->RcoPromedioPermanencia = $RcoPromedioPermanencia;
			$InsReporteCOS->RcoParalizados = $RcoParalizados;
			
			$InsReporteCOS->RcoPersonalMecanicos = $RcoPersonalMecanicos;
			$InsReporteCOS->RcoPersonalAsesores = $RcoPersonalAsesores;
			$InsReporteCOS->RcoPersonalOtros = $RcoPersonalOtros;
			$InsReporteCOS->RcoDiasLaborados = $RcoDiasLaborados;
			$InsReporteCOS->RcoHoraDisponibles = $RcoHoraDisponibles;
			$InsReporteCOS->RcoHoraLaboradas = $RcoHoraLaboradas;
			$InsReporteCOS->RcoTarifaMO = $RcoTarifaMO;
			
			$InsReporteCOS->RcoHoraMOVendidas = $RcoHoraMOVendidas;
			$InsReporteCOS->RcoVentaManoObra = $RcoVentaManoObra;
			$InsReporteCOS->RcoVentaRepuestos = $RcoVentaRepuestos;
			$InsReporteCOS->RcoTicketPromedio = $RcoTicketPromedio;			
			$InsReporteCOS->RcoVentaGarantiaFA = $RcoVentaGarantiaFA;
			
			$InsReporteCOS->RcoTiempoCreacion = date("Y-m-d H:i:s");
			$InsReporteCOS->RcoTiempoModificacion = date("Y-m-d H:i:s");
		
			
			if($InsReporteCOS->MtdRegistrarReporteCOS()){				
				echo "Se registro los archivos COS";	
				echo "<br>";				
			}else {
				echo "No se pudo registrar los archivos COS";	
				echo "<br>";	
			}
			
		}else{
			
			
			echo "Se edito los archivos COS";	
			echo "<br>";	
		
			$InsReporteCOS = new ClsReporteCOS();
			$InsReporteCOS->MtdEditarReporteCOSDato("RcoNumeroCitas",$RcoNumeroCitas,$ReporteCOSId);
			$InsReporteCOS->MtdEditarReporteCOSDato("RcoClientesParticulares",$RcoClientesParticulares,$ReporteCOSId);
			$InsReporteCOS->MtdEditarReporteCOSDato("RcoClientesFlotas",$RcoClientesFlotas,$ReporteCOSId);
			$InsReporteCOS->MtdEditarReporteCOSDato("RcoPromedioPermanencia",$RcoPromedioPermanencia,$ReporteCOSId);
			$InsReporteCOS->MtdEditarReporteCOSDato("RcoParalizados",$RcoParalizados,$ReporteCOSId);
			
			$InsReporteCOS->MtdEditarReporteCOSDato("RcoPersonalMecanicos",$RcoPersonalMecanicos,$ReporteCOSId);
			$InsReporteCOS->MtdEditarReporteCOSDato("RcoPersonalAsesores",$RcoPersonalAsesores,$ReporteCOSId);
			$InsReporteCOS->MtdEditarReporteCOSDato("RcoPersonalOtros",$RcoPersonalOtros,$ReporteCOSId);
			$InsReporteCOS->MtdEditarReporteCOSDato("RcoDiasLaborados",$RcoDiasLaborados,$ReporteCOSId);
			$InsReporteCOS->MtdEditarReporteCOSDato("RcoHoraDisponibles",$RcoHoraDisponibles,$ReporteCOSId);
			$InsReporteCOS->MtdEditarReporteCOSDato("RcoHoraLaboradas",$RcoHoraLaboradas,$ReporteCOSId);
			$InsReporteCOS->MtdEditarReporteCOSDato("RcoTarifaMO",$RcoTarifaMO,$ReporteCOSId);
			
			$InsReporteCOS->MtdEditarReporteCOSDato("RcoHoraMOVendidas",$RcoHoraMOVendidas,$ReporteCOSId);
			$InsReporteCOS->MtdEditarReporteCOSDato("RcoVentaManoObra",$RcoVentaManoObra,$ReporteCOSId);
			$InsReporteCOS->MtdEditarReporteCOSDato("RcoVentaRepuestos",$RcoVentaRepuestos,$ReporteCOSId);
			$InsReporteCOS->MtdEditarReporteCOSDato("RcoTicketPromedio",$RcoTicketPromedio,$ReporteCOSId);
			$InsReporteCOS->MtdEditarReporteCOSDato("RcoVentaGarantiaFA",$RcoVentaGarantiaFA,$ReporteCOSId);
			
		}




		
		
	}
}

echo "<hr>";
echo "PROCESO TERMINADO";
echo "<br>";
echo date("d/m/Y H:i:s");


?>