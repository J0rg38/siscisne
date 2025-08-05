<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"InformeTecnico",$GET_form)){
?>   

<?php $PrivilegioVistaPreliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"InformeTecnico","VistaPreliminar"))?true:false;?>
<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"InformeTecnico","Imprimir"))?true:false;?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsInformeTecnicoIT200Funciones.js" ></script>

<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssInformeTecnicoIT200.css');
</style>
<?php
//VARIABLES
$Registro = false;

$GET_FinId = $_GET['FinId'];

if(!empty($_POST['Identificador'])){
	$Identificador = $_POST['Identificador'];
}
//MENSAJES
include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjInformeTecnico.php');
//CLASES
require_once($InsPoo->MtdPaqActividad().'ClsInformeTecnico.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngreso.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoGasto.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoLlamada.php');
require_once($InsPoo->MtdPaqActividad().'ClsPreEntregaDetalle.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoModalidad.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoTarea.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoProducto.php');

require_once($InsPoo->MtdPaqActividad().'ClsFichaAccion.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionSalidaExterna.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionFoto.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionTarea.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionTempario.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionProducto.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionMantenimiento.php');

//require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoSalida.php');
//require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoSalidaDetalle.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsTallerPedido.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsTallerPedidoDetalle.php');

require_once($InsPoo->MtdPaqRRHH().'ClsPersonal.php');

//INSTANCIAS
$InsInformeTecnico = new ClsInformeTecnico();
$InsFichaIngreso = new ClsFichaIngreso();
$InsPersonal = new ClsPersonal();

//ACCIONES
include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccInformeTecnicoRegistrar.php');
//DATOS

$ResPersonal = $InsPersonal->MtdObtenerPersonales(NULL,NULL,NULL,"PerNombre","ASC",NULL,NULL,NULL,NULL);
$ArrPersonales = $ResPersonal['Datos'];

//ALERTAS
//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();
?>


<script type="text/javascript">
/*
Desactivando tecla ENTER
*/
	FncDesactivarEnter();
/*
Configuracion carga de datos y animacion
*/
$(document).ready(function (){

});
/*
Configuracion Formulario
*/
</script>


<form id="FrmRegistrar" name="FrmRegistrar" method="post" action="#" enctype="multipart/form-data">

<div class="EstCapMenu">
<input name="BtnGuardar"   id="BtnGuardar" type="image" border="0" src="imagenes/acc_guardar.gif" alt="[Guardar]" title="Guardar" />

<?php
if(!empty($GET_dia)){
?>
	<div class="EstSubMenuBoton"><a href="javascript:self.parent.tb_remove('<?php echo $GET_mod;?>');" ><img src="imagenes/iconos/salir.png" alt="[Salir]" title="Salir" border="0"  />Salir</a></div>&nbsp;
<?php	
}
?>
	

<?php
if($Registro){
?>

	<?php
    if($PrivilegioVistaPreliminar){
    ?>
    <div class="EstSubMenuBoton"><a href="javascript:FncVistaPreliminar('<?php echo $InsInformeTecnico->IteId;?>');"><img src="imagenes/iconos/preliminar.png" alt="[Vista Preliminar]" title="Vista preliminar" />V.P.</a></div>
    <?php
    }
    ?>
	<?php
    if($PrivilegioImprimir){
    ?>
    <div class="EstSubMenuBoton"><a href="javascript:FncImprmir('<?php echo $InsInformeTecnico->IteId;?>');"><img src="imagenes/iconos/imprimir.png" alt="[Imprimir]" title="Imprimir"  />Imprimir</a></div>
    <?php
    }
    ?>

<?php	
}
?>

</div>

<div class="EstCapContenido">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
      
      <tr>
        <td width="1922" height="25" colspan="2"><span class="EstFormularioTitulo">REGISTRAR INFORME TECNICO IT200</span></td>
      </tr>
      <tr>
        <td colspan="2">
          
	<ul class="tabs">
        <li><a href="#tab1">Informe Tecnico <span class="EstFormularioTitulo">IT200</span></a></li>
	</ul>

<div class="tab_container">
    <div id="tab1" class="tab_content">
        <!--Content-->


<table width="100%" border="0" cellpadding="2" cellspacing="2">
           
            <tr>
              <td valign="top">
              
              
<div class="EstFormularioArea">
                   <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                     <tr>
                       <td>&nbsp;</td>
                       <td colspan="6"><span class="EstFormularioSubTitulo">Datos del Informe Tecnico <span class="EstFormularioTitulo">IT200</span></span></td>
                       <td>&nbsp;</td>
                       </tr>
                     <tr>
                       <td>&nbsp;</td>
                       <td>&nbsp;</td>
                       <td>&nbsp;</td>
                       <td>&nbsp;</td>
                       <td>&nbsp;</td>
                       <td>&nbsp;</td>
                       <td>&nbsp;</td>
                       <td>&nbsp;</td>
                       </tr>
                     <tr>
                       <td>&nbsp;</td>
                       <td align="left" valign="top">Codigo de Formato:</td>
                       <td align="left" valign="top"><input readonly="readonly" name="CmpCodigoFormato" type="text" class="EstFormularioCaja" id="CmpCodigoFormato" value="IT-200" size="15" maxlength="20" /></td>
                       <td align="left" valign="top">No. de Reporte:</td>
                       <td align="left" valign="top"><input readonly="readonly" name="CmpId" type="text" class="EstFormularioCaja" id="CmpId" value="<?php echo $InsInformeTecnico->IteId;?>" size="15" maxlength="20" /></td>
                       <td align="left" valign="top">Propietario:</td>
                       <td align="left" valign="top"><input  name="CmpPropietario" type="text"  class="EstFormularioCaja" id="CmpPropietario" value="<?php echo $InsInformeTecnico->ItePropietario;?>" size="30" maxlength="50" /></td>
                       <td>&nbsp;</td>
                     </tr>
                     <tr>
                       <td>&nbsp;</td>
                       <td align="left" valign="top">Fecha de Emision:<br />
                         <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
                       <td align="left" valign="top"><span id="sprytextfield7">
                       <label>
                         <input class="EstFormularioCajaFecha" name="CmpFecha" type="text" id="CmpFecha" value="<?php echo ($InsInformeTecnico->IteFecha);?>" size="15" maxlength="10" />
                       </label>
                       <span class="textfieldInvalidFormatMsg"><img src="imagenes/advertencia.png" alt=""  border="0" align="absmiddle" title="Formato no valido"  /></span><span class="textfieldRequiredMsg">Se necesita un valor.</span></span><img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFecha" name="BtnFecha" width="25" height="25" align="absmiddle"  style="cursor:pointer;" /></td>
                       <td align="left" valign="top">Fecha de Venta:<br />
                         <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
                       <td align="left" valign="top"><span id="sprytextfield">
                       <label>
                         <input class="EstFormularioCajaFecha" name="CmpFechaVenta" type="text" id="CmpFechaVenta" value="<?php echo $InsInformeTecnico->IteFechaVenta;?>" size="15" maxlength="10" />
                       </label>
                       <span class="textfieldInvalidFormatMsg"><img src="imagenes/advertencia.png" alt=""  border="0" align="absmiddle" title="Formato no valido"  /></span><span class="textfieldRequiredMsg">Se necesita un valor.</span></span><img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFechaVenta" name="BtnFechaVenta" width="25" height="25" align="absmiddle"  style="cursor:pointer;" /></td>
                       <td align="left" valign="top">Nro. de VIN:</td>
                       <td align="left" valign="top"><input  name="CmpVehiculoIngresoVIN" type="text"  class="EstFormularioCaja" id="CmpVehiculoIngresoVIN" value="<?php echo $InsInformeTecnico->EinVIN;?>" size="30" maxlength="50" readonly="readonly" /></td>
                       <td>&nbsp;</td>
                     </tr>
                     <tr>
                       <td>&nbsp;</td>
                       <td align="left" valign="top">Tipo y No. de Motor:</td>
                       <td align="left" valign="top"><input  name="CmpMotor" type="text"  class="EstFormularioCaja" id="CmpMotor" value="<?php echo $InsInformeTecnico->IteMotor;?>" size="30" maxlength="50" readonly="readonly" /></td>
                       <td align="left" valign="top">Tipo de Transmision:</td>
                       <td align="left" valign="top"><input  name="CmpTipoTransmision" type="text"  class="EstFormularioCaja" id="CmpTipoTransmision" value="<?php echo $InsInformeTecnico->IteTipoTransmision;?>" size="30" maxlength="50" readonly="readonly" /></td>
                       <td align="left" valign="top">&nbsp;</td>
                       <td align="left" valign="top">&nbsp;</td>
                       <td>&nbsp;</td>
                     </tr>
                     <tr>
                       <td>&nbsp;</td>
                       <td align="left" valign="top">Kilometraje:</td>
                       <td align="left" valign="top"><input  name="CmpKilometraje" type="text"  class="EstFormularioCaja" id="CmpKilometraje" value="<?php echo $InsInformeTecnico->FinVehiculoKilometraje;?>" size="30" maxlength="50" readonly="readonly" /></td>
                       <td align="left" valign="top">Tipo de Carroceria:</td>
                       <td align="left" valign="top"><input  name="CmpTipoCarroceria" type="text"  class="EstFormularioCaja" id="CmpTipoCarroceria" value="<?php echo $InsInformeTecnico->IteTipoCarroceria;?>" size="30" maxlength="50" readonly="readonly" /></td>
                       <td align="left" valign="top">Carga/Tara:</td>
                       <td align="left" valign="top"><input  name="CmpCarga" type="text"  class="EstFormularioCaja" id="CmpCarga" value="<?php echo $InsInformeTecnico->IteCarga;?>" size="30" maxlength="50" readonly="readonly" /></td>
                       <td>&nbsp;</td>
                     </tr>
                     <tr>
                       <td>&nbsp;</td>
                       <td align="left" valign="top">Ciudad:</td>
                       <td align="left" valign="top"><input  name="CmpCiudad" type="text"  class="EstFormularioCaja" id="CmpCiudad" value="<?php echo $InsInformeTecnico->IteCiudad;?>" size="30" maxlength="50" readonly="readonly" /></td>
                       <td align="left" valign="top">Departamento:</td>
                       <td align="left" valign="top"><input  name="CmpDepartamento" type="text"  class="EstFormularioCaja" id="CmpDepartamento" value="<?php echo $InsInformeTecnico->IteDepartamento;?>" size="30" maxlength="50" readonly="readonly" /></td>
                       <td align="left" valign="top">Uso del Vehiculo:</td>
                       <td align="left" valign="top"><input  name="CmpUsoVehiculo" type="text"  class="EstFormularioCaja" id="CmpUsoVehiculo" value="<?php echo $InsInformeTecnico->IteUsoVehiculo;?>" size="30" maxlength="50" readonly="readonly" /></td>
                       <td>&nbsp;</td>
                     </tr>
                     <tr>
                       <td>&nbsp;</td>
                       <td align="left" valign="top">Altitud M.S.N.M:</td>
                       <td align="left" valign="top"><input  name="CmpAltitud" type="text"  class="EstFormularioCaja" id="CmpAltitud" value="<?php echo $InsInformeTecnico->IteAltitud;?>" size="30" maxlength="50" readonly="readonly" /></td>
                       <td align="left" valign="top">Ord. de Trabajo:</td>
                       <td align="left" valign="top"><input readonly="readonly" name="CmpFichaIngresoId" type="text" class="EstFormularioCaja" id="CmpFichaIngresoId" value="<?php echo $InsInformeTecnico->FinId;?>" size="15" maxlength="20" /></td>
                       <td align="left" valign="top">&nbsp;</td>
                       <td align="left" valign="top">&nbsp;</td>
                       <td>&nbsp;</td>
                     </tr>
                     <tr>
                       <td>&nbsp;</td>
                       <td align="left" valign="top">&nbsp;</td>
                       <td align="left" valign="top">&nbsp;</td>
                       <td align="left" valign="top">&nbsp;</td>
                       <td align="left" valign="top">&nbsp;</td>
                       <td align="left" valign="top">&nbsp;</td>
                       <td align="left" valign="top">&nbsp;</td>
                       <td>&nbsp;</td>
                     </tr>
                     <tr>
                       <td>&nbsp;</td>
                       <td colspan="6" align="left" valign="top">Sintoma</td>
                       <td>&nbsp;</td>
                     </tr>
                     <tr>
                       <td>&nbsp;</td>
                       <td colspan="6" align="left" valign="top"><textarea name="CmpCondicion" cols="60" rows="2" class="EstFormularioCaja" id="CmpCondicion"><?php echo stripslashes($InsInformeTecnico->IteCondicion);?></textarea></td>
                       <td>&nbsp;</td>
                     </tr>
                     <tr>
                       <td>&nbsp;</td>
                       <td align="left" valign="top">&nbsp;</td>
                       <td align="left">&nbsp;</td>
                       <td align="left">&nbsp;</td>
                       <td align="left">&nbsp;</td>
                       <td align="left">&nbsp;</td>
                       <td align="left">&nbsp;</td>
                       <td>&nbsp;</td>
                     </tr>
                     <tr>
                       <td>&nbsp;</td>
                       <td colspan="6" align="left" valign="top">Diagnostico</td>
                       <td>&nbsp;</td>
                     </tr>
                     <tr>
                       <td>&nbsp;</td>
                       <td colspan="6" align="left" valign="top"><textarea name="CmpCausa" cols="60" rows="2" class="EstFormularioCaja" id="CmpCausa"><?php echo stripslashes($InsInformeTecnico->IteCausa);?></textarea></td>
                       <td>&nbsp;</td>
                     </tr>
                     <tr>
                       <td>&nbsp;</td>
                       <td align="left" valign="top">&nbsp;</td>
                       <td align="left">&nbsp;</td>
                       <td align="left">&nbsp;</td>
                       <td align="left">&nbsp;</td>
                       <td align="left">&nbsp;</td>
                       <td align="left">&nbsp;</td>
                       <td>&nbsp;</td>
                     </tr>
                     <tr>
                       <td>&nbsp;</td>
                       <td colspan="6" align="left" valign="top">Accion Correctiva</td>
                       <td>&nbsp;</td>
                     </tr>
                     <tr>
                       <td>&nbsp;</td>
                       <td colspan="6" align="left" valign="top"><textarea name="CmpCorreccion" cols="60" rows="2" class="EstFormularioCaja" id="CmpCorreccion"><?php echo stripslashes($InsInformeTecnico->IteCorreccion);?></textarea></td>
                       <td>&nbsp;</td>
                     </tr>
                     <tr>
                       <td>&nbsp;</td>
                       <td align="left" valign="top">&nbsp;</td>
                       <td align="left">&nbsp;</td>
                       <td align="left">&nbsp;</td>
                       <td align="left">&nbsp;</td>
                       <td align="left">&nbsp;</td>
                       <td align="left">&nbsp;</td>
                       <td>&nbsp;</td>
                     </tr>
                     <tr>
                       <td>&nbsp;</td>
                       <td colspan="6" align="left" valign="top"> Conclusiones</td>
                       <td>&nbsp;</td>
                     </tr>
                     <tr>
                       <td>&nbsp;</td>
                       <td colspan="6" align="left" valign="top"><textarea name="CmpConclusion" cols="60" rows="2" class="EstFormularioCaja" id="CmpConclusion"><?php echo stripslashes($InsInformeTecnico->IteConclusion);?></textarea></td>
                       <td>&nbsp;</td>
                     </tr>
                     <tr>
                       <td>&nbsp;</td>
                       <td align="left" valign="top">&nbsp;</td>
                       <td align="left">&nbsp;</td>
                       <td align="left">&nbsp;</td>
                       <td align="left">&nbsp;</td>
                       <td align="left">&nbsp;</td>
                       <td align="left">&nbsp;</td>
                       <td>&nbsp;</td>
                     </tr>
                     </table>
                   </div>
                   
                   
              </td>
            </tr>

             

            </table>
          
          
    </div>
    

        




</div>      
          
          
          
          
          
          
          
          
          
          
          
          
          
          
          
          
          
          
          
          
          
          
          
          
          
          
        </td>
      </tr>
      
      <tr>
        <td colspan="2" align="center">&nbsp;</td>
        </tr>
    </table>
</div>
	
	
	
  


<!--  -->
  
</form>
<script type="text/javascript">
Calendar.setup({ 
	inputField : "CmpFecha",  // id del campo de texto 
	ifFormat   : "%d/%m/%Y",  //  
	button     : "BtnFecha"// el id del botón que  
	});

Calendar.setup({ 
	inputField : "CmpFechaVenta",  // id del campo de texto 
	ifFormat   : "%d/%m/%Y",  //  
	button     : "BtnFechaVenta"// el id del botón que  
	});
var sprytextfield7 = new Spry.Widget.ValidationTextField("sprytextfield7", "date", {format:"dd/mm/yyyy"});
var sprytextfield = new Spry.Widget.ValidationTextField("sprytextfield", "date", {format:"dd/mm/yyyy"});
</script>
<?php
}else{
	echo ERR_GEN_101;
}

//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();
?>
