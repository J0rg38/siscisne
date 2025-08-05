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
require_once($InsProyecto->MtdRutConfiguraciones().'CnfNotificacion.php');
////MENSAJES GENERALES
require_once($InsProyecto->MtdRutMensajes().'MsjGeneral.php');
////CLASES GENERALES
require_once($InsProyecto->MtdRutClases().'ClsSesion.php');
require_once($InsProyecto->MtdRutClases().'ClsSesionObjeto.php');
require_once($InsProyecto->MtdRutClases().'ClsMensaje.php');
require_once($InsProyecto->MtdRutLibrerias().'PHPMailer_5.2.4/class.phpmailer.php');
require_once($InsProyecto->MtdRutClases().'ClsCorreo.php');

///CLASES GENERALES
require_once($InsProyecto->MtdRutConexiones().'ClsConexion.php');
require_once($InsProyecto->MtdRutClases().'ClsMysql.php');
////FUNCIONES GENERALES
require_once($InsProyecto->MtdRutFunciones().'FncGeneral.php');




//if(!empty($POST_Sucursal)){

//	$Destinatarios = $CorreosNotificacionFichaIngresoSinFacturarSucursal;

//}else{

	$Destinatarios = $CorreosNotificacionTrasladosProductoGeneral;

//}


$Destinatarios  = "j.blanco@cisne.com.pe";

echo "Destinatarios: ";
echo $Destinatarios;
echo "<br>";



$POST_FechaInicio = isset($_GET['FechaInicio'])?$_GET['FechaInicio']:"01/".date("m")."/".date("Y");
$POST_FechaFin = isset($_GET['FechaFin'])?$_GET['FechaFin']:date("d/m/Y");

$POST_ord = isset($_GET['Orden'])?$_GET['Orden']:"TptFecha";
$POST_sen = isset($_GET['Sentido'])?$_GET['Sentido']:"DESC";

$POST_Sucursal = ($_GET['Sucursal']);


require_once($InsPoo->MtdPaqAlmacen().'ClsTrasladoProducto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsTrasladoProductoDetalle.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngreso.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');


require_once($InsPoo->MtdPaqActividad().'ClsFichaIngreso.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoLlamada.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoGasto.php');
require_once($InsPoo->MtdPaqActividad().'ClsPreEntregaDetalle.php');
require_once($InsPoo->MtdPaqActividad().'ClsPreEntregaTarea.php');
require_once($InsPoo->MtdPaqActividad().'ClsPreEntregaSeccion.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoProducto.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoTarea.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoModalidad.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoHerramienta.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoSuministro.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoMantenimiento.php');

require_once($InsPoo->MtdPaqActividad().'ClsFichaAccion.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionSalidaExterna.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionFoto.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionTarea.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionTempario.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionProducto.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionMantenimiento.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionSuministro.php');

//require_once($InsPoo->MtdPaqAlmacen().'ClsTrasladoProducto.php');
//require_once($InsPoo->MtdPaqAlmacen().'ClsTrasladoProductoDetalle.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsTallerPedido.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsTallerPedidoDetalle.php');
require_once($InsPoo->MtdPaqEmpresa().'ClsSucursal.php');

$InsTrasladoProducto = new ClsTrasladoProducto();
$InsMoneda = new ClsMoneda();
$InsSucursal = new ClsSucursal();
	  
//MtdObtenerTrasladoProductos($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'TptId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oSucursal=NULL,$oSucursalDestino=NULL,$oFecha="TptFecha")
$ResTrasladoProducto = $InsTrasladoProducto->MtdObtenerTrasladoProductos(NULL,NULL,NULL,"",$POST_sen,$POST_pag,FncCambiaFechaAMysql($POST_FechaInicio),FncCambiaFechaAMysql($POST_FechaFin),3,$POST_Sucursal,NULL,"TptTiempoCreacion");
$ArrTrasladoProductos = $ResTrasladoProducto['Datos'];

$Titulo  = "";

if($POST_FechaFin == $POST_FechaInicio){
	$Titulo = " ".$POST_FechaInicio;
}else{
	$Titulo = " ".$POST_FechaInicio." al ".$POST_FechaFin;	
}


$mensaje .= "<b><u>TRASLADOS DE PRODUCTOS REGISTRADOS</u></b>";
$mensaje .= "<br>";	
$mensaje .= "<br>";	

$mensaje .= "<b>Fecha de aviso:</b> ".date("d/m/Y")."";	
$mensaje .= "<br>";

$mensaje .= "<b>Rango de Fechas:</b> ".$POST_FechaInicio." al ".$POST_FechaFin;	
//$mensaje .= "<b>Rango de Fechas:</b> ".$POST_Fecha;	
$mensaje .= "<br>";

$mensaje .= "<b>Descripcion:</b> Traslados de productos entre sedes registrados";
$mensaje .= "<br>";	

  
$mensaje .= "<hr>";
$mensaje .= "<br>";
  
	  $mensaje .= "<br>";

	  if(!empty($ArrTrasladoProductos)){	  
		  
		  $mensaje .= "<table cellpadding='2' cellspacing='0' width='100%' border='1'>";
		  
		  $mensaje .= "<tr>";
		  
			  $mensaje .= "<td width='2%'  align='center'>";
			  $mensaje .= "<b>#</b>";
			  $mensaje .= "</td>";
			  
				$mensaje .= "<td width='5%'  align='center'>";
			  $mensaje .= "<b>ID</b>";
			  $mensaje .= "</td>";
			  
			  $mensaje .= "<td width='5%'  align='center'>";
			  $mensaje .= "<b>FECHA</b>";
			  $mensaje .= "</td>";

			  $mensaje .= "<td width='5%'  align='center'>";
			  $mensaje .= "<b>SUCURSAL ORIGEN</b>";
			  $mensaje .= "</td>";
			  
			  $mensaje .= "<td width='5%'  align='center'>";
			  $mensaje .= "<b>SUCURSAL DESTINO</b>";
			  $mensaje .= "</td>";
			  
			   $mensaje .= "<td   align='center' >";
			  $mensaje .= "<b>REFERENCIA</b>";
			  $mensaje .= "</td>";
			  
			  $mensaje .= "<td   align='center' >";
			  $mensaje .= "<b>GUIA</b>";
			  $mensaje .= "</td>";
			  
			  $mensaje .= "<td   align='center' >";
			  $mensaje .= "<b>RESPONSABLE</b>";
			  $mensaje .= "</td >";

			  $mensaje .= "<td  width='5%'  align='center' >";
			  $mensaje .= "<b>FECHA DE REGISTRO</b>";
			  $mensaje .= "</td>";
			  
			   $mensaje .= "<td  width='15%'  align='center' >";
			  $mensaje .= "<b>OBSERVACION</b>";
			  $mensaje .= "</td>";
			  
		  $mensaje .= "</tr>";
		  
		  
				  
	  $c = 1;	
	  
  foreach($ArrTrasladoProductos as $DatTrasladoProducto){

		$InsTrasladoProductoDetalle = new ClsTrasladoProductoDetalle();
		//MtdObtenerTrasladoProductoDetalles($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'TpdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oTrasladoProducto=NULL,$oEstado=NULL,$oProducto=NULL,$oTrasladoProductoEstado=NULL,$oVehiculoMarca=NULL,$oProductoTipo=NULL,$oFechaInicio=NULL,$oFechaFin=NULL)
		$ResTrasladoProductoDetalle =  $InsTrasladoProductoDetalle->MtdObtenerTrasladoProductoDetalles(NULL,NULL,NULL,"TpdId","ASC",NULL,$DatTrasladoProducto->TptId);
		$ArrTrasladoProductoDetalles = 	$ResTrasladoProductoDetalle['Datos'];	
		
		$Codigos = "";
		
		if(!empty($ArrTrasladoProductoDetalles)){
			foreach($ArrTrasladoProductoDetalles as $DatTrasladoProductoDetalle){
				
				$Codigos .= "".$DatTrasladoProductoDetalle->ProCodigoOriginal.", ";
				
			}
		}
		
			  $mensaje .= "<tr>";
						  
				  $mensaje .= "<td>";
				  $mensaje .= $c;
				  $mensaje .= "</td>";
  
				  $mensaje .= "<td>";
				  $mensaje .= $DatTrasladoProducto->TptId;
				  $mensaje .= "</td>";
				  
				  $mensaje .= "<td>";
				  $mensaje .= $DatTrasladoProducto->TptFecha;
				  $mensaje .= "</td >";

				  $mensaje .= "<td>";
				  $mensaje .= $DatTrasladoProducto->SucNombre;
				  $mensaje .= "</td>";
				  
				    $mensaje .= "<td>";
				  $mensaje .= $DatTrasladoProducto->SucNombreDestino;
				  $mensaje .= "</td>";
				  
				  $mensaje .= "<td>";
				  $mensaje .= $DatTrasladoProducto->TptReferencia;
				  $mensaje .= "</td>";
				  
				  $mensaje .= "<td>";
				  $mensaje .= $DatTrasladoProducto->TptGuiaRemision;
				  $mensaje .= "</td>";
				  
				  
				  $mensaje .= "<td>";
				  $mensaje .= $DatTrasladoProducto->PerNombre." ".$DatTrasladoProducto->PerApellidoPaterno." ".$DatTrasladoProducto->PerApellidoMaterno;
				  $mensaje .= "</td>";
				  
				   $mensaje .= "<td>";
				  $mensaje .= $DatTrasladoProducto->TptTiempoCreacion;
				  $mensaje .= "</td>";
				  				  
				  

				  $mensaje .= "<td>";
				  $mensaje .= $Codigos;
				  $mensaje .= "</td>";
					  
			  $mensaje .= "</tr>";

		  $c++;			
		  
	  
		  $Enviar = true;
	  
		  
				  
  }
	  

		  
			  
		  $mensaje .= "</table>";
		  
		  
	  }
	  
  
  

$mensaje .= "<br>";
$mensaje .= "<br>";
$mensaje .= "Mensaje autogenerado por ".$SistemaNombreAbreviado." a las ".date('d/m/Y H:i:s');


		
				
echo $mensaje;

if($Enviar){
	
	 
	
	//if($POST_Enviar<>"2"){
		$InsCorreo = new ClsCorreo();	
		$InsCorreo->MtdEnviarCorreo($Destinatarios,$SistemaCorreoUsuario,$SistemaCorreoRemitente,"NOTIFICACION: TRASLADOS DE PRODUCTOS REGISTRADOS ".$Titulo,$mensaje);
	//}
	
}
	

?>