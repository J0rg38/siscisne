<?php
//CONTROL DE ACCESO
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsComprobanteRetencionTalonarioFunciones.js" ></script>


<?php
include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjComprobanteRetencionTalonario.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsComprobanteRetencionTalonario.php');

$InsComprobanteRetencionTalonario = new ClsComprobanteRetencionTalonario();

include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccComprobanteRetencionTalonarioRegistrar.php');



//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();
?>





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
	
</div>

<div class="EstCapContenido">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
  
      <tr>
        <td width="1922" height="25" colspan="2"><span class="EstFormularioTitulo">REGISTRAR
        TALONARIO DE COMPROBANTE DE RETENCION</span></td>
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
            <td><input  readonly="readonly" class="EstFormularioCajaDeshabilitada" name="CmpId" type="text" id="CmpId" value="<?php echo $InsComprobanteRetencionTalonario->CrtId;?>" size="15" maxlength="20" /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>N&uacute;mero:</td>
            <td><input  class="EstFormularioCaja" name="CmpNumero" type="text" id="CmpNumero" value="<?php echo $InsComprobanteRetencionTalonario->CrtNumero;?>" size="10" maxlength="5" /></td>
            <td>&nbsp;</td>
          </tr>
          
          <tr>
            <td>&nbsp;</td>
            <td>Inicio:</td>
            <td><input class="EstFormularioCaja" name="CmpInicio" type="text" id="CmpInicio" value="<?php echo $InsComprobanteRetencionTalonario->CrtInicio;?>" size="20" maxlength="20" /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Descripcion:</td>
            <td><input class="EstFormularioCaja" name="CmpDescripcion" type="text" id="CmpDescripcion" value="<?php echo $InsComprobanteRetencionTalonario->CrtDescripcion;?>" size="45" /></td>
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
<?php
}else{
	echo ERR_GEN_101;
}

//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();
?>
