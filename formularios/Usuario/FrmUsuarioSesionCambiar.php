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
require_once('clases/ClsSesion.php');
require_once($InsProyecto->MtdRutClases().'ClsSesionObjeto.php');
require_once('clases/ClsMensaje.php');
/*
*Funciones
*/
require_once($InsProyecto->MtdRutFunciones().'FncGeneral.php');
/*
*Funciones
*/
require_once($InsProyecto->MtdRutFunciones().'FncGeneral.php');
//CONTROL DE LISTA DE ACCESO
require_once('paquetes/PaqAcceso/Clases/ClsACL.php');
//INSTANCIAS
$InsMensaje = new ClsMensaje();
$InsSesion = new ClsSesion();
$InsACL = new ClsACL();


require_once($InsPoo->MtdCnfAcceso());

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>CAMBIAR DE SESION DE USUARIO</title>

<script type="text/javascript" src="librerias/jquery-1.4.2.min.js"></script>
<!--
Funciones Generales
-->
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutFunciones();?>/FncGeneral.js"></script>
<!--
Estilos
-->
<link rel="stylesheet" type="text/css" href="../estilos/CssGeneral.css">
<link rel="stylesheet" type="text/css" href="../estilos/CssAcceso.css">   
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


var Ruta = "<?php echo $InsProyecto->Ruta; ?>";	
</script>
</head>

<body >

    <?php    
    $InsMensaje->MenResultado = $_SESSION['SesAviso'];
    $InsMensaje->MtdImprimirResultado();
    unset($_SESSION['SesAviso']);
    ?>


    
<div class="EstCapMenu">
  
            <div class="EstSubMenuBoton"><a href="javascript:self.parent.tb_remove();" ><img src="imagenes/iconos/salir.png" alt="[Salir]" title="Salir"  />Salir</a></div>
            
</div>

<div class="EstCapContenido">
                                                 
<form method="post" name="FrmSesion" id="FrmSesion" action="../../sesion/SesCambiar.php" enctype="application/x-www-form-urlencoded" >
                 
<table width="543" border="0" align="center" cellpadding="2" cellspacing="2" class="EstTablaAcceso">
	<thead class="EstTablaAccesoHead">
		<tr>
			<th align="center" >
				<fieldset>CAMBIAR SESION DE USUARIO</fieldset>
			</th>
		</tr>
	</thead>
	<tbody class="EstTablaAccesoBody">
		<tr>
			<td >
			<fieldset>
       
       <table border="0" align="center" cellpadding="2" cellspacing="1" class="EstTablaAcceso" >
       <tbody class="EstTablaAccesoBody">
         <tr>
           <td rowspan="4" align="left"> 
           
             </td>
           <td align="left">&nbsp;</td>
           <td align="left">&nbsp;</td>
         </tr>
         <tr>
           <td align="left">Usuario: </td>
           <td align="left"><span id="sprytextfield1">
             <label>
             <input class="EstFormularioCaja" name="CmpUsuario" type="text" id="CmpUsuario" size="30" maxlength="255">
             </label>
             
             
             
             
             <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
         </tr>
         
         <tr>
           <td align="left">Contrasena: </td>
           <td align="left"><span id="sprytextfield2">
             <label>
               <input class="EstFormularioCaja" name="CmpContrasena" type="password" id="CmpContrasena" size="30" maxlength="255">
               </label>
             <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
         </tr>
         
         <tr>
           <td colspan="2" align="center"><input class="EstFormularioBoton" name="BtnIniciarSesion" id="BtnIniciarSesion" type="submit" value="Cambiar Sesion"></td>
         </tr>
         </tbody>
       </table>       
       
			</fieldset>
			</td>
		</tr>
	</tbody>
	<tfoot class="EstTablaAccesoFoot">
        <tr>
            <td align="right">&nbsp;
            
            </td>
        </tr>
	</tfoot>
    </table> 
    
 
</form>	
		 



<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
//-->
</script>



       
</div>      
    
  

</body>
</html>
