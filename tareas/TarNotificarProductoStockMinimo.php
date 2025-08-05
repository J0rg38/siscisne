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


require_once($InsPoo->MtdPaqReporte().'ClsReporteProducto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenStock.php');


$InsReporteProducto = new ClsReporteProducto();
$InsAlmacenStock  = new ClsAlmacenStock();


$FechaInicio = "01/01/".date("Y");
$FechaFin = date("d/m/Y");
$Destinatarios = "j.blanco@cisne.com.pe,l.quispe@cisne.com.pe,p.regente@cisne.com.pe";//
//$Destinatarios = "jblanco@cyc.com.pe";

$mensaje .= "<b>NOTIFICACION DE PRODUCTOS X AGOTAR</b>";	
$mensaje .= "<br>";	
$mensaje .= "<br>";	

$mensaje .= "<b>Fecha de notificacion:</b> ".date("d/m/Y")."";	
$mensaje .= "<br>";	
$mensaje .= "<b>Descripcion:</b> Repuestos que se encuentran agotados o por agotarse segun stock minimo asignado.";	
$mensaje .= "<br>";	

$mensaje .= "<hr>";
$mensaje .= "<br>";


//	public function MtdObtenerReporteProductoStockMinimos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'ProId',$oSentido = 'Desc',$oPaginacion = '0,10',$oProductoTipo=NULL,$oProductoCategoria=NULL,$oProductoCritico=NULL) {
$ResReporteProducto = $InsReporteProducto->MtdObtenerReporteProductoStockMinimos(NULL,NULL,NULL,$POST_ord,$POST_sen,NULL,$POST_ProductoTipo,$POST_ProductoCategoria,1,false);
$ArrReporteProductos = $ResReporteProducto['Datos'];

		$mensaje .= "<table cellpadding='4' cellspacing='0' width='100%' border='1'>";
		
		$mensaje .= "<tr>";
		
			$mensaje .= "<td width='2%'>";
			$mensaje .= "<b>#</b>";
			$mensaje .= "</td>";

			$mensaje .= "<td width='10%' align='center'>";
			$mensaje .= "<b>Cod. Original</b>";
			$mensaje .= "</td>";

			$mensaje .= "<td  align='center'>";
			$mensaje .= "<b>Nombre</b>";
			$mensaje .= "</td>";
			
			$mensaje .= "<td  align='center'>";
			$mensaje .= "<b>Ref.</b>";
			$mensaje .= "</td>";
			
			$mensaje .= "<td width='10%'  align='center'>";
			$mensaje .= "<b>Uni. Med.</b>";
			$mensaje .= "</td>";

		
			
			$mensaje .= "<td width='10%'  align='center'>";
			$mensaje .= "<b>Ventas Ult. (3m)</b>";
			$mensaje .= "</td>";
			
			$mensaje .= "<td width='10%'  align='center'>";
			$mensaje .= "<b>Ventas Ult. (6m).</b>";
			$mensaje .= "</td>";
			
			$mensaje .= "<td width='5%'  align='center'>";
			$mensaje .= "<b>Stock</b>";
			$mensaje .= "</td>";

			$mensaje .= "<td width='5%'  align='center'>";
			$mensaje .= "<b>Stock Min.</b>";
			$mensaje .= "</td>";

			$mensaje .= "<td width='5%'  align='center'>";
			$mensaje .= "<b>Estado</b>";
			$mensaje .= "</td>";


		$mensaje .= "</tr>";

	$i = 1;	
	foreach($ArrReporteProductos as $DatReporteProducto){

		if($DatReporteProducto->RprStockMinimoEstado!="Normal"){
			
			
			$StockReal = $InsAlmacenStock->MtdObtenerAlmacenStockProductoStockReal(NULL,NULL,date("Y"),$DatReporteProducto->ProId);




			$mensaje .= "<tr>";
							
					$mensaje .= "<td>";
					$mensaje .= $i;
					$mensaje .= "</td>";
	
					$mensaje .= "<td>";
					$mensaje .= $DatReporteProducto->ProCodigoOriginal;
					$mensaje .= "</td>";
	
					$mensaje .= "<td>";
					$mensaje .= $DatReporteProducto->ProNombre;
					$mensaje .= "</td>";
					
					$mensaje .= "<td>";
					$mensaje .= $DatReporteProducto->ProReferencia;
					$mensaje .= "</td>";
					
					$mensaje .= "<td>";
					$mensaje .= $DatReporteProducto->UmeNombre;
					$mensaje .= "</td>";
	
					$mensaje .= "<td>";
					$mensaje .= number_format($DatReporteProducto->ProSalidaTotalTrimestral,2);
					$mensaje .= "</td>";
					
					$mensaje .= "<td>";
					$mensaje .= number_format($DatReporteProducto->ProSalidaTotalSemestral,2);
					$mensaje .= "</td>";					
					
					$mensaje .= "<td>";
					$mensaje .= number_format($StockReal ,2);
					$mensaje .= "</td>";
					
					$mensaje .= "<td>";
						$mensaje .= number_format($DatReporteProducto->ProStockMinimo,2);
					$mensaje .= "</td>";
	
					$mensaje .= "<td>";
					$mensaje .= $DatReporteProducto->RprStockMinimoEstado;
					$mensaje .= "</td>";
					
				$mensaje .= "</tr>";
			
			$i++;				
			
			$Enviar = true;
			
		}
				
		
							
	}
	

		
			
		$mensaje .= "</table>";
		
		



$mensaje .= "<br>";
$mensaje .= "<br>";
$mensaje .= "Mensaje autogenerado por ".$SistemaNombreAbreviado." a las ".date('d/m/Y H:i:s');


echo $mensaje;

if($Enviar){
	
	$InsCorreo = new ClsCorreo();	
	$InsCorreo->MtdEnviarCorreo($Destinatarios,$SistemaCorreoUsuario,$SistemaCorreoRemitente,"NOTIFICACION: PRODUCTOS X AGOTAR (ALERTA STOCK MINIMO)".$Titulo,$mensaje);
		
		
}
				
				
				
?>