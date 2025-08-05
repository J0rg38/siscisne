<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>   

<?php $PrivilegioVistaPreliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"VistaPreliminar"))?true:false;?>
<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Imprimir"))?true:false;?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Cliente');?>JsPropietarioFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Cliente');?>JsPropietarioAutocompletar.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Cliente');?>JsClienteFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Cliente');?>JsClienteAutocompletar.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Vehiculo");?>JsVehiculoModeloFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Vehiculo");?>JsVehiculoVersionFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Vehiculo");?>JsVehiculoColorFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Vehiculo');?>JsVehiculoIngresoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Vehiculo');?>JsVehiculoIngresoAutocompletar.js" ></script>


<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Moneda');?>JsMonedaFunciones.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('TipoCambio');?>JsTipoCambioFunciones.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsAsignacionVentaVehiculoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsAsignacionVentaVehiculoDetalleFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsAsignacionVentaVehiculoPropietarioFunciones.js" ></script>

<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssAsignacionVentaVehiculo.css');
</style>


<?php
$Registro = false;
$GET_OvvId = $_GET['OvvId'];
$GET_Origen = $_GET['Origen'];

if(!empty($_POST['Identificador'])){
	$Identificador = $_POST['Identificador'];
}

include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjAsignacionVentaVehiculo.php');
include($InsProyecto->MtdFormulariosMsj('Cliente').'MsjCliente.php');

require_once($InsPoo->MtdPaqLogistica().'ClsAsignacionVentaVehiculo.php');


require_once($InsPoo->MtdPaqLogistica().'ClsCliente.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqLogistica().'ClsTipoDocumento.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoMarca.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoVersionCaracteristica.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoCaracteristicaSeccion.php');

require_once($InsPoo->MtdPaqRRHH().'ClsPersonal.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngreso.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngresoCliente.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngresoFoto.php');

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculo.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoCondicionVenta.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoObsequio.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoLlamada.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoPropietario.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoMantenimiento.php');

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoMantenimiento.php');
 require_once($InsPoo->MtdPaqEmpresa().'ClsSucursal.php');

$InsAsignacionVentaVehiculo = new ClsAsignacionVentaVehiculo();
$InsMoneda = new ClsMoneda();
$InsTipoDocumento = new ClsTipoDocumento();
$InsVehiculoMarca = new ClsVehiculoMarca();
$InsPersonal = new ClsPersonal();
$InsSucursal = new ClsSucursal();

if (!isset($_SESSION['InsAsignacionVentaVehiculoPropietario'.$Identificador])){	
	$_SESSION['InsAsignacionVentaVehiculoPropietario'.$Identificador] = new ClsSesionObjeto();
}else{	
	$_SESSION['InsAsignacionVentaVehiculoPropietario'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsAsignacionVentaVehiculoPropietario'.$Identificador]);
}


include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccAsignacionVentaVehiculoRegistrar.php');

$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","ASC",NULL,1);
$ArrMonedas = $ResMoneda['Datos'];

$RepTipoDocumento = $InsTipoDocumento->MtdObtenerTipoDocumentos(NULL,NULL,'TdoNombre',"ASC",NULL);
$ArrTipoDocumentos = $RepTipoDocumento['Datos'];

$RepVehiculoMarca = $InsVehiculoMarca->MtdObtenerVehiculoMarcas(NULL,NULL,"VmaNombre","ASC",NULL,1);
$ArrVehiculoMarcas = $RepVehiculoMarca['Datos'];

$ResPersonal = $InsPersonal->MtdObtenerPersonales(NULL,NULL,NULL,"PerNombre","ASC",NULL,NULL,1,NULL,NULL,NULL,1);
$ArrPersonalVendedores = $ResPersonal['Datos'];

$ResPersonal = $InsPersonal->MtdObtenerPersonales(NULL,NULL,NULL,"PerNombre","ASC",NULL,NULL,1,NULL,NULL,NULL,NULL);
$ArrPersonales = $ResPersonal['Datos'];



$RepSucursal = $InsSucursal->MtdObtenerSucursales(NULL,NULL,"SucNombre","ASC",NULL);
$ArrSucursales = $RepSucursal['Datos'];



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

	FncAsignacionVentaVehiculoEstablecerMoneda();

	FncVehiculoModelosCargar();
	
	FncAsignacionVentaVehiculoPropietarioListar();


	//FncVehiculoIngresoListar();
});

/*
Configuracion Formulario
*/
var AsignacionVentaVehiculoDetalleEditar = 1;
var AsignacionVentaVehiculoDetalleEliminar = 1;

var VehiculoModeloHabilitado = 1;
var VehiculoVersionHabilitado = 1;
var VehiculoColorHabilitado = 1;

var VehiculoMarcaVigencia = 1;
var VehiculoModeloVigencia = 0;
var VehiculoVersionVigencia = 0;

var AsignacionVentaVehiculoPropietarioEditar = 1;
var AsignacionVentaVehiculoPropietarioEliminar = 1;
</script>


<?php
if($InsCotizacionVehiculo->CveGenerarAsignacionVentaVehiculo<>"No"){
?>

<form id="FrmRegistrar" name="FrmRegistrar" method="post" action="#" enctype="multipart/form-data" onsubmit="FncGuardar();" >

<div class="EstCapMenu">


<?php
if($Registro){
?>

	<?php
    if($PrivilegioVistaPreliminar){
    ?>
    <div class="EstSubMenuBoton"><a href="javascript:FncVistaPreliminar('<?php echo $InsAsignacionVentaVehiculo->AvvId;?>');"><img src="imagenes/iconos/preliminar.png" alt="[Vista Preliminar]" title="Vista preliminar" />V.P.</a></div>
    <?php
    }
    ?>
	<?php
    if($PrivilegioImprimir){
    ?>
    <div class="EstSubMenuBoton"><a href="javascript:FncImprmir('<?php echo $InsAsignacionVentaVehiculo->AvvId;?>');"><img src="imagenes/iconos/imprimir.png" alt="[Imprimir]" title="Imprimir"  />Imprimir</a></div>
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
        ASIGNACION DE VEHICULO</span></td>
      </tr>
      <tr>
        <td colspan="2">

          
	<ul class="tabs">
        <li><a href="#tab1">Asignacion de Vehiculo</a></li>
       
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
                      <td colspan="4"><span class="EstFormularioSubTitulo">Datos de la Asignacion de Vehiculo
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
                      <td align="left" valign="top"><input readonly="readonly" name="CmpId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpId" value="<?php echo $InsAsignacionVentaVehiculo->AvvId;?>" size="20" maxlength="20" /></td>
                      <td align="left" valign="top">Fecha:<br />
                        <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
                      <td align="left" valign="top"><input class="EstFormularioCajaFecha" name="CmpFecha" type="text" id="CmpFecha" value="<?php if(empty($InsAsignacionVentaVehiculo->AvvFecha)){ echo date("d/m/Y");}else{ echo $InsAsignacionVentaVehiculo->AvvFecha; }?>" size="15" maxlength="10" />                      <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFecha" name="BtnFecha" width="25" height="25" align="absmiddle"  style="cursor:pointer;" /></td>
                      <td>&nbsp;</td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left" valign="top">Revisado por:</td>
                      <td align="left" valign="top"><select  class="EstFormularioCombo" name="CmpPersonal" id="CmpPersonal" >
                        <option value="">Escoja una opcion</option>
                        <?php
					foreach($ArrPersonales as $DatPersonal){
					?>
                        <option <?php echo ($DatPersonal->PerId==$InsAsignacionVentaVehiculo->PerId)?'selected="selected"':'';?>  value="<?php echo $DatPersonal->PerId;?>"><?php echo $DatPersonal->PerNombre ?> <?php echo $DatPersonal->PerApellidoPaterno; ?> <?php echo $DatPersonal->PerApellidoMaterno; ?></option>
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
                      <td align="left" valign="top">Fecha de Orden:</td>
                      <td align="left" valign="top"><input name="CmpOrdenVentaVehiculoFecha" type="text" class="EstFormularioCajaDeshabilitada" id="CmpOrdenVentaVehiculoFecha" value="<?php if(empty($InsAsignacionVentaVehiculo->OvvFecha)){ echo date("d/m/Y");}else{ echo $InsAsignacionVentaVehiculo->OvvFecha; }?>" size="15" maxlength="10" readonly="readonly" /></td>
                      <td align="left" valign="top">Fecha de Entrega Estimada:</td>
                      <td align="left" valign="top"><input name="CmpOrdenVentaVehiculoFechaEntrega" type="text" class="EstFormularioCajaDeshabilitada" id="CmpOrdenVentaVehiculoFechaEntrega" value="<?php if(empty($InsAsignacionVentaVehiculo->OvvFechaEntrega)){ echo date("d/m/Y");}else{ echo $InsAsignacionVentaVehiculo->OvvFechaEntrega; }?>" size="15" maxlength="10" readonly="readonly" /></td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left" valign="top">Moneda:</td>
                      <td align="left" valign="top"><table border="0" cellpadding="0" cellspacing="0">
                        <tr>
                          <td><select disabled="disabled" class="EstFormularioCombo" name="CmpMonedaId" id="CmpMonedaId">
                            <option value="">Escoja una opcion</option>
                            <?php
			  foreach($ArrMonedas as $DatMoneda){
			  ?>
                            <option value="<?php echo $DatMoneda->MonId?>" <?php if($InsAsignacionVentaVehiculo->MonId==$DatMoneda->MonId){ echo 'selected="selected"';}elseif($EmpresaMonedaId==$DatMoneda->MonId){  echo 'selected="selected"';}?> ><?php echo $DatMoneda->MonNombre?> ( <?php echo $DatMoneda->MonSimbolo;?>)</option>
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
                          <td><input name="CmpTipoCambio" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpTipoCambio"  value="<?php if (empty($InsAsignacionVentaVehiculo->OvvTipoCambio)){ echo "";}else{ echo $InsAsignacionVentaVehiculo->OvvTipoCambio; } ?>" size="10" maxlength="10" readonly="readonly" /></td>
                          <td></td>
                        </tr>
                      </table></td>
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
                      <td align="left" valign="top"><input name="CmpOrdenVentaVehiculoId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpOrdenVentaVehiculoId"  tabindex="3" value="<?php  echo $InsAsignacionVentaVehiculo->OvvId;?>" size="25" maxlength="25" readonly="readonly" /></td>
                      <td>Asesor de Ventas:</td>
                      <td><select  disabled="disabled" class="EstFormularioCombo" name="CmpPersonalVendedor" id="CmpPersonalVendedor" >
                        <option value="">Escoja una opcion</option>
                        <?php
					foreach($ArrPersonalVendedores as $DatPersonal){
					?>
                        <option <?php echo ($DatPersonal->PerId==$InsAsignacionVentaVehiculo->PerIdVendedor)?'selected="selected"':'';?>  value="<?php echo $DatPersonal->PerId;?>"><?php echo $DatPersonal->PerNombre ?> <?php echo $DatPersonal->PerApellidoPaterno; ?> <?php echo $DatPersonal->PerApellidoMaterno; ?></option>
                        <?php
					}
					?>
                        </select></td>
                      <td>&nbsp;</td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left" valign="top">Observaciones:</td>
                      <td align="left" valign="top"><textarea name="CmpObservacion" cols="45" rows="2" class="EstFormularioCaja" id="CmpObservacion"><?php echo $InsAsignacionVentaVehiculo->AvvObservacion;?></textarea></td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td>&nbsp;</td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left" valign="top">Estado: </td>
                      <td align="left" valign="top"><?php
					switch($InsAsignacionVentaVehiculo->AvvEstado){
						case 1:
							$OpcEstado1 = 'selected = "selected"';
						break;

						case 3:
							$OpcEstado3 = 'selected = "selected"';						
						break;
						
						case 6:
						$OpcEstado6 = 'selected = "selected"';		
						break;
					}
					?>
                        <select disabled="disabled"  class="EstFormularioCombo" name="CmpEstado" id="CmpEstado">
                          <option <?php echo $OpcEstado1;?> value="1">Pendiente</option>
                          <option <?php echo $OpcEstado3;?> value="3">Revisado</option>
                          <option <?php echo $OpcEstado6;?> value="6">Anulado</option>
                          </select></td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td>&nbsp;</td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td colspan="4" align="left" valign="top">Respuesta:</td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td colspan="4" align="center" valign="middle"><?php
					switch($InsAsignacionVentaVehiculo->AvvAprobacion){
						case 1:
							$OpcAprobacion11 = 'checked="checked"';
						break;

						case 2:
							$OpcAprobacion12 = 'checked="checked"';						
						break;
						
					}
		
					?>
                        <input type="radio" name="CmpAprobacion" id="CmpAprobacion1" value="1" <?php echo $OpcAprobacion11;?> />
                        <img src="imagenes/estado/aprobado.png" alt="Aprobado" title="Aprobado"  width="35" height="35" /> Aprobado
                        <input type="radio" name="CmpAprobacion" id="CmpAprobacion2" value="2" <?php echo $OpcAprobacion12;?> />
                        <img src="imagenes/estado/desaprobado.png" alt="Desaprobado" title="Desaprobado"  width="35" height="35" /> Desaprobado </td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td colspan="4" align="left" valign="top"><span class="EstFormularioSubTitulo">Opciones adicionales</span></td>
                      <td>&nbsp;</td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td colspan="4" align="left" valign="top"><input <?php echo (($InsAsignacionVentaVehiculo->AvvNotificar==1)?'checked="checked"':'');?> value="1"  type="checkbox" name="CmpNotificar" id="CmpNotificar" />
                        Notificar aprobacion via email (*) </td>
                      <td>&nbsp;</td>
                      </tr>
                    </table>
                  </div>     
                </td>
            </tr>
            
            <tr>
              <td valign="top"><div class="EstFormularioArea" >
                <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="2"><span class="EstFormularioSubTitulo">PROPIETARIOS </span></td>
                    <td>&nbsp;</td>
                    </tr>
                  <tr>
                    <td width="1%">&nbsp;</td>
                    <td width="49%"><div class="EstFormularioAccion" id="CapAsignacionVentaVehiculoPropietarioAccion">Listo
                      para registrar elementos</div></td>
                    <td width="49%" align="right"><a href="javascript:FncAsignacionVentaVehiculoPropietarioListar();"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a> <a href="javascript:FncAsignacionVentaVehiculoPropietarioEliminarTodo();"></a></td>
                    <td width="1%"><div id="CapAsignacionVentaVehiculoPropietariosResultado"> </div></td>
                    </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="2"><div id="CapAsignacionVentaVehiculoPropietarios" class="EstCapAsignacionVentaVehiculoPropietarios" > </div></td>
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
                    <td colspan="10"><span class="EstFormularioSubTitulo">Datos del Vehiculo 
                      <input name="CmpVehiculoIngresoId" type="hidden" id="CmpVehiculoIngresoId" value="<?php echo $InsAsignacionVentaVehiculo->EinId;?>" size="3" />
                      <input name="CmpPrecioLista" type="hidden" id="CmpPrecioLista" size="3" />
                      <input name="CmpPrecioCierre" type="hidden" id="CmpPrecioCierre" size="3" />
                      <input name="CmpPrecioMinimo" type="hidden" id="CmpPrecioMinimo" size="3" />
                      <input name="CmpBonoGM" type="hidden" id="CmpBonoGM" size="3" />
                      <input name="CmpBonoDealer" type="hidden" id="CmpBonoDealer" size="3" />
                      
                      
<input name="CmpVehiculoVersionIdInicial" type="hidden" id="CmpVehiculoVersionIdInicial" value="<?php echo $InsAsignacionVentaVehiculo->VveId;?>" size="3" />
<input name="CmpVehiculoModeloIdInicial" type="hidden" id="CmpVehiculoModeloIdInicial" value="<?php echo $InsAsignacionVentaVehiculo->VmoId;?>" size="3" />
<input name="CmpVehiculoMarcaIdInicial" type="hidden" id="CmpVehiculoMarcaIdInicial" value="<?php echo $InsAsignacionVentaVehiculo->VmaId;?>" size="3" />

<input name="CmpVehiculoIngresoIdInicial" type="hidden" id="CmpVehiculoIngresoIdInicial" value="<?php echo $InsAsignacionVentaVehiculo->EinId;?>" size="3" />
<input name="CmpVehiculoIngresoVINInicial" type="hidden" id="CmpVehiculoIngresoVINInicial" value="<?php echo $InsAsignacionVentaVehiculo->EinVIN;?>" size="3" />
<input name="CmpVehiculoIngresoNumeroMotorInicial" type="hidden" id="CmpVehiculoIngresoNumeroMotorInicial" value="<?php echo $InsAsignacionVentaVehiculo->EinNumeroMotor;?>" size="3" />
<input name="CmpVehiculoIngresoColorInicial" type="hidden" id="CmpVehiculoIngresoColorInicial" value="<?php echo $InsAsignacionVentaVehiculo->EinColor;?>" size="3" />

<input name="CmpOrdenVentaVehiculoAnoFabricacionInicial" type="hidden" id="CmpOrdenVentaVehiculoAnoFabricacionInicial" value="<?php echo $InsAsignacionVentaVehiculo->EinAnoFabricacion;?>" size="3" />
<input name="CmpOrdenVentaVehiculoAnoModeloInicial" type="hidden" id="CmpOrdenVentaVehiculoAnoModeloInicial" value="<?php echo $InsAsignacionVentaVehiculo->EinAnoModelo;?>" size="3" />


                      
                    </span></td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td align="left" valign="top">&nbsp;</td>
                    <td align="left" valign="top">VIN:</td>
                    <td align="left" valign="top">&nbsp;</td>
                    <td align="left" valign="top">&nbsp;</td>
                    <td align="left" valign="top">Marca:
                      <input name="CmpVehiculoMarcaId" type="hidden" id="CmpVehiculoMarcaId" value="<?php echo $InsAsignacionVentaVehiculo->VmaId;?>" size="3" /></td>
                    <td align="left" valign="top">Modelo:
                      <input name="CmpVehiculoModeloId" type="hidden" id="CmpVehiculoModeloId" value="<?php echo $InsAsignacionVentaVehiculo->VmoId;?>" size="3" /></td>
                    <td align="left" valign="top">Version:
                      <input name="CmpVehiculoVersionId" type="hidden" id="CmpVehiculoVersionId" value="<?php echo $InsAsignacionVentaVehiculo->VveId;?>" size="3" /></td>
                    <td align="left" valign="top">Motor:</td>
                    <td align="left" valign="top">Color:</td>
                    <td align="left" valign="top">A&ntilde;o/Fab.</td>
                    <td align="left" valign="top">A&ntilde;o/Mod.</td>
                    <td align="left" valign="top">&nbsp;</td>
                  </tr>
                  <tr>
                    <td align="left" valign="top"><a href="javascript:FncAsignacionVentaVehiculoDetalleNuevo();"> <img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /> </a></td>
                    <td align="left" valign="top"><input class="EstFormularioCaja" name="CmpVehiculoIngresoVIN" type="text" id="CmpVehiculoIngresoVIN" value="<?php echo ($InsAsignacionVentaVehiculo->EinVIN);?>" size="20" maxlength="30" /></td>
                    <td align="left" valign="top"><a href="javascript:FncVehiculoIngresoBuscar('VIN');"><img src="imagenes/acciones/buscar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                    <td align="left" valign="top">
                    
                    
                    
                    <a id="BtnVehiculoIngresoRegistrar" onclick="FncVehiculoIngresoCargarFormulario('Registrar');" href="javascript:void(0)" title="">
<img src="imagenes/acciones/registrar.png" alt="[Registrar]" width="25" height="25" border="0" align="absmiddle" title="Registrar" />
</a>

<a id="BtnVehiculoIngresoEditar" onclick="FncVehiculoIngresoCargarFormulario('Editar');" href="javascript:void(0)"   title="">
<img src="imagenes/acciones/editar.png" alt="[Editar]" width="25" height="25" border="0" align="absmiddle" title="Editar" />
</a>



                    
                    
                    </td>
                    <td align="left" valign="top"><select class="EstFormularioCombo" name="CmpVehiculoMarca" id="CmpVehiculoMarca" >
                      <option value="">Escoja una opcion</option>
                      <?php
			foreach($ArrVehiculoMarcas as $DatVehiculoMarca){
			?>
                      <option <?php echo $DatVehiculoMarca->VmaId;?> <?php echo ($DatVehiculoMarca->VmaId==$InsAsignacionVentaVehiculo->VmaId)?'selected="selected"':"";?> value="<?php echo $DatVehiculoMarca->VmaId?>"><?php echo $DatVehiculoMarca->VmaNombre?></option>
                      <?php
			}
			?>
                    </select></td>
                    <td align="left" valign="top"><select class="EstFormularioCombo" name="CmpVehiculoModelo" id="CmpVehiculoModelo">
                    </select></td>
                    <td align="left" valign="top"><select class="EstFormularioCombo" name="CmpVehiculoVersion" id="CmpVehiculoVersion">
                    </select></td>
                    <td align="left" valign="top"><input name="CmpVehiculoIngresoNumeroMotor" type="text" class="EstFormularioCajaDeshabilitada" id="CmpVehiculoIngresoNumeroMotor" value="<?php echo ($InsAsignacionVentaVehiculo->EinNumeroMotor);?>" size="8" maxlength="30" readonly="readonly" /></td>
                    <td align="left" valign="top"><input class="EstFormularioCaja" name="CmpVehiculoIngresoColor" type="text" id="CmpVehiculoIngresoColor" value="<?php echo ($InsAsignacionVentaVehiculo->EinColor);?>" size="8" maxlength="30" /></td>
                    <td align="left" valign="top"><input name="CmpOrdenVentaVehiculoAnoFabricacion" type="text" class="EstFormularioCaja" id="CmpOrdenVentaVehiculoAnoFabricacion" value="<?php echo ($InsAsignacionVentaVehiculo->EinAnoFabricacion);?>" size="8" maxlength="4" /></td>
                    <td align="left" valign="top"><input class="EstFormularioCaja" name="CmpOrdenVentaVehiculoAnoModelo" type="text" id="CmpOrdenVentaVehiculoAnoModelo" value="<?php echo ($InsAsignacionVentaVehiculo->EinAnoModelo);?>" size="8" maxlength="4" /></td>
                    <td align="left" valign="top">&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td align="left">&nbsp;</td>
                    <td align="right">&nbsp;</td>
                    <td align="right">&nbsp;</td>
                    <td align="right">&nbsp;</td>
                    <td align="right">&nbsp;</td>
                    <td align="right" valign="top">&nbsp;</td>
                    <td align="left" valign="top">Precio: </td>
                    <td align="left" valign="top">Desc.:</td>
                    <td align="left" valign="top">Desc. Ger.</td>
                    <td align="left" valign="top">Total:</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="6" align="left">
                    
                    
<a id="BtnVehiculoInstalar" href="javascript:FncCargarVehiculoInstalar();"><img src="imagenes/iconos/vehiculo_instalar.png" width="25" height="25" border="0" align="absmiddle"  /> Accesorios</a> <!--<span>(0)</span>
-->
<a id="BtnVehiculoIngresoEvento" href="javascript:FncCargarVehiculoIngresoEvento();"><img src="imagenes/iconos/vehiculo_eventos.png" width="25" height="25" border="0" align="absmiddle"  /> Incidentes</a> <!--<span>(0)</span>-->



</td>
                    <td align="left" valign="top"><input name="CmpOrdenVentaVehiculoPrecio" type="text" class="EstFormularioCajaDeshabilitada" id="CmpOrdenVentaVehiculoPrecio" value="<?php echo number_format($InsAsignacionVentaVehiculo->OvvPrecio,2);?>" size="8" maxlength="10" readonly="readonly" /></td>
                    <td align="left" valign="top"><input name="CmpOrdenVentaVehiculoDescuento" type="text" class="EstFormularioCajaDeshabilitada" id="CmpOrdenVentaVehiculoDescuento" value="<?php echo number_format($InsAsignacionVentaVehiculo->OvvDescuento,2);?>" size="8" maxlength="10" readonly="readonly" /></td>
                    <td align="left" valign="top"><input name="CmpOrdenVentaVehiculoDescuentoGerencia" type="text" class="EstFormularioCajaDeshabilitada" id="CmpOrdenVentaVehiculoDescuentoGerencia" value="<?php echo number_format($InsAsignacionVentaVehiculo->OvvDescuentoGerencia,2);?>" size="8" maxlength="10" readonly="readonly" /></td>
                    <td align="left" valign="top"><input name="CmpOrdenVentaVehiculoTotal" type="text" class="EstFormularioCajaDeshabilitada" id="CmpOrdenVentaVehiculoTotal" value="<?php echo number_format($InsAsignacionVentaVehiculo->OvvTotal,2);?>" size="8" maxlength="10" readonly="readonly" /></td>
                    <td>&nbsp;</td>
                  </tr>
                  </table>
                
              </div></td>
            </tr>
            <tr>
              <td valign="top"><div class="EstFormularioArea">
              <table width="100%" class="EstFormulario">
                <tr>
                  <td colspan="8">&nbsp;</td>
                </tr>
                <tr>
                  <td width="1">&nbsp;</td>
                  <td colspan="6"><span class="EstFormularioSubTitulo">Datos de la Orden de Venta :</span></td>
                  <td width="1">&nbsp;</td>
                </tr>
                
                <tr>
                  <td width="1">&nbsp;</td>
                  <td colspan="6"><div id="CapVehiculoDetalle" class="EstCapVehiculoIngreso"></div></td>
                  <td width="1">&nbsp;</td>
                </tr>
                <tr>
                  <td colspan="8">&nbsp;</td>
                </tr>

              </table>

              
            </div></td>
            </tr>
            <tr>
              <td valign="top"><div class="EstFormularioArea">
                <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                  <tr>
                    <td width="1%">&nbsp;</td>
                    <td width="48%"><span class="EstFormularioSubTitulo">Disponibilidad/Lista de Precios</span></td>
                    <td width="50%" align="right">
                    
                    
                    Sucursal:
       
       <select   class="EstFormularioCombo" name="CmpSucursal" id="CmpSucursal">
              <option value="">Escoja una opcion</option>
              <?php
    foreach($ArrSucursales as $DatSucursal){
    ?>
              <option value="<?php echo $DatSucursal->SucId?>" <?php if($POST_Sucursal==$DatSucursal->SucId){ echo 'selected="selected"';} ?> ><?php echo $DatSucursal->SucNombre;?></option>
              <?php
    }
    ?>
            </select>
            
            
            <a href="javascript:FncVehiculoIngresoListar();"> <img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a></td>
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



<?php	
}else{
	echo ERR_AVV_600;	
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
