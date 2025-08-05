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


require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompra.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompraPedido.php');
require_once($InsPoo->MtdPaqLogistica().'ClsProveedor.php');





$Enviar = false;

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


$InsOrdenCompra = new ClsOrdenCompra();
$ResOrdenCompra = $InsOrdenCompra->MtdObtenerOrdenCompras(NULL,NULL,NULL,"OcoTiempoCreacion","ASC",NULL,(date("Y")."-".date("m")."-01"),(date("Y-m-d")),NULL,NULL,0,NULL,$POST_Moneda,2);
$ArrOrdenCompras = $ResOrdenCompra['Datos'];

$mensaje .= " AVISO DE ORDENES NO PROCESADOS POR PROVEEDOR";
$mensaje .= "<br>";	
$mensaje .= "<br>";	

$mensaje .= "Proveedor: <b>".$ProveedorNombre."</b>";	
$mensaje .= "<br>";
$mensaje .= "Fecha de aviso: <b>".date("d/m/Y")."</b>";	
$mensaje .= "<br>";
$mensaje .= "Descripcion: <b>Ordenes que no han sido procesados por el proveedor</b>";	
$mensaje .= "<br>";	

  
  $mensaje .= "<hr>";
  $mensaje .= "<br>";
  
  
	  $mensaje .= "<br>";


	  if(!empty($ArrOrdenCompras)){
	  
		  
		  $mensaje .= "<table cellpadding='0' cellspacing='0' width='100%' border='1'>";
		  
		  $mensaje .= "<tr>";
		  
			  $mensaje .= "<td width='2%'>";
			  $mensaje .= "<b>#</b>";
			  $mensaje .= "</td>";

			  $mensaje .= "<td width='15%'>";
			  $mensaje .= "<b>ORD. COMPRA</b>";
			  $mensaje .= "</td>";
			  
			  $mensaje .= "<td  width='10%'>";
			  $mensaje .= "<b>FECHA</b>";
			  $mensaje .= "</td >";

			  $mensaje .= "<td  width='15%'>";
			  $mensaje .= "<b>FECHA LLEGADA APROX.</b>";
			  $mensaje .= "</td>";
			  
			  $mensaje .= "<td  width='10%'>";
			  $mensaje .= "<b>DIAS TRANSCURRIDOS</b>";
			  $mensaje .= "</td>";

			 
			  $mensaje .= "<td  width='31%' >";
			  $mensaje .= "<b>CLIENTE</b>";
			  $mensaje .= "</td>";
			  
			    $mensaje .= "<td  width='17%' >";
			  $mensaje .= "<b>COTIZADOR</b>";
			  $mensaje .= "</td>";
			  
		  $mensaje .= "</tr>";
		  
		  
				  
	  $c = 1;	
	  
  foreach($ArrOrdenCompras as $DatOrdenCompra){

	  
			  
			  $mensaje .= "<tr>";
						  
				  $mensaje .= "<td>";
				  $mensaje .= $c;
				  $mensaje .= "</td>";
  
				  $mensaje .= "<td>";
				  $mensaje .= $DatOrdenCompra->OcoId;
				  $mensaje .= "</td>";
				  
				  $mensaje .= "<td>";
				  $mensaje .= $DatOrdenCompra->OcoFecha;
				  $mensaje .= "</td>";

				  $mensaje .= "<td>";
				  $mensaje .= $DatOrdenCompra->OcoFechaLlegadaEstimada;
				  $mensaje .= "</td>";
				  
				  $mensaje .= "<td>";
				  $mensaje .= $DatOrdenCompra->OcoDiaTranscurrido." dias";
				  $mensaje .= "</td>";


				$mensaje .= "<td>";
 
				$InsOrdenCompraPedido = new ClsOrdenCompraPedido();
				
				$ResOrdenCompraPedido =  $InsOrdenCompraPedido->MtdObtenerOrdenCompraPedidos(NULL,NULL,NULL,NULL,NULL,$DatOrdenCompra->OcoId);
				$ArrOrdenCompraPedidos = $ResOrdenCompraPedido['Datos'];	
				
											  
				 foreach($ArrOrdenCompraPedidos as $DatOrdenCompraPedido){
					 
					$mensaje .= $DatOrdenCompraPedido->CliNombre." ".$DatOrdenCompraPedido->CliApellidoPaterno." ".$DatOrdenCompraPedido->CliApellidoMaterno; 
				 
				 }
				  
				$mensaje .= "</td>";
				
				  $mensaje .= "<td>";
				  $mensaje .= $DatOrdenCompra->OcoCotizadorNombre;
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
	  $InsCorreo->MtdEnviarCorreo("iquezada@cyc.com.pe,scanepam@cyc.com.pe,aliendo@cyc.com.pe,jblanco@cyc.com.pe","sistema@cyc.com.pe","C&C S.A.C.","AVISO: ORDENES DE COMPRA NO PROCESADAS - ".$ProveedorNombre,$mensaje);
	  
  }
				
				
				
//		}


?>