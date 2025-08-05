<?php
session_start();
require_once('../../../proyecto/ClsProyecto.php');
require_once('../../../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../../../';
$InsPoo->Ruta  = '../../../';

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
//	header("Content-Type: text/html");
//	header("Content-Disposition:  filename=\"LE".$EmpresaCodigo.date('d-m-Y').".txt\";");
//}

$POST_Sucursal = ($_GET['Sucursal']);
$POST_Sucursal = "";

$POST_FechaInicio = $_GET['FechaInicio'];
$POST_FechaFin = $_GET['FechaFin'];


require_once($InsPoo->MtdPaqContabilidad().'ClsFactura.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCliente.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsPago.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsNotaCredito.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsBoleta.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsNotaCredito.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsNotaDebito.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsKardexVehiculo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculo.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');


$InsPago = new ClsPago();
$InsFactura = new ClsFactura();
$InsMoneda = new ClsMoneda();
$InsCliente = new ClsCliente();
$InsNotaCredito = new ClsNotaCredito();
$InsBoleta = new ClsBoleta();
$InsNotaDebito = new ClsNotaDebito();
$InsKardexVehiculo = new ClsKardexVehiculo();
$InsVehiculo = new ClsVehiculo();

require_once($InsPoo->MtdPaqAlmacen().'ClsKardex.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProducto.php');
require_once($InsPoo->MtdPaqEmpresa().'ClsSucursal.php');

$InsKardex = new ClsKardex();
$InsProducto = new ClsProducto();
$InsSucursal = new ClsSucursal();

$aux = explode("/",$POST_FechaInicio);
$KardexFechaInicio = "01/01/".$aux[2];

$InsSucursal->SucId = $POST_Sucursal;
$InsSucursal->MtdObtenerSucursal();

$InventarioFechaInicio = (empty($InsSucursal->SucInventarioFechaInicio)?$SistemaInventarioFecha:$InsSucursal->SucInventarioFechaInicio);


list($Dia,$Mes,$Ano) = explode("/",$POST_FechaInicio) ;


//MtdObtenerProductos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'ProId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oTipo=NULL,$oValidarStock=1,$oVehiculoMarca=NULL,$oVehiculoModelo=NULL,$oVehiculoVersion=NULL,$oVehiculoAno=NULL,$oTieneIngreso=false,$oReferencia=NULL,$oFecha=NULL,$oTieneSock=0,$oProductoCategoria=NULL,$oUsoEstricto=false,$oVehiculoMarca=NULL,$oCalcularPrecio=NULL,$oTieneCodigoOriginal=false) {
$ResProducto = $InsProducto->MtdObtenerProductos(NULL,NULL,NULL,"ProNombre","ASC",NULL,1,NULL,1,NULL,NULL,NULL,NULL,true,NULL,NULL,0,NULL,false,NULL,NULL,false);
$ArrProductos = $ResProducto['Datos'];


//MtdObtenerVehiculos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'VehId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVehiculoMarca=NULL,$oVehiculoModelo=NULL,$oVehiculoVersion=NULL,$oVehiculoTipo=NULL,$oEstado=NULL)
$ResVehiculo = $InsVehiculo->MtdObtenerVehiculos(NULL,NULL,NULL,"VehCodigoIdentificador","ASC",NULL,NULL,NULL,NULL,NULL,1);
$ArrVehiculos = $ResVehiculo['Datos'];



$libro = "";


$j = 1;

foreach($ArrProductos as $DatProducto){

    //deb($InventarioFechaInicio );
    //MtdObtenerKardexs($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'AmdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oProducto=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oUso=NULL,$oMoneda=NULL,$oFechaTipo="AmoFecha",$oAlmacen=NULL,$oSucursal=NULL) 
    $ResKardex = $InsKardex->MtdObtenerKardexs(NULL,NULL,NULL ,'amd.AmdFecha ASC,(amd.AmdTiempoCreacion) ASC','',NULL,$DatProducto->ProId ,FncCambiaFechaAMysql($InventarioFechaInicio),FncCambiaFechaAMysql($POST_FechaFin),3,$POST_Moneda,"amd.AmdFecha",$POST_Almacen,$POST_Sucursal);
    $ArrKardexs = $ResKardex['Datos'];

	$TotalMovimientoEntradas = 0;
	$TotalMovimientoSalidas = 0;
	
	//$TotalMontoMovimientoEntradas = 0;
	//$TotalMontoMovimientoSalidas = 0;
	
	$TotalEntradaGeneral = 0;
	$TotalSalidaGeneral = 0;
	
	$MostrarSaldoAnterior = true;
	$MostrarSaldoAnterior2 = true;
	
	$Primera = true;
	$MostrarInventario = true;	
	
	foreach($ArrKardexs as $DatKardex){

		$DatKardex->KdxCostoUnitario = (($EmpresaMonedaId==$POST_Moneda or empty($POST_Moneda))?$DatKardex->KdxCostoUnitario:($DatKardex->KdxCostoUnitario/$DatKardex->KdxTipoCambio));  
		$DatKardex->ProCodigoOriginal = str_replace(" ","",$DatKardex->ProCodigoOriginal);
		
		
		$DatKardex->ProCodigoOriginal = str_replace(" ","",$DatKardex->ProCodigoOriginal);
		//$DatKardex->CtiCodigo = $DatKardex->CtiCodigo + 1 -1 ;
		//$DatKardex->TopCodigo = $DatKardex->TopCodigo + 1 -1 ;
		
		if( FncConvetirTimestamp($DatKardex->KdxFecha) < FncConvetirTimestamp($POST_FechaInicio)){	

			if($DatKardex->KdxMovimientoTipo==1  ){
				
				$TotalEntradaGeneral += $DatKardex->KdxCantidad;
	
				$CostoActual = $DatKardex->KdxCostoUnitario;
				$CostoTotalActual = $CostoActual * $DatKardex->KdxCantidad;
				
				$Saldo =  ($TotalEntradaGeneral - $TotalSalidaGeneral);
				
				if($Primera ){
					$CostoUnitarioAnterior = $CostoActual;
					$Primera = false;
				}else{
					//$CostoUnitarioAnterior = round(($CostoUnitarioAnterior + $CostoActual)/2,2);	
					$CostoUnitarioAnterior = (($CostoUnitarioAnterior + $CostoActual)/2);	
				}
		
			}
	
			if($DatKardex->KdxMovimientoTipo==2){
				
				$TotalSalidaGeneral += $DatKardex->KdxCantidad;
	
				$CostoActual = $CostoUnitarioAnterior;
				$CostoTotalActual = $CostoActual * $DatKardex->KdxCantidad;
	
				$Saldo =  ($TotalEntradaGeneral - $TotalSalidaGeneral);			
			}
	
		}else{
		
			$MostrarSaldoAnterior2 = false;
	
			$MostrarSaldoAnterior = false;
			
		
			$Fecha = "01/01/0001";
			
			switch($DatKardex->KdxMovimientoTipo){
				case 1:
					$Fecha = $DatKardex->KdxComprobanteFecha;
				break;
				
				case 2:
					$Fecha = $DatKardex->KdxFecha;
				break;
				
				default:
				break;
				
			}
			
			$Serie = "";
			$Numero = "";
			
			if(empty($DatKardex->KdxComprobanteNumero)){
				list($Serie,$Numero)=explode("-",$DatKardex->KdxComprobanteNumero2);
			}else{
				list($Serie,$Numero)=explode("-",$DatKardex->KdxComprobanteNumero);
			}
			
			$ProductoNombre = $DatKardex->ProNombre;
			$ProductoNombre = trim($ProductoNombre);
			$ProductoNombre = substr($ProductoNombre,0,80);
			
			
			
			if($DatKardex->KdxMovimientoTipo==1  ){
				
				$DatKardex->KdxCantidad = round($DatKardex->KdxCantidad,3);
				$DatKardex->KdxCostoUnitario = round($DatKardex->KdxCostoUnitario,3);
				//echo ($DatKardex->KdxCantidad);
				$TotalEntradaGeneral += $DatKardex->KdxCantidad;

				$CostoActual = $DatKardex->KdxCostoUnitario;
				$CostoTotalActual = $CostoActual * $DatKardex->KdxCantidad;
				
				$Saldo =  ($TotalEntradaGeneral - $TotalSalidaGeneral);		
				
				if($Primera ){
					$CostoUnitarioAnterior = $CostoActual;
					$Primera = false;
				}else{
					$CostoUnitarioAnterior = (($CostoUnitarioAnterior + $CostoActual)/2);	
				}
			
				$CostoTotalSaldo = ($CostoUnitarioAnterior * $Saldo);		
				
				
				$CostoTotalActual = round($CostoTotalActual,3);
				$Saldo = round($Saldo,3);
				$CostoUnitarioAnterior = round($CostoUnitarioAnterior,3);
				$CostoTotalSaldo = round($CostoTotalSaldo,3);
				
				$libro .= $Ano.$Mes."00"."|C1|M".$j."|0003|9|07|".$DatKardex->ProCodigoOriginal."||".$Fecha."|".$DatKardex->CtiCodigo."|".$Serie."|".$Numero."|".$DatKardex->TopCodigo."|".$ProductoNombre."|".$DatKardex->UmeCodigo."|1|".$DatKardex->KdxCantidad."|".$DatKardex->KdxCostoUnitario."|".$CostoTotalActual."|0.00|0.00|0.00|".$Saldo."|".$CostoUnitarioAnterior."|".$CostoTotalSaldo."|1|\n";
				
				$j++;
		
			
			}
				
			if($DatKardex->KdxMovimientoTipo==2){
			  
				$DatKardex->KdxCantidad = round($DatKardex->KdxCantidad,3);
				
				
				$TotalSalidaGeneral += $DatKardex->KdxCantidad;
				
				$CostoActual = $CostoUnitarioAnterior;
				$CostoTotalActual = $CostoActual * $DatKardex->KdxCantidad;
	
				$Saldo =  ($TotalEntradaGeneral - $TotalSalidaGeneral);		
				
				$CostoTotalSaldo = ($Saldo * $CostoUnitarioAnterior);	
				
				
				$CostoActual = round($CostoActual,3);
				$CostoTotalActual = round($CostoTotalActual,3);
				
				
				$Saldo = round($Saldo,3);
				$CostoUnitarioAnterior = round($CostoUnitarioAnterior,3);
				$CostoTotalSaldo = round($CostoTotalSaldo,3);
				
				
				$libro .= $Ano.$Mes."00"."|C1|M".$j."|0003|9|07|".$DatKardex->ProCodigoOriginal."||".$Fecha."|".$DatKardex->CtiCodigo."|".$Serie."|".$Numero."|".$DatKardex->TopCodigo."|".$ProductoNombre."|".$DatKardex->UmeCodigo."|1|0.00|0.00|0.00|".$DatKardex->KdxCantidad."|".$CostoActual."|".$CostoTotalActual."|".$Saldo."|".$CostoUnitarioAnterior."|".$CostoTotalSaldo."|1\n|";
		
				$j++;
				
			}
	
		
	
		}

	}

	if($MostrarSaldoAnterior2){
	
	}

}


/*
* KARDEX VEHICULOS
*/

foreach($ArrVehiculos as $DatVehiculo){

	//deb($POST_UnidadMedidaUso);
	//MtdObtenerKardexVehiculos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'VmdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVehducto=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oUso=NULL,$oMoneda=NULL,$oFechaTipo="VmvFecha",$oSucursal=NULL,$oVehiculoId=NULL,$oVehiculoIngresoId=NULL)
	$ResKardexVehiculo = $InsKardexVehiculo->MtdObtenerKardexVehiculos(NULL,NULL,NULL,'vmd.VmdFecha ASC,(vmd.VmdTiempoCreacion) ASC','',NULL,NULL ,FncCambiaFechaAMysql($KardexFechaInicio),FncCambiaFechaAMysql($POST_FechaFin),$POST_UnidadMedidaUso,$POST_Moneda,"vmd.VmdFecha",$POST_SucursalId,$DatVehiculo->VehId,NULL);
	$ArrKardexVehiculos = $ResKardexVehiculo['Datos'];
	
	$InsVehiculo->VehId = $DatVehiculo->VehId;
	$InsVehiculo->MtdObtenerVehiculo(false);
	

	//$CostoTotalMovimientoEntradas = 0;
	//$CostoTotalMovimientoSalidas = 0;
	
	$TotalMovimientoEntradas = 0;
	$TotalMovimientoSalidas = 0;
	
	//$TotalMontoMovimientoEntradas = 0;
	//$TotalMontoMovimientoSalidas = 0;
	
	$TotalEntradaGeneral = 0;
	$TotalSalidaGeneral = 0;
	
	$MostrarSaldoAnterior = true;
	$MostrarSaldoAnterior2 = true;
	
	$j = 1;
	$Primera = true;
	$MostrarInventario = true;	
	foreach($ArrKardexVehiculos as $DatKardexVehiculo){

		$DatKardexVehiculo->KdvCostoUnitario = (($EmpresaMonedaId==$POST_Moneda or empty($POST_Moneda))?$DatKardexVehiculo->KdvCostoUnitario:($DatKardexVehiculo->KdvCostoUnitario/$DatKardexVehiculo->KdvTipoCambio));  
		$DatKardexVehiculo->KdvCostoIngreso = (($EmpresaMonedaId==$POST_Moneda or empty($POST_Moneda))?$DatKardexVehiculo->KdvCostoIngreso:($DatKardexVehiculo->KdvCostoIngreso/$DatKardexVehiculo->KdvTipoCambio));  
	
		$DatKardexVehiculo->VehCodigoIdentificador = str_replace(" ","",$DatKardexVehiculo->VehCodigoIdentificador);
		//$DatKardexVehiculo->CtiCodigo = $DatKardexVehiculo->CtiCodigo + 1 -1 ;
		//$DatKardexVehiculo->TopCodigo = $DatKardexVehiculo->TopCodigo + 1 -1 ;

		$Fecha = "01/01/0001";
		
		switch($DatKardexVehiculo->KdvMovimientoTipo){
			case 1:
				$Fecha = $DatKardexVehiculo->KdvComprobanteFecha;
			break;
			
			case 2:
				$Fecha = $DatKardexVehiculo->KdvFecha;
			break;
			
			default:
			break;
			
		}
		
	
		$Serie = "";
		$Numero = "";
		  
		 if(empty($DatKardexVehiculo->KdvComprobanteNumero)){
			list($Serie,$Numero)=explode("-",$DatKardexVehiculo->KdvComprobanteNumero2);
		}else{
			list($Serie,$Numero)=explode("-",$DatKardexVehiculo->KdvComprobanteNumero);
		}
	
	
		$ProductoNombre = $DatKardexVehiculo->VmoNombre." ".$DatKardexVehiculo->VveNombre;
		$ProductoNombre = trim($ProductoNombre);
		$ProductoNombre = substr($ProductoNombre,0,80);
			
			
	
	
		if( FncConvetirTimestamp($DatKardexVehiculo->KdvFecha) < FncConvetirTimestamp($POST_FechaInicio)){	
	
			if($DatKardexVehiculo->KdvMovimientoTipo==1  ){
				
				$TotalEntradaGeneral += $DatKardexVehiculo->KdvCantidad;
	
				$CostoActual = $DatKardexVehiculo->KdvCostoUnitario;
				$CostoTotalActual = $CostoActual * $DatKardexVehiculo->KdvCantidad;
				
				$CantidadSaldo =  ($TotalEntradaGeneral - $TotalSalidaGeneral);
				
				if($Primera ){
					$CostoUnitarioAnterior = $CostoActual;
					$Primera = false;
				}else{
					//$CostoUnitarioAnterior = round(($CostoUnitarioAnterior + $CostoActual)/2,2);	
					$CostoUnitarioAnterior = (($CostoUnitarioAnterior + $CostoActual)/2);	
				}
				
			}
	
			if($DatKardexVehiculo->KdvMovimientoTipo==2){
				
				$TotalSalidaGeneral += $DatKardexVehiculo->KdvCantidad;
	
				$CostoActual = $CostoUnitarioAnterior;
				$CostoTotalActual = $CostoActual * $DatKardexVehiculo->KdvCantidad;
	
				$CantidadSaldo =  ($TotalEntradaGeneral - $TotalSalidaGeneral);			
			}
	
		}else{
			
			$MostrarSaldoAnterior2 = false;
			
	 
			$MostrarSaldoAnterior = false;
	 
		   /*     if($DatKardexVehiculo->TopId == "TOP-10015" and $MostrarInventario){
				?>
					<tr>
						<td colspan="25" align="center">
						INVENTARIO
						</td>
					</tr>
				<?php
					$CantidadSaldo = 0;
					$MostrarInventario = false;								
				}*/
				
				
				if($DatKardexVehiculo->KdvMovimientoTipo==1  ){
					
						$TotalEntradaGeneral += $DatKardexVehiculo->KdvCantidad;
						$CantidadSaldo =  ($TotalEntradaGeneral - $TotalSalidaGeneral);		
						
						
						$CantidadEntrada = $DatKardexVehiculo->KdvCantidad;
						$CostoActual = $DatKardexVehiculo->KdvCostoUnitario;
						$CostoTotalActual = $CostoActual * $DatKardexVehiculo->KdvCantidad;
						//$CostoTotalMovimientoEntradas += $CostoTotalActual;
						
						if($Primera ){
							
							$CostoTotalAnterior = $CostoTotalActual;
							$Primera = false;
						
						}else{
							
							$CostoTotalAnterior = (($CostoTotalAnterior + $CostoActual));	
							
						}
					
						$CostoTotalSaldo = ($CostoTotalAnterior);	
						$CostoUnitarioSaldo = $CostoTotalSaldo/(empty($CantidadSaldo)?1:$CantidadSaldo);	
						
						
						
						$DatKardexVehiculo->KdxCostoUnitario = round($DatKardexVehiculo->KdxCostoUnitario,3);
						$CantidadEntrada = round($CantidadEntrada,3);
						$CostoTotalActual = round($CostoTotalActual,3);
						
						$Saldo = round($Saldo,3);
						$CostoUnitarioAnterior = round($CostoUnitarioAnterior,3);
						$CostoTotalSaldo = round($CostoTotalSaldo,3);
						
						
						$libro .= $Ano.$Mes."00"."|C1|M".$j."|0003|9|01|".$DatKardexVehiculo->VehCodigoIdentificador."||".$Fecha."|".$DatKardexVehiculo->CtiCodigo."|".$Serie."|".$Numero."|".$DatKardexVehiculo->TopCodigo."|".$ProductoNombre."|".$DatKardexVehiculo->UmeCodigo."|1|".$CantidadEntrada."|".$DatKardexVehiculo->KdxCostoUnitario."|".$CostoTotalActual."|0.00|0.00|0.00|".$Saldo."|".$CostoUnitarioAnterior."|".$CostoTotalSaldo."|1|\n";
						
						$j++;
				
					}
					
					if($DatKardexVehiculo->KdvMovimientoTipo==2){
			
					//	if($DatKardexVehiculo->KdvSubTipo == 3){
//							
//						
//						}else{
//							
//							
//						}
						
						$TotalSalidaGeneral += $DatKardexVehiculo->KdvCantidad;
						$CantidadSaldo =  ($TotalEntradaGeneral - $TotalSalidaGeneral);		
						
						$CantidadSalida = $DatKardexVehiculo->KdvCantidad;
						$CostoActual = $DatKardexVehiculo->KdvCostoIngreso;
						$CostoTotalActual = $CostoActual * $DatKardexVehiculo->KdvCantidad;
						
						//$CostoTotalMovimientoSalidas += $CostoTotalActual;
						
						$CostoTotalAnterior = (($CostoTotalAnterior - $CostoActual));	
						
						$CostoTotalSaldo = ($CostoTotalAnterior - $CostoTotalActual);	
						$CostoUnitarioSaldo = $CostoTotalSaldo/(empty($CantidadSaldo)?1:$CantidadSaldo);
						
						
						
						
						//$DatKardexVehiculo->KdvCantidad = round($DatKardexVehiculo->KdvCantidad,3);
						$CantidadSalida = round($CantidadSalida,3);
						$CostoActual = round($CostoActual,3);
						$CostoTotalActual = round($CostoTotalActual,3);
						
						$CantidadSaldo = round($CantidadSaldo,3);
						$CostoUnitarioSaldo = round($CostoUnitarioSaldo,3);
						$CostoTotalSaldo = round($CostoTotalSaldo,3);
					
						$libro .= $Ano.$Mes."00"."|C1|M".$j."|0003|9|01|".$DatKardexVehiculo->VehCodigoIdentificador."||".$Fecha."|".$DatKardexVehiculo->CtiCodigo."|".$Serie."|".$Numero."|".$DatKardexVehiculo->TopCodigo."|".$ProductoNombre."|".$DatKardexVehiculo->UmeCodigo."|1|0.00|0.00|0.00|".$CantidadSalida."|".$CostoActual."|".$CostoTotalActual."|".$CantidadSaldo."|".$CostoUnitarioSaldo."|".$CostoTotalSaldo."|1|\n";
				
						$j++;
						
					}
		   
		}
 
	
				$j++;
			}
	

}
	


$NombreArchivo = "LE".$EmpresaCodigo.$Ano.$Mes."00"."130100"."00"."1"."1"."1"."1".".txt";
$Ruta = '../../../generados/libros_electronicos/';

if(file_exists($Ruta.''.$NombreArchivo)){
	unlink($Ruta.''.$NombreArchivo);
}

$ddf = fopen($Ruta.''.$NombreArchivo,'a');
fwrite($ddf,$libro);
fclose($ddf);
//	
$nombre_archivo = basename($Ruta.''.$NombreArchivo);
header("Content-disposition: attachment; filename=".$NombreArchivo);
header("Content-type: application/octet-stream");
readfile($Ruta.''.$NombreArchivo);	

?>