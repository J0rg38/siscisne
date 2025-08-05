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


require_once($InsPoo->MtdPaqLogistica().'ClsPedidoCompra.php');
require_once($InsPoo->MtdPaqLogistica().'ClsPedidoCompraDetalle.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompra.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompraPedido.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompraDetalle.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCliente.php');
require_once($InsPoo->MtdPaqLogistica().'ClsProveedor.php');



$Enviar = false;

$Destinatarios = "iquezada@cyc.com.pe,scanepam@cyc.com.pe,aliendo@cyc.com.pe,jblanco@cyc.com.pe,pcondori@cyc.com.pe,dvercelone@cyc.com.pe,mzamora@cyc.com.pe";
//$Destinatarios = "jblanco@cyc.com.pe";
$FechaInicio = date("d/m/Y");
$FechaFin = date("d/m/Y");

$ProveedorNombre = "";
$ProveedorNumeroDocumento = "";
$ProveedorTipoDocumento = "";
$ProveedorId = "PRV-10548";

$InsProveedor = new ClsProveedor();
$InsProveedor->PrvId = $ProveedorId;
$InsProveedor->MtdObtenerProveedor();


$ProveedorNombre = $InsProveedor->PrvNombre." ".$InsProveedor->PrvApellidoPaterno." ".$InsProveedor->PrvApellidoMaterno;
$ProveedorNumeroDocumento = $InsProveedor->PrvNumeroDocumento;
$ProveedorTipoDocumento = $InsProveedor->TdoNombre;


//$InsOrdenCompra = new ClsOrdenCompra();
//$ResOrdenCompra = $InsOrdenCompra->MtdObtenerOrdenCompras(NULL,NULL,NULL,"OcoTiempoCreacion","ASC",NULL,(date("Y")."-".date("m")."-01"),(date("Y-m-d")),NULL,NULL,0,NULL,$POST_Moneda,2);
//$ArrOrdenCompras = $ResOrdenCompra['Datos'];

$InsPedidoCompraDetalle = new ClsPedidoCompraDetalle();
$ResPedidoCompraDetalle = $InsPedidoCompraDetalle->MtdObtenerPedidoCompraDetalles(NULL,NULL,"PcdBOFecha","DESC",NULL,NULL,3,NULL,FncCambiaFechaAMysql($FechaInicio),NULL,NULL,NULL,NULL,NULL,NULL,"PcdBOFecha");
$ArrPedidoCompraDetalles = $ResPedidoCompraDetalle['Datos'];

$mensaje .= "<b>NOTIFICACION DE BACK ORDER DE ORDENES DE COMPRA</b>";
$mensaje .= "<br>";	
$mensaje .= "<br>";	

$mensaje .= "<b>Proveedor:</b> ".$ProveedorNombre."";	
$mensaje .= "<br>";
$mensaje .= "<b>Fecha de notificacion:</b> ".date("d/m/Y")."";	
$mensaje .= "<br>";
$mensaje .= "<b>Descripcion:</b> Fechas de llegada de repuestos que se encuentran en back order.";	
$mensaje .= "<br>";	

  
  $mensaje .= "<hr>";
  $mensaje .= "<br>";
  
  
	  $mensaje .= "<br>";


	  if(!empty($ArrPedidoCompraDetalles)){
	  
		  
		  $mensaje .= "<table cellpadding='4' cellspacing='0' width='100%' border='1'>";
		  
		  $mensaje .= "<tr>";
		  
			  $mensaje .= "<td width='2%'>";
			  $mensaje .= "<b>#</b>";
			  $mensaje .= "</td>";

			  $mensaje .= "<td width='5%'>";
			  $mensaje .= "<b>ORD. COMPRA</b>";
			  $mensaje .= "</td>";
			  
			  
			   $mensaje .= "<td width='5%'>";
			  $mensaje .= "<b>FEC. PEDIDO</b>";
			  $mensaje .= "</td>";
			  
			    $mensaje .= "<td  width='5%'>";
			  $mensaje .= "<b>COD. ORIG.</b>";
			  $mensaje .= "</td >";
			  
			  
			  $mensaje .= "<td >";
			  $mensaje .= "<b>NOMBRE</b>";
			  $mensaje .= "</td >";

			  $mensaje .= "<td  width='5%'>";
			  $mensaje .= "<b>CANT.</b>";
			  $mensaje .= "</td>";
			  
			  $mensaje .= "<td  width='5%'>";
			  $mensaje .= "<b>AÑO</b>";
			  $mensaje .= "</td>";

			 
			  $mensaje .= "<td  width='5%' >";
			  $mensaje .= "<b>MODELO</b>";
			  $mensaje .= "</td>";
			  
			    $mensaje .= "<td  >";
			  $mensaje .= "<b>CLIENTE</b>";
			  $mensaje .= "</td>";
			  
			   $mensaje .= "<td  width='10%' >";
			  $mensaje .= "<b>ORD. VEN.</b>";
			  $mensaje .= "</td>";
			  
			   $mensaje .= "<td  width='10%' >";
			  $mensaje .= "<b>REF.</b>";
			  $mensaje .= "</td>";
			  
			   $mensaje .= "<td  width='5%' >";
			  $mensaje .= "<b>STATUS BO</b>";
			  $mensaje .= "</td>";
			  
			   $mensaje .= "<td  width='5%' >";
			  $mensaje .= "<b>FECHA LLEGADA</b>";
			  $mensaje .= "</td>";
			  
		  $mensaje .= "</tr>";
		  
		  
				  
			$c = 1;	
			
			foreach($ArrPedidoCompraDetalles as $DatPedidoCompraDetalle){
			
					$mensaje .= "<tr>";
								
						$mensaje .= "<td>";
						$mensaje .= $c;
						$mensaje .= "</td>";
			
						$mensaje .= "<td>";
						$mensaje .= $DatPedidoCompraDetalle->OcoId;
						$mensaje .= "</td>";
						
						$mensaje .= "<td>";
						$mensaje .= $DatPedidoCompraDetalle->OcoFecha;
						$mensaje .= "</td>";
						
						$mensaje .= "<td>";
						$mensaje .= $DatPedidoCompraDetalle->ProCodigoOriginal;
						$mensaje .= "</td>";
						
						$mensaje .= "<td>";
						$mensaje .= $DatPedidoCompraDetalle->ProNombre;
						$mensaje .= "</td>";
						
						$mensaje .= "<td>";
						$mensaje .= $DatPedidoCompraDetalle->PcdCantidad;
						$mensaje .= "</td>";
						
						$mensaje .= "<td>";
						$mensaje .= $DatPedidoCompraDetalle->PcdAno;
						$mensaje .= "</td>";
						
						$mensaje .= "<td>";
						$mensaje .= $DatPedidoCompraDetalle->PcdModelo;
						$mensaje .= "</td>";
						
						$mensaje .= "<td>";
						$mensaje .= $DatPedidoCompraDetalle->CliNombre." ".$DatPedidoCompraDetalle->CliApellidoPaterno." ".$DatPedidoCompraDetalle->CliApellidoMaterno;
						$mensaje .= "</td>";
						
						$mensaje .= "<td>";
						$mensaje .= $DatPedidoCompraDetalle->VdiId;
						$mensaje .= "</td>";
						
						$mensaje .= "<td>";
						$mensaje .= $DatPedidoCompraDetalle->VdiOrdenCompraNumero;
						$mensaje .= "</td>";
						
						$mensaje .= "<td>";
						$mensaje .= $DatPedidoCompraDetalle->PcdBOEstado;
						$mensaje .= "</td>";
						
						$mensaje .= "<td>";
						$mensaje .= $DatPedidoCompraDetalle->PcdBOFecha;
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
	  $InsCorreo->MtdEnviarCorreo($Destinatarios,"sistema@cyc.com.pe","C&C S.A.C.","NOTIFICACION: BACK ORDER DE ORDENES DE COMPRA - ".$ProveedorNombre,$mensaje);
	  
  }
				
				
				
//		}


?>