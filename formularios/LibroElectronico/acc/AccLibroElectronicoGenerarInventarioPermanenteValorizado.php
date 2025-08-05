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

$POST_Ano = ($_GET['Ano']);
$POST_Mes = ($_GET['Mes']);


$POST_ord = isset($_GET['Orden'])?$_GET['Orden']:"FechaEmision";
$POST_sen = isset($_GET['Sentido'])?$_GET['Sentido']:"DESC";

$POST_Moneda = ($_GET['Moneda']);


require_once($InsPoo->MtdPaqContabilidad().'ClsFactura.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCliente.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsPago.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsNotaCredito.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsBoleta.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsNotaCredito.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsNotaDebito.php');

$InsPago = new ClsPago();
$InsFactura = new ClsFactura();
$InsMoneda = new ClsMoneda();
$InsCliente = new ClsCliente();
$InsNotaCredito = new ClsNotaCredito();
$InsBoleta = new ClsBoleta();
$InsNotaDebito = new ClsNotaDebito();

$FechaInicio = "01/".$POST_Mes."/".$POST_Ano;
$FechaFin = FncCantidadDiaMes($POST_Ano,$POST_Mes)."/".$POST_Mes."/".$POST_Ano;



$POST_FechaInicio = $_GET['FechaInicio'];
$POST_FechaFin = $_GET['FechaFin'];
//$POST_Sucursal = (empty($_GET['CmpSucursal'])?$_SESSION['SesionSucursal']:$_GET['CmpSucursal']);
$POST_Sucursal = $_GET['Sucursal'];

$POST_Almacen = $_GET['Almacen'];

$POST_ProductoCodigoOriginal = $_GET['ProductoCodigoOriginal'];
$POST_ProductoNombre = $_GET['ProductoNombre'];
$POST_ProductoUnidadMedidaKardex = $_GET['ProductoUnidadMedidaKardex'];
$POST_ProductoId = $_GET['ProductoId'];



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


//MtdObtenerProductos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'ProId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oTipo=NULL,$oValidarStock=1,$oVehiculoMarca=NULL,$oVehiculoModelo=NULL,$oVehiculoVersion=NULL,$oVehiculoAno=NULL,$oTieneIngreso=false,$oReferencia=NULL,$oFecha=NULL,$oTieneSock=0,$oProductoCategoria=NULL,$oUsoEstricto=false,$oVehiculoMarca=NULL,$oCalcularPrecio=NULL,$oTieneCodigoOriginal=false) {
$ResProducto = $InsProducto->MtdObtenerProductos("ProId","esigual",$POST_ProductoId,"ProNombre","ASC",NULL,1,$POST_ProductoTipo,1,NULL,NULL,NULL,NULL,true,NULL,NULL,0,NULL,false,NULL,NULL,false);
$ArrProductos = $ResProducto['Datos'];






		$libro = "";




$i = 1;
foreach($ArrProductos as $DatProducto){

    //deb($InventarioFechaInicio );
    //MtdObtenerKardexs($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'AmdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oProducto=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oUso=NULL,$oMoneda=NULL,$oFechaTipo="AmoFecha",$oAlmacen=NULL,$oSucursal=NULL) 
    $ResKardex = $InsKardex->MtdObtenerKardexs(NULL,NULL,NULL ,'amd.AmdFecha ASC,(amd.AmdTiempoCreacion) ASC','',NULL,$DatProducto->ProId ,FncCambiaFechaAMysql($InventarioFechaInicio),FncCambiaFechaAMysql($POST_FechaFin),3,$POST_Moneda,"amd.AmdFecha",$POST_Almacen,$POST_Sucursal);
    $ArrKardexs = $ResKardex['Datos'];


	$TotalMovimientoEntradas = 0;
	$TotalMovimientoSalidas = 0;
	
	$TotalMontoMovimientoEntradas = 0;
	$TotalMontoMovimientoSalidas = 0;
	
	$TotalEntradaGeneral = 0;
	$TotalSalidaGeneral = 0;
	
	$MostrarSaldoAnterior = true;
	$MostrarSaldoAnterior2 = true;
	
	$j = 1;
	$Primera = true;
	$MostrarInventario = true;	
	foreach($ArrKardexs as $DatKardex){

		$DatKardex->KdxCostoUnitario = (($EmpresaMonedaId==$POST_Moneda or empty($POST_Moneda))?$DatKardex->KdxCostoUnitario:($DatKardex->KdxCostoUnitario/$DatKardex->KdxTipoCambio));  

	
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
			
				
				if(empty($DatKardex->KdxComprobanteNumero)){
				list($Serie,$Numero)=explode("-",$DatKardex->KdxComprobanteNumero2);
				
				}else{
				list($Serie,$Numero)=explode("-",$DatKardex->KdxComprobanteNumero);
				
				}
	   			
				if($DatKardex->KdxMovimientoTipo==1  ){
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
					
					$libro .= $POST_Ano.$POST_Mes."00"."|C1|M".$c."|0003|9|07|".$DatKardex->ProCodigoOriginal."||".$Fecha."|".$DatKardex->CtiCodigo."|".$Serie."|".$Numero."|".$DatKardex->TopCodigo."|".$DatKardex->Nombre."|".$DatKardex->UmeCodigo."|1|".$DatKardex->KdxCantidad."|".$DatKardex->KdxCostoUnitario."|".$CostoTotalActual."|0.00|0.00|0.00|".$Saldo."|".$CostoUnitarioAnterior."|".$CostoTotalSaldo."|1|".chr(13);
			
			
				
				}
				
				if($DatKardex->KdxMovimientoTipo==2){
				  ($DatKardex->KdxCantidad);
                    $TotalSalidaGeneral += $DatKardex->KdxCantidad;
					
					$CostoActual = $CostoUnitarioAnterior;
					$CostoTotalActual = $CostoActual * $DatKardex->KdxCantidad;
		
					$Saldo =  ($TotalEntradaGeneral - $TotalSalidaGeneral);		
					
					$CostoTotalSaldo = ($Saldo * $CostoUnitarioAnterior);	
					
					$libro .= $POST_Ano.$POST_Mes."00"."|C1|M".$c."|0003|9|07|".$DatKardex->ProCodigoOriginal."||".$Fecha."|".$DatKardex->CtiCodigo."|".$Serie."|".$Numero."|".$DatKardex->TopCodigo."|".$DatKardex->Nombre."|".$DatKardex->UmeCodigo."|1|0.00|0.00|0.00|".$DatKardex->KdxCantidad."|".$CostoActual."|".$CostoTotalActual."|".$Saldo."|".$CostoUnitarioAnterior."|".$CostoTotalSaldo."|1|".chr(13);
			
			
				}
		
			
		
		}



				$j++;
			}

	if($MostrarSaldoAnterior2){
	
	}

}






		


$NombreArchivo = "LE".$EmpresaCodigo.$POST_Ano.$POST_Mes."00"."130100"."00"."1"."1"."1"."1".".txt";
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