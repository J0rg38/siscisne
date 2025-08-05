<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>

<?php
//VARIABLES
$GET_id = $_GET['Id'];
$Edito = false;
//MENSAJES
include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjBanco.php');
//CLASES
require_once($InsPoo->MtdPaqLogistica().'ClsBanco.php');
//INSTANCIAS
$InsBanco = new ClsBanco();
//ACCIONES
include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccBancoEditar.php');

?>



<form id="FrmEditar" name="FrmEditar" method="post" action="#" enctype="multipart/form-data">
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
        <td width="1922" height="25" colspan="2"><span class="EstFormularioTitulo">EDITAR
        BANCO</span></td>
      </tr>
      <tr>
        <td colspan="2">
       
        
        
             <div class="EstFormularioArea">
         
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>Creado el:</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsBanco->BanTiempoCreacion;?></span></td>
            <td>Modificado el</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsBanco->BanTiempoModificacion;?></span></td>
          </tr>
        </table>
        
        </div>   
         <br />
         <div class="EstFormularioArea">
         
        <table class="EstFormulario" width="200" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>C&oacute;digo:</td>
            <td><input name="CmpId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpId" value="<?php echo $InsBanco->BanId;?>" size="15" maxlength="20"  readonly="readonly"/></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Nombre:</td>
            <td><span id="sprytextfield1">
            <label>
            <input class="EstFormularioCaja" name="CmpNombre" type="text" id="CmpNombre" value="<?php echo $InsBanco->BanNombre;?>" size="40" maxlength="250" />
            </label>
            <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
            <td>&nbsp;</td>
          </tr>

          <tr>
            <td>&nbsp;</td>
            <td valign="top">Descripcion:</td>
            <td><span id="sprytextarea1">
            <textarea class="EstFormularioCaja" name="CmpDescripcion" id="CmpDescripcion" cols="45" rows="5"><?php echo addslashes($InsBanco->BanDescripcion);?></textarea>
            <span class="textareaMaxCharsMsg">Se ha superado el número máximo de caracteres.</span></span></td>
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
var sprytextarea1 = new Spry.Widget.ValidationTextarea("sprytextarea1", {maxChars:500, isRequired:false});
//-->
</script>
<?php
}else{
	echo ERR_GEN_101;
}


if(empty($GET_dia)){
	
	if(!$_SESSION['MysqlDeb']){
		$InsMensaje->MtdRedireccionar("principal.php?Mod=".$GET_mod."&Form=Listado",$Edito,1500);
	}
		
}

?>

