<?php
//CONTROL DE ACCESO
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>

<?php
include($InsProyecto->MtdFormulariosMsj("NotaDebitoTalonario").'MsjNotaDebitoTalonario.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsNotaDebitoTalonario.php');

$InsNotaDebitoTalonario = new ClsNotaDebitoTalonario();

include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccNotaDebitoTalonarioRegistrar.php');

$InsMensaje->MenResultado = $Resultado;
$InsMensaje->MtdImprimirResultado();
?>


<script type="text/javascript">
/*
//Desactivando tecla ENTER
*/

/*
//Configuracion carga de datos y animacion
*/
$(document).ready(function (){

	$('#CmpNumero').focus();

});

/*
Configuracion Formulario
*/
</script>


<form id="FrmRegistrar" name="FrmRegistrar" method="post" action="#" enctype="multipart/form-data">


<div class="EstCapMenu">
<div class="EstSubMenuBoton">
<input name="BtnGuardar"   id="BtnGuardar" type="image" border="0" src="imagenes/acc_guardar.gif" alt="[Guardar]" title="Guardar" />
<div>Guardar</div>
</div>
</div>

<div class="EstCapContenido">


<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
  
      <tr>
        <td width="1922" height="25" colspan="2"><span class="EstFormularioTitulo">REGISTRAR
        TALONARIO DE NOTA DE CREDITO</span></td>
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
            <td>C&oacute;digo Interno:</td>
            <td><input  readonly="readonly" class="EstFormularioCajaDeshabilitada" name="CmpId" type="text" id="CmpId" value="<?php echo $InsNotaDebitoTalonario->NdtId;?>" size="15" maxlength="20" /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>N&uacute;mero:</td>
            <td><span id="sprytextfield1">
            <label>
            <input  class="EstFormularioCaja" name="CmpNumero" type="text" id="CmpNumero" value="<?php echo $InsNotaDebitoTalonario->NdtNumero;?>" size="10" maxlength="5" />
            </label>
            <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
            <td>&nbsp;</td>
          </tr>
          
          <tr>
            <td>&nbsp;</td>
            <td>Inicio:</td>
            <td><span id="sprytextfield2">
            <label>
              <input  class="EstFormularioCaja" name="CmpInicio" type="text" id="CmpInicio" value="<?php echo $InsNotaDebitoTalonario->NdtInicio;?>" size="20" maxlength="20" />
            </label>
            <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
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
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "none");
//-->
</script>

<?php
}else{
echo ERR_GEN_101;
}
?>
