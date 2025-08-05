<?php
//session_cache_limiter("public");
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


require_once($InsPoo->MtdPaqAcceso().'ClsUsuario.php');
require_once($InsPoo->MtdPaqAcceso().'ClsAuditoria.php');

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

if($Acceso){	
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">


<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width"/>
 
<title><?php echo $SistemaNombre;?> <?php echo $SistemaVersion;?> - <?php echo $EmpresaNombre;?> - Usuario: <?php echo $_SESSION['SesionNombre'];?> [<?php echo $_SESSION['SesionUsuario'];?>] </title>

<link rel="shortcut icon" type="image/x-icon" href="favicon.ico">

<!--
Estilos
-->
<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssPrincipal.css">
<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssGeneralC.css">
<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssReporte.css">


<!--
Nombre: JQUERY
Descripcion: 
-->
<!--<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.4.3.min.js"></script>-->
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.7.2.min.js"></script>
<!--<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.9.1.min.js"></script>-->

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


<!--
Nombre: NUPLOAD
Descripcion: 
-->
<link href="<?php echo $InsProyecto->MtdRutLibrerias();?>nupload/uploadfile.min.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>nupload/jquery.form.js"></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>nupload/jquery.uploadfile.min.js"></script>

<!--
Nombre: MENU 2016
Descripcion: 
-->

<link rel="stylesheet" href="<?php echo $InsProyecto->MtdRutLibrerias();?>menu2016/cssmenu/styles.css">
<!--<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>-->
<script src="<?php echo $InsProyecto->MtdRutLibrerias();?>menu2016/cssmenu/script.js"></script>


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

<script type="text/javascript">

$(function(){

	//FncReloj();		
	
	$('#CapSesion').html(ImagenAjaxCargar);			

	$.ajax({
		type: 'POST',
		url: 'menus/MenSesionC.php',
		data: '',
		success: function(html){
			$('#CapSesion').html(html);	
			//screenshotPreview();						
		}
	});			
	
		//Cargar tipo de Cambio desde la pagina de SUNAT
	/*$('#CapTipoCambio').html(ImagenAjaxCargar);					

	$.ajax({
		type: 'POST',
		url: 'menus/MenTipoCambio.php',
		data: '',
		success: function(html){
			$('#CapTipoCambio').html(html);
		}
	});*/

	//Hack para corregir autocompletar
	$("<div id='CapAutoCompletar' />").appendTo(document.body);

	$(".autoHeight").css("height",($(window).height()-220));
	//dhtmlx.message({ type:"error", text:"Sistema actualizado 08 de Julio del 2014. Se recomienda presionar CONTROL + F5" });
	
});
	
<?php
$random = new Random();
$Identificador = $random->random_text(10, false, false, true);
?>
//Pasando variables genrales PHP a Javascript	
var CalificacionCosto = <?php echo empty($InsConfiguracionEmpresa->CalCosto)?0:$InsConfiguracionEmpresa->CalCosto;?>;
var CalificacionTipoCambio = <?php echo empty($InsConfiguracionEmpresa->CalTipoCambio)?0:$InsConfiguracionEmpresa->CalTipoCambio;?>;
var CalificacionMargen = <?php echo empty($InsConfiguracionEmpresa->CalMargen)?0:$InsConfiguracionEmpresa->CalMargen;?>;

var MonedaSimbolo = "<?php echo $InsConfiguracionEmpresa->MonSimbolo;?>";
var EmpresaMonedaId = "<?php echo $InsConfiguracionEmpresa->MonId;?>";
var FechaHoy = "<?php echo date("d/m/Y");?>";

var Sitio = "<?php echo $_SERVER['HTTP_HOST']; ?>";
var Ruta = "<?php echo $InsProyecto->Ruta; ?>";
		 
var RutLibrerias = "librerias/";
var RutComunes = "comunes/";
</script>



<!--
<div class="EstCapPrincipalCabecera">
    
    <div class="EstCapCabeceraSesion">
         <div id="CapSesion"></div>
    </div>
    
</div>-->

	<div class="EstCapPrincipalCabecera">
    
		<div class="EstCapCabeceraLogo">
           <img src="imagenes/logos/logo_cabecera.png" width="110" />
		</div>
           <!--<div class="EstCapCabeceraTiempo">
        
        	 <span class="EstRelojFecha">
	          <?php FncFechaHoy();?>
	          </span>
	        <span class="EstRelojHora">&lt;<span id="spanreloj" ></span>&gt;</span>
            
        </div>-->
        
        <div class="EstCapCabeceraSesion">
        	 <div id="CapSesion"></div>
        </div>
        
    <!--    <div class="EstCapCabeceraTipoCambio">
        	 <div id="CapTipoCambio"></div>
        </div>
        -->
     
        

</div>

   <div class="EstCapPrincipalMenu">
	<?php	
    //Menu Botones
    include('menus/MenBotonesC.php');

    ?>
	</div>

	<div class="EstCapPrincipalCuerpo">
      
			<?php
            if($GET_mod<>"Reporte"){
            ?>
            <div class="EstCapSubMenu">
				<?php
                //Menu de formularios
                if(file_exists('formularios/'.$GET_mod.'C/men/Men'.$GET_mod.'.php')){
                  include('formularios/'.$GET_mod.'C/men/Men'.$GET_mod.'.php');	
                }				
                ?>
            </div>   
            <?php
            }
            ?>

            <?php            
            //Formularios	
            if(file_exists('formularios/'.$GET_mod.'C/Frm'.$GET_mod.$GET_form.'.php')){
                include('formularios/'.$GET_mod.'C/Frm'.$GET_mod.$GET_form.'.php');
                
                $InsMensaje->MenResultado = $Resultado;
                $InsMensaje->MtdImprimirResultado();
    
            }else{
                //include('default.php');	
                include('formularios/Default/FrmDefaultC.php');
            }
            ?>
          
        
	</div>
    
<?php
$InsMensaje->MenResultado = $_SESSION['SesAviso'];
$InsMensaje->MtdImprimirResultado();
unset($_SESSION['SesAviso']);
?>

</body>
</html>

<?php
}else{
	//echo "LOGIN";
	header("Location: login.php");
}
?>