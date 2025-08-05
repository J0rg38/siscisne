<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"TrasladoAlmacenEntrada",$GET_form)){
?>   

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Proveedor');?>JsProveedorFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Proveedor');?>JsProveedorAutocompletar.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Producto");?>JsProductoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Producto");?>JsProductoAutocompletar.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Moneda');?>JsMonedaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('TipoCambio');?>JsTipoCambioFunciones.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsTrasladoAlmacenEntradaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsTrasladoAlmacenEntradaDetalleFunciones.js" ></script>

<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssTrasladoAlmacenEntrada.css');
</style>

<?php
if(!empty($_POST['Identificador'])){
	$Identificador = $_POST['Identificador'];
}

$GET_TasId = $_GET['TasId'];
$GET_Ori = $_GET['Origen'];

$Registro = false;

include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjTrasladoAlmacenEntrada.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsTrasladoAlmacenSalida.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsTrasladoAlmacenSalidaDetalle.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsTrasladoAlmacenEntrada.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsTrasladoAlmacenEntradaDetalle.php');
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
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenProducto.php');

$InsTrasladoAlmacenEntrada = new ClsTrasladoAlmacenEntrada();
$InsComprobanteTipo = new ClsComprobanteTipo();
$InsTipoOperacion = new ClsTipoOperacion();
$InsMoneda = new ClsMoneda();
$InsTipoDocumento = new ClsTipoDocumento();
$InsProducto = new ClsProducto();
$InsUnidadMedida = new ClsUnidadMedida();
$InsUnidadMedidaConversion = new ClsUnidadMedidaConversion();
$InsCondicionPago = new ClsCondicionPago();
$InsAlmacen = new ClsAlmacen();

if (!isset($_SESSION['InsTrasladoAlmacenEntradaDetalle'.$Identificador])){	
	$_SESSION['InsTrasladoAlmacenEntradaDetalle'.$Identificador] = new ClsSesionObjeto();
}else{	
	$_SESSION['InsTrasladoAlmacenEntradaDetalle'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsTrasladoAlmacenEntradaDetalle'.$Identificador]);
}


include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccTrasladoAlmacenEntradaRegistrar.php');

$ResComprobanteTipo = $InsComprobanteTipo->MtdObtenerComprobanteTipos(NULL,NULL,"CtiCodigo","ASC",NULL);
$ArrComprobanteTipos = $ResComprobanteTipo['Datos'];

//MtdObtenerTipoOperaciones($oCampo=NULL,$oFiltro=NULL,$oOrden = 'TopId',$oSentido = 'Desc',$oPaginacion = '0,10',$oUso=NULL)

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
	$('#CmpFecha').focus();

	FncTrasladoAlmacenEntradaDetalleListar();
	
	
});
/*
Configuracion Formulario
*/
//var MonedaFuncion = "FncTrasladoAlmacenEntradaDetalleListar";

var TrasladoAlmacenEntradaDetalleEditar = 1;
var TrasladoAlmacenEntradaDetalleEliminar = 1;
</script>










<form id="FrmRegistrar" name="FrmRegistrar" method="post" action="#" enctype="multipart/form-data" onsubmit="FncGuardar();">

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
        TRANSFERENCIA DE ENTRADA</span></td>
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
                          <input type="hidden" name="CmpTiempoRegistroInicio" id="CmpTiempoRegistroInicio"  value="<?php echo $InsTrasladoAlmacenEntrada->TaeTiempoRegistroInicio; ?>" />
                          </span></td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left" valign="top">Codigo Interno:
                      
                      <input name="CmpProveedorId" type="hidden"  id="CmpProveedorId" value="<?php echo $InsTrasladoAlmacenEntrada->PrvId;?>"readonly="readonly" />
                      
                      </td>
                      <td align="left" valign="top"><input readonly="readonly" name="CmpId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpId" value="<?php echo $InsTrasladoAlmacenEntrada->TaeId;?>" size="15" maxlength="20" /></td>
                      <td align="left" valign="top">Fecha de Ingreso: <br><span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span> </td>
                      <td align="left" valign="top"><span id="sprytextfield1">
                        <label>
                          <input class="EstFormularioCajaFecha" name="CmpFecha" type="text" id="CmpFecha" value="<?php if(empty($InsTrasladoAlmacenEntrada->TaeFecha)){ echo date("d/m/Y");}else{ echo $InsTrasladoAlmacenEntrada->TaeFecha; }?>" size="10" maxlength="10" />
                          </label>
                        <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg"><img src="imagenes/advertencia.png" width="20" height="20" border="0" align="absmiddle" title="Formato no valido" alt="[A]"  /></span></span><img src="imagenes/acciones/calendario.png" alt="[Calendario]" id="BtnFecha" name="BtnFecha" width="25" height="25" align="absmiddle"  style="cursor:pointer;" /></td>
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
                        <option value="<?php echo $DatTipoOperacion->TopId?>" <?php if($InsTrasladoAlmacenEntrada->TopId==$DatTipoOperacion->TopId){ echo 'selected="selected"';} ?> ><?php echo $DatTipoOperacion->TopCodigo?> - <?php echo $DatTipoOperacion->TopNombre?></option>
                        <?php
			}
			?>
                      </select></td>
                      <td align="left" valign="top">Almacen Destino:</td>
                      <td align="left" valign="top"><select disabled="disabled" class="EstFormularioCombo" name="CmpAlmacen" id="CmpAlmacen">
                        <option value="">Escoja una opcion</option>
                        <?php
			foreach($ArrAlmacenes as $DatAlmacen){
			?>
                        <option value="<?php echo $DatAlmacen->AlmId?>" <?php if($InsTrasladoAlmacenEntrada->AlmId==$DatAlmacen->AlmId){ echo 'selected="selected"';} ?> ><?php echo $DatAlmacen->AlmNombre?></option>
                        <?php
			}
			?>
                      </select></td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td colspan="4" align="left" valign="top"><span class="EstFormularioSubTitulo">Datos de despacho</span></td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left" valign="top">Tipo de Comprobante:</td>
                      <td align="left" valign="top"><select disabled="disabled" class="EstFormularioCombo" name="CmpComprobanteTipo" id="CmpComprobanteTipo">
                        <option value="">Escoja una opcion</option>
                        <?php
			foreach($ArrComprobanteTipos as $DatComprobanteTipo){
			?>
                        <option value="<?php echo $DatComprobanteTipo->CtiId?>" <?php if($InsTrasladoAlmacenEntrada->CtiId==$DatComprobanteTipo->CtiId){ echo 'selected="selected"';} ?> ><?php echo $DatComprobanteTipo->CtiCodigo?> - <?php echo $DatComprobanteTipo->CtiNombre?></option>
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
                      <td align="left" valign="top"><input name="CmpComprobanteNumeroSerie" type="text" class="EstFormularioCajaDeshabilitada" id="CmpComprobanteNumeroSerie" value="<?php echo $InsTrasladoAlmacenEntrada->TaeComprobanteNumeroSerie;?>" size="10" maxlength="50" readonly="readonly" /> 
                        - 
                        <input name="CmpComprobanteNumeroNumero" type="text" class="EstFormularioCajaDeshabilitada" id="CmpComprobanteNumeroNumero" value="<?php echo $InsTrasladoAlmacenEntrada->TaeComprobanteNumeroNumero;?>" size="20" maxlength="50" readonly="readonly" /></td>
                      <td align="left" valign="top">Fecha de Comprobante: <br />
                        <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
                      <td align="left" valign="top"><input name="CmpComprobanteFecha" type="text" class="EstFormularioCajaDeshabilitada" id="CmpComprobanteFecha" value="<?php echo $InsTrasladoAlmacenEntrada->TaeComprobanteFecha;?>" size="10" maxlength="10" readonly="readonly" /></td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left" valign="top">Comprobante escaneado:</td>
                      <td colspan="3" align="left" valign="top"><iframe src="formularios/TrasladoAlmacenEntrada/acc/AccTrasladoAlmacenEntradaSubirArchivo.php?Identificador=<?php echo $Identificador;?>" id="IfrTrasladoAlmacenEntradaSubirArchivo" name="IfrTrasladoAlmacenEntradaSubirArchivo" scrolling="Auto"  frameborder="0" width="400" height="50"></iframe></td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td colspan="4" align="left" valign="top"><span class="EstFormularioSubTitulo">Observaciones y otras referencias</span></td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left" valign="top">Observaciones Internas:</td>
                      <td align="left" valign="top"><textarea name="CmpObservacion" cols="45" rows="2" class="EstFormularioCaja" id="CmpObservacion"><?php echo $InsTrasladoAlmacenEntrada->TaeObservacion;?></textarea></td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left" valign="top">Estado: </td>
                      <td align="left" valign="top"><?php
					switch($InsTrasladoAlmacenEntrada->TaeEstado){
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
                            <td colspan="13"><span class="EstFormularioSubTitulo">PRODUCTOS</span>
<input name="CmpProductoId"  type="hidden" class="EstFormularioCaja" id="CmpProductoId" size="10" maxlength="20" />
<input type="hidden" name="CmpProductoItem" id="CmpProductoItem" />
<input type="hidden" name="CmpProductoCostoAnterior" id="CmpProductoCostoAnterior" />
<input type="hidden" name="CmpProductoUnidadMedida" id="CmpProductoUnidadMedida" />
<input name="CmpProductoUnidadMedidaEquivalente"  type="hidden" class="EstFormularioCaja" id="CmpProductoUnidadMedidaEquivalente" size="3" maxlength="20"  />


                              <input name="CmpTrasladoAlmacenEntradaDetalleId"  type="hidden" class="EstFormularioCaja" id="CmpTrasladoAlmacenEntradaDetalleId" size="3" maxlength="20"  /></td>
                            </tr>
                          <tr>
                            <td>&nbsp;</td>
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
                            <td>Ubicacion:</td>
                            <td>Estado:</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            </tr>
                          <tr>
                            <td>&nbsp;</td>
                            <td><a href="javascript:FncTrasladoAlmacenEntradaDetalleNuevo();"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                            <td><input name="CmpProductoCodigoOriginal"  type="text" class="EstFormularioCaja" id="CmpProductoCodigoOriginal" size="10" maxlength="20" /></td>
                            <td><a href="javascript:FncProductoBuscar('CodigoOriginal');"><img src="imagenes/acciones/buscar.png" width="25" height="25" alt="[Buscar]" align="absmiddle" title="Buscar" border="0" /></a></td>
                            <td><input name="CmpProductoCodigoAlternativo"  type="text" class="EstFormularioCaja" id="CmpProductoCodigoAlternativo" size="10" maxlength="20" /></td>
                            <td><a href="javascript:FncProductoBuscar('CodigoAlternativo');"><img src="imagenes/acciones/buscar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                            <td><input name="CmpProductoNombre" type="text" class="EstFormularioCaja" id="CmpProductoNombre" size="40" /></td>
                            <td>             
                            <a id="BtnProductoRegistrar" onclick="FncProductoCargarFormulario('Registrar');"  href="javascript:void(0)" title=""> <img src="imagenes/acciones/registrar.png" alt="[Registrar]" width="25" height="25" border="0" align="absmiddle" title="Registrar" /></a>
                              <a id="BtnProductoEditar" onclick="FncProductoCargarFormulario('Editar');" href="javascript:void(0)"   title=""> <img src="imagenes/acciones/editar.png" alt="[Editar]" width="25" height="25" border="0" align="absmiddle" title="Editar" /></a>
                       </td>
                            <td><select  class="EstFormularioCombo" name="CmpProductoUnidadMedidaConvertir" id="CmpProductoUnidadMedidaConvertir" disabled="disabled">
                              </select></td>
                            <td>
                              
                              <input name="CmpProductoCantidad" type="text" class="EstFormularioCaja" id="CmpProductoCantidad" size="10" maxlength="10" />                            </td>
                            <td><input name="CmpTrasladoAlmacenEntradaDetalleUbicacion" type="text" class="EstFormularioCaja" id="CmpTrasladoAlmacenEntradaDetalleUbicacion" size="15" maxlength="45" /></td>
                            <td><select  class="EstFormularioCombo" name="CmpTrasladoAlmacenEntradaDetalleEstado" id="CmpTrasladoAlmacenEntradaDetalleEstado">
                              <option value="0">-</option>
                              <option value="1">No Llego</option>
                              <option value="2">Da&ntilde;ado</option>
                              <option selected="selected" value="3">Conforme</option>
                            </select></td>
                            <td><a href="javascript:FncTrasladoAlmacenEntradaDetalleGuardar();"><img src="imagenes/acciones/guardar.png" width="25" height="25" border="0" title="Guardar" alt="[Guardar]" align="absmiddle" /></a></td>
                            <td><!--<a href="comunes/Producto/FrmProductoBuscar.php?height=440&amp;width=850" class="thickbox" title=""><img src="imagenes/acciones/buscador.png" width="25" height="25" border="0" align="absmiddle" ></a>--></td>
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
                    <td width="49%" align="right"><a href="javascript:FncTrasladoAlmacenEntradaDetalleListar();">
                      <input type="hidden" name="CmpTrasladoAlmacenEntradaDetalleAccion" id="CmpTrasladoAlmacenEntradaDetalleAccion" value="AccTrasladoAlmacenEntradaDetalleRegistrar.php" />
                     <img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a> <a href="javascript:FncTrasladoAlmacenEntradaDetalleEliminarTodo();"><img  src="imagenes/acciones/listado_eliminar_todo.png"  width="25" height="25"  border="0" title="Eliminar Todo"   alt="[Eli. Todo.]" align="absmiddle"/> Eliminar Todo</a></td>
                    <td width="1%"><div id="CapTrasladoAlmacenEntradaDetallesResultado"> </div></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="2"><div id="CapTrasladoAlmacenEntradaDetalles" class="EstCapTrasladoAlmacenEntradaDetalles" > </div></td>
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
	button     : "BtnComprobanteFecha"// el id del botón que  

	});
	

</script>

<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "date", {format:"dd/mm/yyyy"});

</script>
<?php
}else{
	echo ERR_GEN_101;
}


if(!$_SESSION['MysqlDeb']){
	$InsMensaje->MtdRedireccionar("principal.php?Mod=".$GET_mod."&Form=Listado",$Registro,1500);
}
?>
