<?php
//session_destroy();
session_start();
//session_destroy();
if(empty($_SESSION['MysqlDeb'])){$_SESSION['MysqlDeb'] = false;}
if(empty($_SESSION['MysqlDeb'])){$_SESSION['MysqlDebLevel'] = 0;}
if(!empty($_GET['d']) and !empty($_GET['v'])){if(($_GET['d']==1)){$_SESSION['MysqlDeb']=true;}else{$_SESSION['MysqlDeb']=false;}$_SESSION['MysqlDebLevel']=$_GET['v'];}
	
/*
*Archivos de Sistema
*/
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

//INSTANCIAS
$InsSesion = new ClsSesion();
$InsMensaje = new ClsMensaje();
$InsConexion = new ClsConexion();

if(empty($_SESSION['SesAviso'])){
	$InsSesion->MtdDestruirSesion();	
}

require_once($InsPoo->MtdPaqConfiguracion().'ClsConfiguracionEmpresa.php');

$InsConfiguracionEmpresa = new ClsConfiguracionEmpresa();
$InsConfiguracionEmpresa->CemId = "CEM-10000";
$InsConfiguracionEmpresa->CemRuta = $InsProyecto->MtdRutConfiguraciones();
$InsConfiguracionEmpresa->MtdGenerarConfiguracionEmpresa();

?>


 <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
    <html>
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
            <meta name="viewport" content="width=device-width"/>
            <title>ADMINISTRADOR DE <?php echo $SistemaNombre;?></title>
             <!--  <link rel="stylesheet" type="text/css" href="estilos/CssPrincipal.css">-->
            <link rel="stylesheet" type="text/css" href="estilos/CssGeneral.css">    
            <link rel="stylesheet" type="text/css" href="estilos/CssAcceso.css">   
         
            
          
            
			<script type="text/javascript" src="librerias/jquery-1.3.2.min.js"></script>

                 
             <script type="text/javascript" src="funciones/FncGeneral.js"></script>
             <script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
        <link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
        </head>
    <body onLoad="FncReloj();">
    
    <?php    
    $InsMensaje->MenResultado = $_SESSION['SesAviso'];
    $InsMensaje->MtdImprimirResultado();
    unset($_SESSION['SesAviso']);
    ?>
    
<div class="CapAccesoPrincipal">
<!--	<div class="CapAccesoBarraSuperior">
    
    <table width="100%" class="EstTablaSesion">
            <tr>
            <td align="right">
            
			<?php FncFechaHoy();?> <<span id="spanreloj" ></span>>
            
            </td>
            </tr>
            </table>
    </div>-->
<!--    <div class="CapAccesoCuerpoMargenArriba"></div>-->
   <!-- <div class="CapAccesoCuerpo">-->
    
        <!--<div class="CapAccesoFormularioMargen">-</div>-->
        
     	<!--<div class="CapAccesoFormulario">-->
          <form method="post" name="FrmSesion" id="FrmSesion" action="sesion/SesIniciar.php" enctype="application/x-www-form-urlencoded" >
                 

<div class="login">

    <div class="login-header">
    	<h1>ACCESO A SISTEMA</h1>
    </div>
    
	<div class="login-form">
  
		<img src="imagenes/login_<?php echo $SistemaLogo;?>" alt="" width="30%" />
        
        <h3>Usuario:</h3>
        <span id="sprytextfield1">
        <label>
        <input class="EstFormularioCaja" type="text" placeholder="Usuario" id="CmpUsuario"  name="CmpUsuario" />
        </label>
        
        <span class="textfieldRequiredMsg"><img src="imagenes/advertencia.png" width="20" height="20" border="0" align="absmiddle" title="Debe completar este campo" alt="[A]"  /></span></span>
        
		<br>
		<h3>Contraseña:</h3>
        <span id="sprytextfield2">
        <label>
        <input class="EstFormularioCaja" type="password" placeholder="Contraseña"  name="CmpContrasena" id="CmpContrasena"/>
        </label>
        <span class="textfieldRequiredMsg"><img src="imagenes/advertencia.png" width="20" height="20" border="0" align="absmiddle" title="Debe completar este campo" alt="[A]"  /></span></span>
             
           <!-- <h6 class="login-check"> <input value="1" name="CmpVersionCelular" id="CmpVersionCelular" type="checkbox"> Version para celular</h6>  -->
       <input type="hidden" name="CmpVersionCelular" id="CmpVersionCelular" value="1">
        <br>
        <input class="EstFormularioBoton" name="BtnIniciarSesion" id="BtnIniciarSesion" type="submit" value="Iniciar Sesion">
        
  
  <!--  <br>
    <a class="sign-up">Sign Up!</a>-->
   <!-- <br>
    <h6 class="no-access">Can't access your account?</h6>-->
    
    <br> 
    <br> 
    <div class="EstAccesoPie">
  <!--  <?php echo $EmpresaNombre;?>  - <?php echo date("Y");?>    <br> -->
     <?php echo $SistemaNombre;?> v<?php echo $SistemaVersion;?>
     </div>
     
	</div>
</div>
<!--<div class="error-page">
  <div class="try-again">Error: Try again?</div>
</div>-->


    
 
            </form>	
    	<!--</div>-->
        
       <!-- <div class="CapAccesoFormularioMargen">-</div>-->
    
 <!--   </div>-->
    <!--    <div class="CapAccesoCuerpoMargenAbajo"></div>-->
    
<!--    <div class="CapAccesoBarraInferior">
	
<?php echo $EmpresaNombre;?>  - <?php echo date("Y");?>    <br> 
     <?php echo $SistemaNombre;?> v<?php echo $SistemaVersion;?>
    
    </div>
    -->
    </div>
</div>


            
          
    
           
<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
//-->
</script>

    </body>
    </html>
