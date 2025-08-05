<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>   

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Producto");?>JsProductoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Producto");?>JsProductoAutocompletar.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Moneda');?>JsMonedaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('TipoCambio');?>JsTipoCambioFunciones.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsPedidoCompraLlegadaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsPedidoCompraLlegadaDetalleFunciones.js" ></script>


<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssPedidoCompraLlegada.css');
</style>

<?php
if(!empty($_POST['Identificador'])){
	$Identificador = $_POST['Identificador'];
}

$GET_OcoId = $_GET['OcoId'];
$GET_Ori = $_GET['Origen'];

$Registro = false;

include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjPedidoCompraLlegada.php');
include($InsProyecto->MtdFormulariosMsj('Proveedor').'MsjProveedor.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsPedidoCompraLlegada.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsPedidoCompraLlegadaDetalle.php');
require_once($InsPoo->MtdPaqLogistica().'ClsProveedor.php');
require_once($InsPoo->MtdPaqLogistica().'ClsComprobanteTipo.php');
require_once($InsPoo->MtdPaqLogistica().'ClsTipoOperacion.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqLogistica().'ClsTipoDocumento.php');


require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompra.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompraDetalle.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompraPedido.php');


require_once($InsPoo->MtdPaqLogistica().'ClsPedidoCompra.php');
require_once($InsPoo->MtdPaqLogistica().'ClsPedidoCompraDetalle.php');
require_once($InsPoo->MtdPaqLogistica().'ClsTipoDocumento.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsProducto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoCodigoReemplazo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsUnidadMedidaConversion.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsUnidadMedida.php');
require_once($InsPoo->MtdPaqRRHH().'ClsPersonal.php');

$InsPedidoCompraLlegada = new ClsPedidoCompraLlegada();
$InsComprobanteTipo = new ClsComprobanteTipo();
$InsTipoOperacion = new ClsTipoOperacion();
$InsMoneda = new ClsMoneda();
$InsTipoDocumento = new ClsTipoDocumento();
$InsProducto = new ClsProducto();
$InsUnidadMedida = new ClsUnidadMedida();
$InsUnidadMedidaConversion = new ClsUnidadMedidaConversion();

$InsPersonal = new ClsPersonal();

if (!isset($_SESSION['InsPedidoCompraLlegadaDetalle'.$Identificador])){	
	$_SESSION['InsPedidoCompraLlegadaDetalle'.$Identificador] = new ClsSesionObjeto();
}else{	
	$_SESSION['InsPedidoCompraLlegadaDetalle'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsPedidoCompraLlegadaDetalle'.$Identificador]);
}

if (!isset($_SESSION['InsOrdenCompraPedido'.$Identificador])){	
	$_SESSION['InsOrdenCompraPedido'.$Identificador] = new ClsSesionObjeto();
}else{	
	$_SESSION['InsOrdenCompraPedido'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsOrdenCompraPedido'.$Identificador]);
}


include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccPedidoCompraLlegadaRegistrar.php');

$ResComprobanteTipo = $InsComprobanteTipo->MtdObtenerComprobanteTipos(NULL,NULL,"CtiCodigo","ASC",NULL);
$ArrComprobanteTipos = $ResComprobanteTipo['Datos'];

$ResTipoOperacion = $InsTipoOperacion->MtdObtenerTipoOperaciones(NULL,NULL,"TopCodigo","ASC",NULL);
$ArrTipoOperaciones = $ResTipoOperacion['Datos'];

$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","ASC",NULL);
$ArrMonedas = $ResMoneda['Datos'];

$RepTipoDocumento = $InsTipoDocumento->MtdObtenerTipoDocumentos(NULL,NULL,'TdoNombre',"ASC",NULL);
$ArrTipoDocumentos = $RepTipoDocumento['Datos'];

//MtdObtenerPersonales($oCampo=NULL,$oCondicion,$oFiltro=NULL,$oOrden = 'PerId',$oSentido = 'Desc',$oPaginacion = '0,10',$oPersonalTipo=NULL,$oEstado=NULL,$oFechaNacimientoRango=NULL,$oTaller=NULL,$oRecepcion=NULL,$oVenta=NULL) {
$ResPersonal = $InsPersonal->MtdObtenerPersonales(NULL,NULL,NULL,"PerNombre","ASC",NULL,NULL,1,NULL,NULL,NULL,NULL);
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

	//FncMonedaBuscar('Id');
	$('#CmpFecha').focus();
	
	FncPedidoCompraLlegadaEstablecerMoneda();
	
	FncPedidoCompraLlegadaDetalleListar();
	
	
});
/*
Configuracion Formulario
*/


var PedidoCompraLlegadaDetalleEditar = 1;
var PedidoCompraLlegadaDetalleEliminar = 1;
</script>


<form id="FrmRegistrar" name="FrmRegistrar" method="post" action="#" enctype="multipart/form-data">

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
        DESPACHO (LLEGADA DE REPUESTOS A ALMACEN)</span></td>
      </tr>
      <tr>
        <td colspan="2">
          
          
          
	<ul class="tabs">
        <li><a href="#tab1">Llegada a Almacen</a></li>
       
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
                        <span class="EstFormularioSubTitulo">Datos de la Llegada a Almacen
                        <input type="hidden" name="Guardar" id="Guardar"   />
                        <input type="hidden" name="Identificador" id="Identificador"  value="<?php echo $Identificador; ?>" />
                        </span></td>
                      <td>&nbsp;</td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td align="center">&nbsp;</td>
                      <td>&nbsp;</td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left" valign="top">Codigo Interno:</td>
                      <td align="left" valign="top"><input readonly="readonly" name="CmpId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpId" value="<?php echo $InsPedidoCompraLlegada->PleId;?>" size="15" maxlength="20" /></td>
                      <td align="left" valign="top">Fecha de Llegada: <br><span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span> </td>
                      <td align="left" valign="top"><span id="sprytextfield1">
                        <label>
                          <input class="EstFormularioCajaFecha" name="CmpFecha" type="text" id="CmpFecha" value="<?php if(empty($InsPedidoCompraLlegada->PleFecha)){ echo date("d/m/Y");}else{ echo $InsPedidoCompraLlegada->PleFecha; }?>" size="15" maxlength="10" />
                          </label>
                        <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg"><img src="imagenes/advertencia.png" width="20" height="20" border="0" align="absmiddle" title="Formato no valido" alt="[A]"  /></span></span><img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFecha" name="BtnFecha" width="25" height="25" align="absmiddle"  style="cursor:pointer;" /></td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left" valign="top">Empleado:</td>
                      <td align="left" valign="top"><select  class="EstFormularioCombo" name="CmpPersonal" id="CmpPersonal" >
                        <option value="">Escoja una opcion</option>
                        <?php
					foreach($ArrPersonales as $DatPersonal){
					?>
                        <option <?php echo ($DatPersonal->PerId==$InsPedidoCompraLlegada->PerId)?'selected="selected"':'';?>  value="<?php echo $DatPersonal->PerId;?>"><?php echo $DatPersonal->PerNombre ?> <?php echo $DatPersonal->PerApellidoPaterno; ?> <?php echo $DatPersonal->PerApellidoMaterno; ?></option>
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
                      <td align="left" valign="top">Observacion:</td>
                      <td align="left" valign="top"><textarea name="CmpObservacion" cols="45" rows="2" class="EstFormularioCaja" id="CmpObservacion"><?php echo $InsPedidoCompraLlegada->PleObservacion;?></textarea></td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left" valign="top">Estado: </td>
                      <td align="left" valign="top"><?php
					switch($InsPedidoCompraLlegada->PleEstado){
						case 1:
							$OpcEstado1 = 'selected = "selected"';
						break;

						case 3:
							$OpcEstado3 = 'selected = "selected"';						
						break;
						
						case 31:
							$OpcEstado31 = 'selected = "selected"';						
						break;
					}
					?>
                        <select  class="EstFormularioCombo" name="CmpEstado" id="CmpEstado">
                          <option <?php echo $OpcEstado1;?> value="1">Pendiente</option>
                          <option <?php echo $OpcEstado3;?> value="3">Realizado</option>
                          <option <?php echo $OpcEstado31;?> value="31">Correo Enviado</option>
                          </select></td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td valign="top">&nbsp;</td>
                      <td colspan="3">
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
                            <td colspan="12"><span class="EstFormularioSubTitulo">PRODUCTOS</span>
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
                            
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            </tr>
                          <tr>
                            <td>&nbsp;</td>
                            <td>
                              
                              <input class="EstFormularioCasilla" title="Activar/Desactivar uso de lector" type="checkbox" value="1" id="CmpProductoLector" name="CmpProductoLector"  />                            </td>
                            <td><a href="javascript:FncPedidoCompraLlegadaDetalleNuevo();"></a></td>
                            <td><input name="CmpProductoCodigoOriginal"  type="text" class="EstFormularioCaja" id="CmpProductoCodigoOriginal" size="10" maxlength="20" /></td>
                            <td><a href="javascript:FncProductoBuscar('CodigoOriginal');"></a></td>
                            <td><input name="CmpProductoCodigoAlternativo"  type="text" class="EstFormularioCaja" id="CmpProductoCodigoAlternativo" size="10" maxlength="20" /></td>
                            <td><a href="javascript:FncProductoBuscar('CodigoAlternativo');"></a></td>
                            <td><input name="CmpProductoNombre" type="text" class="EstFormularioCaja" id="CmpProductoNombre" size="40" /></td>
                            <td>&nbsp;</td>
                            <td><select  class="EstFormularioCombo" name="CmpProductoUnidadMedidaConvertir" id="CmpProductoUnidadMedidaConvertir" disabled="disabled">
                              </select></td>
                            <td>
                              
                              <input name="CmpProductoCantidad" type="text" class="EstFormularioCaja" id="CmpProductoCantidad" size="10" maxlength="10" />                            </td>
                            <td><a href="javascript:FncPedidoCompraLlegadaDetalleGuardar();"><img src="imagenes/acciones/guardar.png" width="25" height="25" border="0" title="Guardar" alt="[Guardar]" align="absmiddle" /></a></td>
                            <td><a href="comunes/Producto/FrmProductoBuscar.php?height=440&amp;width=850" class="thickbox" title=""></a></td>
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
                    <td width="2%"><input type="hidden" name="CmpPedidoCompraLlegadaDetalleAccion" id="CmpPedidoCompraLlegadaDetalleAccion" value="AccPedidoCompraLlegadaDetalleRegistrar.php" /></td>
                    <td width="48%"><div class="EstFormularioAccion" id="CapProductoAccion">Listo
                      para registrar elementos</div></td>
                    <td width="49%" align="right"><a href="javascript:FncPedidoCompraLlegadaDetalleListar();"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a> <a href="javascript:FncPedidoCompraLlegadaDetalleEliminarTodo();"><img  src="imagenes/acciones/listado_eliminar_todo.png"  width="25" height="25"  border="0" title="Eliminar Todo"   alt="[Eli. Todo.]" align="absmiddle"/> Eliminar Todo</a></td>
                    <td width="1%"><div id="CapPedidoCompraLlegadaDetallesResultado"> </div></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="2"><div id="CapPedidoCompraLlegadaDetalles" class="EstCapPedidoCompraLlegadaDetalles" > </div></td>
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
