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
      <td height="99" colspan="3" align="left" valign="top"><!--<img src="../../imagenes/dj_cabecera.jpg" align="[Cabecera]" title="Cabecera"  />--></td>
    </tr>
    <tr>
      <td width="6%" align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td align="center" valign="top" ><p>   <strong><u>CARTA  PODER</u></strong></p></td>
      <td width="7%" align="left" valign="top">&nbsp;</td>
    </tr>
    <tr class="EstOrdenVentaVehiculoImprimirTabla">
      <td align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" >
        
        
        <p align="justify">
          <span class="EstOrdenVentaVehiculoImprimirContenido"> SUNAR</span><br />
          <span class="EstOrdenVentaVehiculoImprimirEtiqueta"> REGISTRO DE PROPIEDAD VEHICULAR </span><br />
          <span class="EstOrdenVentaVehiculoImprimirContenido">Presente.-</span><br />
            <span class="EstOrdenVentaVehiculoImprimirContenido">
        Por intermedio de la presente:
          </span>
          </p>
        
        
        <p align="justify">
        
        
          <span class="EstOrdenVentaVehiculoImprimirContenido"> 
            
           Tengo a bien conferir   <span class="EstOrdenVentaVehiculoImprimirEtiqueta"> Poder Especial</span> para que las  personas a continuación se mencionan , puedan en forma  individual suscribir indistintamente el  <span class="EstOrdenVentaVehiculoImprimirEtiqueta">FORMATO ELECTRONICO DE INMATRICULACION</span>  aprobado por  la SUNARP  , <span class="EstOrdenVentaVehiculoImprimirEtiqueta">FORMULARIO NOTARIAL </span> de cambio de características , así como cualquier  documento que se requiera para la inscripción solicitada al Registro de Propiedad Vehicular .
            </span>
          
          
          </p>
        
        </td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr class="EstOrdenVentaVehiculoImprimirTabla">
      <td align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" >
        
        <p align="justify">
          <span class="EstOrdenVentaVehiculoImprimirContenido"> 
           Los apoderados designados mediante la presente carta son los siguientes:  </span>
          </p>
        </td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr class="EstOrdenVentaVehiculoImprimirTabla">
      <td width="6%" rowspan="4" align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td align="center" valign="top" >
        
        
        <?php
$InsPago = new ClsPago();
$ResPago = $InsPago->MtdObtenerPagos(NULL,NULL,NULL,"PagFecha","ASC",NULL,NULL,NULL,$InsOrdenVentaVehiculo->OvvId,NULL,NULL);

$ArrPagos = $ResPago['Datos'];

?>
        <table width="92%" border="1" cellpadding="2" cellspacing="2" class="EstOrdenVentaVehiculoImprimirTabla">
          <thead class="EstOrdenVentaVehiculoImprimirTablaHead">
            <tr>
              <th width="8%" align="center">Nombres&nbsp;y&nbsp;Apellidos&nbsp;&nbsp;</th>
              <th width="13%" align="center"><p>DNI</p></th>
              </tr>
            </thead>
          <tbody class="EstOrdenVentaVehiculoImprimirTablaBody"> 
            <?php
	  $i=1;
	  if(!empty($PesonalTramiteAAP)){
		  foreach($PesonalTramiteAAP as $DatPesonalTramiteAAP){
	?>
            <tr>
              <td align="left"><?php echo $DatPesonalTramiteAAP[0];?></td>
              <td align="left"><?php echo $DatPesonalTramiteAAP[1];?></td>
              </tr>
            
            <?php
			$i++;
		  }
	  }
	  ?>  
            </tbody>
          </table>
        
        
        </td>
      <td rowspan="4" align="left" valign="top">&nbsp;</td>
    </tr>
    <tr class="EstOrdenVentaVehiculoImprimirTabla">
      <td align="left" valign="top" >
      <p align="justify">
      
      <span class="EstOrdenVentaVehiculoImprimirContenido">En consecuencia, agradeciendo por la atención prestada al presente otorgamiento de facultades quedo a ustedes.

 </span>
 </p>
 
 <p align="justify">
  <span class="EstOrdenVentaVehiculoImprimirContenido">
 En señal de conformidad con el contenido del presente documento se legaliza la firma ante Notario. </span>
 </p>
  <p align="justify">
  <span class="EstOrdenVentaVehiculoImprimirContenido">
 Atentamente </span>
 </p>
 </td>
    </tr>
    <tr class="EstOrdenVentaVehiculoImprimirTabla">
      <td height="200" align="left" valign="top" >&nbsp;</td>
    </tr>
    <tr class="EstOrdenVentaVehiculoImprimirTabla">
      <td align="left" valign="top" ><table width="100%" align="center">
          <tr>
            <td align="left" valign="top">
              
             
          

<span class="EstOrdenVentaVehiculoImprimirFirma">
FIRMA Y HUELLA  DACTILAR.<br/>

</span>    

            </td>
            
            
          </tr>
          </table></td>
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
