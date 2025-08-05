<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsSocioSistemaPensionFunciones.js" ></script>

<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssSocio.css');
</style>
<?php $PrivilegioEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar"))?true:false;?>
<?php
//VARIABLES
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
<div class="EstCapMenu">
           	<?php
			if($PrivilegioEditar){
			?>           
             
             <div class="EstSubMenuBoton"><a href="principal<?php echo (!empty($GET_dia)?'2':'');?>.php?Mod=<?php echo $GET_mod;?>&Form=Editar<?php echo (!empty($GET_dia)?'&Dia=1':'');?>&Id=<?php echo $InsSocio->SocId;?>"><img src="imagenes/iconos/editar.png" alt="[Editar]" title="Editar" />Editar</a></div>
             <?php
			}
			?>  
</div>

<div class="EstCapContenido">


<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
      
      <tr>
        <td width="1922" height="25" colspan="2"><span class="EstFormularioTitulo">VER
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
            <td>&nbsp;</td>
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
            <td><input value="<?php echo $InsSocio->SocNombre;?>"  class="EstFormularioCaja"  name="CmpNombre" type="text" id="CmpNombre" size="40" maxlength="255" readonly="readonly" /></td>
            <td>&nbsp;</td>
            <td rowspan="9" align="left" valign="top">
              <?php            
if(!empty($_SESSION['SesSocFoto'])){
	
	$extension = strtolower(pathinfo($_SESSION['SesSocFoto'], PATHINFO_EXTENSION));
	$nombre_base = basename($_SESSION['SesSocFoto'], '.'.$extension);  
?>
              
              Vista Previa:<br />
              <img  src="subidos/socio_fotos/<?php echo $nombre_base."_thumb.".$extension;?>" title="<?php echo $nombre_base."_thumb.".$extension;?>" />
              
              
              <?php	
}else{
?>
              No hay FOTO
              <?php	
}
?>
              
              
            </td>
            <td>&nbsp;</td>
          </tr>
          
          <tr>
            <td>&nbsp;</td>
            <td>Apellido Paterno:</td>
            <td><input value="<?php echo $InsSocio->SocApellidoPaterno;?>"  class="EstFormularioCaja"  name="CmpApellidoPaterno" type="text" id="CmpApellidoPaterno" size="40" maxlength="255" readonly="readonly" /></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Apellido Materno:</td>
            <td><input value="<?php echo $InsSocio->SocApellidoMaterno;?>"  class="EstFormularioCaja"  name="CmpApellidoMaterno" type="text" id="CmpApellidoMaterno" size="40" maxlength="255" readonly="readonly" /></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><select class="EstFormularioCombo" name="CmpTipoDocumento" id="CmpTipoDocumento" disabled="disabled">
							<?php
                            foreach($ArrTipoDocumentos as $DatTipoDocumento ){
                            ?>
                                              <option <?php echo ($InsSocio->TdoId==$DatTipoDocumento->TdoId)?'selected="selected"':'';?> value="<?php echo $DatTipoDocumento->TdoId; ?>"><?php echo $DatTipoDocumento->TdoCodigo; ?> - <?php echo $DatTipoDocumento->TdoNombre; ?></option>
							<?php
                            }			
                            ?>
                            </select>
              :</td>
            <td><input value="<?php echo $InsSocio->SocNumeroDocumento;?>"  class="EstFormularioCaja"  name="CmpNumeroDocumento" type="text" id="CmpNumeroDocumento" size="40" maxlength="50" readonly="readonly" /></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Email:</td>
            <td><input value="<?php echo $InsSocio->SocEmail;?>"  class="EstFormularioCaja"  name="CmpEmail" type="text" id="CmpEmail" size="40" maxlength="255" readonly="readonly" /></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Tel&eacute;fono:</td>
            <td><input value="<?php echo $InsSocio->SocTelefono;?>"  class="EstFormularioCaja"  name="CmpTelefono" type="text" id="CmpTelefono" size="40" maxlength="50" readonly="readonly" /></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Celular:</td>
            <td><input value="<?php echo $InsSocio->SocCelular;?>"  class="EstFormularioCaja"  name="CmpCelular" type="text" id="CmpCelular" size="40" maxlength="50" readonly="readonly" /></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Direcci&oacute;n:</td>
            <td><input value="<?php echo $InsSocio->SocDireccion;?>"  class="EstFormularioCaja"  name="CmpDireccion" type="text" id="CmpDireccion" size="40" maxlength="255" readonly="readonly" /></td>
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
              
              <select class="EstFormularioCombo" name="CmpEstado" id="CmpEstado" disabled="disabled">
                <option <?php echo $OpcEstado1;?> value="1">En Actividad</option>
                <option <?php echo $OpcEstado2;?> value="2">De Baja</option>
                </select>            </td>
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

	
	
	
    


<?php
}else{
	echo ERR_GEN_101;
}


//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();

?>

