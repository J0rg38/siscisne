<?php
session_start();
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


require_once($InsPoo->MtdPaqReporte().'ClsReporteFichaIngreso.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoModalidad.php');
require_once($InsPoo->MtdPaqLogistica().'ClsPedidoCompra.php');
require_once($InsPoo->MtdPaqLogistica().'ClsPedidoCompraDetalle.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccion.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionTarea.php');

$InsReporteFichaIngreso = new ClsReporteFichaIngreso();
$InsFichaIngresoModalidad = new ClsFichaIngresoModalidad();
$InsPedidoCompra = new ClsPedidoCompra();
$InsPedidoCompraDetalle = new ClsPedidoCompraDetalle();

$InsFichaAccion = new ClsFichaAccion();
$InsFichaAccionTarea = new ClsFichaAccionTarea();

//case 1:		$Estado = "RECEPCION [Pendiente]";
//case 11:		$Estado = "RECEPCION [Enviado]";
//case 2:		$Estado = "TALLER [Revisando]";
//case 3:		$Estado = "TALLER [Preparando Pedido]";
//case 4:		$Estado = "TALLER [Pedido Enviado]";
//case 5:		$Estado = "ALMACEN [Revisado Pedido]";
//case 6:		$Estado = "ALMACEN [Preparando Pedido]";
//case 7:		$Estado = "ALMACEN [Pedido Enviado]";
//case 71:	$Estado = "TALLER [Pedido Recibido]";
//case 72:	$Estado = "ALMACEN [Pedido Extornado]";
//
//case 73:$Estado = "TALLER [Trabajo Terminado]";
//case 74:$Estado = "RECEPCION [Revisando]";
//
//case 75:$Estado = "RECEPCION [Conforme/Por Facturar]";
//case 8:	$Estado = "TALLER [Por Facturar]";
//case 9:	$Estado = "CONTABILIDAD [Facturado]";		

//MtdObtenerReporteFichaIngresoPendientes($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'FinId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oModalidadIngreso=NULL,$oDiaTranscurrido=NULL) {
$ResReporteFichaIngreso = $InsReporteFichaIngreso->MtdObtenerReporteFichaIngresoPendientes(NULL,NULL,NULL,"FinFecha","ASC","",date("Y")."-01-01",date("Y-m-d"),NULL,3,"11,2,3,4,5,6,7,71,72",1);
$ArrReporteFichaIngresos = $ResReporteFichaIngreso['Datos'];


$mensaje .= "<b><u>ORDENES DE TRABAJO PENDIENTES</u></b>";
$mensaje .= "<br>";	
$mensaje .= "<br>";	

$mensaje .= "<b>Fecha de aviso:</b> ".date("d/m/Y")."";	
$mensaje .= "<br>";
$mensaje .= "<b>Descripcion:</b> Ordenes de trabajo que no han sido concluidas en mas de 3 dias";
$mensaje .= "<br>";	

  
$mensaje .= "<hr>";
$mensaje .= "<br>";
  
	  $mensaje .= "<br>";

	  if(!empty($ArrReporteFichaIngresos)){	  
		  
		  $mensaje .= "<table cellpadding='2' cellspacing='0' width='100%' border='1'>";
		  
		  $mensaje .= "<tr>";
		  
			  $mensaje .= "<td width='2%'  align='center'>";
			  $mensaje .= "<b>#</b>";
			  $mensaje .= "</td>";

			  $mensaje .= "<td width='5%'  align='center'>";
			  $mensaje .= "<b>O.T.</b>";
			  $mensaje .= "</td>";
			  
			   $mensaje .= "<td width='10%'  align='center' >";
			  $mensaje .= "<b>MODALIDAD</b>";
			  $mensaje .= "</td>";
			  
			  $mensaje .= "<td  width='5%'  align='center' >";
			  $mensaje .= "<b>FECHA</b>";
			  $mensaje .= "</td >";

			  $mensaje .= "<td  width='5%'  align='center' >";
			  $mensaje .= "<b>DIAS TRANSC.</b>";
			  $mensaje .= "</td>";

			  $mensaje .= "<td  width='31%'  align='center' >";
			  $mensaje .= "<b>CLIENTE</b>";
			  $mensaje .= "</td>";
			  
			    $mensaje .= "<td  width='5%'  align='center' >";
			  $mensaje .= "<b>MODELO</b>";
			  $mensaje .= "</td>";
			  
			   $mensaje .= "<td  width='5%'  align='center' >";
			  $mensaje .= "<b>PLACA</b>";
			  $mensaje .= "</td>";
			  
				$mensaje .= "<td  width='15%'  align='center' >";
			  $mensaje .= "<b>ASESOR</b>";
			  $mensaje .= "</td>";
			  
			   
			 //  $mensaje .= "<td  width='15%'  align='center' >";
			 // $mensaje .= "<b>MECANICO</b>";
			 // $mensaje .= "</td>";
			  
			    $mensaje .= "<td  width='17%'  align='center' >";
			  $mensaje .= "<b>DIAGNOSTICO</b>";
			  $mensaje .= "</td>";
			  
			   $mensaje .= "<td  width='17%'  align='center' >";
			  $mensaje .= "<b>OBSERVACION</b>";
			  $mensaje .= "</td>";
			  
		  $mensaje .= "</tr>";
		  
		  
				  
	  $c = 1;	
	  
  foreach($ArrReporteFichaIngresos as $DatReporteFichaIngreso){

			  $mensaje .= "<tr>";
						  
				  $mensaje .= "<td>";
				  $mensaje .= $c;
				  $mensaje .= "</td>";
  
				  $mensaje .= "<td>";
				  $mensaje .= $DatReporteFichaIngreso->FinId;
				  $mensaje .= "</td>";
				  
				   $mensaje .= "<td>";
				   
					//$InsFichaIngresoModalidad = new ClsFichaIngresoModalidad();
			  
			  //function MtdObtenerFichaIngresoModalidades($oCampo=NULL,$oFiltro=NULL,$oOrden = 'FimId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFichaIngreso=NULL,$oEstado=NULL
					$ResFichaIngresoModalidad = $InsFichaIngresoModalidad->MtdObtenerFichaIngresoModalidades(NULL,NULL,'FimId','ASC',NULL,$DatReporteFichaIngreso->FinId,NULL);
					$ArrFichaIngresoModalidades = $ResFichaIngresoModalidad['Datos'];
					 
					if(!empty($ArrFichaIngresoModalidades)){						
						foreach($ArrFichaIngresoModalidades as $DatFichaIngresoModalidad){
						
	//						echo $DatFichaIngresoModalidad->MinNombre;
							$mensaje .= $DatFichaIngresoModalidad->MinNombre;
							$mensaje .= "<br>";
							
						}						
					}
					
					$mensaje .= "</td>";
		
				  
				  $mensaje .= "<td>";
				  $mensaje .= $DatReporteFichaIngreso->FinFecha;
				  $mensaje .= "</td >";

				  $mensaje .= "<td>";
				  $mensaje .= $DatReporteFichaIngreso->FinDiaTranscurrido;
				  $mensaje .= "</td>";
				  
				  $mensaje .= "<td>";
				  $mensaje .= $DatReporteFichaIngreso->CliNombre." ".$DatReporteFichaIngreso->CliApellidoPaterno." ".$DatReporteFichaIngreso->CliApellidoMaterno;
				  $mensaje .= "</td>";
				  
				  $mensaje .= "<td>";
				  $mensaje .= $DatReporteFichaIngreso->VmoNombre;
				  $mensaje .= "</td>";
				  
				  $mensaje .= "<td>";
				  $mensaje .= $DatReporteFichaIngreso->EinPlaca;
				  $mensaje .= "</td>";
				  
				   $mensaje .= "<td>";
				   $mensaje .= $DatReporteFichaIngreso->PerNombreAsesor." ".$DatReporteFichaIngreso->PerApellidoPaternoAsesor." ".$DatReporteFichaIngreso->PerApellidoMaternoAsesor;
					$mensaje .= "</td>";


				//   $mensaje .= "<td>";
				//  $mensaje .= $DatReporteFichaIngreso->PerNombre." ".$DatReporteFichaIngreso->PerApellidoPaterno." ".$DatReporteFichaIngreso->PerApellidoMaterno;
				//  $mensaje .= "</td>";

				  $mensaje .= "<td>";
				  
				  $diagnostico = "";
				  
				 if(!empty($ArrFichaIngresoModalidades)){			
						foreach($ArrFichaIngresoModalidades as $DatFichaIngresoModalidad){
							
							$diagnostico .= "";
							
//MtdObtenerFichaAcciones($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'FccId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFichaIngresoModalidad=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oFichaIngresoEstado=NULL,$oPorFacturar=false,$oPorGenerarGarantia=false,$oFichaIngresoModalidadIngreso=NULL,$oIgnorarTotalVacio=false,$oFacturable=NULL,$oGenerarFactura=false,$oTipoFecha="fcc.FccFecha") {
							$ResFichaAccion = $InsFichaAccion->MtdObtenerFichaAcciones(NULL,NULL,NULL,'FccId','Desc',NULL,$DatFichaIngresoModalidad->FimId,NULL,NULL,NULL,NULL,false,false,NULL,false,NULL,false,"fcc.FccFecha");								
							$ArrFichaAcciones = $ResFichaAccion['Datos'];
							
							//deb($ArrFichaAcciones);
							if(!empty($ArrFichaAcciones)){
								foreach ($ArrFichaAcciones as $DatFichaAccion){
									
									//MtdObtenerFichaAccionTareas($oCampo=NULL,$oFiltro=NULL,$oOrden = 'FatId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFichaAccion=NULL,$oEstado=NULL) {
									$ResFichaAccionTarea = $InsFichaAccionTarea->MtdObtenerFichaAccionTareas(NULL,NULL,'FatId','Desc',NULL,$DatFichaAccion->FccId,NULL);
									$ArrFichaAccionTareas = $ResFichaAccionTarea['Datos'];
									
									if(!empty($ArrFichaAccionTareas)){
										foreach($ArrFichaAccionTareas as $DatFichaAccionTarea){
												$diagnostico .= $DatFichaAccionTarea->FatDescripcion;
												$diagnostico .= ". ";
										}
									}
								
								}								
							}
							
						}						
					}
					
				$mensaje .= $diagnostico;
				
				
					 
				  $mensaje .= "</td>";
				  
				  $mensaje .= "<td>";
				  
				  if(!empty($DatReporteFichaIngreso->FinNota)){
					   $mensaje .= $DatReporteFichaIngreso->FinNota.": ";
				  }
				

//				  MtdObtenerPedidoCompras($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'PcoId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oMoneda=NULL,$oConOrdenCompra=0,$oVentaDirecta=NULL,$oOrdenCompra=NULL,$oFichaAccion=NULL,$oFichaIngreso=NULL,$oOrigen=array()) {
					$ResPedidoCompra = $InsPedidoCompra->MtdObtenerPedidoCompras(NULL,NULL,NULL,'PcoId','Desc','0,10',NULL,NULL,3,NULL,1,NULL,NULL,NULL,$DatReporteFichaIngreso->FinId,array());
					$ArrPedidoCompras = $ResPedidoCompra['Datos'];	
					
					if(!empty($ArrPedidoCompras)){
						
						$mensaje .= "Tiene (".count($ArrPedidoCompras).") pedido(s) ";
						
						$pedido_aux = "";
						
						foreach($ArrPedidoCompras as $DatPedidoCompra){
							
							$pedido = "";
												
							$ArrOrden = explode("-",$DatPedidoCompra->OcoId);	
							
							if($ArrOrden[1]=="STK"){
								$pedido .= "STOCK";
							}else if($ArrOrden[1]=="ZGAR"){
								$pedido .= "GARANTIA";
							}else if($ArrOrden[1]=="ZVOR"){
								$pedido .= "IMPORTACION";
							}else{
								$pedido .= "";
							}
							
							if($pedido<>$pedido_aux){
								$mensaje .= $pedido;
							}
							
							
							$mensaje .= "<br>";
							
							$pedido_aux = $pedido;
						}
						
						
						$pendientes = 0;
						foreach($ArrPedidoCompras as $DatPedidoCompra){
							
							//MtdObtenerPedidoCompraDetalles($oCampo=NULL,$oFiltro=NULL,$oOrden = 'PcdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oPedidoCompra=NULL,$oEstado=NULL,$oProducto=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oOrdenCompra=NULL,$oCliente=NULL,$oConOrdenCompra=NULL,$oVentaDirectaDetalleId=NULL,$oPedidoCompraEstado=NULL,$oFecha="PcoFecha",$oValidarRecibido=false,$oConFichaIngreso=false,$oOrdenCompraEstado=NULL) {
							$ResPedidoCompraDetalle =  $InsPedidoCompraDetalle->MtdObtenerPedidoCompraDetalles(NULL,NULL,NULL,NULL,'',$DatPedidoCompra->PcoId);
							$ArrPedidoCompraDetalles = 	$ResPedidoCompraDetalle['Datos'];	
							
							if(!empty($ArrPedidoCompraDetalles)){
								
								foreach($ArrPedidoCompraDetalles as $DatPedidoCompraDetalle ){
									//$DatPedidoCompraDetalle->PcdCantidadPendiente
									if($DatPedidoCompraDetalle->PcdCantidadPendiente>1){
										$pendientes++;
									}
									
								}
							}
							
							if($pendientes>0){
								$mensaje .= " con (".$pendientes.") repuestos pendientes ";								
							}
							
							$mensaje .= "<br>";
						}
						
					}
					
					
				  $mensaje .= "</td>";



					  
			  $mensaje .= "</tr>";

		  $c++;			
		  
	  
		  $Enviar = true;
	  
		  
				  
  }
	  

		  
			  
		  $mensaje .= "</table>";
		  
		  
	  }
	  
  
  
  $mensaje .= "<br>";
  $mensaje .= "<br>";
  $mensaje .= "Mensaje autogenerado por SISTEMA CYC a las ".date('d/m/Y H:i:s');
  
  
  echo $mensaje;
  
  if($Enviar){
	  
	  $InsCorreo = new ClsCorreo();	
	  $InsCorreo->MtdEnviarCorreo("jblanco@cyc.com.pe,dvercelone@cyc.com.pe,jmaquera@cyc.com.pe,iquezada@cyc.com.pe,scanepam@cyc.com.pe","sistema@cyc.com.pe","C&C S.A.C.","AVISO: ORDENES DE TRABAJO PENDIENTES",$mensaje);
	  
  }
				
				
				
//		}


?>