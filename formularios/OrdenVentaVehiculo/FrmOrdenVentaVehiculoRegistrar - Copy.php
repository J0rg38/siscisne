<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>   

<?php $PrivilegioVistaPreliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"VistaPreliminar"))?true:false;?>
<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Imprimir"))?true:false;?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Cliente');?>JsPropietarioFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Cliente');?>JsPropietarioAutocompletar.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Cliente');?>JsClienteFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Cliente');?>JsClienteAutocompletar.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Vehiculo');?>JsVehiculoIngresoSimpleFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Vehiculo');?>JsVehiculoIngresoSimpleAutocompletar.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Vehiculo");?>JsVehiculoModeloFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Vehiculo");?>JsVehiculoVersionFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Vehiculo");?>JsVehiculoColorFunciones.js" ></script>
<!--<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Vehiculo');?>JsVehiculoIngresoSimpleFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Vehiculo');?>JsVehiculoIngresoSimpleAutocompletar.js" ></script>
-->
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Vehiculo');?>JsVehiculoColorAutocompletar.js" ></script>


<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Moneda');?>JsMonedaFunciones.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('TipoCambio');?>JsTipoCambioFunciones.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsOrdenVentaVehiculoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsOrdenVentaVehiculoDetalleFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsOrdenVentaVehiculoPropietarioFunciones.js" ></script>

<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssOrdenVentaVehiculo.css');
</style>


<?php
$Registro = false;
$GET_CveId = $_GET['CveId'];
$GET_Origen = $_GET['Origen'];

if(!empty($_POST['Identificador'])){
	$Identificador = $_POST['Identificador'];
}

include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjOrdenVentaVehiculo.php');
include($InsProyecto->MtdFormulariosMsj('Cliente').'MsjCliente.php');

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculo.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoCondicionVenta.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoObsequio.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoLlamada.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoPropietario.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoMantenimiento.php');

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoMantenimiento.php');


require_once($InsPoo->MtdPaqLogistica().'ClsCliente.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqLogistica().'ClsTipoDocumento.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoMarca.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoVersionCaracteristica.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoCaracteristicaSeccion.php');

require_once($InsPoo->MtdPaqRRHH().'ClsPersonal.php');

require_once($InsPoo->MtdPaqLogistica().'ClsCotizacionVehiculo.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCotizacionVehiculoLlamada.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCotizacionVehiculoCondicionVenta.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCotizacionVehiculoFoto.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCondicionVenta.php');
require_once($InsPoo->MtdPaqLogistica().'ClsObsequio.php');
require_once($InsPoo->MtdPaqLogistica().'ClsModalidadPago.php');


require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngreso.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngresoCliente.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngresoFoto.php');






require_once($InsPoo->MtdPaqActividad().'ClsFichaIngreso.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoLlamada.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoGasto.php');
require_once($InsPoo->MtdPaqActividad().'ClsPreEntregaDetalle.php');
require_once($InsPoo->MtdPaqActividad().'ClsPreEntregaTarea.php');
require_once($InsPoo->MtdPaqActividad().'ClsPreEntregaSeccion.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoProducto.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoTarea.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoManoObra.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoModalidad.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoHerramienta.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoSuministro.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoMantenimiento.php');

require_once($InsPoo->MtdPaqActividad().'ClsFichaAccion.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionSalidaExterna.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionFoto.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionTarea.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionTempario.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionProducto.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionMantenimiento.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionSuministro.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsTallerPedido.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsTallerPedidoDetalle.php');
require_once($InsPoo->MtdPaqActividad().'ClsPlanMantenimiento.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsPago.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsPagoComprobante.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCondicionPago.php');
$InsOrdenVentaVehiculo = new ClsOrdenVentaVehiculo();
$InsMoneda = new ClsMoneda();
$InsTipoDocumento = new ClsTipoDocumento();
$InsVehiculoMarca = new ClsVehiculoMarca();

$InsPersonal = new ClsPersonal();

$InsCondicionVenta = new ClsCondicionVenta();
$InsCondicionPago = new ClsCondicionPago();
$InsObsequio = new ClsObsequio();
$InsModalidadPago = new ClsModalidadPago();
$InsPlanMantenimiento = new ClsPlanMantenimiento();


$ResCondicionVenta = $InsCondicionVenta->MtdObtenerCondicionVentas(NULL,NULL,'CovId','DESC',NULL,1);
$ArrCondicionVentas = $ResCondicionVenta['Datos'];


// MtdObtenerObsequios($oCampo=NULL,$oFiltro=NULL,$oOrden = 'ObsId',$oSentido = 'Desc',$oPaginacion = '0,10',$oUso=NULL,$oEstado=NULL)
$ResObsequio = $InsObsequio->MtdObtenerObsequios(NULL,NULL,'ObsId','DESC',NULL,1,1);
$ArrObsequios = $ResObsequio['Datos'];

$ResAccesorio = $InsObsequio->MtdObtenerObsequios(NULL,NULL,'ObsOrden','ASC',NULL,2,1);
$ArrAccesorios = $ResAccesorio['Datos'];

if (!isset($_SESSION['InsOrdenVentaVehiculoPropietario'.$Identificador])){	
	$_SESSION['InsOrdenVentaVehiculoPropietario'.$Identificador] = new ClsSesionObjeto();
}else{	
	$_SESSION['InsOrdenVentaVehiculoPropietario'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsOrdenVentaVehiculoPropietario'.$Identificador]);
}


include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccOrdenVentaVehiculoRegistrar.php');

$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","ASC",NULL,1);
$ArrMonedas = $ResMoneda['Datos'];

$RepTipoDocumento = $InsTipoDocumento->MtdObtenerTipoDocumentos(NULL,NULL,'TdoNombre',"ASC",NULL);
$ArrTipoDocumentos = $RepTipoDocumento['Datos'];

$RepVehiculoMarca = $InsVehiculoMarca->MtdObtenerVehiculoMarcas(NULL,NULL,"VmaNombre","ASC",NULL,1);
$ArrVehiculoMarcas = $RepVehiculoMarca['Datos'];

$ResPersonal = $InsPersonal->MtdObtenerPersonales(NULL,NULL,NULL,"PerNombre","ASC",NULL,NULL,1,NULL,NULL,NULL,1,NULL, $_SESSION['SesionSucursal'],NULL,NULL,true);
$ArrPersonales = $ResPersonal['Datos'];

//MtdObtenerPersonales($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PerId',$oSentido = 'Desc',$oPaginacion = '0,10',$oPersonalTipo=NULL,$oEstado=NULL,$oFechaNacimientoRango=NULL,$oTaller=NULL,$oRecepcion=NULL,$oVenta=NULL,$oArea=NULL,$oSucursal=NULL,$oAlmacen=NULL,$oFirmante=NULL,$oMultisucursal=false)
$ResPersonal = $InsPersonal->MtdObtenerPersonales(NULL,NULL,NULL,"PerNombre","ASC",NULL,NULL,1,NULL,NULL,NULL,NULL,NULL, $_SESSION['SesionSucursal'],NULL,1,true);
$ArrPersonalFirmantes = $ResPersonal['Datos'];
	
	
	
//MtdObtenerModalidadPagos($oCampo=NULL,$oFiltro=NULL,$oOrden = 'MpaId',$oSentido = 'Desc',$oPaginacion = '0,10',$oUso=NULL)
$ResModalidadPago = $InsModalidadPago->MtdObtenerModalidadPagos(NULL,NULL,"MpaNombre","ASC",NULL,1);
$ArrModalidadPagos = $ResModalidadPago['Datos'];

//MtdObtenerObsequios($oCampo=NULL,$oFiltro=NULL,$oOrden = 'ObsId',$oSentido = 'Desc',$oPaginacion = '0,10',$oUso=NULL)

//function MtdObtenerCondicionPagos($oCampo=NULL,$oFiltro=NULL,$oOrden = 'NpaId',$oSentido = 'Desc',$oPaginacion = '0,10',$oUso=NULL)
$RepCondicionPago = $InsCondicionPago->MtdObtenerCondicionPagos(NULL,NULL,"NpaNombre","ASC",NULL,1);
$ArrCondicionPagos = $RepCondicionPago['Datos'];
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

	FncOrdenVentaVehiculoEstablecerMoneda();

	FncVehiculoModelosCargar();
	
	FncOrdenVentaVehiculoPropietarioListar();

	FncOrdenVentaVehiculoEstablecerMantenimiento();

	//FncVehiculoIngresoListar();
});

/*
Configuracion Formulario
*/
var OrdenVentaVehiculoDetalleEditar = 1;
var OrdenVentaVehiculoDetalleEliminar = 1;

var VehiculoModeloHabilitado = 1;
var VehiculoVersionHabilitado = 1;
var VehiculoColorHabilitado = 1;

var VehiculoMarcaVigencia = 1;
var VehiculoModeloVigencia = 1;
var VehiculoVersionVigencia = 1;

var OrdenVentaVehiculoPropietarioEditar = 1;
var OrdenVentaVehiculoPropietarioEliminar = 1;
</script>


<?php
if($InsCotizacionVehiculo->CveGenerarOrdenVentaVehiculo<>"No"){
?>

<form id="FrmRegistrar" name="FrmRegistrar" method="post" action="#" enctype="multipart/form-data" onsubmit="FncGuardar();" >

<div class="EstCapMenu">


<?php
if($Registro){
?>

	<?php
    if($PrivilegioVistaPreliminar){
    ?>
    <div class="EstSubMenuBoton"><a href="javascript:FncVistaPreliminar('<?php echo $InsOrdenVentaVehiculo->OvvId;?>');"><img src="imagenes/iconos/preliminar.png" alt="[Vista Preliminar]" title="Vista preliminar" />V.P.</a></div>
    <?php
    }
    ?>
	<?php
    if($PrivilegioImprimir){
    ?>
    <div class="EstSubMenuBoton"><a href="javascript:FncImprmir('<?php echo $InsOrdenVentaVehiculo->OvvId;?>');"><img src="imagenes/iconos/imprimir.png" alt="[Imprimir]" title="Imprimir"  />Imprimir</a></div>
    <?php
    }
    ?>
            

<?php
}
?>    



<div class="EstSubMenuBoton">
<input name="BtnGuardar"   id="BtnGuardar" type="image" border="0" src="imagenes/acc_guardar.gif" alt="[Guardar]" title="Guardar" />
<div>Guardar</div>
</div><?php
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
        ORDEN DE VENTA DE VEHICULO</span></td>
      </tr>
      <tr>
        <td colspan="2">

          
	<ul class="tabs">
        <li><a href="#tab1">Orden de Venta</a></li>
        <li><a href="#tab2">Notas</a></li>
        <li><a href="#tab3">Acta de Entrega</a></li>
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
                    <td colspan="4"><span class="EstFormularioSubTitulo">Datos de la Orden de Venta de Vehiculo
                        <input type="hidden" name="Guardar" id="Guardar"   />
                      <input type="hidden" name="Identificador" id="Identificador"  value="<?php echo $Identificador; ?>" />
                    </span></td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td align="left">&nbsp;</td>
                    <td align="left">&nbsp;</td>
                    <td align="left">&nbsp;</td>
                    <td align="left">&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td align="left" valign="top">Codigo Interno:</td>
                    <td align="left" valign="top"><input readonly="readonly" name="CmpId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpId" value="<?php echo $InsOrdenVentaVehiculo->OvvId;?>" size="20" maxlength="20" /></td>
                    <td align="left" valign="top">Fecha:<br />
                      <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
                    <td align="left" valign="top"><input class="EstFormularioCajaFecha" name="CmpFecha" type="text" id="CmpFecha" value="<?php if(empty($InsOrdenVentaVehiculo->OvvFecha)){ echo date("d/m/Y");}else{ echo $InsOrdenVentaVehiculo->OvvFecha; }?>" size="15" maxlength="10" />                      <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFecha" name="BtnFecha" width="25" height="25" align="absmiddle"  style="cursor:pointer;" /></td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td align="left" valign="top">Condicion de Venta:</td>
                    <td align="left" valign="top"><?php
					
					$aux = '';
					
foreach($ArrCondicionVentas as $DatCondicionVenta){
?>
                            <?php
	if(!empty($InsOrdenVentaVehiculo->OrdenVentaVehiculoCondicionVenta)){	
		foreach($InsOrdenVentaVehiculo->OrdenVentaVehiculoCondicionVenta as $DatOrdenVentaVehiculoCondicionVenta ){
			$aux = '';
			if($DatOrdenVentaVehiculoCondicionVenta->CovId==$DatCondicionVenta->CovId){
				$aux = 'checked="checked"';						
				break;
			}					
		}
	}				
	?>
                            <input <?php echo $aux;?> type="checkbox" value="<?php echo $DatCondicionVenta->CovId;?>" name="CmpCondicionVenta_<?php echo $DatCondicionVenta->CovId;?>" id="CmpCondicionVenta_<?php echo $DatCondicionVenta->CovId;?>" />
                            <?php echo $DatCondicionVenta->CovNombre;?><br />
                            <?php	
}
?>
                            <input name="CmpCondicionVentaOtro" type="text" class="EstFormularioCaja" id="CmpCondicionVentaOtro" value="<?php echo $InsOrdenVentaVehiculo->OvvCondicionVentaOtro;?>" size="20" maxlength="255"  /></td>
                    <td align="left" valign="top">Forma de Pago:</td>
                    <td align="left" valign="top"><select name="CmpCondicionPago" id="CmpCondicionPago" class="EstFormularioCombo" >
                      <option value="">Escoja una opcion</option>
                      <?php
					foreach($ArrCondicionPagos as $DatCondicionPago){
					?>
                      <option <?php if($InsOrdenVentaVehiculo->NpaId==$DatCondicionPago->NpaId){ echo 'selected="selected"';}?> value="<?php echo $DatCondicionPago->NpaId;?>"><?php echo $DatCondicionPago->NpaNombre;?></option>
                      <?php  
					}
					?>
                    </select></td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="4" align="left" valign="top"><span class="EstFormularioSubTitulo">Datos de facturacion</span></td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td align="left" valign="top">Comprobante a emitir:</td>
                    <td align="left" valign="top"><?php
					switch($InsOrdenVentaVehiculo->OvvComprobanteVenta){
						case "F":
							$OpcComprobanteVenta1 = 'selected = "selected"';
						break;

						case "B":
							$OpcComprobanteVenta2 = 'selected = "selected"';						
						break;
						
						default:
						
						break;
					}
					?>                      <select   class="EstFormularioCombo" name="CmpComprobanteVenta" id="CmpComprobanteVenta">
                      <option value="">Escoja una opcion</option>
                      <option <?php echo $OpcComprobanteVenta1;?> value="F">Factura</option>
                      <option <?php echo $OpcComprobanteVenta2;?> value="B">Boleta</option>
                    </select></td>
                    <td align="left" valign="top">Modalidad de Pago del Cliente:</td>
                    <td align="left" valign="top"><select  class="EstFormularioCombo" name="CmpModalidadPago" id="CmpModalidadPago" >
                      <option value="">Escoja una opcion</option>
                      <?php
                foreach($ArrModalidadPagos as $DatModalidadPago){
                ?>
                      <option <?php echo ($DatModalidadPago->MpaId == $InsOrdenVentaVehiculo->MpaId)?'selected="selected"':'';?>  value="<?php echo $DatModalidadPago->MpaId;?>"><?php echo $DatModalidadPago->MpaAbreviatura ?> - <?php echo $DatModalidadPago->MpaNombre ?></option>
                      <?php
                }
                ?>
                    </select></td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td align="left" valign="top">Moneda:</td>
                    <td align="left" valign="top">
                      
                      <table border="0" cellpadding="0" cellspacing="0">
                        <tr>
                          <td><select class="EstFormularioCombo" name="CmpMonedaId" id="CmpMonedaId">
                            <option value="">Escoja una opcion</option>
                            <?php
			  foreach($ArrMonedas as $DatMoneda){
			  ?>
                            <option value="<?php echo $DatMoneda->MonId?>" <?php if($InsOrdenVentaVehiculo->MonId==$DatMoneda->MonId){ echo 'selected="selected"';}elseif($EmpresaMonedaId==$DatMoneda->MonId){  echo 'selected="selected"';}?> ><?php echo $DatMoneda->MonNombre?> ( <?php echo $DatMoneda->MonSimbolo;?>)</option>
                            <?php
			  }
			  ?>
                          </select></td>
                          <td><div id="CapMonedaBuscar"></div></td>
                          </tr>
                        </table></td>
                    <td align="left" valign="top">Tipo de Cambio: <br />
                      <span class="EstFormularioSubEtiqueta"> (0.000)</span></td>
                    <td align="left" valign="top"><table>
                      <tr>
                        <td><input name="CmpTipoCambio" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpTipoCambio" onchange="FncCotizacionProductoDetalleListar();" value="<?php if (empty($InsOrdenVentaVehiculo->OvvTipoCambio)){ echo "";}else{ echo $InsOrdenVentaVehiculo->OvvTipoCambio; } ?>" size="10" maxlength="10" /></td>
                        <td><a href="javascript:FncOrdenVentaVehiculoEstablecerMoneda();"><img src="imagenes/acciones/recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /></a></td>
                        </tr>
                      </table></td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td align="left" valign="top">Impuesto:<br />
                      <span class="EstFormularioSubEtiqueta">(%)</span></td>
                    <td align="left" valign="top"><input name="CmpPorcentajeImpuestoVenta" type="text" class="EstFormularioCajaDeshabilitada" id="CmpPorcentajeImpuestoVenta"  value="<?php if(empty($InsOrdenVentaVehiculo->OvvPorcentajeImpuestoVenta)){ echo $EmpresaImpuestoVenta; }else{echo $InsOrdenVentaVehiculo->OvvPorcentajeImpuestoVenta;}?>" size="10" maxlength="5" readonly="readonly" /></td>
                    <td align="left" valign="top">&nbsp;</td>
                    <td align="left" valign="top">&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="4" align="left" valign="top">
                      <table width="100%">
                        <tr>
                          <td align="left" valign="top"><span class="EstFormularioSubTitulo">Obsequios:</span></td>
                          <td align="left" valign="top"><span class="EstFormularioSubTitulo">Accesorios:</span></td>
                          <td align="left" valign="top"><span class="EstFormularioSubTitulo">Mantenimientos Gratuitos:</span></td>
                          </tr>
                        <tr>
                          <td width="32%" align="left" valign="top">
                            
                            
                            <?php
					
					$aux = '';
foreach($ArrObsequios as $DatObsequio){
?>
                            <?php
	if(!empty($InsOrdenVentaVehiculo->OrdenVentaVehiculoObsequio)){	
		foreach($InsOrdenVentaVehiculo->OrdenVentaVehiculoObsequio as $DatOrdenVentaVehiculoObsequio ){
			$aux = '';
			if($DatOrdenVentaVehiculoObsequio->ObsId==$DatObsequio->ObsId and !empty($DatOrdenVentaVehiculoObsequio->OvoObsequio)){
				$aux = 'checked="checked"';						
				break;
			}					
		}
	}				
	?>
                            <input <?php echo $aux;?> type="checkbox" value="<?php echo $DatObsequio->ObsId;?>" name="CmpObsequio_<?php echo $DatObsequio->ObsId;?>" id="CmpObsequio_<?php echo $DatObsequio->ObsId;?>" />
                            <?php echo $DatObsequio->ObsNombre;?>
                            <?php 
					  if(!empty($DatObsequio->ObsFoto)){
					?>
                            <a target="<?php echo (!empty($DatObsequio->ObsArchivo)?'_blank'.$DatObsequio->ObsArchivo:'');?>" href="<?php echo (!empty($DatObsequio->ObsArchivo)?'subidos/obsequio_archivos/'.$DatObsequio->ObsArchivo:'#');?>"> <img src="imagenes/avisos/<?php echo $DatObsequio->ObsFoto?>" alt="<?php echo $DatObsequio->ObsNombre?>" width="25" height="25" border="0" align="absmiddle" title="<?php echo $DatObsequio->ObsNombre?>" /></a>
                            <?php
					  }else{
						?>
                            <?php 
					  if(!empty($DatObsequio->ObsArchivo)){
					?>
                            <a target="<?php echo (!empty($DatObsequio->ObsArchivo)?'_blank'.$DatObsequio->ObsArchivo:'');?>" href="<?php echo (!empty($DatObsequio->ObsArchivo)?'subidos/obsequio_archivos/'.$DatObsequio->ObsArchivo:'#');?>"> <img src="imagenes/iconos/promocion.png" alt="Promocion" title="Vehiculo con promocion" border="0" width="25" height="25"/></a>
                            <?php  
					  }
					  ?>
                            <?php  
					  }
					  ?>
                            <br />
                            <?php	
}
?>
                            <input name="CmpObsequioOtro" type="text" class="EstFormularioCaja" id="CmpObsequioOtro" value="<?php echo $InsOrdenVentaVehiculo->OvvObsequioOtro;?>" size="20" maxlength="255"  />
                            
<br />
* Esta informacion NO aparecera en la facturacion del vehiculo.
                            
                            
                            </td>
                          <td width="33%" align="left" valign="top"><?php
					
					$aux = '';
foreach($ArrAccesorios as $DatAccesorio){
?>
                            <?php
	if(!empty($InsOrdenVentaVehiculo->OrdenVentaVehiculoObsequio)){	
		foreach($InsOrdenVentaVehiculo->OrdenVentaVehiculoObsequio as $DatOrdenVentaVehiculoObsequio ){
			$aux = '';

			if($DatOrdenVentaVehiculoObsequio->ObsId==$DatAccesorio->ObsId and !empty($DatOrdenVentaVehiculoObsequio->OvoObsequio)){
				$aux = 'checked="checked"';						
				break;
			}					
		}
	}				
	?>
                            <input <?php echo $aux;?> type="checkbox" value="<?php echo $DatAccesorio->ObsId;?>" name="CmpObsequio_<?php echo $DatAccesorio->ObsId;?>" id="CmpObsequio_<?php echo $DatAccesorio->ObsId;?>" />
                            <?php echo $DatAccesorio->ObsNombre;?>
                            <?php 
					  if(!empty($DatAccesorio->ObsFoto)){
					?>
                            <a target="<?php echo (!empty($DatAccesorio->ObsArchivo)?'_blank'.$DatAccesorio->ObsArchivo:'');?>" href="<?php echo (!empty($DatAccesorio->ObsArchivo)?'subidos/obsequio_archivos/'.$DatAccesorio->ObsArchivo:'#');?>"> <img src="imagenes/avisos/<?php echo $DatAccesorio->ObsFoto?>" alt="<?php echo $DatAccesorio->ObsNombre?>" width="25" height="25" border="0" align="absmiddle" title="<?php echo $DatAccesorio->ObsNombre?>" /></a>
                            <?php
					  }else{
						?>
                            <?php 
					  if(!empty($DatAccesorio->ObsArchivo)){
					?>
                            <a target="<?php echo (!empty($DatAccesorio->ObsArchivo)?'_blank'.$DatAccesorio->ObsArchivo:'');?>" href="<?php echo (!empty($DatAccesorio->ObsArchivo)?'subidos/obsequio_archivos/'.$DatAccesorio->ObsArchivo:'#');?>"> <img src="imagenes/iconos/promocion.png" alt="Promocion" title="Vehiculo con promocion" border="0" width="25" height="25"/></a>
                            <?php  
					  }
					  ?>
                            <?php  
					  }
					  ?>
                            <br />
                            <?php	
}
?>
                            
                            * Esta informacion aparecera en la facturacion del vehiculo.
                            </td>
                          <td width="35%" align="left" valign="top">
         
         
<div id="CapPlanMantenimientoChevrolet">                 
Chevrolet:  <br />                
<?php

$aux = '';
foreach($InsPlanMantenimiento->PmaChevroletKilometrajesResumen as $DatKilometroEtiqueta => $DatKilometro){
?>

  <?php
	if(!empty($InsOrdenVentaVehiculo->OrdenVentaVehiculoMantenimiento)){	
		foreach($InsOrdenVentaVehiculo->OrdenVentaVehiculoMantenimiento as $DatOrdenVentaVehiculoMantenimiento ){
			$aux = '';
			if($DatOrdenVentaVehiculoMantenimiento->OvmKilometraje==$DatKilometro['km']){
				$aux = 'checked="checked"';						
				break;
			}					
		}
	}				
	?>

<input etiqueta="mant_chevrolet" <?php echo $aux;?> type="checkbox" value="<?php echo $DatKilometro['km'];?>" name="CmpMantenimientoChevrolet_<?php echo $DatKilometro['km'];?>" id="CmpMantenimientoChevrolet_<?php echo $DatKilometro['km'];?>" /> <?php echo $DatKilometroEtiqueta;?> km
<br />
<?php	
}
?>

</div>

<div id="CapPlanMantenimientoIsuzu">
Isuzu:<br />

<?php
$aux = '';
foreach($InsPlanMantenimiento->PmaIsuzuKilometrajesResumen as $DatKilometroEtiqueta => $DatKilometro){
?>

    <?php  
    if(!empty($InsOrdenVentaVehiculo->OrdenVentaVehiculoMantenimiento)){	
        foreach($InsOrdenVentaVehiculo->OrdenVentaVehiculoMantenimiento as $DatOrdenVentaVehiculoMantenimiento ){
            $aux = '';
            if($DatOrdenVentaVehiculoMantenimiento->OvmKilometraje==$DatKilometro['km']){
                $aux = 'checked="checked"';						
                break;
            }					
        }
    }				
    ?>
        
    
<input etiqueta="mant_isuzu" <?php echo $aux;?> type="checkbox" value="<?php echo $DatKilometro['km'];?>" name="CmpMantenimientoIsuzu_<?php echo $DatKilometro['km'];?>" id="CmpMantenimientoIsuzu_<?php echo $DatKilometro['km'];?>" /> <?php echo $DatKilometroEtiqueta;?> km
<br />
<?php	
}
?>
</div>
                            
                            </td>
                          </tr>
                        </table>
                      
                      
                      </td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="4" align="left" valign="top"><span class="EstFormularioSubTitulo">Observaciones y otras referencias</span></td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td align="left" valign="top">Orden de Venta:</td>
                    <td align="left" valign="top"><input name="CmpCotizacionVehiculoId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpCotizacionVehiculoId"  tabindex="3" value="<?php  echo $InsOrdenVentaVehiculo->CveId;?>" size="25" maxlength="25" readonly="readonly" /></td>
                    <td>Asesor de Ventas:</td>
                    <td><select  class="EstFormularioCombo" name="CmpPersonal" id="CmpPersonal" >
                      <option value="">Escoja una opcion</option>
                      <?php
					foreach($ArrPersonales as $DatPersonal){
					?>
                      <option <?php echo ($DatPersonal->PerId==$InsOrdenVentaVehiculo->PerId)?'selected="selected"':'';?>  value="<?php echo $DatPersonal->PerId;?>"><?php echo $DatPersonal->PerNombre ?> <?php echo $DatPersonal->PerApellidoPaterno; ?> <?php echo $DatPersonal->PerApellidoMaterno; ?></option>
                      <?php
					}
					?>
                    </select></td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td align="left" valign="top">Observacion:</td>
                    <td align="left" valign="top"><textarea name="CmpObservacion" cols="45" rows="2" class="EstFormularioCaja" id="CmpObservacion"><?php echo $InsOrdenVentaVehiculo->OvvObservacion;?></textarea></td>
                    <td>Firmante:</td>
                    <td><select  class="EstFormularioCombo" name="CmpPersonalFirmante" id="CmpPersonalFirmante" >
                      <option value="">Escoja una opcion</option>
                      <?php
					foreach($ArrPersonalFirmantes as $DatPersonalFirmante){
					?>
                      <option <?php echo ($DatPersonalFirmante->PerId==$InsOrdenVentaVehiculo->PerIdFirmante)?'selected="selected"':'';?>  value="<?php echo $DatPersonalFirmante->PerId;?>"><?php echo $DatPersonalFirmante->PerNombre ?> <?php echo $DatPersonalFirmante->PerApellidoPaterno; ?> <?php echo $DatPersonalFirmante->PerApellidoMaterno; ?></option>
                      <?php
					}
					?>
                      </select></td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td align="left" valign="top">Fecha Estimada de Entrega:</td>
                    <td align="left" valign="top"><input class="EstFormularioCajaFecha" name="CmpFechaEntrega" type="text" id="CmpFechaEntrega" value="<?php echo $InsOrdenVentaVehiculo->OvvFechaEntrega; ?>" size="15" maxlength="10" />
                      <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFechaEntrega" name="BtnFechaEntrega" width="25" height="25" align="absmiddle"  style="cursor:pointer;" /></td>
                    <td align="left" valign="top">Entrega Inmediata:</td>
                    <td align="left" valign="top"><?php
					switch($InsOrdenVentaVehiculo->OvvInmediata){
						case 1:
							$OpcInmediata1 = 'selected = "selected"';
						break;

						case 2:
							$OpcInmediata3 = 'selected = "selected"';						
						break;
						
					}
					?>
                      <select  class="EstFormularioCombo" name="CmpInmediata" id="CmpInmediata">
                        <option <?php echo $OpcInmediata1;?> value="1">Si</option>
                        <option <?php echo $OpcInmediata3;?> value="3">No</option>
                        </select></td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td align="left" valign="top">Estado: </td>
                    <td align="left" valign="top"><?php
					switch($InsOrdenVentaVehiculo->OvvEstado){
						case 1:
							$OpcEstado1 = 'selected = "selected"';
						break;

						case 3:
							$OpcEstado3 = 'selected = "selected"';						
						break;
						
						case 4:
						$OpcEstado4 = 'selected = "selected"';		
						break;
						
						case 5:
						$OpcEstado5 = 'selected = "selected"';		
						break;
						case 6:
						$OpcEstado6 = 'selected = "selected"';		
						break;
					}
					?>
                      <select disabled="disabled"  class="EstFormularioCombo" name="CmpEstado" id="CmpEstado">
                        <option <?php echo $OpcEstado1;?> value="1">Pendiente</option>
                        <option <?php echo $OpcEstado3;?> value="3">Listo</option>
                        <option <?php echo $OpcEstado4;?> value="4">Por Facturar</option>
                        <option <?php echo $OpcEstado5;?> value="5">Facturado</option>
                        <option <?php echo $OpcEstado6;?> value="6">Anulado</option>
                        </select></td>
                    <td align="left" valign="top">&nbsp;</td>
                    <td align="left" valign="top">&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="4" align="left" valign="top"><span class="EstFormularioSubTitulo">Opciones adicionales</span></td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="4" align="left" valign="top"><input <?php echo (($InsOrdenVentaVehiculo->OvvNotificar==1)?'checked="checked"':'');?> value="1"  type="checkbox" name="CmpNotificar" id="CmpNotificar" />
                      Solicitar aprobacion de VIN por email</td>
                    <td>&nbsp;</td>
                  </tr>
                  </table>
                  </div>     
                </td>
            </tr>
            
            <tr>
              <td valign="top"><div class="EstFormularioArea">
                <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="6"><span class="EstFormularioSubTitulo">Datos del Propietario
                      <input type="hidden" name="CmpOrdenVentaVehiculoPropietarioFirmaDJ" id="CmpOrdenVentaVehiculoPropietarioFirmaDJ" />
                      <input type="hidden" name="CmpOrdenVentaVehiculoPropietarioItem" id="CmpOrdenVentaVehiculoPropietarioItem" />
                      <input type="hidden" name="CmpPropietarioId" id="CmpPropietarioId" />
                    </span></td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>Tipo Doc.:</td>
                    <td>Num. Documento:</td>
                    <td>Nombre:</td>
                    <td>Telefono:</td>
                    <td>Celular:</td>
                    <td>Email:</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td><select disabled="disabled" class="EstFormularioCombo" name="CmpPropietarioTipoDocumento" id="CmpPropietarioTipoDocumento">
                      <option value="">Escoja una opcion</option>
                      <?php
foreach($ArrTipoDocumentos as $DatTipoDocumento){
?>
                      <option <?php echo $DatTipoDocumento->TdoId;?> value="<?php echo $DatTipoDocumento->TdoId?>"><?php echo $DatTipoDocumento->TdoCodigo?> - <?php echo $DatTipoDocumento->TdoNombre?></option>
                      <?php
}
?>
                    </select></td>
                    <td><table border="0" cellpadding="0" cellspacing="0">
                      <tr>
                        <td><a id="BtnPropietarioNuevo" href="javascript:FncPropietarioNuevo();"> <img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /> </a></td>
                        <td><input tabindex="4" class="EstFormularioCaja" name="CmpPropietarioNumeroDocumento" type="text" id="CmpPropietarioNumeroDocumento" size="15" maxlength="50"   /></td>
                        <td><a id="BtnPropietarioBuscarNumeroDocumento" href="javascript:FncPropietarioBuscar('NumeroDocumento');"> <img src="imagenes/acciones/buscar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                        <td><a id="BtnPropietarioRegistrar" onclick="FncPropietarioCargarFormulario('Registrar');" href="javascript:void(0)" title=""> <img src="imagenes/acciones/registrar.png" alt="[Registrar]" width="25" height="25" border="0" align="absmiddle" title="Registrar" /></a> 
                        
                        <a id="BtnPropietarioEditar" onclick="FncPropietarioCargarFormulario('Editar');" href="javascript:void(0)"   title=""> <img src="imagenes/acciones/editar.png" alt="[Editar]" width="25" height="25" border="0" align="absmiddle" title="Editar" /></a>
                        
                        </td>
                        <td><div id="CapPropietarioBuscar"></div></td>
                      </tr>
                      <tr> </tr>
                    </table></td>
                    <td><input  tabindex="2" class="EstFormularioCaja" name="CmpPropietarioNombre" type="text" id="CmpPropietarioNombre" size="30" maxlength="255"  /></td>
                    <td><input name="CmpPropietarioTelefono" type="text" class="EstFormularioCajaDeshabilitada" id="CmpPropietarioTelefono"  tabindex="2" size="15" maxlength="255" readonly="readonly"  /></td>
                    <td><input name="CmpPropietarioCelular" type="text" class="EstFormularioCajaDeshabilitada" id="CmpPropietarioCelular"  tabindex="2" size="15" maxlength="255" readonly="readonly"  /></td>
                    <td><input name="CmpPropietarioEmail" type="text" class="EstFormularioCajaDeshabilitada" id="CmpPropietarioEmail"  tabindex="2" size="20" maxlength="255" readonly="readonly"  /></td>
                    <td><a href="javascript:FncOrdenVentaVehiculoPropietarioGuardar();"><img src="imagenes/acciones/guardar.png" width="25" height="25" border="0" title="Guardar" alt="[Guardar]" align="absmiddle" /></a></td>
                  </tr>
                </table>
              </div></td>
            </tr>
            <tr>
              <td valign="top"><div class="EstFormularioArea" >
                <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="2"><span class="EstFormularioSubTitulo">PROPIETARIOS </span></td>
                    <td><input type="hidden" name="CmpOrdenVentaVehiculoPropietarioAccion" id="CmpOrdenVentaVehiculoPropietarioAccion" value="AccOrdenVentaVehiculoPropietarioRegistrar.php" /></td>
                  </tr>
                  <tr>
                    <td width="1%">&nbsp;</td>
                    <td width="49%"><div class="EstFormularioAccion" id="CapOrdenVentaVehiculoPropietarioAccion">Listo
                      para registrar elementos</div></td>
                    <td width="48%" align="right"><a href="javascript:FncOrdenVentaVehiculoPropietarioListar();"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a> <a href="javascript:FncOrdenVentaVehiculoPropietarioEliminarTodo();"><img  src="imagenes/eliminar_todo.png"  width="20" height="20"  border="0" title="Eliminar Todo"   alt="[Eliminar Todo]" align="absmiddle"/></a></td>
                    <td width="2%"><div id="CapOrdenVentaVehiculoPropietariosResultado"> </div></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="2"><div id="CapOrdenVentaVehiculoPropietarios" class="EstCapOrdenVentaVehiculoPropietarios" > </div></td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="2">&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                </table>
              </div></td>
            </tr>
            <tr>
              <td valign="top"><div class="EstFormularioArea">
                <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="12"><span class="EstFormularioSubTitulo">Datos del Vehiculo 
                      <input name="CmpVehiculoIngresoId" type="hidden" id="CmpVehiculoIngresoId" value="<?php echo $InsOrdenVentaVehiculo->EinId;?>" size="3" />
                      <input name="CmpPrecioLista" type="hidden" id="CmpPrecioLista" size="3" />
                      <input name="CmpPrecioCierre" type="hidden" id="CmpPrecioCierre" size="3" />
                      <input name="CmpPrecioMinimo" type="hidden" id="CmpPrecioMinimo" size="3" />
                      <input name="CmpBonoGM" type="hidden" id="CmpBonoGM" size="3" />
                      <input name="CmpBonoDealer" type="hidden" id="CmpBonoDealer" size="3" />
                    </span></td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td align="left" valign="top">&nbsp;</td>
                    <td align="left" valign="top">Marca:
                      <input name="CmpVehiculoMarcaId" type="hidden" id="CmpVehiculoMarcaId" value="<?php echo $InsOrdenVentaVehiculo->VmaId;?>" size="3" /></td>
                    <td align="left" valign="top">Modelo:
                      <input name="CmpVehiculoModeloId" type="hidden" id="CmpVehiculoModeloId" value="<?php echo $InsOrdenVentaVehiculo->VmoId;?>" size="3" /></td>
                    <td align="left" valign="top">Version:
                      <input name="CmpVehiculoVersionId" type="hidden" id="CmpVehiculoVersionId" value="<?php echo $InsOrdenVentaVehiculo->VveId;?>" size="3" /></td>
                    <td align="left" valign="top">&nbsp;</td>
                    <td align="left" valign="top">VIN:</td>
                    <td align="left" valign="top">&nbsp;</td>
                    <td align="left" valign="top">&nbsp;</td>
                    <td align="left" valign="top">GLP</td>
                    <td align="left" valign="top">Motor:</td>
                    <td align="left" valign="top">Color:</td>
                    <td align="left" valign="top">A&ntilde;o/Fab.</td>
                    <td align="left" valign="top">A&ntilde;o/Mod.</td>
                    <td align="left" valign="top">&nbsp;</td>
                  </tr>
                  <tr>
                    <td align="left" valign="top"><a href="javascript:FncOrdenVentaVehiculoDetalleNuevo();"></a></td>
                    <td align="left" valign="top"><select class="EstFormularioCombo" name="CmpVehiculoMarca" id="CmpVehiculoMarca" >
                      <option value="">Escoja una opcion</option>
                      <?php
			foreach($ArrVehiculoMarcas as $DatVehiculoMarca){
			?>
                      <option <?php echo $DatVehiculoMarca->VmaId;?> <?php echo ($DatVehiculoMarca->VmaId==$InsOrdenVentaVehiculo->VmaId)?'selected="selected"':"";?> value="<?php echo $DatVehiculoMarca->VmaId?>"><?php echo $DatVehiculoMarca->VmaNombre?></option>
                      <?php
			}
			?>
                    </select></td>
                    <td align="left" valign="top"><select class="EstFormularioCombo" name="CmpVehiculoModelo" id="CmpVehiculoModelo">
                    </select></td>
                    <td align="left" valign="top"><select class="EstFormularioCombo" name="CmpVehiculoVersion" id="CmpVehiculoVersion">
                    </select></td>
                    <td align="left" valign="top"><a href="javascript:FncOrdenVentaVehiculoDetalleNuevo();"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                    <td align="left" valign="top"><input name="CmpVehiculoIngresoVIN" type="text" class="EstFormularioCaja" id="CmpVehiculoIngresoVIN" value="<?php echo ($InsOrdenVentaVehiculo->EinVIN);?>" size="20" maxlength="30" /></td>
                    <td align="left" valign="top"><a href="javascript:FncVehiculoIngresoSimpleBuscar('VIN');"><img src="imagenes/acciones/buscar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                    <td align="left" valign="top"><a id="BtnVehiculoIngresoRegistrar" onclick="FncVehiculoIngresoCargarFormulario('Registrar');" href="javascript:void(0)" title=""> <img src="imagenes/acciones/registrar.png" alt="[Registrar]" width="25" height="25" border="0" align="absmiddle" title="Registrar" /> </a> <a id="BtnVehiculoIngresoEditar" onclick="FncVehiculoIngresoCargarFormulario('Editar');" href="javascript:void(0)"   title=""> <img src="imagenes/acciones/editar.png" alt="[Editar]" width="25" height="25" border="0" align="absmiddle" title="Editar" /> </a></td>
                    <td align="left" valign="top"><?php
					switch($InsOrdenVentaVehiculo->OvvGLP){
						case "Si":
							$OpcGLP1 = 'selected = "selected"';
						break;

						case "No":
							$OpcGLP3 = 'selected = "selected"';						
						break;
					
					}
					?>
                      <select class="EstFormularioCombo" name="CmpGLP" id="CmpGLP">
                        <option <?php echo $OpcGLP1;?> value="Si">Si</option>
                        <option <?php echo $OpcGLP3;?> value="No">No</option>
                    
                      </select></td>
                    <td align="left" valign="top"><input class="EstFormularioCajaDeshabilitada" name="CmpVehiculoMotor" type="text" id="CmpVehiculoMotor" value="<?php echo ($InsOrdenVentaVehiculo->OvvMotor);?>" size="8" maxlength="30" /></td>
                    <td align="left" valign="top"><input class="EstFormularioCaja" name="CmpVehiculoColor" type="text" id="CmpVehiculoColor" value="<?php echo ($InsOrdenVentaVehiculo->OvvColor);?>" size="8" maxlength="30" /></td>
                    <td align="left" valign="top"><input class="EstFormularioCaja" name="CmpVehiculoAnoFabricacion" type="text" id="CmpVehiculoAnoFabricacion" value="<?php echo ($InsOrdenVentaVehiculo->OvvAnoFabricacion);?>" size="8" maxlength="4" /></td>
                    <td align="left" valign="top"><input class="EstFormularioCaja" name="CmpVehiculoAnoModelo" type="text" id="CmpVehiculoAnoModelo" value="<?php echo ($InsOrdenVentaVehiculo->OvvAnoModelo);?>" size="8" maxlength="4" /></td>
                    <td align="left" valign="top">&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td align="left"><input class="EstFormularioBoton" type="button" name="BtnBuscarVIN" id="BtnBuscarVIN" value="Buscar VIN" /></td>
                    <td align="left">&nbsp;</td>
                    <td align="left">&nbsp;</td>
                    <td align="left">&nbsp;</td>
                    <td align="left">&nbsp;</td>
                    <td align="left">&nbsp;</td>
                    <td align="left">&nbsp;</td>
                    <td align="left">Precio Prof.:</td>
                    <td align="left" valign="top">Precio: </td>
                    <td align="left" valign="top">Desc.:</td>
                    <td align="left" valign="top">Desc. Ger.</td>
                    <td align="left" valign="top">Total:</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td align="right">&nbsp;</td>
                    <td align="right">&nbsp;</td>
                    <td align="right" valign="top">&nbsp;</td>
                    <td align="left" valign="top">&nbsp;</td>
                    <td align="left" valign="top">&nbsp;</td>
                    <td align="left" valign="top">&nbsp;</td>
                    <td align="left" valign="top">&nbsp;</td>
                    <td align="left" valign="top"><input name="CmpCotizacionTotal" type="text" class="EstFormularioCajaDeshabilitada" id="CmpCotizacionTotal" value="<?php echo number_format($InsOrdenVentaVehiculo->CveTotal,2);?>" size="8" maxlength="10" readonly="readonly" /></td>
                    <td align="left" valign="top"><input name="CmpPrecio" type="text" class="EstFormularioCaja" id="CmpPrecio" value="<?php echo number_format($InsOrdenVentaVehiculo->OvvPrecio,2);?>" size="8" maxlength="10" /></td>
                    <td align="left" valign="top"><input class="EstFormularioCaja" name="CmpDescuento" type="text" id="CmpDescuento" value="<?php echo number_format($InsOrdenVentaVehiculo->OvvDescuento,2);?>" size="8" maxlength="10" /></td>
                    <td align="left" valign="top"><input name="CmpDescuentoGerencia" type="text" class="EstFormularioCajaDeshabilitada" id="CmpDescuentoGerencia" value="<?php echo number_format($InsOrdenVentaVehiculo->OvvDescuentoGerencia,2);?>" size="8" maxlength="10" readonly="readonly" /></td>
                    <td align="left" valign="top"><input name="CmpTotal" type="text" class="EstFormularioCaja" id="CmpTotal" value="<?php echo number_format($InsOrdenVentaVehiculo->OvvTotal,2);?>" size="8" maxlength="10" /></td>
                    <td>&nbsp;</td>
                  </tr>
                  </table>
                
              </div></td>
            </tr>
            <tr>
              <td valign="top"><div class="EstFormularioArea">
                <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                  <tr>
                    <td width="1%">&nbsp;</td>
                    <td width="67%"><span class="EstFormularioSubTitulo">Disponibilidad/Lista de Precios</span></td>
                    <td width="31%" align="right"><a href="javascript:FncVehiculoIngresoListar();"> <img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a></td>
                    <td width="1%">&nbsp;</td>
                    </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="2"><div id="CapVehiculoIngreso" class="EstCapVehiculoIngreso"></div></td>
                    <td>&nbsp;</td>
                    </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
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
                          <td colspan="2"><span class="EstFormularioSubTitulo">Notas Adicionales</span></td>
                          <td align="right">&nbsp;</td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td align="left" valign="top">&nbsp;</td>
                          <td align="left" valign="top">
                          
                          
          <script type="text/javascript">


//tinymce.init({
//	selector: "textarea#CmpNota",
//	theme: "modern",
//	menubar : false,
//	toolbar1: "bold italic | bullist numlist",
//	width : 700,
//	height : 180
//});

</script>

          <textarea name="CmpNota" cols="60" rows="5" class="EstFormularioCaja" id="CmpNota"><?php echo stripslashes($InsOrdenVentaVehiculo->OvvNota);?></textarea>
          
          
          
            
                          </td>
                          <td align="right">&nbsp;</td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td align="right">&nbsp;</td>
                          
                          </tr>
                          
                          </table>     
                
                
                
                
                </div>
                </td>
                </tr>
                </table>
</div> 

      <div id="tab3" class="tab_content">
        <!--Content-->
        
        
        

<table width="100%" border="0" cellpadding="2" cellspacing="2">
            
            <tr>
              <td width="97%" valign="top">
                <div class="EstFormularioArea">
                
                
                
                
           
               
              <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                        <tr>
                          <td>&nbsp;</td>
                          <td colspan="2"><span class="EstFormularioSubTitulo">Acta de Entrega:</span></td>
                          <td align="right">&nbsp;</td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td align="left" valign="top">Fecha:</td>
                          <td align="left" valign="top"><input class="EstFormularioCajaFecha" name="CmpActaEntregaFecha" type="text" id="CmpActaEntregaFecha" value="<?php echo $InsOrdenVentaVehiculo->OvvActaEntregaFecha; ?>" size="15" maxlength="10" />
                            <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnActaEntregaFecha" name="BtnActaEntregaFecha" width="25" height="25" align="absmiddle"  style="cursor:pointer;" />
                          
                          <input <?php echo (($InsOrdenVentaVehiculo->OvvEntregaNotificar==1)?'checked="checked"':'');?> value="1"  type="checkbox" name="CmpEntregaNotificar" id="CmpEntregaNotificar" />
                      Notificar entrega via email (*)
                      
                      
                      </td>
                          <td align="right">&nbsp;</td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td align="left" valign="top">Accesorios:</td>
                          <td align="left" valign="top">
                            
                            
                            <script type="text/javascript">


tinymce.init({
	selector: "textarea#CmpActaEntregaDescripcion",
	theme: "modern",
	menubar : false,
	toolbar1: "bold italic | bullist numlist",
	width : 700,
	height : 180
});

</script>
                            
                            <textarea name="CmpActaEntregaDescripcion" cols="60" rows="10" class="EstFormularioCaja" id="CmpActaEntregaDescripcion"><?php echo stripslashes($InsOrdenVentaVehiculo->OvvActaEntregaDescripcion);?></textarea>
                            
                            
                            
                            
                          </td>
                          <td align="right">&nbsp;</td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td align="right">&nbsp;</td>
                          
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
	
	
	
  


<!--  -->
  
</form>
<script type="text/javascript">
Calendar.setup({ 
	inputField : "CmpFecha",  // id del campo de texto 
	ifFormat   : "%d/%m/%Y",  //  
	button     : "BtnFecha"// el id del botón que  
	});
	

Calendar.setup({ 
	inputField : "CmpFechaEntrega",  // id del campo de texto 
	ifFormat   : "%d/%m/%Y",  //  
	button     : "BtnFechaEntrega"// el id del botón que  
	});


Calendar.setup({ 
	inputField : "CmpActaEntregaFecha",  // id del campo de texto 
	ifFormat   : "%d/%m/%Y",  //  
	button     : "BtnActaEntregaFecha"// el id del botón que  
	});


		
</script>



<?php	
}else{
	echo ERR_OVV_600;	
}
?>


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
