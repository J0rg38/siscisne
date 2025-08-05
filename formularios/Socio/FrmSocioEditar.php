<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsSocioFunciones.js" ></script>         
    
<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssSocio.css');
</style>
<?php
//VARIABLES
if(!empty($_POST['Identificador'])){
	$Identificador = $_POST['Identificador'];
}

$GET_id = $_GET['Id'];
//MENSAJES
include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjSocio.php');
//CLASES
require_once($InsPoo->MtdPaqLogistica().'ClsSocio.php');

require_once($InsPoo->MtdPaqLogistica().'ClsTipoDocumento.php');
//INSTANCIAS
$InsSocio = new ClsSocio();

$InsTipoDocumento = new ClsTipoDocumento();
//ACCIONES
include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccSocioEditar.php');
//DATOS

$RepTipoDocumento = $InsTipoDocumento->MtdObtenerTipoDocumentos(NULL,NULL,"TdoId","ASC",NULL);
$ArrTipoDocumentos = $RepTipoDocumento['Datos'];

//ALERTAS
//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();
?>
<script type="text/javascript">
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
        SOCIO</span></td>
      </tr>
      <tr>
        <td colspan="2">
      
        <div class="EstFormularioArea">
         
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>Creado el:</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsSocio->SocTiempoCreacion;?></span></td>
            <td>&nbsp;</td>
            <td>Modificado el</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsSocio->SocTiempoModificacion;?></span></td>
          </tr>
        </table>
        
        </div>  
          <br />
        
 		<ul class="tabs">
            <li><a href="#tab1">Socio</a></li>

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
            <td><input type="hidden" name="Identificador" id="Identificador"  value="<?php echo $Identificador; ?>" /></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>C&oacute;digo:</td>
            <td><input name="CmpId" type="text" class="EstFormularioCaja" id="CmpId" value="<?php echo $InsSocio->SocId;?>" size="15" maxlength="20" readonly="readonly" /></td>
            <td>&nbsp;</td>
            <td>Foto:</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Nombre:</td>
            <td>
              <span id="sprytextfield1">
                <label>
                  <input class="EstFormularioCaja" name="CmpNombre" type="text" id="CmpNombre" value="<?php echo $InsSocio->SocNombre;?>" size="40" maxlength="250" />
                  </label>
                <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
            <td>&nbsp;</td>
            <td rowspan="19" valign="top"><iframe src="formularios/Socio/acc/AccSocioSubirArchivo.php" id="IfrSocioSubirArchivo" name="IfrSocioSubirArchivo" scrolling="Auto"  frameborder="0" width="400" height="500"></iframe></td>
            <td>&nbsp;</td>
          </tr>
          
          <tr>
            <td>&nbsp;</td>
            <td>Apellido Paterno:</td>
            <td>
              <span id="sprytextfield7">
              <label>
              <input class="EstFormularioCaja" name="CmpApellidoPaterno" type="text" id="CmpApellidoPaterno" value="<?php echo $InsSocio->SocApellidoPaterno;?>" size="40" maxlength="250" />
              </label>
              <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Apellido Materno:</td>
            <td><span id="sprytextfield8">
              <label>
                <input class="EstFormularioCaja" name="CmpApellidoMaterno" type="text" id="CmpApellidoMaterno" value="<?php echo $InsSocio->SocApellidoMaterno;?>" size="40" maxlength="250" />
                </label>
              <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><select class="EstFormularioCombo" name="CmpTipoDocumento" id="CmpTipoDocumento">
							<?php
                            foreach($ArrTipoDocumentos as $DatTipoDocumento ){
                            ?>
                                              <option <?php echo ($InsSocio->TdoId==$DatTipoDocumento->TdoId)?'selected="selected"':'';?> value="<?php echo $DatTipoDocumento->TdoId; ?>"><?php echo $DatTipoDocumento->TdoCodigo; ?> - <?php echo $DatTipoDocumento->TdoNombre; ?></option>
							<?php
                            }			
                            ?>
                            </select>
              :</td>
            <td><input value="<?php echo $InsSocio->SocNumeroDocumento;?>"  class="EstFormularioCaja"  name="CmpNumeroDocumento" type="text" id="CmpNumeroDocumento" size="40" maxlength="50" /></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Email:</td>
            <td>
              <span id="sprytextfield5">
              <label>
              <input class="EstFormularioCaja"   name="CmpEmail" type="text" id="CmpEmail" value="<?php echo $InsSocio->SocEmail;?>" size="40" maxlength="255" />
              </label>
              <span class="textfieldInvalidFormatMsg"><img src="imagenes/advertencia.png" width="20" height="20" border="0" align="absmiddle" title="Formato no valido" alt="[A]"  /></span></span></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Tel&eacute;fono:</td>
            <td><input value="<?php echo $InsSocio->SocTelefono;?>"  class="EstFormularioCaja"  name="CmpTelefono" type="text" id="CmpTelefono" size="40" maxlength="50" /></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Celular:</td>
            <td><input value="<?php echo $InsSocio->SocCelular;?>"  class="EstFormularioCaja"  name="CmpCelular" type="text" id="CmpCelular" size="40" maxlength="50" /></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Direcci&oacute;n:</td>
            <td><input value="<?php echo $InsSocio->SocDireccion;?>"  class="EstFormularioCaja"  name="CmpDireccion" type="text" id="CmpDireccion" size="40" maxlength="255" /></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Estado:</td>
            <td>
              <?php
			switch($InsSocio->SocEstado){
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
                <option <?php echo $OpcEstado2;?> value="2">De Baja</option>
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
</script>
<?php
}else{
	echo ERR_GEN_101;
}


//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();

?>

