<?php
//session_cache_limiter("public");
session_start();

if(empty($_SESSION['MysqlDeb'])){$_SESSION['MysqlDeb'] = false;}
if(empty($_SESSION['MysqlDeb'])){$_SESSION['MysqlDebLevel'] = 0;}
if(!empty($_GET['d']) and !empty($_GET['v'])){if(($_GET['d']==1)){$_SESSION['MysqlDeb']=true;}else{$_SESSION['MysqlDeb']=false;}$_SESSION['MysqlDebLevel']=$_GET['v'];}

////ARCHIVOS PRINCIPALES
require_once('proyecto/ClsProyecto.php');
require_once('proyecto/ClsPoo.php');

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



$Acceso = false;

if($InsSesion->MtdSesionVerificar()){	
	$Acceso = true;
}elseif($InsSesion->MtdRevivirSesion()){
	echo "Sesion recuperada...";
	$Acceso = true;
}


if (isset($_COOKIE['Sesion'])) {
	//deb($_COOKIE['Sesion[SesionIniciado]']);	
//	echo "...";
}else{
	
}
//		if (isset($_COOKIE['Sesion'])) {
//			foreach ($_COOKIE['Sesion'] as $name => $value) {
//				$name = htmlspecialchars($name);
//				$value = htmlspecialchars($value);
//				echo "$name : $value <br />\n";
//			}
//		}

//if($InsSesion->MtdSesionVerificar()){	
if($Acceso){	
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
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.7.2.min.js"></script>

<!--
Funciones Generales
-->
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutFunciones();?>FncGeneral.js"></script>

<!--
Nombre: SPRY VALIDATION
Descripcion: Librerias de Validacion
-->
<script src="<?php echo $InsProyecto->MtdRutSpry();?>SpryValidationTextField.js" type="text/javascript"></script>
<link href="<?php echo $InsProyecto->MtdRutSpry();?>SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<script src="<?php echo $InsProyecto->MtdRutSpry();?>SpryValidationSelect.js" type="text/javascript"></script>
<link href="<?php echo $InsProyecto->MtdRutSpry();?>SpryValidationSelect.css" rel="stylesheet" type="text/css" />
<script src="<?php echo $InsProyecto->MtdRutSpry();?>SpryValidationTextarea.js" type="text/javascript"></script>
<link href="<?php echo $InsProyecto->MtdRutSpry();?>SpryValidationTextarea.css" rel="stylesheet" type="text/css" />
<script src="<?php echo $InsProyecto->MtdRutSpry();?>SpryValidationRadio.js" type="text/javascript"></script>
<link href="<?php echo $InsProyecto->MtdRutSpry();?>SpryValidationRadio.css" rel="stylesheet" type="text/css" />

<script src="<?php echo $InsProyecto->MtdRutSpry();?>SpryValidationCheckbox.js" type="text/javascript"></script>
<link href="<?php echo $InsProyecto->MtdRutSpry();?>SpryValidationCheckbox.css" rel="stylesheet" type="text/css" />


<!--
Nombre: JS Calendar
Descripcion: Libreria para generar menu de calendario.
-->
<link rel="stylesheet" type="text/css" media="all" href="<?php echo $InsProyecto->MtdRutLibrerias();?>jscalendar-1.0/calendar-blue.css" title="winter" />
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jscalendar-1.0/calendar.js"></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jscalendar-1.0/lang/calendar-es.js"></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jscalendar-1.0/calendar-setup.js"></script>


<!--
Nombre: MI ARBOL
Descripcion:
-->
<?php require_once($InsProyecto->MtdRutLibrerias().'jbarbol/jbarbol.php');?>
<link rel="stylesheet" type="text/css" media="all" href="<?php echo $InsProyecto->MtdRutLibrerias();?>jbarbol/jbacss.css" />

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
Nombre: Jquery Tabs y demas
Descripcion: Libreria para generar tabs y demas.
-->

<!--<link type="text/css" href="librerias/jquery-ui-1.7.2.custom/css/smoothness/jquery-ui-1.7.2.custom.css" rel="stylesheet" />	
<script type="text/javascript" src="librerias/jquery-ui-1.7.2.custom/js2/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="librerias/jquery-ui-1.7.2.custom/js2/jquery-ui-1.7.2.custom.min.js"></script>-->


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
Nombre: FCK Editor
Descripcion: Libreria para generar los campos de descripcion.
-->
<!--<link href="<?php echo $InsProyecto->MtdRutLibrerias();?>fckeditor/_samples/sample.css" rel="stylesheet" type="text/css" />-->
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>fckeditor/fckeditor.js"></script>


<!--
Nombre: Arbol DHTMLX
Descripcion:
-->
<link rel="STYLESHEET" type="text/css" href="<?php echo $InsProyecto->MtdRutLibrerias();?>dhtmlxTree/dhtmlxTree/codebase/dhtmlxtree.css">
<script  src="<?php echo $InsProyecto->MtdRutLibrerias();?>dhtmlxTree/dhtmlxTree/codebase/dhtmlxcommon.js"></script>
<script  src="<?php echo $InsProyecto->MtdRutLibrerias();?>dhtmlxTree/dhtmlxTree/codebase/dhtmlxtree.js"></script>
<script  src="<?php echo $InsProyecto->MtdRutLibrerias();?>dhtmlxTree/dhtmlxTree/codebase/ext/dhtmlxtree_xw.js"></script>    
<script  src="<?php echo $InsProyecto->MtdRutLibrerias();?>dhtmlxTree/dhtmlxTree/codebase/ext/dhtmlxtree_li.js"></script>


<!--
Nombre: TINY MCE
Descripcion: 
-->

<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>tinymce_4.0.21/js/tinymce/tinymce.min.js"></script>

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
Nombre: AUTOHEIGHT
Descripcion: 
-->
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>autoheight.js"></script>  
<!--
Nombre: SCHEDULE
Descripcion: 
-->


<!--
Nombre: SCHEDULE
Descripcion: 
-->

<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>dhtmlxScheduler_v4.3.1/codebase/dhtmlxscheduler.js"></script>
<link href="<?php echo $InsProyecto->MtdRutLibrerias();?>dhtmlxScheduler_v4.3.1/codebase/dhtmlxscheduler.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>dhtmlxScheduler_v4.3.1/codebase/ext/dhtmlxscheduler_minical.js"></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>dhtmlxScheduler_v4.3.1/codebase/locale/locale_es.js"></script>


<!--
Nombre: JS Timer
Descripcion: 
-->
<!-- Prerequisites: jQuery and jQuery UI Stylesheet -->
<!--<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>-->
<!--<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutLibrerias();?>jQuery.ptTimeSelect-0.8/jquery-ui.css" />

<link rel="stylesheet" type="text/css" media="all" href="<?php echo $InsProyecto->MtdRutLibrerias();?>jQuery.ptTimeSelect-0.8/src/jquery.ptTimeSelect.css" title="winter" />
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jQuery.ptTimeSelect-0.8/src/jquery.ptTimeSelect.js"></script>

-->

<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jonthornton-jquery-timepicker-1.11.11-5-gde77772/jquery.timepicker.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutLibrerias();?>jonthornton-jquery-timepicker-1.11.11-5-gde77772/jquery.timepicker.css" />

<!--
Nombre: NUPLOAD
Descripcion: 
-->
<link href="<?php echo $InsProyecto->MtdRutLibrerias();?>nupload/uploadfile.min.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>nupload/jquery.form.js"></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>nupload/jquery.uploadfile.min.js"></script>





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
     
	<?php
	if($GET_mod<>"Reporte"){
	?>
      <div class="EstCapMenu">
		<?php
        //Menu de formularios
        if(file_exists('formularios/'.$GET_mod.'/men/Men'.$GET_mod.'.php')){
            include('formularios/'.$GET_mod.'/men/Men'.$GET_mod.'.php');	
        }				
        ?>
    </div>   
    <?php
	}
	?>

		<?php            
        //Formularios	
        if(file_exists('formularios/'.$GET_mod.'/Frm'.$GET_mod.$GET_form.'.php')){
            include('formularios/'.$GET_mod.'/Frm'.$GET_mod.$GET_form.'.php');
			
						
			$InsMensaje->MenResultado = $Resultado ?? '';
			$InsMensaje->MtdImprimirResultado("Normal");
        }else{
            //include('default.php');	
            include('formularios/Default/FrmDefault.php');
        }
        ?>

</div>
    
    
<?php
$InsMensaje->MenResultado = $_SESSION['SesAviso'] ?? '';
$InsMensaje->MtdImprimirResultado("Normal");
unset($_SESSION['SesAviso']);
?>
    
</body>
</html>

<?php
}else{
	header("Location: login.php");	
}
?>
