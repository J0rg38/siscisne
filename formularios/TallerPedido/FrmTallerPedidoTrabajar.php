<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar")){
?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Documento');?>JsGastoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Documento');?>JsGastoAutocompletar.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Documento');?>JsAlmacenMovimientoEntradaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Documento');?>JsAlmacenMovimientoEntradaAutocompletar.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsTallerPedidoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsTallerPedidoDetalleFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsTallerPedidoMantenimientoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsTallerPedidoTotalFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsTallerPedidoFichaFunciones.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsTallerPedidoHerramientaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsTallerPedidoHistorialFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsTallerPedidoCotizacionesFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsTallerPedidoFotoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsTallerPedidoGastoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsTallerPedidoAlmacenMovimientoEntradaFunciones.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsTallerPedidoFotoVINFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsTallerPedidoFotoDelanteraFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsTallerPedidoFotoCuponFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsTallerPedidoFotoMantenimientoFunciones.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Vehiculo');?>JsVehiculoMantenimientoFunciones.js" ></script>


<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssTallerPedido.css');
@import url('<?php echo $InsProyecto->MtdFormulariosCss("PlanMantenimiento");?>CssPlanMantenimiento.css');
</style>

<?php
$GET_Id = $_GET['Id'];

$Edito = false;

if(!empty($_POST['Identificador'])){
	$Identificador = $_POST['Identificador'];
}
include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjTallerPedido.php');
include($InsProyecto->MtdFormulariosMsj("AlmacenMovimientoSalida").'MsjAlmacenMovimientoSalida.php');

require_once($InsPoo->MtdPaqActividad().'ClsModalidadIngreso.php');

require_once($InsPoo->MtdPaqActividad().'ClsFichaIngreso.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoLlamada.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoGasto.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoAlmacenMovimientoEntrada.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenCierre.php');

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

//require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoSalida.php');
//require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoSalidaDetalle.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsTallerPedido.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsTallerPedidoDetalle.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsUnidadMedidaConversion.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsUnidadMedida.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProducto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoFoto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoCodigoReemplazo.php');require_once($InsPoo->MtdPaqAlmacen().'ClsProductoVehiculoVersion.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoAno.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoFoto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsListaPrecio.php');
//require_once($InsPoo->MtdPaqAlmacen().'ClsProductoCosto.php');

require_once($InsPoo->MtdPaqActividad().'ClsPlanMantenimiento.php');
require_once($InsPoo->MtdPaqActividad().'ClsPlanMantenimientoDetalle.php');
require_once($InsPoo->MtdPaqActividad().'ClsPlanMantenimientoSeccion.php');
require_once($InsPoo->MtdPaqActividad().'ClsPlanMantenimientoTarea.php');

require_once($InsPoo->MtdPaqLogistica().'ClsCliente.php');

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoObsequio.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoTipoUnidadMedida.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsTipoCambio.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacen.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenProducto.php');
require_once($InsPoo->MtdPaqActividad().'ClsTareaProducto.php');
require_once($InsPoo->MtdPaqRRHH().'ClsPersonal.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenStock.php');

$InsFichaIngreso = new ClsFichaIngreso();
$InsModalidadIngreso = new ClsModalidadIngreso();

$InsProducto = new ClsProducto();
$InsUnidadMedida = new ClsUnidadMedida();
$InsUnidadMedidaConversion = new ClsUnidadMedidaConversion();

$InsPlanMantenimiento = new ClsPlanMantenimiento();
$InsPlanMantenimientoSeccion = new ClsPlanMantenimientoSeccion();
$InsPlanMantenimientoDetalle = new ClsPlanMantenimientoDetalle();
$InsPlanMantenimientoTarea = new ClsPlanMantenimientoTarea();

$InsMoneda = new ClsMoneda();
$InsAlmacen = new ClsAlmacen();
$InsPersonal = new ClsPersonal();
$InsFichaIngreso->FinId = $GET_Id;
$InsFichaIngreso = $InsFichaIngreso->MtdObtenerFichaIngreso();
$InsFichaIngreso->UsuId = $_SESSION['SesionId'];

$ArrTallerPedidos = null;	
$ArrTallerPedidos = array();

if(!empty($InsFichaIngreso->FichaIngresoModalidad)){
	foreach($InsFichaIngreso->FichaIngresoModalidad as $DatFichaIngresoModalidad){	
	
		if (!isset($_SESSION['InsTallerPedidoDetalle'.$DatFichaIngresoModalidad->MinSigla.$Identificador])){	
			$_SESSION['InsTallerPedidoDetalle'.$DatFichaIngresoModalidad->MinSigla.$Identificador] = new ClsSesionObjeto();
		}else{	
			$_SESSION['InsTallerPedidoDetalle'.$DatFichaIngresoModalidad->MinSigla.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsTallerPedidoDetalle'.$DatFichaIngresoModalidad->MinSigla.$Identificador]);
		}

		if (!isset($_SESSION['InsTallerPedidoMantenimiento'.$DatFichaIngresoModalidad->MinSigla.$Identificador])){	
			$_SESSION['InsTallerPedidoMantenimiento'.$DatFichaIngresoModalidad->MinSigla.$Identificador] = new ClsSesionObjeto();
		}else{	
			$_SESSION['InsTallerPedidoMantenimiento'.$DatFichaIngresoModalidad->MinSigla.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsTallerPedidoMantenimiento'.$DatFichaIngresoModalidad->MinSigla.$Identificador]);
		}
		
		if (!isset($_SESSION['InsTallerPedidoFoto'.$DatFichaIngresoModalidad->MinSigla.$Identificador])){	
			$_SESSION['InsTallerPedidoFoto'.$DatFichaIngresoModalidad->MinSigla.$Identificador] = new ClsSesionObjeto();
		}else{	
			$_SESSION['InsTallerPedidoFoto'.$DatFichaIngresoModalidad->MinSigla.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsTallerPedidoFoto'.$DatFichaIngresoModalidad->MinSigla.$Identificador]);
		}
		
		
		if (!isset($_SESSION['InsTallerPedidoFicha'.$DatFichaIngresoModalidad->MinSigla.$Identificador])){	
			$_SESSION['InsTallerPedidoFicha'.$DatFichaIngresoModalidad->MinSigla.$Identificador] = new ClsSesionObjeto();
		}else{	
			$_SESSION['InsTallerPedidoFicha'.$DatFichaIngresoModalidad->MinSigla.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsTallerPedidoFicha'.$DatFichaIngresoModalidad->MinSigla.$Identificador]);
		}
		
	
	}		
}
	
if (!isset($_SESSION['InsTallerPedidoHerramienta'.$Identificador])){	
	$_SESSION['InsTallerPedidoHerramienta'.$Identificador] = new ClsSesionObjeto();
}else{	
	$_SESSION['InsTallerPedidoHerramienta'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsTallerPedidoHerramienta'.$Identificador]);
}		
	
	
if (!isset($_SESSION['InsTallerPedidoGasto'.$Identificador])){	
	$_SESSION['InsTallerPedidoGasto'.$Identificador] = new ClsSesionObjeto();
}else{	
	$_SESSION['InsTallerPedidoGasto'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsTallerPedidoGasto'.$Identificador]);
}		

if (!isset($_SESSION['InsTallerPedidoAlmacenMovimientoEntrada'.$Identificador])){	
	$_SESSION['InsTallerPedidoAlmacenMovimientoEntrada'.$Identificador] = new ClsSesionObjeto();
}else{	
	$_SESSION['InsTallerPedidoAlmacenMovimientoEntrada'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsTallerPedidoAlmacenMovimientoEntrada'.$Identificador]);
}		
		
		

include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccTallerPedidoTrabajar.php');

//$ResModalidadIngreso = $InsModalidadIngreso->MtdObtenerModalidadIngresos(NULL,NULL,'MinId','ASC',NULL,"1,3");
$ResModalidadIngreso = $InsModalidadIngreso->MtdObtenerModalidadIngresos(NULL,NULL,'MinId','ASC',NULL,NULL);
$ArrModalidadIngresos = $ResModalidadIngreso['Datos'];

$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","ASC",NULL,1);
$ArrMonedas = $ResMoneda['Datos'];

$RepAlmacen = $InsAlmacen->MtdObtenerAlmacenes(NULL,NULL,"AlmNombre","ASC",NULL,$InsTallerPedido->SucId);
$ArrAlmacenes = $RepAlmacen['Datos'];

//MtdObtenerPersonales($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PerId',$oSentido = 'Desc',$oPaginacion = '0,10',$oPersonalTipo=NULL,$oEstado=NULL,$oFechaNacimientoRango=NULL,$oTaller=NULL,$oRecepcion=NULL,$oVenta=NULL,$oArea=NULL,$oSucursal=NULL,$oAlmacen=NULL,$oFirmante=NULL,$oMultisucursal=false)
$ResPersonal = $InsPersonal->MtdObtenerPersonales(NULL,NULL,NULL,"PerNombre","ASC",NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,$_SESSION['SesionSucursal'],NULL,NULL,true);
$ArrTecnicos = $ResPersonal['Datos'];

?>

<?php
if($InsFichaIngreso->FinEstado == 7 or $InsFichaIngreso->FinEstado == 71 or $InsFichaIngreso->FinEstado == 73  or $InsFichaIngreso->FinEstado == 74 or $InsFichaIngreso->FinEstado == 75 or $InsFichaIngreso->FinEstado == 9 or $InsFichaIngreso->FinEstado == 10){
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

	FncTallerPedidoHerramientaListar();

	$('input[type=checkbox]').each(function () {
		if($(this).attr('etiqueta')=="modalidad"){
			
			FncTallerPedidoFotoListar($(this).attr('sigla'));
			
			FncTallerPedidoDetalleListar($(this).attr('sigla'));
			//FncTallerPedidoDetalleListar2($(this).attr('sigla'));
			
			FncTallerPedidoMantenimientoListar($(this).attr('sigla'));
			FncTallerPedidoFichaListar($(this).attr('sigla'));
			FncTallerPedidoTotalListar($(this).attr('sigla'));
			
		}			 
	});
	
	
		FncTallerPedidoHistorialListar();
		FncTallerPedidoCotizacionesListar();
		FncTallerPedidoGastoListar();
		FncTallerPedidoAlmacenMovimientoEntradaListar();
	
	FncTallerPedidoFotoVINListar();
	FncTallerPedidoFotoDelanteraListar();
	FncTallerPedidoFotoCuponListar();
	FncTallerPedidoFotoMantenimientoListar();

});

/*
Configuracion Formulario
*/

var Formulario = "FrmRegistrar";

var TallerPedidoFichaEditar = 1;
var TallerPedidoFichaEliminar = 1;

var TallerPedidoDetalleEditar = 1;
var TallerPedidoDetalleEliminar = 1;

var TallerPedidoMantenimientoEditar = 1;
var TallerPedidoMantenimientoEliminar = 1;

var TallerPedidoHerramientaEditar = 2;
var TallerPedidoHerramientaEliminar = 2;

var TallerPedidoFotoEditar = 2;
var TallerPedidoFotoEliminar = 2;

var TallerPedidoGastoEditar = 1;
var TallerPedidoGastoEliminar = 1;

var TallerPedidoAlmacenMovimientoEntradaEditar = 1;
var TallerPedidoAlmacenMovimientoEntradaEliminar = 1;

var TallerPedidoFotoVINEliminar = 2;
var TallerPedidoFotoDelanteraEliminar = 2;
var TallerPedidoFotoCuponEliminar = 2;
var TallerPedidoFotoMantenimientoEliminar = 2;
var PrimerRegistro = 2;

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
	



<?php
/*if($Registro){
?>    

	<?php
    if($PrivilegioVistaPreliminar){
    ?>
        <div class="EstSubMenuBoton"><a href="javascript:FncVistaPreliminar('<?php echo $InsTallerPedido->FccId;?>');"><img src="imagenes/iconos/preliminar.png" alt="[Vista Preliminar]" title="Vista preliminar" />V.P.</a></div>
    <?php
    }
    ?>
    <?php
    if($PrivilegioImprimir){
    ?>
        <div class="EstSubMenuBoton"><a href="javascript:FncImprmir('<?php echo $InsTallerPedido->FccId;?>');"><img src="imagenes/iconos/imprimir.png" alt="[Imprimir]" title="Imprimir"  />Imprimir</a></div>
    <?php
    }
    ?>
            
<?php
}*/
?>            

</div>

<div class="EstCapContenido">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
      
      <tr>
        <td width="1922" height="25" colspan="2"><span class="EstFormularioTitulo">EDITAR ORDEN DE TRABAJO (ALMACEN) *</span></td>
      </tr>
      <tr>
        <td colspan="2">

              
<div class="EstFormularioArea">
  <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
    <tr>
      <td align="left" valign="top">Ord. Trabajo:</td>
      <td align="left" valign="top"><input name="CmpFichaIngresoId" type="text" class="EstFormularioCaja" id="CmpFichaIngresoId" value="<?php echo $InsFichaIngreso->FinId;?>" size="15" readonly="readonly" /></td>
      <td align="left" valign="top">Fecha:<br />
        <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
      <td align="left" valign="top"><input name="CmpFecha" type="text" class="EstFormularioCajaFecha" id="CmpFecha" value="<?php echo $InsFichaIngreso->FinFecha;?>" size="15" maxlength="10" readonly="readonly" /></td>
      <td align="left" valign="top">Cliente:</td>
      <td colspan="3" align="left" valign="top">  <input name="CmpFichaIngresoCliente" type="text" class="EstFormularioCaja" id="CmpFichaIngresoCliente" value="<?php echo $InsFichaIngreso->CliNombre;?> <?php echo $InsFichaIngreso->CliApellidoPaterno;?> <?php echo $InsFichaIngreso->CliApellidoMaterno;?>" size="45" readonly="readonly" />
        
        <input name="CmpFichaIngresoClienteId" type="hidden" class="EstFormularioCaja" id="CmpFichaIngresoClienteId" value="<?php echo $InsFichaIngreso->CliId;?>" size="45" readonly="readonly" /></td>
      <td align="left" valign="top">Tipo Cliente:</td>
      <td align="left" valign="top"><input name="CmpClienteTipoNombre" type="text" class="EstFormularioCaja" id="CmpClienteTipoNombre" value="<?php echo $InsFichaIngreso->LtiNombre;?>" size="15" readonly="readonly" /></td>
      <td align="left" valign="top"><input type="hidden" name="Guardar" id="Guardar"   />
        <input type="hidden" name="Identificador" id="Identificador"  value="<?php echo $Identificador; ?>" />
        <input name="CmpFichaIngresoVehiculoVersion" type="hidden" class="EstFormularioCaja" id="CmpFichaIngresoVehiculoVersion" value="<?php echo $InsFichaIngreso->VveId;?>"  /><!-- REVISAR -->
        <input name="CmpFichaIngresoMantenimientoKilometraje" type="hidden" class="EstFormularioCaja" id="CmpFichaIngresoMantenimientoKilometraje" value="<?php echo $InsFichaIngreso->FinMantenimientoKilometraje;?>"  />
        <input name="CmpFichaIngresoEstado" type="hidden" class="EstFormularioCaja" id="CmpFichaIngresoEstado" value="<?php echo $InsFichaIngreso->FinEstado;?>"  />
        <input name="CmpVehiculoIngresoMarcaId" type="hidden" class="EstFormularioCaja" id="CmpVehiculoIngresoMarcaId" value="<?php echo $InsFichaIngreso->VmaId;?>"  />
        <input name="CmpVehiculoIngresoModeloId" type="hidden" class="EstFormularioCaja" id="CmpVehiculoIngresoModeloId" value="<?php echo $InsFichaIngreso->VmoId;?>"  />
        <input name="CmpVehiculoIngresoVersionId" type="hidden" class="EstFormularioCaja" id="CmpVehiculoIngresoVersionId" value="<?php echo $InsFichaIngreso->VveId;?>"  />
        <input name="CmpVehiculoIngresoAnoFabricacion" type="hidden" class="EstFormularioCaja" id="CmpVehiculoIngresoAnoFabricacion" value="<?php echo $InsFichaIngreso->EinAnoFabricacion;?>"  />
        <input name="CmpPlanMantenimientoId" type="hidden" class="EstFormularioCaja" id="CmpPlanMantenimientoId" value="<?php echo $InsFichaIngreso->PmaId;?>"  />
        
        
        <input name="CmpClienteTipo" type="hidden" class="EstFormularioCaja" id="CmpClienteTipo" value="<?php echo $InsFichaIngreso->LtiId;?>"  />
                
           <input name="CmpVehiculoIngresoId" type="hidden" class="EstFormularioCaja" id="CmpVehiculoIngresoId" value="<?php echo $InsFichaIngreso->EinId;?>"  />
      </td>
    </tr>

    <tr>
      <td align="left" valign="top"> Placa </td>
      <td align="left" valign="top"><input name="CmpFichaIngresoPlaca" type="text" class="EstFormularioCaja" id="CmpFichaIngresoPlaca" value="<?php echo $InsFichaIngreso->EinPlaca;?>" size="15" readonly="readonly" /></td>
      <td align="left" valign="top">VIN:</td>
      <td align="left" valign="top"><input name="CmpFichaIngresoVIN" type="text" class="EstFormularioCaja" id="CmpFichaIngresoVIN" value="<?php echo $InsFichaIngreso->EinVIN;?>" size="20" readonly="readonly" /></td>
      <td align="left" valign="top">Km.:</td>
      <td align="left" valign="top"><input name="CmpVehiculoKilometraje" type="text" class="EstFormularioCaja" id="CmpVehiculoKilometraje" value="<?php echo $InsFichaIngreso->FinVehiculoKilometraje;?>" size="15" readonly="readonly"  /></td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top"><input name="CmpSucursalId" type="hidden" class="EstFormularioCaja" id="CmpSucursalId" value="<?php echo $InsFichaIngreso->SucId;?>"  /></td>
    </tr>
    <tr>
      <td align="left" valign="top">Marca:</td>
      <td align="left" valign="top"><input name="CmpFichaIngresoMarca" type="text" class="EstFormularioCaja" id="CmpFichaIngresoMarca" value="<?php echo $InsFichaIngreso->VmaNombre;?>" size="15" readonly="readonly" /></td>
      <td align="left" valign="top">Modelo:</td>
      <td align="left" valign="top"><input name="CmpFichaIngresoModelo" type="text" class="EstFormularioCaja" id="CmpFichaIngresoModelo" value="<?php echo $InsFichaIngreso->VmoNombre;?>" size="15" readonly="readonly" /></td>
      <td align="left" valign="top">Version:</td>
      <td align="left" valign="top"><input name="CmpFichaIngresoVersion" type="text" class="EstFormularioCaja" id="CmpFichaIngresoVersion" value="<?php echo $InsFichaIngreso->VveNombre;?>" size="15" readonly="readonly" /></td>
      <td align="left" valign="top">A&ntilde;o:</td>
      <td align="left" valign="top"><input name="CmpVehiculoIngresoAnoFabricacion" type="text" class="EstFormularioCaja" id="CmpVehiculoIngresoAnoFabricacion" value="<?php echo $InsFichaIngreso->EinAnoFabricacion;?>" size="15" readonly="readonly" /></td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top">Tecnico:</td>
      <td colspan="9" align="left" valign="top"><input name="CmpPersonalNombre" type="text" class="EstFormularioCaja" id="CmpPersonalNombre" value="<?php echo $InsFichaIngreso->PerNombre;?>" size="20" readonly="readonly" />
        <input name="CmpPersonalApellidoPaterno" type="text" class="EstFormularioCaja" id="CmpPersonalApellidoPaterno" value="<?php echo $InsFichaIngreso->PerApellidoPaterno;?>" size="20" readonly="readonly" />
        <input name="CmpPersonal3" type="text" class="EstFormularioCaja" id="CmpPersonal3" value="<?php echo $InsFichaIngreso->PerApellidoMaterno;?>" size="20" readonly="readonly" /></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top">Notas:<br />
        <span class="EstFormularioSubEtiqueta">(Resumen de la situacion actual de la O.T.)</span></td>
      <td colspan="9" align="left" valign="top"><textarea name="CmpNota" cols="45" rows="2" readonly="readonly" class="EstFormularioCaja" id="CmpNota"><?php echo $InsFichaIngreso->FinNota;?></textarea></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="11" align="left" valign="top">
        
        
        
        <a href="javascript:FncPopUp('formularios/FichaIngreso/FrmFichaIngresoImprimirIN.php?Id=<?php echo $InsFichaIngreso->FinId;?>&amp;P=',0,0,1,0,0,1,0,screen.height,screen.width);"><img src="imagenes/avisos/ficha.gif" alt="" width="25" height="25" border="0" align="Ficha" title="Ficha" /> Inventario</a> 
        
        
        
        <a href="javascript:FncPopUp('formularios/FichaIngreso/FrmFichaIngresoImprimirFT.php?Id=<?php echo $InsFichaIngreso->FinId;?>&amp;P=',0,0,1,0,0,1,0,screen.height,screen.width);"> <img src="imagenes/avisos/ficha.gif" alt="" width="25" height="25" border="0" align="Ficha" title="Ficha" /> Ficha Tecnica</a>
        
        <a href="javascript:FncPopUp('formularios/FichaIngreso/FrmFichaIngresoImprimirFI.php?Id=<?php echo $InsFichaIngreso->FinId;?>&amp;P=',0,0,1,0,0,1,0,screen.height,screen.width);"> <img src="imagenes/avisos/ficha.gif" alt="" width="25" height="25" border="0" align="Ficha" title="Ficha" /> Ficha Interna</a>
      
      
      
      
        
              
         <a href="javascript:FncVehiculoMantenimientoResumenListado();"><img src="imagenes/avisos/ficha.gif" alt="" width="25" height="25" border="0" align="Ficha" title="Ficha" /> Mantenimientos</a>
         
         
               <?php
if(!empty($InsFichaIngreso->OvvId)

){
?>  		
          <a href="javascript:FncPopUp('formularios/OrdenVentaVehiculo/FrmOrdenVentaVehiculoImprimir.php?Id=<?php echo $InsFichaIngreso->OvvId;?>&amp;P=',0,0,1,0,0,1,0,screen.height,screen.width);"> <img src="imagenes/avisos/ficha.gif" alt="" width="25" height="25" border="0" align="Ficha" title="Ficha" /> Venta Vehiculo</a>
          
   <?php
}

?>


  <?php
if($InsFichaIngreso->FinCotizacionProducto=="Si"){
?>  
  <a href="formularios/FichaIngreso/DiaCotizacionProductoListado.php?height=440&amp;width=850&amp;FinId=<?php echo $InsFichaIngreso->FinId?>" class="thickbox" title=""><img src="imagenes/avisos/ficha.gif" alt="" width="25" height="25" border="0" align="Cotizacion" title="Cotizacion" /> Cotizacion</a>     
        
  <?php
}
?>
        
  <?php
/*if(!empty($InsFichaIngreso->CprId)){
?>


  <a href="javascript:FncPopUp('formularios/CotizacionProducto/FrmCotizacionProductoImprimir.php?Id=<?php echo $InsFichaIngreso->CprId;?>&amp;P=',0,0,1,0,0,1,0,screen.height,screen.width);"> <img src="imagenes/avisos/ficha.gif" alt="" width="25" height="25" border="0" align="Cotizacion" title="Cotizacion" /> Cotizacion</a>
  
      
    <a href="formularios/CotizacionProducto/DiaCotizacionProductoFotoListado.php?height=440&width=850&CprId=<?php echo $dat->CprId?>" class="thickbox" title="">

Ver Documentacion
</a> 



	  <?php
    
    if(!empty($InsFichaIngreso->CprSeguroFoto)){
        
        $extension = strtolower(pathinfo($InsFichaIngreso->CprSeguroFoto, PATHINFO_EXTENSION));
        $nombre_base = basename($InsFichaIngreso->CprSeguroFoto, '.'.$extension);  
    ?><br />
    <img  title="<?php echo $InsFichaIngreso->CprSeguro;?>" src="subidos/cliente_fotos/<?php echo $nombre_base.".".$extension;?>" width="25" height="25" border="0" />
    <?php
    }
    ?>


 ASEGURADORA: <?php echo $InsFichaIngreso->CprSeguro; ?>
<?php	
}*/
?>
        
        <input type="hidden"  name="CmpCotizacionProductoId" id="CmpCotizacionProductoId" value="<?php echo $InsFichaIngreso->CprId;?>"      />
        
        
        </td>
    </tr>
  </table>
</div>  
<br />

    
    <?php
	//deb($ArrTallerPedidos);
	?>      
<ul class="tabs">


	

	<?php
	$c=2;
	//foreach($InsFichaIngreso->FichaIngresoModalidad as $DatTallerPedido){
	foreach($ArrTallerPedidos as $DatTallerPedido){
    ?>
		<li><a href="#tab<?php echo $c;?>"><?php echo $DatTallerPedido->MinNombre;?></a></li>
	<?php
	$c++;
    }
    ?>
    
    <li><a href="#tab1">Herramientas</a></li>
      <li><a href="#tab<?php echo $c+7;?>">Gastos Adicionales</a></li>
    
	<li><a href="#tab<?php echo $c+1;?>">Historial</a></li>

    <li><a href="#tab<?php echo $c+3;?>">Obs. Taller</a></li>
     <li><a href="#tab<?php echo $c+4;?>">Obs. Almacen</a></li>
     <li><a href="#tab<?php echo $c+5;?>">Fotos GM</a></li>
   
    
</ul>
	
<div class="tab_container">


    
	<?php
	$c=2;
	//foreach($InsFichaIngreso->FichaIngresoModalidad as $DatTallerPedido){
	foreach($ArrTallerPedidos as $DatTallerPedido){
		
		
			$FichaIngresoModalidadObsequio = 2;
			$FichaAccionPedido = "";		
			$FichaAccionManoObra = 0;
			$FichaAccionManoObraDetalle = '';
			$PersonalId = '';
			
			
            if(!empty($InsFichaIngreso->FichaIngresoModalidad)){	
                foreach($InsFichaIngreso->FichaIngresoModalidad as $DatFichaIngresoModalidad){
					
                    if($DatTallerPedido->MinId == $DatFichaIngresoModalidad->MinId){
						
						$InsFichaAccion =  $DatFichaIngresoModalidad->FichaAccion;
						
						$FichaIngresoModalidadObsequio = $DatFichaIngresoModalidad->FimObsequio;
						$FichaAccionPedido = $InsFichaAccion->FccPedido;
						
						$FichaAccionManoObra = $InsFichaAccion->FccManoObra;
						$FichaAccionManoObraDetalle = $InsFichaAccion->FccManoObraDetalle;
						$PersonalId = $InsFichaAccion->PerId;
						
                        break;
                    }					
                }
            }		?>

	<div id="tab<?php echo $c;?>" class="tab_content">

                    <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                    <tr>
                      <td colspan="4">
                      
                      <div class="EstFormularioArea">
                        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                          <tr>
                            <td>&nbsp;</td>
                            <td colspan="6"><span class="EstFormularioSubTitulo">Datos del  PEDIDO DE TALLER: <?php echo strtoupper($DatTallerPedido->MinNombre);?>
                              
                            </span>
                            
                            
                                <?php 
							if($DatTallerPedido->AmoCierre == "1"){
							?>
                             <img  src="imagenes/estado/cerrado.png" width="25" height="25" border="0" title="Cerrado" alt="Cerrado"  align="absmiddle"/>
                            <?php	
							}
							?>
                            
                                                        
<input name="CmpFichaAccionId_<?php echo $DatTallerPedido->MinSigla?>" type="hidden" id="CmpFichaAccionId_<?php echo $DatTallerPedido->MinSigla?>" value="<?php echo $DatTallerPedido->FccId;?>" />


                            <input name="CmpClienteId_<?php echo $DatTallerPedido->MinSigla?>" type="hidden" id="CmpClienteId_<?php echo $DatTallerPedido->MinSigla?>" value="<?php echo $DatTallerPedido->CliId;?>" />
                             
                             
                             <input name="CmpTipoOperacionId_<?php echo $DatTallerPedido->MinSigla?>" type="hidden" id="CmpTipoOperacionId_<?php echo $DatTallerPedido->MinSigla?>" value="<?php echo $DatTallerPedido->TopId;?>" />
                            
                           <!-- <input name="CmpFecha_<?php echo $DatTallerPedido->MinSigla?>" type="hidden" id="CmpFecha_<?php echo $DatTallerPedido->MinSigla?>" value="<?php echo $DatTallerPedido->AmoFecha;?>" />
                            -->
                              <input name="CmpObservacion_<?php echo $DatTallerPedido->MinSigla?>" type="hidden" id="CmpObservacion_<?php echo $DatTallerPedido->MinSigla?>" value="<?php echo $DatTallerPedido->AmoObservacion;?>" />
                              
                              <input name="CmpModalidadIngresoSigla_<?php echo $DatTallerPedido->MinSigla?>" type="hidden" id="CmpModalidadIngresoSigla_<?php echo $DatTallerPedido->MinSigla?>" value="<?php echo $DatTallerPedido->MinSigla?>" />
                              
                              <input name="CmpModalidadIngresoNombre_<?php echo $DatTallerPedido->MinSigla?>" type="hidden" id="CmpModalidadIngresoNombre_<?php echo $DatTallerPedido->MinSigla?>" value="<?php echo $DatTallerPedido->MinNombre;?>" />
                              
                              <input name="CmpModalidadIngresoId_<?php echo $DatTallerPedido->MinSigla?>" type="hidden" id="CmpModalidadIngresoId_<?php echo $DatTallerPedido->MinSigla?>" value="<?php echo $DatTallerPedido->MinId;?>" />
                            
                            <input name="CmpId_<?php echo $DatTallerPedido->MinSigla?>" type="hidden" class="EstFormularioCaja" id="CmpId_<?php echo $DatTallerPedido->MinSigla?>" value="<?php echo $DatTallerPedido->AmoId;?>" size="15" maxlength="20" readonly="readonly" />
                            
                            <input name="CmpFichaAccionId_<?php echo $DatTallerPedido->MinSigla?>" type="hidden" class="EstFormularioCaja" id="CmpFichaAccionId_<?php echo $DatTallerPedido->MinSigla?>" value="<?php echo $DatTallerPedido->FccId;?>" size="15" maxlength="20" readonly="readonly" />
                            
                              <span style="color:#F5F5F5">(<?php echo $DatTallerPedido->FccId;?>) / (<?php echo $DatTallerPedido->MinId;?>) / (<?php echo $DatTallerPedido->AmoId;?>)</span>
                             
                            </td>
                            <td>&nbsp;</td>
                          </tr>
                          <tr>
                            <td>&nbsp;</td>
                            <td align="left" valign="top"><input style="visibility:hidden;" etiqueta="modalidad" checked="checked"  type="checkbox" value="<?php echo $DatTallerPedido->MinId?>" name="CmpModalidadId_<?php echo $DatTallerPedido->MinSigla?>" id="CmpModalidadId_<?php echo $DatTallerPedido->MinSigla?>" sigla="<?php echo $DatTallerPedido->MinSigla?>" /></td>
                            <td align="left" valign="top">&nbsp;</td>
                            <td align="left" valign="top">&nbsp;</td>
                            <td align="left" valign="top">&nbsp;</td>
                            <td align="left" valign="top">&nbsp;</td>
                            <td align="left" valign="top">&nbsp;</td>
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr>
                            <td>&nbsp;</td>
                            <td align="left" valign="top">Descuento:</td>
                            <td align="left" valign="top"><input class="EstFormularioCaja" name="CmpDescuento_<?php echo $DatTallerPedido->MinSigla?>" type="text" id="CmpDescuento_<?php echo $DatTallerPedido->MinSigla?>" value="<?php echo number_format($DatTallerPedido->AmoDescuento,2);?>" size="10" maxlength="10" /></td>
                            <td align="left" valign="top">Fecha de Emisi&oacute;n::</td>
                            <td align="left" valign="top">


<input class="EstFormularioCajaFecha" name="CmpFecha_<?php echo $DatTallerPedido->MinSigla?>" type="text" id="CmpFecha_<?php echo $DatTallerPedido->MinSigla?>" value="<?php echo $DatTallerPedido->AmoFecha;?>" size="10" maxlength="10" <?php echo (($DatTallerPedido->AmoCierre=="1")?'readonly="readonly"':'');?> />

                   <?php 
				if($DatTallerPedido->AmoCierre == "2"){
				?>
                
                   <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnFecha_<?php echo $DatTallerPedido->MinSigla?>" name="BtnFecha_<?php echo $DatTallerPedido->MinSigla?>" width="25" height="25" align="absmiddle"  style="cursor:pointer;" />
                    
             <script type="text/javascript">
Calendar.setup({ 
	inputField : "CmpFecha_<?php echo $DatTallerPedido->MinSigla?>",  // id del campo de texto 
	ifFormat   : "%d/%m/%Y",  //  
	button     : "BtnFecha_<?php echo $DatTallerPedido->MinSigla?>"// el id del botón que  
	});

</script>    		
				<?php
				}
				?>


                            </td>
                            <td align="left" valign="top">Mano de Obra e Insumos: <br />
                            <span class="EstFormularioSubEtiqueta"> (%)</span></td>
                            <td align="left" valign="top">
                            
                            <input name="CmpPorcentajeMantenimiento_<?php echo $DatTallerPedido->MinSigla?>" type="text" class="EstFormularioCajaDeshabilitada" id="CmpPorcentajeMantenimiento_<?php echo $DatTallerPedido->MinSigla?>" value="<?php echo number_format($DatTallerPedido->AmoPorcentajeMantenimiento,2);?>" size="15" maxlength="20" readonly="readonly" />


  <!-- ALMACEN -->
                            <input type="hidden" name="CmpAlmacen_<?php echo $DatTallerPedido->MinSigla?>" id="CmpAlmacen_<?php echo $DatTallerPedido->MinSigla?>" value="<?php echo $DatTallerPedido->AlmId;?>" />
                            <!--<input type="hidden" name="CmpMonedaId_<?php echo $DatTallerPedido->MinSigla?>" id="CmpMonedaId_<?php echo $DatTallerPedido->MinSigla?>" value="<?php echo $DatTallerPedido->MonId;?>" />-->


                            </td>
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr>
                            <td>&nbsp;</td>
                            <td align="left" valign="top">Moneda: </td>
                            <td align="left" valign="top"><select  class="EstFormularioCombo" name="CmpMonedaId_<?php echo $DatTallerPedido->MinSigla?>" id="CmpMonedaId_<?php echo $DatTallerPedido->MinSigla?>">

<?php
foreach($ArrMonedas as $DatMoneda){
?>
<option <?php echo (($DatTallerPedido->MonId==$DatMoneda->MonId)?'selected="selected"':'');?>  value="<?php echo $DatMoneda->MonId;?>"><?php echo $DatMoneda->MonNombre;?></option>
<?php
}
?>

</select></td>
                            <td align="left" valign="top">Tipo de Cambio: <br />
                            <span class="EstFormularioSubEtiqueta"> (0.000)</span></td>
                            <td align="left" valign="top"><table>
                              <tr>
                                <td><input name="CmpTipoCambio_<?php echo $DatTallerPedido->MinSigla?>" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpTipoCambio_<?php echo $DatTallerPedido->MinSigla?>" value="<?php echo $DatTallerPedido->AmoTipoCambio?>" size="10" maxlength="10" /></td>
                                <td><a href="javascript:void(0);" id="BtnTallerPedidoEstablecerMoneda_<?php echo $DatTallerPedido->MinSigla?>"><img src="imagenes/acciones/recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /></a></td>
                              </tr>
                            </table></td>
                            <td align="left" valign="top">Gratuito:</td>
                            <td align="left" valign="top"><input type="hidden" name="CmpFichaIngresoModalidadObsequio_<?php echo $DatTallerPedido->MinSigla?>" id="CmpFichaIngresoModalidadObsequio_<?php echo $DatTallerPedido->MinSigla?>" value="<?php echo $FichaIngresoModalidadObsequio;?>" />
                              <?php
							if($FichaIngresoModalidadObsequio==1){
							?>
                              Si
  <?php
							}else{
							?>
                              No
  <?php	
							}
							?></td>
                            <td align="left" valign="top"></td>
                          </tr>
                          <tr>
                            <td>&nbsp;</td>
                            <td align="left" valign="top">Detalle de Mano de Obra:</td>
                            <td align="left" valign="top"><textarea name="CmpFichaAccionManoObraDetalle_<?php echo $DatTallerPedido->MinSigla?>" cols="45" rows="2" class="EstFormularioCaja" id="CmpFichaAccionManoObraDetalle_<?php echo $DatTallerPedido->MinSigla?>"><?php echo stripslashes($FichaAccionManoObraDetalle);?></textarea>
                            
                            
                            </td>
                            <td align="left" valign="top">Costo de Mano de Obra:</td>
                            <td align="left" valign="top"><input class="EstFormularioCaja" name="CmpFichaAccionManoObra_<?php echo $DatTallerPedido->MinSigla?>" type="text" id="CmpFichaAccionManoObra_<?php echo $DatTallerPedido->MinSigla?>" value="<?php echo number_format($FichaAccionManoObra,2);?>" size="10" maxlength="10" /></td>
                            <td align="left" valign="top">Tecnico:</td>
                            <td align="left" valign="top"><!-- ALMACEN -->
                                
                            <select  class="EstFormularioCombo" name="CmpPersonal_<?php echo $DatTallerPedido->MinSigla?>" id="CmpPersonal_<?php echo $DatTallerPedido->MinSigla?>" >
                    <option value="">Escoja una opcion</option>
                    <?php
					foreach($ArrTecnicos as $DatTecnico){
					?>
                    <option <?php echo ($DatTecnico->PerId==$PersonalId)?'selected="selected"':'';?>  value="<?php echo $DatTecnico->PerId;?>"><?php echo $DatTecnico->PerNombre ?> <?php echo $DatTecnico->PerApellidoPaterno; ?> <?php echo $DatTecnico->PerApellidoMaterno; ?></option>
                    <?php
					}
					?>
                  </select></td>
                            <td align="left" valign="top"></td>
                          </tr>
                        </table>

                      </div>
                      
                      </td>
                    </tr>
                    <tr>
                      <td colspan="4">
                      
<!--<h1><?php echo $DatTallerPedido->MinId;?>333</h1>-->

	                      
					<?php
					//if($DatTallerPedido->MinId <> "MIN-10001"){
						if($DatTallerPedido->MinSigla <> "MA"){
					?>	

                     <div class="EstFormularioArea" id="CapModalidad">
                        <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                          <tr>
                            <td align="center"><span class="EstFormularioSubTitulo"> Productos: <?php echo strtoupper($DatTallerPedido->MinNombre);?></span></td>
                          </tr>
                          <tr>
                            <td width="50%" align="left" valign="top">
                            
                            <div class="EstFormularioArea">
                              <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                                <tr>
                                  <td>&nbsp;</td>
                                  <td colspan="13"><span class="EstFormularioSubTitulo">PRODUCTOS que componen el PEDIDO DE TALLER</span><span class="EstFormularioSubTitulo">
                                    
                                    <input type="hidden" name="Cmp<?php echo $DatTallerPedido->MinSigla?>ProductoUnidadMedida" id="Cmp<?php echo $DatTallerPedido->MinSigla?>ProductoUnidadMedida" value="" />
                                    <input type="hidden" name="Cmp<?php echo $DatTallerPedido->MinSigla?>ProductoUnidadMedidaEquivalente"   id="Cmp<?php echo $DatTallerPedido->MinSigla?>ProductoUnidadMedidaEquivalente" value=""  />

									<input type="hidden" name="Cmp<?php echo $DatTallerPedido->MinSigla?>ProductoId"    id="Cmp<?php echo $DatTallerPedido->MinSigla?>ProductoId" value=""   />
                                    <input type="hidden" name="Cmp<?php echo $DatTallerPedido->MinSigla?>ProductoItem" id="Cmp<?php echo $DatTallerPedido->MinSigla?>ProductoItem" value="" />
                                    <input type="hidden" name="CmpTallerPedido<?php echo $DatTallerPedido->MinSigla?>ProductoId"  class="EstFormularioCaja" id="CmpTallerPedido<?php echo $DatTallerPedido->MinSigla?>ProductoId" value=""  />
                                  
                                  
                                   <input type="hidden" name="Cmp<?php echo $DatTallerPedido->MinSigla?>TallerPedidoDetalleReingreso" id="Cmp<?php echo $DatTallerPedido->MinSigla?>TallerPedidoDetalleReingreso" value="2" />
                                  
                                  
                                       <input type="hidden" name="Cmp<?php echo $DatTallerPedido->MinSigla?>TallerPedidoDetalleEstado" id="Cmp<?php echo $DatTallerPedido->MinSigla?>TallerPedidoDetalleEstado" value="3" />
                                       
                                        <input name="CmpPorcentajeMantenimiento_<?php echo $DatTallerPedido->MinSigla?>" type="hidden" class="EstFormularioCaja" id="CmpPorcentajeMantenimiento_<?php echo $DatTallerPedido->MinSigla?>" value="<?php echo $DatTallerPedido->AmoPorcentajeMantenimiento;?>" size="15" maxlength="20" readonly="readonly" />
                                                        
                               <input name="CmpPorcentajeImpuestoVenta_<?php echo $DatTallerPedido->MinSigla?>" type="hidden" class="EstFormularioCaja" id="CmpPorcentajeImpuestoVenta_<?php echo $DatTallerPedido->MinSigla?>" value="<?php echo $DatTallerPedido->AmoPorcentajeImpuestoVenta;?>" size="15" maxlength="20" readonly="readonly" />
                                       
                                       </span></td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td><input type="hidden" name="CmpTallerPedido<?php echo $DatTallerPedido->MinSigla?>ProductoAccion" id="CmpTallerPedido<?php echo $DatTallerPedido->MinSigla?>ProductoAccion" value="AccTallerPedidoDetalleRegistrar.php" /></td>
                                  <td>C&oacute;digo Orig.:</td>
                                  <td>&nbsp;</td>
                                  <td>C&oacute;digo Alt.:</td>
                                  <td>&nbsp;</td>
                                  <td>Nombre : </td>
                                  <td>Cantidad:</td>
                                  <td>U.M. </td>
                                  <td>Precio:</td>
                                  <td>Importe:</td>
                                  <td>Fecha  Salida F&iacute;sica:</td>
                                  <td><div id="Cap<?php echo $DatTallerPedido->MinSigla?>ProductoBuscar"></div></td>
                                  <td>&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td><a href="javascript:FncTallerPedidoDetalleNuevo('<?php echo $DatTallerPedido->MinSigla?>');"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                                  <td><input name="Cmp<?php echo $DatTallerPedido->MinSigla?>ProductoCodigoOriginal"  type="text" class="EstFormularioCaja" id="Cmp<?php echo $DatTallerPedido->MinSigla?>ProductoCodigoOriginal" size="10" maxlength="20" /></td>
                                  <td><a href="javascript:FncProductoBuscar('CodigoOriginal','<?php echo $DatTallerPedido->MinSigla?>','<?php echo $DatTallerPedido->MinSigla?>');"><img src="imagenes/acciones/buscar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                                  <td><input name="Cmp<?php echo $DatTallerPedido->MinSigla?>ProductoCodigoAlternativo"  type="text" class="EstFormularioCaja" id="Cmp<?php echo $DatTallerPedido->MinSigla?>ProductoCodigoAlternativo" size="10" maxlength="20" /></td>
                                  <td><a href="javascript:FncProductoBuscar('CodigoAlternativo','<?php echo $DatTallerPedido->MinSigla?>','<?php echo $DatTallerPedido->MinSigla?>');"><img src="imagenes/acciones/buscar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                                  <td><input name="Cmp<?php echo $DatTallerPedido->MinSigla?>ProductoNombre" type="text" class="EstFormularioCaja" id="Cmp<?php echo $DatTallerPedido->MinSigla?>ProductoNombre" size="25" /></td>
                                  <td><input name="Cmp<?php echo $DatTallerPedido->MinSigla?>ProductoCantidad" type="text" class="EstFormularioCaja" id="Cmp<?php echo $DatTallerPedido->MinSigla?>ProductoCantidad" size="10" maxlength="10"  /></td>
                                  <td><select  class="EstFormularioCombo" name="Cmp<?php echo $DatTallerPedido->MinSigla?>ProductoUnidadMedidaConvertir" id="Cmp<?php echo $DatTallerPedido->MinSigla?>ProductoUnidadMedidaConvertir">
                                  </select></td>
                                  <td><input name="Cmp<?php echo $DatTallerPedido->MinSigla?>ProductoPrecio" type="text" class="EstFormularioCajaDeshabilitada" id="Cmp<?php echo $DatTallerPedido->MinSigla?>ProductoPrecio" size="10" maxlength="10"   /></td>
                                  <td>
                                    
                                    <input name="Cmp<?php echo $DatTallerPedido->MinSigla?>ProductoImporte" type="text" class="EstFormularioCajaDeshabilitada" id="Cmp<?php echo $DatTallerPedido->MinSigla?>ProductoImporte" size="10" maxlength="10"  />
                                    
                                    
                                  </td>
                                  <td><input name="CmpTallerPedidoDetalleFecha_<?php echo $DatTallerPedido->MinSigla?>"  type="text" class="EstFormularioCajaFecha" id="CmpTallerPedidoDetalleFecha_<?php echo $DatTallerPedido->MinSigla?>" size="10" maxlength="20" readonly="readonly" />
                                    
                                    
                                    <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnTallerPedidoDetalleFecha_<?php echo $DatTallerPedido->MinSigla?>" name="BtnTallerPedidoDetalleFecha_<?php echo $DatTallerPedido->MinSigla?>" width="25" height="25" align="absmiddle"  style="cursor:pointer;" />
                                    
                                    <script type="text/javascript">
Calendar.setup({ 
	inputField : "CmpTallerPedidoDetalleFecha_<?php echo $DatTallerPedido->MinSigla?>",  // id del campo de texto 
	ifFormat   : "%d/%m/%Y",  //  
	button     : "BtnTallerPedidoDetalleFecha_<?php echo $DatTallerPedido->MinSigla?>"// el id del botón que  
	});

</script>    
                                    
                                    
                                    
                                  </td>
                                  <td><a href="javascript:FncTallerPedidoDetalleGuardar('<?php echo $DatTallerPedido->MinSigla?>');"><img src="imagenes/acciones/guardar.png" width="25" height="25" border="0" title="Guardar" alt="[Guardar]" align="absmiddle" /></a></td>
                                  <td><a href="comunes/Producto/FrmProductoBuscar.php?height=440&amp;width=850&amp;Modalidad=<?php echo $DatTallerPedido->MinSigla?>" class="thickbox" title=""><img src="imagenes/acciones/buscador.png" width="25" height="25" border="0" align="absmiddle" ></a></td>
                                </tr>
                              </table>
                            </div>
                            
                            
                            </td>
                          </tr>
                          
                          
                          <tr>
                            <td align="left" valign="top">
                            
                            <div class="EstFormularioArea" >
                              <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                                <tr>
                                  <td width="1%">&nbsp;</td>
                                  <td colspan="2">PRODUCTOS del PEDIDO DE TALLER</td>
                                  <td width="1%">&nbsp;</td>
                                </tr>
                                
                                <?php
								/*
								?>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td colspan="2"><div id="CapTallerPedido<?php echo $DatTallerPedido->MinSigla?>Productos2" class="EstCapTallerPedidoDetalles" ></div></td>
                                  <td>&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td colspan="2">* No olvide definir la UNIDAD DE MEDIDA y la CANTIDAD a solicitar </td>
                                  <td>&nbsp;</td>
                                </tr>
                                 <?php
								*/
								?>
                                
                                <tr>
                                  <td>&nbsp;</td>
                                  <td width="49%"><div class="EstFormularioAccion" id="Cap<?php echo $DatTallerPedido->MinSigla?>ProductoAccion">Listo
                                    para registrar elementos
                                      
                                  </div></td>
                                  <td width="49%" align="right">
                                  
                                  

 <a href="javascript:FncTallerPedidoCargarCotizacionProducto('<?php echo $DatTallerPedido->MinSigla?>');"><img  src="imagenes/acciones/cargar_datos.png"  width="20" height="20"  border="0" title="Cargar Datos"   alt="[Cargar Datos]" align="absmiddle"/> Cargar Productos de Ord. de Venta</a>
 
 
 
<!-- <a href="javascript:FncTallerPedidoDetalleListar('<?php echo $DatTallerPedido->MinSigla?>');"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a> <a href="javascript:FncTallerPedidoDetalleEliminarTodo('<?php echo $DatTallerPedido->MinSigla?>');"><img  src="imagenes/acciones/listado_eliminar_todo.png"  width="25" height="25"  border="0" title="Eliminar Todo"   alt="[Eli. Todo.]" align="absmiddle"/>
 
 
  Eliminar Todo</a>
  -->
  
  
  </td>
                                  <td><div id="CapTallerPedido<?php echo $DatTallerPedido->MinSigla?>ProductosResultado"> </div></td>
                                </tr>
                                
                                <?php
								/*
								?>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td colspan="2">PRODUCTOS adicionales</td>
                                  <td>&nbsp;</td>
                                </tr>
                                <?php
								*/
								?>
                                
                                <tr>
                                  <td>&nbsp;</td>
                                  <td colspan="2"><div id="CapTallerPedido<?php echo $DatTallerPedido->MinSigla?>Productos" class="EstCapTallerPedidoDetalles" ></div></td>
                                  <td>&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td colspan="2">* Los PRODUCTOS adicionales a las que se asignaron inicialmente en la Orden de Trabajo van en este espacio</td>
                                  <td>&nbsp;</td>
                                </tr>
                              </table>
                            </div>
                            </td>
                          </tr>
                          
                          
                          <tr>
                            <td align="left" valign="top"><!--<div class="EstFormularioArea" >
                              <table border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                                <tr>
                                  <td width="4" align="left" valign="top">&nbsp;</td>
                                  <td colspan="2" align="left" valign="top">
                                    
                                    <span class="EstFormularioSubTitulo">Otras Fichas de Salida</span>
                                    
                                                                    </td>
                                  <td width="4" align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td width="138" align="left" valign="top">&nbsp;</td>
                                  <td width="137" align="right" valign="top"><a href="javascript:FncTallerPedidoFichaListar('<?php echo $DatFichaIngresoModalidad->MinSigla?>');"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a>
                                  
                                      <a href="javascript:FncPopUp('formularios/FichaAccion/FrmFichaAccionTallerPedidoImprimir.php?Id=<?php echo $DatFichaIngresoModalidad->FccId;?>&amp;P=',0,0,1,0,0,1,0,screen.height,screen.width);"> <img src="imagenes/avisos/ficha.gif" alt="" width="25" height="25" border="0" align="Ficha" title="Ficha" /> Resumen Ficha</a>    
                                  
                                  
                                  </td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td colspan="2" align="left" valign="top">                                    
                                  
                                  <div class="EstCapTallerPedidoFichas" id="CapTallerPedido<?php echo $DatFichaIngresoModalidad->MinSigla;?>Fichas"></div>
                                  
                                  
                                  </td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td colspan="2" align="left" valign="top">&nbsp;</td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                              </table>
                            </div>-->
                            
                            <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                                <tr>
                                  <td width="1%">&nbsp;</td>
                                  <td colspan="2">TOTALES</td>
                                  <td>&nbsp;</td>
                                </tr>
                                
                                <?php
								/*
                                ?>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td colspan="2"><div id="CapTallerPedido<?php echo $DatTallerPedido->MinSigla?>Productos2" class="EstCapTallerPedidoDetalles" ></div></td>
                                  <td>&nbsp;</td>
                                </tr>
                                  <?php
								*/
                                ?>
                                
                                <tr>
                                  <td>&nbsp;</td>
                                  <td width="49%">&nbsp;</td>
                                  <td width="50%" align="right"><a href="javascript:FncTallerPedidoTotalListar('<?php echo $DatTallerPedido->MinSigla?>');"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a> </td>
                                  <td><div id="CapTallerPedido<?php echo $DatTallerPedido->MinSigla?>ProductosResultado"> </div></td>
                                </tr>
                                
                                <?php
								/*
								?>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td colspan="2">PRODUCTOS adicionales</td>
                                  <td>&nbsp;</td>
                                </tr>
                                 <?php
								*/
								?>
                                
                                <tr>
                                  <td>&nbsp;</td>
                                  <td colspan="2">

									<div id="CapTallerPedido<?php echo $DatTallerPedido->MinSigla?>Totales" class="EstCapTallerPedidoTotales" ></div>

								  </td>
                                  <td>&nbsp;</td>
                                </tr>
                              </table>
                              
                            </td>
                          </tr>
                          <tr>
                            <td align="left" valign="top"><div class="EstFormularioArea" >
                              <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                                <tr>
                                  <td width="1%" align="left" valign="top">&nbsp;</td>
                                  <td width="98%" align="left" valign="top">Pedidos</td>
                                  <td width="1%" align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td align="left" valign="top"><div class="EstFormularioCajaObservacion"> <?php echo stripslashes($FichaAccionPedido);?> </div></td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                              </table>
                            </div></td>
                          </tr>
                          <tr>
                            <td align="left" valign="top"><div class="EstFormularioArea" >
                                <table border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                                  <tr>
                                    <td width="4" align="left" valign="top">&nbsp;</td>
                                    <td colspan="2" align="left" valign="top"><span class="EstFormularioSubTitulo">Fotos</span></td>
                                    <td width="4" align="left" valign="top">&nbsp;</td>
                                  </tr>
                                  <tr>
                                    <td align="left" valign="top">&nbsp;</td>
                                    <td width="138" align="left" valign="top">&nbsp;</td>
                                    <td width="137" align="right" valign="top"><a href="javascript:FncTallerPedidoFotoListar('<?php echo $DatFichaIngresoModalidad->MinSigla?>');"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a></td>
                                    <td align="left" valign="top">&nbsp;</td>
                                  </tr>
                                  <tr>
                                    <td align="left" valign="top">&nbsp;</td>
                                    <td colspan="2" align="left" valign="top"><div class="EstCapTallerPedidoFotos" id="CapTallerPedido<?php echo $DatFichaIngresoModalidad->MinSigla;?>Fotos"></div></td>
                                    <td align="left" valign="top">&nbsp;</td>
                                  </tr>
                                  <tr>
                                    <td align="left" valign="top">&nbsp;</td>
                                    <td colspan="2" align="left" valign="top"><span class="EstFormularioNota">* Fotos del trabajo realizado </span></td>
                                    <td align="left" valign="top">&nbsp;</td>
                                  </tr>
                                </table>
                            </div></td>
                          </tr>
                        </table>
                      </div>
                      
                    
					<?php
					}else{
					?>	
					<div class="EstFormularioArea" >
                        <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                          <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td align="left"><?php
							if($FichaIngresoModalidadObsequio == 1){
							?>
                              <img src="imagenes/acciones/obsequio.jpg" alt="Obsequio" width="20" height="20" border="0" title="Obsequio" /> <span class="EstFormularioResaltar"> Este SERVICIO es GRATUITO </span>
                            <?php	
							}
							?></td>
                            <td>&nbsp;</td>
                          </tr>
                          <tr>
                            <td width="1%">&nbsp;</td>
                            <td width="49%"><span class="EstFormularioSubTitulo"> Tareas del Plan de Mantenimiento</span></td>
                            <td width="49%" align="right"><a href="javascript:FncTallerPedidoMantenimientoListar('<?php echo $DatTallerPedido->MinSigla?>');"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a></td>
                            <td width="1%">&nbsp;</td>
                          </tr>
                          <tr>
                            <td>&nbsp;</td>
                            <td colspan="2"><div id="CapTallerPedido<?php echo $DatTallerPedido->MinSigla?>Mantenimientos" class="EstCapTallerPedidoMantenimientos" > </div></td>
                            <td>&nbsp;</td>
                          </tr>
                          <tr>
                            <td>&nbsp;</td>
                            <td colspan="2"><!--<div class="EstFormularioArea" >
                              <table border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                                <tr>
                                  <td width="4" align="left" valign="top">&nbsp;</td>
                                  <td colspan="2" align="left" valign="top">
                                    
                                    <span class="EstFormularioSubTitulo">Otras Fichas de Salida</span>
                                    
                                                                    </td>
                                  <td width="4" align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td width="138" align="left" valign="top">&nbsp;</td>
                                  <td width="137" align="right" valign="top"><a href="javascript:FncTallerPedidoFichaListar('<?php echo $DatFichaIngresoModalidad->MinSigla?>');"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a>
                                  
                                  
                                                           
                                  
              <a href="javascript:FncPopUp('formularios/FichaAccion/FrmFichaAccionTallerPedidoImprimir.php?Id=<?php echo $DatFichaIngresoModalidad->FccId;?>&amp;P=',0,0,1,0,0,1,0,screen.height,screen.width);"> <img src="imagenes/avisos/ficha.gif" alt="" width="25" height="25" border="0" align="Ficha" title="Ficha" /> Resumen Ficha</a>   
              </td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td colspan="2" align="left" valign="top">                                    
                                  
                                  <div class="EstCapTallerPedidoFichas" id="CapTallerPedido<?php echo $DatFichaIngresoModalidad->MinSigla;?>Fichas"></div>
                                  
                                  
                                  </td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td colspan="2" align="left" valign="top">&nbsp;</td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                              </table>
                            </div>--></td>
                            <td>&nbsp;</td>
                          </tr>
                          <tr>
                            <td>&nbsp;</td>
                            <td colspan="2"><div class="EstFormularioArea">
                              <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                                <tr>
                                  <td>&nbsp;</td>
                                  <td colspan="13"><span class="EstFormularioSubTitulo">PRODUCTOS que componen el PEDIDO DE TALLER</span><span class="EstFormularioSubTitulo">
                                    
                                    <input type="hidden" name="Cmp<?php echo $DatTallerPedido->MinSigla?>ProductoUnidadMedida" id="Cmp<?php echo $DatTallerPedido->MinSigla?>ProductoUnidadMedida" value="" />
                                    <input type="hidden" name="Cmp<?php echo $DatTallerPedido->MinSigla?>ProductoUnidadMedidaEquivalente"   id="Cmp<?php echo $DatTallerPedido->MinSigla?>ProductoUnidadMedidaEquivalente" value=""  />

									<input type="hidden" name="Cmp<?php echo $DatTallerPedido->MinSigla?>ProductoId"    id="Cmp<?php echo $DatTallerPedido->MinSigla?>ProductoId" value=""   />
                                    <input type="hidden" name="Cmp<?php echo $DatTallerPedido->MinSigla?>ProductoItem" id="Cmp<?php echo $DatTallerPedido->MinSigla?>ProductoItem" value="" />
                                    <input type="hidden" name="CmpTallerPedido<?php echo $DatTallerPedido->MinSigla?>ProductoId"  class="EstFormularioCaja" id="CmpTallerPedido<?php echo $DatTallerPedido->MinSigla?>ProductoId" value=""  />
                                  
                                  <input type="hidden" name="Cmp<?php echo $DatTallerPedido->MinSigla?>TallerPedidoDetalleReingreso" id="Cmp<?php echo $DatTallerPedido->MinSigla?>TallerPedidoDetalleReingreso" value="2"     />
                                  
                                  <input type="hidden" name="Cmp<?php echo $DatTallerPedido->MinSigla?>TallerPedidoDetalleEstado" id="Cmp<?php echo $DatTallerPedido->MinSigla?>TallerPedidoDetalleEstado" value="3"     />
                                  
                                  
                                  </span></td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td><input type="hidden" name="CmpTallerPedido<?php echo $DatTallerPedido->MinSigla?>ProductoAccion" id="CmpTallerPedido<?php echo $DatTallerPedido->MinSigla?>ProductoAccion" value="AccTallerPedidoDetalleRegistrar.php" /></td>
                                  <td>C&oacute;digo Orig.:</td>
                                  <td>&nbsp;</td>
                                  <td>C&oacute;digo Alt.:</td>
                                  <td>&nbsp;</td>
                                  <td>Nombre : </td>
                                  <td>Cantidad:</td>
                                  <td>U.M. :</td>
                                  <td>Precio:</td>
                                  <td>Importe:</td>
                                  <td>Fecha:</td>
                                  <td><div id="Cap<?php echo $DatTallerPedido->MinSigla?>ProductoBuscar"></div></td>
                                  <td>&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td><a href="javascript:FncTallerPedidoDetalleNuevo('<?php echo $DatTallerPedido->MinSigla?>');"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                                  <td><input name="Cmp<?php echo $DatTallerPedido->MinSigla?>ProductoCodigoOriginal"  type="text" class="EstFormularioCaja" id="Cmp<?php echo $DatTallerPedido->MinSigla?>ProductoCodigoOriginal" size="10" maxlength="20" /></td>
                                  <td><a href="javascript:FncProductoBuscar('CodigoOriginal','<?php echo $DatTallerPedido->MinSigla?>','<?php echo $DatTallerPedido->MinSigla?>');"><img src="imagenes/acciones/buscar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                                  <td><input name="Cmp<?php echo $DatTallerPedido->MinSigla?>ProductoCodigoAlternativo"  type="text" class="EstFormularioCaja" id="Cmp<?php echo $DatTallerPedido->MinSigla?>ProductoCodigoAlternativo" size="10" maxlength="20" /></td>
                                  <td><a href="javascript:FncProductoBuscar('CodigoAlternativo','<?php echo $DatTallerPedido->MinSigla?>','<?php echo $DatTallerPedido->MinSigla?>');"><img src="imagenes/acciones/buscar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                                  <td><input name="Cmp<?php echo $DatTallerPedido->MinSigla?>ProductoNombre" type="text" class="EstFormularioCaja" id="Cmp<?php echo $DatTallerPedido->MinSigla?>ProductoNombre" size="25" /></td>
                                  <td><input name="Cmp<?php echo $DatTallerPedido->MinSigla?>ProductoCantidad" type="text" class="EstFormularioCaja" id="Cmp<?php echo $DatTallerPedido->MinSigla?>ProductoCantidad" size="10" maxlength="10"  /></td>
                                  <td><select  class="EstFormularioCombo" name="Cmp<?php echo $DatTallerPedido->MinSigla?>ProductoUnidadMedidaConvertir" id="Cmp<?php echo $DatTallerPedido->MinSigla?>ProductoUnidadMedidaConvertir">
                                  </select></td>
                                  <td><input name="Cmp<?php echo $DatTallerPedido->MinSigla?>ProductoPrecio" type="text" class="EstFormularioCajaDeshabilitada" id="Cmp<?php echo $DatTallerPedido->MinSigla?>ProductoPrecio" size="10" maxlength="10"   /></td>
                                  <td><input name="Cmp<?php echo $DatTallerPedido->MinSigla?>ProductoImporte" type="text" class="EstFormularioCajaDeshabilitada" id="Cmp<?php echo $DatTallerPedido->MinSigla?>ProductoImporte" size="10" maxlength="10"  /></td>
                                  <td>
                                    
                                    <input name="CmpTallerPedidoDetalleFecha_<?php echo $DatTallerPedido->MinSigla?>"  type="text" class="EstFormularioCajaFecha" id="CmpTallerPedidoDetalleFecha_<?php echo $DatTallerPedido->MinSigla?>" size="10" maxlength="20" readonly="readonly" />
                                    
                                    
                                    <img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnTallerPedidoDetalleFecha_<?php echo $DatTallerPedido->MinSigla?>" name="BtnTallerPedidoDetalleFecha_<?php echo $DatTallerPedido->MinSigla?>" width="25" height="25" align="absmiddle"  style="cursor:pointer;" />
                                    
                                    <script type="text/javascript">
Calendar.setup({ 
	inputField : "CmpTallerPedidoDetalleFecha_<?php echo $DatTallerPedido->MinSigla?>",  // id del campo de texto 
	ifFormat   : "%d/%m/%Y",  //  
	button     : "BtnTallerPedidoDetalleFecha_<?php echo $DatTallerPedido->MinSigla?>"// el id del botón que  
	});

</script>    
                                    
</td>
                                  <td><a href="javascript:FncTallerPedidoDetalleGuardar('<?php echo $DatTallerPedido->MinSigla?>');"><img src="imagenes/acciones/guardar.png" width="25" height="25" border="0" title="Guardar" alt="[Guardar]" align="absmiddle" /></a></td>
                                  <td><a href="comunes/Producto/FrmProductoBuscar.php?height=440&amp;width=850&amp;Modalidad=<?php echo $DatTallerPedido->MinSigla?>" class="thickbox" title=""><img src="imagenes/acciones/buscador.png" width="25" height="25" border="0" align="absmiddle" ></a></td>
                                </tr>
                              </table>
                            </div></td>
                            <td>&nbsp;</td>
                          </tr>
                          <tr>
                            <td>&nbsp;</td>
                            <td colspan="2"><div class="EstFormularioArea" >
                              <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                                <tr>
                                  <td width="1%">&nbsp;</td>
                                  <td width="49%"><div class="EstFormularioAccion" id="Cap<?php echo $DatTallerPedido->MinSigla?>ProductoAccion">Listo
                                    para registrar elementos
                                      
                                  </div></td>
                                  <td width="50%" align="right"><a href="javascript:FncTallerPedidoDetalleListar('<?php echo $DatTallerPedido->MinSigla?>');"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a> <a href="javascript:FncTallerPedidoDetalleEliminarTodo('<?php echo $DatTallerPedido->MinSigla?>');"><img  src="imagenes/acciones/listado_eliminar_todo.png"  width="25" height="25"  border="0" title="Eliminar Todo"   alt="[Eli. Todo.]" align="absmiddle"/> Eliminar Todo</a></td>
                                  <td width="0%"><div id="CapTallerPedido<?php echo $DatTallerPedido->MinSigla?>ProductosResultado"> </div></td>
                                </tr>
                                
                                <?php
							/*	
								?>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td colspan="2">PRODUCTOS del PEDIDO DE TALLER</td>
                                  <td>&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td colspan="2"><div id="CapTallerPedido<?php echo $DatTallerPedido->MinSigla?>Productos2" class="EstCapTallerPedidoDetalles" ></div></td>
                                  <td>&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td colspan="2">* No olvide definir la UNIDAD DE MEDIDA y la CANTIDAD a solicitar </td>
                                  <td>&nbsp;</td>
                                </tr>
                                       <?php
								*/
								?>                         
                                
                                <?php
							/*	
								?>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td colspan="2">PRODUCTOS adicionales</td>
                                  <td>&nbsp;</td>
                                </tr>
                                
                                <?php
								*/
								?>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td colspan="2"><div id="CapTallerPedido<?php echo $DatTallerPedido->MinSigla?>Productos" class="EstCapTallerPedidoDetalles" ></div></td>
                                  <td>&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td colspan="2">* Los PRODUCTOS adicionales a las que se asignaron inicialmente en la Orden de Trabajo van en este espacio</td>
                                  <td>&nbsp;</td>
                                </tr>
                              </table>
                            </div></td>
                            <td>&nbsp;</td>
                          </tr>
                          <tr>
                            <td>&nbsp;</td>
                            <td colspan="2">
                            
                            <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                                <tr>
                                  <td width="1%">&nbsp;</td>
                                  <td colspan="2">TOTALES</td>
                                  <td>&nbsp;</td>
                                </tr>
                                
                                <?php
								/*
                                ?>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td colspan="2"><div id="CapTallerPedido<?php echo $DatTallerPedido->MinSigla?>Productos2" class="EstCapTallerPedidoDetalles" ></div></td>
                                  <td>&nbsp;</td>
                                </tr>
                                  <?php
								*/
                                ?>
                                
                                <tr>
                                  <td>&nbsp;</td>
                                  <td width="49%">&nbsp;</td>
                                  <td width="50%" align="right"><a href="javascript:FncTallerPedidoTotalListar('<?php echo $DatTallerPedido->MinSigla?>');"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a> </td>
                                  <td><div id="CapTallerPedido<?php echo $DatTallerPedido->MinSigla?>ProductosResultado"> </div></td>
                                </tr>
                                
                                <?php
								/*
								?>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td colspan="2">PRODUCTOS adicionales</td>
                                  <td>&nbsp;</td>
                                </tr>
                                 <?php
								*/
								?>
                                
                                <tr>
                                  <td>&nbsp;</td>
                                  <td colspan="2">

									<div id="CapTallerPedido<?php echo $DatTallerPedido->MinSigla?>Totales" class="EstCapTallerPedidoTotales" ></div>

								  </td>
                                  <td>&nbsp;</td>
                                </tr>
                              </table>
                              
                              <p>&nbsp;</p></td>
                            <td>&nbsp;</td>
                          </tr>
                          <tr>
                            <td>&nbsp;</td>
                            <td colspan="2">
                            
                            <div class="EstFormularioArea" >
                              <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                                <tr>
                                  <td width="1%" align="left" valign="top">&nbsp;</td>
                                  <td width="98%" align="left" valign="top">Pedidos</td>
                                  <td width="1%" align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td align="left" valign="top"><div class="EstFormularioCajaObservacion"> <?php echo stripslashes($FichaAccionPedido);?> </div></td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                              </table>
                            </div>
                            
                            
                            </td>
                            <td>&nbsp;</td>
                          </tr>
                          <tr>
                            <td>&nbsp;</td>
                            <td colspan="2"><div class="EstFormularioArea" >
                                <table border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                                  <tr>
                                    <td width="4" align="left" valign="top">&nbsp;</td>
                                    <td colspan="2" align="left" valign="top"><span class="EstFormularioSubTitulo">Fotos</span></td>
                                    <td width="4" align="left" valign="top">&nbsp;</td>
                                  </tr>
                                  <tr>
                                    <td align="left" valign="top">&nbsp;</td>
                                    <td width="138" align="left" valign="top">&nbsp;</td>
                                    <td width="137" align="right" valign="top"><a href="javascript:FncTallerPedidoFotoListar('<?php echo $DatFichaIngresoModalidad->MinSigla?>');"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a></td>
                                    <td align="left" valign="top">&nbsp;</td>
                                  </tr>
                                  <tr>
                                    <td align="left" valign="top">&nbsp;</td>
                                    <td colspan="2" align="left" valign="top"><div class="EstCapTallerPedidoFotos" id="CapTallerPedido<?php echo $DatFichaIngresoModalidad->MinSigla;?>Fotos"></div></td>
                                    <td align="left" valign="top">&nbsp;</td>
                                  </tr>
                                  <tr>
                                    <td align="left" valign="top">&nbsp;</td>
                                    <td colspan="2" align="left" valign="top"><span class="EstFormularioNota">* Fotos del trabajo realizado </span></td>
                                    <td align="left" valign="top">&nbsp;</td>
                                  </tr>
                                </table>
                            </div></td>
                            <td>&nbsp;</td>
                          </tr>
                          <tr>
                            <td>&nbsp;</td>
                            <td colspan="2"></td>
                            <td>&nbsp;</td>
                          </tr>
                          </table>
                        </div>
                    <?php	
					}
					?>
                      
                      
                      
                      </td>
                    </tr>
                    </table>
                  
	</div>
    
	<?php
	$c++;
    }
    ?>
    
    
    
	<div id="tab1" class="tab_content">

		<table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                          <tr>
                            <td colspan="2" align="center"><span class="EstFormularioSubTitulo">Herramientas a utilizar</span></td>
                          </tr>
                          <tr>
                           
                            <td width="50%" align="left" valign="top"><div class="EstFormularioArea" >
                              <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                                <tr>
                                  <td width="1%"><span class="EstFormularioAccion">
                                    <input type="hidden" name="CmpTallerPedidoHerramientaAccion" id="CmpTallerPedidoHerramientaAccion" value="AccTallerPedidoHerramientaRegistrar.php" /></span></td>
                                  <td width="49%"><div class="EstFormularioAccion" id="CapHerramientaAccion">Listo
                                    para registrar elementos
                                      
                                  </div></td>
                                  <td width="49%" align="right"><a href="javascript:FncTallerPedidoHerramientaListar();"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a>
                                  <!--<a href="javascript:FncTallerPedidoHerramientaEliminarTodo();"><img  src="imagenes/acciones/listado_eliminar_todo.png"  width="25" height="25"  border="0" title="Eliminar Todo"   alt="[Eli. Todo.]" align="absmiddle"/> Eliminar Todo</a>-->
                                  
                                  </td>
                                  <td width="1%"><div id="CapTallerPedidoHerramientasResultado"> </div></td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td colspan="2"><div id="CapTallerPedidoHerramientas" class="EstCapTallerPedidoHerramientas" ></div></td>
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
                        </table>
                        
                        
       
    
    </div>
    


    
                    <div id="tab<?php echo $c+7;?>" class="tab_content">
    	<table width="100%" border="0" cellpadding="2" cellspacing="2">
            
            <tr>
              <td width="97%" valign="top">
                <div class="EstFormularioArea" >
                        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                    <tr>
                      <td><span class="EstFormularioSubTitulo"> GASTOS ADICIONALES</span></td>
                      </tr>
                    <tr>
                      <td>
                      


<div class="EstFormularioArea">
                              <table width="918" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                                <tr>
                                  <td width="4">&nbsp;</td>
                                  <td colspan="10"><span class="EstFormularioSubTitulo">SERVICIOS Y PRODUCTOS ALTERNATIVOS</span><span class="EstFormularioSubTitulo">
                                    
                                    <input type="hidden" name="CmpTallerPedidoGastoItem" id="CmpTallerPedidoGastoItem" value="" />
                                    <input type="hidden" name="CmpTallerPedidoGastoId"  class="EstFormularioCaja" id="CmpTallerPedidoGastoId" value=""  />
                                    
                                    <input type="hidden" name="CmpGastoId"  class="EstFormularioCaja" id="CmpGastoId" value=""  />
                                    
                                    <input type="hidden" name="CmpGastoMonedaNombre"  class="EstFormularioCaja" id="CmpGastoMonedaNombre" value=""  />
                                    
                                    <input type="hidden" name="CmpGastoMonedaSimbolo"  class="EstFormularioCaja" id="CmpGastoMonedaSimbolo" value=""  />
                                    
                                     <input type="hidden" name="CmpGastoTipoCambio"  class="EstFormularioCaja" id="CmpGastoTipoCambio" value=""  />
                                     
                                     <input type="hidden" name="CmpGastoMonedaId"  class="EstFormularioCaja" id="CmpGastoMonedaId" value=""  />
                                     
                                     <input type="hidden" name="CmpGastoFoto"  class="EstFormularioCaja" id="CmpGastoFoto" value=""  />

                                  </span></td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td width="20" align="left" valign="top"><input type="hidden" name="CmpTallerPedidoGastoAccion" id="CmpTallerPedidoGastoAccion" value="AccTallerPedidoGastoRegistrar.php" /></td>
                                  <td width="66" align="left" valign="top">Num. Comprob.:</td>
                                  <td width="90" align="left" valign="top">&nbsp;</td>
                                  <td width="63" align="left" valign="top">Fecha Comprob.</td>
                                  <td width="240" align="left" valign="top">Proveedor : </td>
                                  <td width="60" align="left" valign="top">Concepto:</td>
                                  <td width="60" align="left" valign="top">Moneda:</td>
                                  <td width="60" align="left" valign="top">Total:</td>
                                  <td width="20" align="left" valign="top"><div id="CapGastoBuscar"></div></td>
                                  <td width="101" align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td align="left" valign="top"><a href="javascript:FncTallerPedidoGastoNuevo();"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                                  <td align="left" valign="top"><input name="CmpGastoComprobanteNumero"  type="text" class="EstFormularioCaja" id="CmpGastoComprobanteNumero" size="10" maxlength="20" /></td>
                                  <td align="left" valign="top"><!--<a href="javascript:FncTallerPedidoGastoBuscar('NumeroComprobante');"><img src="imagenes/acciones/buscar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a>-->
                                  
                                  
<a id="BtnGastoRegistrar" onclick="FncGastoCargarFormulario('Registrar');" href="javascript:void(0)" title=""> <img src="imagenes/acciones/registrar.png" alt="[Registrar]" width="25" height="25" border="0" align="absmiddle" title="Registrar" /> </a> 
 
<a id="BtnGastoEditar" onclick="FncGastoCargarFormulario('Editar');" href="javascript:void(0)"   title=""> <img src="imagenes/acciones/editar.png" alt="[Editar]" width="25" height="25" border="0" align="absmiddle" title="Editar" /> </a>
 
 
 
                                  
                                  </td>
                                  <td align="left" valign="top"><input name="CmpGastoComprobanteFecha"  type="text" class="EstFormularioCajaDeshabilitada" id="CmpGastoComprobanteFecha" size="10" maxlength="20" readonly="readonly" /></td>
                                  <td align="left" valign="top"><input name="CmpProveedorNombre" type="text" class="EstFormularioCajaDeshabilitada" id="CmpProveedorNombre" size="30" /></td>
                                  <td align="left" valign="top"><input name="CmpGastoConcepto" type="text" class="EstFormularioCajaDeshabilitada" id="CmpGastoConcepto" size="30" /></td>
                                  <td align="left" valign="top"><select disabled="disabled"  class="EstFormularioCombo" name="CmpGastoMoneda" id="CmpGastoMoneda">
                                    <?php
foreach($ArrMonedas as $DatMoneda){
?>
                                    <option <?php echo (($InsTallerPedido->MonId==$DatMoneda->MonId)?'selected="selected"':'');?>  value="<?php echo $DatMoneda->MonId;?>"><?php echo $DatMoneda->MonNombre;?></option>
                                    <?php
}
?>
                                  </select></td>
                                  <td align="left" valign="top"><input name="CmpGastoTotal" type="text" class="EstFormularioCajaDeshabilitada" id="CmpGastoTotal" size="10" maxlength="10"  /></td>
                                  <td align="left" valign="top"><a href="javascript:FncTallerPedidoGastoGuardar();"><img src="imagenes/acciones/guardar.png" width="25" height="25" border="0" title="Guardar" alt="[Guardar]" align="absmiddle" /></a></td>
                                  <td align="left" valign="top">
                                  
                                  <!--<a href="comunes/Producto/FrmProductoBuscar.php?height=440&amp;width=850&amp;Modalidad=<?php echo $DatTallerPedido->MinSigla?>" class="thickbox" title=""><img src="imagenes/acciones/buscador.png" width="25" height="25" border="0" align="absmiddle" ></a>--></td>
                                </tr>
                              </table>
                            </div>
                            
                            
                            
                          </td>
                    </tr>
                    <tr>
                      <td><div class="EstFormularioArea" >
                        <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                          <tr>
                            <td width="1%">&nbsp;</td>
                            <td width="49%"><div class="EstFormularioAccion" id="CapTallerPedidoGastoAccion">Listo
                              para registrar elementos</div></td>
                            <td width="49%" align="right"><a href="javascript:FncTallerPedidoGastoListar();"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a></td>
                            <td width="1%"><div id="CapTallerPedidoGastosResultado"> </div></td>
                            </tr>
                          <tr>
                            <td>&nbsp;</td>
                            <td colspan="2"><div id="CapTallerPedidoGastos" class="EstCapTallerPedidoGastos" > </div></td>
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
                      <td>
                      
                 <!--     <div class="EstFormularioArea">
                        <table width="918" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                          <tr>
                            <td width="4">&nbsp;</td>
                            <td colspan="9"><span class="EstFormularioSubTitulo">REPUESTOS</span><span class="EstFormularioSubTitulo">
                              <input type="hidden" name="CmpTallerPedidoAlmacenMovimientoEntradaItem" id="CmpTallerPedidoAlmacenMovimientoEntradaItem" value="" />
                              <input type="hidden" name="CmpTallerPedidoAlmacenMovimientoEntradaId"  class="EstFormularioCaja" id="CmpTallerPedidoAlmacenMovimientoEntradaId" value=""  />
                              <input type="hidden" name="CmpAlmacenMovimientoEntradaId"  class="EstFormularioCaja" id="CmpAlmacenMovimientoEntradaId" value=""  />
                              <input type="hidden" name="CmpAlmacenMovimientoEntradaMonedaNombre"  class="EstFormularioCaja" id="CmpAlmacenMovimientoEntradaMonedaNombre" value=""  />
                              <input type="hidden" name="CmpAlmacenMovimientoEntradaMonedaSimbolo"  class="EstFormularioCaja" id="CmpAlmacenMovimientoEntradaMonedaSimbolo" value=""  />
                              <input type="hidden" name="CmpAlmacenMovimientoEntradaTipoCambio"  class="EstFormularioCaja" id="CmpAlmacenMovimientoEntradaTipoCambio" value=""  />
                              <input type="hidden" name="CmpAlmacenMovimientoEntradaMonedaId"  class="EstFormularioCaja" id="CmpAlmacenMovimientoEntradaMonedaId" value=""  />
                              <input type="hidden" name="CmpAlmacenMovimientoEntradaFoto"  class="EstFormularioCaja" id="CmpAlmacenMovimientoEntradaFoto" value=""  />
                            </span></td>
                          </tr>
                          <tr>
                            <td>&nbsp;</td>
                            <td width="20" align="left" valign="top"><input type="hidden" name="CmpTallerPedidoAlmacenMovimientoEntradaAccion" id="CmpTallerPedidoAlmacenMovimientoEntradaAccion" value="AccTallerPedidoAlmacenMovimientoEntradaRegistrar.php" /></td>
                            <td width="66" align="left" valign="top">Num. Comprob.:</td>
                            <td width="90" align="left" valign="top">&nbsp;</td>
                            <td width="63" align="left" valign="top">Fecha Comprob.</td>
                            <td width="240" align="left" valign="top">Proveedor : </td>
                            <td width="60" align="left" valign="top">Moneda:</td>
                            <td width="60" align="left" valign="top">Total:</td>
                            <td width="20" align="left" valign="top"><div id="CapAlmacenMovimientoEntradaBuscar"></div></td>
                            <td width="101" align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr>
                            <td>&nbsp;</td>
                            <td align="left" valign="top"><a href="javascript:FncTallerPedidoAlmacenMovimientoEntradaNuevo();"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                            <td align="left" valign="top"><input name="CmpAlmacenMovimientoEntradaComprobanteNumero"  type="text" class="EstFormularioCaja" id="CmpAlmacenMovimientoEntradaComprobanteNumero" size="10" maxlength="20" /></td>
                            <td align="left" valign="top">
                            
                            
           
                            
                              <a id="BtnAlmacenMovimientoEntradaRegistrar" onclick="FncAlmacenMovimientoEntradaCargarFormulario('Registrar');" href="javascript:void(0)" title=""> <img src="imagenes/acciones/registrar.png" alt="[Registrar]" width="25" height="25" border="0" align="absmiddle" title="Registrar" /></a> <a id="BtnAlmacenMovimientoEntradaEditar" onclick="FncAlmacenMovimientoEntradaCargarFormulario('Editar');" href="javascript:void(0)"   title=""> <img src="imagenes/acciones/editar.png" alt="[Editar]" width="25" height="25" border="0" align="absmiddle" title="Editar" /></a></td>
                            <td align="left" valign="top"><input name="CmpAlmacenMovimientoEntradaComprobanteFecha"  type="text" class="EstFormularioCajaDeshabilitada" id="CmpAlmacenMovimientoEntradaComprobanteFecha" size="10" maxlength="20" readonly="readonly" /></td>
                            <td align="left" valign="top"><input name="CmpProveedorNombre2" type="text" class="EstFormularioCajaDeshabilitada" id="CmpProveedorNombre2" size="30" /></td>
                            <td align="left" valign="top"><select  class="EstFormularioCombo" name="CmpAlmacenMovimientoEntradaMoneda" id="CmpAlmacenMovimientoEntradaMoneda">
                              <?php
foreach($ArrMonedas as $DatMoneda){
?>
                              <option <?php echo (($InsTallerPedido->MonId==$DatMoneda->MonId)?'selected="selected"':'');?>  value="<?php echo $DatMoneda->MonId;?>"><?php echo $DatMoneda->MonNombre;?></option>
                              <?php
}
?>
                            </select></td>
                            <td align="left" valign="top"><input name="CmpAlmacenMovimientoEntradaTotal" type="text" class="EstFormularioCajaDeshabilitada" id="CmpAlmacenMovimientoEntradaTotal" size="10" maxlength="10"  /></td>
                            <td align="left" valign="top"><a href="javascript:FncTallerPedidoAlmacenMovimientoEntradaGuardar();"><img src="imagenes/acciones/guardar.png" width="25" height="25" border="0" title="Guardar" alt="[Guardar]" align="absmiddle" /></a></td>
                            <td align="left" valign="top"></td>
                          </tr>
                        </table>
                      </div>
                      -->
                      
                      </td>
                    </tr>
                    <tr>
                      <td>
                      
                      
                   <!--   <div class="EstFormularioArea" >
                        <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                          <tr>
                            <td width="1%">&nbsp;</td>
                            <td width="49%"><div class="EstFormularioAccion" id="CapTallerPedidoAlmacenMovimientoEntradaAccion">Listo
                              para registrar elementos</div></td>
                            <td width="49%" align="right"><a href="javascript:FncTallerPedidoAlmacenMovimientoEntradaListar();"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a></td>
                            <td width="1%"><div id="CapTallerPedidoAlmacenMovimientoEntradasResultado"> </div></td>
                          </tr>
                          <tr>
                            <td>&nbsp;</td>
                            <td colspan="2"><div id="CapTallerPedidoAlmacenMovimientoEntradas" class="EstCapTallerPedidoAlmacenMovimientoEntradas" > </div></td>
                            <td>&nbsp;</td>
                          </tr>
                          <tr>
                            <td>&nbsp;</td>
                            <td colspan="2">&nbsp;</td>
                            <td>&nbsp;</td>
                          </tr>
                        </table>
                      </div>
                      
                      -->
                      
                      </td>
                      </tr>
                    </table>
                      </div>    
                </td>
            </tr>
            </table>    
    </div>
    
    
                <div id="tab<?php echo $c+1;?>" class="tab_content">
    	<table width="100%" border="0" cellpadding="2" cellspacing="2">
            
            <tr>
              <td width="97%" valign="top">
                <div class="EstFormularioArea">
                  <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                    <tr>
                      <td><span class="EstFormularioSubTitulo">Historial OTs</span></td>
                      </tr>
                    <tr>
                      <td><div class="EstFormularioArea" >
                        <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                          <tr>
                            <td width="3%">&nbsp;</td>
                            <td width="47%"><div class="EstFormularioAccion" id="CapTallerPedidoHistorialAccion">Listo
                              para registrar elementos</div></td>
                            <td width="49%" align="right"><a href="javascript:FncTallerPedidoHistorialListar();"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a></td>
                            <td width="1%"><div id="CapTallerPedidoHistorialesResultado"> </div></td>
                            </tr>
                          <tr>
                            <td>&nbsp;</td>
                            <td colspan="2"><div id="CapTallerPedidoHistoriales" class="EstCapTallerPedidoHistoriales" > </div></td>
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
                      <td><span class="EstFormularioSubTitulo">Cotizaciones</span></td>
                    </tr>
                    <tr>
                      <td><div class="EstFormularioArea" >
                        <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                          <tr>
                            <td width="3%">&nbsp;</td>
                            <td width="47%"><div class="EstFormularioAccion" id="CapTallerPedidoCotizacionesAccion">Listo
                              para registrar elementos</div></td>
                            <td width="49%" align="right"><a href="javascript:FncTallerPedidoCotizacionesListar();"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a></td>
                            <td width="1%"><div id="CapTallerPedidoCotizacionesResultado"> </div></td>
                            </tr>
                          <tr>
                            <td>&nbsp;</td>
                            <td colspan="2"><div id="CapTallerPedidoCotizaciones" class="EstCapTallerPedidoCotizaciones" > </div></td>
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
                      <td></td>
                    </tr>
                    </table>
                  
                  
                  
                  </div>     
                </td>
            </tr>
            </table>    
    </div>
    

    
    
    
         <div id="tab<?php echo $c+3;?>" class="tab_content">
    	<table width="100%" border="0" cellpadding="2" cellspacing="2">
            
            <tr>
              <td width="97%" valign="top">
                <div class="EstFormularioArea">
                
                  <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                    <tr>
                      <td><span class="EstFormularioSubTitulo">OBERVACIONES DE TALLER</span></td>
                      </tr>
                    <tr>
                      <td><div class="EstFormularioArea" >
                        <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                                <tr>
                                  <td width="1%" align="left" valign="top">&nbsp;</td>
                                  <td width="98%" align="left" valign="top">&nbsp;</td>
                                  <td width="1%" align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td align="left" valign="top"><div class="EstFormularioCajaObservacion"> <?php echo stripslashes($InsFichaIngreso->FinSalidaObservacion);?> </div></td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                              </table>
                      </div></td>
                      </tr>
                    </table>
                  
                  
                  
                  </div>     
                </td>
            </tr>
            </table>    
    </div>
    
    
    
    
    
    
    <div id="tab<?php echo $c+4;?>" class="tab_content">
    
    	<div class="EstFormularioArea">
    

	  <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
	    <tr>
	      <td>&nbsp;</td>
	      <td><span class="EstFormularioSubTitulo">OBSERVACIONES ALMACEN</span></td>
	      <td>&nbsp;</td>
	      </tr>
	    <tr>
	      <td>&nbsp;</td>
	      <td align="left" valign="top">&nbsp;</td>
	      <td align="left" valign="top">&nbsp;</td>
	      </tr>
	    <tr>
	      <td>&nbsp;</td>
	      <td align="left" valign="top">
	        
  <script type="text/javascript">

tinymce.init({
	selector: "textarea#CmpAlmacenObservacion",
	theme: "modern",
	menubar : false,
	toolbar1: "bold italic | bullist numlist",
	width : 700,
	height : 180
});

</script>
	        
  <textarea name="CmpAlmacenObservacion" cols="60" rows="2" class="EstFormularioCaja" id="CmpAlmacenObservacion"><?php echo stripslashes($InsFichaIngreso->FinAlmacenObservacion);?></textarea>
	        
	        
	        </td>
	      <td align="left" valign="top">&nbsp;</td>
	      </tr>
	    <tr>
	      <td>&nbsp;</td>
	      <td align="left" valign="top">&nbsp;</td>
	      <td align="left" valign="top">&nbsp;</td>
	      </tr>
	    </table>

	    </div>
	</div>
    
    
    	<div id="tab<?php echo $c+5;?>" class="tab_content">
    	<table width="100%" border="0" cellpadding="2" cellspacing="2">
            
            <tr>
              <td width="97%" valign="top">
              
              
              <div class="EstFormularioArea">
                  <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                    <tr>
                      <td><span class="EstFormularioSubTitulo">Foto VIN</span></td>
                      </tr>
                    <tr>
                      <td>
                      
                      
                      
                      
                      
                      <div class="EstFormularioArea" >
                              <table border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                                <tr>
                                  <td width="4" align="left" valign="top">&nbsp;</td>
                                  <td colspan="2" align="left" valign="top">
                                    
                                    <span class="EstFormularioSubTitulo">Fotos</span>
                                    
                                    <a href="javascript:FncTallerPedidoFotoVINListar();"></a>                                  </td>
                                  <td width="4" align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td width="1" align="left" valign="top">&nbsp;</td>
                                  <td width="274" align="right" valign="top"><a href="javascript:FncTallerPedidoFotoVINListar();"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a></td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td align="left" valign="top"><div class="EstCapTallerPedidoFotoVINs" id="CapTallerPedidoFotoVINs"></div></td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td colspan="2" align="left" valign="top">
                                    
                                    <span class="EstFormularioNota">* Fotos del VIN del vehiculo </span>
                                    
                                  </td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                              </table>
                            </div>
                            
                            
                     
                     </td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td><span class="EstFormularioSubTitulo">Foto Frontal</span></td>
                    </tr>
                    <tr>
                      <td>
                      
                      
                      
                      <div class="EstFormularioArea" >
                              <table border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                                <tr>
                                  <td width="4" align="left" valign="top">&nbsp;</td>
                                  <td colspan="2" align="left" valign="top">
                                    
                                    <span class="EstFormularioSubTitulo">Fotos</span>                                  </td>
                                  <td width="4" align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td width="1" align="left" valign="top">&nbsp;</td>
                                  <td width="260" align="right" valign="top"><a href="javascript:FncTallerPedidoFotoDelanteraListar();"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a></td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td align="left" valign="top">&nbsp;</td>
								<td align="left" valign="top"><div class="EstCapTallerPedidoFotoDelanteras" id="CapTallerPedidoFotoDelanteras"></div></td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td colspan="2" align="left" valign="top">
                                    
                                    <span class="EstFormularioNota">* Fotos de la Delantera del vehiculo </span>
                                    
                                  </td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                              </table>
                            </div>
                            
                            
                            
                    
                    
                      </td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td><span class="EstFormularioSubTitulo">Foto Cupon</span></td>
                    </tr>
                    <tr>
                      <td><div class="EstFormularioArea" >
                        <table border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                          <tr>
                            <td width="4" align="left" valign="top">&nbsp;</td>
                            <td colspan="2" align="left" valign="top"><span class="EstFormularioSubTitulo">Fotos</span>                            </td>
                            <td width="4" align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr>
                            <td align="left" valign="top">&nbsp;</td>
                            <td width="1" align="left" valign="top">&nbsp;</td>
                            <td width="274" align="right" valign="top"><a href="javascript:FncTallerPedidoFotoCuponListar();"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a></td>
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr>
                            <td align="left" valign="top">&nbsp;</td>
                            <td align="left" valign="top">&nbsp;</td>
                            <td align="left" valign="top"><div class="EstCapTallerPedidoFotoCupones" id="CapTallerPedidoFotoCupones"></div></td>
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr>
                            <td align="left" valign="top">&nbsp;</td>
                            <td colspan="2" align="left" valign="top">&nbsp;</td>
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                        </table>
                      </div></td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td><span class="EstFormularioSubTitulo">Foto Mantenimiento</span></td>
                    </tr>
                    <tr>
                      <td><div class="EstFormularioArea" >
                        <table border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                          <tr>
                            <td width="4" align="left" valign="top">&nbsp;</td>
                            <td colspan="2" align="left" valign="top"><span class="EstFormularioSubTitulo">Fotos</span>                            </td>
                            <td width="4" align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr>
                            <td align="left" valign="top">&nbsp;</td>
                            <td width="1" align="left" valign="top">&nbsp;</td>
                            <td width="274" align="right" valign="top"><a href="javascript:FncTallerPedidoFotoMantenimientoListar();"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a></td>
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr>
                            <td align="left" valign="top">&nbsp;</td>
                            <td align="left" valign="top">&nbsp;</td>
                            <td align="left" valign="top"><div class="EstCapTallerPedidoFotoMantenimientos" id="CapTallerPedidoFotoMantenimientos"></div></td>
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr>
                            <td align="left" valign="top">&nbsp;</td>
                            <td colspan="2" align="left" valign="top">&nbsp;</td>
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                        </table>
                      </div></td>
                    </tr>
                    <tr>
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
</script>

<?php
}else{
	echo ERR_TPE_705;		
}
?>

<?php

}else{
	echo ERR_GEN_101;
}

if(!$_SESSION['MysqlDeb']){
	$InsMensaje->MtdRedireccionar("principal.php?Mod=".$GET_mod."&Form=Listado",$Edito,1500);
}
	
//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();
?>
