<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>   

<?php $PrivilegioMultisucursal = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Multisucursal"))?true:false;?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Proveedor');?>JsProveedorFuncionesv2.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Proveedor');?>JsProveedorAutocompletarv2.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Vehiculo");?>JsVehiculoIngresoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Vehiculo");?>JsVehiculoIngresoAutocompletar.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Moneda');?>JsMonedaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('TipoCambio');?>JsTipoCambioFunciones.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsVehiculoMovimientoEntradaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsVehiculoMovimientoEntradaDetalleFunciones.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsVehiculoMovimientoEntradaAutocompletar.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsVehiculoMovimientoEntradaFotoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsVehiculoMovimientoEntradaGuiaRemisionFotoFunciones.js" ></script>

<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssVehiculoMovimientoEntrada.css');
</style>

<?php

if(!empty($_POST['Identificador'])){
	$Identificador = $_POST['Identificador'];
}

$GET_OcoId = $_GET['OcoId'];
$GET_Ori = $_GET['Origen'];

$Registro = false;

include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjVehiculoMovimientoEntrada.php');
include($InsProyecto->MtdFormulariosMsj('Proveedor').'MsjProveedor.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoMovimientoEntrada.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoMovimientoEntradaDetalle.php');
require_once($InsPoo->MtdPaqLogistica().'ClsProveedor.php');
require_once($InsPoo->MtdPaqLogistica().'ClsComprobanteTipo.php');
require_once($InsPoo->MtdPaqLogistica().'ClsTipoOperacion.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');

require_once($InsPoo->MtdPaqLogistica().'ClsTipoDocumento.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCondicionPago.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculo.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsUnidadMedidaConversion.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsUnidadMedida.php');


require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsUnidadMedida.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacen.php');
require_once($InsPoo->MtdPaqEmpresa().'ClsSucursal.php');


$InsVehiculoMovimientoEntrada = new ClsVehiculoMovimientoEntrada();
$InsComprobanteTipo = new ClsComprobanteTipo();
$InsTipoOperacion = new ClsTipoOperacion();
$InsMoneda = new ClsMoneda();
$InsTipoDocumento = new ClsTipoDocumento();
$InsVehiculo = new ClsVehiculo();
$InsUnidadMedida = new ClsUnidadMedida();
$InsUnidadMedidaConversion = new ClsUnidadMedidaConversion();
$InsCondicionPago = new ClsCondicionPago();
$InsAlmacen = new ClsAlmacen();
$InsSucursal = new ClsSucursal();

if (!isset($_SESSION['InsVehiculoMovimientoEntradaDetalle'.$Identificador])){	
	$_SESSION['InsVehiculoMovimientoEntradaDetalle'.$Identificador] = new ClsSesionObjeto();
}else{	
	$_SESSION['InsVehiculoMovimientoEntradaDetalle'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsVehiculoMovimientoEntradaDetalle'.$Identificador]);
}


include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccVehiculoMovimientoEntradaRegistrar.php');

$ResComprobanteTipo = $InsComprobanteTipo->MtdObtenerComprobanteTipos(NULL,NULL,"CtiCodigo","ASC",NULL);
$ArrComprobanteTipos = $ResComprobanteTipo['Datos'];


$ResTipoOperacion = $InsTipoOperacion->MtdObtenerTipoOperaciones(NULL,NULL,"TopCodigo","ASC",NULL,"1,3");
$ArrTipoOperaciones = $ResTipoOperacion['Datos'];

$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","ASC",NULL);
$ArrMonedas = $ResMoneda['Datos'];

$RepTipoDocumento = $InsTipoDocumento->MtdObtenerTipoDocumentos(NULL,NULL,'TdoNombre',"ASC",NULL);
$ArrTipoDocumentos = $RepTipoDocumento['Datos'];

$RepCondicionPago = $InsCondicionPago->MtdObtenerCondicionPagos(NULL,NULL,"NpaNombre","ASC",NULL,1);
$ArrCondicionPagos = $RepCondicionPago['Datos'];


$RepAlmacen = $InsAlmacen->MtdObtenerAlmacenes(NULL,NULL,"AlmNombre","ASC",NULL);
$ArrAlmacenes = $RepAlmacen['Datos'];
//($oCampo=NULL,$oFiltro=NULL,$oOrden = 'AlmId',$oSentido = 'Desc',$oPaginacion = '0,10') 


$RepSucursal = $InsSucursal->MtdObtenerSucursales(NULL,NULL,"SucNombre","ASC",NULL);
$ArrSucursales = $RepSucursal['Datos'];


$ResUnidadMedida = $InsUnidadMedida->MtdObtenerUnidadMedidas(NULL,NULL,NULL,"UmeId","ASC",NULL,NULL);	
$ArrUnidadMedidas = $ResUnidadMedida['Datos'];
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

	//FncMonedaBuscar('Id');
	$('#CmpGuiaRemisionNumeroSerie').focus();
	
	FncVehiculoMovimientoEntradaEstablecerMoneda();
	
	FncVehiculoMovimientoEntradaDetalleListar();
	
	
	FncVehiculoMovimientoEntradaFotoListar();
	
	FncVehiculoMovimientoEntradaGuiaRemisionFotoListar();
	
});
/*
Configuracion Formulario
*/
//var MonedaFuncion = "FncVehiculoMovimientoEntradaDetalleListar";

var VehiculoMovimientoEntradaDetalleEditar = 1;
var VehiculoMovimientoEntradaDetalleEliminar = 1;

var VehiculoMovimientoEntradaGuiaRemisionFotoEditar = 1;
var VehiculoMovimientoEntradaGuiaRemisionFotoEliminar = 1;

var VehiculoMovimientoEntradaFotoEditar = 1;
var VehiculoMovimientoEntradaFotoEliminar = 1;

</script>





<form id="FrmRegistrar" name="FrmRegistrar" method="post" action="#" enctype="multipart/form-data" >

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
        COMPRA DE VEHICULO</span></td>
      </tr>
      <tr>
        <td colspan="2">
          
          
          
	<ul class="tabs">
        <li><a href="#tab1">Compra de Vehiculo</a></li>
        <li><a href="#tab2">Comprobante de Pago</a></li>
        
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
                        <span class="EstFormularioSubTitulo">Datos de la Compra de Vehiculo
                        <input type="hidden" name="Guardar" id="Guardar"   />
                        <input type="hidden" name="Identificador" id="Identificador"  value="<?php echo $Identificador; ?>" />
                        </span></td>
                      <td>&nbsp;</td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>

<input type="hidden" name="CmpTiempoRegistroInicio" id="CmpTiempoRegistroInicio"  value="<?php echo $InsVehiculoMovimientoEntrada->VmvTiempoRegistroInicio; ?>" />


                      </td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td align="center">&nbsp;</td>
                      <td>&nbsp;</td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left" valign="top">Codigo:</td>
                      <td align="left" valign="top"><input readonly="readonly" name="CmpId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpId" value="<?php echo $InsVehiculoMovimientoEntrada->VmvId;?>" size="15" maxlength="20" /></td>
                      <td align="left" valign="top">Fecha de Ingreso: <br><span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span> </td>
                      <td align="left" valign="top"><input class="EstFormularioCajaFecha" name="CmpFecha" type="text" id="CmpFecha" value="<?php if(empty($InsVehiculoMovimientoEntrada->VmvFecha)){ echo date("d/m/Y");}else{ echo $InsVehiculoMovimientoEntrada->VmvFecha; }?>" size="10" maxlength="10" />                        <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFecha" name="BtnFecha" width="25" height="25" align="absmiddle"  style="cursor:pointer;" /></td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left" valign="top">Tipo de Operacion:</td>
                      <td align="left" valign="top"><select disabled="disabled" class="EstFormularioCombo" name="CmpTipoOperacion" id="CmpTipoOperacion">
                        <option value="">Escoja una opcion</option>
                        <?php
			foreach($ArrTipoOperaciones as $DatTipoOperacion){
			?>
                        <option value="<?php echo $DatTipoOperacion->TopId?>" <?php if($InsVehiculoMovimientoEntrada->TopId ==$DatTipoOperacion->TopId){ echo 'selected="selected"';} ?> ><?php echo $DatTipoOperacion->TopCodigo?> - <?php echo $DatTipoOperacion->TopNombre?></option>
                        <?php
			}
			?>
                      </select></td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left" valign="top">Numero Guia de Remisi&oacute;n:</td>
                      <td align="left" valign="top"><input name="CmpGuiaRemisionNumeroSerie" type="text" class="EstFormularioCaja" id="CmpGuiaRemisionNumeroSerie" value="<?php echo $InsVehiculoMovimientoEntrada->VmvGuiaRemisionNumeroSerie;?>" size="10" maxlength="50" />
                        -
                        <input name="CmpGuiaRemisionNumeroNumero" type="text" class="EstFormularioCaja" id="CmpGuiaRemisionNumeroNumero" value="<?php echo $InsVehiculoMovimientoEntrada->VmvGuiaRemisionNumeroNumero;?>" size="20" maxlength="50" /></td>
                      <td align="left" valign="top">Fecha de Guia de Remision: <br />
                        <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
                      <td align="left" valign="top"><input class="EstFormularioCajaFecha" name="CmpGuiaRemisionFecha" type="text" id="CmpGuiaRemisionFecha" value="<?php echo $InsVehiculoMovimientoEntrada->VmvGuiaRemisionFecha; ?>" size="15" maxlength="10" />                        <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnGuiaRemisionFecha" name="BtnGuiaRemisionFecha" width="25" height="25" align="absmiddle"  style="cursor:pointer;" /></td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td valign="top">Guia Remision Escaneada:</td>
                      <td colspan="3"><div class="EstFormularioArea" >
                        <table border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                          <tr>
                            <td width="1%">&nbsp;</td>
                            <td width="48%"><a href="javascript:FncVehiculoMovimientoEntradaGuiaRemisionFotoListar();"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a> <a href="javascript:FncVehiculoMovimientoEntradaGuiaRemisionFotoEliminarTodo();"></a></td>
                            <td width="50%" align="right"><div class="EstFormularioAccion" id="CapVehiculoMovimientoEntradaGuiaRemisionFotosAccion">Listo
                              para registrar elementos</div></td>
                            <td width="1%">&nbsp;</td>
                          </tr>
                          <tr>
                            <td>&nbsp;</td>
                            <td colspan="2"><table border="0" cellpadding="0" cellspacing="0" class="EstFormulario">
                              <tr>
                                <td width="275" colspan="2" align="left" valign="top"><div id="fileUploadVehiculoMovimientoEntradaGuiaRemisionFoto">Escoger Archivo</div>
                                  <script type="text/javascript">
									
									$(document).ready(function(){
						
											$("#fileUploadVehiculoMovimientoEntradaGuiaRemisionFoto").uploadFile({
												
											allowedTypes:"png,gif,jpg,jpeg,pdf",
											url:"formularios/VehiculoMovimientoEntrada/acc/AccVehiculoMovimientoEntradaGuiaRemisionFotoSubir.php",
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
												FncVehiculoMovimientoEntradaGuiaRemisionFotoListar ();
											}
							
										});
									});
									  
									</script></td>
                                <td width="4" align="left" valign="top">&nbsp;</td>
                              </tr>
                              <tr>
                                <td colspan="2" align="left" valign="top"><div class="EstCapVehiculoMovimientoEntradaGuiaRemisionFotos" id="CapVehiculoMovimientoEntradaGuiaRemisionFotos"></div></td>
                                <td align="left" valign="top">&nbsp;</td>
                              </tr>
                            </table></td>
                            <td><div id="CapVehiculoMovimientoEntradaGuiaRemisionFotosResultado"> </div></td>
                          </tr>
                        </table>
                      </div></td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left" valign="top">Observacion:</td>
                      <td align="left" valign="top"><textarea name="CmpObservacion" cols="45" rows="2" class="EstFormularioCaja" id="CmpObservacion"><?php echo $InsVehiculoMovimientoEntrada->VmvObservacion;?></textarea></td>
                      <td align="left" valign="top">Sucursal Destino:</td>
                      <td align="left" valign="top"><!--<select class="EstFormularioCombo" name="CmpAlmacen" id="CmpAlmacen">
                        <option value="">Escoja una opcion</option>
                        <?php
			foreach($ArrAlmacenes as $DatAlmacen){
			?>
                        <option value="<?php echo $DatAlmacen->AlmId?>" <?php if($InsVehiculoMovimientoEntrada->AlmId==$DatAlmacen->AlmId){ echo 'selected="selected"';} ?> ><?php echo $DatAlmacen->AlmNombre?></option>
                        <?php
			}
			?>
                      </select>-->
                      
                      <select <?php echo (($PrivilegioMultisucursal)?'':'disabled="disabled"');?>    class="EstFormularioCombo" name="CmpSucursal" id="CmpSucursal">
                    <option value="">Escoja una opcion</option>
                    <?php
    foreach($ArrSucursales as $DatSucursal){
    ?>
                    <option value="<?php echo $DatSucursal->SucId;?>" <?php if($InsVehiculoMovimientoEntrada->SucId==$DatSucursal->SucId){ echo 'selected="selected"';} ?> ><?php echo $DatSucursal->SucNombre;?></option>
                    <?php
    }
    ?>
                  </select>
                  
                  </td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left" valign="top">Estado: </td>
                      <td align="left" valign="top"><?php
					switch($InsVehiculoMovimientoEntrada->VmvEstado){
						case 1:
							$OpcEstado1 = 'selected = "selected"';
						break;

						case 3:
							$OpcEstado3 = 'selected = "selected"';						
						break;
					}
					?>
                        <select  class="EstFormularioCombo" name="CmpEstado" id="CmpEstado">
                          <option <?php echo $OpcEstado1;?> value="1">No Realizado</option>
                          <option <?php echo $OpcEstado3;?> value="3">Realizado</option>
                          </select></td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td colspan="4" valign="top"><span class="EstFormularioSubTitulo">Opciones Adicionales:</span></td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td valign="top"><input <?php echo (!empty($InsVehiculoMovimientoEntrada->OcoId)?'checked="checked"':'');?>  type="checkbox" name="CmpNotificar" id="CmpNotificar" value="1"  />
                        Notificar via email</td>
                      <td>
                      <td>                      
                          <td>                      
                          <td>&nbsp;</td>
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
                            <td colspan="18"><span class="EstFormularioSubTitulo">VEHICULOS</span>
                              <input name="CmpVehiculoId"  type="hidden" class="EstFormularioCaja" id="CmpVehiculoId" size="10" maxlength="20" />
<input type="hidden" name="CmpVehiculoItem" id="CmpVehiculoItem" />
<input type="hidden" name="CmpVehiculoCostoAnterior" id="CmpVehiculoCostoAnterior" />
<input type="hidden" name="CmpVehiculoUnidadMedida" id="CmpVehiculoUnidadMedida" />
<input name="CmpVehiculoUnidadMedidaEquivalente"  type="hidden" class="EstFormularioCaja" id="CmpVehiculoUnidadMedidaEquivalente" size="3" maxlength="20"  />
                              <input name="CmpVehiculoMovimientoEntradaDetalleId"  type="hidden" class="EstFormularioCaja" id="CmpVehiculoMovimientoEntradaDetalleId" size="3" maxlength="20"  /></td>
                            </tr>
                          <tr>
                            <td>&nbsp;</td>
                            <td valign="top"><div id="CapVehiculoIngresoBuscar"></div></td>
                            <td valign="top">VIN:
                              <input name="CmpVehiculoIngresoId" type="hidden" id="CmpVehiculoIngresoId" value="" size="3" /></td>
                            <td valign="top">&nbsp;</td>
                            <td align="left" valign="top">&nbsp;</td>
                            <td align="left" valign="top">Codigo Unico:
                              <input name="CmpVehiculoId" type="hidden" id="CmpVehiculoId" size="3" /></td>
                            <td align="left" valign="top">Marca:
                              <input name="CmpVehiculoIngresoMarcaId" type="hidden" id="CmpVehiculoIngresoMarcaId" size="3" /></td>
                            <td align="left" valign="top">Modelo:
                              <input name="CmpVehiculoIngresoModeloId" type="hidden" id="CmpVehiculoIngresoModeloId" size="3" /></td>
                            <td align="left" valign="top">Version:
                              <input name="CmpVehiculoIngresoVersionId" type="hidden" id="CmpVehiculoIngresoVersionId" size="3" /></td>
                            <td valign="top">Color Exterior:</td>
                            <td valign="top">Color Interior:</td>
                            <td align="left" valign="top">A&ntilde;o /Fab.</td>
                            <td align="left" valign="top">A&ntilde;o/Mod.</td>
                            <td valign="top">U.M.</td>
                            <td valign="top">Cantidad:</td>
                            
                            <td valign="top">
                              Valor Unit.:</td>
                            <td valign="top">
                              Valor Total:</td>
                            <td valign="top">&nbsp;</td>
                            <td valign="top">&nbsp;</td>
                            </tr>
                          <tr>
                            <td>&nbsp;</td>
                            <td valign="middle"><a href="javascript:FncVehiculoMovimientoEntradaDetalleNuevo();"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                            <td valign="middle"><input name="CmpVehiculoIngresoVIN" type="text" class="EstFormularioCaja" id="CmpVehiculoIngresoVIN" value="" size="15" maxlength="30"  /></td>
                            <td valign="middle"><a href="javascript:FncVehiculoIngresoBuscar('VIN');"><img src="imagenes/acciones/buscar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                            <td align="left" valign="middle"><a id="BtnVehiculoIngresoRegistrar" onclick="FncVehiculoIngresoCargarFormulario('Registrar');" href="javascript:void(0)" title=""> <img src="imagenes/acciones/registrar.png" alt="[Registrar]" width="25" height="25" border="0" align="absmiddle" title="Registrar" /> </a> <a id="BtnVehiculoIngresoEditar" onclick="FncVehiculoIngresoCargarFormulario('Editar');" href="javascript:void(0)"   title=""> <img src="imagenes/acciones/editar.png" alt="[Editar]" width="25" height="25" border="0" align="absmiddle" title="Editar" /> </a></td>
                            <td align="left" valign="middle"><input class="EstFormularioCajaDeshabilitada" name="CmpVehiculoCodigoIdentificador" type="text" id="CmpVehiculoCodigoIdentificador" size="8" maxlength="30" /></td>
                            <td align="left" valign="middle"><input name="CmpVehiculoIngresoMarca" type="text" class="EstFormularioCajaDeshabilitada" id="CmpVehiculoIngresoMarca" size="10" maxlength="30" readonly="readonly" /></td>
                            <td align="left" valign="middle"><input name="CmpVehiculoIngresoModelo" type="text" class="EstFormularioCajaDeshabilitada" id="CmpVehiculoIngresoModelo" size="10" maxlength="30" readonly="readonly" /></td>
                            <td align="left" valign="middle"><input name="CmpVehiculoIngresoVersion" type="text" class="EstFormularioCajaDeshabilitada" id="CmpVehiculoIngresoVersion" size="10" maxlength="30" readonly="readonly" /></td>
                            <td valign="middle"><input class="EstFormularioCajaDeshabilitada" name="CmpVehiculoIngresoColor" type="text" id="CmpVehiculoIngresoColor" size="8" maxlength="30" /></td>
                            <td valign="middle"><input class="EstFormularioCajaDeshabilitada" name="CmpVehiculoIngresoColorInterior" type="text" id="CmpVehiculoIngresoColorInterior" size="8" maxlength="30" /></td>
                            <td align="left" valign="middle"><input class="EstFormularioCajaDeshabilitada" name="CmpVehiculoIngresoAnoFabricacion" type="text" id="CmpVehiculoIngresoAnoFabricacion" size="7" maxlength="4" /></td>
                            <td align="left" valign="middle"><input class="EstFormularioCajaDeshabilitada" name="CmpVehiculoIngresoAnoModelo" type="text" id="CmpVehiculoIngresoAnoModelo" size="7" maxlength="4" /></td>
                            <td valign="middle">
                            

<select disabled="disabled" class="EstFormularioCombo" name="CmpVehiculoMovimientoEntradaDetalleUnidadMedida" id="CmpVehiculoMovimientoEntradaDetalleUnidadMedida">
              <option value="">Escoja una opcion</option>
              <?php
			foreach($ArrUnidadMedidas as $DatUnidadMedida){
			?>
              <option  value="<?php echo $DatUnidadMedida->UmeId?>"><?php echo $DatUnidadMedida->UmeNombre?></option>
              <?php
			}
			?>
            </select>
            
            
            </td>
                            <td valign="middle">
                              
                              <input name="CmpVehiculoMovimientoEntradaDetalleCantidad" type="text" class="EstFormularioCaja" id="CmpVehiculoMovimientoEntradaDetalleCantidad" size="8" maxlength="10" />                            </td>
                            <td valign="middle"><input name="CmpVehiculoMovimientoEntradaDetalleCosto" type="text" class="EstFormularioCajaDeshabilitada" id="CmpVehiculoMovimientoEntradaDetalleCosto" size="8" maxlength="10" readonly="readonly" />                            </td>
                            <td valign="middle">
                              
                              <input name="CmpVehiculoMovimientoEntradaDetalleImporte" type="text" class="EstFormularioCaja" id="CmpVehiculoMovimientoEntradaDetalleImporte" size="8" maxlength="10" />                            </td>
                            <td valign="middle"><a href="javascript:FncVehiculoMovimientoEntradaDetalleGuardar();"><img src="imagenes/acciones/guardar.png" width="25" height="25" border="0" title="Guardar" alt="[Guardar]" align="absmiddle" /></a></td>
                            <td valign="middle">
                            
                            <!--<a href="comunes/Vehiculo/FrmVehiculoBuscar.php?height=440&amp;width=850" class="thickbox" title=""><img src="imagenes/acciones/buscador.png" width="25" height="25" border="0" align="absmiddle" ></a>
                            -->
                            
                            </td>
                          </tr>
                          </table>                      </td>
                      </tr>
                    </table>
                  </div>              </td>
            </tr>
            
            <tr>
              <td valign="top"><div class="EstFormularioArea" >
                <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                  <tr>
                    <td width="1%">&nbsp;</td>
                    <td width="49%"><div class="EstFormularioAccion" id="CapVehiculoAccion">Listo
                      para registrar elementos</div></td>
                    <td width="49%" align="right"><a href="javascript:FncVehiculoMovimientoEntradaDetalleListar();">
                      <input type="hidden" name="CmpVehiculoMovimientoEntradaDetalleAccion" id="CmpVehiculoMovimientoEntradaDetalleAccion" value="AccVehiculoMovimientoEntradaDetalleRegistrar.php" />
                      <img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a>
                    
                    <!--<a href="javascript:FncVehiculoMovimientoEntradaDetalleEliminarTodo();"><img  src="imagenes/acciones/listado_eliminar_todo.png"  width="25" height="25"  border="0" title="Eliminar Todo"   alt="[Eli. Todo.]" align="absmiddle"/> Eliminar Todo</a>--></td>
                    <td width="1%"><div id="CapVehiculoMovimientoEntradaDetallesResultado"> </div></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="2"><div id="CapVehiculoMovimientoEntradaDetalles" class="EstCapVehiculoMovimientoEntradaDetalles" > </div></td>
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
	<div id="tab2" class="tab_content">
       <!--Content-->
	<table width="100%" border="0" cellpadding="2" cellspacing="2">
	<tr>
		<td width="97%" valign="top">
        
                  <div class="EstFormularioArea">
                <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="4"><span class="EstFormularioSubTitulo">Datos del Comprobante de Pago</span></td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="4" align="left" valign="top">Proveedor:</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td align="left" valign="top">
                      <select class="EstFormularioCombo" name="CmpProveedorTipoDocumento" id="CmpProveedorTipoDocumento" disabled="disabled">
                        <option value="">Escoja una opcion</option>
                        <?php
			foreach($ArrTipoDocumentos as $DatTipoDocumento){
			?>
                        <option <?php echo $DatTipoDocumento->TdoId;?> <?php echo ($DatTipoDocumento->TdoId==$InsVehiculoMovimientoEntrada->TdoId)?'selected="selected"':"";?> value="<?php echo $DatTipoDocumento->TdoId?>"><?php echo $DatTipoDocumento->TdoCodigo?> - <?php echo $DatTipoDocumento->TdoNombre?></option>
                        <?php
			}
			?>
                      </select>
:
<input name="CmpProveedorId" type="hidden" id="CmpProveedorId" value="<?php echo $InsVehiculoMovimientoEntrada->PrvId;?>" size="3" /></td>
                    <td align="left" valign="top">
                      
                      <table border="0" cellpadding="0" cellspacing="0">
                        <tr>
                          <td><a href="javascript:FncProveedorNuevo('','');"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></a></td>
                          <td><input name="CmpProveedorNumeroDocumento" type="text" class="EstFormularioCaja" id="CmpProveedorNumeroDocumento"  value="<?php echo $InsVehiculoMovimientoEntrada->PrvNumeroDocumento;?>" size="20" maxlength="50" /></td>
                          <td><a href="javascript:FncProveedorBuscar('NumeroDocumento');"><img src="imagenes/acciones/buscar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                          <td> <a id="BtnProveedorRegistrar" onclick="FncProveedorCargarFormulario('Registrar','','');"  href="javascript:void(0)" title=""> <img src="imagenes/acciones/registrar.png" alt="[Registrar]" width="25" height="25" border="0" align="absmiddle" title="Registrar" /></a> <a id="BtnProveedorEditar" onclick="FncProveedorCargarFormulario('Editar','','');" href="javascript:void(0)"   title="">
                            <img src="imagenes/acciones/editar.png" alt="[Editar]" width="25" height="25" border="0" align="absmiddle" title="Editar" />
                            </a>
                            
                            </td>
                          <td><div id="CapProveedorBuscar"></div>
                            
                            </td>
                          </tr>
                        </table></td>
                    <td align="left" valign="top">Proveedor:
                      <input class="EstFormularioCaja" name="CmpProveedorNombre" type="hidden" id="CmpProveedorNombre" value="<?php echo $InsVehiculoMovimientoEntrada->PrvNombre;?>" size="45" maxlength="255"  />
                      <input class="EstFormularioCaja" name="CmpProveedorApellidoPaterno" type="hidden" id="CmpProveedorApellidoPaterno" value="<?php echo $InsVehiculoMovimientoEntrada->PrvApellidoPaterno;?>" size="45" maxlength="255"  />
                      <input class="EstFormularioCaja" name="CmpProveedorApellidoMaterno" type="hidden" id="CmpProveedorApellidoMaterno" value="<?php echo $InsVehiculoMovimientoEntrada->PrvApellidoMaterno;?>" size="45" maxlength="255"  /></td>
                    <td align="left" valign="top">
                      
                      
                      
                      <table border="0" cellpadding="0" cellspacing="0">
                        <tr>
                          <td><a href="javascript:FncProveedorNuevo('','');"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></a></td>
                          <td><input class="EstFormularioCaja" name="CmpProveedorNombreCompleto" type="text" id="CmpProveedorNombreCompleto" value="<?php echo $InsVehiculoMovimientoEntrada->PrvNombreCompleto;?>" size="45" maxlength="255"  />
                            <a href="formularios/VehiculoMovimientoEntrada/FrmProveedorBuscar.php?height=440&width=850" class="thickbox" title="">
                              <img src="imagenes/acciones/buscador.png" width="25" height="25" border="0" align="absmiddle" ></a>
                            
                            
                            </td>
                          </tr>
                        </table>                        
                      
                      
                      
                      
                      </td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="4" align="left" valign="top">Comporbante:</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td align="left" valign="top">Tipo de Comprobante:</td>
                    <td align="left" valign="top"><select class="EstFormularioCombo" name="CmpComprobanteTipo" id="CmpComprobanteTipo">
                      <option value="">Escoja una opcion</option>
                      <?php
			foreach($ArrComprobanteTipos as $DatComprobanteTipo){
			?>
                      <option value="<?php echo $DatComprobanteTipo->CtiId?>" <?php if($InsVehiculoMovimientoEntrada->CtiId==$DatComprobanteTipo->CtiId){ echo 'selected="selected"';} ?> ><?php echo $DatComprobanteTipo->CtiCodigo?> - <?php echo $DatComprobanteTipo->CtiNombre?></option>
                      <?php
			}
			?>
                    </select></td>
                    <td align="left" valign="top">&nbsp;</td>
                    <td align="left" valign="top">&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td align="left" valign="top">Numero de Comprobante:</td>
                    <td align="left" valign="top"> <input name="CmpComprobanteNumeroSerie" type="text" class="EstFormularioCaja" id="CmpComprobanteNumeroSerie" value="<?php echo $InsVehiculoMovimientoEntrada->VmvComprobanteNumeroSerie;?>" size="10" maxlength="50" />
- 
  <input name="CmpComprobanteNumeroNumero" type="text" class="EstFormularioCaja" id="CmpComprobanteNumeroNumero" value="<?php echo $InsVehiculoMovimientoEntrada->VmvComprobanteNumeroNumero;?>" size="20" maxlength="50" /></td>
                    <td align="left" valign="top">Fecha de Comprobante: <br><span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
                    <td align="left" valign="top"><input class="EstFormularioCajaFecha" name="CmpComprobanteFecha" type="text" id="CmpComprobanteFecha" value="<?php echo $InsVehiculoMovimientoEntrada->VmvComprobanteFecha;?>" size="15" maxlength="10" />                      <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnComprobanteFecha" name="BtnComprobanteFecha" width="25" height="25" align="absmiddle"  style="cursor:pointer;" /></td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td align="left" valign="top">Condicion de Pago:</td>
                    <td align="left" valign="top"><select name="CmpCondicionPago" id="CmpCondicionPago" class="EstFormularioCombo" >
                      <option value="">Escoja una opcion</option>
                      <?php
					foreach($ArrCondicionPagos as $DatCondicionPago){
					?>
                      <option <?php if($InsVehiculoMovimientoEntrada->NpaId==$DatCondicionPago->NpaId){ echo 'selected="selected"';}?> value="<?php echo $DatCondicionPago->NpaId;?>"><?php echo $DatCondicionPago->NpaNombre;?></option>
                      <?php  
					}
					?>
                    </select></td>
                    <td align="left" valign="top">Cantidad de Dias:</td>
                    <td align="left" valign="top"><input class="EstFormularioCaja" name="CmpCantidadDia" type="text" id="CmpCantidadDia" size="10" maxlength="3" value="<?php echo $InsVehiculoMovimientoEntrada->VmvCantidadDia;?>" /></td>
                    <td align="left" valign="top">&nbsp;</td>
                    </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td align="left" valign="top">Moneda:                      </td>
                    <td align="left" valign="top"><table border="0" cellpadding="0" cellspacing="0">
                      <tr>
                        <td><span id="spryselect2">
                          <select class="EstFormularioCombo" name="CmpMonedaId" id="CmpMonedaId">
                            <option value="">Escoja una opcion</option>
                            <?php
			  foreach($ArrMonedas as $DatMoneda){
			  ?>
                            <option value="<?php echo $DatMoneda->MonId?>" <?php if($InsVehiculoMovimientoEntrada->MonId==$DatMoneda->MonId){ echo 'selected="selected"';}elseif($EmpresaMonedaId==$DatMoneda->MonId){  echo 'selected="selected"';}?> ><?php echo $DatMoneda->MonNombre?> ( <?php echo $DatMoneda->MonSimbolo;?>)</option>
                            <?php
			  }
			  ?>
                            </select>
                          <span class="selectRequiredMsg"><img src="imagenes/advertencia.png" width="20" height="20" border="0" align="absmiddle" title="Debe seleccionar un elemento" alt="[A]"  /></span></span></td>
                        <td><div id="CapMonedaBuscar"></div></td>
                        </tr>
                      </table>
                      
                      </td>
                    <td align="left" valign="top">Tipo de Cambio: <br />
                      <span class="EstFormularioSubEtiqueta"> (0.000)</span></td>
                    <td align="left" valign="top">
                    
                    
                    <table>
                    <tr>
                    <td>
                    <input name="CmpTipoCambio" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpTipoCambio" onchange="FncVehiculoMovimientoEntradaDetalleListar();" value="<?php if (empty($InsVehiculoMovimientoEntrada->VmvTipoCambio)){ echo "";}else{ echo $InsVehiculoMovimientoEntrada->VmvTipoCambio; } ?>" size="10" maxlength="10" readonly="readonly" />
                    
                    
                    <input name="CmpTipoCambioComercial" type="hidden"  class="EstFormularioCajaDeshabilitada" id="CmpTipoCambioComercial" value="<?php if (empty($InsVehiculoMovimientoEntrada->VmvTipoCambioComercial)){ echo "";}else{ echo $InsVehiculoMovimientoEntrada->VmvTipoCambioComercial; } ?>" size="10" maxlength="10" />
                    
                    </td>
                    <td>
                    <a href="javascript:FncVehiculoMovimientoEntradaEstablecerMoneda();"><img src="imagenes/acciones/recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /></a>
                    
                    </td>
                    </tr>
                    </table>
                    
                    </td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="4" valign="top">Adjuntos:</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td align="left" valign="top">Comprobante Escaneado:</td>
                    <td colspan="3" align="left" valign="top"><div class="EstFormularioArea" >
                      <table border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                        <tr>
                          <td width="1%">&nbsp;</td>
                          <td width="48%"><a href="javascript:FncVehiculoMovimientoEntradaFotoListar();"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a> <a href="javascript:FncVehiculoMovimientoEntradaFotoEliminarTodo();"></a></td>
                          <td width="50%" align="right"><div class="EstFormularioAccion" id="CapVehiculoMovimientoEntradaFotosAccion">Listo
                            para registrar elementos</div></td>
                          <td width="1%">&nbsp;</td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td colspan="2"><table border="0" cellpadding="0" cellspacing="0" class="EstFormulario">
                            <tr>
                              <td width="275" colspan="2" align="left" valign="top"><div id="fileUploadVehiculoMovimientoEntradaFoto">Escoger Archivo</div>
                                <script type="text/javascript">
									
									$(document).ready(function(){
						
											$("#fileUploadVehiculoMovimientoEntradaFoto").uploadFile({
												
											allowedTypes:"png,gif,jpg,jpeg,pdf",
											url:"formularios/VehiculoMovimientoEntrada/acc/AccVehiculoMovimientoEntradaFotoSubir.php",
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
												FncVehiculoMovimientoEntradaFotoListar ();
											}
							
										});
									});
									  
									</script></td>
                              <td width="4" align="left" valign="top">&nbsp;</td>
                            </tr>
                            <tr>
                              <td colspan="2" align="left" valign="top"><div class="EstCapVehiculoMovimientoEntradaFotos" id="CapVehiculoMovimientoEntradaFotos"></div></td>
                              <td align="left" valign="top">&nbsp;</td>
                            </tr>
                          </table></td>
                          <td><div id="CapVehiculoMovimientoEntradaFotosResultado"> </div></td>
                        </tr>
                      </table>
                    </div></td>
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
Calendar.setup({ 
	inputField : "CmpFecha",  // id del campo de texto 
	ifFormat   : "%d/%m/%Y",  //  
	button     : "BtnFecha"// el id del botón que  
	});
	
Calendar.setup({ 
	inputField : "CmpComprobanteFecha",  // id del campo de texto 
	ifFormat   : "%d/%m/%Y",  //  
	button     : "BtnComprobanteFecha",// el id del botón que  
	onUpdate       :    FncTipoCambioCargarAux
	});
	
Calendar.setup({ 
	inputField : "CmpGuiaRemisionFecha",  // id del campo de texto 
	ifFormat   : "%d/%m/%Y",  //  
	button     : "BtnGuiaRemisionFecha"// el id del botón que  
	});

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


if(!$_SESSION['MysqlDeb']){
	$InsMensaje->MtdRedireccionar("principal.php?Mod=".$GET_mod."&Form=Listado",$Registro,1500);
}
?>
