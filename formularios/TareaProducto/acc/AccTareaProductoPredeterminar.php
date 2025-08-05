<?php
session_start();
require_once('../../../proyecto/ClsProyecto.php');
require_once('../../../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../../../';
$InsPoo->Ruta = '../../../';

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

$POST_ProductoId = $_POST['ProductoId'];
$POST_ProductoCantidad = $_POST['ProductoCantidad'];
$POST_ProductoUnidadMedidaConvertir = $_POST['ProductoUnidadMedidaConvertir'];
$POST_MarcaId = $_POST['MarcaId'];
$POST_ModeloId = $_POST['ModeloId'];
$POST_VersionId = $_POST['VersionId'];
$POST_PlanMantenimientoTareaId = $_POST['PlanMantenimientoTareaId'];
$POST_AlmacenId = $_POST['AlmacenId'];
$POST_ClienteTipoId = $_POST['ClienteTipoId'];
$POST_Importe = (empty($_POST['ProductoImporte'])?0:$_POST['ProductoImporte']);
//$POST_Precio = $_POST['Precio'];

require_once($InsPoo->MtdPaqActividad().'ClsTareaProducto.php');
require_once($InsPoo->MtdPaqActividad().'ClsPlanMantenimientoDetalle.php');
require_once($InsPoo->MtdPaqActividad().'ClsPlanMantenimientoTarea.php');
require_once($InsPoo->MtdPaqActividad().'ClsPlanMantenimiento.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoTipoUnidadMedida.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsListaPrecio.php');
require_once($InsPoo->MtdPaqLogistica().'ClsClienteTipo.php');
$InsTareaProducto = new ClsTareaProducto();
$InsPlanMantenimiento = new ClsPlanMantenimiento();

$ResPlanMantenimiento = $InsPlanMantenimiento->MtdObtenerPlanMantenimientos(NULL,NULL,NULL,'PmaId','ASC',1,NULL,NULL,$POST_ModeloId) ;
$ArrPlanMantenimientos = $ResPlanMantenimiento['Datos'];

$InsPlanMantenimiento->PmaId = $ArrPlanMantenimientos[0]->PmaId;
unset($ArrPlanMantenimientos);
$InsPlanMantenimiento->MtdObtenerPlanMantenimiento();

//MtdObtenerTareaProductos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'TprId',$oSentido = 'Desc',$oPaginacion = '0,10',$oPlanMantenimiento=NULL,$oKilometraje=NULL,$oTarea=NULL) 

$Precio = $POST_Importe/$POST_ProductoCantidad;
$ValorVenta = $Precio/(($EmpresaImpuestoVenta/100)+1);
$Impuesto = $Precio-$ValorVenta;

$Predetermino = true;

switch($POST_MarcaId){

	//case "VMA-10017"://CHEVROLET
	default://CHEVROLET
	
		if(!empty($InsPlanMantenimiento->PmaChevroletKilometrajes)){
			foreach($InsPlanMantenimiento->PmaChevroletKilometrajes as $DatKilometroEtiqueta => $DatKilometro){				

				//MtObtenerPlanMantenimientoDetalleAccion($oPlanMantenimiento=NULL,$oKilometraje=NULL,$oSeccion=NULL,$oTarea=NULL) 
				$InsPlanMantenimientoDetalle = new ClsPlanMantenimientoDetalle();
				$PlanMantenimientoDetalleAccion = $InsPlanMantenimientoDetalle->MtObtenerPlanMantenimientoDetalleAccion($InsPlanMantenimiento->PmaId,$DatKilometro['km'],NULL,$POST_PlanMantenimientoTareaId);	
				
					if($PlanMantenimientoDetalleAccion == "R" or
					$PlanMantenimientoDetalleAccion == "C" or
					$PlanMantenimientoDetalleAccion == "U"){
						
						//MtdObtenerTareaProductos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'TprId',$oSentido = 'Desc',$oPaginacion = '0,10',$oPlanMantenimiento=NULL,$oKilometraje=NULL,$oTarea=NULL) 
						
						$ResTareaProducto = $InsTareaProducto->MtdObtenerTareaProductos(NULL,NULL,NULL,'TprId','Desc','1',$InsPlanMantenimiento->PmaId,$DatKilometro['km'],$POST_PlanMantenimientoTareaId);
						$ArrTareaProductos = $ResTareaProducto['Datos'];
						
						
						if(!empty($ArrTareaProductos)){
							$TareaProductoId = "";
							foreach($ArrTareaProductos as $DatTareaProducto){
								
								$TareaProductoId = $DatTareaProducto->TprId;
							}
							
							if(!empty($TareaProductoId)){
								
								$InsTareaProducto = new ClsTareaProducto();	
								$InsTareaProducto->TprId = $TareaProductoId;
								$InsTareaProducto->ProId = $POST_ProductoId;
								$InsTareaProducto->UmeId = $POST_ProductoUnidadMedidaConvertir;
								$InsTareaProducto->TprPrecio = $Precio;
								
								$InsTareaProducto->AlmId = $POST_AlmacenId ;
								
								$InsTareaProducto->TprCantidad = eregi_replace(",","",(empty($POST_ProductoCantidad)?0:$POST_ProductoCantidad));
								$InsTareaProducto->TprKilometraje = $DatKilometro['km'];
								$InsTareaProducto->PmtId = $POST_PlanMantenimientoTareaId;
								$InsTareaProducto->PmaId = $InsPlanMantenimiento->PmaId;
								
								
								
								if($InsTareaProducto->MtdEditarTareaProducto()){
									
									$InsClienteTipo = new ClsClienteTipo();
									$RepClienteTipo = $InsClienteTipo->MtdObtenerClienteTipos("LtiId","esigual",$POST_ClienteTipoId,"LtiNombre","ASC",NULL);
									$ArrClienteTipos = $RepClienteTipo['Datos'];
									
									if(!empty($ArrClienteTipos)){
										foreach($ArrClienteTipos as $DatClienteTipo){
										
											//MtdObtenerListaPrecios($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'LprId',$oSentido = 'Desc',$oPaginacion = '0,10',$oProducto=NULL,$oClienteTipo=NULL,$oUnidadMedida=NULL)
											$InsListaPrecio = new ClsListaPrecio();
											$ResListaPrecio = $InsListaPrecio->MtdObtenerListaPrecios(NULL,NULL,NULL,'LprId','Desc','',$POST_ProductoId,$DatClienteTipo->LtiId,$POST_ProductoUnidadMedidaConvertir);
											$ArrListaPrecios = $ResListaPrecio['Datos'];
											
											$ListaPrecioId = "";
											
											if(!empty($ArrListaPrecios)){
												foreach($ArrListaPrecios as $DatListaPrecio){
													
													$ListaPrecioId = $DatListaPrecio->LprId;
															
												}
											}
											
											
												
												$InsListaPrecio = new ClsListaPrecio();
												$InsListaPrecio->LprId = $ListaPrecioId;		
												$InsListaPrecio->ProId = $POST_ProductoId;													
												$InsListaPrecio->LtiId = $DatClienteTipo->LtiId;
												$InsListaPrecio->UmeId = $POST_ProductoUnidadMedidaConvertir;
												
												$InsListaPrecio->LprCosto = 0;
							
												$InsListaPrecio->LprUtilidad = 0;
												$InsListaPrecio->LprOtroCosto = 0;
												$InsListaPrecio->LprManoObra = 0;
							
												$InsListaPrecio->LprAdicional = 0;
												$InsListaPrecio->LprDescuento = 0;
							
												$InsListaPrecio->LprPorcentajeUtilidad = 0;
												$InsListaPrecio->LprPorcentajeOtroCosto = 0;
												$InsListaPrecio->LprPorcentajeManoObra = 0;
							
												$InsListaPrecio->LprPorcentajeDescuento = 0;
												$InsListaPrecio->LprPorcentajeAdicional = 0;
												
												$InsListaPrecio->LprValorVenta = $ValorVenta;
												$InsListaPrecio->LprImpuesto = $Impuesto;
												$InsListaPrecio->LprPrecio = $Precio;
								
												$InsListaPrecio->LprTiempoCreacion = date("Y-m-d H:i:s");
												$InsListaPrecio->LprTiempoModificacion = date("Y-m-d H:i:s");
												$InsListaPrecio->LprEliminado = 1;
												
											if(!empty($ListaPrecioId)){
												
												$InsListaPrecio->MtdEditarListaPrecio();
												
											}else{
												
												$InsListaPrecio->MtdRegistrarListaPrecio();
												
											}
											
											
										}
									}
									
									
//									$Predetermino = 
								}else{
									$Predetermino = false;
								}
							
							}else{
								//echo "3";	
								$Predetermino = false;
							}
							
						}else{
							
							$InsTareaProducto = new ClsTareaProducto();	
							$InsTareaProducto->TprId = NULL;
							$InsTareaProducto->ProId = $POST_ProductoId;
							$InsTareaProducto->UmeId = $POST_ProductoUnidadMedidaConvertir;
							$InsTareaProducto->TprPrecio = $Precio;
							$InsTareaProducto->AlmId = $POST_AlmacenId ;
							
							$InsTareaProducto->TprCantidad = eregi_replace(",","",(empty($POST_ProductoCantidad)?0:$POST_ProductoCantidad));
							$InsTareaProducto->TprKilometraje = $DatKilometro['km'];
							$InsTareaProducto->PmtId = $POST_PlanMantenimientoTareaId;
							$InsTareaProducto->PmaId = $InsPlanMantenimiento->PmaId;
							
							if($InsTareaProducto->MtdRegistrarTareaProducto()){
								
								
								$InsClienteTipo = new ClsClienteTipo();
									$RepClienteTipo = $InsClienteTipo->MtdObtenerClienteTipos("LtiId","esigual",$POST_ClienteTipoId,"LtiNombre","ASC",NULL);
									$ArrClienteTipos = $RepClienteTipo['Datos'];
									
									if(!empty($ArrClienteTipos)){
										foreach($ArrClienteTipos as $DatClienteTipo){
										
											//MtdObtenerListaPrecios($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'LprId',$oSentido = 'Desc',$oPaginacion = '0,10',$oProducto=NULL,$oClienteTipo=NULL,$oUnidadMedida=NULL)
											$InsListaPrecio = new ClsListaPrecio();
											$ResListaPrecio = $InsListaPrecio->MtdObtenerListaPrecios(NULL,NULL,NULL,'LprId','Desc','',$POST_ProductoId,$DatClienteTipo->LtiId,$POST_ProductoUnidadMedidaConvertir);
											$ArrListaPrecios = $ResListaPrecio['Datos'];
											
											$ListaPrecioId = "";
											
											if(!empty($ArrListaPrecios)){
												foreach($ArrListaPrecios as $DatListaPrecio){
													
													$ListaPrecioId = $DatListaPrecio->LprId;
															
												}
											}
											
											
												
												$InsListaPrecio = new ClsListaPrecio();
												$InsListaPrecio->LprId = $ListaPrecioId;			
												$InsListaPrecio->LtiId = $DatClienteTipo->LtiId;
												$InsListaPrecio->UmeId = $POST_ProductoUnidadMedidaConvertir;
												
												$InsListaPrecio->LprCosto = 0;
							
												$InsListaPrecio->LprUtilidad = 0;
												$InsListaPrecio->LprOtroCosto = 0;
												$InsListaPrecio->LprManoObra = 0;
							
												$InsListaPrecio->LprAdicional = 0;
												$InsListaPrecio->LprDescuento = 0;
							
												$InsListaPrecio->LprPorcentajeUtilidad = 0;
												$InsListaPrecio->LprPorcentajeOtroCosto = 0;
												$InsListaPrecio->LprPorcentajeManoObra = 0;
							
												$InsListaPrecio->LprPorcentajeDescuento = 0;
												$InsListaPrecio->LprPorcentajeAdicional = 0;
												
												$InsListaPrecio->LprValorVenta = $ValorVenta;
												$InsListaPrecio->LprImpuesto = $Impuesto;
												$InsListaPrecio->LprPrecio = $Precio;
								
												$InsListaPrecio->LprTiempoCreacion = date("Y-m-d H:i:s");
												$InsListaPrecio->LprTiempoModificacion = date("Y-m-d H:i:s");
												$InsListaPrecio->LprEliminado = 1;
												
											if(!empty($ListaPrecioId)){
												
												$InsListaPrecio->MtdEditarListaPrecio();
												
											}else{
												
												$InsListaPrecio->MtdRegistrarListaPrecio();
												
											}
											
											
										}
									}
									
									
								//echo "1";	
							}else{
								//echo "2";	
								$Predetermino = false;
							}
							
						}
						
					
					}
			
				
				
			}				
		}
		
		if($Predetermino){
			echo "1";	
		}else{
			echo "2";
		}
						
	break;
	
	case "VMA-10018"://ISUZU

		if(!empty($InsPlanMantenimiento->PmaIsuzuKilometrajes)){
			foreach($InsPlanMantenimiento->PmaIsuzuKilometrajes as $DatKilometroEtiqueta => $DatKilometro){				

				//MtObtenerPlanMantenimientoDetalleAccion($oPlanMantenimiento=NULL,$oKilometraje=NULL,$oSeccion=NULL,$oTarea=NULL) 
				$InsPlanMantenimientoDetalle = new ClsPlanMantenimientoDetalle();
				$PlanMantenimientoDetalleAccion = $InsPlanMantenimientoDetalle->MtObtenerPlanMantenimientoDetalleAccion($InsPlanMantenimiento->PmaId,$DatKilometro['km'],NULL,$POST_PlanMantenimientoTareaId);	
				
					if($PlanMantenimientoDetalleAccion == "R" or
					$PlanMantenimientoDetalleAccion == "C" or
					$PlanMantenimientoDetalleAccion == "U"){
						
						//MtdObtenerTareaProductos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'TprId',$oSentido = 'Desc',$oPaginacion = '0,10',$oPlanMantenimiento=NULL,$oKilometraje=NULL,$oTarea=NULL) 
						
						$ResTareaProducto = $InsTareaProducto->MtdObtenerTareaProductos(NULL,NULL,NULL,'TprId','Desc','1',$InsPlanMantenimiento->PmaId,$DatKilometro['km'],$POST_PlanMantenimientoTareaId);
						$ArrTareaProductos = $ResTareaProducto['Datos'];
						
						
						if(!empty($ArrTareaProductos)){
							$TareaProductoId = "";
							foreach($ArrTareaProductos as $DatTareaProducto){
								
								$TareaProductoId = $DatTareaProducto->TprId;
							}
							
							if(!empty($TareaProductoId)){
								
								$InsTareaProducto = new ClsTareaProducto();	
								$InsTareaProducto->TprId = $TareaProductoId;
								$InsTareaProducto->ProId = $POST_ProductoId;
								$InsTareaProducto->UmeId = $POST_ProductoUnidadMedidaConvertir;
								
								$InsTareaProducto->AlmId = $POST_AlmacenId ;
								
								$InsTareaProducto->TprCantidad = eregi_replace(",","",(empty($POST_ProductoCantidad)?0:$POST_ProductoCantidad));
								
								$InsTareaProducto->TprKilometraje = $DatKilometro['km'];
								$InsTareaProducto->PmtId = $POST_PlanMantenimientoTareaId;
								$InsTareaProducto->PmaId = $InsPlanMantenimiento->PmaId;
								
								if($InsTareaProducto->MtdEditarTareaProducto()){
									//echo "1";	
								}else{
									$Predetermino = false;
									//echo "2";	
								}
							
							}else{
								//echo "3";	
								$Predetermino = false;
							}
							
						}else{
							
							$InsTareaProducto = new ClsTareaProducto();	
							$InsTareaProducto->TprId = NULL;
							$InsTareaProducto->ProId = $POST_ProductoId;
							$InsTareaProducto->UmeId = $POST_ProductoUnidadMedidaConvertir;
							
							$InsTareaProducto->AlmId = $POST_AlmacenId ;
							
							$InsTareaProducto->TprCantidad = eregi_replace(",","",(empty($POST_ProductoCantidad)?0:$POST_ProductoCantidad));
							
							$InsTareaProducto->TprKilometraje = $DatKilometro['km'];
							$InsTareaProducto->PmtId = $POST_PlanMantenimientoTareaId;
							$InsTareaProducto->PmaId = $InsPlanMantenimiento->PmaId;
							
							if($InsTareaProducto->MtdRegistrarTareaProducto()){
								//echo "1";	
							}else{
								//echo "2";	
								$Predetermino = false;
							}
							
						}
						
					
					}
			
				
				
			}				
		}
		
		if($Predetermino){
			echo "1";	
		}else{
			echo "2";
		}
		
	break;
	
	case "":
		echo "0";
	break;

}


?>