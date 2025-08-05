<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsZonaPrivilegioFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsZonaPrivilegioAjax.js" ></script>

<?php
//VARIABLES
$GET_id = $_GET['Id'];

if(!empty($_POST['Identificador'])){
	$Identificador = $_POST['Identificador'];
}
//MENSAJES
include($InsProyecto->MtdFormulariosMsj("Zona").'MsjZona.php');
//CLASES
require_once($InsPoo->MtdPaqAcceso().'ClsZona.php');
require_once($InsPoo->MtdPaqAcceso().'ClsZonaPrivilegio.php');
require_once($InsPoo->MtdPaqAcceso().'ClsPrivilegio.php');
//INSTANCIAS
$InsZona = new ClsZona();
$InsPrivilegio = new ClsPrivilegio();

if (isset($_SESSION['InsZonaPrivilegio'.$Identificador])){	
	$_SESSION['InsZonaPrivilegio'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsZonaPrivilegio'.$Identificador]);
}
//DATOS
$ResPrivilegio = $InsPrivilegio->MtdObtenerPrivilegios(NULL,NULL,"PriNombre","ASC",NULL);
$ArrPrivilegios = $ResPrivilegio['Datos'];
//ACCIONES
include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccZonaEditar.php');

//ALERTAS
//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();
?>

<script type="text/javascript">
/*
Desactivando tecla ENTER
*/
FncDesactivarEnter();

$().ready(function() {
	
});
</script>

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
        ZONA</span></td>
      </tr>
      <tr>
        <td colspan="2">
       
        
        
             <div class="EstFormularioZona"></div>   
         <br />
         <div class="EstFormularioZona">
         
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
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
            <input name="CmpId" type="text" class="EstFormularioCaja" id="CmpId" value="<?php echo $InsZona->ZonId;?>" size="15" maxlength="20"  readonly="readonly"/>
            </label>
            <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Nombre:</td>
            <td><span id="sprytextfield1">
            <label>
            <input class="EstFormularioCaja" name="CmpNombre" type="text" id="CmpNombre" value="<?php echo $InsZona->ZonNombre;?>" size="40" maxlength="250" />
            </label>
            <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
            <td>&nbsp;</td>
          </tr>

          <tr>
            <td>&nbsp;</td>
            <td>Alias:</td>
            <td><input class="EstFormularioCaja" name="CmpAlias" type="text" id="CmpAlias" value="<?php echo $InsZona->ZonAlias;?>" size="40" maxlength="250" /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Privilegios:</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="2"><table width="100%" border="1">
			<?php
			$i = 1;
			foreach($ArrPrivilegios as $DatPrivilegio){
			?>
              <?php
			  	if(is_array($InsZona->ZonaPrivilegio)){	
					foreach($InsZona->ZonaPrivilegio as $DatZonaPrivilegio ){
						$aux = '';
						$ZprId = "";
						if($DatZonaPrivilegio->PriId==$DatPrivilegio->PriId){
							$aux = 'checked="checked"';						
							$ZprId = $DatZonaPrivilegio->ZprId;
							break;
						}					
						
					}
				}				
				?>
              <tr>
                <td><?php echo $i;?></td>
                <td><?php echo $DatPrivilegio->PriNombre?> <!--[<?php echo $DatPrivilegio->PriId;?>]--></td>
                <td>
				<input  <?php echo $aux;?> type="checkbox" name="CmpPrivilegioId_<?php echo $DatPrivilegio->PriId;?>" id="CmpPrivilegioId_<?php echo $DatPrivilegio->PriId;?>" value="<?php echo $DatPrivilegio->PriId;?>" />
				<input type="hidden" name="CmpZonaPrivilegioId_<?php echo $DatPrivilegio->PriId;?>" id="CmpZonaPrivilegioId_<?php echo $DatPrivilegio->PriId;?>" value="<?php echo $ZprId;?>" /></td>
              </tr>
              <?php
			  $i++;
			}
			?>
            </table></td>
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


