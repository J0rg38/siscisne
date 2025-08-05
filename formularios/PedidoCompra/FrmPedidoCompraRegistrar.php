<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>   

<?php $PrivilegioVistaPreliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"VistaPreliminar"))?true:false;?>
<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Imprimir"))?true:false;?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("OrdenCompra");?>JsOrdenCompraFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("OrdenCompra");?>JsOrdenCompraAutocompletar.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Producto");?>JsProductoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Producto");?>JsProductoAutocompletar.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Cliente');?>JsClienteFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Cliente');?>JsClienteAutocompletar.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Moneda');?>JsMonedaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('TipoCambio');?>JsTipoCambioFunciones.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsPedidoCompraFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsPedidoCompraDetalleFunciones.js" ></script>

<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssPedidoCompra.css');
</style>

<?php

$Registro = false;

if(!empty($_POST['Identificador'])){
	$Identificador = $_POST['Identificador'];
}

$GET_VdiId = $_GET['VdiId'];
$GET_FccId = $_GET['FccId'];

$GET_Origen = $_GET['Origen'];
$POST_OrdenCompraEnviar = $_POST['CmpOrdenCompraEnviar'];

include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjPedidoCompra.php');
//CLASES
require_once($InsPoo->MtdPaqLogistica().'ClsPedidoCompra.php');
require_once($InsPoo->MtdPaqLogistica().'ClsPedidoCompraDetalle.php');
require_once($InsPoo->MtdPaqLogistica().'ClsTipoOperacion.php');
require_once($InsPoo->MtdPaqLogistica().'ClsTipoDocumento.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCliente.php');
require_once($InsPoo->MtdPaqLogistica().'ClsClienteTipo.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVentaDirecta.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVentaDirectaDetalle.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVentaDirectaTarea.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVentaDirectaFoto.php');

require_once($InsPoo->MtdPaqLogistica().'ClsCotizacionProducto.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCotizacionProductoDetalle.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsUnidadMedidaConversion.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsUnidadMedida.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProducto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoFoto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoCodigoReemplazo.php');require_once($InsPoo->MtdPaqAlmacen().'ClsProductoVehiculoVersion.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoAno.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoFoto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsListaPrecio.php');
//require_once($InsPoo->MtdPaqAlmacen().'ClsProductoCosto.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsProductoDisponibilidad.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoListaPrecio.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoReemplazo.php');


require_once($InsPoo->MtdPaqContabilidad().'ClsTipoCambio.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompra.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompraDetalle.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompraPedido.php');

require_once($InsPoo->MtdPaqActividad().'ClsFichaAccion.php');

require_once($InsPoo->MtdPaqRRHH().'ClsPersonal.php');


//INSTANCIAS
$InsPedidoCompra = new ClsPedidoCompra();
$InsTipoOperacion = new ClsTipoOperacion();
$InsTipoDocumento = new ClsTipoDocumento();
$InsClienteTipo = new ClsClienteTipo();
$InsCotizacionProducto = new ClsCotizacionProducto();

$InsVentaDirecta = new ClsVentaDirecta();

$InsProducto = new ClsProducto();
$InsUnidadMedida = new ClsUnidadMedida();
$InsUnidadMedidaConversion = new ClsUnidadMedidaConversion();

$InsMoneda = new ClsMoneda();
$InsPersonal = new ClsPersonal();

$InsProductoDisponibilidad = new ClsProductoDisponibilidad();
$InsProductoListaPrecio = new ClsProductoListaPrecio();
$InsProductoReemplazo = new ClsProductoReemplazo();

if (!isset($_SESSION['InsPedidoCompraDetalle'.$Identificador])){	
	$_SESSION['InsPedidoCompraDetalle'.$Identificador] = new ClsSesionObjeto();
}else{	
	$_SESSION['InsPedidoCompraDetalle'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsPedidoCompraDetalle'.$Identificador]);
}

//ACCIONES
include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccPedidoCompraRegistrar.php');
//DATOS
$ResTipoOperacion = $InsTipoOperacion->MtdObtenerTipoOperaciones(NULL,NULL,"TopCodigo","ASC",NULL);
$ArrTipoOperaciones = $ResTipoOperacion['Datos'];
//DATOS FICHA INGRESO
$RepTipoDocumento = $InsTipoDocumento->MtdObtenerTipoDocumentos(NULL,NULL,'TdoNombre',"ASC",NULL);
$ArrTipoDocumentos = $RepTipoDocumento['Datos'];

//MtdObtenerClienteTipos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'LtiId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVehiculoMarca=NULL,$oEstado=NULL)
$RepClienteTipo = $InsClienteTipo->MtdObtenerClienteTipos(NULL,NULL,NULL,'VmaNombre,LtiNombre',"ASC",NULL,NULL,1);
$ArrClienteTipos = $RepClienteTipo['Datos'];

$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","ASC",NULL,1);
$ArrMonedas = $ResMoneda['Datos'];


//MtdObtenerPersonales($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PerId',$oSentido = 'Desc',$oPaginacion = '0,10',$oPersonalTipo=NULL,$oEstado=NULL,$oFechaNacimientoRango=NULL,$oTaller=NULL,$oRecepcion=NULL,$oVenta=NULL,$oArea=NULL,$oSucursal=NULL,$oAlmacen=NULL,$oFirmante=NULL,$oMultisucursal=false,$oSinSucursal=false)
$ResPersonal = $InsPersonal->MtdObtenerPersonales(NULL,NULL,NULL,"PerNombre","ASC",NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,$_SESSION['SesionSucursal'],1,NULL,true);
$ArrPersonales = $ResPersonal['Datos'];
?>


<script src="../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script type="text/javascript">
/*
Desactivando tecla ENTER
*/

	FncDesactivarEnter();
/*
Configuracion carga de datos y animacion
*/
$(document).ready(function (){

	$('#CmpClienteNombre').focus();

	FncPedidoCompraDetalleListar();

<?php
/*if($Guardar==false){
?>
	var ClienteId = "<?php echo $InsPedidoCompra->CliId?>";

	if(ClienteId == ""){
		FncClienteCargarFormulario("Registrar");
	}

<?php	
}*/
?>

});

/*
Configuracion Formulario
*/
var Formulario = "FrmRegistrar";

var PedidoCompraDetalleEditar = 1;
var PedidoCompraDetalleEliminar = 1;
var PedidoCompraDetalleVerEstado = 2;

var UnidadMedidaTipo = 2;

</script>


<link href="../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />

<form id="FrmRegistrar" name="FrmRegistrar" method="post" action="#" enctype="multipart/form-data" onsubmit="FncGuardar();" >

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

<?php
if($Registro){
?>

	<?php
/*    if($PrivilegioVistaPreliminar){
    ?>
    <div class="EstSubMenuBoton"><a href="javascript:FncVistaPreliminar('<?php echo $InsPedidoCompra->PcoId;?>');"><img src="imagenes/iconos/preliminar.png" alt="[Vista Preliminar]" title="Vista preliminar" />V.P.</a></div>
    <?php
    }
    ?>
	<?php
    if($PrivilegioImprimir){
    ?>
    <div class="EstSubMenuBoton"><a href="javascript:FncImprmir('<?php echo $InsPedidoCompra->PcoId;?>');"><img src="imagenes/iconos/imprimir.png" alt="[Imprimir]" title="Imprimir"  />Imprimir</a></div>
    <?php
    }*/
    ?>
    
<?php	
}
?>


</div>

<div class="EstCapContenido">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
      
      <tr>
        <td width="1922" height="25" colspan="2"><span class="EstFormularioTitulo">REGISTRAR
        PEDIDO DE COMPRA</span></td>
      </tr>
      <tr>
        <td colspan="2">
          
          
          
	<ul class="tabs">
		<li><a href="#tab1">Pedido de Compra</a></li>
		
        
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
                        <span class="EstFormularioSubTitulo">Datos del Pedido de Compra
                          <input type="hidden" name="Guardar" id="Guardar"   />
                         <input type="hidden" name="Identificador" id="Identificador"  value="<?php echo $Identificador; ?>" />
                        </span></td>
                      <td>&nbsp;</td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">&nbsp;</td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left" valign="top">Codigo Interno:</td>
                      <td align="left" valign="top"><input readonly="readonly" name="CmpId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpId" value="<?php echo $InsPedidoCompra->PcoId;?>" size="15" maxlength="20" /></td>
                      <td align="left" valign="top">Tipo de Pedido: </td>
                      <td align="left" valign="top"><?php
switch($InsPedidoCompra->PcoTipoPedido){

	case "1-ZGAR":
		$OpcTipoPedido1 = 'selected = "selected"';
	break;
	
	case "2-ZVOR":
		$OpcTipoPedido2 = 'selected = "selected"';						
	break;
	
		case "3-YRUSH":
		$OpcTipoPedido3 = 'selected = "selected"';						
	break;
	
		case "4-STK":
		$OpcTipoPedido4 = 'selected = "selected"';						
	break;

}
?>
                        <select   class="EstFormularioCombo" name="CmpTipoPedido" id="CmpTipoPedido"    >
                          <option <?php echo $OpcTipoPedido1;?> value="1-ZGAR">ZGAR (GARANTIAS)</option>
                          <option <?php echo $OpcTipoPedido2;?> value="2-ZVOR">ZVOR (VEHICULO DETENIDO)</option>
                          <option <?php echo $OpcTipoPedido3;?> value="3-YRUSH">YRUSH (EMERGENCIA)</option>
                          <option <?php echo $OpcTipoPedido4;?> value="4-STK">STK (STOCK)</option>
                        </select></td>
                      <td align="left" valign="top">&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left" valign="top">Fecha:<br />
                        <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
                      <td align="left" valign="top"><span id="sprytextfield1">
                        <label>
                          <input class="EstFormularioCajaFecha" name="CmpFecha" type="text" id="CmpFecha" value="<?php if(empty($InsPedidoCompra->PcoFecha)){ echo date("d/m/Y");}else{ echo $InsPedidoCompra->PcoFecha; }?>" size="15" maxlength="10" />
                          </label>
                        <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg"><img src="imagenes/advertencia.png" width="20" height="20" border="0" align="absmiddle" title="Formato no valido" alt="[A]"  /></span></span><img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFecha" name="BtnFecha" width="25" height="25" align="absmiddle"  style="cursor:pointer;" /></td>
                      <td align="left" valign="top">Hora :<br />
                        <span class="EstFormularioSubEtiqueta">(00:00)</span></td>
                      <td align="left" valign="top"><input class="EstFormularioCajaHora" name="CmpHora" type="text" id="CmpHora" value="<?php  echo $InsPedidoCompra->PcoHora;?>" size="15" maxlength="10" />
                        <!--   <a href="javascript:FncCitaCalendarioCargarFormulario('VerCalendarioFull')"><img src="imagenes/acciones/calendario_full.png" width="25" height="25" border="0" alt="Calendario" title="Calendario" align="absmiddle" /></a>
              --></td>
                      <td align="left" valign="top">&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left" valign="top">Cliente: </td>
                      <td colspan="3" align="left" valign="top">
                        
                        <table>
                          <tr>
                            <td><input type="hidden" name="CmpClienteId" id="CmpClienteId" value="<?php echo $InsPedidoCompra->CliId;?>" size="3" /></td>
                            <td><select <?php if(!empty($InsPedidoCompra->CliId)){ echo 'disabled="disabled"';} ?>  class="EstFormularioCombo" name="CmpClienteTipoDocumento" id="CmpClienteTipoDocumento" >
                              <option value="">Escoja una opcion</option>
                              <?php
	foreach($ArrTipoDocumentos as $DatTipoDocumento){
	?>
                              <option <?php echo $DatTipoDocumento->TdoId;?> <?php echo ($DatTipoDocumento->TdoId==$InsPedidoCompra->TdoId)?'selected="selected"':"";?> value="<?php echo $DatTipoDocumento->TdoId?>"><?php echo $DatTipoDocumento->TdoCodigo?> - <?php echo $DatTipoDocumento->TdoNombre?></option>
                              <?php
	}
	?>
                              </select></td>
                            <td><a href="javascript:FncClienteNuevo();"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                            <td><input <?php if(!empty($InsPedidoCompra->CliId)){ echo 'readonly="readonly"';} ?> name="CmpClienteNumeroDocumento" type="text" class="EstFormularioCaja" id="CmpClienteNumeroDocumento" tabindex="4" value="<?php echo $InsPedidoCompra->CliNumeroDocumento;?>" size="20" maxlength="50"   /></td>
                            <td><a href="javascript:FncClienteBuscar('NumeroDocumento');"><img src="imagenes/acciones/buscar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                            <td><input <?php if(!empty($InsPedidoCompra->CliId)){ echo 'readonly="readonly"';} ?> name="CmpClienteNombre" type="text" class="EstFormularioCaja" id="CmpClienteNombre"  tabindex="2" value="<?php echo $InsPedidoCompra->CliNombre;?> <?php echo $InsPedidoCompra->CliApellidoPaterno;?> <?php echo $InsPedidoCompra->CliApellidoMaterno;?>" size="45" maxlength="255"  />
                              
                              <a href="comunes/Cliente/FrmClienteBuscar.php?height=440&amp;width=850" class="thickbox" title=""><img src="imagenes/acciones/buscador.png" width="25" height="25" border="0" align="absmiddle" ></a>                        </td>
                            <td><a id="BtnClienteRegistrar" onclick="FncClienteCargarFormulario('Registrar');"  href="javascript:void(0)" title=""> <img src="imagenes/acciones/registrar.png" alt="[Registrar]" width="25" height="25" border="0" align="absmiddle" title="Registrar" /></a> <a id="BtnClienteEditar" onclick="FncClienteCargarFormulario('Editar');" href="javascript:void(0)"   title=""> <img src="imagenes/acciones/editar.png" alt="[Editar]" width="25" height="25" border="0" align="absmiddle" title="Editar" /></a></td>
                            </tr>
                          </table>                      </td>
                      <td align="left" valign="top">&nbsp;</td>
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
                              <option value="<?php echo $DatMoneda->MonId?>" <?php if($InsPedidoCompra->MonId==$DatMoneda->MonId){ echo 'selected="selected"';}elseif($EmpresaMonedaId==$DatMoneda->MonId){  echo 'selected="selected"';}?> ><?php echo $DatMoneda->MonNombre?> ( <?php echo $DatMoneda->MonSimbolo;?>)</option>
                              <?php
			  }
			  ?>
                              </select>
                            <span class="selectRequiredMsg"><img src="imagenes/advertencia.png" width="20" height="20" border="0" align="absmiddle" title="Debe seleccionar un elemento" alt="[A]"  /></span></span></td>
                          <td><div id="CapMonedaBuscar"></div></td>
                          </tr>
                        </table></td>
                      <td align="left" valign="top">Tipo de Cambio:<br />
                        <span class="EstFormularioSubEtiqueta"> (0.000)</span></td>
                      <td align="left" valign="top">
                        
                        <table border="0" cellpadding="0" cellspacing="0">
                          <tr>
                            <td>
                              
                              <input name="CmpTipoCambio" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpTipoCambio" onchange="FncPedidoCompraDetalleListar();" value="<?php if (empty($InsPedidoCompra->PcoTipoCambio)){ echo "";}else{ echo $InsPedidoCompra->PcoTipoCambio; } ?>" size="10" maxlength="10" readonly="readonly" />                      </td>
                            <td><a href="javascript:FncPedidoCompraEstablecerMoneda();"><img src="imagenes/acciones/recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /></a></td>
                            </tr>
                          </table>                      </td>
                      <td align="left" valign="top">&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left" valign="top">Incluye Impuesto:</td>
                      <td align="left" valign="top"><?php
switch($InsPedidoCompra->PcoIncluyeImpuesto){

	case 1:
		$OpcIncluyeImpuesto1 = 'selected = "selected"';
	break;
	
	case 2:
		$OpcIncluyeImpuesto2 = 'selected = "selected"';						
	break;

}
?>
                        <select   class="EstFormularioCombo" name="CmpIncluyeImpuesto" id="CmpIncluyeImpuesto"  disabled="disabled"  >
                          <option <?php echo $OpcIncluyeImpuesto1;?> value="1">Si</option>
                          <option <?php echo $OpcIncluyeImpuesto2;?> value="2">No</option>
                          </select></td>
                      <td align="left" valign="top">Impuesto (%):</td>
                      <td align="left" valign="top"><input name="CmpPorcentajeImpuestoVenta" type="text" class="EstFormularioCajaDeshabilitada" id="CmpPorcentajeImpuestoVenta"  value="<?php echo $InsPedidoCompra->PcoPorcentajeImpuestoVenta;?>" size="10" maxlength="10" readonly="readonly" /></td>
                      <td align="left" valign="top">&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left" valign="top">Estado: </td>
                      <td align="left" valign="top"><?php
					switch($InsPedidoCompra->PcoEstado){
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
                    <option <?php echo $OpcEstado31;?> value="31">Correo Enviado</option>
                     <option <?php echo $OpcEstado6;?> value="6">Anulado</option>
                        </select>
                        <!-- <input type="hidden" name="CmpEstado" id="CmpEstado" value="<?php echo $InsPedidoCompra->PcoEstado;?>" />
                       --></td>
                      <td align="left" valign="top">
                      <td align="left" valign="top">
                      <td align="left" valign="top">&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td colspan="4" align="left" valign="top"><span class="EstFormularioSubTitulo">Aprobacion</span></td>
                      <td align="left" valign="top">&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left" valign="top">Aprobado:</td>
                      <td align="left" valign="top"><?php
switch($InsPedidoCompra->PcoAprobado){

	case 1:
		$OpcAprobado1 = 'selected = "selected"';
	break;
	
	case 2:
		$OpcAprobado2 = 'selected = "selected"';						
	break;

}
?>
                        <select   class="EstFormularioCombo" name="CmpAprobado" id="CmpAprobado"  disabled="disabled"  >
                          <option <?php echo $OpcAprobado1;?> value="1">Si</option>
                          <option <?php echo $OpcAprobado2;?> value="2">No</option>
                        </select></td>
                      <td align="left" valign="top">Respuesta:</td>
                      <td align="left" valign="top"><textarea name="CmpSolicitudAprobacionRespuesta" cols="45" rows="2" readonly="readonly" class="EstFormularioCaja" id="CmpSolicitudAprobacionRespuesta"><?php echo $InsPedidoCompra->PcoSolicitudAprobacionRespuesta;?></textarea></td>
                      <td align="left" valign="top">&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td colspan="4" align="left" valign="top"><span class="EstFormularioSubTitulo">Observaciones y otras referencias</span></td>
                      <td align="left" valign="top">&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left" valign="top">A solicitud de:</td>
                      <td align="left" valign="top"><select  class="EstFormularioCombo" name="CmpPersonal" id="CmpPersonal" >
                        <option value="">Escoja una opcion</option>
                        <?php
					foreach($ArrPersonales as $DatPersonal){
					?>
                        <option <?php echo ($DatPersonal->PerId==$InsPedidoCompra->PerId)?'selected="selected"':'';?>  value="<?php echo $DatPersonal->PerId;?>"><?php echo $DatPersonal->PerNombre ?> <?php echo $DatPersonal->PerApellidoPaterno; ?> <?php echo $DatPersonal->PerApellidoMaterno; ?></option>
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
                      <td align="left" valign="top">Observacion Interna:</td>
                      <td align="left" valign="top"><textarea name="CmpObservacion" cols="45" rows="2" class="EstFormularioCaja" id="CmpObservacion"><?php echo $InsPedidoCompra->PcoObservacion;?></textarea></td>
                      <td align="left" valign="top">Observacion Impresa:</td>
                      <td align="left" valign="top"><textarea name="CmpObservacionImpresa" cols="45" rows="2" class="EstFormularioCaja" id="CmpObservacionImpresa"><?php echo $InsPedidoCompra->PcoObservacionImpresa;?></textarea></td>
                      <td align="left" valign="top">&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left" valign="top">VIN:</td>
                      <td align="left" valign="top"><input name="CmpVehiculoIngresoVIN" type="text" class="EstFormularioCajaDeshabilitada" id="CmpVehiculoIngresoVIN"  tabindex="3" value="<?php  echo $InsPedidoCompra->EinVIN;?>" size="20" maxlength="25" readonly="readonly" /></td>
                      <td align="left" valign="top">Origen:</td>
                      <td align="left" valign="top"><?php
                    switch($InsPedidoCompra->PcoOrigen){
						case "PCO":
						  $OpcOrigen1 = 'selected = "selected"';
						break;
						
						case "VDI":
						  $OpcOrigen2 = 'selected = "selected"';
						break;
						
						case "LLA":
						  $OpcOrigen3 = 'selected = "selected"';
						break;
						
						case "FIN":
						  $OpcOrigen4 = 'selected = "selected"';
						break;
						
						case "STK":
						  $OpcOrigen5 = 'selected = "selected"';
						break;
                    }
                    ?>
                        <select <?php echo ($InsPedidoCompra->PcoOrigen=="VDI")?'disabled="disabled"':'';?>   class="EstFormularioCombo" name="CmpOrigen" id="CmpOrigen" >
                          <option <?php echo $OpcOrigen1;?> value="PCO">Ped. Compra Normal</option>
                          <option <?php echo $OpcOrigen2;?> value="VDI">Ord. Venta</option>
                          <option <?php echo $OpcOrigen4;?> value="FIN">Ord. Trabajo</option>
                          <option <?php echo $OpcOrigen3;?> value="LLA">Llamada de Cliente</option>
                          <option <?php echo $OpcOrigen5;?> value="STK">Stock Almacen</option>
                        </select></td>
                      <td align="left" valign="top">&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left" valign="top">Placa:</td>
                      <td align="left" valign="top"><input name="CmpVehiculoIngresoPlaca" type="text" class="EstFormularioCajaDeshabilitada" id="CmpVehiculoIngresoPlaca"  tabindex="3" value="<?php  echo $InsPedidoCompra->EinPlaca;?>" size="20" maxlength="25" readonly="readonly" /></td>
                      <td align="left" valign="top">Orden de Compra: </td>
                      <td align="left" valign="top"><table>
                        <tr>
                          <td><a href="javascript:FncOrdenCompraNuevo();"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                          <td><input name="CmpOrdenCompraId" id="CmpOrdenCompraId" type="hidden"    value="<?php  echo $InsPedidoCompra->OcoId;?>" size="20" maxlength="20" />
                            <input name="CmpOrdenCompra" type="text" class="EstFormularioCaja" id="CmpOrdenCompra"  tabindex="3" value="<?php  echo $InsPedidoCompra->OcoId;?>" size="25" maxlength="25" /></td>
                          <td><a id="BtnOrdenCompraRegistrar" onclick="FncOrdenCompraCargarFormulario('Registrar');"  href="javascript:void(0)" title=""> <img src="imagenes/acciones/registrar.png" alt="[Registrar]" width="25" height="25" border="0" align="absmiddle" title="Registrar" /></a> <a id="BtnOrdenCompraEditar" onclick="FncOrdenCompraCargarFormulario('Editar');" href="javascript:void(0)"   title=""> <img src="imagenes/acciones/editar.png" alt="[Editar]" width="25" height="25" border="0" align="absmiddle" title="Editar" /></a></td>
                          <td><a href="javascript:FncOrdenCompraBuscar('Id');"><img src="imagenes/acciones/buscar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                          <td></td>
                        </tr>
                      </table></td>
                      <td align="left" valign="top">&nbsp;</td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left" valign="top">Ord. Venta/Ref.:</td>
                      <td align="left" valign="top"><input name="CmpVentaDirectaId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpVentaDirectaId"  tabindex="3" value="<?php  echo $InsPedidoCompra->VdiId;?>" size="20" maxlength="25" readonly="readonly" />
                        /
                        <input name="CmpVentaDirectaOrdenCompraNumero" type="text" class="EstFormularioCajaDeshabilitada" id="CmpVentaDirectaOrdenCompraNumero"  tabindex="3" value="<?php  echo $InsPedidoCompra->VdiOrdenCompraNumero;?>" size="20" maxlength="25" readonly="readonly" /></td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left" valign="top">Ord. Trab./Modalidad</td>
                      <td align="left" valign="top"><input name="CmpFichaIngresoId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpFichaIngresoId"  tabindex="3" value="<?php  echo $InsPedidoCompra->FinId;?>" size="20" maxlength="25" readonly="readonly" />
                        /
                        <input name="CmpFichaIngresoModalidad" type="text" class="EstFormularioCajaDeshabilitada" id="CmpFichaIngresoModalidad"  tabindex="3" value="<?php  echo $InsPedidoCompra->MinNombre;?>" size="20" maxlength="45" readonly="readonly" />
                        <span class="EstFormularioSubTitulo">
                          <input type="hidden" name="CmpFichaAccionId" id="CmpFichaAccionId" value="<?php  echo $InsPedidoCompra->FccId;?>" />
                          </span></td>
                      <td align="left" valign="top">                    
                        <td align="left" valign="top">                      
                          <td align="left" valign="top">&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td colspan="4" align="left" valign="top"><span class="EstFormularioSubTitulo">Opciones Adicionales</span>                      </td>
                      <td align="left" valign="top">&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td colspan="2" align="left" valign="top"><input type="checkbox" name="CmpOrdenCompraEnviar" id="CmpOrdenCompraEnviar" value="1" />
                        <label for="CmpFichaIngresoEnviar">Generar ORDEN DE COMPRA  una vez guardado este formulario</label>                      </td>
                      <td align="left" valign="top">                      
                          <td align="left" valign="top">                      
                          <td align="left" valign="top">&nbsp;</td>
                    </tr>
                    </table>
                  </div>     
                </td>
            </tr>
            
            <tr>
              <td valign="top">
              
                                  
                    <?php
				//	if($InsPedidoCompra->PcoOrigen<>"VDI"){
					?>
                <div class="EstFormularioArea">
                  
                  <table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td width="98%">
                        
                        
                        
                        
                        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                          <tr>
                            <td>&nbsp;</td>
                            <td colspan="18"><span class="EstFormularioSubTitulo">


PRODUCTOS
  <input type="hidden" name="CmpProductoId"    id="CmpProductoId"   />
<input type="hidden" name="CmpProductoItem" id="CmpProductoItem" />
<!--<input type="hidden" name="CmpProductoCostoAnterior" id="CmpProductoCostoAnterior" />-->
<!--U:-->	<input type="hidden" name="CmpProductoUnidadMedida" id="CmpProductoUnidadMedida" />
<!--E:-->	<input type="hidden" name="CmpProductoUnidadMedidaEquivalente"   id="CmpProductoUnidadMedidaEquivalente"  />
<!--C:-->	<input type="hidden" name="CmpProductoCostoAux"    id="CmpProductoCostoAux"    />
<input type="hidden" name="CmpPedidoCompraDetalleId"  class="EstFormularioCaja" id="CmpPedidoCompraDetalleId"  />


                            
                            <input type="hidden" name="CmpProductoPromedioMensual"  class="EstFormularioCaja" id="CmpProductoPromedioMensual"  />
                            </span></td>
                            </tr>
                          <tr>
                            <td>&nbsp;</td>
                            <td>Estado:</td>
                            <td><div id="CapProductoBuscar"></div></td>
                            <td>C&oacute;digo Orig.</td>
                            <td>&nbsp;</td>
                            <td>C&oacute;digo Alt.</td>
                            <td>&nbsp;</td>
                            <td>Nombre : </td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>U.M.                              </td>
                            <td>A&ntilde;o:</td>
                            <td>Modelo:</td>
                            <td>Precio:</td>
                            <td>Cantidad:</td>
                            <td>Importe:</td>
                            <td>Obs.</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            </tr>
                          <tr>
                            <td>&nbsp;</td>
                            <td>
                            
                            <select  class="EstFormularioCombo" name="CmpPedidoCompraDetalleEstado" id="CmpPedidoCompraDetalleEstado">
<option value="0">-</option>
<option value="3" selected="selected">Considerar</option>
<option value="7">Descontinuado/Concluido</option>
<option value="8">Descontinuado/Pedir Reemplazo</option>
<option value="9">Solicito Fuente</option>
<option value="10">Stock/Pedir Denuevo</option>
<option value="6">Anulado</option>
</select>        


</td>
                            <td>
                              
                              <?php
							if(empty($InsPedidoCompra->VdiId)){
							?>
                              
                              <a href="javascript:FncPedidoCompraDetalleNuevo();"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a>
                              
                              <?php	
							}
							?>
                              
                              
                            </td>
                            <td><input name="CmpProductoCodigoOriginal"  type="text" class="EstFormularioCaja" id="CmpProductoCodigoOriginal" size="10" maxlength="20" /></td>
                            <td>
                              
                              
                              <?php
							if(empty($InsPedidoCompra->VdiId)){
							?>
                              
                              <a href="javascript:FncProductoBuscar('CodigoOriginal');"><img src="imagenes/acciones/buscar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a>
                              <?php	
							}
							?>                          
                              
                            </td>
                            <td><input name="CmpProductoCodigoAlternativo"  type="text" class="EstFormularioCaja" id="CmpProductoCodigoAlternativo" size="10" maxlength="20" /></td>
                            <td><?php
								if(empty($InsPedidoCompra->VdiId)){
							?>
                              <a href="javascript:FncProductoBuscar('CodigoAlternativo','');"><img src="imagenes/acciones/buscar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a>
                              <?php
							}
							?></td>
                            <td><input name="CmpProductoNombre" type="text" class="EstFormularioCaja" id="CmpProductoNombre" size="30" /></td>
                            <td>
                                                   
                            <?php
							if(empty($InsPedidoCompra->VdiId)){
							?>     

                            <a id="BtnProductoRegistrar" onclick="FncProductoCargarFormulario('Registrar');"  href="javascript:void(0)" title=""> <img src="imagenes/acciones/registrar.png" alt="[Registrar]" width="25" height="25" border="0" align="absmiddle" title="Registrar" /> </a> <a id="BtnProductoEditar" onclick="FncProductoCargarFormulario('Editar');" href="javascript:void(0)"   title=""> <img src="imagenes/acciones/editar.png" alt="[Editar]" width="25" height="25" border="0" align="absmiddle" title="Editar" /> </a>
  <?php	
							}
							?>  

                            </td>
                            <td>
                            
                            
                                                                               
                            <?php
							//if(empty($InsPedidoCompra->VdiId)){
							?> 
                            
                            
                            <a id="BtnProductoConsulta" onclick="FncProductoCargarFormulario('Consulta');" href="javascript:void(0)"   title=""> <img src="imagenes/producto_consulta.jpg" alt="[Consulta]" width="20" height="20" border="0" align="absmiddle" title="Consulta" /> </a>
    <?php	
							//}
							?>  
                          
                            </td>
                            <td><select  class="EstFormularioCombo" name="CmpProductoUnidadMedidaConvertir" id="CmpProductoUnidadMedidaConvertir">
                            </select></td>
                            <td><input name="CmpPedidoCompraDetalleAno" type="text" class="EstFormularioCaja" id="CmpPedidoCompraDetalleAno" size="5" maxlength="4"  /></td>
                            <td><input name="CmpPedidoCompraDetalleModelo" type="text" class="EstFormularioCaja" id="CmpPedidoCompraDetalleModelo" size="10" maxlength="45"  /></td>
                            <td><input name="CmpProductoPrecio" type="text" class="EstFormularioCaja" id="CmpProductoPrecio" size="7" maxlength="10"  /></td>
                            <td>
                              
                              <input name="CmpProductoCantidad" type="text"  class="<?php echo (!empty($InsPedidoCompra->VdiId))?'EstFormularioCajaDeshabilitada':'EstFormularioCaja';?>" id="CmpProductoCantidad" size="7" maxlength="10"  />                            </td>
                            <td><input name="CmpProductoImporte" type="text" class="EstFormularioCaja" id="CmpProductoImporte" size="7" maxlength="10"  /></td>
                            <td><input name="CmpPedidoCompraDetalleObservacion" type="text" class="EstFormularioCaja" id="CmpPedidoCompraDetalleObservacion" size="20" maxlength="255" /></td>
                            <td><a href="javascript:FncPedidoCompraDetalleGuardar();"><img src="imagenes/acciones/guardar.png" width="25" height="25" border="0" title="Guardar" alt="[Guardar]" align="absmiddle" /></a></td>
                            <td><a href="comunes/Producto/FrmProductoBuscar.php?height=440&amp;width=850" class="thickbox" title=""><img src="imagenes/acciones/buscador.png" width="25" height="25" border="0" align="absmiddle" ></a></td>
                          </tr>
                          </table>                      
                          </td>
                      </tr>
                    </table>
                  </div>             
                  
                  <?php
				//	}
				?>
                   </td>
            </tr>
            
            <tr>
              <td valign="top"><div class="EstFormularioArea" >
                <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                  <tr>
                    <td width="1%">&nbsp;</td>
                    <td width="49%"><div class="EstFormularioAccion" id="CapProductoAccion">Listo
                      para registrar elementos</div></td>
                    <td width="49%" align="right"><a href="javascript:FncPedidoCompraDetalleListar();">
                      <input type="hidden" name="CmpPedidoCompraDetalleAccion" id="CmpPedidoCompraDetalleAccion" value="AccPedidoCompraDetalleRegistrar.php" />
                      <img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a>
                      
                      
                      <?php
					if($InsPedidoCompra->PcoOrigen<>"VDI" and empty($InsPedidoCompra->OcoId)){
					?>
                      <a href="javascript:FncPedidoCompraDetalleEliminarTodo();"><img  src="imagenes/acciones/listado_eliminar_todo.png"  width="25" height="25"  border="0" title="Eliminar Todo"   alt="[Eli. Todo.]" align="absmiddle"/> Eliminar Todo</a>
                      <?php
					}
					?>
                      
                      
                      </td>
                    <td width="1%"><div id="CapPedidoCompraDetallesResultado"> </div></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="2"><div id="CapPedidoCompraDetalles" class="EstCapPedidoCompraDetalles" > </div></td>
                    <td>&nbsp;</td>
                    </tr>
                  </table>
                </div></td>
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
</script>

<script type="text/javascript">
var spryselect2 = new Spry.Widget.ValidationSelect("spryselect2");
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "date", {format:"dd/mm/yyyy"});
</script>
<?php
}else{
	echo ERR_GEN_101;
}

if(empty($GET_dia)){
	
	if(!$_SESSION['MysqlDeb']){
		$InsMensaje->MtdRedireccionar("principal.php?Mod=".$GET_mod."&Form=Listado",$Registro,1500);
	}
		
}


?>
