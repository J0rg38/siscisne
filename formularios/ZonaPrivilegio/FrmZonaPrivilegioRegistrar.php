<?php

include($InsProyecto->MtdFormulariosMsj("ZonaPrivilegio").'MsjZonaPrivilegio.php');


require_once($InsPoo->MtdPaqAcceso().'ClsZonaPrivilegio.php');
require_once($InsPoo->MtdPaqAcceso().'ClsZona.php');
require_once($InsPoo->MtdPaqAcceso().'ClsPrivilegio.php');

$InsZonaPrivilegio = new ClsZonaPrivilegio();
$InsZona = new ClsZona();
$InsPrivilegio = new ClsPrivilegio();

include($InsProyecto->MtdRutFormularios().'ZonaPrivilegio/acc/AccZonaPrivilegioRegistrar.php');

$ResZona = $InsZona->MtdObtenerZonas($POST_cam,$POST_fil,"ZonNombre","ASC",$POST_pag);
$ArrZonas = $ResZona['Datos'];

$ResPrivilegio = $InsPrivilegio->MtdObtenerPrivilegios($POST_cam,$POST_fil,"PriNombre","ASC",$POST_pag);
$ArrPrivilegios = $ResPrivilegio['Datos'];

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
        ZONA PRIVILEGIO</span></td>
      </tr>
      <tr>
        <td colspan="2">
        
        
        <div class="EstFormularioZonaPrivilegio">
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Zona:</td>
            <td>
            <select name="CmpZona" id="CmpZona" class="EstFormularioCaja">
            <?php
			foreach($ArrZonas as $DatZona){
			?>
			<option <?php if($InsZonaPrivilegio->ZonId==$DatZona->ZonId){ echo 'selected="selected"';}?> value="<?php echo $DatZona->ZonId;?>"><?php echo $DatZona->ZonNombre;?></option>
			<?php
			}
			?>
            </select>
            
            </td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Privilegio;</td>
            <td>
            
            <select name="CmpPrivilegio" id="CmpPrivilegio" class="EstFormularioCaja">
            <?php
			foreach($ArrPrivilegios as $DatPrivilegio){
			?>
			<option <?php if($InsZonaPrivilegio->PriId==$DatPrivilegio->PriId){ echo 'selected="selected"';}?> value="<?php echo $DatPrivilegio->PriId;?>"><?php echo $DatPrivilegio->PriNombre;?></option>
			<?php
			}
			?>
            </select>
            </td>
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
