<?php
//session_start();
//if(empty($_SESSION['MysqlDeb'])){$_SESSION['MysqlDeb'] = false;}
//if(empty($_SESSION['MysqlDeb'])){$_SESSION['MysqlDebLevel'] = 0;}
//if(!empty($_GET['d']) and !empty($_GET['v'])){if(($_GET['d']==1)){$_SESSION['MysqlDeb']=true;}else{$_SESSION['MysqlDeb']=false;}$_SESSION['MysqlDebLevel']=$_GET['v'];}

////ARCHIVOS PRINCIPALES
require_once('../../proyecto/ClsProyecto.php');
require_once('../../proyecto/ClsPoo.php');

$InsPoo->Ruta = '../../';
$InsProyecto->Ruta = '../../';

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
/*
*Control de Lista de Acceso
*/
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
<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssReporte.css">


<!--
Nombre: JQUERY
Descripcion: 
-->
<!--<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.4.3.min.js"></script>-->
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.7.2.min.js"></script>
<!--<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.9.1.min.js"></script>-->
<!--<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.11.2.min.js"></script>-->

<!--
Funciones Generales
-->
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutFunciones();?>FncGeneral.js"></script>

<!--
Nombre: JQUERY AUTOCOMPLETE
Descripcion: Caja de Autocompletar
-->
<!--<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-autocomplete/lib/jquery.js"></script>-->
<script type='text/javascript' src='<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-autocomplete/lib/jquery.bgiframe.min.js'></script>
<script type='text/javascript' src='<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-autocomplete/lib/jquery.ajaxQueue.js'></script>
<!--<script type='text/javascript' src='<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-autocomplete/lib/thickbox-compressed.js'></script>-->
<script type='text/javascript' src='<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-autocomplete/jquery.autocomplete.js'></script>

<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-autocomplete/jquery.autocomplete.css" />
<!--<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-autocomplete/lib/thickbox.css" />-->

</head>
<body >

<script type="text/javascript">
$(function(){

	//Hack para corregir autocompletar
	$("<div id='CapAutoCompletar' />").appendTo(document.body);

});

var Ruta = "<?php echo $InsProyecto->Ruta; ?>";
		 
var RutLibrerias = "librerias/";
var RutComunes = "comunes/";

</script>

<!--<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Producto");?>JsProductoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Producto");?>JsProductoAutocompletar.js" ></script>
-->
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs("AlmacenMovimientoEntrada");?>JsAlmacenMovimientoEntradaDetalleReemplazar.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs("AlmacenMovimientoEntrada");?>JsAlmacenMovimientoEntradaDetalleReemplazarFunciones.js" ></script>

<?php

$Identificador = $_GET['Identificador'];
$POST_Item = $_GET['Item'];

session_start();
if (!isset($_SESSION['InsAlmacenMovimientoEntradaDetalle'.$Identificador])){
	$_SESSION['InsAlmacenMovimientoEntradaDetalle'.$Identificador] = new ClsSesionObjeto();
}

$InsAlmacenMovimientoEntradaDetalle1 = array();
$InsAlmacenMovimientoEntradaDetalle1 = $_SESSION['InsAlmacenMovimientoEntradaDetalle'.$Identificador]->MtdObtenerSesionObjeto($_GET['Item']);

?>

<div class="EstFormularioArea"> 
    <div id="ForBuscadorProductos"  >
      <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
        <tr>
          <td width="1%">&nbsp;</td>
          <td colspan="2"><span class="EstFormularioSubTitulo"> Datos de los codigos a reemplazar</span></td>
          <td width="1%">&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td colspan="2" align="left" valign="top"><span class="EstFormularioSubTitulo2">Codigo Actual</span></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td width="20%" align="left" valign="top">Codigo Original:</td>
          <td width="78%" align="left" valign="top"><input name="CmpProductoCodigoOriginalAnterior" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpProductoCodigoOriginalAnterior" value="<?php  echo $InsAlmacenMovimientoEntradaDetalle1->Parametro17;  ?>" size="20" maxlength="20" readonly="readonly" /></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td align="left" valign="top">Nombre:</td>
          <td align="left" valign="top"><input class="EstFormularioCaja" name="CmpProductoNombreAnterior" type="text" id="CmpProductoNombreAnterior" value="<?php echo $InsAlmacenMovimientoEntradaDetalle1->Parametro3;?>" size="45" maxlength="255"  /></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td align="left" valign="top">&nbsp;</td>
          <td align="left" valign="top"></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td colspan="2" align="left" valign="top"><span class="EstFormularioSubTitulo2">Codigo Nuevo</span> </td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td width="20%" align="left" valign="top">Codigo Original:
          
        <input type="hidden" name="Identificador" id="Identificador" value="<?php echo $Identificador;?>" />
        <input type="hidden" name="CmpProductoItem" id="CmpProductoItem" value="<?php echo $POST_Item;?>" />
        
        <input type="hidden" name="CmpProductoId" id="CmpProductoId" value="" />
		<input type="hidden" name="CmpProductoId" id="CmpProductoId" value="" /></td>
          <td align="left" valign="top">
          
          <table border="0" cellpadding="0" cellspacing="2">
          <tr>
          <td>
          
            <a href="javascript:FncProductoNuevo();"><img src="../../imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a>
            
          </td>
          <td>
          <input name="CmpProductoCodigoOriginal" type="text"  class="EstFormularioCaja" id="CmpProductoCodigoOriginal" size="20" maxlength="20" />
          </td>
          <td>
          
          
          <a href="javascript:FncProductoBuscar('CodigoOriginal');"><img src="../../imagenes/acciones/buscar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a>
          
          
          
          </td>
          <td>  <a id="BtnProductoRegistrar" onclick="FncProductoCargarFormulario('Registrar');"  href="javascript:void(0)" title="">
                            <img src="../../imagenes/acciones/registrar.png" alt="[Registrar]" width="25" height="25" border="0" align="absmiddle" title="Registrar" /> 
                            </a>
                            
                            <a id="BtnProductoEditar" onclick="FncProductoCargarFormulario('Editar');" href="javascript:void(0)"   title="">
                            <img src="../../imagenes/acciones/editar.png" alt="[Editar]" width="25" height="25" border="0" align="absmiddle" title="Editar" /> 
                            </a></td>
          </tr>
          </table>
          
          
          </td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td align="left" valign="top">Nombre:</td>
          <td align="left" valign="top"><input name="CmpProductoNombre" type="text" class="EstFormularioCaja" id="CmpProductoNombre" size="45" maxlength="255" readonly="readonly"  /></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td colspan="2" align="center">
          <input class="EstFormularioBoton" type="button" name="BtnReemplazar" id="BtnReemplazar" value="Reemplazar" />
          <input class="EstFormularioBoton" type="button" name="BtnCancelar" id="BtnCancelar" value="Cancelar" />
          </td>
          <td>&nbsp;</td>
        </tr>
    
      </table>
    </div>
</div>
   

</body>
</html>

