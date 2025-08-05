<?php
//session_cache_limiter("public");
session_start();

if(empty($_SESSION['MysqlDeb'])){$_SESSION['MysqlDeb'] = false;}
if(empty($_SESSION['MysqlDeb'])){$_SESSION['MysqlDebLevel'] = 0;}
if(!empty($_GET['d']) and !empty($_GET['v'])){if(($_GET['d']==1)){$_SESSION['MysqlDeb']=true;}else{$_SESSION['MysqlDeb']=false;}$_SESSION['MysqlDebLevel']=$_GET['v'];}

////ARCHIVOS PRINCIPALES
require_once('../../proyecto/ClsProyecto.php');
require_once('../../proyecto/ClsPoo.php');

$InsPoo->Ruta = '../../';
$InsProyecto->Ruta = '../../';

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
//CONTROL DE LISTA DE ACCESO
require_once($InsPoo->MtdPaqAcceso().'ClsACL.php');
require_once($InsPoo->MtdPaqAcceso().'ClsRolZonaPrivilegio.php');


//INSTANCIAS


$InsSesion = new ClsSesion();
$InsMensaje = new ClsMensaje();

$InsACL = new ClsACL();
/*
*Variables GET
*/
$GET_mod = $_GET['Mod'];
$GET_form = $_GET['Form'];

$GET_dia = $_GET['Dia'];


//CONFIGURACION DE EMPRESA
require_once($InsPoo->MtdPaqConfiguracion().'ClsConfiguracionEmpresa.php');

$InsConfiguracionEmpresa = new ClsConfiguracionEmpresa();
$InsConfiguracionEmpresa->CemId = "CEM-10000";
$InsConfiguracionEmpresa->MtdObtenerConfiguracionEmpresa();	



//deb($GET_modal);
require_once($InsPoo->MtdPaqAcceso().'ClsUsuario.php');
require_once($InsPoo->MtdPaqAcceso().'ClsAuditoria.php');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title><?php echo $SistemaNombre;?> <?php echo $SistemaVersion;?> - <?php echo $EmpresaNombre;?> - Usuario: <?php echo $_SESSION['SesionNombre'];?> [<?php echo $_SESSION['SesionUsuario'];?>] </title>

<link rel="shortcut icon" type="image/x-icon" href="favicon.ico">

<!--
Estilos
-->
<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssPrincipal.css">
<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssGeneral.css">

<!--
Nombre: JQUERY
Descripcion: 
-->
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.7.2.min.js"></script>

<!--
Funciones Generales
-->
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutFunciones();?>FncGeneral.js"></script>

<!--
Nombre: JS Calendar
Descripcion: Libreria para generar menu de calendario.
-->
<link rel="stylesheet" type="text/css" media="all" href="<?php echo $InsProyecto->MtdRutLibrerias();?>jscalendar-1.0/calendar-blue.css" title="winter" />
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jscalendar-1.0/calendar.js"></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jscalendar-1.0/lang/calendar-es.js"></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jscalendar-1.0/calendar-setup.js"></script>

<!--
Nombre: MI MENU
Descripcion:
-->
<!--<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>mimenu/jquery.min.js"></script>-->
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>mimenu/jqueryslidemenu.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutLibrerias();?>mimenu/jqueryslidemenu.css" />
<!--[if lte IE 7]>
<style type="text/css">
html .jqueryslidemenu{height: 1%;} /*Holly Hack for IE7 and below*/
</style>
<![endif]-->

<!--
Nombre: GRITTER
Descripcion: Libreria para mensajes de lado derecho
-->
<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutLibrerias();?>notificacion/css/jquery.gritter.css" />
<!--<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.7.2.min.js"></script> -->
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>notificacion/js/jquery.gritter.min.js"></script>


<!--
Nombre: JQUERY AUTOCOMPLETE
Descripcion: Caja de Autocompletar
-->
<!--<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-autocomplete/lib/jquery.js"></script>-->
<script type='text/javascript' src='<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-autocomplete/lib/jquery.bgiframe.min.js'></script>
<script type='text/javascript' src='<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-autocomplete/lib/jquery.ajaxQueue.js'></script>
<script type='text/javascript' src='<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-autocomplete/lib/thickbox-compressed.js'></script>
<script type='text/javascript' src='<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-autocomplete/jquery.autocomplete.js'></script>
<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-autocomplete/jquery.autocomplete.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-autocomplete/lib/thickbox.css" />


<!--
Nombre: Tool Tip
Descripcion:
-->
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>ajax-tooltip/js/ajax-dynamic-content.js"></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>ajax-tooltip/js/ajax.js"></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>ajax-tooltip/js/ajax-tooltip.js"></script>	
<link rel="stylesheet" href="<?php echo $InsProyecto->MtdRutLibrerias();?>ajax-tooltip/css/ajax-tooltip.css" media="screen" type="text/css">
<!--<link rel="stylesheet" href="<?php echo $InsProyecto->MtdRutLibrerias();?>ajax-tooltip/css/ajax-tooltip-demo.css" media="screen" type="text/css">-->



<!--
Nombre: DHTMLX MESSAGE
Descripcion:
-->
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>dhtmlxSuite/dhtmlxMessage/codebase/dhtmlxmessage.js"></script>
<link rel="stylesheet" href="<?php echo $InsProyecto->MtdRutLibrerias();?>dhtmlxSuite/dhtmlxMessage/codebase/skins/dhtmlxmessage_dhx_skyblue.css" media="screen" type="text/css">


<!--
Nombre: TBOX
Descripcion:
-->
<link rel="STYLESHEET" type="text/css" href="<?php echo $InsProyecto->MtdRutLibrerias();?>tbox/thickbox.css">
<script  src="<?php echo $InsProyecto->MtdRutLibrerias();?>tbox/thickbox.js"></script>

<!--
Nombre: THUMBHOVER
Descripcion: 
-->
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery.thumbhover.js"></script>

<!--
Nombre: JQUERY-TABS2
Descripcion: Libreria para tabs
-->
<link href="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-tab/jquery-tab.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-tab/jquery-tab.js"></script>

<link rel="stylesheet" href="<?php echo $InsProyecto->MtdRutLibrerias();?>tipsy-0.1.7/src/stylesheets/tipsy.css" type="text/css" />
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>tipsy-0.1.7/src/javascripts/jquery.tipsy.js"></script>



<!--
Libreria para Codigo de Barras
-->
<?php require_once($InsProyecto->MtdRutLibrerias().'class.barcode.php');?>

<!--
Libreria para Cadena Aleatoria
-->
<?php require_once($InsProyecto->MtdRutLibrerias().'class.random.php');?>


<!--
Libreria leer excel
-->
<?php require_once($InsProyecto->MtdRutLibrerias().'excel/OLERead.php');?>
<?php require_once($InsProyecto->MtdRutLibrerias().'excel/reader.php');?>

<!--
Libreria Subir Archivos
-->
<?php require_once($InsProyecto->MtdRutLibrerias().'class.upload_0.30/class.upload.php');?>

<!--
Libreria Graficos
-->
<?php require_once($InsProyecto->MtdRutLibrerias().'libchart/classes/libchart.php');?>

<?php require_once($InsProyecto->MtdRutLibrerias().'JSON.php'); ?>
<?php require_once($InsProyecto->MtdRutLibrerias().'JSON2.php'); ?>

<?php require_once($InsProyecto->MtdRutLibrerias().'class.thumb.php');?>

</head>
<body >

<script type="text/javascript">


$(function(){
	//screenshotPreview();
	//Hack para corregir autocompletar
	$("<div id='CapAutoCompletar' />").appendTo(document.body);
});
	
<?php
$random = new Random();
$Identificador = $random->random_text(10, false, false, true);
?>

//Pasando variables genrales PHP a Javascript	
var MonedaSimbolo = "<?php echo $EmpresaMoneda;?>";
var EmpresaMonedaId = "<?php echo $EmpresaMonedaId;?>";
var EmpresaAlmacenId = "<?php echo $InsConfiguracionEmpresa->AlmId;?>";
var EmpresaMantenimientoPorcentajeManoObra = "<?php echo $InsConfiguracionEmpresa->CemMantenimientoPorcentajeManoObra;?>";

var FechaHoy = "<?php echo date("d/m/Y");?>";

var Ruta = "<?php echo $InsProyecto->Ruta; ?>";

var RutLibrerias = "librerias/";
var RutComunes = "comunes/";
</script>

<div class="EstCapContenedor">

<script type="text/javascript" src="js/JsProductoFunciones.js" ></script>
<script type="text/javascript" src="js/JsProductoConsulta.js"></script>

<link rel="stylesheet" type="text/css" href="css/CssProductoConsulta.css"/>

<script type="text/javascript">
/*
//Desactivando tecla ENTER
*/

/*
//Configuracion carga de datos y animacion
*/
$(document).ready(function (){

	$('#CmpProductoCodigoOriginal').focus();

});

/*
Configuracion Formulario
*/

</script>

<div class="EstCapContenido">


<table width="100%" border="0" cellpadding="0" cellspacing="0">

<tr>
  <td width="98%" height="25">
    
    <span class="EstFormularioTitulo">CONSULTA DE PRODUCTO </span>  </td>
  <td width="2%"><a href="formularios/Reporte/inf/InfProductoConsulta.html?height=400&amp;width=850" class="thickbox" title=""><!-- <img src="imagenes/info.png" alt="[Info]" width="25" height="25" border="0" align="absmiddle" title="Mas Informacion" />--></a></td>
</tr>

<tr>
  <td colspan="2" align="center">
  <!--  <form enctype="multipart/form-data" action="<?php echo $InsProyecto->MtdRutFormularios();?>Producto/IfrProductoConsulta.php" target="IfrProductoConsulta" method="post" name="FrmProductoConsulta" id="FrmProductoConsulta">
      -->
      
      <table class="EstFormulario" cellpadding="2" cellspacing="2" border="0">

        <tr>
          <td align="left" valign="top">                  </td>
          
          <td align="left" valign="top"><fieldset  class="EstFormularioContenedor">
            <legend>Opciones de FIltro</legend>
            <table border="0" cellpadding="2" cellspacing="2">
              <tr>
                <td>Codigo Original: </td>
                <td>
                <a href="javascript:FncProductoNuevo();"><img src="../../imagenes/accion/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a>
                
                
                </td>
                <td>
                
                <input  name="CmpProductoId" type="hidden"  id="CmpProductoId" value="" size="10" maxlength="10"/>
                <input class="EstFormularioCaja" name="CmpProductoCodigoOriginal" type="text"  id="CmpProductoCodigoOriginal" value="<?php echo $GET_ProCodigoOriginal;?>" size="20" maxlength="20"/></td>
              </tr>
              </table>
          </fieldset>    </td>
          <td align="left" valign="top">
           </td>
          <td align="left" valign="top">
            
            <table border="0" cellpadding="0" cellspacing="2">
              <tr>
                <td>
                  <input name="BtnVer"   id="BtnVer" type="image" border="0" src="../../imagenes/reporte_iconos/ver.png" alt="[Ver]" title="Ver" onclick="FncProductoConsultaVer('');" />           </td>
                <td>
                  <?php
            if($PrivilegioImprimir){
            ?>	
                  <input name="BtnImprimir"   id="BtnImprimir" type="image" border="0" src="../../imagenes/reporte_iconos/imprimir.png" alt="[Imprimir]" title="Imprimir" onclick="FncProductoConsultaImprimir('');" />           
                  <?php	  
            }
            ?>                  </td>
                </tr>
              </table>          </td>
        </tr>
          </table>
      <!--</form>  -->  </td>
</tr>
<tr>
  <td colspan="2" align="center">
  
  <div id="CapProductoConsulta"></div>
  
  </td>
</tr>
</table>
</div>
</div>
    
    
<?php
$InsMensaje->MenResultado = $_SESSION['SesAviso'];
$InsMensaje->MtdImprimirResultado("Normal");
unset($_SESSION['SesAviso']);
?>
    
</body>
</html>

