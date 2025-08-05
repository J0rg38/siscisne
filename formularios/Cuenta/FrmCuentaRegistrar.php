<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>
<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss('Cuenta');?>CssCuenta.css');
</style>

<?php
$Registro = false;

include($InsProyecto->MtdFormulariosMsj('Cuenta').'MsjCuenta.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsCuenta.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqLogistica().'ClsBanco.php');

$InsCuenta = new ClsCuenta();
$InsMoneda = new ClsMoneda();
$InsBanco = new ClsBanco();

include($InsProyecto->MtdFormulariosAcc('Cuenta').'AccCuentaRegistrar.php');

$ResBanco = $InsBanco->MtdObtenerBancos(NULL,NULL,"BanNombre","ASC",1,NULL);
$ArrBancos = $ResBanco['Datos'];

$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonNombre","ASC",NULL,NULL);
$ArrMonedas = $ResMoneda['Datos'];

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
        CUENTA</span></td>
      </tr>
      <tr>
        
        <td colspan="2">
        
         <table width="100%" border="0" cellpadding="2" cellspacing="2">
        <tr>
          <td>
            
            <div class="EstFormularioArea">
              
              <table border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td><input type="hidden" name="Guardar" id="Guardar"   />
                    <input type="hidden" name="Identificador" id="Identificador"  value="<?php echo $Identificador; ?>" /></td>
                  <td>&nbsp;</td>
                  </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">C&oacute;digo Interno:</td>
                  <td align="left" valign="top"><input name="CmpId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpId" value="<?php echo $InsCuenta->CueId;?>" size="15" maxlength="20" readonly="readonly" /></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Numero:</td>
                  <td align="left" valign="top">
                    <span id="sprytextfield1">
                      <label>
                        <input class="EstFormularioCaja" name="CmpNumero" type="text" id="CmpNumero" value="<?php echo $InsCuenta->CueNumero;?>" size="40" maxlength="45" />
                        </label>
                      <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">CCI:</td>
                  <td align="left" valign="top"><input class="EstFormularioCaja" name="CmpCCI" type="text" id="CmpCCI" value="<?php echo $InsCuenta->CueCCI;?>" size="40" maxlength="45" /></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Banco:</td>
                  <td align="left" valign="top"><span id="spryselect3">
                  <select class="EstFormularioCombo" name="CmpBanco" id="CmpBanco">
                    <option value="">Escoja una opcion</option>
                    <?php
			foreach($ArrBancos as $DatBanco){
			?>
                    <option value="<?php echo $DatBanco->BanId?>" <?php if($InsCuenta->BanId==$DatBanco->BanId){ echo 'selected="selected"';} ?> ><?php echo $DatBanco->BanNombre?></option>
                    <?php
			}
			?>
                  </select>
                  <span class="selectRequiredMsg">Debe escoger una opcion</span></span></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Moneda:</td>
                  <td align="left" valign="top"><span id="spryselect">
                    <select class="EstFormularioCombo" name="CmpMoneda" id="CmpMoneda">
                      <option value="">Escoja una opcion</option>
                      <?php
			foreach($ArrMonedas as $DatMoneda){
			?>
                      <option value="<?php echo $DatMoneda->MonId?>" <?php if($InsCuenta->MonId==$DatMoneda->MonId){ echo 'selected="selected"';} ?> ><?php echo $DatMoneda->MonNombre?> <?php echo $DatMoneda->MonSimbolo?></option>
                      <?php
			}
			?>
                      </select>
                    <span class="selectRequiredMsg">Debe escoger una opcion</span></span></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Descripcion:</td>
                  <td align="left" valign="top"><textarea class="EstFormularioCaja" name="CmpDescripcion" id="CmpDescripcion" cols="45" rows="4"><?php echo addslashes($InsCuenta->CueObservacion);?></textarea></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Estado:</td>
                  <td align="left" valign="top">
                    <?php
			switch($InsCuenta->CueEstado){
				case 1:
					$OpcEstado1 = 'selected="selected"';
				break;
				
				case 2:
					$OpcEstado2 = 'selected="selected"';
				break;

			}
			?>
                    
                    <select class="EstFormularioCombo" name="CmpEstado" id="CmpEstado">
                      <option <?php echo $OpcEstado1;?> value="1">En actividad</option>
                      <option <?php echo $OpcEstado2;?> value="2">Sin actividad</option>
                      </select></td>
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
        </table>
        
        
        </td>
      </tr>
      
      <tr>
        <td colspan="2" align="center">&nbsp;</td>
        </tr>
    </table>
</div>
	

	
    

</form>


     
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var spryselect3 = new Spry.Widget.ValidationSelect("spryselect3");
var spryselect = new Spry.Widget.ValidationSelect("spryselect");
</script>
<?php
}else{
	echo ERR_GEN_101;
}

//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();
if(empty($GET_dia)){
	
	if(!$_SESSION['MysqlDeb']){
		$InsMensaje->MtdRedireccionar("principal.php?Mod=".$GET_mod."&Form=Listado",$Registro,1500);
	}
	
}


?>

