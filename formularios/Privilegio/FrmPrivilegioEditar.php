<?php

$GET_id = $_GET['Id'];
include('formularios/Privilegio/msj/MsjPrivilegio.php');

require_once('paquetes/PaqAcceso/Clases/ClsPrivilegio.php');
require_once('paquetes/PaqAcceso/Clases/ClsZona.php');
require_once('paquetes/PaqAcceso/Clases/ClsPrivilegio.php');

$InsPrivilegio = new ClsPrivilegio();
$InsZona = new ClsZona();
$InsPrivilegio = new ClsPrivilegio();

include('formularios/Privilegio/acc/AccPrivilegioEditar.php');

$ResZona = $InsZona->MtdObtenerZonas($POST_cam,$POST_fil,$POST_ord,$POST_sen,$POST_pag);
$ArrZonas = $ResZona['Datos'];

$ResPrivilegio = $InsPrivilegio->MtdObtenerPrivilegios($POST_cam,$POST_fil,$POST_ord,$POST_sen,$POST_pag);
$ArrPrivilegios = $ResPrivilegio['Datos'];

//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();

?>

<form id="FrmEditar" name="FrmEditar" method="post" action="#" enctype="multipart/form-data">
<div class="EstCapMenu">
<div class="EstSubMenuBoton">
<input name="BtnGuardar"   id="BtnGuardar" type="image" border="0" src="imagenes/acc_guardar.gif" alt="[Guardar]" title="Guardar" />
<div>Guardar</div>
</div>

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
        PRIVILEGIO</span></td>
      </tr>
      <tr>
        <td colspan="2">
       
        
        
             <div class="EstFormularioPrivilegio"></div>   
         <br />
         <div class="EstFormularioPrivilegio">
         
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
            <td><span id="sprytextfield2">
            <label>
            <input name="CmpId" type="text" class="EstFormularioCaja" id="CmpId" value="<?php echo $InsPrivilegio->PriId;?>" size="15" maxlength="20"  readonly="readonly"/>
            </label>
            <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Nombre:</td>
            <td><span id="sprytextfield1">
            <label>
            <input class="EstFormularioCaja" name="CmpNombre" type="text" id="CmpNombre" value="<?php echo $InsPrivilegio->PriNombre;?>" size="40" maxlength="250" />
            </label>
            <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
            <td>&nbsp;</td>
          </tr>

          <tr>
            <td>&nbsp;</td>
            <td>Alias:</td>
            <td><input class="EstFormularioCaja" name="CmpAlias" type="text" id="CmpAlias" value="<?php echo $InsPrivilegio->PriAlias;?>" size="40" maxlength="250" /></td>
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
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
//-->
</script>


