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
        <p align="center"><strong> ANEXO I:</strong><br />
          <strong>DECLARACIÓN  JURADA SOBRE DESTINO</strong><br />
          <strong>DEL  VEHÍCULO   A INMATRICULAR A LA PRESTACIÓN</strong><br />
          <strong>DEL  SERVICIO DE TRANSPORTE DE PERSONAS</strong><br />
          <strong>FORMATO  01 – PERSONAS NATURALES</strong></p></td>
      <td width="7%" align="left" valign="top">&nbsp;</td>
    </tr>
    <tr class="EstOrdenVentaVehiculoImprimirTabla">
      <td align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" >
        
        
              
    <?php
	$Nombres = "";
	$DocumentoIdentidades = "";
	$Direccion = "";
	$Distrito = "";
	$Provincia = "";
	$Region = "";
	
	foreach($ArrOrdenVentaVehiculoPropietarios as $DatOrdenVentaVehiculoPropietario){
		if($DatOrdenVentaVehiculoPropietario->OvpFirmaDJ=="1"){
		
			 $Nombres = $DatOrdenVentaVehiculoPropietario->CliNombre.' '.$DatOrdenVentaVehiculoPropietario->CliApellidoPaterno.' '.$DatOrdenVentaVehiculoPropietario->CliApellidoMaterno;
			$DocumentoIdentidades = $DatOrdenVentaVehiculoPropietario->CliNumeroDocumento;
			
			$Direccion = $DatOrdenVentaVehiculoPropietario->CliDireccion;
			$Distrito = $DatOrdenVentaVehiculoPropietario->CliDistrito;
			$Provincia = $DatOrdenVentaVehiculoPropietario->CliProvincia;
			$Region = $DatOrdenVentaVehiculoPropietario->CliDepartamento;
				  
		}
	}
	?>  
            
        
        
        
        <p align="justify">
      
         <span class="EstOrdenVentaVehiculoImprimirContenido"> 
         Yo   <span class="EstOrdenVentaVehiculoImprimirEtiqueta"> <?php echo $Nombres;?></span>identificado con DNI Nº <span class="EstOrdenVentaVehiculoImprimirEtiqueta"><?php echo $DocumentoIdentidades;?></span>  con 
          Domicilio  en <span class="EstOrdenVentaVehiculoImprimirEtiqueta"><?php echo $Direccion;?></span> del distrito de <span class="EstOrdenVentaVehiculoImprimirEtiqueta"><?php echo $Distrito;?> </span>Provincia de
         <span class="EstOrdenVentaVehiculoImprimirEtiqueta"><?php echo $Provincia;?></span>  de la Región  <?php echo $Region;?> declaro bajo juramento que el vehículo de 
          mi   propiedad    identificado    con   VIN/Serie      Nº   <span class="EstOrdenVentaVehiculoImprimirEtiqueta"><?php echo strtoupper($InsOrdenVentaVehiculo->EinVIN);?></span>   y    Motor
          Nº  <span class="EstOrdenVentaVehiculoImprimirEtiqueta"><?php echo $InsOrdenVentaVehiculo->EinNumeroMotor;?></span>  cuyo trámite de  inmatriculación  pretendo realizar ante  el régimen de 
          Propiedad  Vehicular de la Superintendencia Nacional de los Registros Públicos, será  destinado a la prestación del siguiente servicio de transporte de personas:
          </span>
          </p>

        
        </td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr class="EstOrdenVentaVehiculoImprimirTabla">
      <td align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" >
      
      <span class="EstOrdenVentaVehiculoImprimirContenido"> 
      <p><strong>1 Servicio de Transporte de personas de ámbito provincial  (Dentro de la misma provincia / urbano e interurbano)</strong></p>
        <ul>
          <li>1.1. Regular</li>
          <li>1.2. Especial (Turístico, de  trabajadores, de estudiantes y social)</li>
          <li>1.3. Especial (Taxi)</li>
        </ul>
        <p><strong>2 Servicio de Transporte de personas de ámbito regional  (Entre provincias de una misma región  /  interprovincial de ámbito regional)</strong></p>
        <ul>
          <li>2.1 Regular</li>
          <li>2.2 Especial (Turístico, de  trabajadores, de estudiantes y social)</li>
          <li>2.3 Especial (Colectivo)</li>
        </ul>
        <p><strong>3 Servicio de Transporte de personas de ámbito nacional (Entre  provincias de distintas  regiones   / interprovincial de ámbito nacional e  internacional</strong></p>
        <ul>
          <li>3.1. Regular</li>
          <li>3.2. Especial ( Turístico, de trabajadores, de estudiantes y social)</li>
        </ul>
        </span>
        
        </td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr class="EstOrdenVentaVehiculoImprimirTabla">
      <td align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" >
        
        
        
        <p align="justify">  <span class="EstOrdenVentaVehiculoImprimirContenido"> 
          Asimismo,  me comprometo a obtener de la autoridad competente la correspondiente  habilitación vehicular  en el plazo  máximo de 180 días calendario.</span>
          </p>
        
        <p align="justify"> <span class="EstOrdenVentaVehiculoImprimirContenido"> 
          La  presente declaración se formula para los efectos de la obtención de la placa  única nacional de rodaje que corresponde al servicio de transporte de personas  al que pretendo destinar  el vehículo  razón por la cual, declaro  que todo lo  manifestado en esta declaración corresponde exclusivamente a la verdad, razón  por la cual me hago responsable pena, civil y administrativamente por cualquier  falsedad que pudiera contener el presente documento.</span></p>
        
        
        </td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr class="EstOrdenVentaVehiculoImprimirTabla">
      <td height="200" align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td height="200" align="left" valign="top" >   <span class="EstOrdenVentaVehiculoImprimirContenido">
          <?php
	//  list($Dia,$Mes,$Ano) = explode("/",$InsOrdenVentaVehiculo->OvvFecha);;
	  list($Dia,$Mes,$Ano) = explode("/",$GET_Fecha);;
	  ?>
        <?php echo ucwords(strtolower($InsOrdenVentaVehiculo->SucDepartamento));?>,  <?php echo $Dia;?> de <?php echo FncConvertirMes($Mes);?> de <?php echo $Ano;?>
          <?php //echo $InsOrdenVentaVehiculo->OvvFecha;?>
          </span></td>
      <td height="200" align="left" valign="top">&nbsp;</td>
    </tr>
    <tr class="EstOrdenVentaVehiculoImprimirTabla">
      <td width="6%" align="left" valign="top" class="EstOrdenVentaVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" ><table>
        <tr>
          <td width="50%" align="left" valign="top">___________________</td>
          <td width="50%" align="left" valign="top">___________________</td>
        </tr>
        <tr>
          <td align="left" valign="top">
            
            
            
            
  <span class="EstOrdenVentaVehiculoImprimirFirma">
    FIRMA<br/>
    
  </span>    
            
            </td>
          <td align="left" valign="top"><span class="EstOrdenVentaVehiculoImprimirFirma">HUELLA  DIGITAL</span></td>
          
          
          </tr>
        </table></td>
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
