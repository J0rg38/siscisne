<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>
<?php $PrivilegioEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar"))?true:false;?>



<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsProveedorComunicadoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsProveedorComunicadoFotoSoloFunciones.js" ></script>

<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssProveedorComunicado.css');
</style>

<?php
$GET_id = $_GET['Id'];

include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjProveedorComunicado.php');

require_once($InsPoo->MtdPaqLogistica().'ClsProveedorComunicado.php');
require_once($InsPoo->MtdPaqLogistica().'ClsTipoDocumento.php');

$InsProveedorComunicado = new ClsProveedorComunicado();
$InsTipoDocumento = new ClsTipoDocumento();

include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccProveedorComunicadoEditar.php');




$RepTipoDocumento = $InsTipoDocumento->MtdObtenerTipoDocumentos(NULL,NULL,'TdoNombre',"ASC",NULL);
$ArrTipoDocumentos = $RepTipoDocumento['Datos'];

?>

<script type="text/javascript">



$(document).ready(function (){
	
/*
CARGAS INICIALES
*/	

	
/*
AGREGANDO EVENTOS
*/

	FncProveedorComunicadoFotoSoloListar();
	
});

var ProveedorComunicadoFotoSoloEditar = 2;
var ProveedorComunicadoFotoSoloEliminar = 2;

</script>
<div class="EstCapMenu">
           	<?php
			if($PrivilegioEditar){
			?>           
             
             <div class="EstSubMenuBoton"><a href="principal<?php echo (!empty($GET_dia)?'2':'');?>.php?Mod=<?php echo $GET_mod;?>&Form=Editar<?php echo (!empty($GET_dia)?'&Dia=1':'');?>&Id=<?php echo $InsProveedorComunicado->PomId;?>"><img src="imagenes/iconos/editar.png" alt="[Editar]" title="Editar" />Editar</a></div>
             <?php
			}
			?>  
            
            
            

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
        <td width="961" height="25"><span class="EstFormularioTitulo">VER COMUNICADO</span></td>
      </tr>
      <tr>
        <td>
        
        
        
        <div class="EstFormularioArea">
         
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>Creado el:</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsProveedorComunicado->PomTiempoCreacion;?></span></td>
            <td>&nbsp;</td>
            <td>Modificado el</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsProveedorComunicado->PomTiempoModificacion;?></span></td>
          </tr>
        </table>
        
</div>
        
        
                                <br />



 		
<ul class="tabs">
    <li><a href="#tab1">Comunicado</a></li>

</ul>

<div class="tab_container">
    <div id="tab1" class="tab_content">
        <!--Content-->

    
         <table border="0" cellpadding="2" cellspacing="2">
           <tr>
             <td valign="top">
             <div class="EstFormularioArea" >
             <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>&nbsp;</td>
            <td colspan="4">
              <span class="EstFormularioSubTitulo">
                Datos del Comunicado			
                <input type="hidden" name="Identificador" id="Identificador"  value="<?php echo $Identificador; ?>" />
              </span></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Codigo Interno:</td>
            <td colspan="3" align="left" valign="top"><input name="CmpId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpId" value="<?php echo $InsProveedorComunicado->PomId;?>" size="20" maxlength="20" readonly="readonly" /></td>
            <td>&nbsp;</td>
            </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Proveedor:
              <input name="CmpProveedorId" type="hidden" id="CmpProveedorId" value="<?php echo $InsProveedorComunicado->PrvId;?>" size="3" /></td>
            <td colspan="3" align="left" valign="top"><table>
              <tr>
                <td><select <?php if(!empty($InsProveedorComunicado->PrvId)){ echo 'disabled="disabled"';} ?>  class="EstFormularioCombo" name="CmpProveedorTipoDocumento" id="CmpProveedorTipoDocumento">
                  <option value="">Escoja una opcion</option>
                  <?php
			foreach($ArrTipoDocumentos as $DatTipoDocumento){
			?>
                  <option <?php echo $DatTipoDocumento->TdoId;?> <?php echo ($DatTipoDocumento->TdoId==$InsProveedorComunicado->TdoId)?'selected="selected"':"";?> value="<?php echo $DatTipoDocumento->TdoId?>"><?php echo $DatTipoDocumento->TdoCodigo?> - <?php echo $DatTipoDocumento->TdoNombre?></option>
                  <?php
			}
			?>
                  </select></td>
                <td><a href="javascript:FncProveedorNuevo();"></a></td>
                <td><input <?php if(!empty($InsProveedorComunicado->PrvId)){ echo 'readonly="readonly"';} ?> name="CmpProveedorNumeroDocumento" type="text" class="EstFormularioCaja" id="CmpProveedorNumeroDocumento"  value="<?php echo $InsProveedorComunicado->PrvNumeroDocumento;?>" size="15" maxlength="50" /></td>
                <td><a href="javascript:FncProveedorBuscar('NumeroDocumento');"></a></td>
                <td><span id="sprytextfield5">
                  <label>
                    <input <?php if(!empty($InsProveedorComunicado->PrvId)){ echo 'readonly="readonly"';} ?> class="EstFormularioCaja" name="CmpProveedorNombre" type="text" id="CmpProveedorNombre" value="<?php echo $InsProveedorComunicado->PrvNombre?> <?php echo $InsProveedorComunicado->PrvApellidoPaterno;?> <?php echo $InsProveedorComunicado->PrvApellidoMaterno;?>" size="35" maxlength="255"  />
                    </label>
                  </span></td>
                <td>&nbsp;</td>
                </tr>
            </table></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Numeracion:</td>
            <td align="left" valign="top"><input  name="CmpCodigo" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpCodigo" value="<?php echo $InsProveedorComunicado->PomCodigo;?>" size="30" maxlength="45" readonly="readonly" /></td>
            <td align="left" valign="top">Fecha:<br />
              <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
            <td align="left" valign="top"><input name="CmpFecha" type="text" class="EstFormularioCajaFecha" id="CmpFecha" value="<?php  echo $InsProveedorComunicado->PomFecha; ?>" size="15" maxlength="10" readonly="readonly" /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Asunto:</td>
            <td colspan="3" align="left" valign="top"><input name="CmpAsunto" type="text" class="EstFormularioCaja" id="CmpAsunto" value="<?php echo $InsProveedorComunicado->PomAsunto;?>" size="45" maxlength="200" readonly="readonly"  /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Descripcion:</td>
            <td colspan="3" align="left" valign="top"><textarea name="CmpDescripcion" cols="45" readonly="readonly" class="EstFormularioCaja" id="CmpDescripcion"><?php echo $InsProveedorComunicado->PomDescripcion;?></textarea></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Archivo:</td>
            <td colspan="3" align="left" valign="top"><table border="0" cellpadding="0" cellspacing="0" class="EstFormulario">
              <tr>
                <td width="275" colspan="2" align="left" valign="top">
                  
                  <div id="fileUploadProveedorComunicadoFotoSolo2">Escoger Archivo</div>
                  
                  <script type="text/javascript">
									
									$(document).ready(function(){
						
											$("#fileUploadProveedorComunicadoFotoSolo").uploadFile({
												
											allowedTypes:"png,gif,jpg,jpeg,pdf",
											url:"formularios/ProveedorComunicado/acc/AccProveedorComunicadoSubirFotoSolo.php",
											formData: {"Identificador":"<?php echo $Identificador;?>"},
											multiple:true,
											autoSubmit:true,
											fileName:"Filedata",
											showStatusAfterSuccess:false,
											dragDropStr: "<span><b>Arrastre y suelte aqui los archivos.</b></span>",
											abortStr:"Abortar",
											cancelStr:"Cancelar",
											doneStr:"Hecho",
											multiDragErrorStr: "Arrastre y suelte aqui los archivos.",
											extErrorStr:"Extension de archivo no permitido",
											sizeErrorStr:"Tamaño no permitido",
											uploadErrorStr:"No se pudo subir el archivo",
											dragdropWidth: 500,
											
											onSuccess:function(files,data,xhr){
												FncProveedorComunicadoFotoSoloListar();
											}
							
										});
									});
									  
									</script>
                  
                  
                  
                  
                  </td>
                <td width="4" align="left" valign="top">&nbsp;</td>
                </tr>
              <tr>
                <td colspan="2" align="left" valign="top"><div class="EstCapProveedorComunicadoFotoSolos" id="CapProveedorComunicadoFotoSolos2"></div></td>
                <td align="left" valign="top">&nbsp;</td>
                </tr>
            </table></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td colspan="3" align="left" valign="top">&nbsp;</td>
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
        <td align="center">&nbsp;</td>
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
