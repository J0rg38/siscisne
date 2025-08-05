<?php
session_start();
require_once('../../proyecto/ClsProyecto.php');
require_once('../../proyecto/ClsPoo.php');
$InsProyecto->Ruta = '../../';
$InsPoo->Ruta = '../../';

require_once($InsProyecto->MtdRutConexiones().'ClsConexion.php');
require_once($InsProyecto->MtdRutClases().'ClsMysql.php');

/*
*Mensajes
*/
require_once($InsProyecto->MtdRutMensajes().'MsjGeneral.php');
/*
*Configuraciones
*/
require_once($InsProyecto->MtdRutConfiguraciones().'CnfSistema.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfEmpresa.php');
/*
*Clases Generales
*/
require_once($InsProyecto->MtdRutClases().'ClsSesion.php');
require_once($InsProyecto->MtdRutClases().'ClsSesionObjeto.php');
require_once($InsProyecto->MtdRutClases().'ClsMensaje.php');
/*
*Funciones
*/
require_once($InsProyecto->MtdRutFunciones().'FncGeneral.php');

/*
*Control de Lista de Acceso
*/
require_once($InsPoo->MtdPaqAcceso().'ClsACL.php');
require_once($InsPoo->MtdPaqAcceso().'ClsRolZonaPrivilegio.php');
/*
*Instancias
*/
$InsMensaje = new ClsMensaje();
$InsSesion = new ClsSesion();
$InsACL = new ClsACL();

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>REGISTRAR CARGO DE PERSONAL</title>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>/jquery-1.4.2.min.js"></script>
<!--
Funciones Generales
-->
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutFunciones();?>/FncGeneral.js"></script>
<!--
Estilos
-->
<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>/CssGeneral.css">

<!--
Librerias de Validacion
-->
<script src="<?php echo $InsProyecto->MtdRutSpry();?>/SpryValidationTextField.js" type="text/javascript"></script>
<link href="<?php echo $InsProyecto->MtdRutSpry();?>/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<script src="<?php echo $InsProyecto->MtdRutSpry();?>/SpryValidationSelect.js" type="text/javascript"></script>
<link href="<?php echo $InsProyecto->MtdRutSpry();?>/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
<script src="<?php echo $InsProyecto->MtdRutSpry();?>/SpryValidationTextarea.js" type="text/javascript"></script>
<link href="<?php echo $InsProyecto->MtdRutSpry();?>/SpryValidationTextarea.css" rel="stylesheet" type="text/css" />

<script type="text/javascript">
//Pasando variables genrales PHP a Javascript	
var MonedaSimbolo = "<?php echo $EmpresaMoneda;?>";
var EmpresaMonedaId = "<?php echo $EmpresaMonedaId;?>";
var FechaHoy = "<?php echo date("d/m/Y");?>";
var ArcPrincipal = "principal.php";
var Ruta = "<?php echo $InsProyecto->Ruta; ?>";	
</script>
</head>

<body >

<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"PersonalTipo","Registrar")){
?>

<?php
include('formularios/PersonalTipo/msj/MsjPersonalTipo.php');
require_once($InsPoo->MtdPaqRRHH().'/ClsPersonalTipo.php');

$InsPersonalTipo = new ClsPersonalTipo();

include('formularios/PersonalTipo/acc/AccPersonalTipoRegistrar.php');

//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();
?>

<form id="FrmRegistrar" name="FrmRegistrar" method="post" action="#" enctype="multipart/form-data">

<div class="EstCapMenu">

            <div class="EstSubMenuBoton"><a href="javascript:self.parent.FncCargarPersonalTipos();self.parent.tb_remove();" ><img src="imagenes/iconos/salir.png" alt="[Salir]" title="Salir"  />Salir</a></div>
            
<div class="EstSubMenuBoton">
<input name="BtnGuardar"   id="BtnGuardar" type="image" border="0" src="imagenes/acc_guardar.gif" alt="[Guardar]" title="Guardar" />
<div>Guardar</div>
</div>

<?php
if(!empty($GET_dia)){
?>
	<div class="EstSubMenuBoton"><a href="javascript:self.parent.tb_remove('<?php echo $GET_mod;?>');" ><img src="imagenes/iconos/salir.png" alt="[Salir]" title="Salir" border="0"  />Salir</a></div>
<?php	
}
?>
	
</div>

<div class="EstCapContenido">


<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
      
      <tr>
        <td width="961" height="25" colspan="2"><span class="EstFormularioTitulo">REGISTRAR CARGO DE PERSONAL</span></td>
      </tr>
      <tr>
        <td colspan="2">
        
         <div class="EstFormularioArea">
         
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td valign="top">&nbsp;</td>
            <td valign="top">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Nombre:</td>
            <td>
              <span id="sprytextfield1">
                <label>
                  <input class="EstFormularioCaja"  name="CmpNombre" type="text" id="CmpNombre" value="<?php echo $InsPersonalTipo->PtiNombre;?>" size="40" maxlength="250" />
                  </label>
                <span class="textfieldRequiredMsg"><img src="imagenes/advertencia.png" width="20" height="20" border="0" align="absmiddle" title="Debe completar este campo" alt="[A]"  /></span></span></td>
            <td>&nbsp;</td>
          </tr>
          
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>
        
        </div>
        </td>
      </tr>
      <tr>
        <td colspan="2" align="center">&nbsp;</td>
        </tr>
    </table>
    
    
</div>


</form>
<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
//-->
</script>
        
<?php
}else{
	echo ERR_GEN_101;
}

//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();
?>

</body>
</html>



