<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>   

<?php $PrivilegioVistaPreliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"VistaPreliminar"))?true:false;?>
<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Imprimir"))?true:false;?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Producto');?>JsListaPrecioFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Producto");?>JsProductoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Producto");?>JsProductoAutocompletar.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsTrasladoAlmacenSalidaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsTrasladoAlmacenSalidaDetalleFunciones.js" ></script>

<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssTrasladoAlmacenSalida.css');
</style>

<?php
$GET_ori = $_GET['Ori'];
$GET_TpeId = $_GET['TpeId'];

$Registro = false;

if(!empty($_POST['Identificador'])){
	$Identificador = $_POST['Identificador'];
}

include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjTrasladoAlmacenSalida.php');
//CLASES
require_once($InsPoo->MtdPaqAlmacen().'ClsTrasladoAlmacenSalida.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsTrasladoAlmacenSalidaDetalle.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProducto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoCodigoReemplazo.php');
require_once($InsPoo->MtdPaqLogistica().'ClsTipoOperacion.php');


require_once($InsPoo->MtdPaqActividad().'ClsFichaIngreso.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoLlamada.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoGasto.php');
require_once($InsPoo->MtdPaqActividad().'ClsPreEntregaDetalle.php');
require_once($InsPoo->MtdPaqActividad().'ClsPreEntregaTarea.php');
require_once($InsPoo->MtdPaqActividad().'ClsPreEntregaSeccion.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoProducto.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoTarea.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoMantenimiento.php');

require_once($InsPoo->MtdPaqActividad().'ClsModalidadIngreso.php');
require_once($InsPoo->MtdPaqActividad().'ClsPlanMantenimiento.php');
require_once($InsPoo->MtdPaqLogistica().'ClsTipoDocumento.php');

require_once($InsPoo->MtdPaqLogistica().'ClsCliente.php');
require_once($InsPoo->MtdPaqLogistica().'ClsClienteTipo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacen.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenProducto.php');
require_once($InsPoo->MtdPaqRRHH().'ClsPersonal.php');

//INSTANCIAS
$InsTrasladoAlmacenSalida = new ClsTrasladoAlmacenSalida();
$InsTipoOperacion = new ClsTipoOperacion();

$InsModalidadIngreso = new ClsModalidadIngreso();
$InsPlanMantenimiento = new ClsPlanMantenimiento();
$InsTipoDocumento = new ClsTipoDocumento();

$InsClienteTipo = new ClsClienteTipo();

$InsAlmacen = new ClsAlmacen();
$InsMoneda = new ClsMoneda();
$InsPersonal = new ClsPersonal();

if (!isset($_SESSION['InsTrasladoAlmacenSalidaDetalle'.$Identificador])){	
	$_SESSION['InsTrasladoAlmacenSalidaDetalle'.$Identificador] = new ClsSesionObjeto();
}else{	
	$_SESSION['InsTrasladoAlmacenSalidaDetalle'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsTrasladoAlmacenSalidaDetalle'.$Identificador]);
}


//ACCIONES
include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccTrasladoAlmacenSalidaRegistrar.php');
//DATOS
// MtdObtenerTipoOperaciones($oCampo=NULL,$oFiltro=NULL,$oOrden = 'TopId',$oSentido = 'Desc',$oPaginacion = '0,10',$oUso=NULL)
$ResTipoOperacion = $InsTipoOperacion->MtdObtenerTipoOperaciones(NULL,NULL,"TopCodigo","ASC",NULL,"2,3");
$ArrTipoOperaciones = $ResTipoOperacion['Datos'];
//DATOS FICHA INGRESO
$ResPlanMantenimiento = $InsPlanMantenimiento->MtdObtenerPlanMantenimientos(NULL,NULL,NULL,"PmaNombre","ASC",1,NULL);
$ArrPlanMantenimientos = $ResPlanMantenimiento['Datos'];

$ResModalidadIngreso = $InsModalidadIngreso->MtdObtenerModalidadIngresos(NULL,NULL,"MinNombre","ASC",NULL,"1,3");
$ArrModalidadIngresos = $ResModalidadIngreso['Datos'];

$RepTipoDocumento = $InsTipoDocumento->MtdObtenerTipoDocumentos(NULL,NULL,'TdoNombre',"ASC",NULL);
$ArrTipoDocumentos = $RepTipoDocumento['Datos'];

//MtdObtenerClienteTipos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'LtiId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVehiculoMarca=NULL,$oEstado=NULL)
$RepClienteTipo = $InsClienteTipo->MtdObtenerClienteTipos(NULL,NULL,NULL,'VmaNombre,LtiNombre',"ASC",NULL,NULL,1);
$ArrClienteTipos = $RepClienteTipo['Datos'];
$RepAlmacen = $InsAlmacen->MtdObtenerAlmacenes(NULL,NULL,"AlmNombre","ASC",NULL);
$ArrAlmacenes = $RepAlmacen['Datos'];

$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","ASC",NULL);
$ArrMonedas = $ResMoneda['Datos'];

$ResPersonal = $InsPersonal->MtdObtenerPersonales(NULL,NULL,NULL,"PerNombre","ASC",NULL,NULL,NULL,NULL,NULL,NULL,NULL);
$ArrPersonales = $ResPersonal['Datos'];

?>


<script type="text/javascript">
/*
Desactivando tecla ENTER
*/

	FncDesactivarEnter();
/*
Configuracion carga de datos y animacion
*/
$(document).ready(function (){

	$('#CmpFecha').focus();
	
	FncTrasladoAlmacenSalidaDetalleListar();
	
});
/*
Configuracion Formulario
*/
var Formulario = "FrmRegistrar";

var TrasladoAlmacenSalidaDetalleEditar = 1;
var TrasladoAlmacenSalidaDetalleEliminar = 1;

var UnidadMedidaTipo = 2;
</script>

<form id="FrmRegistrar" name="FrmRegistrar" method="post" action="#" enctype="multipart/form-data"  onsubmit="FncGuardar();" >

<div class="EstCapMenu">
<input name="BtnGuardar"   id="BtnGuardar" type="image" border="0" src="imagenes/acc_guardar.gif" alt="[Guardar]" title="Guardar" />

<?php
if(!empty($GET_dia)){
?>
	<div class="EstSubMenuBoton"><a href="javascript:self.parent.tb_remove('<?php echo $GET_mod;?>');" ><img src="imagenes/iconos/salir.png" alt="[Salir]" title="Salir" border="0"  />Salir</a></div>&nbsp;
<?php	
}
?>
	

<?php
if($Registro){
?>

	<?php
    if($PrivilegioVistaPreliminar){
    ?>
    <div class="EstSubMenuBoton"><a href="javascript:FncVistaPreliminar('<?php echo $InsTrasladoAlmacenSalida->TasId;?>');"><img src="imagenes/iconos/preliminar.png" alt="[Vista Preliminar]" title="Vista preliminar" />V.P.</a></div>
    <?php
    }
    ?>
	<?php
    if($PrivilegioImprimir){
    ?>
    <div class="EstSubMenuBoton"><a href="javascript:FncImprmir('<?php echo $InsTrasladoAlmacenSalida->TasId;?>');"><img src="imagenes/iconos/imprimir.png" alt="[Imprimir]" title="Imprimir"  />Imprimir</a></div>
    <?php
    }
    ?>
    
<?php	
}
?>


</div>

<div class="EstCapContenido">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
      
      <tr>
        <td width="1922" height="25" colspan="2"><span class="EstFormularioTitulo">REGISTRAR
        TRANSFERENCIA DE SALIDA </span></td>
      </tr>
      <tr>
        <td colspan="2">
          
          
          
	<ul class="tabs">
		<li><a href="#tab1">Transferencia</a></li>
		
        
	</ul>

<div class="tab_container">
    <div id="tab1" class="tab_content">
        <!--Content-->


<table width="100%" border="0" cellpadding="2" cellspacing="2">
            
            <tr>
              <td width="97%" valign="top">
                <div class="EstFormularioArea">
                  <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                    <tr>
                      <td>&nbsp;</td>
                      <td colspan="4">
                        <span class="EstFormularioSubTitulo">Datos de la Transferencia
                          <input type="hidden" name="Guardar" id="Guardar"   />
                          <input type="hidden" name="Identificador" id="Identificador"  value="<?php echo $Identificador; ?>" />
                          </span></td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left" valign="top">Codigo Interno:</td>
                      <td align="left" valign="top"><input readonly="readonly" name="CmpId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpId" value="<?php echo $InsTrasladoAlmacenSalida->TasId;?>" size="15" maxlength="20" /></td>
                      <td align="left" valign="top">Fecha de Salida:<br />
                        <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
                      <td align="left" valign="top"><span id="sprytextfield1">
                        <label>
                          <input class="EstFormularioCajaFecha" name="CmpFecha" type="text" id="CmpFecha" value="<?php if(empty($InsTrasladoAlmacenSalida->TasFecha)){ echo date("d/m/Y");}else{ echo $InsTrasladoAlmacenSalida->TasFecha; }?>" size="10" maxlength="10" />
                        </label>
                        <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg"><img src="imagenes/advertencia.png" width="20" height="20" border="0" align="absmiddle" title="Formato no valido" alt="[A]"  /></span></span><img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFecha" name="BtnFecha" width="25" height="25" align="absmiddle"  style="cursor:pointer;" /></td>
                      <td align="left" valign="top">&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left" valign="top">Tipo de Operacion:</td>
                      <td colspan="3" align="left" valign="top"><select disabled="disabled" class="EstFormularioCombo" name="CmpTipoOperacion" id="CmpTipoOperacion">
                        <option value="">Escoja una opcion</option>
                        <?php
			foreach($ArrTipoOperaciones as $DatTipoOperacion){
			?>
                        <option value="<?php echo $DatTipoOperacion->TopId?>" <?php if($InsTrasladoAlmacenSalida->TopId==$DatTipoOperacion->TopId){ echo 'selected="selected"';} ?> ><?php echo $DatTipoOperacion->TopCodigo?> - <?php echo $DatTipoOperacion->TopNombre?></option>
                        <?php
			}
			?>
                      </select></td>
                      <td align="left" valign="top">&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left" valign="top">Almacen de Origen:</td>
                      <td align="left" valign="top"><span id="spryselect4">
                        <select class="EstFormularioCombo" name="CmpAlmacen" id="CmpAlmacen">
                          <option value="">Escoja una opcion</option>
                          <?php
			foreach($ArrAlmacenes as $DatAlmacen){
			?>
                          <option value="<?php echo $DatAlmacen->AlmId?>" <?php if($InsTrasladoAlmacenSalida->AlmId==$DatAlmacen->AlmId){ echo 'selected="selected"';} ?> ><?php echo $DatAlmacen->AlmNombre?></option>
                          <?php
			}
			?>
                          </select>
                        <span class="selectRequiredMsg">Debe escoger una opcion</span></span></td>
                      <td align="left" valign="top">Almacen Destino:</td>
                      <td align="left" valign="top"><span id="spryselect">
                        <select class="EstFormularioCombo" name="CmpAlmacenDestino" id="CmpAlmacenDestino">
                          <option value="">Escoja una opcion</option>
                          <?php
			foreach($ArrAlmacenes as $DatAlmacen){
			?>
                          <option value="<?php echo $DatAlmacen->AlmId?>" <?php if($InsTrasladoAlmacenSalida->AlmIdDestino==$DatAlmacen->AlmId){ echo 'selected="selected"';} ?> ><?php echo $DatAlmacen->AlmNombre?></option>
                          <?php
			}
			?>
                          </select>
                        <span class="selectRequiredMsg">Debe escoger una opcion</span></span></td>
                      <td align="left" valign="top">&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left" valign="top">Responsable:</td>
                      <td align="left" valign="top"><select  class="EstFormularioCombo" name="CmpPersonal" id="CmpPersonal" >
                        <option value="">Escoja una opcion</option>
                        <?php
					foreach($ArrPersonales as $DatPersonal){
					?>
                        <option <?php echo ($DatPersonal->PerId==$InsTrasladoAlmacenSalida->PerId)?'selected="selected"':'';?>  value="<?php echo $DatPersonal->PerId;?>"><?php echo $DatPersonal->PerNombre ?> <?php echo $DatPersonal->PerApellidoPaterno; ?> <?php echo $DatPersonal->PerApellidoMaterno; ?></option>
                        <?php
					}
					?>
                      </select></td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td colspan="4" align="left" valign="top"><span class="EstFormularioSubTitulo">Datos de despacho</span></td>
                      <td align="left" valign="top">&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left" valign="top">Empresa de Transportes:</td>
                      <td align="left" valign="top"><input name="CmpEmpresaTransporte" type="text" class="EstFormularioCaja" id="CmpEmpresaTransporte" value="<?php echo $InsTrasladoAlmacenSalida->TasEmpresaTransporte;?>" size="45" maxlength="255" /></td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left" valign="top">Doc. Ref.</td>
                      <td align="left" valign="top"><input name="CmpEmpresaTransporteDocumento" type="text" class="EstFormularioCaja" id="CmpEmpresaTransporteDocumento" value="<?php echo $InsTrasladoAlmacenSalida->TasEmpresaTransporteDocumento;?>" size="20" maxlength="255" /></td>
                      <td align="left" valign="top">Fecha de Doc:<br />
                        <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
                      <td align="left" valign="top"><span id="sprytextfield1"><span id="sprytextfield2">
                        <input name="CmpEmpresaTransporteFecha" type="text" class="EstFormularioCajaFecha" id="CmpEmpresaTransporteFecha" value="<?php echo $InsTrasladoAlmacenSalida->TasEmpresaTransporteFecha; ?>" size="15" maxlength="10" />
                        <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no v&aacute;lido.</span></span><span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no v&aacute;lido.</span></span> <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnEmpresaTransporteFecha" name="BtnEmpresaTransporteFecha" width="25" height="25" align="absmiddle"  style="cursor:pointer;" /></td>
                      <td align="left" valign="top">&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left" valign="top">Tipo de Envio:</td>
                      <td align="left" valign="top"><input name="CmpEmpresaTransporteTipoEnvio" type="text" class="EstFormularioCaja" id="CmpEmpresaTransporteTipoEnvio" value="<?php echo $InsTrasladoAlmacenSalida->TasEmpresaTransporteTipoEnvio;?>" size="20" maxlength="45" /></td>
                      <td align="left" valign="top">Clave de envio:</td>
                      <td align="left" valign="top"><input name="CmpEmpresaTransporteClave" type="text" class="EstFormularioCaja" id="CmpEmpresaTransporteClave" value="<?php echo $InsTrasladoAlmacenSalida->TasEmpresaTransporteClave;?>" size="10" maxlength="10" /></td>
                      <td align="left" valign="top">&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td colspan="4" align="left" valign="top"><span class="EstFormularioSubTitulo">Observaciones y otras referencias</span></td>
                      <td align="left" valign="top">&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left" valign="top">Observaciones Internas:</td>
                      <td align="left" valign="top"><textarea name="CmpObservacion" cols="45" rows="2" class="EstFormularioCaja" id="CmpObservacion"><?php echo $InsTrasladoAlmacenSalida->TasObservacion;?></textarea></td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left" valign="top">Estado:</td>
                      <td align="left" valign="top"><?php
					switch($InsTrasladoAlmacenSalida->TasEstado){
						case 1:
							$OpcEstado1 = 'selected = "selected"';
						break;

						case 2:
							$OpcEstado2 = 'selected = "selected"';
						break;

						case 3:
							$OpcEstado3 = 'selected = "selected"';						
						break;
					}
					?>
                        <select  class="EstFormularioCombo" name="CmpEstado" id="CmpEstado" >
                          <option <?php echo $OpcEstado1;?> value="1">No Realizado</option>
                          <option <?php echo $OpcEstado3;?> value="3">Realizado</option>
                          </select></td>
                      <td align="left" valign="top"><span class="EstFormularioSubTitulo">
                        <input type="hidden" name="CmpIncluyeImpuesto" id="CmpIncluyeImpuesto"  value="<?php echo $InsTrasladoAlmacenSalida->TasIncluyeImpuesto;?>" />
                        <input type="hidden" name="CmpPorcentajeImpuestoVenta" id="CmpPorcentajeImpuestoVenta"  value="<?php echo $InsTrasladoAlmacenSalida->TasPorcentajeImpuestoVenta;?>" />
                        <input type="hidden" name="CmpDescuento" id="CmpDescuento"  value="<?php echo $InsTrasladoAlmacenSalida->TasDescuento;?>" />
                      
                       <input type="hidden" name="CmpClienteId" id="CmpClienteId"  value="<?php echo $InsTrasladoAlmacenSalida->CliId;?>" />
                       
                       </span></td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">&nbsp;</td>
                    </tr>
                    </table>
                  </div>     
                </td>
            </tr>
            
            <tr>
              <td valign="top">
                <div class="EstFormularioArea">
                  
                  <table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td width="98%">
                        
                        
                        
                        
                        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                          <tr>
                            <td>&nbsp;</td>
                            <td colspan="10"><span class="EstFormularioSubTitulo">PRODUCTOS </span><span class="EstFormularioSubTitulo">
<input type="hidden" name="CmpProductoId"    id="CmpProductoId"   />
<input type="hidden" name="CmpProductoItem" id="CmpProductoItem" />
<!--<input type="hidden" name="CmpProductoCostoAnterior" id="CmpProductoCostoAnterior" />-->
<input type="hidden" name="CmpProductoUnidadMedida" id="CmpProductoUnidadMedida" />
<input type="hidden" name="CmpProductoUnidadMedidaEquivalente"   id="CmpProductoUnidadMedidaEquivalente"  />
<input type="hidden" name="CmpProductoCostoAux"    id="CmpProductoCostoAux"    />
<input type="hidden" name="CmpTrasladoAlmacenSalidaDetalleId"  class="EstFormularioCaja" id="CmpTrasladoAlmacenSalidaDetalleId"  />
                            </span></td>
                            </tr>
                          <tr>
                            <td>&nbsp;</td>
                            <td><div id="CapProductoBuscar"></div></td>
                            <td>C&oacute;digo Orig.</td>
                            <td>&nbsp;</td>
                            <td>C&oacute;digo Alt.</td>
                            <td>&nbsp;</td>
                            <td>Nombre : </td>
                            <td>U.M.                              </td>
                            <td>Cantidad:</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            </tr>
                          <tr>
                            <td>&nbsp;</td>
                            <td><a href="javascript:FncTrasladoAlmacenSalidaDetalleNuevo();"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                            <td><input name="CmpProductoCodigoOriginal"  type="text" class="EstFormularioCaja" id="CmpProductoCodigoOriginal" size="10" maxlength="20" /></td>
                            <td><a href="javascript:FncProductoBuscar('CodigoOriginal');"><img src="imagenes/acciones/buscar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                            <td><input name="CmpProductoCodigoAlternativo"  type="text" class="EstFormularioCaja" id="CmpProductoCodigoAlternativo" size="10" maxlength="20" /></td>
                            <td><a href="javascript:FncProductoBuscar('CodigoAlternativo');"><img src="imagenes/acciones/buscar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                            <td><input name="CmpProductoNombre" type="text" class="EstFormularioCaja" id="CmpProductoNombre" size="40" /></td>
                            <td><select  class="EstFormularioCombo" name="CmpProductoUnidadMedidaConvertir" id="CmpProductoUnidadMedidaConvertir">
                            </select></td>
                            <td>
                              
                              <input name="CmpProductoCantidad" type="text" class="EstFormularioCaja" id="CmpProductoCantidad" size="10" maxlength="10"  />                            </td>
                            <td><a href="javascript:FncTrasladoAlmacenSalidaDetalleGuardar();"><img src="imagenes/acciones/guardar.png" width="25" height="25" border="0" title="Guardar" alt="[Guardar]" align="absmiddle" /></a></td>
                            <td><a href="comunes/Producto/FrmProductoBuscar.php?height=440&amp;width=850" class="thickbox" title=""><img src="imagenes/acciones/buscador.png" width="25" height="25" border="0" align="absmiddle" ></a></td>
                          </tr>
                          </table>                      
                          </td>
                      </tr>
                    </table>
                  </div>             
                  
                  
                   </td>
            </tr>
            
            <tr>
              <td valign="top"><div class="EstFormularioArea" >
                <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                  <tr>
                    <td width="1%"><input type="hidden" name="CmpTrasladoAlmacenSalidaDetalleAccion" id="CmpTrasladoAlmacenSalidaDetalleAccion" value="AccTrasladoAlmacenSalidaDetalleRegistrar.php" /></td>
                    <td width="48%"><div class="EstFormularioAccion" id="CapProductoAccion">Listo
                      para registrar elementos</div></td>
                    <td width="50%" align="right"><a href="javascript:FncTrasladoAlmacenSalidaDetalleListar();"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a> <a href="javascript:FncTrasladoAlmacenSalidaDetalleEliminarTodo();"><img  src="imagenes/acciones/listado_eliminar_todo.png"  width="25" height="25"  border="0" title="Eliminar Todo"   alt="[Eli. Todo.]" align="absmiddle"/> Eliminar Todo</a></td>
                    <td width="1%"><div id="CapTrasladoAlmacenSalidaDetallesResultado"> </div></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="2"><div id="CapTrasladoAlmacenSalidaDetalles" class="EstCapTrasladoAlmacenSalidaDetalles" > </div></td>
                    <td>&nbsp;</td>
                  </tr>
                  </table>
                </div></td>
            </tr>
            <tr>
              <td valign="top">&nbsp;</td>
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
	
	
	
  


<!--  -->
  
</form>

<script type="text/javascript">
	
Calendar.setup({ 
inputField : "CmpFecha",  // id del campo de texto 
ifFormat   : "%d/%m/%Y",  //  
button     : "BtnFecha"// el id del botón que  
});

Calendar.setup({ 
inputField : "CmpEmpresaTransporteFecha",  // id del campo de texto 
ifFormat   : "%d/%m/%Y",  //  
button     : "BtnEmpresaTransporteFecha"// el id del botón que  
});
	
</script>

<script type="text/javascript">
var spryselect4 = new Spry.Widget.ValidationSelect("spryselect4");
var spryselect = new Spry.Widget.ValidationSelect("spryselect");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "date");
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "date", {format:"dd/mm/yyyy"});
</script>
<?php

//$InsMensaje->MtdRedireccionar("principal.php?Mod=".$GET_mod."&Form=Listado",$Registro,1500);

}else{
	echo ERR_GEN_101;
}


if(!$_SESSION['MysqlDeb']){
	$InsMensaje->MtdRedireccionar("principal.php?Mod=".$GET_mod."&Form=Listado",$Registro,1500);
}


//ALERTAS
//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();
?>
