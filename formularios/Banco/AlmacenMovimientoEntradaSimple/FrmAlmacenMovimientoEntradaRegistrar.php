<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>   

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Proveedor');?>JsProveedorFunciones.js" ></script>
<!--<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Proveedor');?>JsProveedorAutocompletar.js" ></script>-->

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Producto");?>JsProductoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Producto");?>JsProductoAutocompletar.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Moneda');?>JsMonedaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('TipoCambio');?>JsTipoCambioFunciones.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsAlmacenMovimientoEntradaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsAlmacenMovimientoEntradaDetalleFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsAlmacenMovimientoEntradaCostoVinculadoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsAlmacenMovimientoEntradaAutocompletar.js" ></script>

<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssAlmacenMovimientoEntrada.css');
</style>


<?php
if(!empty($_POST['Identificador'])){
	$Identificador = $_POST['Identificador'];
}

$GET_OcoId = $_GET['OcoId'];
$GET_Ori = $_GET['Origen'];

$Registro = false;

include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjAlmacenMovimientoEntrada.php');
include($InsProyecto->MtdFormulariosMsj('Proveedor').'MsjProveedor.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoEntrada.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoEntradaDetalle.php');
require_once($InsPoo->MtdPaqLogistica().'ClsProveedor.php');
require_once($InsPoo->MtdPaqLogistica().'ClsComprobanteTipo.php');
require_once($InsPoo->MtdPaqLogistica().'ClsTipoOperacion.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');



require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompra.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompraDetalle.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompraPedido.php');



require_once($InsPoo->MtdPaqLogistica().'ClsPedidoCompra.php');
require_once($InsPoo->MtdPaqLogistica().'ClsPedidoCompraDetalle.php');
require_once($InsPoo->MtdPaqLogistica().'ClsTipoDocumento.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCondicionPago.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsProducto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoCodigoReemplazo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsUnidadMedidaConversion.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsUnidadMedida.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVentaConcretada.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVentaDirecta.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVentaDirectaDetalle.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVentaDirectaTarea.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVentaDirectaFoto.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsProducto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsUnidadMedida.php');



require_once($InsPoo->MtdPaqAlmacen().'ClsVentaConcretada.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVentaConcretadaDetalle.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacen.php');


$InsAlmacenMovimientoEntrada = new ClsAlmacenMovimientoEntrada();
$InsComprobanteTipo = new ClsComprobanteTipo();
$InsTipoOperacion = new ClsTipoOperacion();
$InsMoneda = new ClsMoneda();
$InsTipoDocumento = new ClsTipoDocumento();
$InsProducto = new ClsProducto();
$InsUnidadMedida = new ClsUnidadMedida();
$InsUnidadMedidaConversion = new ClsUnidadMedidaConversion();
$InsCondicionPago = new ClsCondicionPago();
$InsAlmacen = new ClsAlmacen();

if (!isset($_SESSION['InsAlmacenMovimientoEntradaDetalle'.$Identificador])){	
	$_SESSION['InsAlmacenMovimientoEntradaDetalle'.$Identificador] = new ClsSesionObjeto();
}else{	
	$_SESSION['InsAlmacenMovimientoEntradaDetalle'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsAlmacenMovimientoEntradaDetalle'.$Identificador]);
}

if (!isset($_SESSION['InsOrdenCompraPedido'.$Identificador])){	
	$_SESSION['InsOrdenCompraPedido'.$Identificador] = new ClsSesionObjeto();
}else{	
	$_SESSION['InsOrdenCompraPedido'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsOrdenCompraPedido'.$Identificador]);
}


include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccAlmacenMovimientoEntradaRegistrar.php');

$ResComprobanteTipo = $InsComprobanteTipo->MtdObtenerComprobanteTipos(NULL,NULL,"CtiCodigo","ASC",NULL);
$ArrComprobanteTipos = $ResComprobanteTipo['Datos'];

$ResTipoOperacion = $InsTipoOperacion->MtdObtenerTipoOperaciones(NULL,NULL,"TopCodigo","ASC",NULL);
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

?>


<script src="../../../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
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
	$('#CmpFecha').focus();
	
	FncAlmacenMovimientoEntradaEstablecerDocumentoOrigen();
	
	FncAlmacenMovimientoEntradaEstablecerMoneda();
	
	
	FncAlmacenMovimientoEntradaDetalleListar();
	
	FncAlmacenMovimientoEntradaCostoVinculadoListar();
	
});
/*
Configuracion Formulario
*/
//var MonedaFuncion = "FncAlmacenMovimientoEntradaDetalleListar";

var AlmacenMovimientoEntradaDetalleEditar = 1;
var AlmacenMovimientoEntradaDetalleEliminar = 1;
</script>






<link href="../../../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />

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
        ENTRADA A ALMACEN</span></td>
      </tr>
      <tr>
        <td colspan="2">
          
          
          
	<ul class="tabs">
        <li><a href="#tab1">Entrada a Almacen</a></li>
        <li><a href="#tab2">Comprobante de Pago</a></li>
        <li><a href="#tab3">Costos Vinculados</a></li>
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
                        <span class="EstFormularioSubTitulo">Datos de la Entrada a Almacen
                        <input type="hidden" name="Guardar" id="Guardar"   />
                        <input type="hidden" name="Identificador" id="Identificador"  value="<?php echo $Identificador; ?>" />
                        </span></td>
                      <td>&nbsp;</td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>

<input type="hidden" name="CmpTiempoRegistroInicio" id="CmpTiempoRegistroInicio"  value="<?php echo $InsAlmacenMovimientoEntrada->AmoTiempoRegistroInicio; ?>" />


                      </td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td align="center">&nbsp;</td>
                      <td>&nbsp;</td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left" valign="top">Codigo:</td>
                      <td align="left" valign="top"><input readonly="readonly" name="CmpId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpId" value="<?php echo $InsAlmacenMovimientoEntrada->AmoId;?>" size="15" maxlength="20" /></td>
                      <td align="left" valign="top">Fecha de Ingreso: <br><span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span> </td>
                      <td align="left" valign="top"><span id="sprytextfield1">
                        <label>
                          <input class="EstFormularioCajaFecha" name="CmpFecha" type="text" id="CmpFecha" value="<?php if(empty($InsAlmacenMovimientoEntrada->AmoFecha)){ echo date("d/m/Y");}else{ echo $InsAlmacenMovimientoEntrada->AmoFecha; }?>" size="15" maxlength="10" />
                          </label>
                        <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg"><img src="imagenes/advertencia.png" width="20" height="20" border="0" align="absmiddle" title="Formato no valido" alt="[A]"  /></span></span><img src="imagenes/calendar.gif" alt="[Calendario]" id="BtnFecha" name="BtnFecha" width="18" height="18" align="absmiddle"  style="cursor:pointer;" /></td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left" valign="top">Tipo de Operacion:</td>
                      <td align="left" valign="top"><span id="spryselect">
                        <select class="EstFormularioCombo" name="CmpTipoOperacion" id="CmpTipoOperacion">
                          <option value="">Escoja una opcion</option>
                          <?php
			foreach($ArrTipoOperaciones as $DatTipoOperacion){
			?>
                          <option value="<?php echo $DatTipoOperacion->TopId?>" <?php if($InsAlmacenMovimientoEntrada->TopId==$DatTipoOperacion->TopId){ echo 'selected="selected"';} ?> ><?php echo $DatTipoOperacion->TopCodigo?> - <?php echo $DatTipoOperacion->TopNombre?></option>
                          <?php
			}
			?>
                          </select>
                        <span class="selectRequiredMsg">Debe escoger una opcion</span></span></td>
                      <td align="left" valign="top">Ord. Compra:</td>
                      <td align="left" valign="top">
                        
                        <input name="CmpOrdenCompra" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpOrdenCompra" value="<?php  echo $InsAlmacenMovimientoEntrada->OcoId;  ?>" size="20" maxlength="20" readonly="readonly" />
                        
                        
                        </td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left" valign="top">Numero Guia de Remisi&oacute;n:</td>
                      <td align="left" valign="top"><input name="CmpGuiaRemisionNumeroSerie" type="text" class="EstFormularioCaja" id="CmpGuiaRemisionNumeroSerie" value="<?php echo $InsAlmacenMovimientoEntrada->AmoGuiaRemisionNumeroSerie;?>" size="10" maxlength="50" />
                        -
                        <input name="CmpGuiaRemisionNumeroNumero" type="text" class="EstFormularioCaja" id="CmpGuiaRemisionNumeroNumero" value="<?php echo $InsAlmacenMovimientoEntrada->AmoGuiaRemisionNumeroNumero;?>" size="20" maxlength="50" /></td>
                      <td align="left" valign="top">Fecha de Guia de Remision: <br />
                        <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
                      <td align="left" valign="top"><span id="sprytextfield8">
                        <label>
                          <input class="EstFormularioCajaFecha" name="CmpGuiaRemisionFecha" type="text" id="CmpGuiaRemisionFecha" value="<?php echo $InsAlmacenMovimientoEntrada->AmoGuiaRemisionFecha; ?>" size="15" maxlength="10" />
                        </label>
                        <span class="textfieldInvalidFormatMsg"><img src="imagenes/advertencia.png" alt="" title="Formato no valido"  border="0" align="absmiddle"  /></span></span> <img src="imagenes/calendar.gif" alt="[Calendario]" id="BtnGuiaRemisionFecha" name="BtnGuiaRemisionFecha" width="18" height="18" align="absmiddle"  style="cursor:pointer;" /></td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td valign="top">Guia Remision Escaneada:</td>
                      <td colspan="3"><iframe src="formularios/AlmacenMovimientoEntrada/acc/AccAlmacenMovimientoEntradaGuiaRemisionFotoSubirArchivo.php?Identificador=<?php echo $Identificador;?>" id="IfrAlmacenMovimientoEntradaGuiaRemisionFotoSubirArchivo" name="IfrAlmacenMovimientoEntradaGuiaRemisionFotoSubirArchivo" scrolling="auto"  frameborder="0"  width="400" height="200"></iframe></td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left" valign="top">Observacion:</td>
                      <td align="left" valign="top"><textarea name="CmpObservacion" cols="45" rows="2" class="EstFormularioCaja" id="CmpObservacion"><?php echo $InsAlmacenMovimientoEntrada->AmoObservacion;?></textarea></td>
                      <td align="left" valign="top">Almacen Destino:</td>
                      <td align="left" valign="top"><span id="spryselect4">
                      <select class="EstFormularioCombo" name="CmpAlmacen" id="CmpAlmacen">
                        <option value="">Escoja una opcion</option>
                        <?php
			foreach($ArrAlmacenes as $DatAlmacen){
			?>
                        <option value="<?php echo $DatAlmacen->AlmId?>" <?php if($InsAlmacenMovimientoEntrada->AlmId==$DatAlmacen->AlmId){ echo 'selected="selected"';} ?> ><?php echo $DatAlmacen->AlmNombre?></option>
                        <?php
			}
			?>
                      </select>
                      <span class="selectRequiredMsg">Debe escoger una opcion</span></span></td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left" valign="top">Estado: </td>
                      <td align="left" valign="top"><?php
					switch($InsAlmacenMovimientoEntrada->AmoEstado){
						case 1:
							$OpcEstado1 = 'selected = "selected"';
						break;

						case 3:
							$OpcEstado3 = 'selected = "selected"';						
						break;
					}
					?>
                        <select  class="EstFormularioCombo" name="CmpEstado" id="CmpEstado">
                          <option <?php echo $OpcEstado1;?> value="1">Pendiente</option>
                          <option <?php echo $OpcEstado3;?> value="3">Realizado</option>
                          </select></td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left" valign="top">OTRAS OPCIONES:</td>
                      <td align="left" valign="top"><input type="checkbox" name="CmpGenerarVentaConcretada" id="CmpGenerarVentaConcretada" value="1"  />
                        Generar Venta Concretadas</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td valign="top">&nbsp;</td>
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
                            <td colspan="15"><span class="EstFormularioSubTitulo">PRODUCTOS</span>
<input name="CmpProductoId"  type="hidden" class="EstFormularioCaja" id="CmpProductoId" size="10" maxlength="20" />
<input type="hidden" name="CmpProductoItem" id="CmpProductoItem" />
<input type="hidden" name="CmpProductoCostoAnterior" id="CmpProductoCostoAnterior" />
<input type="hidden" name="CmpProductoUnidadMedida" id="CmpProductoUnidadMedida" />
<input name="CmpProductoUnidadMedidaEquivalente"  type="hidden" class="EstFormularioCaja" id="CmpProductoUnidadMedidaEquivalente" size="3" maxlength="20"  />
                              <input name="CmpProductoAlmacenMovimientoDetalleId"  type="hidden" class="EstFormularioCaja" id="CmpProductoAlmacenMovimientoDetalleId" size="3" maxlength="20"  /></td>
                            </tr>
                          <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>Estado:</td>
                            <td><div id="CapProductoBuscar"></div></td>
                            <td>C&oacute;digo Orig.</td>
                            <td>&nbsp;</td>
                            <td>C&oacute;digo Alt.</td>
                            <td>&nbsp;</td>
                            <td>Nombre : </td>
                            <td>&nbsp;</td>
                            <td>U.M.
                            </td>
                            <td>Cantidad:</td>
                            
                            <td>
                              Valor Unit.:</td>
                            <td>
                              Valor Total:</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            </tr>
                          <tr>
                            <td>&nbsp;</td>
                            <td>
                              
                              <input class="EstFormularioCasilla" title="Activar/Desactivar uso de lector" type="checkbox" value="1" id="CmpProductoLector" name="CmpProductoLector"  />                            </td>
                            <td>


<select  class="EstFormularioCombo" name="CmpAlmacenMovimientoDetalleEstado" id="CmpAlmacenMovimientoDetalleEstado">
                         <option value="0">-</option>
                         <option value="1">No Llego</option>
                         <option value="2">Dañado</option>
                         <option selected="selected" value="3">Conforme</option>
                       </select>
                       
                       
                            </td>
                            <td>
                            
                            <?php
							//if(empty($InsAlmacenMovimientoEntrada->OcoId)){
							?>
                            <a href="javascript:FncAlmacenMovimientoEntradaDetalleNuevo();"><img src="imagenes/registrar.png" width="20" height="20" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a>
                            <?php	
							//}
							?>
                            
                            
                            
                            
                            </td>
                            <td><input name="CmpProductoCodigoOriginal"  type="text" class="EstFormularioCaja" id="CmpProductoCodigoOriginal" size="10" maxlength="20" /></td>
                            <td>
                            
                                                        <?php
							if(empty($InsAlmacenMovimientoEntrada->OcoId)){
							?>
                            <a href="javascript:FncProductoBuscar('CodigoOriginal');"><img src="imagenes/buscar2.gif" width="25" height="25" alt="[Buscar]" align="absmiddle" title="Buscar" border="0" /></a>
                               <?php	
							}
							?>                         
                            
                            </td>
                            <td><input name="CmpProductoCodigoAlternativo"  type="text" class="EstFormularioCaja" id="CmpProductoCodigoAlternativo" size="10" maxlength="20" /></td>
                            <td>


                                                        <?php
							if(empty($InsAlmacenMovimientoEntrada->OcoId)){
							?>                          
                            <a href="javascript:FncProductoBuscar('CodigoAlternativo');"><img src="imagenes/buscar2.gif" width="25" height="25" alt="[Buscar]" align="absmiddle" title="Buscar" border="0" /></a>
                            
                                <?php	
							}
							?>                         
                                                       
                            
                            </td>
                            <td><input name="CmpProductoNombre" type="text" class="EstFormularioCaja" id="CmpProductoNombre" size="40" /></td>
                            <td>
                            
                            <?php
							//if(empty($InsAlmacenMovimientoEntrada->OcoId)){
							?>
                            
                            <a id="BtnProductoRegistrar" onclick="FncProductoCargarFormulario('Registrar');"  href="javascript:void(0)" title="">
                            <img src="imagenes/nuevo.png" alt="[Registrar]" width="20" height="20" border="0" align="absmiddle" title="Registrar" /> 
                            </a>
                            
                            <a id="BtnProductoEditar" onclick="FncProductoCargarFormulario('Editar');" href="javascript:void(0)"   title="">
                            <img src="imagenes/editar.png" alt="[Editar]" width="20" height="20" border="0" align="absmiddle" title="Editar" /> 
                            </a>
                            
                                <?php	
							//}
							?>                         
                                 
                            
                            </td>
                            <td><select  class="EstFormularioCombo" name="CmpProductoUnidadMedidaConvertir" id="CmpProductoUnidadMedidaConvertir" disabled="disabled">
                              </select></td>
                            <td>
                              
                              <input name="CmpProductoCantidad" type="text" class="EstFormularioCaja" id="CmpProductoCantidad" size="10" maxlength="10" />                            </td>
                            <td><input name="CmpProductoCostoIngresoNeto" type="text" class="EstFormularioCaja" id="CmpProductoCostoIngresoNeto" size="10" maxlength="10" readonly="readonly" />                            </td>
                            <td>
                              
                              <input name="CmpProductoImporte" type="text" class="EstFormularioCaja" id="CmpProductoImporte" size="10" maxlength="10" />                            </td>
                            <td><a href="javascript:FncAlmacenMovimientoEntradaDetalleGuardar();"><img src="imagenes/guardar.gif" width="20" height="20" border="0" title="Guardar" alt="[Guardar]" align="absmiddle" /></a></td>
                            <td><a href="comunes/Producto/FrmProductoBuscar.php?height=440&amp;width=850" class="thickbox" title="">[...]</a></td>
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
                    <td width="49%"><div class="EstFormularioAccion" id="CapProductoAccion">Listo
                      para registrar elementos</div></td>
                    <td width="49%" align="right"><a href="javascript:FncAlmacenMovimientoEntradaDetalleListar();">
                      <input type="hidden" name="CmpAlmacenMovimientoEntradaDetalleAccion" id="CmpAlmacenMovimientoEntradaDetalleAccion" value="AccAlmacenMovimientoEntradaDetalleRegistrar.php" />
                      <img  src="imagenes/recargar.gif"  width="20" height="20"  border="0" title="Recargar"   alt="[Recargar]" align="absmiddle"/> Recargar</a>
                    
                    <!--<a href="javascript:FncAlmacenMovimientoEntradaDetalleEliminarTodo();"><img  src="imagenes/eliminar_todo.png"  width="20" height="20"  border="0" title="Eliminar Todo"   alt="[Eli. Todo.]" align="absmiddle"/></a>--></td>
                    <td width="1%"><div id="CapAlmacenMovimientoEntradaDetallesResultado"> </div></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="2"><div id="CapAlmacenMovimientoEntradaDetalles" class="EstCapAlmacenMovimientoEntradaDetalles" > </div></td>
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
                    <td>&nbsp;</td>
                    <td colspan="3">&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td align="left" valign="top">
                      <span id="spryselect1">
                   <select class="EstFormularioCombo" name="CmpProveedorTipoDocumento" id="CmpProveedorTipoDocumento" disabled="disabled">
                      <option value="">Escoja una opcion</option>
                      <?php
			foreach($ArrTipoDocumentos as $DatTipoDocumento){
			?>
                      <option <?php echo $DatTipoDocumento->TdoId;?> <?php echo ($DatTipoDocumento->TdoId==$InsAlmacenMovimientoEntrada->TdoId)?'selected="selected"':"";?> value="<?php echo $DatTipoDocumento->TdoId?>"><?php echo $DatTipoDocumento->TdoCodigo?> - <?php echo $DatTipoDocumento->TdoNombre?></option>
                      <?php
			}
			?>
                      </select>
                      <span class="selectRequiredMsg">Seleccione un elemento.</span></span>
                      :
                      <input name="CmpProveedorId" type="hidden" id="CmpProveedorId" value="<?php echo $InsAlmacenMovimientoEntrada->PrvId;?>" size="3" /></td>
                    <td align="left" valign="top">
                      
                      <table border="0" cellpadding="0" cellspacing="0">
                        <tr>
                          <td><a href="javascript:FncProveedorNuevo('','');"><img src="imagenes/registrar.png" width="20" height="20" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                          <td>
                            <span id="sprytextfield21">
                           <input name="CmpProveedorNumeroDocumento" type="text" class="EstFormularioCaja" id="CmpProveedorNumeroDocumento"  value="<?php echo $InsAlmacenMovimientoEntrada->PrvNumeroDocumento;?>" size="20" maxlength="50" />
                            <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
                          <td><a href="javascript:FncProveedorBuscar('NumeroDocumento');"><img src="imagenes/buscar2.gif" width="25" height="25" alt="[Buscar]" align="absmiddle" title="Buscar" border="0"  /></a></td>
                          <td>
                          

                                <a id="BtnProveedorRegistrar" onclick="FncProveedorCargarFormulario('Registrar','','');"  href="javascript:void(0)" title="">
                                <img src="imagenes/nuevo.png" alt="[Registrar]" width="20" height="20" border="0" align="absmiddle" title="Registrar" />
                                </a>
                                
                                <a id="BtnProveedorEditar" onclick="FncProveedorCargarFormulario('Editar','','');" href="javascript:void(0)"   title="">
                                <img src="imagenes/editar.png" alt="[Editar]" width="20" height="20" border="0" align="absmiddle" title="Editar" />
                                </a>

                          </td>
                          <td><div id="CapProveedorBuscar"></div>
                            
                            </td>
                          </tr>
                      </table></td>
                    <td align="left" valign="top">Proveedor:</td>
                    <td align="left" valign="top">
                    
                    
                    
                      <table border="0" cellpadding="0" cellspacing="0">
                        <tr>
                        <td><a href="javascript:FncProveedorNuevo('','');"><img src="imagenes/registrar.png" width="20" height="20" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
						<td>
                                  <span id="sprytextfield5">
                      <label>
                        <input class="EstFormularioCaja" name="CmpProveedorNombre" type="text" id="CmpProveedorNombre" value="<?php echo $InsAlmacenMovimientoEntrada->PrvNombreCompleto;?>" size="45" maxlength="255"  />
                      </label>
                      <span class="textfieldRequiredMsg">Se necesita un valor.</span></span>
                      
                      
                      <a href="formularios/AlmacenMovimientoEntrada/FrmProveedorBuscar.php?height=440&width=850" class="thickbox" title="">[...]</a>
                      
                        </td>
                        </tr>
                        </table>                        


                      
                      
                      </td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td align="left" valign="top">Tipo de Comprobante:</td>
                    <td align="left" valign="top"><span id="spryselect3">
                      <select class="EstFormularioCombo" name="CmpComprobanteTipo" id="CmpComprobanteTipo">
                        <option value="">Escoja una opcion</option>
                        <?php
			foreach($ArrComprobanteTipos as $DatComprobanteTipo){
			?>
                        <option value="<?php echo $DatComprobanteTipo->CtiId?>" <?php if($InsAlmacenMovimientoEntrada->CtiId==$DatComprobanteTipo->CtiId){ echo 'selected="selected"';} ?> ><?php echo $DatComprobanteTipo->CtiCodigo?> - <?php echo $DatComprobanteTipo->CtiNombre?></option>
                        <?php
			}
			?>
                        </select>
                      <span class="selectRequiredMsg">Debe escoger una opcion</span></span></td>
                    <td align="left" valign="top">Origen:</td>
                    <td align="left" valign="top"><?php
					switch($InsAlmacenMovimientoEntrada->AmoDocumentoOrigen){
						case 1:
							$OpcDocumentoOrigen1 = 'selected = "selected"';
						break;
						
						case 2:
							$OpcDocumentoOrigen2 = 'selected = "selected"';						
						break;
						
						

					}
					?>
                      <select   class="EstFormularioCombo" name="CmpDocumentoOrigen" id="CmpDocumentoOrigen">
                        <option <?php echo $OpcDocumentoOrigen1;?> value="1">Nacional</option>
                        <option <?php echo $OpcDocumentoOrigen2;?> value="2">Internacional</option>
                      </select>
                      
                      </td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td align="left" valign="top">Numero de Comprobante:</td>
                    <td align="left" valign="top"> <span id="sprytextfield20">
<input name="CmpComprobanteNumeroSerie" type="text" class="EstFormularioCaja" id="CmpComprobanteNumeroSerie" value="<?php echo $InsAlmacenMovimientoEntrada->AmoComprobanteNumeroSerie;?>" size="10" maxlength="50" />
                      <span class="textfieldRequiredMsg">Se necesita un valor.</span></span>                     -
                      
                      <span id="sprytextfield9">
                     <input name="CmpComprobanteNumeroNumero" type="text" class="EstFormularioCaja" id="CmpComprobanteNumeroNumero" value="<?php echo $InsAlmacenMovimientoEntrada->AmoComprobanteNumeroNumero;?>" size="20" maxlength="50" />
                      <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
                    <td align="left" valign="top">Fecha de Comprobante: <br><span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
                    <td align="left" valign="top"><span id="sprytextfield7">
                    <label>
                      <input class="EstFormularioCajaFecha" name="CmpComprobanteFecha" type="text" id="CmpComprobanteFecha" value="<?php echo $InsAlmacenMovimientoEntrada->AmoComprobanteFecha;?>" size="15" maxlength="10" />
                    </label>
                    <span class="textfieldInvalidFormatMsg"><img src="imagenes/advertencia.png"  border="0" align="absmiddle" title="Formato no valido"  /></span><span class="textfieldRequiredMsg">Se necesita un valor.</span></span>
                      
                      <img src="imagenes/calendar.gif" alt="[Calendario]" id="BtnComprobanteFecha" name="BtnComprobanteFecha" width="18" height="18" align="absmiddle"  style="cursor:pointer;" /></td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td align="left" valign="top">Condicion de Pago:</td>
                    <td align="left" valign="top">
                    
                    <span id="spryselect2">
                      <select name="CmpCondicionPago" id="CmpCondicionPago" class="EstFormularioCombo" >
                        <option value="">Escoja una opcion</option>
                        <?php
					foreach($ArrCondicionPagos as $DatCondicionPago){
					?>
                        <option <?php if($InsAlmacenMovimientoEntrada->NpaId==$DatCondicionPago->NpaId){ echo 'selected="selected"';}?> value="<?php echo $DatCondicionPago->NpaId;?>"><?php echo $DatCondicionPago->NpaNombre;?></option>
                        <?php  
					}
					?>
                        </select>
                      <span class="selectRequiredMsg"><img src="imagenes/advertencia.png" width="20" height="20" border="0" align="absmiddle" title="Debe seleccionar un elemento" alt="[A]"  /></span></span></td>
                    <td align="left" valign="top">Cantidad de Dias:</td>
                    <td align="left" valign="top"><span id="sprytextfield11">
                      <input class="EstFormularioCaja" name="CmpCantidadDia" type="text" id="CmpCantidadDia" size="10" maxlength="3" value="<?php echo $InsAlmacenMovimientoEntrada->AmoCantidadDia;?>" />
                      <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no v&aacute;lido.</span></span></td>
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
                            <option value="<?php echo $DatMoneda->MonId?>" <?php if($InsAlmacenMovimientoEntrada->MonId==$DatMoneda->MonId){ echo 'selected="selected"';}elseif($EmpresaMonedaId==$DatMoneda->MonId){  echo 'selected="selected"';}?> ><?php echo $DatMoneda->MonNombre?> ( <?php echo $DatMoneda->MonSimbolo;?>)</option>
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
                    <input name="CmpTipoCambio" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpTipoCambio" onchange="FncAlmacenMovimientoEntradaDetalleListar();" value="<?php if (empty($InsAlmacenMovimientoEntrada->AmoTipoCambio)){ echo "";}else{ echo $InsAlmacenMovimientoEntrada->AmoTipoCambio; } ?>" size="10" maxlength="10" />
                    
                    </td>
                    <td>
                    <a href="javascript:FncAlmacenMovimientoEntradaEstablecerMoneda();"><img src="imagenes/recargar.jpg" width="20" height="20" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /></a>
                    
                    </td>
                    </tr>
                    </table>
                    
                    </td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td valign="top">Comprobante escaneado:</td>
                    <td colspan="3"><iframe src="formularios/AlmacenMovimientoEntrada/acc/AccAlmacenMovimientoEntradaSubirArchivo.php?Identificador=<?php echo $Identificador;?>" id="IfrAlmacenMovimientoEntradaSubirArchivo" name="IfrAlmacenMovimientoEntradaSubirArchivo" scrolling="auto"  frameborder="0" width="400" height="200"></iframe></td>
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
    <div id="tab3" class="tab_content">
    <table width="100%" border="0" cellpadding="2" cellspacing="2">
	<tr>
		<td width="97%" valign="top">
        
                  <div class="EstFormularioArea">
    <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
	    <tr>
	      <td width="4">&nbsp;</td>
	      <td colspan="6"><span class="EstFormularioSubTitulo">Costos Vinculados</span></td>
	      </tr>
	    <tr>
	      <td>&nbsp;</td>
	      <td width="252">&nbsp;</td>
	      <td width="60">&nbsp;</td>
	      <td width="129">&nbsp;</td>
	      <td width="72">&nbsp;</td>
	      <td width="14">&nbsp;</td>
	      <td width="4">&nbsp;</td>
	      </tr>
	    <tr>
	      <td>&nbsp;</td>
	      <td colspan="5">
          
          <div id="CapCostoInternacionales">
          

          <table border="0" cellpadding="2" cellspacing="2">
	        <tr>
	          <td>COSTOS INTERNACIONALES</td>
	          <td align="center">Num. Comprob.</td>
	          <td align="center">Monto</td>
	          <td align="center">Moneda</td>
	          <td align="center">Tipo Doc.</td>
	          <td align="center">&nbsp;</td>
	          <td align="center">Num. Documento</td>
	          <td align="center">&nbsp;</td>
	          <td align="center">&nbsp;</td>
	          <td align="center">Proveedor</td>
	          <td>&nbsp;</td>
	          <td>&nbsp;</td>
	          </tr>
	        <tr>
	          <td align="left" class="EstFormulario">Aduana Internacional:</td>
	          <td><input name="CmpInternacionalNumeroComprobante1" type="text" class="EstFormularioCaja" id="CmpInternacionalNumeroComprobante1" value="<?php echo $InsAlmacenMovimientoEntrada->AmoInternacionalNumeroComprobante1;?>" size="20" maxlength="20" /></td>
	          <td><span id="sprytextfield10">
	            <input class="EstFormularioCaja" onchange="FncAlmacenMovimientoEntradaCostoVinculadoListar();" name="CmpTotalAduana" type="text" id="CmpTotalAduana" value="<?php if(empty($InsAlmacenMovimientoEntrada->AmoInternacionalTotalAduana)){ echo "0.00"; }else{echo number_format($InsAlmacenMovimientoEntrada->AmoInternacionalTotalAduana,2);}?>" size="10" maxlength="5" />
	            <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg"><img src="imagenes/advertencia.png" width="20" height="20" border="0" align="absmiddle" title="Formato no valido" alt="[A]"  /></span></span></td>
	          <td><select class="EstFormularioCombo" name="CmpInternacionalMonedaId1" id="CmpInternacionalMonedaId1">
	            <option value="">Escoja una opcion</option>
	            <?php
			  foreach($ArrMonedas as $DatMoneda){
			  ?>
	            <option value="<?php echo $DatMoneda->MonId?>" <?php if($InsAlmacenMovimientoEntrada->MonIdInternacional1==$DatMoneda->MonId){ echo 'selected="selected"';}elseif($EmpresaMonedaId==$DatMoneda->MonId){  echo 'selected="selected"';}?> ><?php echo $DatMoneda->MonNombre?> ( <?php echo $DatMoneda->MonSimbolo;?>)</option>
	            <?php
			  }
			  ?>
	            </select></td>
	          <td><select class="EstFormularioCombo" name="CmpInternacionalProveedorTipoDocumento1" id="CmpInternacionalProveedorTipoDocumento1">
	            <option value="">Escoja una opcion</option>
	            <?php
			foreach($ArrTipoDocumentos as $DatTipoDocumento){
			?>
	            <option <?php echo $DatTipoDocumento->TdoId;?> <?php echo ($DatTipoDocumento->TdoId==$InsAlmacenMovimientoEntrada->TdoIdInternacional1)?'selected="selected"':"";?> value="<?php echo $DatTipoDocumento->TdoId?>"><?php echo $DatTipoDocumento->TdoCodigo?> - <?php echo $DatTipoDocumento->TdoNombre?></option>
	            <?php
			}
			?>
	            </select></td>
	          <td>
              
<a href="javascript:FncProveedorNuevo('Internacional','1');"><img src="imagenes/registrar.png" width="20" height="20" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a>

</td>
	          <td><label for="CmpInternacionalProveedorNumeroDocumento1"></label>
	            <input name="CmpInternacionalProveedorId1" type="hidden" class="EstFormularioCaja" id="CmpInternacionalProveedorId1" value="<?php echo $InsAlmacenMovimientoEntrada->PrvIdInternacional1;?>" size="20" maxlength="20" />
                <input name="CmpInternacionalProveedorNumeroDocumento1" type="text" class="EstFormularioCaja" id="CmpInternacionalProveedorNumeroDocumento1" value="<?php echo $InsAlmacenMovimientoEntrada->PrvNumeroDocumentoInternacional1;?>" size="20" maxlength="20" /></td>
	          <td>


<a href="javascript:FncProveedorBuscar('NumeroDocumento','Internacional','1');"><img src="imagenes/buscar2.gif" width="25" height="25" alt="[Buscar]" align="absmiddle" title="Buscar" border="0"  /></a>

</td>
	          <td>
              
              
<a id="BtnInternacionalProveedorRegistrar1" onclick="FncProveedorCargarFormulario('Registrar','Internacional','1');"  href="javascript:void(0)" title="">
<img src="imagenes/nuevo.png" alt="[Registrar]" width="20" height="20" border="0" align="absmiddle" title="Registrar" />
</a>

<a id="BtnInternacionalProveedorEditar1" onclick="FncProveedorCargarFormulario('Editar','Internacional','1');" href="javascript:void(0)"   title="">
<img src="imagenes/editar.png" alt="[Editar]" width="20" height="20" border="0" align="absmiddle" title="Editar" />
</a>


              </td>
	          <td><input name="CmpInternacionalProveedorNombre1" type="text" class="EstFormularioCaja" id="CmpInternacionalProveedorNombre1" value="<?php echo $InsAlmacenMovimientoEntrada->PrvNombreInternacional1;?>" size="50" maxlength="100" /></td>
	          <td><a href="formularios/AlmacenMovimientoEntrada/FrmProveedorBuscar.php?height=440&amp;width=850&amp;Ruta=1&amp;Tipo=Internacional" class="thickbox" title="">[...]</a></td>
	          <td>&nbsp;</td>
	          </tr>
	        <tr>
	          <td align="left" class="EstFormulario">Transporte:</td>
	          <td><input name="CmpInternacionalNumeroComprobante2" type="text" class="EstFormularioCaja" id="CmpInternacionalNumeroComprobante2" value="<?php echo $InsAlmacenMovimientoEntrada->AmoInternacionalNumeroComprobante2;?>" size="20" maxlength="20" /></td>
	          <td><span id="sprytextfield11">
	            <input class="EstFormularioCaja" onchange="FncAlmacenMovimientoEntradaCostoVinculadoListar();" name="CmpTotalTransporte" type="text" id="CmpTotalTransporte" value="<?php if(empty($InsAlmacenMovimientoEntrada->AmoInternacionalTotalTransporte)){ echo "0.00"; }else{echo number_format($InsAlmacenMovimientoEntrada->AmoInternacionalTotalTransporte,2);}?>" size="10" maxlength="5" />
	            <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg"><img src="imagenes/advertencia.png" width="20" height="20" border="0" align="absmiddle" title="Formato no valido" alt="[A]"  /></span></span></td>
	          <td><select class="EstFormularioCombo" name="CmpInternacionalMonedaId2" id="CmpInternacionalMonedaId2">
	            <option value="">Escoja una opcion</option>
	            <?php
			  foreach($ArrMonedas as $DatMoneda){
			  ?>
	            <option value="<?php echo $DatMoneda->MonId?>" <?php if($InsAlmacenMovimientoEntrada->MonIdInternacional1==$DatMoneda->MonId){ echo 'selected="selected"';}elseif($EmpresaMonedaId==$DatMoneda->MonId){  echo 'selected="selected"';}?> ><?php echo $DatMoneda->MonNombre?> ( <?php echo $DatMoneda->MonSimbolo;?>)</option>
	            <?php
			  }
			  ?>
	            </select></td>
	          <td><select class="EstFormularioCombo" name="CmpInternacionalProveedorTipoDocumento2" id="CmpInternacionalProveedorTipoDocumento2">
	            <option value="">Escoja una opcion</option>
	            <?php
			foreach($ArrTipoDocumentos as $DatTipoDocumento){
			?>
	            <option <?php echo $DatTipoDocumento->TdoId;?> <?php echo ($DatTipoDocumento->TdoId==$InsAlmacenMovimientoEntrada->TdoIdInternacional2)?'selected="selected"':"";?> value="<?php echo $DatTipoDocumento->TdoId?>"><?php echo $DatTipoDocumento->TdoCodigo?> - <?php echo $DatTipoDocumento->TdoNombre?></option>
	            <?php
			}
			?>
	            </select></td>
	          <td><a href="javascript:FncProveedorNuevo('Internacional','2');"><img src="imagenes/registrar.png" width="20" height="20" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
	          <td><input name="CmpInternacionalProveedorId2" type="hidden" class="EstFormularioCaja" id="CmpInternacionalProveedorId2" value="<?php echo $InsAlmacenMovimientoEntrada->PrvIdInternacional2;?>" size="20" maxlength="20" />	            <input name="CmpInternacionalProveedorNumeroDocumento2" type="text" class="EstFormularioCaja" id="CmpInternacionalProveedorNumeroDocumento2" value="<?php echo $InsAlmacenMovimientoEntrada->PrvNumeroDocumentoInternacional2;?>" size="20" maxlength="20" /></td>
	          <td><a href="javascript:FncProveedorBuscar('NumeroDocumento','Internacional','2');"><img src="imagenes/buscar2.gif" width="25" height="25" alt="[Buscar]" align="absmiddle" title="Buscar" border="0"  /></a></td>
	          <td>

<a id="BtnInternacionalProveedorRegistrar2" onclick="FncProveedorCargarFormulario('Registrar','Internacional','2');"  href="javascript:void(0)" title="">
<img src="imagenes/nuevo.png" alt="[Registrar]" width="20" height="20" border="0" align="absmiddle" title="Registrar" />
</a>

<a id="BtnInternacionalProveedorEditar2" onclick="FncProveedorCargarFormulario('Editar','Internacional','2');" href="javascript:void(0)"   title="">
<img src="imagenes/editar.png" alt="[Editar]" width="20" height="20" border="0" align="absmiddle" title="Editar" />
</a>

              </td>
	          <td><input name="CmpInternacionalProveedorNombre2" type="text" class="EstFormularioCaja" id="CmpInternacionalProveedorNombre2" value="<?php echo $InsAlmacenMovimientoEntrada->PrvNombreInternacional2;?>" size="50" maxlength="100" /></td>
	          <td><a href="formularios/AlmacenMovimientoEntrada/FrmProveedorBuscar.php?height=440&amp;width=850&amp;Ruta=2&amp;Tipo=Internacional" class="thickbox" title="">[...]</a></td>
	          <td>&nbsp;</td>
	          </tr>
	        <tr>
	          <td align="left" class="EstFormulario">Desestiba:</td>
	          <td><input name="CmpInternacionalNumeroComprobante3" type="text" class="EstFormularioCaja" id="CmpInternacionalNumeroComprobante3" value="<?php echo $InsAlmacenMovimientoEntrada->AmoInternacionalNumeroComprobante3;?>" size="20" maxlength="20" /></td>
	          <td><span id="sprytextfield12">
	            <input class="EstFormularioCaja" onchange="FncAlmacenMovimientoEntradaCostoVinculadoListar();" name="CmpTotalDesestiba" type="text" id="CmpTotalDesestiba" value="<?php if(empty($InsAlmacenMovimientoEntrada->AmoInternacionalTotalDesestiba)){ echo "0.00"; }else{echo number_format($InsAlmacenMovimientoEntrada->AmoInternacionalTotalDesestiba,2);}?>" size="10" maxlength="5" />
	            <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg"><img src="imagenes/advertencia.png" width="20" height="20" border="0" align="absmiddle" title="Formato no valido" alt="[A]"  /></span></span></td>
	          <td><select class="EstFormularioCombo" name="CmpInternacionalMonedaId3" id="CmpInternacionalMonedaId3">
	            <option value="">Escoja una opcion</option>
	            <?php
			  foreach($ArrMonedas as $DatMoneda){
			  ?>
	            <option value="<?php echo $DatMoneda->MonId?>" <?php if($InsAlmacenMovimientoEntrada->MonIdInternacional1==$DatMoneda->MonId){ echo 'selected="selected"';}elseif($EmpresaMonedaId==$DatMoneda->MonId){  echo 'selected="selected"';}?> ><?php echo $DatMoneda->MonNombre?> ( <?php echo $DatMoneda->MonSimbolo;?>)</option>
	            <?php
			  }
			  ?>
	            </select></td>
	          <td><select class="EstFormularioCombo" name="CmpInternacionalProveedorTipoDocumento3" id="CmpInternacionalProveedorTipoDocumento3">
	            <option value="">Escoja una opcion</option>
	            <?php
			foreach($ArrTipoDocumentos as $DatTipoDocumento){
			?>
	            <option <?php echo $DatTipoDocumento->TdoId;?> <?php echo ($DatTipoDocumento->TdoId==$InsAlmacenMovimientoEntrada->TdoIdInternacional3)?'selected="selected"':"";?> value="<?php echo $DatTipoDocumento->TdoId?>"><?php echo $DatTipoDocumento->TdoCodigo?> - <?php echo $DatTipoDocumento->TdoNombre?></option>
	            <?php
			}
			?>
	            </select></td>
	          <td><a href="javascript:FncProveedorNuevo('Internacional','3');"><img src="imagenes/registrar.png" width="20" height="20" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
	          <td><input name="CmpInternacionalProveedorId3" type="hidden" class="EstFormularioCaja" id="CmpInternacionalProveedorId3" value="<?php echo $InsAlmacenMovimientoEntrada->PrvIdInternacional3;?>" size="20" maxlength="20" />	            <input name="CmpInternacionalProveedorNumeroDocumento3" type="text" class="EstFormularioCaja" id="CmpInternacionalProveedorNumeroDocumento3" value="<?php echo $InsAlmacenMovimientoEntrada->PrvNumeroDocumentoInternacional3;?>" size="20" maxlength="20" /></td>
	          <td><a href="javascript:FncProveedorBuscar('NumeroDocumento','Internacional','3');"><img src="imagenes/buscar2.gif" width="25" height="25" alt="[Buscar]" align="absmiddle" title="Buscar" border="0"  /></a></td>
	          <td>
              
<a id="BtnInternacionalProveedorRegistrar3" onclick="FncProveedorCargarFormulario('Registrar','Internacional','3');"  href="javascript:void(0)" title="">
<img src="imagenes/nuevo.png" alt="[Registrar]" width="20" height="20" border="0" align="absmiddle" title="Registrar" />
</a>

<a id="BtnInternacionalProveedorEditar3" onclick="FncProveedorCargarFormulario('Editar','Internacional','3');" href="javascript:void(0)"   title="">
<img src="imagenes/editar.png" alt="[Editar]" width="20" height="20" border="0" align="absmiddle" title="Editar" />
</a>

				</td>
	          <td><input name="CmpInternacionalProveedorNombre3" type="text" class="EstFormularioCaja" id="CmpInternacionalProveedorNombre3" value="<?php echo $InsAlmacenMovimientoEntrada->PrvNombreInternacional3;?>" size="50" maxlength="100" /></td>
	          <td><a href="formularios/AlmacenMovimientoEntrada/FrmProveedorBuscar.php?height=440&amp;width=850&amp;Ruta=3&amp;Tipo=Internacional" class="thickbox" title="">[...]</a></td>
	          <td>&nbsp;</td>
	          </tr>
	        <tr>
	          <td align="left" class="EstFormulario">Almacenaje:</td>
	          <td><input name="CmpInternacionalNumeroComprobante4" type="text" class="EstFormularioCaja" id="CmpInternacionalNumeroComprobante4" value="<?php echo $InsAlmacenMovimientoEntrada->AmoInternacionalNumeroComprobante4;?>" size="20" maxlength="20" /></td>
	          <td><span id="sprytextfield13">
	            <input class="EstFormularioCaja" onchange="FncAlmacenMovimientoEntradaCostoVinculadoListar();" name="CmpTotalAlmacenaje" type="text" id="CmpTotalAlmacenaje" value="<?php if(empty($InsAlmacenMovimientoEntrada->AmoInternacionalTotalAlmacenaje)){ echo "0.00"; }else{echo number_format($InsAlmacenMovimientoEntrada->AmoInternacionalTotalAlmacenaje,2);}?>" size="10" maxlength="5" />
	            <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg"><img src="imagenes/advertencia.png" width="20" height="20" border="0" align="absmiddle" title="Formato no valido" alt="[A]"  /></span></span></td>
	          <td><select class="EstFormularioCombo" name="CmpInternacionalMonedaId4" id="CmpInternacionalMonedaId4">
	            <option value="">Escoja una opcion</option>
	            <?php
			  foreach($ArrMonedas as $DatMoneda){
			  ?>
	            <option value="<?php echo $DatMoneda->MonId?>" <?php if($InsAlmacenMovimientoEntrada->MonIdInternacional1==$DatMoneda->MonId){ echo 'selected="selected"';}elseif($EmpresaMonedaId==$DatMoneda->MonId){  echo 'selected="selected"';}?> ><?php echo $DatMoneda->MonNombre?> ( <?php echo $DatMoneda->MonSimbolo;?>)</option>
	            <?php
			  }
			  ?>
	            </select></td>
	          <td><select class="EstFormularioCombo" name="CmpInternacionalProveedorTipoDocumento4" id="CmpInternacionalProveedorTipoDocumento4">
	            <option value="">Escoja una opcion</option>
	            <?php
			foreach($ArrTipoDocumentos as $DatTipoDocumento){
			?>
	            <option <?php echo $DatTipoDocumento->TdoId;?> <?php echo ($DatTipoDocumento->TdoId==$InsAlmacenMovimientoEntrada->TdoIdInternacional4)?'selected="selected"':"";?> value="<?php echo $DatTipoDocumento->TdoId?>"><?php echo $DatTipoDocumento->TdoCodigo?> - <?php echo $DatTipoDocumento->TdoNombre?></option>
	            <?php
			}
			?>
	            </select></td>
	          <td><a href="javascript:FncProveedorNuevo('Internacional','4');"><img src="imagenes/registrar.png" width="20" height="20" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
	          <td><input name="CmpInternacionalProveedorId4" type="hidden" class="EstFormularioCaja" id="CmpInternacionalProveedorId4" value="<?php echo $InsAlmacenMovimientoEntrada->PrvIdInternacional4;?>" size="20" maxlength="20" />	            <input name="CmpInternacionalProveedorNumeroDocumento4" type="text" class="EstFormularioCaja" id="CmpInternacionalProveedorNumeroDocumento4" value="<?php echo $InsAlmacenMovimientoEntrada->PrvNumeroDocumentoInternacional4;?>" size="20" maxlength="20" /></td>
	          <td><a href="javascript:FncProveedorBuscar('NumeroDocumento','Internacional','4');"><img src="imagenes/buscar2.gif" width="25" height="25" alt="[Buscar]" align="absmiddle" title="Buscar" border="0"  /></a></td>
	          <td>
              
<a id="BtnInternacionalProveedorRegistrar4" onclick="FncProveedorCargarFormulario('Registrar','Internacional','4');"  href="javascript:void(0)" title="">
<img src="imagenes/nuevo.png" alt="[Registrar]" width="20" height="20" border="0" align="absmiddle" title="Registrar" />
</a>
<a id="BtnInternacionalProveedorEditar4" onclick="FncProveedorCargarFormulario('Editar','Internacional','4');" href="javascript:void(0)"   title="">
<img src="imagenes/editar.png" alt="[Editar]" width="20" height="20" border="0" align="absmiddle" title="Editar" />
</a>

</td>
	          <td><input name="CmpInternacionalProveedorNombre4" type="text" class="EstFormularioCaja" id="CmpInternacionalProveedorNombre4" value="<?php echo $InsAlmacenMovimientoEntrada->PrvNombreInternacional4;?>" size="50" maxlength="100" /></td>
	          <td><a href="formularios/AlmacenMovimientoEntrada/FrmProveedorBuscar.php?height=440&amp;width=850&amp;Ruta=4&amp;Tipo=Internacional" class="thickbox" title="">[...]</a></td>
	          <td>&nbsp;</td>
	          </tr>
	        <tr>
	          <td align="left" class="EstFormulario">Ad Valorem:</td>
	          <td><input name="CmpInternacionalNumeroComprobante5" type="text" class="EstFormularioCaja" id="CmpInternacionalNumeroComprobante5" value="<?php echo $InsAlmacenMovimientoEntrada->AmoInternacionalNumeroComprobante5;?>" size="20" maxlength="20" /></td>
	          <td><span id="sprytextfield14">
	            <input class="EstFormularioCaja" onchange="FncAlmacenMovimientoEntradaCostoVinculadoListar();" name="CmpTotalAdValorem" type="text" id="CmpTotalAdValorem" value="<?php if(empty($InsAlmacenMovimientoEntrada->AmoInternacionalTotalAdValorem)){ echo "0.00"; }else{echo number_format($InsAlmacenMovimientoEntrada->AmoInternacionalTotalAdValorem,2);}?>" size="10" maxlength="5" />
	            <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg"><img src="imagenes/advertencia.png" width="20" height="20" border="0" align="absmiddle" title="Formato no valido" alt="[A]"  /></span></span></td>
	          <td><select class="EstFormularioCombo" name="CmpInternacionalMonedaId5" id="CmpInternacionalMonedaId5">
	            <option value="">Escoja una opcion</option>
	            <?php
			  foreach($ArrMonedas as $DatMoneda){
			  ?>
	            <option value="<?php echo $DatMoneda->MonId?>" <?php if($InsAlmacenMovimientoEntrada->MonIdInternacional1==$DatMoneda->MonId){ echo 'selected="selected"';}elseif($EmpresaMonedaId==$DatMoneda->MonId){  echo 'selected="selected"';}?> ><?php echo $DatMoneda->MonNombre?> ( <?php echo $DatMoneda->MonSimbolo;?>)</option>
	            <?php
			  }
			  ?>
	            </select></td>
	          <td><select class="EstFormularioCombo" name="CmpInternacionalProveedorTipoDocumento5" id="CmpInternacionalProveedorTipoDocumento5">
	            <option value="">Escoja una opcion</option>
	            <?php
			foreach($ArrTipoDocumentos as $DatTipoDocumento){
			?>
	            <option <?php echo $DatTipoDocumento->TdoId;?> <?php echo ($DatTipoDocumento->TdoId==$InsAlmacenMovimientoEntrada->TdoIdInternacional5)?'selected="selected"':"";?> value="<?php echo $DatTipoDocumento->TdoId?>"><?php echo $DatTipoDocumento->TdoCodigo?> - <?php echo $DatTipoDocumento->TdoNombre?></option>
	            <?php
			}
			?>
	            </select></td>
	          <td><a href="javascript:FncProveedorNuevo('Internacional','5');"><img src="imagenes/registrar.png" width="20" height="20" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
	          <td><input name="CmpInternacionalProveedorId5" type="hidden" class="EstFormularioCaja" id="CmpInternacionalProveedorId5" value="<?php echo $InsAlmacenMovimientoEntrada->PrvIdInternacional5;?>" size="20" maxlength="20" />	            <input name="CmpInternacionalProveedorNumeroDocumento5" type="text" class="EstFormularioCaja" id="CmpInternacionalProveedorNumeroDocumento5" value="<?php echo $InsAlmacenMovimientoEntrada->PrvNumeroDocumentoInternacional5;?>" size="20" maxlength="20" /></td>
	          <td><a href="javascript:FncProveedorBuscar('NumeroDocumento','Internacional','5');"><img src="imagenes/buscar2.gif" width="25" height="25" alt="[Buscar]" align="absmiddle" title="Buscar" border="0"  /></a></td>
	          <td>
<a id="BtnInternacionalProveedorRegistrar5" onclick="FncProveedorCargarFormulario('Registrar','Internacional','5');"  href="javascript:void(0)" title="">
<img src="imagenes/nuevo.png" alt="[Registrar]" width="20" height="20" border="0" align="absmiddle" title="Registrar" /> 
</a>
<a id="BtnInternacionalProveedorEditar5" onclick="FncProveedorCargarFormulario('Editar','Internacional','5');" href="javascript:void(0)"   title="">
<img src="imagenes/editar.png" alt="[Editar]" width="20" height="20" border="0" align="absmiddle" title="Editar" />
</a>
			</td>
	          <td><input name="CmpInternacionalProveedorNombre5" type="text" class="EstFormularioCaja" id="CmpInternacionalProveedorNombre5" value="<?php echo $InsAlmacenMovimientoEntrada->PrvNombreInternacional5;?>" size="50" maxlength="100" /></td>
	          <td><a href="formularios/AlmacenMovimientoEntrada/FrmProveedorBuscar.php?height=440&amp;width=850&amp;Ruta=5&amp;Tipo=Internacional" class="thickbox" title="">[...]</a></td>
	          <td>&nbsp;</td>
	          </tr>
	        <tr>
	          <td align="left" class="EstFormulario">Aduana Nacional:</td>
	          <td><input name="CmpInternacionalNumeroComprobante6" type="text" class="EstFormularioCaja" id="CmpInternacionalNumeroComprobante6" value="<?php echo $InsAlmacenMovimientoEntrada->AmoInternacionalNumeroComprobante6;?>" size="20" maxlength="20" /></td>
	          <td><span id="sprytextfield15">
	            <input class="EstFormularioCaja" onchange="FncAlmacenMovimientoEntradaCostoVinculadoListar();" name="CmpTotalAduanaNacional" type="text" id="CmpTotalAduanaNacional" value="<?php if(empty($InsAlmacenMovimientoEntrada->AmoInternacionalTotalAduanaNacional)){ echo "0.00"; }else{echo number_format($InsAlmacenMovimientoEntrada->AmoInternacionalTotalAduanaNacional,2);}?>" size="10" maxlength="5" />
	            <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg"><img src="imagenes/advertencia.png" width="20" height="20" border="0" align="absmiddle" title="Formato no valido" alt="[A]"  /></span></span></td>
	          <td><select class="EstFormularioCombo" name="CmpInternacionalMonedaId6" id="CmpInternacionalMonedaId6">
	            <option value="">Escoja una opcion</option>
	            <?php
			  foreach($ArrMonedas as $DatMoneda){
			  ?>
	            <option value="<?php echo $DatMoneda->MonId?>" <?php if($InsAlmacenMovimientoEntrada->MonIdInternacional1==$DatMoneda->MonId){ echo 'selected="selected"';}elseif($EmpresaMonedaId==$DatMoneda->MonId){  echo 'selected="selected"';}?> ><?php echo $DatMoneda->MonNombre?> ( <?php echo $DatMoneda->MonSimbolo;?>)</option>
	            <?php
			  }
			  ?>
	            </select></td>
	          <td><select class="EstFormularioCombo" name="CmpInternacionalProveedorTipoDocumento6" id="CmpInternacionalProveedorTipoDocumento6">
	            <option value="">Escoja una opcion</option>
	            <?php
			foreach($ArrTipoDocumentos as $DatTipoDocumento){
			?>
	            <option <?php echo $DatTipoDocumento->TdoId;?> <?php echo ($DatTipoDocumento->TdoId==$InsAlmacenMovimientoEntrada->TdoIdInternacional6)?'selected="selected"':"";?> value="<?php echo $DatTipoDocumento->TdoId?>"><?php echo $DatTipoDocumento->TdoCodigo?> - <?php echo $DatTipoDocumento->TdoNombre?></option>
	            <?php
			}
			?>
	            </select></td>
	          <td><a href="javascript:FncProveedorNuevo('Internacional','6');"><img src="imagenes/registrar.png" width="20" height="20" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
	          <td><input name="CmpInternacionalProveedorId6" type="hidden" class="EstFormularioCaja" id="CmpInternacionalProveedorId6" value="<?php echo $InsAlmacenMovimientoEntrada->PrvIdInternacional6;?>" size="20" maxlength="20" />	            <input name="CmpInternacionalProveedorNumeroDocumento6" type="text" class="EstFormularioCaja" id="CmpInternacionalProveedorNumeroDocumento6" value="<?php echo $InsAlmacenMovimientoEntrada->PrvNumeroDocumentoInternacional6;?>" size="20" maxlength="20" /></td>
	          <td><a href="javascript:FncProveedorBuscar('NumeroDocumento','Internacional','6');"><img src="imagenes/buscar2.gif" width="25" height="25" alt="[Buscar]" align="absmiddle" title="Buscar" border="0"  /></a></td>
	          <td>
              
<a id="BtnInternacionalProveedorRegistrar6" onclick="FncProveedorCargarFormulario('Registrar','Internacional','6');"  href="javascript:void(0)" title="">
<img src="imagenes/nuevo.png" alt="[Registrar]" width="20" height="20" border="0" align="absmiddle" title="Registrar" />
</a>
<a id="BtnInternacionalProveedorEditar6" onclick="FncProveedorCargarFormulario('Editar','Internacional','6');" href="javascript:void(0)"   title="">
<img src="imagenes/editar.png" alt="[Editar]" width="20" height="20" border="0" align="absmiddle" title="Editar" />
</a></td>
	          <td><input name="CmpInternacionalProveedorNombre6" type="text" class="EstFormularioCaja" id="CmpInternacionalProveedorNombre6" value="<?php echo $InsAlmacenMovimientoEntrada->PrvNombreInternacional6;?>" size="50" maxlength="100" /></td>
	          <td><a href="formularios/AlmacenMovimientoEntrada/FrmProveedorBuscar.php?height=440&amp;width=850&amp;Ruta=6&amp;Tipo=Internacional" class="thickbox" title="">[...]</a></td>
	          <td>&nbsp;</td>
	          </tr>
	        <tr>
	          <td align="left" class="EstFormulario">Gastos Administrativos:</td>
	          <td><input name="CmpInternacionalNumeroComprobante7" type="text" class="EstFormularioCaja" id="CmpInternacionalNumeroComprobante7" value="<?php echo $InsAlmacenMovimientoEntrada->AmoInternacionalNumeroComprobante7;?>" size="20" maxlength="20" /></td>
	          <td><span id="sprytextfield16">
	            <input class="EstFormularioCaja" onchange="FncAlmacenMovimientoEntradaCostoVinculadoListar();" name="CmpTotalGastoAdministrativo" type="text" id="CmpTotalGastoAdministrativo" value="<?php if(empty($InsAlmacenMovimientoEntrada->AmoInternacionalTotalGastoAdministrativo)){ echo "0.00"; }else{echo number_format($InsAlmacenMovimientoEntrada->AmoInternacionalTotalGastoAdministrativo,2);}?>" size="10" maxlength="5" />
	            <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg"><img src="imagenes/advertencia.png" width="20" height="20" border="0" align="absmiddle" title="Formato no valido" alt="[A]"  /></span></span></td>
	          <td><select class="EstFormularioCombo" name="CmpInternacionalMonedaId7" id="CmpInternacionalMonedaId7">
	            <option value="">Escoja una opcion</option>
	            <?php
			  foreach($ArrMonedas as $DatMoneda){
			  ?>
	            <option value="<?php echo $DatMoneda->MonId?>" <?php if($InsAlmacenMovimientoEntrada->MonIdInternacional1==$DatMoneda->MonId){ echo 'selected="selected"';}elseif($EmpresaMonedaId==$DatMoneda->MonId){  echo 'selected="selected"';}?> ><?php echo $DatMoneda->MonNombre?> ( <?php echo $DatMoneda->MonSimbolo;?>)</option>
	            <?php
			  }
			  ?>
	            </select></td>
	          <td><select class="EstFormularioCombo" name="CmpInternacionalProveedorTipoDocumento7" id="CmpInternacionalProveedorTipoDocumento7">
	            <option value="">Escoja una opcion</option>
	            <?php
			foreach($ArrTipoDocumentos as $DatTipoDocumento){
			?>
	            <option <?php echo $DatTipoDocumento->TdoId;?> <?php echo ($DatTipoDocumento->TdoId==$InsAlmacenMovimientoEntrada->TdoIdInternacional7)?'selected="selected"':"";?> value="<?php echo $DatTipoDocumento->TdoId?>"><?php echo $DatTipoDocumento->TdoCodigo?> - <?php echo $DatTipoDocumento->TdoNombre?></option>
	            <?php
			}
			?>
	            </select></td>
	          <td><a href="javascript:FncProveedorNuevo('Internacional','7');"><img src="imagenes/registrar.png" width="20" height="20" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
	          <td><input name="CmpInternacionalProveedorId7" type="hidden" class="EstFormularioCaja" id="CmpInternacionalProveedorId7" value="<?php echo $InsAlmacenMovimientoEntrada->PrvIdInternacional7;?>" size="20" maxlength="20" />	            <input name="CmpInternacionalProveedorNumeroDocumento7" type="text" class="EstFormularioCaja" id="CmpInternacionalProveedorNumeroDocumento7" value="<?php echo $InsAlmacenMovimientoEntrada->PrvNumeroDocumentoInternacional7;?>" size="20" maxlength="20" /></td>
	          <td><a href="javascript:FncProveedorBuscar('NumeroDocumento','Internacional','7');"><img src="imagenes/buscar2.gif" width="25" height="25" alt="[Buscar]" align="absmiddle" title="Buscar" border="0"  /></a></td>
	          <td>
              
<a id="BtnInternacionalProveedorRegistrar7" onclick="FncProveedorCargarFormulario('Registrar','Internacional','7');"  href="javascript:void(0)" title="">
<img src="imagenes/nuevo.png" alt="[Registrar]" width="20" height="20" border="0" align="absmiddle" title="Registrar" />
</a>
<a id="BtnInternacionalProveedorEditar7" onclick="FncProveedorCargarFormulario('Editar','Internacional','7');" href="javascript:void(0)"   title="">
<img src="imagenes/editar.png" alt="[Editar]" width="20" height="20" border="0" align="absmiddle" title="Editar" />
</a>
			</td>
	          <td><input name="CmpInternacionalProveedorNombre7" type="text" class="EstFormularioCaja" id="CmpInternacionalProveedorNombre7" value="<?php echo $InsAlmacenMovimientoEntrada->PrvNombreInternacional7;?>" size="50" maxlength="100" /></td>
	          <td><a href="formularios/AlmacenMovimientoEntrada/FrmProveedorBuscar.php?height=440&amp;width=850&amp;Ruta=7&amp;Tipo=Internacional" class="thickbox" title="">[...]</a></td>
	          <td>&nbsp;</td>
	          </tr>
	        <tr>
	          <td align="left" class="EstFormulario">Otros Costos 1:</td>
	          <td><input name="CmpInternacionalNumeroComprobante8" type="text" class="EstFormularioCaja" id="CmpInternacionalNumeroComprobante8" value="<?php echo $InsAlmacenMovimientoEntrada->AmoInternacionalNumeroComprobante8;?>" size="20" maxlength="20" /></td>
	          <td><span id="sprytextfield17">
	            <input class="EstFormularioCaja" onchange="FncAlmacenMovimientoEntradaCostoVinculadoListar();" name="CmpTotalOtroCosto1" type="text" id="CmpTotalOtroCosto1" value="<?php if(empty($InsAlmacenMovimientoEntrada->AmoInternacionalTotalOtroCosto1)){ echo "0.00"; }else{echo number_format($InsAlmacenMovimientoEntrada->AmoInternacionalTotalOtroCosto1,2);}?>" size="10" maxlength="5" />
	            <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg"><img src="imagenes/advertencia.png" width="20" height="20" border="0" align="absmiddle" title="Formato no valido" alt="[A]"  /></span></span></td>
	          <td><select class="EstFormularioCombo" name="CmpInternacionalMonedaId8" id="CmpInternacionalMonedaId8">
	            <option value="">Escoja una opcion</option>
	            <?php
			  foreach($ArrMonedas as $DatMoneda){
			  ?>
	            <option value="<?php echo $DatMoneda->MonId?>" <?php if($InsAlmacenMovimientoEntrada->MonIdInternacional1==$DatMoneda->MonId){ echo 'selected="selected"';}elseif($EmpresaMonedaId==$DatMoneda->MonId){  echo 'selected="selected"';}?> ><?php echo $DatMoneda->MonNombre?> ( <?php echo $DatMoneda->MonSimbolo;?>)</option>
	            <?php
			  }
			  ?>
	            </select></td>
	          <td><select class="EstFormularioCombo" name="CmpInternacionalProveedorTipoDocumento8" id="CmpInternacionalProveedorTipoDocumento8">
	            <option value="">Escoja una opcion</option>
	            <?php
			foreach($ArrTipoDocumentos as $DatTipoDocumento){
			?>
	            <option <?php echo $DatTipoDocumento->TdoId;?> <?php echo ($DatTipoDocumento->TdoId==$InsAlmacenMovimientoEntrada->TdoIdInternacional8)?'selected="selected"':"";?> value="<?php echo $DatTipoDocumento->TdoId?>"><?php echo $DatTipoDocumento->TdoCodigo?> - <?php echo $DatTipoDocumento->TdoNombre?></option>
	            <?php
			}
			?>
	            </select></td>
	          <td><a href="javascript:FncProveedorNuevo('Internacional','8');"><img src="imagenes/registrar.png" width="20" height="20" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
	          <td><input name="CmpInternacionalProveedorId8" type="hidden" class="EstFormularioCaja" id="CmpInternacionalProveedorId8" value="<?php echo $InsAlmacenMovimientoEntrada->PrvIdInternacional8;?>" size="20" maxlength="20" />	            <input name="CmpInternacionalProveedorNumeroDocumento8" type="text" class="EstFormularioCaja" id="CmpInternacionalProveedorNumeroDocumento8" value="<?php echo $InsAlmacenMovimientoEntrada->PrvNumeroDocumentoInternacional8;?>" size="20" maxlength="20" /></td>
	          <td><a href="javascript:FncProveedorBuscar('NumeroDocumento','Internacional','8');"><img src="imagenes/buscar2.gif" width="25" height="25" alt="[Buscar]" align="absmiddle" title="Buscar" border="0"  /></a></td>
	          <td>

<a id="BtnInternacionalProveedorRegistrar8" onclick="FncProveedorCargarFormulario('Registrar','Internacional','8');"  href="javascript:void(0)" title="">
<img src="imagenes/nuevo.png" alt="[Registrar]" width="20" height="20" border="0" align="absmiddle" title="Registrar" />
</a>

<a id="BtnInternacionalProveedorEditar8" onclick="FncProveedorCargarFormulario('Editar','Internacional','8');" href="javascript:void(0)"   title="">
<img src="imagenes/editar.png" alt="[Editar]" width="20" height="20" border="0" align="absmiddle" title="Editar" />
</a>
			</td>
	          <td><input name="CmpInternacionalProveedorNombre8" type="text" class="EstFormularioCaja" id="CmpInternacionalProveedorNombre8" value="<?php echo $InsAlmacenMovimientoEntrada->PrvNombreInternacional8;?>" size="50" maxlength="100" /></td>
	          <td><a href="formularios/AlmacenMovimientoEntrada/FrmProveedorBuscar.php?height=440&amp;width=850&amp;Ruta=8&amp;Tipo=Internacional" class="thickbox" title="">[...]</a></td>
	          <td>&nbsp;</td>
	          </tr>
	        <tr>
	          <td align="left" class="EstFormulario">Otros Costos 2:</td>
	          <td><input name="CmpInternacionalNumeroComprobante9" type="text" class="EstFormularioCaja" id="CmpInternacionalNumeroComprobante9" value="<?php echo $InsAlmacenMovimientoEntrada->AmoInternacionalNumeroComprobante9;?>" size="20" maxlength="20" /></td>
	          <td><span id="sprytextfield18">
	            <input class="EstFormularioCaja" onchange="FncAlmacenMovimientoEntradaCostoVinculadoListar();" name="CmpTotalOtroCosto2" type="text" id="CmpTotalOtroCosto2" value="<?php if(empty($InsAlmacenMovimientoEntrada->AmoInternacionalTotalOtroCosto2)){ echo "0.00"; }else{echo number_format($InsAlmacenMovimientoEntrada->AmoInternacionalTotalOtroCosto2,2);}?>" size="10" maxlength="5" />
	            <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg"><img src="imagenes/advertencia.png" width="20" height="20" border="0" align="absmiddle" title="Formato no valido" alt="[A]"  /></span></span></td>
	          <td><select class="EstFormularioCombo" name="CmpInternacionalMonedaId9" id="CmpInternacionalMonedaId9">
	            <option value="">Escoja una opcion</option>
	            <?php
			  foreach($ArrMonedas as $DatMoneda){
			  ?>
	            <option value="<?php echo $DatMoneda->MonId?>" <?php if($InsAlmacenMovimientoEntrada->MonIdInternacional1==$DatMoneda->MonId){ echo 'selected="selected"';}elseif($EmpresaMonedaId==$DatMoneda->MonId){  echo 'selected="selected"';}?> ><?php echo $DatMoneda->MonNombre?> ( <?php echo $DatMoneda->MonSimbolo;?>)</option>
	            <?php
			  }
			  ?>
	            </select></td>
	          <td><select class="EstFormularioCombo" name="CmpInternacionalProveedorTipoDocumento9" id="CmpInternacionalProveedorTipoDocumento9">
	            <option value="">Escoja una opcion</option>
	            <?php
			foreach($ArrTipoDocumentos as $DatTipoDocumento){
			?>
	            <option <?php echo $DatTipoDocumento->TdoId;?> <?php echo ($DatTipoDocumento->TdoId==$InsAlmacenMovimientoEntrada->TdoIdInternacional9)?'selected="selected"':"";?> value="<?php echo $DatTipoDocumento->TdoId?>"><?php echo $DatTipoDocumento->TdoCodigo?> - <?php echo $DatTipoDocumento->TdoNombre?></option>
	            <?php
			}
			?>
	            </select></td>
	          <td><a href="javascript:FncProveedorNuevo('Internacional','9');"><img src="imagenes/registrar.png" width="20" height="20" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
	          <td><input name="CmpInternacionalProveedorId9" type="hidden" class="EstFormularioCaja" id="CmpInternacionalProveedorId9" value="<?php echo $InsAlmacenMovimientoEntrada->PrvIdInternacional9;?>" size="20" maxlength="20" />	            <input name="CmpInternacionalProveedorNumeroDocumento9" type="text" class="EstFormularioCaja" id="CmpInternacionalProveedorNumeroDocumento9" value="<?php echo $InsAlmacenMovimientoEntrada->PrvNumeroDocumentoInternacional9;?>" size="20" maxlength="20" /></td>
	          <td><a href="javascript:FncProveedorBuscar('NumeroDocumento','Internacional','9');"><img src="imagenes/buscar2.gif" width="25" height="25" alt="[Buscar]" align="absmiddle" title="Buscar" border="0"  /></a></td>
	          <td>
              
<a id="BtnInternacionalProveedorRegistrar9" onclick="FncProveedorCargarFormulario('Registrar','Internacional','9');"  href="javascript:void(0)" title="">
<img src="imagenes/nuevo.png" alt="[Registrar]" width="20" height="20" border="0" align="absmiddle" title="Registrar" />
</a>
<a id="BtnInternacionalProveedorEditar9" onclick="FncProveedorCargarFormulario('Editar','Internacional','9');" href="javascript:void(0)"   title="">
<img src="imagenes/editar.png" alt="[Editar]" width="20" height="20" border="0" align="absmiddle" title="Editar" />
</a>

</td>
	          <td><input name="CmpInternacionalProveedorNombre9" type="text" class="EstFormularioCaja" id="CmpInternacionalProveedorNombre9" value="<?php echo $InsAlmacenMovimientoEntrada->PrvNombreInternacional9;?>" size="50" maxlength="100" /></td>
	          <td><a href="formularios/AlmacenMovimientoEntrada/FrmProveedorBuscar.php?height=440&amp;width=850&amp;Ruta=9&amp;Tipo=Internacional" class="thickbox" title="">[...]</a></td>
	          <td>&nbsp;</td>
	          </tr>
	        <tr>
	          <td class="EstFormulario">Total Importacion:</td>
	          <td>&nbsp;</td>
	          <td><span id="sprytextfield19">
	            <label for="CmpTotalCostoImportacion"></label>
	            <input class="EstFormularioCaja" name="CmpTotaImportacion" type="text" id="CmpTotaImportacion" value="<?php if(empty($InsAlmacenMovimientoEntrada->AmoTotalImportacion)){ echo "0.00"; }else{echo number_format($InsAlmacenMovimientoEntrada->AmoTotalImportacion,2);}?>" size="10" maxlength="5" readonly="readonly" />
	            <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
	          <td>&nbsp;</td>
	          <td>&nbsp;</td>
	          <td>&nbsp;</td>
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
	          <td>&nbsp;</td>
	          <td>&nbsp;</td>
	          <td>&nbsp;</td>
	          <td>&nbsp;</td>
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
	      <td>&nbsp;</td>
	      </tr>
	    <tr>
	      <td>&nbsp;</td>
	      <td colspan="5">
          
          <div id="CapCostoNacionales">
          
          
          
          <table border="0" cellpadding="2" cellspacing="2">
	        <tr>
	          <td>COSTOS NACIONALES</td>
	          <td align="center">Num. Comprob.</td>
	          <td align="center">Monto</td>
	          <td align="center">Moneda</td>
	          <td align="center">Tipo Doc.</td>
	          <td align="center">&nbsp;</td>
	          <td align="center">Num. Documento</td>
	          <td align="center">&nbsp;</td>
	          <td align="center">&nbsp;</td>
	          <td align="center">Proveedor</td>
	          <td>&nbsp;</td>
	          </tr>
	        <tr>
	          <td align="left" valign="top">Recargo:</td>
	          <td align="left" valign="top">-</td>
	          <td align="left" valign="top"><span id="sprytextfield2">
	        <input class="EstFormularioCaja" onchange="FncAlmacenMovimientoEntradaCostoVinculadoListar();" name="CmpTotalRecargo" type="text" id="CmpTotalRecargo" value="<?php if(empty($InsAlmacenMovimientoEntrada->AmoNacionalTotalRecargo)){ echo "0.00"; }else{echo number_format($InsAlmacenMovimientoEntrada->AmoNacionalTotalRecargo,2);}?>" size="10" maxlength="10" />
	        <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg"><img src="imagenes/advertencia.png" width="20" height="20" border="0" align="absmiddle" title="Formato no valido" alt="[A]"  /></span></span></td>
	          <td align="left" valign="top">-</td>
	          <td align="left" valign="top">-</td>
	          <td align="left" valign="top">&nbsp;</td>
	          <td align="left" valign="top">-</td>
	          <td align="left" valign="top">&nbsp;</td>
	          <td align="left" valign="top">&nbsp;</td>
	          <td align="left" valign="top">-</td>
	          <td align="center">-</td>
	          </tr>
	        <tr>
	          <td align="left" valign="top">Flete:</td>
	          <td align="left" valign="top"><input name="CmpNacionalNumeroComprobante2" type="text" class="EstFormularioCaja" id="CmpNacionalNumeroComprobante2" value="<?php echo $InsAlmacenMovimientoEntrada->AmoNacionalNumeroComprobante2;?>" size="20" maxlength="20" /></td>
	          <td align="left" valign="top"><span id="sprytextfield3">
	        <input class="EstFormularioCaja" onchange="FncAlmacenMovimientoEntradaCostoVinculadoListar();" name="CmpTotalFlete" type="text" id="CmpTotalFlete" value="<?php if(empty($InsAlmacenMovimientoEntrada->AmoNacionalTotalFlete)){ echo "0.00"; }else{echo number_format($InsAlmacenMovimientoEntrada->AmoNacionalTotalFlete,2);}?>" size="10" maxlength="10" />
	        <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg"><img src="imagenes/advertencia.png" width="20" height="20" border="0" align="absmiddle" title="Formato no valido" alt="[A]"  /></span></span></td>
	          <td align="left" valign="top"><select class="EstFormularioCombo" name="CmpNacionalMonedaId2" id="CmpNacionalMonedaId2">
	            <option value="">Escoja una opcion</option>
	            <?php
			  foreach($ArrMonedas as $DatMoneda){
			  ?>
	            <option value="<?php echo $DatMoneda->MonId?>" <?php if($InsAlmacenMovimientoEntrada->MonIdInternacional1==$DatMoneda->MonId){ echo 'selected="selected"';}elseif($EmpresaMonedaId==$DatMoneda->MonId){  echo 'selected="selected"';}?> ><?php echo $DatMoneda->MonNombre?> ( <?php echo $DatMoneda->MonSimbolo;?>)</option>
	            <?php
			  }
			  ?>
	            </select></td>
	          <td align="left" valign="top"><select class="EstFormularioCombo" name="CmpNacionalProveedorTipoDocumento2" id="CmpNacionalProveedorTipoDocumento2">
	            <option value="">Escoja una opcion</option>
	            <?php
			foreach($ArrTipoDocumentos as $DatTipoDocumento){
			?>
	            <option <?php echo $DatTipoDocumento->TdoId;?> <?php echo ($DatTipoDocumento->TdoId==$InsAlmacenMovimientoEntrada->TdoIdNacional2)?'selected="selected"':"";?> value="<?php echo $DatTipoDocumento->TdoId?>"><?php echo $DatTipoDocumento->TdoCodigo?> - <?php echo $DatTipoDocumento->TdoNombre?></option>
	            <?php
			}
			?>
	            </select></td>
	          <td align="left" valign="top"><a href="javascript:FncProveedorNuevo('Nacional','2');"><img src="imagenes/registrar.png" width="20" height="20" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
	          <td align="left" valign="top"><input name="CmpNacionalProveedorId2" type="hidden" class="EstFormularioCaja" id="CmpNacionalProveedorId2" value="<?php echo $InsAlmacenMovimientoEntrada->PrvIdNacional2;?>" size="20" maxlength="20" />	            <input name="CmpNacionalProveedorNumeroDocumento2" type="text" class="EstFormularioCaja" id="CmpNacionalProveedorNumeroDocumento2" value="<?php echo $InsAlmacenMovimientoEntrada->PrvNumeroDocumentoNacional2;?>" size="20" maxlength="20" /></td>
	          <td align="left" valign="top"><a href="javascript:FncProveedorBuscar('NumeroDocumento','Nacional','2');"><img src="imagenes/buscar2.gif" width="25" height="25" alt="[Buscar]" align="absmiddle" title="Buscar" border="0"  /></a></td>
	          <td align="left" valign="top">

<a id="BtnNacionalProveedorRegistrar2" onclick="FncProveedorCargarFormulario('Registrar','Nacional','2');"  href="javascript:void(0)" title="">
<img src="imagenes/nuevo.png" alt="[Registrar]" width="20" height="20" border="0" align="absmiddle" title="Registrar" />
</a>

<a id="BtnNacionalProveedorEditar2" onclick="FncProveedorCargarFormulario('Editar','Nacional','2');" href="javascript:void(0)"   title="">
<img src="imagenes/editar.png" alt="[Editar]" width="20" height="20" border="0" align="absmiddle" title="Editar" />
</a>

              </td>
	          <td align="left" valign="top"><input name="CmpNacionalProveedorNombre2" type="text" class="EstFormularioCaja" id="CmpNacionalProveedorNombre2" value="<?php echo $InsAlmacenMovimientoEntrada->PrvNombreNacional2;?>" size="50" maxlength="100" /></td>
	          <td><a href="formularios/AlmacenMovimientoEntrada/FrmProveedorBuscar.php?height=440&amp;width=850&amp;Ruta=2&amp;Tipo=Nacional" class="thickbox" title="">[...]</a></td>
	          </tr>
	       
	        <tr>
	          <td align="left" valign="top">Otro Costo Nacional:</td>
	          <td align="left" valign="top"><input name="CmpNacionalNumeroComprobante3" type="text" class="EstFormularioCaja" id="CmpNacionalNumeroComprobante3" value="<?php echo $InsAlmacenMovimientoEntrada->AmoNacionalNumeroComprobante3;?>" size="20" maxlength="20" /></td>
	          <td align="left" valign="top"><span id="sprytextfield6">
	        <input class="EstFormularioCaja" onchange="FncAlmacenMovimientoEntradaCostoVinculadoListar();" name="CmpTotalOtroCosto" type="text" id="CmpTotalOtroCosto" value="<?php if(empty($InsAlmacenMovimientoEntrada->AmoNacionalTotalOtroCosto)){ echo "0.00"; }else{echo number_format($InsAlmacenMovimientoEntrada->AmoNacionalTotalOtroCosto,2);}?>" size="10" maxlength="10" />
	        <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg"><img src="imagenes/advertencia.png" width="20" height="20" border="0" align="absmiddle" title="Formato no valido" alt="[A]"  /></span></span></td>
	          <td align="left" valign="top"><select class="EstFormularioCombo" name="CmpNacionalMonedaId3" id="CmpNacionalMonedaId3">
	            <option value="">Escoja una opcion</option>
	            <?php
			  foreach($ArrMonedas as $DatMoneda){
			  ?>
	            <option value="<?php echo $DatMoneda->MonId?>" <?php if($InsAlmacenMovimientoEntrada->MonIdInternacional1==$DatMoneda->MonId){ echo 'selected="selected"';}elseif($EmpresaMonedaId==$DatMoneda->MonId){  echo 'selected="selected"';}?> ><?php echo $DatMoneda->MonNombre?> ( <?php echo $DatMoneda->MonSimbolo;?>)</option>
	            <?php
			  }
			  ?>
	            </select></td>
	          <td align="left" valign="top"><select class="EstFormularioCombo" name="CmpNacionalProveedorTipoDocumento3" id="CmpNacionalProveedorTipoDocumento3">
	            <option value="">Escoja una opcion</option>
	            <?php
			foreach($ArrTipoDocumentos as $DatTipoDocumento){
			?>
	            <option <?php echo $DatTipoDocumento->TdoId;?> <?php echo ($DatTipoDocumento->TdoId==$InsAlmacenMovimientoEntrada->TdoIdNacional3)?'selected="selected"':"";?> value="<?php echo $DatTipoDocumento->TdoId?>"><?php echo $DatTipoDocumento->TdoCodigo?> - <?php echo $DatTipoDocumento->TdoNombre?></option>
	            <?php
			}
			?>
	            </select></td>
	          <td align="left" valign="top"><a href="javascript:FncProveedorNuevo('Nacional','3');"><img src="imagenes/registrar.png" width="20" height="20" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
	          <td align="left" valign="top"><input name="CmpNacionalProveedorId3" type="hidden" class="EstFormularioCaja" id="CmpNacionalProveedorId3" value="<?php echo $InsAlmacenMovimientoEntrada->PrvIdNacional3;?>" size="20" maxlength="20" />	            <input name="CmpNacionalProveedorNumeroDocumento3" type="text" class="EstFormularioCaja" id="CmpNacionalProveedorNumeroDocumento3" value="<?php echo $InsAlmacenMovimientoEntrada->PrvNumeroDocumentoNacional3;?>" size="20" maxlength="20" /></td>
	          <td align="left" valign="top"><a href="javascript:FncProveedorBuscar('NumeroDocumento','Nacional','3');"><img src="imagenes/buscar2.gif" width="25" height="25" alt="[Buscar]" align="absmiddle" title="Buscar" border="0"  /></a></td>
	          <td align="left" valign="top">

<a id="BtnNacionalProveedorRegistrar3" onclick="FncProveedorCargarFormulario('Registrar','Nacional','3');"  href="javascript:void(0)" title="">
<img src="imagenes/nuevo.png" alt="[Registrar]" width="20" height="20" border="0" align="absmiddle" title="Registrar" />
</a>

<a id="BtnNacionalProveedorEditar3" onclick="FncProveedorCargarFormulario('Editar','Nacional','3');" href="javascript:void(0)"   title="">
<img src="imagenes/editar.png" alt="[Editar]" width="20" height="20" border="0" align="absmiddle" title="Editar" />
</a>

			</td>
	          <td align="left" valign="top"><input name="CmpNacionalProveedorNombre3" type="text" class="EstFormularioCaja" id="CmpNacionalProveedorNombre3" value="<?php echo $InsAlmacenMovimientoEntrada->PrvNombreNacional3;?>" size="50" maxlength="100" /></td>
	          <td><a href="formularios/AlmacenMovimientoEntrada/FrmProveedorBuscar.php?height=440&amp;width=850&amp;Ruta=3&amp;Tipo=Nacional" class="thickbox" title="">[...]</a></td>
	          </tr>
              
               <tr>
                 <td align="left" valign="top">Flete escaneado:</td>
                 <td colspan="3" align="left" valign="top"><iframe src="formularios/AlmacenMovimientoEntrada/acc/AccAlmacenMovimientoEntradaNacionalFoto2SubirArchivo.php?Identificador=<?php echo $Identificador;?>" id="IfrAlmacenMovimientoNacionalFoto2EntradaSubirArchivo" name="IfrAlmacenMovimientoEntradaNacionalFoto2SubirArchivo" scrolling="auto"  frameborder="0"  width="400" height="200"></iframe></td>
                 <td align="left" valign="top">Otro Costo escaneado:</td>
                 <td colspan="5" align="left" valign="top"><iframe src="formularios/AlmacenMovimientoEntrada/acc/AccAlmacenMovimientoEntradaNacionalFoto3SubirArchivo.php?Identificador=<?php echo $Identificador;?>" id="IfrAlmacenMovimientoNacionalFoto3EntradaSubirArchivo" name="IfrAlmacenMovimientoEntradaNacionalFoto3SubirArchivo" scrolling="auto"  frameborder="0"  width="400" height="200"></iframe></td>
                 <td>&nbsp;</td>
               </tr>
               <tr>
	          <td>&nbsp;</td>
	          <td>&nbsp;</td>
	          <td>&nbsp;</td>
	          <td>&nbsp;</td>
	          <td>&nbsp;</td>
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
	      <td>&nbsp;</td>
	      </tr>
	    <tr>
	      <td>&nbsp;</td>
	      <td>&nbsp;</td>
	      <td>&nbsp;</td>
	      <td>&nbsp;</td>
	      <td>&nbsp;</td>
	      <td>&nbsp;</td>
	      <td>&nbsp;</td>
	      </tr>
	    <tr>
	      <td>&nbsp;</td>
	      <td colspan="5">
          <div class="EstFormularioArea" >
                <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="2"><div class="EstFormularioAccion" id="CapCostoVinculadoAccion">Listo
                      para registrar elementos</div></td>
                    <td>&nbsp;</td>
                    </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td><span class="EstFormularioSubTitulo"> Elementos que componen los costos vinculados de la ENTRADA A ALMACEN</span></td>
                    <td align="right"> 
                      <a href="javascript:FncAlmacenMovimientoEntradaCostoVinculadoListar();"><img  src="imagenes/recargar.gif"  width="20" height="20"  border="0" title="Recargar"   alt="[Recargar]" align="absmiddle"/> Recargar</a>
                      
                      

                      
                      
                      
                      
                      </td>
                    <td>&nbsp;</td>
                    </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="2"><div id="CapAlmacenMovimientoEntradaCostoVinculados" class="EstCapAlmacenMovimientoEntradaCostoVinculados" > </div></td>
                    <td><div id="CapAlmacenMovimientoEntradaCostoVinculadosResultado"> </div></td>
                    </tr>
                  </table>
                </div>
          </td>
	      <td>&nbsp;</td>
	      </tr>
	    <tr>
	      <td>&nbsp;</td>
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

<script type="text/javascript">
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5");
var sprytextfield7 = new Spry.Widget.ValidationTextField("sprytextfield7", "date", {format:"dd/mm/yyyy"});
var spryselect3 = new Spry.Widget.ValidationSelect("spryselect3");
var spryselect3 = new Spry.Widget.ValidationSelect("spryselect3");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "currency");
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "currency");
var sprytextfield6 = new Spry.Widget.ValidationTextField("sprytextfield6", "currency");
var sprytextfield10 = new Spry.Widget.ValidationTextField("sprytextfield10", "currency");
var sprytextfield11 = new Spry.Widget.ValidationTextField("sprytextfield11", "currency");
var sprytextfield12 = new Spry.Widget.ValidationTextField("sprytextfield12", "currency");
var sprytextfield13 = new Spry.Widget.ValidationTextField("sprytextfield13", "currency");
var sprytextfield14 = new Spry.Widget.ValidationTextField("sprytextfield14", "currency");
var sprytextfield15 = new Spry.Widget.ValidationTextField("sprytextfield15", "currency");
var sprytextfield16 = new Spry.Widget.ValidationTextField("sprytextfield16", "currency");
var sprytextfield17 = new Spry.Widget.ValidationTextField("sprytextfield17", "currency");
var sprytextfield18 = new Spry.Widget.ValidationTextField("sprytextfield18", "currency");
var sprytextfield19 = new Spry.Widget.ValidationTextField("sprytextfield19");
var spryselect = new Spry.Widget.ValidationSelect("spryselect");
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "date", {format:"dd/mm/yyyy"});
var spryselect2 = new Spry.Widget.ValidationSelect("spryselect2");
var sprytextfield9 = new Spry.Widget.ValidationTextField("sprytextfield9");
var sprytextfield20 = new Spry.Widget.ValidationTextField("sprytextfield20");
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1");
var sprytextfield21 = new Spry.Widget.ValidationTextField("sprytextfield21");
var spryselect2 = new Spry.Widget.ValidationSelect("spryselect2");
var sprytextfield8 = new Spry.Widget.ValidationTextField("sprytextfield8", "date", {format:"dd/mm/yyyy", isRequired:false});
var spryselect4 = new Spry.Widget.ValidationSelect("spryselect4");
</script>
<?php
}else{
	echo ERR_GEN_101;
}


if(!$_SESSION['MysqlDeb']){
	$InsMensaje->MtdRedireccionar("principal.php?Mod=".$GET_mod."&Form=Listado",$Registro,1500);
}
?>
