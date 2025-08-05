<?php
session_start();
require_once('../../proyecto/ClsProyecto.php');
require_once('../../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../../';
$InsPoo->Ruta  = '../../';

////CONFIGURACIONES GENERALES
require_once($InsProyecto->MtdRutConfiguraciones().'CnfSistema.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfEmpresa.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfConexion.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfNotificacion.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfFormularioNota.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfModulo'.$_SESSION['SesionSucursalSiglas'].'.php');
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


require_once($InsProyecto->MtdRutLibrerias().'class.numeroaletras.php');

$GET_id = $_GET['Id'];
$GET_M = $_GET['M'];
$GET_Fecha = (empty($_GET['Fecha'])?date("d/m/Y"):$_GET['Fecha']);

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculo.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoCondicionVenta.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoObsequio.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoLlamada.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoVersionCaracteristica.php');

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoPropietario.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoMantenimiento.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsPago.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsPagoComprobante.php');

$InsPago = new ClsPago();
$InsOrdenVentaVehiculoPropietario = new ClsOrdenVentaVehiculoPropietario();

$InsOrdenVentaVehiculo = new ClsOrdenVentaVehiculo();
$InsOrdenVentaVehiculo->OvvId = $GET_id;
$InsOrdenVentaVehiculo->MtdObtenerOrdenVentaVehiculo(false);


$ResPago = $InsPago->MtdObtenerPagos(NULL,NULL,NULL,"PagFecha","ASC",NULL,NULL,NULL,$InsOrdenVentaVehiculo->OvvId,NULL,NULL);
$ArrPagos = $ResPago['Datos'];


$ResOrdenVentaVehiculoPropietario = $InsOrdenVentaVehiculoPropietario->MtdObtenerOrdenVentaVehiculoPropietarios(NULL,NULL,'OvpId', 'Desc',NULL,$InsOrdenVentaVehiculo->OvvId,NULL);
$ArrOrdenVentaVehiculoPropietarios = $ResOrdenVentaVehiculoPropietario['Datos'];


if($InsOrdenVentaVehiculo->MonId<>$EmpresaMonedaId){

		$InsOrdenVentaVehiculo->OvvPrecio = round($InsOrdenVentaVehiculo->OvvPrecio / $InsOrdenVentaVehiculo->OvvTipoCambio,3);
		$InsOrdenVentaVehiculo->OvvDescuento = round($InsOrdenVentaVehiculo->OvvDescuento / $InsOrdenVentaVehiculo->OvvTipoCambio,3);
		
		$InsOrdenVentaVehiculo->OvvBonoGM = round($InsOrdenVentaVehiculo->OvvBonoGM / $InsOrdenVentaVehiculo->OvvTipoCambio,3);
		$InsOrdenVentaVehiculo->OvvBonoDealer = round($InsOrdenVentaVehiculo->OvvBonoDealer / $InsOrdenVentaVehiculo->OvvTipoCambio,3);
		
		$InsOrdenVentaVehiculo->OvvDescuentoGerencia = round($InsOrdenVentaVehiculo->OvvDescuentoGerencia / $InsOrdenVentaVehiculo->OvvTipoCambio,3);
		
		$InsOrdenVentaVehiculo->OvvTotal = round($InsOrdenVentaVehiculo->OvvTotal / $InsOrdenVentaVehiculo->OvvTipoCambio,3);
		$InsOrdenVentaVehiculo->OvvImpuesto = round($InsOrdenVentaVehiculo->OvvImpuesto / $InsOrdenVentaVehiculo->OvvTipoCambio,3);
		$InsOrdenVentaVehiculo->OvvSubTotal = round($InsOrdenVentaVehiculo->OvvSubTotal / $InsOrdenVentaVehiculo->OvvTipoCambio,3);
		
		
		$InsOrdenVentaVehiculo->CveTotal = round($InsOrdenVentaVehiculo->CveTotal / $InsOrdenVentaVehiculo->OvvTipoCambio,3);
			
	}	
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Declaracion Jurada No. <?php echo $InsOrdenVentaVehiculo->OvvId;?></title>

<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssImprimir.css">
<link href="css/CssOrdenVentaVehiculoImprimir.css" rel="stylesheet" type="text/css" />
<link href="css/CssOrdenVentaVehiculoImprimirMP1.css" rel="stylesheet" type="text/css" />

<!--<script type="text/javascript" src="js/JsOrdenVentaVehiculoImprimir.js"></script>-->
<!--<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.4.3.min.js"></script>-->
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="js/JsOrdenVentaVehiculoImprimirMP1.js" ></script>

<!--
Nombre: JS Calendar
Descripcion: Libreria para generar menu de calendario.
-->
<link rel="stylesheet" type="text/css" media="all" href="<?php echo $InsProyecto->MtdRutLibrerias();?>jscalendar-1.0/calendar-blue.css" title="winter" />
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jscalendar-1.0/calendar.js"></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jscalendar-1.0/lang/calendar-es.js"></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jscalendar-1.0/calendar-setup.js"></script>

<script type="text/javascript">
$().ready(function() {
	
<?php if($_GET['P']==1 and !empty($InsOrdenVentaVehiculo->OvvId)){?> 
FncOrdenVentaVehiculoMP1Imprimir(); 
<?php }?>

<?php if($_GET['P']==1){?>
setTimeout("window.close();",1500);
<?php }?>
	
});
</script>


</head>
<body>

<!--
<hr class="EstReporteLinea">
-->

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstOrdenVentaVehiculoImprimirTabla">

<tr>
    <td valign="top"><table width="100%" border="0" cellpadding="3" cellspacing="2" class="EstOrdenVentaVehiculoImprimirTabla">
    <tr>
      <td colspan="3" align="left" valign="top">
        
        
  <?php if($_GET['P']<>1){ ?>
        
        
  <form id="FrmOrdenDia" name="FrmOrdenDia" method="get" enctype="multipart/form-data" action="#">
    
  <input type="hidden" name="Id" id="Id" value="<?php echo $GET_id;?>" />
  <input type="hidden" name="P" id="P" value="" />
    
    
  <table border="0" align="right" cellpadding="0" cellspacing="0">
  <tr>
    <td align="right" valign="top">
      
      
      <a id="BtnImprimir" href="javascript:void(0);"> Imprimir <img src="../../imagenes/acciones/imprimir.gif" alt="Imprimir" width="25" height="25" border="0" align="absmiddle" title="Imprimir" /></a></td>
  </tr>
  </table>
    
  </form>
  <?php }?>
        
        
  </td>
    </tr>
    <tr>
      <td width="6%" align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td align="center" valign="top" >
        
        
        
        
        
        <p>   <strong><u> ANEXO 1</u></strong><br />
          AMPLIACION DE FORMATO DE INMATRICULACIONES (Segunda hoja)<br />
          TIPO O USO DEL VEHICULO
          </p>
        
        
        
        </td>
      <td width="7%" align="left" valign="top">&nbsp;</td>
    </tr>
    <tr class="EstOrdenVentaVehiculoImprimirTabla">
      <td align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td align="center" valign="top" >
        
 
        <table width="100%" border="1" cellpadding="2" cellspacing="2" class="EstOrdenVentaVehiculoImprimirContenido">
          <tr>
            <td align="center">   <span class="EstOrdenVentaVehiculoImprimirEtiqueta"> TIPO O USO DEL VEHICULO</span></td>
            <td align="center" valign="top"><span class="EstOrdenVentaVehiculoImprimirEtiqueta"> Opciones    de acuerdo a
              Resolución    Directoral Nº 4012-
              2009-MTC/15</span></td>
            <td align="center" valign="top"><span class="EstOrdenVentaVehiculoImprimirEtiqueta"> Consignar    el dato correspondiente      (ver instrucciones)</span></td>
          </tr>
          <tr>
            <td valign="top"><p>VEHICULOS MENORES</p></td>
            <td valign="top"><p>&nbsp;</p></td>
            <td valign="top"><p>&nbsp;</p></td>
          </tr>
          <tr>
            <td valign="top"><p>Categoría</p></td>
            <td valign="top"><p>L1, L2, L3, L4, L5</p></td>
            <td valign="top"><p>&nbsp;</p></td>
          </tr>
          <tr>
            <td valign="top"><p>VEHICULOS LIVIANOS O PESADOS</p></td>
            <td valign="top"><p>&nbsp;</p></td>
            <td valign="top"><p>&nbsp;</p></td>
          </tr>
          <tr>
            <td valign="top"><p>Vehículos de la Categoría M</p></td>
            <td valign="top"><p>M - Particular</p></td>
            <td valign="top"><p>&nbsp;</p></td>
          </tr>
          <tr>
            <td valign="top"><p>Vehículos de la Categoría M1</p></td>
            <td valign="top"><p>-M1 – Taxis<br />
              -M1 – Colectivo</p></td>
            <td valign="top"><p>&nbsp;</p></td>
          </tr>
          <tr>
            <td valign="top"><p>Vehículos de las Categorías M2    y M3 para el servicio de transporte urbano e interurbano de personas</p></td>
            <td valign="top"><p>-M2 para el servicio de transporte urbano de    personas.<br />
              -M2 para el servicio de transporte interurbano de    personas.<br />
              -M3 para el servicio de transporte urbano de    personas.<br />
              -M3 para el servicio de transporte urbano e interurbano    de personas.<br />
              -M2 para el servicio de transporte urbano de    personas.<br />
              -M3 para el servicio de transporte urbano e    interurbano de personas.</p></td>
            <td valign="top"><p>&nbsp;</p></td>
          </tr>
          <tr>
            <td valign="top"><p>Vehículos de las Categorías M2    y M3 para el servicio de transporte     interprovincial de personas</p></td>
            <td valign="top"><p>-M2 para el servicio de transporte interprovincial    de personas.<br />
              -M3 para el servicio de transporte interprovincial    de personas.</p></td>
            <td valign="top"><p>&nbsp;</p></td>
          </tr>
          <tr>
            <td valign="top"><p>Vehículos motorizados de la categoría    N para el transporte de mercancías</p></td>
            <td valign="top"><p>Motorizados N para el transporte de mercancías.</p></td>
            <td valign="top"><p>&nbsp;</p></td>
          </tr>
          <tr>
            <td valign="top"><p>Vehículos no motorizados de la    categoría O para el transporte de mercancías</p></td>
            <td valign="top"><p>Motorizados O para el transporte de mercancía.</p></td>
            <td valign="top"><p>&nbsp;</p></td>
          </tr>
        </table>

        
        </td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr class="EstOrdenVentaVehiculoImprimirTabla">
      <td align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" >
      
       <span class="EstOrdenVentaVehiculoImprimirContenido"> 
      <p>Glosario</p>
        <ol>
          <li>Tipo: Categoría, que ha sido determinada por  el Ministerio de Transporte, en:</li>
        </ol>
        <p>Vehículos menores: L1, L2, L3, L4, L5<br />
          Vehículos Livianos o pesados:M, M1, M2, M3, N, O.</p>
        <ol>
          <li>Uso: Servicio, el que ha sido determinado por  el Ministerio de Transportes y Comunicaciones solo para los Vehículos Liviano o  pesados, como:</li>
        </ol>
        <p>-Particular<br />
          -Taxi<br />
          -Colectivo<br />
          -Servicio de transporte urbano de personas.<br />
          -Servicio de transporte interurbano de personas.<br />
          -Servicio de transporte interprovincial de personas.<br />
          -Transporte de mercancías.</p>
          </span>
          </td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr class="EstOrdenVentaVehiculoImprimirTabla">
      <td align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" >
        
        <p align="justify">&nbsp;</p>
        </td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="3" align="center" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
    </tr>
    </table></td>
  </tr>
  
<tr>
    <td colspan="5">&nbsp;</td>
  </tr>
</table>




<?php /*if($_GET['P']<>1){ ?>

<script type="text/javascript"> 
	Calendar.setup({ 
	inputField : "Fecha",  // id del campo de texto 
	ifFormat   : "%d/%m/%Y",  //  
	button     : "BtnFecha",//,// el id del bot&oacute;n que  
	onUpdate       :    FncOrdenVentaVehiculoCargar
	}); 
</script>
<?php
}*/
?> 
 
</body>
</html>
