<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsCalificacionFunciones.js" ></script>
<?php
//MENSAJES
include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjCalificacion.php');
//CLASES
require_once($InsPoo->MtdPaqLogistica().'ClsCalificacion.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsTipoCambio.php');
//CLASES
$InsCalificacion = new ClsCalificacion();
$InsMoneda = new ClsMoneda();
//ACCIONES
include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccCalificacionRegistrar.php');

$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","ASC",NULL);
$ArrMonedas = $ResMoneda['Datos'];

?>

<form id="FrmRegistrar" name="FrmRegistrar" method="post" action="#" enctype="multipart/form-data"  onsubmit="FncGuardar();">	

<div class="EstCapMenu">
<input name="BtnGuardar"   id="BtnGuardar" type="image" border="0" src="imagenes/acc_guardar.gif" alt="[Guardar]" title="Guardar" />

<?php
if(!empty($GET_dia)){
?>
	<div class="EstSubMenuBoton"><a href="javascript:self.parent.tb_remove('<?php echo $GET_mod;?>');" ><img src="imagenes/iconos/salir.png" alt="[Salir]" title="Salir" border="0"  />Salir</a></div>&nbsp;
<?php	
}
?>
	
</div>

<div class="EstCapContenido">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
  
      <tr>
        <td width="1922" height="25" colspan="2"><span class="EstFormularioTitulo">REGISTRAR
        CALIFICACION</span></td>
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
            <td align="left" valign="top">Codigo:</td>
            <td align="left" valign="top"><input name="CmpId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpId" value="<?php echo $InsCalificacion->CalId;?>" size="15" maxlength="20"  readonly="readonly"/></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Nombre:</td>
            <td align="left" valign="top"><span id="sprytextfield1">
              <label>
                <input  class="EstFormularioCaja" name="CmpNombre" type="text" id="CmpNombre" value="<?php echo $InsCalificacion->CalTipo;?>" size="5" maxlength="2" />
                </label>
              <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
            <td>&nbsp;</td>
          </tr>
          
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Moneda:</td>
            <td align="left" valign="top"><select class="EstFormularioCombo" name="CmpMonedaId" id="CmpMonedaId" disabled="disabled">
              <option value="">Escoja una opcion</option>
              <?php
			  foreach($ArrMonedas as $DatMoneda){
			  ?>
              <option value="<?php echo $DatMoneda->MonId?>" <?php if($InsCalificacion->MonId==$DatMoneda->MonId){ echo 'selected="selected"';}?> ><?php echo $DatMoneda->MonNombre?> ( <?php echo $DatMoneda->MonSimbolo;?>)</option>
              <?php
			  }
			  ?>
            </select></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Tipo de Cambio:<br />
              <span class="EstFormularioSubEtiqueta">(0.000)</span></td>
            <td align="left" valign="top"><input name="CmpTipoCambio" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpTipoCambio" onchange="FncBoletaDetalleListar();" value="<?php  echo $InsCalificacion->CalTipoCambio;  ?>" size="10" maxlength="10" readonly="readonly" /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Costo:</td>
            <td align="left" valign="top"><span id="sprytextfield4">
            <label for="CmpCosto"></label>
            <input class="EstFormularioCaja" name="CmpCosto" type="text" id="CmpCosto" value="<?php echo number_format($InsCalificacion->CalCosto,2);?>" size="10" maxlength="10" />
            <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Margen:</td>
            <td align="left" valign="top"><span id="sprytextfield2">
            <label for="CmpMargen"></label>
            <input class="EstFormularioCaja" name="CmpMargen" type="text" id="CmpMargen" value="<?php echo number_format($InsCalificacion->CalMargen,2);?>" size="10" maxlength="10" />
            <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Rango:</td>
            <td align="left" valign="top"><input  class="EstFormularioCaja" name="CmpRango" type="text" id="CmpRango" value="<?php echo $InsCalificacion->CalRango;?>" size="40" maxlength="45" /></td>
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
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none");
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
//-->
</script>
<?php
}else{
	echo ERR_GEN_101;
}

//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();
?>
