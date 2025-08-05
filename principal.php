<?php
//session_cache_limiter("public")AASADSSD;
session_start();

//session_destroy();
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
$GET_NMod = $_GET['NMod'];
$GET_NfnId = $_GET['NfnId'];
$GET_Leido = $_GET['Leido'];
//CONFIGURACION DE EMPRESA
require_once($InsPoo->MtdPaqConfiguracion().'ClsConfiguracionEmpresa.php');

$InsConfiguracionEmpresa = new ClsConfiguracionEmpresa();
$InsConfiguracionEmpresa->CemId = "CEM-10000";
$InsConfiguracionEmpresa->MtdObtenerConfiguracionEmpresa();	


require_once($InsPoo->MtdPaqAcceso().'ClsUsuario.php');
require_once($InsPoo->MtdPaqAcceso().'ClsAuditoria.php');
require_once($InsPoo->MtdPaqActividad().'ClsNotificacion.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsTipoCambio.php');

$Acceso = false;

if($InsSesion->MtdSesionVerificar()){	
	$Acceso = true;
}elseif($InsSesion->MtdRevivirSesion()){
	echo "Sesion recuperada...";
	$Acceso = true;
}
//if($InsSesion->MtdSesionVerificar()){	
//deb($Acceso);

//deb($_COOKIE['Sesion']);
//		if (isset($_COOKIE['Sesion'])) {
//			foreach ($_COOKIE['Sesion'] as $name => $value) {
//				$name = htmlspecialchars($name);
//				$value = htmlspecialchars($value);
//				echo "$name : $value <br />\n";
//			}
//		}

$_SESSION['SesIpAcceso'] = FncObtenerIp();



if($SistemaNombreAbreviado == $_SESSION['SesionSistema']){
	
	


if($Acceso){	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title><?php echo $SistemaNombre;?> <?php echo $SistemaVersion;?> - <?php echo $EmpresaNombre;?> - Usuario: <?php echo $_SESSION['SesionNombre'];?> [<?php echo $_SESSION['SesionUsuario'];?>] </title>

<link rel="shortcut icon" type="image/x-icon" href="favicon.ico">

<!--
Estilos
-->

<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssReporte.css">

<?php
if($_SESSION['MysqlDeb']){
?>
<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssGeneralMenuDebug.css">
<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssPrincipalDebug.css">
<?php		
}else{
?>
<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssPrincipal.css">
<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssGeneral.css">
<?php
}		
?>


<!--
Nombre: JQUERY
Descripcion: 
-->
<!--<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.4.3.min.js"></script>-->
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.7.2.min.js"></script>
<!--<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.9.1.min.js"></script>-->
<!--<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.11.2.min.js"></script>-->

<!--<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-simple-context-menu-master/jquery.contextmenu.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-simple-context-menu-master/jquery.contextmenu.css" title="winter" />-->

  <!-- <script src="http://code.jquery.com/jquery-1.11.2.min.js"></script>
    <script src="../jquery.contextmenu.js"></script>
    <link rel="stylesheet" href="../jquery.contextmenu.css">
    -->
    
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



<!--<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery.bpopup-0.9.0.min.js"></script>
-->
<!--
Nombre: JS Calendar
Descripcion: Libreria para generar menu de calendario.
-->
<link rel="stylesheet" type="text/css" media="all" href="<?php echo $InsProyecto->MtdRutLibrerias();?>jscalendar-1.0/calendar-blue.css" title="winter" />
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jscalendar-1.0/calendar.js"></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jscalendar-1.0/lang/calendar-es.js"></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jscalendar-1.0/calendar-setup.js"></script>

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
Nombre: MENU
Descripcion: 
-->
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>nuevomenu/Dropdown.src.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutLibrerias();?>nuevomenu/Dropdown.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutLibrerias();?>nuevomenu/Dropdown.ltr.css" />
<!--<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutLibrerias();?>nuevomenu/Dropdown.rtl.css" />
-->

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
Nombre: TINY MCE
Descripcion: 
-->
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>tinymce_4.0.21/js/tinymce/tinymce.min.js"></script>

<!--<script type="text/javascript" src='../../codebase/dhtmlxmessage.js'></script>
<link rel="stylesheet" type="text/css" href="../../codebase/skins/dhtmlxmessage_dhx_skyblue.css">
-->
<!--
Nombre: DHTMLX MESSAGE
Descripcion:
-->
<!--<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>dhtmlxSuite/dhtmlxMessage/codebase/dhtmlxmessage.js"></script>
<link rel="stylesheet" href="<?php echo $InsProyecto->MtdRutLibrerias();?>dhtmlxSuite/dhtmlxMessage/codebase/skins/dhtmlxmessage_dhx_skyblue.css" media="screen" type="text/css">
-->


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




<!--
Nombre: AUTOHEIGHT
Descripcion: 
-->
<!--<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>autoheight.js"></script>  
-->

<!--
Nombre: ION SOUND
Descripcion: 
-->
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>ion.sound-1.3.0/js/ion-sound/ion.sound.min.js"></script>  

<!--
Nombre: UPLOADIFY
Descripcion: 
-->
<!--<link href="<?php echo $InsProyecto->MtdRutLibrerias();?>uploadify/uploadify.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>uploadify/jquery.uploadify.min.js"></script>  
-->

<!--
Nombre: NUPLOAD
Descripcion: 
-->
<link href="<?php echo $InsProyecto->MtdRutLibrerias();?>nupload/uploadfile.min.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>nupload/jquery.form.js"></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>nupload/jquery.uploadfile.min.js"></script>



<!--
Nombre: BPOPUP
Descripcion: 
-->
<!--<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery.bpopup.min.js"></script>  -->


<!--
Nombre: CONTEXT-MENU
Descripcion: 
-->
<!-- <script src="http://code.jquery.com/jquery-1.11.2.min.js"></script>-->
<!--
<script src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-simple-context-menu-master/jquery.contextmenu.js"></script>
<link rel="stylesheet" href="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-simple-context-menu-master/jquery.contextmenu.css">
-->
    
    
<!--
Nombre: CONTEXTUAL
Descripcion: 
-->
<!--<link rel="stylesheet" href="<?php echo $InsProyecto->MtdRutLibrerias();?>menucontextual/jquery.contextMenu.css">
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>menucontextual/jquery.contextMenu.js"></script>
-->

<!--
NOTIFICACION 
-->
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Notificacion');?>JsNotificacionFunciones.js" ></script>

<!--
Nombre: DHTMLX MESSAGES
Descripcion:
-->
<script src="<?php echo $InsProyecto->MtdRutLibrerias();?>dhtmlxSuite_v50_std/codebase/dhtmlx.js"></script>
<link rel="stylesheet" href="<?php echo $InsProyecto->MtdRutLibrerias();?>dhtmlxSuite_v50_std/codebase/dhtmlx.css">

<!--
Nombre: SCHEDULE
Descripcion: 
-->

<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>dhtmlxScheduler_v4.3.1/codebase/dhtmlxscheduler.js"></script>
<link href="<?php echo $InsProyecto->MtdRutLibrerias();?>dhtmlxScheduler_v4.3.1/codebase/dhtmlxscheduler.css" rel="stylesheet" type="text/css" />
<!--<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>dhtmlxScheduler_v4.3.1/codebase/ext/dhtmlxscheduler_minical.js"></script>

-->
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>dhtmlxScheduler_v4.3.1/codebase/locale/locale_es.js"></script>
<script src="<?php echo $InsProyecto->MtdRutLibrerias();?>dhtmlxScheduler_v4.3.1/codebase/ext/dhtmlxscheduler_readonly.js" type="text/javascript" charset="utf-8"></script>


<!--
Libreria TOOLTIP
-->

<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jstooltip.js"></script>

<!-- ESTILOS DE JORGITO -->
<link rel="stylesheet" type="text/css" href="estilos/fonts/stylesheet.css">
<style type="text/css">
	*{
		font-family: 'SF Pro Display';
    font-weight: normal;
    font-style: normal;
	}
</style>

<!-- FIN DE ESTILOS DE JORGITO -->
    
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
<?php require_once($InsProyecto->MtdRutLibrerias().'class.numeroaletras.php');?>
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


<?php require_once($InsProyecto->MtdRutLibrerias().'PHPMailer_5.2.4/class.phpmailer.php');?>

<?php
define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

/** Include PHPExcel */
//require_once dirname(__FILE__) . '/../Classes/PHPExcel.php';
require_once($InsProyecto->MtdRutLibrerias().'ZipArchive.php');
require_once($InsProyecto->MtdRutLibrerias().'PHPExcel_1.8.0_doc/Classes/PHPExcel.php');
?>


</head>
<body >

<?php
$random = new Random();
$Identificador = $random->random_text(10, false, false, true);


if(!empty($GET_NfnId)){
	
	if($GET_Leido=="1"){
		
		$InsNotificacion = new ClsNotificacion();
		$InsNotificacion->MtdActualizarEstadoNotificacion($GET_NfnId,"3",false);
		
	}
}
?>

<?php
$InsMoneda = new ClsMoneda();
$InsTipoCambio = new ClsTipoCambio();

$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","ASC",NULL);
$ArrMonedas = $ResMoneda['Datos'];

$ArrTipoCambios = array();

if(!empty($ArrMonedas)){
	foreach($ArrMonedas as $DatMoneda){
		
		$Moneda = array();
		//$Moneda['MonId'] = $DatMoneda->MonId;
		
		$InsTipoCambio = new ClsTipoCambio();
		$InsTipoCambio->MonId = $DatMoneda->MonId;
		$InsTipoCambio->MtdObtenerTipoCambioUltimo();
		$InsTipoCambio->InsMysql = NULL;
		/*if(!empty($InsTipoCambio->NULL)){
			$Moneda['TcaMontoCompra'] = $InsTipoCambio->TcaMontoCompra;
			$Moneda['TcaMontoVenta'] = $InsTipoCambio->TcaMontoVenta;
			$Moneda['TcaMontoComercial'] = $InsTipoCambio->TcaMontoComercial;
		}else{
			$Moneda['TcaMontoCompra'] = 0;
			$Moneda['TcaMontoVenta'] = 0;
			$Moneda['TcaMontoComercial'] = 0;
		}*/
		$ArrTipoCambios[] = $InsTipoCambio;
	
	}
}
?>
<script type="text/javascript">

$(function(){

	screenshotPreview();

	FncReloj();		
	//Cargar tipo de Cambio desde la pagina de SUNAT
	$('#CapTipoCambio').html(ImagenAjaxCargar);					

	$.ajax({
		type: 'POST',
		url: 'menus/MenTipoCambio.php',
		data: '',
		success: function(html){
			$('#CapTipoCambio').html(html);
		}
	});


	$('#CapSesion').html(ImagenAjaxCargar);			

	$.ajax({
		type: 'POST',
		url: 'menus/MenSesion.php',
		data: '',
		success: function(html){
			$('#CapSesion').html(html);	
			screenshotPreview();						
		}
	});	
	
	

	//Hack para corregir autocompletar
	$("<div id='CapAutoCompletar' />").appendTo(document.body);

	$(".autoHeight").css("height",($(window).height()-220));
	//dhtmlx.message({ type:"error", text:"Sistema actualizado 08 de Julio del 2014. Se recomienda presionar CONTROL + F5" });
	
	/*
	$.ionSound({
		sounds: [                       // set needed sounds names
			"bienvenido_cyc",
			"buenos_dias",
			"buenas_tardes",
			"buenas_noches",
			
			"eliminar_no",
			"eliminar_si",
			
			"guardar_si",
			"guardar_no",
			
			"orden_pendiente2"
		],
		path: "audios/",                // set path to sounds
		multiPlay: true,               // playing only 1 sound at once
		volume: "0.9"                   // not so loud please
	});*/
	
	/*$('.thickbox').bPopup({
		content:'iframe', //'ajax', 'iframe' or 'image'
		contentContainer:'.content',
		loadUrl:$(this).attr('href') //Uses jQuery.load()
	});*/
	
//	
//	$('.thickbox').bind('click', function(e) {
//
//                // Prevents the default action to be triggered. 
//                e.preventDefault();
//				var enlace = $(this).attr('href');
////				alert("");
//                // Triggering bPopup when click event is fired
//                $(this).bPopup({
//				    //content:'iframe'//, //'ajax', 'iframe' or 'image'
//					//contentContainer:'.content',
//					loadUrl:enlace,//Uses jQuery.load()
//					 modalColor: 'greenYellow'
//					
//				});
//
//     });

//	$.ajax({
//		type: 'POST',		
//		crossDomain: true,
//		contentType: 'application/x-www-form-urlencoded',
//		 xhrFields: { withCredentials: true },
//		 //ttp://192.168.10.4:8090/FacturadorSunat/MostrarXml.htm
//		url: 'http://192.168.10.4:8090/FacturadorSunat/MostrarXml.htm',
//		data: 'nomArch=20410705878-03-B001-001215&sitArch=03',
//		complete: function(response) {
//
//			console.log("OK");
//			
//		},
//		success: function(respuesta){
//				console.log("NOOK");				
//		}
//	});
//	
	
//		
	
});
	
//Pasando variables genrales PHP a Javascript	
var CalificacionCosto = <?php echo empty($InsConfiguracionEmpresa->CalCosto)?0:$InsConfiguracionEmpresa->CalCosto;?>;
var CalificacionTipoCambio = <?php echo empty($InsConfiguracionEmpresa->CalTipoCambio)?0:$InsConfiguracionEmpresa->CalTipoCambio;?>;
var CalificacionMargen = <?php echo empty($InsConfiguracionEmpresa->CalMargen)?0:$InsConfiguracionEmpresa->CalMargen;?>;

var MonedaSimbolo = "<?php echo $InsConfiguracionEmpresa->MonSimbolo;?>";
var EmpresaMonedaId = "<?php echo $InsConfiguracionEmpresa->MonId;?>";
var FechaHoy = "<?php echo date("d/m/Y");?>";
var EmpresaMonedaId = "<?php echo $InsConfiguracionEmpresa->MonId;?>";
var EmpresaImpuestoVenta = "<?php echo $InsConfiguracionEmpresa->CemImpuestoVenta;?>";
////var EmpresaAlmacenId = "<?php echo $InsConfiguracionEmpresa->AlmId;?>";
var EmpresaAlmacenId = "";
var EmpresaMantenimientoPorcentajeManoObra = "<?php echo $InsConfiguracionEmpresa->CemMantenimientoPorcentajeManoObra;?>";

var Sitio = "<?php echo $_SERVER['HTTP_HOST']; ?>";

var Ruta = "<?php echo $InsProyecto->Ruta; ?>";
		 
var RutLibrerias = "librerias/";
var RutComunes = "comunes/";

var EmpresaMargenesMantenimiento = "<?php echo $EmpresaMargenesMantenimiento;?>";
var EmpresaMargenesMeson = "<?php echo $EmpresaMargenesMeson;?>";

var ArrTipoCambios = (<?php echo json_encode($ArrTipoCambios);?>);
//alert( obj.name === "John" );

//	console.log(ArrTipoCambios['MON-100001'].TcaMontoCompra);
//for (i in ArrTipoCambios) {
//	
//	console.log(ArrTipoCambios[i].MonId);
//	
//    
//}
	
	/*$.each(ArrTipoCambios, function(key, value) {
		console.log('stuff : ' + key + ", " + value);
	});*/
			
			
</script>

<?php


?>
<!--<div class="EstCapContenedor">-->

    <div class="EstCapPrincipalCabecera">
    
		<div class="EstCapCabeceraLogo">
			<?php
/*            if(!empty($SistemaLogo) and file_exists("imagenes/".$SistemaLogo)){
            ?>
            <img src="imagenes/cabecera_<?php echo $SistemaLogo?>" width="110" />
            <?php
            }else{
            ?>
            <img src="imagenes/cabecera_logotipo.png" width="110" />
            <?php	
            }*/
            ?>
            
                        <img src="imagenes/logos/logo_cabecera.png" width="110" height="30"/>
</div>
        <div class="EstCapCabeceraSesion">
        	 <div id="CapSesion"></div>
        </div>
        
        <div class="EstCapCabeceraTipoCambio">
        	 <div id="CapTipoCambio"></div>
        </div>
        
        <div class="EstCapCabeceraTiempo">
        
        	 <span class="EstRelojFecha">
	          <?php FncFechaHoy();?>
	          </span>
	        <span class="EstRelojHora"><span id="spanreloj" ></span></span>
            
        </div>
        

	</div>
	
    <div class="EstCapPrincipalMenu">
	<?php	
    //Menu Botones
    include('menus/MenBotones.php');
//    include('menus/MenBotones2.php');
    ?>
	</div>
 <div class="EstCapPrincipalSubMenu">
 </div>
 
 
	<div class="EstCapPrincipalCuerpo">
      
			<?php
            if($GET_mod<>"Reporte"){
            ?>
                <div class="EstCapSubMenu">
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

          <!--  <div class="EstCapContenido">-->
            <?php            
            //Formularios	
            if(file_exists('formularios/'.$GET_mod.'/Frm'.$GET_mod.$GET_form.'.php')){
                include('formularios/'.$GET_mod.'/Frm'.$GET_mod.$GET_form.'.php');
                
                $InsMensaje->MenResultado = $Resultado;
                $InsMensaje->MtdImprimirResultado();
    
            }else{
                //include('default.php');	
                include('formularios/Default/FrmDefault.php');
            }
            ?>
            <!--</div>-->
        
	</div>
    
   
  <!--  <div class="EstCapPrincipalPie">
    C&C S.A.C.
    </div>-->
<!--</div>
    -->
    
<?php
/*//if($_SESSION['SisAudio']){
?>
<script type="text/javascript">

$().ready(function() {
	
	
	
	
<?php
		if(empty($GET_mod) or empty($GET_form)){
?>
			$.ionSound.play("bienvenido_cyc");
<?php
		}
		
?>

		

	
});
</script>
<?php
//}*/
?>

<div class='error' style='display:none'></div>

<?php
$InsMensaje->MenResultado = $_SESSION['SesAviso'];
$InsMensaje->MtdImprimirResultado();
unset($_SESSION['SesAviso']);
?>

<!--<script>
        (function(w,d,u){
                var s=d.createElement('script');s.async=true;s.src=u+'?'+(Date.now()/60000|0);
                var h=d.getElementsByTagName('script')[0];h.parentNode.insertBefore(s,h);
        })(window,document,'https://cdn.bitrix24.es/b11099221/crm/site_button/loader_1_35ifeq.js');
</script>
-->
</body>
</html>

<?php
}else{
	//echo "LOGIN";
	header("Location: login.php");
}

}else{
	$_SESSION['SesAviso'].="#ERR_GEN_207";
	header("Location: login.php");
}
?>