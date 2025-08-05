<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsMiembroDirectorioFunciones.js" ></script>

<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssMiembroDirectorio.css');
</style>
<?php $PrivilegioEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar"))?true:false;?>
<?php
//VARIABLES
$GET_id = $_GET['Id'];
//MENSAJES
include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjMiembroDirectorio.php');
//CLASES
require_once($InsPoo->MtdPaqLogistica().'ClsMiembroDirectorio.php');
require_once($InsPoo->MtdPaqLogistica().'ClsTipoDocumento.php');
//INSTANCIAS
$InsMiembroDirectorio = new ClsMiembroDirectorio();

$InsTipoDocumento = new ClsTipoDocumento();
//ACCIONES
include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccMiembroDirectorioEditar.php');
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
             
             <div class="EstSubMenuBoton"><a href="principal<?php echo (!empty($GET_dia)?'2':'');?>.php?Mod=<?php echo $GET_mod;?>&Form=Editar<?php echo (!empty($GET_dia)?'&Dia=1':'');?>&Id=<?php echo $InsMiembroDirectorio->MdiId;?>"><img src="imagenes/iconos/editar.png" alt="[Editar]" title="Editar" />Editar</a></div>
             <?php
			}
			?>  
</div>

<div class="EstCapContenido">


<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
      
      <tr>
        <td width="1922" height="25" colspan="2"><span class="EstFormularioTitulo">VER
        MIEMBRO DEL DIRECTORIO</span></td>
      </tr>
      <tr>
        <td colspan="2">
      
        
        <div class="EstFormularioArea">
         
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>Creado el:</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsMiembroDirectorio->MdiTiempoCreacion;?></span></td>
            <td>&nbsp;</td>
            <td>Modificado el</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsMiembroDirectorio->MdiTiempoModificacion;?></span></td>
          </tr>
        </table>
        
        </div>  
          <br />
 
 
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
            <td>C&oacute;digo:</td>
            <td><input name="CmpId" type="text" class="EstFormularioCaja" id="CmpId" value="<?php echo $InsMiembroDirectorio->MdiId;?>" size="15" maxlength="20" readonly="readonly" /></td>
            <td>&nbsp;</td>
            <td>Foto:</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Nombre:</td>
            <td><input value="<?php echo $InsMiembroDirectorio->MdiNombre;?>"  class="EstFormularioCaja"  name="CmpNombre" type="text" id="CmpNombre" size="40" maxlength="255" readonly="readonly" /></td>
            <td>&nbsp;</td>
            <td rowspan="10" align="left" valign="top">
              <?php            
if(!empty($_SESSION['SesMdiFoto'])){
	
	$extension = strtolower(pathinfo($_SESSION['SesMdiFoto'], PATHINFO_EXTENSION));
	$nombre_base = basename($_SESSION['SesMdiFoto'], '.'.$extension);  
?>
              
              Vista Previa:<br />
              <img  src="subidos/miembro_directorio_fotos/<?php echo $nombre_base."_thumb.".$extension;?>" title="<?php echo $nombre_base."_thumb.".$extension;?>" />
              
              
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
            <td><input value="<?php echo $InsMiembroDirectorio->MdiApellidoPaterno;?>"  class="EstFormularioCaja"  name="CmpApellidoPaterno" type="text" id="CmpApellidoPaterno" size="40" maxlength="255" readonly="readonly" /></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Apellido Materno:</td>
            <td><input value="<?php echo $InsMiembroDirectorio->MdiApellidoMaterno;?>"  class="EstFormularioCaja"  name="CmpApellidoMaterno" type="text" id="CmpApellidoMaterno" size="40" maxlength="255" readonly="readonly" /></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><select class="EstFormularioCombo" name="CmpTipoDocumento" id="CmpTipoDocumento" disabled="disabled">
              <option value="">Escoja una opcion</option>
              <?php
			foreach($ArrTipoDocumentos as $DatTipoDocumento ){
			?>
              <option <?php echo ($InsMiembroDirectorio->TdoId == $DatTipoDocumento->TdoId)?'selected="selected"':'';?> value="<?php echo $DatTipoDocumento->TdoId; ?>"><?php echo $DatTipoDocumento->TdoCodigo; ?> - <?php echo $DatTipoDocumento->TdoNombre; ?></option>
              <?php
			}			
			?>
            </select>              
              :</td>
            <td><input value="<?php echo $InsMiembroDirectorio->MdiNumeroDocumento;?>"  class="EstFormularioCaja"  name="CmpNumeroDocumento" type="text" id="CmpNumeroDocumento" size="40" maxlength="50" readonly="readonly" /></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Cargo:</td>
            <td><?php
			switch($InsMiembroDirectorio->MdiCargo){
				case 1:
					$OpcCargo1 = 'selected="selected"';
				break;
				
				case 2:
					$OpcCargo2 = 'selected="selected"';
				break;

			}
			?>
              <select class="EstFormularioCombo" name="CmpCargo" id="CmpCargo" disabled="disabled">
                <option <?php echo $OpcCargo1;?> value="1">Presidente</option>
                <option <?php echo $OpcCargo2;?> value="2">Director</option>
              </select></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Email:</td>
            <td><input value="<?php echo $InsMiembroDirectorio->MdiEmail;?>"  class="EstFormularioCaja"  name="CmpEmail" type="text" id="CmpEmail" size="40" maxlength="255" readonly="readonly" /></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Tel&eacute;fono:</td>
            <td><input value="<?php echo $InsMiembroDirectorio->MdiTelefono;?>"  class="EstFormularioCaja"  name="CmpTelefono" type="text" id="CmpTelefono" size="40" maxlength="50" readonly="readonly" /></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Celular:</td>
            <td><input value="<?php echo $InsMiembroDirectorio->MdiCelular;?>"  class="EstFormularioCaja"  name="CmpCelular" type="text" id="CmpCelular" size="40" maxlength="50" readonly="readonly" /></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Direcci&oacute;n:</td>
            <td><input value="<?php echo $InsMiembroDirectorio->MdiDireccion;?>"  class="EstFormularioCaja"  name="CmpDireccion" type="text" id="CmpDireccion" size="40" maxlength="255" readonly="readonly" /></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Estado:</td>
            <td>
              
              <?php
			switch($InsMiembroDirectorio->MdiEstado){
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
                <option <?php echo $OpcEstado2;?> value="2">Sin Actividad</option>
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

