<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>

<!-- ARCHIVO DE FUNCIONES JS -->

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Moneda');?>JsMonedaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('TipoCambio');?>JsTipoCambioFunciones.js" ></script>



<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Vehiculo');?>JsVehiculoIngresoSimpleFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Vehiculo');?>JsVehiculoIngresoSimpleAutocompletar.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Vehiculo');?>JsVehiculoMantenimientoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Personal");?>JsPersonalCombo.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsVehiculoIngresoBonoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsVehiculoIngresoBonoPresupuestoFunciones.js" ></script>

<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssVehiculoIngresoBono.css');
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssVehiculoIngresoBonoPresupuesto.css');
</style>

<?php
$Registro = false;
$POST_Sucursal = $_POST['CmpSucursal'];

//MENSAJES
include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjVehiculoIngresoBono.php');
//CLASES
require_once($InsPoo->MtdPaqActividad().'ClsVehiculoIngresoBono.php');
require_once($InsPoo->MtdPaqRRHH().'ClsPersonal.php');
require_once($InsPoo->MtdPaqLogistica().'ClsTipoDocumento.php');
require_once($InsPoo->MtdPaqLogistica().'ClsClienteTipo.php');
require_once($InsPoo->MtdPaqEmpresa().'ClsSucursal.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');

$SucursalId = $POST_Sucursal;
//CONFIGURACIONES
//require_once($InsPoo->MtdPaqActividadConf().'CnfVehiculoIngresoBono.php');

//CLASES
$InsVehiculoIngresoBono = new ClsVehiculoIngresoBono();
$InsPersonal = new ClsPersonal();
$InsTipoDocumento = new ClsTipoDocumento();
$InsClienteTipo = new ClsClienteTipo();
$InsSucursal = new ClsSucursal();
$InsMoneda = new ClsMoneda();

$SucursalSiglas = "";

if(!empty($POST_Sucursal)){

	$InsSucursal->SucId = $POST_Sucursal;
	$InsSucursal->MtdObtenerSucursal(false);
	$SucursalSiglas = $InsSucursal->SucSiglas;	
}

//ACCIONES
include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccVehiculoIngresoBonoRegistrar.php');



//MtdObtenerPersonales($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PerId',$oSentido = 'Desc',$oPaginacion = '0,10',$oPersonalTipo=NULL,$oEstado=NULL,$oFechaNacimientoRango=NULL,$oTaller=NULL,$oRecepcion=NULL,$oVenta=NULL,$oArea=NULL,$oSucursal=NULL,$oAlmacen=NULL,$oFirmante=NULL,$oMultisucursal=false)
$ResPersonal = $InsPersonal->MtdObtenerPersonales(NULL,NULL,NULL,"PerNombre","ASC",NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,$InsVehiculoIngresoBono->SucId,NULL,NULL,true);
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
	FncVehiculoIngresoBonoMantenimientoKilometrajeEstablecer();
	
	FncVehiculoIngresoBonoHistorialListar();

});

</script>


<form id="FrmRegistrar" name="FrmRegistrar" method="post" action="#" enctype="multipart/form-data" >	

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
        <td width="1922" height="25" colspan="2"><span class="EstFormularioTitulo">REGISTRAR
        BONO DE VEHICULO</span></td>
      </tr>
      <tr>
        <td colspan="2">
        
          <div class="EstFormularioArea">
         
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>Creado el:</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsVehiculoIngresoBono->VibTiempoCreacion;?></span></td>
            <td>&nbsp;</td>
            <td>Modificado el</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsVehiculoIngresoBono->VibTiempoModificacion;?></span></td>
          </tr>
        </table>
        
        </div>  
        
	<br />
        
	<ul class="tabs">
    
        <li><a href="#tab1">Bono</a></li>
     
        
	</ul>
	<div class="tab_container">
    <div id="tab1" class="tab_content">
        <!--Content-->     
             
        
      
        
        
        
             <table width="100%" border="0" cellpadding="2" cellspacing="2">
       
       <tr>
         <td valign="top">
           
         
        
        <div class="EstFormularioArea">
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td width="4">&nbsp;</td>
            <td width="118">&nbsp;</td>
            <td colspan="5">&nbsp;</td>
            <td width="4">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Código Interno:

         </td>
            <td width="309" align="left" valign="top"><input name="CmpId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpId" value="<?php echo $InsVehiculoIngresoBono->VibId;?>" size="15" maxlength="20"  readonly="readonly"/></td>
            <td width="161" align="left" valign="top">&nbsp;</td>
            <td width="314" align="left" valign="top">&nbsp;</td>
            <td width="314" align="left" valign="top">&nbsp;</td>
            <td width="314" align="left" valign="top">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Fecha:<br />
              <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
            <td align="left" valign="top">
              
              
              <label>
                <input class="EstFormularioCajaFecha" name="CmpFecha" type="text" id="CmpFecha" value="<?php  echo $InsVehiculoIngresoBono->VibFecha;?>" size="15" maxlength="10" />
                </label><img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFecha" name="BtnFecha" width="25" height="25" align="absmiddle"  style="cursor:pointer;" /></td>
            <td align="left" valign="top">Sucursal:</td>
            <td align="left" valign="top"><select disabled="disabled"  class="EstFormularioCombo" name="CmpSucursal" id="CmpSucursal">
              <option value="">Escoja una opcion</option>
              <?php
    foreach($ArrSucursales as $DatSucursal){
    ?>
              <option value="<?php echo $DatSucursal->SucId;?>" <?php if($InsVehiculoIngresoBono->SucId==$DatSucursal->SucId){ echo 'selected="selected"';} ?> ><?php echo $DatSucursal->SucNombre;?></option>
              <?php
    }
    ?>
              </select></td>
            <td align="left" valign="top">Aprobado por:</td>
            <td align="left" valign="top"><select  class="EstFormularioCombo" name="CmpPersonal" id="CmpPersonal" >
              <option value="">Escoja una opcion</option>
              <?php
					foreach($ArrAsesores as $DatAsesor){
					?>
              <option <?php echo ($DatAsesor->PerId==$InsVehiculoIngresoBono->PerId)?'selected="selected"':'';?>  value="<?php echo $DatAsesor->PerId;?>"><?php echo $DatAsesor->PerNombre ?> <?php echo $DatAsesor->PerApellidoPaterno; ?> <?php echo $DatAsesor->PerApellidoMaterno; ?></option>
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
                <td align="left" valign="top" class="EstFormulario"><input name="CmpVehiculoIngresoId" type="hidden" id="CmpVehiculoIngresoId" value="<?php echo $InsVehiculoIngresoBono->EinId;?>" size="3" /></td>
                <td align="left" valign="top" class="EstFormulario"><a href="javascript:FncVehiculoIngresoSimpleNuevo();"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                <td align="left" valign="top" class="EstFormulario">VIN:</td>
                <td align="left" valign="top" class="EstFormulario"><input name="CmpVehiculoIngresoVIN" type="text" class="EstFormularioCaja" id="CmpVehiculoIngresoVIN"  value="<?php echo $InsVehiculoIngresoBono->EinVIN;?>" size="25" maxlength="50" /></td>
                <td align="left" valign="top" class="EstFormulario"><a href="javascript:FncVehiculoIngresoSimpleBuscar('VIN');"><img src="imagenes/acciones/buscar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                <td align="left" valign="top" class="EstFormulario">Placa:</td>
                <td align="left" valign="top" class="EstFormulario"><input  name="CmpVehiculoIngresoPlaca" type="text"  class="EstFormularioCaja" id="CmpVehiculoIngresoPlaca" value="<?php echo $InsVehiculoIngresoBono->EinPlaca;?>" size="10" maxlength="50"  /></td>
                <td align="left" valign="top" class="EstFormulario"><a href="javascript:FncVehiculoIngresoSimpleBuscar('Placa');"><img src="imagenes/acciones/buscar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                <td align="left" valign="top" class="EstFormulario"><a id="BtnVehiculoIngresoRegistrar" onclick="FncVehiculoIngresoSimpleCargarFormulario('Registrar');" href="javascript:void(0)" title=""> <img src="imagenes/acciones/registrar.png" alt="[Registrar]" width="25" height="25" border="0" align="absmiddle" title="Registrar" /></a> <a id="BtnVehiculoIngresoEditar" onclick="FncVehiculoIngresoSimpleCargarFormulario('Editar');" href="javascript:void(0)"   title=""> <img src="imagenes/acciones/editar.png" alt="[Editar]" width="25" height="25" border="0" align="absmiddle" title="Editar" /></a></td>
                <td align="left" valign="top" class="EstFormulario">Marca:
                  <input name="CmpVehiculoMarcaId" type="hidden" id="CmpVehiculoMarcaId" value="<?php echo $InsVehiculoIngresoBono->VmaId;?>" size="3" /></td>
                <td align="left" valign="top" class="EstFormulario"><input  name="CmpVehiculoMarca" type="text"  class="EstFormularioCaja" id="CmpVehiculoMarca" value="<?php echo $InsVehiculoIngresoBono->VmaNombre;?>" size="15" maxlength="50" /></td>
                <td align="left" valign="top" class="EstFormulario">Modelo:
                  <input name="CmpVehiculoModeloId" type="hidden" id="CmpVehiculoModeloId" value="<?php echo $InsVehiculoIngresoBono->VmoId;?>" size="3" /></td>
                <td align="left" valign="top" class="EstFormulario"><input  name="CmpVehiculoModelo" type="text"  class="EstFormularioCaja" id="CmpVehiculoModelo" value="<?php echo $InsVehiculoIngresoBono->VmoNombre;?>" size="15" maxlength="50" /></td>
                <td align="left" valign="top" class="EstFormulario">Version:
                  <input name="CmpVehiculoVersionId" type="hidden" id="CmpVehiculoVersionId" value="<?php echo $InsVehiculoIngresoBono->VveId;?>" size="3" /></td>
                <td align="left" valign="top" class="EstFormulario"><input  name="CmpVehiculoVersion" type="text"  class="EstFormularioCaja" id="CmpVehiculoVersion" value="<?php echo $InsVehiculoIngresoBono->VveNombre;?>" size="15" maxlength="50" /></td>
              </tr>
            </table></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Cliente:</td>
            <td colspan="5" align="left" valign="top"><table>
              <tr>
                <td><input type="hidden" name="CmpClienteId" id="CmpClienteId" value="<?php echo $InsVehiculoIngresoBono->CliId;?>" size="3" />
                  <input name="CmpClienteVehiculoIngresoId" type="hidden" id="CmpClienteVehiculoIngresoId" value="<?php echo $InsVehiculoIngresoBono->EinId;?>" size="3" /></td>
                <td><select disabled="disabled" class="EstFormularioCombo" name="CmpClienteTipoDocumento" id="CmpClienteTipoDocumento"  >
                  <option value="">Escoja una opcion</option>
                  <?php
	foreach($ArrTipoDocumentos as $DatTipoDocumento){
	?>
                  <option <?php echo $DatTipoDocumento->TdoId;?> <?php echo ($DatTipoDocumento->TdoId==$InsVehiculoIngresoBono->TdoId)?'selected="selected"':"";?> value="<?php echo $DatTipoDocumento->TdoId?>"><?php echo $DatTipoDocumento->TdoCodigo?> - <?php echo $DatTipoDocumento->TdoNombre?></option>
                  <?php
	}
	?>
                  </select></td>
                <td>&nbsp;</td>
                <td><input name="CmpClienteNumeroDocumento" type="text" class="EstFormularioCaja" id="CmpClienteNumeroDocumento"  tabindex="4" value="<?php echo $InsVehiculoIngresoBono->CliNumeroDocumento;?>" size="20" maxlength="50" readonly="readonly" <?php if(!empty($InsVehiculoIngresoBono->CliId)){ echo 'readonly="readonly"';} ?>   /></td>
                <td>&nbsp;</td>
                <td><input name="CmpClienteNombreCompleto" type="text" class="EstFormularioCaja" id="CmpClienteNombreCompleto"   tabindex="2" value="<?php echo $InsVehiculoIngresoBono->CliNombre;?> <?php echo $InsVehiculoIngresoBono->CliApellidoPaterno;?> <?php echo $InsVehiculoIngresoBono->CliApellidoMaterno;?>" size="45" maxlength="255" readonly="readonly" <?php if(!empty($InsVehiculoIngresoBono->CliId)){ echo 'readonly="readonly"';} ?>  />
                  <input type="hidden" name="CmpClienteNombre" id="CmpClienteNombre" value="<?php echo $InsVehiculoIngresoBono->CliNombre;?>" size="3" />
                  <input type="hidden" name="CmpClienteApellidoPaterno" id="CmpClienteApellidoPaterno" value="<?php echo $InsVehiculoIngresoBono->CliApellidoPaterno;?>" size="3" />
                  <input type="hidden" name="CmpClienteApellidoMaterno" id="CmpClienteApellidoMaterno" value="<?php echo $InsVehiculoIngresoBono->CliApellidoMaterno;?>" size="3" /></td>
                <td>&nbsp;</td>
                <td></td>
                </tr>
              <tr> </tr>
              </table></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="6" align="left" valign="top"><span class="EstFormularioSubTitulo">DATOS DE LA BONO DE VEHICULO</span></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Referencia:</td>
            <td colspan="5" align="left" valign="top"><input name="CmpReferencia" type="text" class="EstFormularioCaja" id="CmpReferencia" value="<?php echo $InsVehiculoIngresoBono->VibReferencia;?>" size="45" maxlength="255" /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Moneda:</td>
            <td align="left" valign="top"><table border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td><span id="spryselect2">
                  <select class="EstFormularioCombo" name="CmpMonedaId" id="CmpMonedaId">
                    <option value="">Escoja una opcion</option>
                    <?php
			  foreach($ArrMonedas as $DatMoneda){
			  ?>
                    <option value="<?php echo $DatMoneda->MonId?>" <?php if($InsVehiculoIngresoBono->MonId==$DatMoneda->MonId){ echo 'selected="selected"';}elseif($EmpresaMonedaId==$DatMoneda->MonId){  echo 'selected="selected"';}?> ><?php echo $DatMoneda->MonNombre?> ( <?php echo $DatMoneda->MonSimbolo;?>)</option>
                    <?php
			  }
			  ?>
                    </select>
                  <span class="selectRequiredMsg"><img src="imagenes/advertencia.png" width="20" height="20" border="0" align="absmiddle" title="Debe seleccionar un elemento" alt="[A]"  /></span></span></td>
                <td><div id="CapMonedaBuscar"></div></td>
                </tr>
              </table></td>
            <td align="left" valign="top">Tipo de Cambio: <br />
              <span class="EstFormularioSubEtiqueta"> (0.000)</span></td>
            <td colspan="3" align="left" valign="top"><table>
              <tr>
                <td><input name="CmpTipoCambio" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpTipoCambio" value="<?php if (empty($InsVehiculoIngresoBono->VibTipoCambio)){ echo "";}else{ echo $InsVehiculoIngresoBono->VibTipoCambio; } ?>" size="10" maxlength="10" /></td>
                <td></td>
                </tr>
              </table></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Total:</td>
            <td align="left" valign="top"><input class="EstFormularioCaja" name="CmpTotal" type="text" id="CmpTotal" size="10" maxlength="10" value="<?php echo round($InsVehiculoIngresoBono->VibMonto,2);?>" /></td>
            <td align="left" valign="top">&nbsp;</td>
            <td colspan="3" align="left" valign="top">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Observaciones:</td>
            <td align="left" valign="top"><textarea class="EstFormularioCaja" name="CmpDescripcion" id="CmpDescripcion" cols="45" rows="4"><?php echo $InsVehiculoIngresoBono->VibObservacionInterna;?></textarea></td>
            <td align="left" valign="top">&nbsp;</td>
            <td colspan="3" align="left" valign="top">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Estado:</td>
            <td align="left" valign="top"><?php
			switch($InsVehiculoIngresoBono->VibEstado){
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
            <td>&nbsp;</td>
            <td colspan="5">&nbsp;</td>
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
<!--
//-->

Calendar.setup({ 
	inputField : "CmpFecha",  // id del campo de texto 
	ifFormat   : "%d/%m/%Y",  //  
	button     : "BtnFecha"// el id del botón que  
	});
	
	

</script>


   
<?php
}else{
	echo ERR_GEN_101;
}

//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();

	if(!$_SESSION['MysqlDeb']){
		$InsMensaje->MtdRedireccionar("principal.php?Mod=".$GET_mod."&Form=Listado",$Registro,1500);
	}
?>
