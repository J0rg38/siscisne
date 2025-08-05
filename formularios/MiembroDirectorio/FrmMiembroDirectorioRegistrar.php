<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsMiembroDirectorioFunciones.js" ></script>

<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssMiembroDirectorio.css');
</style>
<?php
if(!empty($_POST['Identificador'])){
	$Identificador = $_POST['Identificador'];
}
//MENSAJES
include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjMiembroDirectorio.php');
//CLASES
require_once($InsPoo->MtdPaqLogistica().'ClsMiembroDirectorio.php');
require_once($InsPoo->MtdPaqLogistica().'ClsTipoDocumento.php');
//INSTANCIAS
$InsMiembroDirectorio = new ClsMiembroDirectorio();
$InsTipoDocumento = new ClsTipoDocumento();
//ACCIONES
include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccMiembroDirectorioRegistrar.php');
//DATOS
$RepTipoDocumento = $InsTipoDocumento->MtdObtenerTipoDocumentos(NULL,NULL,"TdoNombre","ASC",NULL);
$ArrTipoDocumentos = $RepTipoDocumento['Datos'];

//ALERTAS
//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();
?>

<script type="text/javascript">
$().ready(function() {
});
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
	
  </div>
  <div class="EstCapContenido">
    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
      <tr>
        <td width="1922" height="25" colspan="2"><span class="EstFormularioTitulo">REGISTRAR
        MIEMBRO DEL DIRECTORIO</span></td>
      </tr>
      <tr>
        <td colspan="2">
		
		
		<ul class="tabs">
            <li><a href="#tab1">Miembro del Directorio</a></li>

          </ul>
          <div class="tab_container">
            <div id="tab1" class="tab_content"> 
              <!--Content-->
              
              <table border="0" cellpadding="2" cellspacing="2">
                <tr>
                  <td colspan="2" valign="top">
				  
				  <div class="EstFormularioArea">
                      <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                        <tr>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td><input type="hidden" name="Identificador" id="Identificador"  value="<?php echo $Identificador; ?>" /></td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>Nombre:</td>
                          <td><span id="sprytextfield1">
                            <label>
                              <input class="EstFormularioCaja" name="CmpNombre" type="text" id="CmpNombre" value="<?php echo $InsMiembroDirectorio->MdiNombre;?>" size="40" maxlength="250" />
                            </label>
                            <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
                          <td>&nbsp;</td>
                          <td align="left" valign="top">Foto:</td>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>Apellido Paterno:</td>
                          <td><span id="sprytextfield7">
                            <label>
                              <input class="EstFormularioCaja" name="CmpApellidoPaterno" type="text" id="CmpApellidoPaterno" value="<?php echo $InsMiembroDirectorio->MdiApellidoPaterno;?>" size="40" maxlength="250" />
                            </label>
                            <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
                          <td>&nbsp;</td>
                          <td rowspan="21" align="left" valign="top"><iframe src="formularios/MiembroDirectorio/acc/AccMiembroDirectorioSubirArchivo.php" id="IfrMiembroDirectorioSubirArchivo" name="IfrMiembroDirectorioSubirArchivo" scrolling="Auto"  frameborder="0" width="400" height="500"></iframe></td>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>Apellido Materno</td>
                          <td><span id="sprytextfield8">
                            <label>
                              <input class="EstFormularioCaja" name="CmpApellidoMaterno" type="text" id="CmpApellidoMaterno" value="<?php echo $InsMiembroDirectorio->MdiApellidoMaterno;?>" size="40" maxlength="250" />
                            </label>
                            <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>
                            <span id="spryselect1">
                           <select class="EstFormularioCombo" name="CmpTipoDocumento" id="CmpTipoDocumento">
                          <option value="">Escoja una opcion</option>
                              <?php
			foreach($ArrTipoDocumentos as $DatTipoDocumento ){
			?>
                              <option <?php echo ($InsMiembroDirectorio->TdoId == $DatTipoDocumento->TdoId)?'selected="selected"':'';?> value="<?php echo $DatTipoDocumento->TdoId; ?>"><?php echo $DatTipoDocumento->TdoCodigo; ?> - <?php echo $DatTipoDocumento->TdoNombre; ?></option>
                              <?php
			}			
			?>
                            </select>
                            <span class="selectRequiredMsg">Seleccione un elemento.</span></span>:</td>
                          <td><input value="<?php echo $InsMiembroDirectorio->MdiNumeroDocumento;?>"  class="EstFormularioCaja"  name="CmpNumeroDocumento" type="text" id="CmpNumeroDocumento" size="40" maxlength="50" /></td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>Cargo:</td>
                          <td>
						  
		<?php
			switch($InsMiembroDirectorio->MdiCargo){
				case 1:
					$OpcCargo1 = 'selected="selected"';
				break;
				
				case 2:
					$OpcCargo2 = 'selected="selected"';
				break;

			}
			?>
                            <select class="EstFormularioCombo" name="CmpCargo" id="CmpCargo">
                              <option <?php echo $OpcCargo1;?> value="1">Presidente</option>
                              <option <?php echo $OpcCargo2;?> value="2">Director</option>
                          </select></td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>Email:</td>
                          <td><span id="sprytextfield5">
                            <label>
                              <input class="EstFormularioCaja"   name="CmpEmail" type="text" id="CmpEmail" value="<?php echo $InsMiembroDirectorio->MdiEmail;?>" size="40" maxlength="255" />
                            </label>
                            <span class="textfieldInvalidFormatMsg"><img src="imagenes/advertencia.png" width="20" height="20" border="0" align="absmiddle" title="Formato no valido" alt="[A]"  /></span></span></td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>Tel&eacute;fono:</td>
                          <td><input value="<?php echo $InsMiembroDirectorio->MdiTelefono;?>"  class="EstFormularioCaja"  name="CmpTelefono" type="text" id="CmpTelefono" size="40" maxlength="50" /></td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>Celular:</td>
                          <td><input value="<?php echo $InsMiembroDirectorio->MdiCelular;?>"  class="EstFormularioCaja"  name="CmpCelular" type="text" id="CmpCelular" size="40" maxlength="50" /></td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>Direcci&oacute;n:</td>
                          <td><input value="<?php echo $InsMiembroDirectorio->MdiDireccion;?>"  class="EstFormularioCaja"  name="CmpDireccion" type="text" id="CmpDireccion" size="40" maxlength="255" /></td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>Estado:</td>
                          <td><?php
			switch($InsMiembroDirectorio->MdiEstado){
				case 1:
					$OpcEstado1 = 'selected="selected"';
				break;
				
				case 2:
					$OpcEstado2 = 'selected="selected"';
				break;

			}
			?>
                            <select class="EstFormularioCombo" name="CmpEstado" id="CmpEstado">
                              <option <?php echo $OpcEstado1;?> value="1">En Actividad</option>
                              <option <?php echo $OpcEstado2;?> value="2">Sin Actividad</option>
                            </select></td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
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
            </div>

           
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
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5", "email", {isRequired:false});
var sprytextfield7 = new Spry.Widget.ValidationTextField("sprytextfield7");
var sprytextfield8 = new Spry.Widget.ValidationTextField("sprytextfield8");
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1");
</script>
<?php
}else{
	echo ERR_GEN_101;
}

//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();
?>
