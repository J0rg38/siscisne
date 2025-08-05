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

$GET_Fecha = (empty($_GET['Fecha'])?date("d/m/Y"):$_GET['Fecha']);

list($Dia,$Mes,$Ano) = explode("/",$GET_Fecha);

//CLASES
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngreso.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoMarca.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoModelo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoVersion.php');
require_once($InsPoo->MtdPaqEmpresa().'ClsSucursal.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoCierreInventario.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculo.php');


//INSTANCIAS
$InsVehiculoIngreso = new ClsVehiculoIngreso();
$InsVehiculoMarca = new ClsVehiculoMarca();
$InsVehiculoModelo = new ClsVehiculoModelo();
$InsVehiculoVersion = new ClsVehiculoVersion();
$InsSucursal = new ClsSucursal();

$ResVehiculoIngreso = $InsVehiculoIngreso->MtdObtenerVehiculoIngresos(NULL,NULL,NULL,"EinId","ASC",NULL,1,NULL,NULL,$POST_EstadoVehicular,$POST_VehiculoMarcaId,$POST_VehiculoModeloId,$POST_VehiculoVersionId,NULL,NULL,NULL,NULL,"EinFechaRecepcion",NULL,NULL,$POST_Sucursal);
$ArrVehiculoIngresos = $ResVehiculoIngreso['Datos'];

//MtdObtenerVehiculoIngresoAnoFabricaciones($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'EinId',$oSentido = 'Desc',$oPaginacion = '0,10') {
$ResVehiculoIngresoAno = $InsVehiculoIngreso->MtdObtenerVehiculoIngresoAnoFabricaciones(NULL,NULL,NULL,'EinAnoFabricacion','ASC',NULL);
$ArrVehiculoIngresoAnos = $ResVehiculoIngresoAno['Datos'];

echo "Total de años de vehiculos encontrados: ".count($ArrVehiculoIngresoAnos);
echo "<br>";
echo "<br>";
$RepVehiculoMarca = $InsVehiculoMarca->MtdObtenerVehiculoMarcas(NULL,NULL,"VmaNombre","ASC",NULL);
$ArrVehiculoMarcas = $RepVehiculoMarca['Datos'];

if(!empty($ArrVehiculoMarcas)){
	foreach($ArrVehiculoMarcas as $DatVehiculoMarca){
		
		echo "VmaNombre: ".$DatVehiculoMarca->VmaNombre;
		echo "<br>";
		
		$RepVehiculoModelo = $InsVehiculoModelo->MtdObtenerVehiculoModelos(NULL,NULL,"VmoNombre","ASC",NULL,$DatVehiculoMarca->VmaId);
		$ArrVehiculoModelos = $RepVehiculoModelo['Datos'];
		
		if(!empty($ArrVehiculoModelos)){
			foreach($ArrVehiculoModelos as $DatVehiculoModelo){				
				
					echo "VmoNombre: ".$DatVehiculoModelo->VmoNombre;
					echo "<br>";
		
				//MtdObtenerVehiculoVersiones($oCampo=NULL,$oFiltro=NULL,$oOrden = 'VveId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVehiculoMarca=NULL,$oVehiculoModelo=NULL,$oVigenciaVenta=NULL,$oEstado=NULL)
				$RepVehiculoVersion = $InsVehiculoVersion->MtdObtenerVehiculoVersiones(NULL,NULL,"VveNombre","ASC",NULL,NULL,$DatVehiculoModelo->VmoId,NULL,NULL);
				$ArrVehiculoVersiones = $RepVehiculoVersion['Datos'];
				
				if(!empty($ArrVehiculoVersiones)){
					foreach($ArrVehiculoVersiones as $DatVehiculoVersion){
					
					echo "VveNombre: ".$DatVehiculoVersion->VveNombre;
					echo "<br>";
		
						if(!empty($ArrVehiculoIngresoAnos)){
							foreach($ArrVehiculoIngresoAnos as $DatVehiculoIngresoAno){
							
							echo "EinAnoFabricacion: ".$DatVehiculoIngresoAno->EinAnoFabricacion;
								echo "<br>";
					
								$InsVehiculoIngreso = new ClsVehiculoIngreso();
								//MtdObtenerVehiculoIngresosValor($oFuncion="SUM",$oParametro="EinId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'EinId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oTipo=NULL,$oCliente=NULL,$oEstadoVehicular=NULL,$oVehiculoMarca=NULL,$oVehiculoModelo=NULL,$oVehiculoVersion=NULL,$oAnoModelo=NULL,$oAnoFabricacion=NULL,$oColor=NULL,$oConProforma=NULL,$oFecha="EinFechaRecepcion",$oFechaInicio=NULL,$oFechaFin=NULL,$oSucursal=NULL,$oConcesionario=NULL) 
								//$VehiculoIngresoTotal = $InsVehiculoIngreso->MtdObtenerVehiculoIngresosValor("COUNT","ein.EinId",NULL,NULL,NULL,NULL,NULL,'EinComprobanteCompraFecha','DESC','1',1,NULL,NULL,"STOCK",NULL,NULL,$DatVehiculoVersion->VveId,NULL,$DatVehiculoIngresoAno->EinAnoFabricacion,NULL,NULL,"EinComprobanteCompraFecha",NULL,NULL,NULL,NULL);	
								
								//MtdObtenerVehiculoIngresos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'EinId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oTipo=NULL,$oCliente=NULL,$oEstadoVehicular=NULL,$oVehiculoMarca=NULL,$oVehiculoModelo=NULL,$oVehiculoVersion=NULL,$oAnoModelo=NULL,$oAnoFabricacion=NULL,$oColor=NULL,$oConProforma=NULL,$oFecha="EinFechaRecepcion",$oFechaInicio=NULL,$oFechaFin=NULL,$oSucursal=NULL,$oConcesionario=NULL)
								$ResVehiculoIngreso = $InsVehiculoIngreso->MtdObtenerVehiculoIngresos(NULL,NULL,NULL,"EinEstadoVehicular","ASC",NULL,1,NULL,NULL,"STOCK,VENDIDO,RESERVADO,C/INCIDENCIA,TRAMITE",NULL,NULL,$DatVehiculoVersion->VveId,NULL,$DatVehiculoIngresoAno->EinAnoFabricacion,NULL,NULL,"EinFechaRecepcion",NULL,NULL,NULL);
								$ArrVehiculoIngresos = $ResVehiculoIngreso['Datos'];
								
								$TotalLibre = 0;
								if(!empty($ArrVehiculoIngresos)){
									foreach($ArrVehiculoIngresos as $DatVehiculoIngreso){
										
										//MtdObtenerOrdenVentaVehiculos($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'OvvId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oMoneda=NULL,$oPersonal=NULL,$oCliente=NULL,$oConCotizacion=0,$oFacturable=NULL,$oCotizacionVehiculo=NULL,$oVehiculoIngreso=NULL,$oSucursal=NULL,$oAprobacion1=NULL,$oAprobacion2=NULL,$oAprobacion3=NULL,$oTieneActaFechaEntrega=0,$oTieneComprobante=false) 
										$InsOrdenVentaVehiculo = new ClsOrdenVentaVehiculo();
										$ResOrdenVentaVehiculo = $InsOrdenVentaVehiculo->MtdObtenerOrdenVentaVehiculos("EinVIN","contiene",$DatVehiculoIngreso->EinVIN,'OvvFecha','Desc','1',NULL,FncCambiaFechaAMysql($GET_Fecha),"2,3,4,5",NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,false) ;
										$ArrOrdenVentaVehiculos = $ResOrdenVentaVehiculo['Datos'];
										
										if(empty($ArrOrdenVentaVehiculos)){
											$TotalLibre++;
										}
											
									}
								}


									////////////////////////////////////////////////////
									
									if($TotalLibre>0){
										$InsVehiculoCierreInventario = new ClsVehiculoCierreInventario();
										//$InsVehiculoCierreInventario->MtdObtenerVehiculoCierreInventarios(NULL,NULL,NULL,'VciId','ASC','1',1,$Ano,$Mes,$DatVehiculoVersion->VveId,$DatVehiculoIngresoAno->EinAnoFabricacion,NULL);
										$InsVehiculoCierreInventario->VveId = $DatVehiculoVersion->VveId;
										$InsVehiculoCierreInventario->VciFecha = FncCambiaFechaAMysql($GET_Fecha);
										$InsVehiculoCierreInventario->VciAno = $Ano;;
										$InsVehiculoCierreInventario->VciMes = $Mes;
										$InsVehiculoCierreInventario->VciCantidad = $TotalLibre;
										$InsVehiculoCierreInventario->VciAnoFabricacion = $DatVehiculoIngresoAno->EinAnoFabricacion;
										$InsVehiculoCierreInventario->VciAnoModelo = NULL;
										$InsVehiculoCierreInventario->VciEstado = 1;
										$InsVehiculoCierreInventario->VciTiempoCreacion = date("Y-m-d H:i:s");
										$InsVehiculoCierreInventario->VciTiempoModificacion = date("Y-m-d H:i:s");
										
										if($InsVehiculoCierreInventario->MtdRegistrarVehiculoCierreInventario()){
											
										}
									}
									
																	//MtdObtenerVehiculoCierreInventarios($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'VciId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oAno=NULL,$oMes=NULL,$oVehiculoVersionId=NULL,$oAnoFabricacion=NULL,$oAnoModelo=NULL)
								
								echo "<br>";
							}
						}
						
						
					}
				}

			}
		}

	}
}


echo "<hr>";

echo "PROCESO TERMINADO";
echo "<br>";
echo date("d/m/Y H:i:s");
?>