<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>

<?php $PrivilegioEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar"))?true:false;?>


<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsVehiculoIngresoEventoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsVehiculoIngresoEventoPresupuestoFunciones.js" ></script>


<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssVehiculoIngresoEvento.css');
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssVehiculoIngresoEventoPresupuesto.css');
</style>

<?php
//VARIABLES
$GET_id = $_GET['Id'];
//MENSAJES
include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjVehiculoIngresoEvento.php');
//CLASES
require_once($InsPoo->MtdPaqActividad().'ClsVehiculoIngresoEvento.php');
require_once($InsPoo->MtdPaqRRHH().'ClsPersonal.php');
require_once($InsPoo->MtdPaqLogistica().'ClsTipoDocumento.php');
require_once($InsPoo->MtdPaqLogistica().'ClsClienteTipo.php');
require_once($InsPoo->MtdPaqEmpresa().'ClsSucursal.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
//INSTANCIAS
$InsVehiculoIngresoEvento = new ClsVehiculoIngresoEvento();
$InsPersonal = new ClsPersonal();
$InsTipoDocumento = new ClsTipoDocumento();
$InsClienteTipo = new ClsClienteTipo();
$InsSucursal = new ClsSucursal();
$InsMoneda = new ClsMoneda();

//ACCIONES
include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccVehiculoIngresoEventoEditar.php');

//MtdObtenerPersonales($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PerId',$oSentido = 'Desc',$oPaginacion = '0,10',$oPersonalTipo=NULL,$oEstado=NULL,$oFechaNacimientoRango=NULL,$oTaller=NULL,$oRecepcion=NULL,$oVenta=NULL,$oArea=NULL,$oSucursal=NULL,$oAlmacen=NULL,$oFirmante=NULL,$oMultisucursal=false)
$ResPersonal = $InsPersonal->MtdObtenerPersonales(NULL,NULL,NULL,"PerNombre","ASC",NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,$InsVehiculoIngresoEvento->SucId,NULL,NULL,true);
$ArrAsesores = $ResPersonal['Datos'];

$RepTipoDocumento = $InsTipoDocumento->MtdObtenerTipoDocumentos(NULL,NULL,'TdoNombre',"ASC",NULL);
$ArrTipoDocumentos = $RepTipoDocumento['Datos'];

$RepClienteTipo = $InsClienteTipo->MtdObtenerClienteTipos(NULL,NULL,NULL,'VmaNombre,LtiNombre',"ASC",NULL);
$ArrClienteTipos = $RepClienteTipo['Datos'];

$RepSucursal = $InsSucursal->MtdObtenerSucursales(NULL,NULL,"SucNombre","ASC",NULL);
$ArrSucursales = $RepSucursal['Datos'];


$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","ASC",NULL);
$ArrMonedas = $ResMoneda['Datos'];


?>

<script type="text/javascript">
/*
Desactivando tecla ENTER
*/
FncDesactivarEnter();
/*
Configuracion Formulario
*/
$(document).ready(function (){
	
/*
CARGAS INICIALES
*/	
	FncVehiculoIngresoEventoMantenimientoKilometrajeEstablecer();
	
	FncVehiculoIngresoEventoHistorialListar();
	
});

</script>


<div class="EstCapMenu">
          	<?php
			if($PrivilegioEditar){
			?>           
             
             <div class="EstSubMenuBoton"><a href="principal<?php echo (!empty($GET_dia)?'2':'');?>.php?Mod=<?php echo $GET_mod;?>&Form=Editar<?php echo (!empty($GET_dia)?'&Dia=1':'');?>&Id=<?php echo $InsVehiculoIngresoEvento->VieId;?>"><img src="imagenes/iconos/editar.png" alt="[Editar]" title="Editar" />Editar</a></div>
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
        <td width="1922" height="25" colspan="2"><span class="EstFormularioTitulo">VER
        INCIDENTE DE VEHICULO</span></td>
      </tr>
      <tr>
        <td colspan="2">
        
        
        
             <div class="EstFormularioArea">
         
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>Creado el:</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsVehiculoIngresoEvento->VieTiempoCreacion;?></span></td>
            <td>Modificado el</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsVehiculoIngresoEvento->VieTiempoModificacion;?></span></td>
          </tr>
        </table>
        
        </div>   
        <br />
        
        	<ul class="tabs">
        <li><a href="#tab1">Incidente</a></li>
        

	</ul>
 <div class="tab_container">
    <div id="tab1" class="tab_content">
        <!--Content-->     
             
        
      
        
        
        
             <table width="100%" border="0" cellpadding="2" cellspacing="2">
       
       <tr>
         <td valign="top">
           
           
         <div class="EstFormularioArea">
         
        <table class="EstFormulario" width="200" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td width="1">&nbsp;</td>
            <td width="93">&nbsp;</td>
            <td width="241">&nbsp;</td>
            <td width="122">&nbsp;</td>
            <td width="184">&nbsp;</td>
            <td width="115">&nbsp;</td>
            <td width="82">&nbsp;</td>
            <td width="1">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>C&oacute;digo Interno:</td>
            <td><input name="CmpId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpId" value="<?php echo $InsVehiculoIngresoEvento->VieId;?>" size="15" maxlength="20"  readonly="readonly"/></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Fecha:<br />
              <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
            <td align="left" valign="top"><span id="sprytextfield2">
              <label>
                <input name="CmpFecha" type="text" class="EstFormularioCajaFecha" id="CmpFecha" value="<?php  echo $InsVehiculoIngresoEvento->VieFecha;?>" size="15" maxlength="10" readonly="readonly" />
                </label>
              </span></td>
            <td align="left" valign="top">Sucursal:</td>
            <td align="left" valign="top"><select disabled="disabled"  class="EstFormularioCombo" name="CmpSucursal" id="CmpSucursal">
              <option value="">Escoja una opcion</option>
              <?php
    foreach($ArrSucursales as $DatSucursal){
    ?>
              <option value="<?php echo $DatSucursal->SucId;?>" <?php if($InsVehiculoIngresoEvento->SucId==$DatSucursal->SucId){ echo 'selected="selected"';} ?> ><?php echo $DatSucursal->SucNombre;?></option>
              <?php
    }
    ?>
              </select></td>
            <td align="left" valign="top">Reportado por:</td>
            <td align="left" valign="top"><select disabled="disabled"  class="EstFormularioCombo" name="CmpPersonal" id="CmpPersonal" >
              <option value="">Escoja una opcion</option>
              <?php
					foreach($ArrAsesores as $DatAsesor){
					?>
              <option <?php echo ($DatAsesor->PerId==$InsVehiculoIngresoEvento->PerId)?'selected="selected"':'';?>  value="<?php echo $DatAsesor->PerId;?>"><?php echo $DatAsesor->PerNombre ?> <?php echo $DatAsesor->PerApellidoPaterno; ?> <?php echo $DatAsesor->PerApellidoMaterno; ?></option>
              <?php
					}
					?>
            </select></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="6" align="left" valign="top"><span class="EstFormularioSubTitulo">DATOS DEL CLIENTE Y VEHICULO</span></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Vehiculo:</td>
            <td colspan="5" align="left" valign="top"><table>
              <tr>
                <td align="left" valign="top" class="EstFormulario"><input name="CmpVehiculoIngresoId" type="hidden" id="CmpVehiculoIngresoId" value="<?php echo $InsVehiculoIngresoEvento->EinId;?>" size="3" /></td>
                <td align="left" valign="top" class="EstFormulario">VIN:</td>
                <td align="left" valign="top" class="EstFormulario"><input name="CmpVehiculoIngresoVIN" type="text" class="EstFormularioCaja" id="CmpVehiculoIngresoVIN"  value="<?php echo $InsVehiculoIngresoEvento->EinVIN;?>" size="25" maxlength="50" readonly="readonly" /></td>
                <td align="left" valign="top" class="EstFormulario">Placa:</td>
                <td align="left" valign="top" class="EstFormulario"><input  name="CmpVehiculoIngresoPlaca" type="text"  class="EstFormularioCaja" id="CmpVehiculoIngresoPlaca" value="<?php echo $InsVehiculoIngresoEvento->EinPlaca;?>" size="10" maxlength="50" readonly="readonly"  /></td>
                <td align="left" valign="top" class="EstFormulario">Marca:
                  <input name="CmpVehiculoMarcaId" type="hidden" id="CmpVehiculoMarcaId" value="<?php echo $InsVehiculoIngresoEvento->VmaId;?>" size="3" /></td>
                <td align="left" valign="top" class="EstFormulario"><input  name="CmpVehiculoMarca" type="text"  class="EstFormularioCaja" id="CmpVehiculoMarca" value="<?php echo $InsVehiculoIngresoEvento->VmaNombre;?>" size="15" maxlength="50" readonly="readonly" /></td>
                <td align="left" valign="top" class="EstFormulario">Modelo:
                  <input name="CmpVehiculoModeloId" type="hidden" id="CmpVehiculoModeloId" value="<?php echo $InsVehiculoIngresoEvento->VmoId;?>" size="3" /></td>
                <td align="left" valign="top" class="EstFormulario"><input  name="CmpVehiculoModelo" type="text"  class="EstFormularioCaja" id="CmpVehiculoModelo" value="<?php echo $InsVehiculoIngresoEvento->VmoNombre;?>" size="15" maxlength="50" readonly="readonly"  /></td>
                <td align="left" valign="top" class="EstFormulario">Version:
                  <input name="CmpVehiculoVersionId" type="hidden" id="CmpVehiculoVersionId" value="<?php echo $InsVehiculoIngresoEvento->VveId;?>" size="3" /></td>
                <td align="left" valign="top" class="EstFormulario"><input  name="CmpVehiculoVersion" type="text"  class="EstFormularioCaja" id="CmpVehiculoVersion" value="<?php echo $InsVehiculoIngresoEvento->VveNombre;?>" size="15" maxlength="50" readonly="readonly" /></td>
                </tr>
              </table></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="6" align="left" valign="top"><span class="EstFormularioSubTitulo">DATOS DEL INCIDENTE DE VEHICULO</span></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Referencia:</td>
            <td colspan="5" align="left" valign="top"><input name="CmpReferencia" type="text" class="EstFormularioCaja" id="CmpReferencia" value="<?php echo $InsVehiculoIngresoEvento->VieReferencia;?>" size="45" maxlength="255" readonly="readonly" /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Descripcion::</td>
            <td colspan="5" align="left" valign="top"><textarea name="CmpDescripcion" cols="45" rows="4" readonly="readonly" class="EstFormularioCaja" id="CmpDescripcion"><?php echo $InsVehiculoIngresoEvento->VieObservacionInterna;?></textarea></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Estado:</td>
            <td align="left" valign="top"><?php
			switch($InsVehiculoIngresoEvento->VieEstado){
				case 1:
					$OpcEstado1 = 'selected="selected"';
				break;
	
				case 3:
					$OpcEstado3 = 'selected="selected"';
				break;
				
				case 6:
					$OpcEstado6 = 'selected="selected"';
				break;
				
			}
			?>
              <select disabled="disabled" class="EstFormularioCombo" id="CmpEstado" name="CmpEstado">
                <option <?php echo $OpcEstado1;?> value="1">Pendiente</option>
                <option <?php echo $OpcEstado3;?> value="3">Realizado</option>
                <option <?php echo $OpcEstado6;?> value="6">Anulado</option>
                </select></td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td colspan="5" align="left" valign="top">&nbsp;</td>
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


