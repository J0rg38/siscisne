<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>

<?php $PrivilegioVistaPreliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"VistaPreliminar"))?true:false;?>
<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Imprimir"))?true:false;?>
<?php $PrivilegioEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar"))?true:false;?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsOrdenCodificacionFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsOrdenCodificacionFotoFunciones.js" ></script>

<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssOrdenCodificacion.css');
</style>

<?php
$GET_id = $_GET['Id'];

include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjOrdenCodificacion.php');

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCodificacion.php');
require_once($InsPoo->MtdPaqLogistica().'ClsTipoDocumento.php');
require_once($InsPoo->MtdPaqRRHH().'ClsPersonal.php');

$InsOrdenCodificacion = new ClsOrdenCodificacion();
$InsTipoDocumento = new ClsTipoDocumento();
$InsPersonal = new ClsPersonal();

include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccOrdenCodificacionEditar.php');

$RepTipoDocumento = $InsTipoDocumento->MtdObtenerTipoDocumentos(NULL,NULL,'TdoNombre',"ASC",NULL);
$ArrTipoDocumentos = $RepTipoDocumento['Datos'];


$ResPersonal = $InsPersonal->MtdObtenerPersonales(NULL,NULL,NULL,"PerNombre","ASC",NULL,NULL,1,NULL,NULL,NULL,1);
$ArrPersonales = $ResPersonal['Datos'];

?>

<script type="text/javascript">
/*
Configuracion carga de datos y animacion
*/

$(document).ready(function (){
	
	FncOrdenCodificacionFotoListar();
		
});

var OrdenCodificacionFotoEditar = 2;
var OrdenCodificacionFotoEliminar = 2;


</script>

<div class="EstCapMenu">
  
  
  	<?php
    if($PrivilegioVistaPreliminar){
    ?>
    <div class="EstSubMenuBoton"><a href="javascript:FncVistaPreliminar('<?php echo $InsOrdenCodificacion->OciId;?>');"><img src="imagenes/iconos/preliminar.png" alt="[Vista Preliminar]" title="Vista preliminar" />V.P.</a></div>
    <?php
    }
    ?>
	<?php
    if($PrivilegioImprimir){
    ?>
    <div class="EstSubMenuBoton"><a href="javascript:FncImprmir('<?php echo $InsOrdenCodificacion->OciId;?>');"><img src="imagenes/iconos/imprimir.png" alt="[Imprimir]" title="Imprimir"  />Imprimir</a></div>
    <?php
    }
    ?>
    
             
          	<?php
			if($PrivilegioEditar){
			?>           
             
             <div class="EstSubMenuBoton"><a href="principal<?php echo (!empty($GET_dia)?'2':'');?>.php?Mod=<?php echo $GET_mod;?>&Form=Editar<?php echo (!empty($GET_dia)?'&Dia=1':'');?>&Id=<?php echo $InsOrdenCodificacion->OciId;?>&Su=<?php echo $InsOrdenCodificacion->SucId;?>"><img src="imagenes/iconos/editar.png" alt="[Editar]" title="Editar" />Editar</a></div>
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
        <td width="1922" height="25" colspan="2"><span class="EstFormularioTitulo">VER  CONSULTA TECNICA PN</span></td>
      </tr>
      <tr>
        <td colspan="2">
 
 
                <div class="EstFormularioArea">
         
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>Creado el:</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsOrdenCodificacion->OciTiempoCreacion;?></span></td>
            <td>&nbsp;</td>
            <td>Modificado el</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsOrdenCodificacion->OciTiempoModificacion;?></span></td>
          </tr>
        </table>
        
        </div>  
        
       
        
   
        <br />
       
        
        
               
<ul class="tabs">
	<li><a href="#tab1"> Consulta Tecnica PN</a></li>

</ul>        

<div class="tab_container">

    <div id="tab1" class="tab_content">
        <!--Content-->     
		             <table width="100%" border="0" cellpadding="2" cellspacing="2">
       
       <tr>
         <td valign="top"><div class="EstFormularioArea">
           <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
             <tr>
               <td>&nbsp;</td>
               <td colspan="4"><span class="EstFormularioSubTitulo">Datos de la Consulta Tecnica PN
                 
                 
                 <input type="hidden" name="Guardar" id="Guardar"   />
                 <input type="hidden" name="Identificador" id="Identificador"  value="<?php echo $Identificador; ?>" />
                 <input name="CmpOrigen" type="hidden" id="CmpOrigen" value="<?php echo $InsOrdenCodificacion->OciOrigen;?>" size="3" />
                 </span></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Codigo Interno:</td>
               <td align="left" valign="top"><input readonly="readonly" name="CmpId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpId" value="<?php echo $InsOrdenCodificacion->OciId;?>" size="15" maxlength="20" /></td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Proveedor:
                 <input name="CmpProveedorId" type="hidden" id="CmpProveedorId" value="<?php echo $InsOrdenCodificacion->PrvId;?>" size="3" /></td>
               <td colspan="3" align="left" valign="top"><table>
                 <tr>
                   <td><select <?php if(!empty($InsOrdenCodificacion->PrvId)){ echo 'disabled="disabled"';} ?>  class="EstFormularioCombo" name="CmpProveedorTipoDocumento" id="CmpProveedorTipoDocumento">
                     <option value="">Escoja una opcion</option>
                     <?php
			foreach($ArrTipoDocumentos as $DatTipoDocumento){
			?>
                     <option <?php echo $DatTipoDocumento->TdoId;?> <?php echo ($DatTipoDocumento->TdoId==$InsOrdenCodificacion->TdoId)?'selected="selected"':"";?> value="<?php echo $DatTipoDocumento->TdoId?>"><?php echo $DatTipoDocumento->TdoCodigo?> - <?php echo $DatTipoDocumento->TdoNombre?></option>
                     <?php
			}
			?>
                   </select></td>
                   <td><a href="javascript:FncProveedorNuevo();"></a></td>
                   <td><input name="CmpProveedorNumeroDocumento" type="text" class="EstFormularioCaja" id="CmpProveedorNumeroDocumento"  value="<?php echo $InsOrdenCodificacion->PrvNumeroDocumento;?>" size="15" maxlength="50" readonly="readonly" <?php if(!empty($InsOrdenCodificacion->PrvId)){ echo 'readonly="readonly"';} ?> /></td>
                   <td><a href="javascript:FncProveedorBuscar('NumeroDocumento');"></a></td>
                   <td><input name="CmpProveedorNombre" type="text" class="EstFormularioCaja" id="CmpProveedorNombre" value="<?php echo $InsOrdenCodificacion->PrvNombreCompleto;?>" size="35" maxlength="255" readonly="readonly" <?php if(!empty($InsOrdenCodificacion->PrvId)){ echo 'readonly="readonly"';} ?>  />
                     <a href="comunes/Proveedor/FrmProveedorBuscar.php?height=440&amp;width=850" class="thickbox" title=""></a></td>
                   <td>&nbsp;</td>
                 </tr>
               </table></td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Fecha:<br />
                 <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
               <td align="left" valign="top"><input  name="CmpFecha" type="text" class="EstFormularioCajaFecha" id="CmpFecha" value="<?php if(empty($InsOrdenCodificacion->OciFecha)){ echo date("d/m/Y");}else{ echo $InsOrdenCodificacion->OciFecha; }?>" size="15" maxlength="10" readonly="readonly" /></td>
               <td align="left" valign="top">Hora:<br />
                 <span class="EstFormularioSubEtiqueta">(00:00:00)</span></td>
               <td align="left" valign="top"><input name="CmpHora" type="text"  class="EstFormularioCajaHora" id="CmpHora" value="<?php if (empty($InsOrdenCodificacion->OciHora)){ echo "";}else{ echo $InsOrdenCodificacion->OciHora; } ?>" size="10" maxlength="10" readonly="readonly" /></td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Fecha Respuesta<br />
                 <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
               <td align="left" valign="top"><input name="CmpFechaRespuesta" type="text" class="EstFormularioCajaFecha" id="CmpFechaRespuesta" value="<?php  echo $InsOrdenCodificacion->OciFechaRespuesta;?>" size="15" maxlength="10" readonly="readonly" /></td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Nombre del Solicitante:</td>
               <td align="left" valign="top"><select disabled="disabled" class="EstFormularioCombo" name="CmpPersonal" id="CmpPersonal" >
                 <option value="">Escoja una opcion</option>
                 <?php
					foreach($ArrPersonales as $DatPersonal){
					?>
                 <option <?php echo ($DatPersonal->PerId==$InsOrdenCodificacion->PerId)?'selected="selected"':'';?>  value="<?php echo $DatPersonal->PerId;?>"><?php echo $DatPersonal->PerNombre ?> <?php echo $DatPersonal->PerApellidoPaterno; ?> <?php echo $DatPersonal->PerApellidoMaterno; ?></option>
                 <?php
					}
					?>
               </select></td>
               <td align="left" valign="top">Cargo del Solicitante:</td>
               <td align="left" valign="top"><input name="CmpSolicitanteCargo" type="text"  class="EstFormularioCaja" id="CmpSolicitanteCargo" value="<?php echo $InsOrdenCodificacion->OciSolicitanteCargo;?>" size="25" maxlength="45" readonly="readonly" /></td>
               <td align="left" valign="top">&nbsp;</td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Dealer/Sucursal:</td>
               <td align="left" valign="top"><input name="CmpDealerSucursal" type="text"  class="EstFormularioCaja" id="CmpDealerSucursal" value="<?php echo $InsOrdenCodificacion->OciDealerSucursal;?>" size="25" maxlength="45" readonly="readonly" /></td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Descripcion PN Solicitado:</td>
               <td align="left" valign="top"><input name="CmpDescripcionPN" type="text"  class="EstFormularioCaja" id="CmpDescripcionPN" value="<?php echo $InsOrdenCodificacion->OciDescripcionPN;?>" size="45" maxlength="255" readonly="readonly" /></td>
               <td align="left" valign="top">VIN:</td>
               <td align="left" valign="top"><input name="CmpVIN" type="text"  class="EstFormularioCaja" id="CmpVIN" value="<?php echo $InsOrdenCodificacion->OciVIN;?>" size="25" maxlength="45" readonly="readonly" /></td>
               <td align="left" valign="top">&nbsp;</td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Modelo:</td>
               <td align="left" valign="top"><input name="CmpVehiculoModelo" type="text"  class="EstFormularioCaja" id="CmpVehiculoModelo" value="<?php echo $InsOrdenCodificacion->OciVehiculoModelo;?>" size="25" maxlength="45" readonly="readonly" /></td>
               <td align="left" valign="top">A&ntilde;o de Fabricacion:</td>
               <td align="left" valign="top"><input name="CmpVehiculoAnoFabricacion" type="text"  class="EstFormularioCaja" id="CmpVehiculoAnoFabricacion" value="<?php echo $InsOrdenCodificacion->OciVehiculoAnoFabricacion;?>" size="25" maxlength="45" readonly="readonly" /></td>
               <td align="left" valign="top">&nbsp;</td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Motor/Cilindrada:</td>
               <td align="left" valign="top"><input name="CmpVehiculoMotorCilindrada" type="text"  class="EstFormularioCaja" id="CmpVehiculoMotorCilindrada" value="<?php echo $InsOrdenCodificacion->OciVehiculoMotorCilindrada;?>" size="25" maxlength="45" readonly="readonly" /></td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="4" align="left" valign="top"><span class="EstFormularioSubTitulo">Datos Adicionales</span></td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Observaciones en Correo:</td>
               <td align="left" valign="top"><textarea name="CmpObservacionCorreo" cols="45" rows="2" readonly="readonly" class="EstFormularioCaja" id="CmpObservacionCorreo"><?php echo $InsOrdenCodificacion->OciObservacionCorreo;?></textarea></td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="4" align="left" valign="top"><span class="EstFormularioSubTitulo">Observaciones y Otras Referencias</span></td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Observacion Interna:</td>
               <td align="left" valign="top"><textarea name="CmpObservacion" cols="45" rows="2" readonly="readonly" class="EstFormularioCaja" id="CmpObservacion"><?php echo $InsOrdenCodificacion->OciObservacion;?></textarea></td>
               <td align="left" valign="top">Observacion Impresa:</td>
               <td align="left" valign="top"><textarea name="CmpObservacionImpresa" cols="45" rows="2" readonly="readonly" class="EstFormularioCaja" id="CmpObservacionImpresa"><?php echo $InsOrdenCodificacion->OciObservacionImpresa;?></textarea></td>
               <td align="left" valign="top">&nbsp;</td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Estado: </td>
               <td align="left" valign="top"><?php
					switch($InsOrdenCodificacion->OciEstado){
							case 1:
							$OpcEstado1 = 'selected = "selected"';
						break;
						
						case 3:
							$OpcEstado3 = 'selected = "selected"';						
						break;
						
						case 31:
							$OpcEstado31 = 'selected = "selected"';						
						break;
						
						case 6:
							$OpcEstado6 = 'selected = "selected"';						
						break;
					}
					?>
                 <select  class="EstFormularioCombo" name="CmpEstado" id="CmpEstado" disabled="disabled" >
                   <option <?php echo $OpcEstado1;?> value="1">Pendiente</option>
                   <option <?php echo $OpcEstado3;?> value="3">Realizado</option>
                   <option <?php echo $OpcEstado31;?> value="31">Enviado/Correo</option>
                   <option <?php echo $OpcEstado6;?> value="6">Anulado</option>
                   </select></td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="4" align="left" valign="top"><span class="EstFormularioSubTitulo">Foto de Referencia </span></td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td colspan="4" align="left" valign="top"><div class="EstFormularioArea" >
                 <table border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                   <tr>
                     <td width="1%">&nbsp;</td>
                     <td width="48%"><a href="javascript:FncOrdenCodificacionFotoListar();"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a> <a href="javascript:FncOrdenCodificacionFotoEliminarTodo();"></a></td>
                     <td width="50%" align="right"><div class="EstFormularioAccion" id="CapOrdenCodificacionFotosAccion">Listo
                       para registrar elementos</div></td>
                     <td width="1%">&nbsp;</td>
                   </tr>
                   <tr>
                     <td>&nbsp;</td>
                     <td colspan="2"><table border="0" cellpadding="0" cellspacing="0" class="EstFormulario">
                       <tr>
                         <td width="275" colspan="2" align="left" valign="top"><script type="text/javascript">
									
									$(document).ready(function(){
						
											$("#fileUploadOrdenCodificacionFoto").uploadFile({
												
											allowedTypes:"png,gif,jpg,jpeg,pdf",
											url:"formularios/OrdenCodificacion/acc/AccOrdenCodificacionSubirFoto.php",
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
											sizeErrorStr:"Tama&ntilde;o no permitido",
											uploadErrorStr:"No se pudo subir el archivo",
											dragdropWidth: 500,
											
											onSuccess:function(files,data,xhr){
												FncOrdenCodificacionFotoListar();
											}
							
										});
									});
									  
									</script></td>
                         <td width="4" align="left" valign="top">&nbsp;</td>
                       </tr>
                       <tr>
                         <td colspan="2" align="left" valign="top"><div class="EstCapOrdenCodificacionFotos" id="CapOrdenCodificacionFotos"></div></td>
                         <td align="left" valign="top">&nbsp;</td>
                       </tr>
                     </table></td>
                     <td><div id="CapOrdenCodificacionFotosResultado"> </div></td>
                   </tr>
                 </table>
               </div></td>
               <td align="left" valign="top">&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               </tr>
             </table>
           </div></td>
       </tr>
       </table>
    </div>    
    

    
   
    
    
<div>		
 
 
        
        
        
          
       

           
  
        
        
        
        
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
