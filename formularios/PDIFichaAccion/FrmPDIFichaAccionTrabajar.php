<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],"FichaAccion","Editar")){
?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Proveedor');?>JsProveedorAutocompletar.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Proveedor');?>JsProveedorFunciones.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsPDIFichaAccionFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsPDIFichaAccionTareaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsPDIFichaAccionFotoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsPDIFichaAccionTemparioFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsPDIFichaAccionProductoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsPDIFichaAccionSuministroFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsPDIFichaAccionMantenimientoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsPDIFichaAccionHerramientaFunciones.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsPDIFichaAccionHistorialFunciones.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsPDIFichaAccionFotoVINFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsPDIFichaAccionFotoDelanteraFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsPDIFichaAccionFotoCuponFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsPDIFichaAccionFotoMantenimientoFunciones.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs("PreEntrega");?>JsPreEntregaPDSDetalleFunciones.js" ></script>

<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss("PreEntrega");?>CssPreEntrega.css');
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssPDIFichaAccion.css');
@import url('<?php echo $InsProyecto->MtdFormulariosCss("PlanMantenimiento");?>CssPlanMantenimiento.css');
</style>

<?php
$GET_Id = $_GET['Id'];

$Edito = false;

if(!empty($_POST['Identificador'])){
	$Identificador = $_POST['Identificador'];
}
include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjPDIFichaAccion.php');
include($InsProyecto->MtdFormulariosMsj("FichaIngreso").'MsjFichaIngreso.php');

require_once($InsPoo->MtdPaqActividad().'ClsFichaAccion.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionFoto.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionSalidaExterna.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionTarea.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionTempario.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionProducto.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionMantenimiento.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionSuministro.php');

require_once($InsPoo->MtdPaqActividad().'ClsModalidadIngreso.php');

require_once($InsPoo->MtdPaqActividad().'ClsFichaIngreso.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoLlamada.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoGasto.php');
require_once($InsPoo->MtdPaqActividad().'ClsPreEntregaDetalle.php');
require_once($InsPoo->MtdPaqActividad().'ClsPreEntregaTarea.php');
require_once($InsPoo->MtdPaqActividad().'ClsPreEntregaSeccion.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoProducto.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoTarea.php');

require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoModalidad.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoHerramienta.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoSuministro.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoMantenimiento.php');

require_once($InsPoo->MtdPaqActividad().'ClsPlanMantenimiento.php');
require_once($InsPoo->MtdPaqActividad().'ClsPlanMantenimientoDetalle.php');
require_once($InsPoo->MtdPaqActividad().'ClsPlanMantenimientoSeccion.php');
require_once($InsPoo->MtdPaqActividad().'ClsPlanMantenimientoTarea.php');

//require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoSalida.php');
//require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoSalidaDetalle.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsTallerPedido.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsTallerPedidoDetalle.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsUnidadMedidaConversion.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsUnidadMedida.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProducto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoCodigoReemplazo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoVehiculoVersion.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoAno.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsListaPrecio.php');
//require_once($InsPoo->MtdPaqAlmacen().'ClsProductoCosto.php');

require_once($InsPoo->MtdPaqLogistica().'ClsTipoDocumento.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngreso.php');

require_once($InsPoo->MtdPaqActividad().'ClsPreEntregaDetalle.php');
require_once($InsPoo->MtdPaqActividad().'ClsPreEntregaSeccion.php');
require_once($InsPoo->MtdPaqActividad().'ClsPreEntregaTarea.php');




$InsFichaAccion = new ClsFichaAccion();
$InsFichaIngreso = new ClsFichaIngreso();
$InsModalidadIngreso = new ClsModalidadIngreso();

$InsPlanMantenimiento = new ClsPlanMantenimiento();
$InsPlanMantenimientoTarea = new ClsPlanMantenimientoTarea();
$InsPlanMantenimientoSeccion = new ClsPlanMantenimientoSeccion();

$InsProducto = new ClsProducto();
$InsUnidadMedida = new ClsUnidadMedida();
$InsUnidadMedidaConversion = new ClsUnidadMedidaConversion();

$InsTipoDocumento = new ClsTipoDocumento();

$InsMoneda = new ClsMoneda();

$InsPreEntregaTarea = new ClsPreEntregaTarea();
$InsPreEntregaSeccion = new ClsPreEntregaSeccion();




$InsFichaIngreso->FinId = $GET_Id;
$InsFichaIngreso = $InsFichaIngreso->MtdObtenerFichaIngreso();	
$InsFichaIngreso->UsuId = $_SESSION['SesionId'];
	
$ArrFichaAccion = NULL;	
$ArrFichaAccion = array();

$ResModalidadIngreso = $InsModalidadIngreso->MtdObtenerModalidadIngresos(NULL,NULL,"MinId","ASC",NULL,"1,3");
$ArrModalidadIngresos = $ResModalidadIngreso['Datos'];

	if (!isset($_SESSION['InsPreEntregaDetalle'.$Identificador])){	
		$_SESSION['InsPreEntregaDetalle'.$Identificador] = new ClsSesionObjeto();
	}else{	
		$_SESSION['InsPreEntregaDetalle'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsPreEntregaDetalle'.$Identificador]);
	}
	
	
if(!empty($InsFichaIngreso->FichaIngresoModalidad)){
	foreach($InsFichaIngreso->FichaIngresoModalidad as $DatFichaIngresoModalidad){
			
			
		if (!isset($_SESSION['InsFichaAccionTarea'.$DatFichaIngresoModalidad->MinSigla.$Identificador])){	
			$_SESSION['InsFichaAccionTarea'.$DatFichaIngresoModalidad->MinSigla.$Identificador] = new ClsSesionObjeto();
		}else{	
			$_SESSION['InsFichaAccionTarea'.$DatFichaIngresoModalidad->MinSigla.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsFichaAccionTarea'.$DatFichaIngresoModalidad->MinSigla.$Identificador]);
		}	
		
		
		if (!isset($_SESSION['InsFichaAccionTempario'.$DatFichaIngresoModalidad->MinSigla.$Identificador])){	
			$_SESSION['InsFichaAccionTempario'.$DatFichaIngresoModalidad->MinSigla.$Identificador] = new ClsSesionObjeto();
		}else{	
			$_SESSION['InsFichaAccionTempario'.$DatFichaIngresoModalidad->MinSigla.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsFichaAccionTempario'.$DatFichaIngresoModalidad->MinSigla.$Identificador]);
		}		

		if (!isset($_SESSION['InsFichaAccionProducto'.$DatFichaIngresoModalidad->MinSigla.$Identificador])){	
			$_SESSION['InsFichaAccionProducto'.$DatFichaIngresoModalidad->MinSigla.$Identificador] = new ClsSesionObjeto();
		}else{	
			$_SESSION['InsFichaAccionProducto'.$DatFichaIngresoModalidad->MinSigla.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsFichaAccionProducto'.$DatFichaIngresoModalidad->MinSigla.$Identificador]);
		}

		if (!isset($_SESSION['InsFichaAccionMantenimiento'.$DatFichaIngresoModalidad->MinSigla.$Identificador])){	
			$_SESSION['InsFichaAccionMantenimiento'.$DatFichaIngresoModalidad->MinSigla.$Identificador] = new ClsSesionObjeto();
		}else{	
			$_SESSION['InsFichaAccionMantenimiento'.$DatFichaIngresoModalidad->MinSigla.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsFichaAccionMantenimiento'.$DatFichaIngresoModalidad->MinSigla.$Identificador]);
		}
		
		if (!isset($_SESSION['InsFichaAccionSuministro'.$DatFichaIngresoModalidad->MinSigla.$Identificador])){	
			$_SESSION['InsFichaAccionSuministro'.$DatFichaIngresoModalidad->MinSigla.$Identificador] = new ClsSesionObjeto();
		}else{	
			$_SESSION['InsFichaAccionSuministro'.$DatFichaIngresoModalidad->MinSigla.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsFichaAccionSuministro'.$DatFichaIngresoModalidad->MinSigla.$Identificador]);
		}
		
		if (!isset($_SESSION['InsFichaAccionFoto'.$DatFichaIngresoModalidad->MinSigla.$Identificador])){	
			$_SESSION['InsFichaAccionFoto'.$DatFichaIngresoModalidad->MinSigla.$Identificador] = new ClsSesionObjeto();
		}else{	
			$_SESSION['InsFichaAccionFoto'.$DatFichaIngresoModalidad->MinSigla.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsFichaAccionFoto'.$DatFichaIngresoModalidad->MinSigla.$Identificador]);
		}

	}
}

if (!isset($_SESSION['InsFichaAccionHerramienta'.$Identificador])){	
	$_SESSION['InsFichaAccionHerramienta'.$Identificador] = new ClsSesionObjeto();
}else{	
	$_SESSION['InsFichaAccionHerramienta'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsFichaAccionHerramienta'.$Identificador]);
}


$RepPlanMantenimientoSeccion = $InsPlanMantenimientoSeccion->MtdObtenerPlanMantenimientoSecciones(NULL,NULL,"PmsId","ASC",NULL);
$ArrPlanMantenimientoSecciones = $RepPlanMantenimientoSeccion['Datos'];

if($InsFichaIngreso->FinEstado==2  or $InsFichaIngreso->FinEstado==3  or $InsFichaIngreso->FinEstado==4  or $InsFichaIngreso->FinEstado==5 or $InsFichaIngreso->FinEstado==6 or $InsFichaIngreso->FinEstado == 72 or $InsFichaIngreso->FinEstado == 7 or $InsFichaIngreso->FinEstado == 71 or $InsFichaIngreso->FinEstado == 73 or $InsFichaIngreso->FinEstado == 74 or $InsFichaIngreso->FinEstado == 75  or $InsFichaIngreso->FinEstado == 9){
	
	include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccPDIFichaAccionTrabajar.php');
	
}

$ResModalidadIngreso = $InsModalidadIngreso->MtdObtenerModalidadIngresos(NULL,NULL,'MinId','ASC',NULL,"1,3");
$ArrModalidadIngresos = $ResModalidadIngreso['Datos'];

$RepTipoDocumento = $InsTipoDocumento->MtdObtenerTipoDocumentos(NULL,NULL,"TdoId","ASC",NULL);
$ArrTipoDocumentos = $RepTipoDocumento['Datos'];

$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","ASC",NULL);
$ArrMonedas = $ResMoneda['Datos'];


?>

<?php
//deb($InsFichaIngreso->FinEstado);
?>

<?php
/*
case 1:		$Estado = "RECEPCION [Pendiente]";
case 11:	$Estado = "RECEPCION [Enviado]";
case 2:		$Estado = "TALLER [Revisando]";
case 3:		$Estado = "TALLER [Preparando Pedido]";
case 4:		$Estado = "TALLER [Pedido Enviado]";
case 5:		$Estado = "ALMACEN [Revisado Pedido]";
case 6:		$Estado = "ALMACEN [Preparando Pedido]";
case 7:		$Estado = "ALMACEN [Pedido Enviado]";
case 71:	$Estado = "TALLER [Pedido Recibido]";
case 72:	$Estado = "ALMACEN [Pedido Extornado]";

case 73:$Estado = "TALLER [Trabajo Terminado]";
case 74:$Estado = "RECEPCION [Revisando]";

case 75:$Estado = "RECEPCION [Conforme/Por Facturar]";
case 8:	$Estado = "TALLER [Por Facturar]";
case 9:	$Estado = "CONTABILIDAD [Facturado]";						
*/


if($InsFichaIngreso->FinEstado==2  or $InsFichaIngreso->FinEstado==3  or $InsFichaIngreso->FinEstado==4  or $InsFichaIngreso->FinEstado==5 or $InsFichaIngreso->FinEstado==6 or $InsFichaIngreso->FinEstado == 72 or $InsFichaIngreso->FinEstado == 7 or $InsFichaIngreso->FinEstado == 71 or $InsFichaIngreso->FinEstado == 73 or $InsFichaIngreso->FinEstado == 74 or $InsFichaIngreso->FinEstado == 75  or $InsFichaIngreso->FinEstado == 9){
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

	FncFichaAccionHerramientaListar();

	$('input[type=checkbox]').each(function () {
		if($(this).attr('etiqueta')=="modalidad"){
			
			FncFichaAccionFotoListar($(this).attr('sigla'));
			
			FncFichaAccionTareaListar($(this).attr('sigla'));
			FncFichaAccionTareaListar2($(this).attr('sigla'));
			
			FncFichaAccionTemparioListar($(this).attr('sigla'));
			
			FncFichaAccionProductoListar($(this).attr('sigla'));
			FncFichaAccionProductoListar2($(this).attr('sigla'));
			
			FncFichaAccionSuministroListar($(this).attr('sigla'));
			FncFichaAccionSuministroListar2($(this).attr('sigla'));
			
			FncFichaAccionMantenimientoListar($(this).attr('sigla'));
			
		}			 
	});


	FncFichaAccionHistorialListar();
	
	FncFichaAccionFotoVINListar();
	FncFichaAccionFotoDelanteraListar();
	FncFichaAccionFotoCuponListar();
	FncFichaAccionFotoMantenimientoListar();
	
	FncPreEntregaPDSDetalleListar();
	
});

/*
Configuracion Formulario
*/

var Formulario = "FrmEditar";

var FichaAccionTareaEditar = 1;
var FichaAccionTareaEliminar = 1;

var FichaAccionFotoEditar = 1;
var FichaAccionFotoEliminar = 1;

var FichaAccionTemparioEditar = 1;
var FichaAccionTemparioEliminar = 1;

var FichaAccionProductoEditar = 2;
var FichaAccionProductoEliminar = 2;

var FichaAccionSuministroEditar = 2;
var FichaAccionSuministroEliminar = 2;

var FichaAccionMantenimientoEditar = 2;
var FichaAccionMantenimientoEliminar = 2;

var FichaAccionHerramientaEditar = 2;
var FichaAccionHerramientaEliminar = 2;

var FichaAccionRecibirMantenimientoEditar = 1;

var PreEntregaDetalleEditar = 2;
var PreEntregaDetalleEliminar = 2; 


var FichaAccionFotoVINEliminar = 1;
var FichaAccionFotoDelanteraEliminar = 1;
var FichaAccionFotoCuponEliminar = 1;
var FichaAccionFotoMantenimientoEliminar = 1;

</script>

<form id="FrmEditar" name="FrmEditar" method="post" action="#" enctype="multipart/form-data" onsubmit="FncGuardar();" >

<div class="EstCapSubMenu">

           
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
}
?>            

</div>

<div class="EstCapContenido">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
      
      <tr>
        <td width="1922" height="25" colspan="2"><span class="EstFormularioTitulo">EDITAR  ORDEN DE TRABAJO *</span></td>
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
      <td colspan="5" align="left" valign="top"><input name="CmpFichaIngresoCliente" type="text" class="EstFormularioCaja" id="CmpFichaIngresoCliente" value="<?php echo $InsFichaIngreso->CliNombre;?> <?php echo $InsFichaIngreso->CliApellidoPaterno;?> <?php echo $InsFichaIngreso->CliApellidoMaterno;?>" size="45" readonly="readonly" /></td>
      <td align="left" valign="top"><input type="hidden" name="Guardar" id="Guardar"   />
        <input type="hidden" name="Identificador" id="Identificador"  value="<?php echo $Identificador; ?>" />
        <input name="CmpFichaIngresoVehiculoVersion" type="hidden" class="EstFormularioCaja" id="CmpFichaIngresoVehiculoVersion" value="<?php echo $InsFichaIngreso->VveId;?>"  /><!-- REVISAR -->
        <!--<input name="CmpFichaIngresoMantenimientoKilometraje" type="hidden" class="EstFormularioCaja" id="CmpFichaIngresoMantenimientoKilometraje" value="<?php echo $InsFichaIngreso->FinMantenimientoKilometraje;?>"  />-->
        <input name="CmpFichaIngresoEstado" type="hidden" class="EstFormularioCaja" id="CmpFichaIngresoEstado" value="<?php echo $InsFichaIngreso->FinEstado;?>"  />
        <input name="CmpVehiculoIngresoMarcaId" type="hidden" class="EstFormularioCaja" id="CmpVehiculoIngresoMarcaId" value="<?php echo $InsFichaIngreso->VmaId;?>"  />
        <input name="CmpVehiculoIngresoModeloId" type="hidden" class="EstFormularioCaja" id="CmpVehiculoIngresoModeloId" value="<?php echo $InsFichaIngreso->VmoId;?>"  />
        <input name="CmpVehiculoIngresoVersionId" type="hidden" class="EstFormularioCaja" id="CmpVehiculoIngresoVersionId" value="<?php echo $InsFichaIngreso->VveId;?>"  />
        <input name="CmpVehiculoIngresoAnoFabricacion" type="hidden" class="EstFormularioCaja" id="CmpVehiculoIngresoAnoFabricacion" value="<?php echo $InsFichaIngreso->EinAnoFabricacion;?>"  />
        


         
<input name="CmpFichaIngresoTipo" type="hidden" class="EstFormularioCaja" id="CmpFichaIngresoTipo" value="<?php echo $InsFichaIngreso->FinTipo;?>"  />


         
         
        </td>
    </tr>

    
    <tr>
      <td align="left" valign="top"> Placa </td>
      <td align="left" valign="top"><input name="CmpFichaIngresoPlaca" type="text" class="EstFormularioCaja" id="CmpFichaIngresoPlaca" value="<?php echo $InsFichaIngreso->EinPlaca;?>" size="15" readonly="readonly" /></td>
      <td align="left" valign="top">VIN:</td>
      <td align="left" valign="top"><input name="CmpFichaIngresoVIN" type="text" class="EstFormularioCaja" id="CmpFichaIngresoVIN" value="<?php echo $InsFichaIngreso->EinVIN;?>" size="15" readonly="readonly" /></td>
      <td align="left" valign="top">Marca:</td>
      <td align="left" valign="top"><input name="CmpFichaIngresoMarca" type="text" class="EstFormularioCaja" id="CmpFichaIngresoMarca" value="<?php echo $InsFichaIngreso->VmaNombre;?>" size="15" readonly="readonly" /></td>
      <td align="left" valign="top">Modelo:</td>
      <td align="left" valign="top"><input name="CmpFichaIngresoModelo" type="text" class="EstFormularioCaja" id="CmpFichaIngresoModelo" value="<?php echo $InsFichaIngreso->VmoNombre;?>" size="15" readonly="readonly" /></td>
      <td align="left" valign="top">Version:</td>
      <td align="left" valign="top"><input name="CmpFichaIngresoVersion" type="text" class="EstFormularioCaja" id="CmpFichaIngresoVersion" value="<?php echo $InsFichaIngreso->VveNombre;?>" size="15" readonly="readonly" /></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    
    
    
    <tr>
      <td align="left" valign="top">Moneda:</td>
      <td align="left" valign="top"><select  class="EstFormularioCombo" name="CmpMonedaId" id="CmpMonedaId" disabled="disabled" >
        <option value="">Escoja una opcion</option>
        <?php
foreach($ArrMonedas as $DatMoneda){
?>
        <option value="<?php echo $DatMoneda->MonId?>" <?php if($InsFichaIngreso->MonId==$DatMoneda->MonId){ echo 'selected="selected"';}?> ><?php echo $DatMoneda->MonNombre?> ( <?php echo $DatMoneda->MonSimbolo;?>)</option>
        <?php
}
?>
        </select></td>
      <td align="left" valign="top">Tipo Cambio:</td>
      <td align="left" valign="top"><input name="CmpTipoCambio" type="text" class="EstFormularioCaja" id="CmpTipoCambio" value="<?php echo $InsFichaIngreso->FinTipoCambio;?>" size="10" maxlength="10" readonly="readonly"  /></td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    
        <tr>
          <td colspan="11" align="left" valign="top">
            
            
            
            
            
            
            
            </td>
        </tr>
        <tr>
      <td colspan="11" align="center" valign="top">
      
      <?php

	foreach($InsFichaIngreso->FichaIngresoModalidad as $DatFichaIngresoModalidad){
		//foreach($ArrModalidadIngresos as $DatModalidadIngreso){
		?>
        <?php
			//$aux = '';
//            if(!empty($InsFichaIngreso->FichaIngresoModalidad)){	
//                foreach($InsFichaIngreso->FichaIngresoModalidad as $DatFichaIngresoModalidad ){
//                    if($DatFichaIngresoModalidad->MinId==$DatModalidadIngreso->MinId){
//                        $aux = 'checked="checked"';						
//                        break;
//                    }					
//                }
//            }				
            ?>
        <input style="visibility:hidden;" etiqueta="modalidad" checked="checked"   type="checkbox" value="<?php echo $DatFichaIngresoModalidad->MinId?>" name="CmpModalidadId_<?php echo $DatFichaIngresoModalidad->MinSigla?>" id="CmpModalidadId_<?php echo $DatFichaIngresoModalidad->MinSigla?>" sigla="<?php echo $DatFichaIngresoModalidad->MinSigla;?>" />
        <?php //echo $DatFichaIngresoModalidad->MinNombre?> 
        <?php	
		}
		?>
        
      </td>
      </tr>
  </table>
</div>  
<br />


<?php
//deb($ArrFichaAccion);
?>
          
<ul class="tabs">

	<?php
	/*$c=2;
	//foreach($InsFichaIngreso->FichaIngresoModalidad as $DatFichaAccion){
	foreach($ArrFichaAccion as $DatFichaAccion){
    ?>
		<li><a href="#tab<?php echo $c;?>"><?php echo $DatFichaAccion->MinNombre;?></a></li>
	<?php
	$c++;
    }*/
    ?>
    
    
	<?php
	$c=2;
	foreach($InsFichaIngreso->FichaIngresoModalidad as $DatFichaIngresoModalidad){
	//foreach($ArrModalidadIngresos  as $DatFichaIngresoModalidad){
    ?>
    
    	<?php
		if($DatFichaIngresoModalidad->MinSigla == "PP"){
		?>
			<li><a id="TabModalidad<?php echo $DatFichaIngresoModalidad->MinSigla;;?>" href="#tab<?php echo $c;?>"><?php echo $DatFichaIngresoModalidad->MinNombre;?></a></li>
        <?php
		}
		?>

        
        
	<?php
	$c++;
    }
    ?>
    
	<li><a href="#tab1">Herramientas</a></li>
	<li><a href="#tab<?php echo $c;?>">Observaciones</a></li>
	<li><a href="#tab<?php echo $c+1;?>">Historial</a></li>
	<li><a href="#tab<?php echo $c+2;?>">Fotos GM</a></li>

	<?php
	if($InsFichaIngreso->FinTipo == 2){
	?>
	<li><a href="#tab<?php echo $c+3;?>">Formato PDS</a></li>
	<?php
    }
    ?>
    
    <li><a href="#tab<?php echo $c+4;?>">Observacion Almacen</a></li>
    
    
</ul>
	
<div class="tab_container">


  
		
	
	<?php
	$c=2;
	//foreach($ArrModalidadIngresos  as $DatFichaIngresoModalidad){
	foreach($InsFichaIngreso->FichaIngresoModalidad as $DatFichaIngresoModalidad){
		
?>
		<?php
		if($DatFichaIngresoModalidad->MinSigla == "PP"){
		?>
<?php
			
			$FichaAccionId = '';
			$FichaAccionFecha = date("d/m/Y");
			$FichaAccionObservacion = '';
			$FichaAccionCausa = '';
			$FichaAccionPedido = '';
			$FichaAccionSolucion = '';
			$FichaIngresoModalidadId = '';
			$FichaIngresoModalidadObsequio = 2;
			
			$FichaAccionSalidaTaller = array();

            if(!empty($ArrFichaAccion)){	
                foreach($ArrFichaAccion as $DatFichaAccion ){
					
                    if($DatFichaIngresoModalidad->MinId==$DatFichaAccion->MinId){

						$FichaAccionId = $DatFichaAccion->FccId;
						$FichaAccionFecha = $DatFichaAccion->FccFecha;
						$FichaAccionObservacion = $DatFichaAccion->FccObservacion;
						$FichaAccionCausa = $DatFichaAccion->FccCausa;
						$FichaAccionPedido = $DatFichaAccion->FccPedido;
						$FichaAccionSolucion = $DatFichaAccion->FccSolucion;
						
						$FichaAccionComprobanteNumero = $DatFichaAccion->FccComprobanteNumero;
						$FichaAccionComprobanteFecha = $DatFichaAccion->FccComprobanteFecha;
						
						$FichaIngresoModalidadId = $DatFichaAccion->FimId;
						$FichaIngresoModalidadObsequio = $DatFichaAccion->FimObsequio;		
						
						$FichaAccionSalidaExterna = $DatFichaAccion->FichaAccionSalidaExterna;			  
                        break;
                    }					
                }
            }	
			
			
	?>
    


	<?php
//	$c=2;
	
	//foreach($ArrFichaAccion as $DatFichaAccion){
		
	
	?>

	<div id="tab<?php echo $c;?>" class="tab_content">
 	
    
    	<div class="EstFormularioArea" id="CapModalidad<?php echo $DatFichaIngresoModalidad->MinSigla;?>">
 
                    <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                    <tr>
                      <td colspan="4">
                      
                      <div class="EstFormularioArea">
                        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                          <tr>
                            <td>&nbsp;</td>
                            <td colspan="2"><span class="EstFormularioSubTitulo">Datos de la  MODALIDAD de ORDEN DE TRABAJO: <?php echo strtoupper($DatFichaIngresoModalidad->MinNombre);?>
                              
                            </span></td>
                            <td>&nbsp;</td>
                          </tr>
                          <tr>
                            <td>&nbsp;</td>
                            <td align="left" valign="top">

<!--<input style="visibility:hidden;" etiqueta="modalidad" checked="checked"  type="checkbox" value="<?php echo $DatFichaAccion->MinId?>" name="CmpModalidadId_<?php echo $DatFichaAccion->MinSigla?>" id="CmpModalidadId_<?php echo $DatFichaAccion->MinSigla?>" sigla="<?php echo $DatFichaAccion->MinSigla?>" />-->
							
                            </td>
                            <td align="left" valign="top">
                            
                            <input name="CmpId_<?php echo $DatFichaIngresoModalidad->MinSigla?>" type="hidden" class="EstFormularioCaja" id="CmpId_<?php echo $DatFichaIngresoModalidad->MinSigla?>" value="<?php echo $FichaAccionId;?>" size="15" maxlength="20" readonly="readonly" />
                              <input name="CmpFecha_<?php echo $DatFichaIngresoModalidad->MinSigla?>" type="hidden" id="CmpFecha_<?php echo $DatFichaIngresoModalidad->MinSigla?>" value="<?php echo $FichaAccionFecha;?>" />
                              <input name="CmpObservacion_<?php echo $DatFichaIngresoModalidad->MinSigla?>" type="hidden" id="CmpObservacion_<?php echo $DatFichaIngresoModalidad->MinSigla?>" value="<?php echo $FichaAccionObservacion;?>" />
                              <input name="CmpModalidadIngresoSigla_<?php echo $DatFichaIngresoModalidad->MinSigla?>" type="hidden" id="CmpModalidadIngresoSigla_<?php echo $DatFichaIngresoModalidad->MinSigla?>" value="<?php echo $DatFichaIngresoModalidad->MinSigla?>" />
                              <input name="CmpModalidadIngresoNombre_<?php echo $DatFichaIngresoModalidad->MinSigla?>" type="hidden" id="CmpModalidadIngresoNombre_<?php echo $DatFichaIngresoModalidad->MinSigla?>" value="<?php echo $DatFichaIngresoModalidad->MinNombre;?>" />
                              <input name="CmpModalidadIngresoId_<?php echo $DatFichaIngresoModalidad->MinSigla?>" type="hidden" id="CmpModalidadIngresoId_<?php echo $DatFichaIngresoModalidad->MinSigla?>" value="<?php echo $DatFichaIngresoModalidad->MinId;?>" />
                            <input name="CmpFichaIngresoModalidadId_<?php echo $DatFichaIngresoModalidad->MinSigla?>" type="hidden" class="EstFormularioCaja" id="CmpFichaIngresoModalidadId_<?php echo $DatFichaIngresoModalidad->MinSigla?>" value="<?php echo $FichaIngresoModalidadId;?>" size="15" maxlength="20" readonly="readonly" />
                            
                            <span style="color:#F5F5F5">(<?php echo $FichaAccionId;?>) / (<?php echo $FichaIngresoModalidadId;?>) / (<?php echo $FichaAccionFecha;?>) </span>
                            </td>
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                        </table>

                      </div>
                      
                      </td>
                    </tr>
                    <tr>
                      <td colspan="4">
                      
	   <?php
     switch($DatFichaIngresoModalidad->MinSigla){
         
        case "PP":
        ?>
        
     <div class="EstFormularioArea" >
        <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
          

          
          
          <tr>
            <td align="center"><span class="EstFormularioSubTitulo">Tareas y Productos: <?php echo strtoupper($DatFichaIngresoModalidad->MinNombre);?></span></td>
          </tr>
          <tr>
            <td align="left" valign="top"><div class="EstFormularioArea">
              <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                <tr>
                  <td width="4" align="left" valign="top">&nbsp;</td>
                  <td colspan="4" align="left" valign="top"><span class="EstFormularioSubTitulo">TAREAS</span>
                    <input type="hidden" name="Cmp<?php echo $DatFichaIngresoModalidad->MinSigla?>TareaItem" id="Cmp<?php echo $DatFichaIngresoModalidad->MinSigla?>TareaItem" />
                    <input type="hidden" name="Cmp<?php echo $DatFichaIngresoModalidad->MinSigla?>TareaId" id="Cmp<?php echo $DatFichaIngresoModalidad->MinSigla?>TareaId" /></td>
                  <td align="left" valign="top">&nbsp;</td>
                  <td align="left" valign="top">&nbsp;</td>
                  <td align="left" valign="top">&nbsp;</td>
                  <td align="left" valign="top">&nbsp;</td>
                  <td align="left" valign="top">&nbsp;</td>
                  </tr>
                <tr>
                  <td align="left" valign="top">&nbsp;</td>
                  <td width="20" align="left" valign="top"><a href="javascript:FncFichaAccionTareaEliminarTodo('<?php echo $DatFichaIngresoModalidad->MinSigla?>');">
                    <input type="hidden" name="CmpFichaAccion<?php echo $DatFichaIngresoModalidad->MinSigla?>TareaAccion" id="CmpFichaAccion<?php echo $DatFichaIngresoModalidad->MinSigla?>TareaAccion" value="AccPDIFichaAccionTareaRegistrar.php" />
                    </a></td>
                  <td width="97" align="left" valign="top">Descripcion: </td>
                  <td width="98" align="right" valign="top">&nbsp;</td>
                  <td width="109" align="right" valign="top"></td>
                  <td align="left" valign="top">Actividad:</td>
                  <td align="left" valign="top">Especificacion:</td>
                  <td align="left" valign="top">Costo:</td>
                  <td align="left" valign="top">&nbsp;</td>
                  <td width="21" align="left" valign="top">&nbsp;</td>
                  </tr>
                <tr>
                  <td align="left" valign="top">&nbsp;</td>
                  <td align="left" valign="top"><a href="javascript:FncFichaAccionTareaNuevo('<?php echo $DatFichaIngresoModalidad->MinSigla?>');"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                  <td colspan="3" align="left" valign="top"><textarea name="Cmp<?php echo $DatFichaIngresoModalidad->MinSigla?>TareaDescripcion" cols="50" class="EstFormularioCaja" id="Cmp<?php echo $DatFichaIngresoModalidad->MinSigla?>TareaDescripcion"></textarea></td>
                  <td align="left" valign="top"><select class="EstFormularioCombo" name="Cmp<?php echo $DatFichaIngresoModalidad->MinSigla?>TareaAccion" id="Cmp<?php echo $DatFichaIngresoModalidad->MinSigla?>TareaAccion">
                    <option value="L">Planchado</option>
                    <option value="N">Pintado</option>
                    <option value="E">Centrado</option>
                  </select></td>
                  <td align="left" valign="top"><input name="Cmp<?php echo $DatFichaIngresoModalidad->MinSigla?>TareaEspecificacion" type="text" class="EstFormularioCaja" id="Cmp<?php echo $DatFichaIngresoModalidad->MinSigla?>TareaEspecificacion" size="20" maxlength="20" /></td>
                  <td align="left" valign="top"><input name="Cmp<?php echo $DatFichaIngresoModalidad->MinSigla?>TareaCosto" type="text" class="EstFormularioCaja" id="Cmp<?php echo $DatFichaIngresoModalidad->MinSigla?>TareaCosto" size="10" maxlength="10" /></td>
                  <td align="left" valign="top"></td>
                  <td align="left" valign="top"><a href="javascript:FncFichaAccionTareaGuardar('<?php echo $DatFichaIngresoModalidad->MinSigla?>');"><img src="imagenes/acciones/guardar.png" width="25" height="25" border="0" title="Guardar" alt="[Guardar]" align="absmiddle" /></a></td>
                  </tr>
                </table>
            </div></td>
          </tr>
          <tr>
            <td align="left" valign="top"><div class="EstFormularioArea" >
              <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                <tr>
                  <td width="1%" align="left" valign="top">&nbsp;</td>
                  <td colspan="2" align="left" valign="top">TAREAS asignadas en la Orden de Trabajo</td>
                  <td width="1%" align="left" valign="top">&nbsp;</td>
                </tr>
                <tr>
                  <td align="left" valign="top">&nbsp;</td>
                  <td width="50%" align="left" valign="top">  <div class="EstFormularioAccion" id="Cap<?php echo $DatFichaIngresoModalidad->MinSigla?>TareaAccion">
                    
                    
                    
                    Listo
                    para registrar elementos</div></td>
                  <td width="48%" align="right" valign="top"><a href="javascript:FncFichaAccionTareaListar('<?php echo $DatFichaIngresoModalidad->MinSigla?>');"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a> <a href="javascript:FncFichaAccionTareaEliminarTodo('<?php echo $DatFichaIngresoModalidad->MinSigla?>');"><img  src="imagenes/acciones/listado_eliminar_todo.png"  width="25" height="25"  border="0" title="Eliminar Todo"   alt="[Eli. Todo.]" align="absmiddle"/> Eliminar Todo</a></td>
                  <td align="left" valign="top"><div id="CapFichaAccionTareasResultado"> </div></td>
                </tr>
                <tr>
                  <td align="left" valign="top">&nbsp;</td>
                  <td colspan="2" align="left" valign="top"><div id="CapFichaAccion<?php echo $DatFichaIngresoModalidad->MinSigla?>Tareas" class="EstCapFichaAccionTareas2" > </div></td>
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
            <td align="left" valign="top">
            
            
            <div class="EstFormularioArea">
              <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                <tr>
                  <td width="4" align="left" valign="top">&nbsp;</td>
                  <td width="344" align="left" valign="top"><span class="EstFormularioSubTitulo">PRODUCTOS</span></td>
                  <td width="5" align="left" valign="top">&nbsp;</td>
                  </tr>
                </table>
            </div>
            
            </td>
          </tr>
          <tr>
            <td align="left" valign="top"><div class="EstFormularioArea" >
              <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                  <tr>
                    <td width="1%">&nbsp;</td>
                    <td colspan="2">PRODUCTOS asignados en la Orden de Trabajo</td>
                    <td width="1%">&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td width="51%"><div class="EstFormularioAccion" id="Cap<?php echo $DatFichaIngresoModalidad->MinSigla?>ProductoAccion">Listo
                    para registrar elementos </div></td>
                    <td width="47%" align="right"><a href="javascript:FncFichaAccionProductoListar('<?php echo $DatFichaIngresoModalidad->MinSigla?>');"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a> <a href="javascript:FncFichaAccionProductoEliminarTodo('<?php echo $DatFichaIngresoModalidad->MinSigla?>');"><img  src="imagenes/acciones/listado_eliminar_todo.png"  width="25" height="25"  border="0" title="Eliminar Todo"   alt="[Eli. Todo.]" align="absmiddle"/> Eliminar Todo</a></td>
                    <td><div id="CapFichaAccion<?php echo $DatFichaIngresoModalidad->MinSigla?>ProductosResultado"> </div></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="2"><div id="CapFichaAccion<?php echo $DatFichaIngresoModalidad->MinSigla?>Productos2" class="EstCapFichaAccionProductos2" > </div></td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="2"><div id="CapFichaAccion<?php echo $DatFichaIngresoModalidad->MinSigla?>Productos" class="EstCapFichaAccionProductos2" ></div></td>
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
            <td align="left" valign="top">
            
            
             <div class="EstFormularioArea" >
            
            
                    <?php
        
        if(!empty($FichaAccionSalidaExterna)){
            
            $FichaAccionSalidaExternaId = "";
            $FichaAccionSalidaExternaProveedorId = "";
            $FichaAccionSalidaExternaProveedorNombre = "";
            $FichaAccionSalidaExternaProveedorTipoDocumentoId = "";
            $FichaAccionSalidaExternaFechaSalida = "";
            $FichaAccionSalidaExternaFechaFinalizacion = "";
            
            foreach($FichaAccionSalidaExterna as $DatFichaAccionSalidaExterna){
                
                $FichaAccionSalidaExternaId = $DatFichaAccionSalidaExterna->FsxId;
                $FichaAccionSalidaExternaProveedorId = $DatFichaAccionSalidaExterna->PrvId;
                $FichaAccionSalidaExternaProveedorNombreCompleto = $DatFichaAccionSalidaExterna->PrvNombreCompleto;
                $FichaAccionSalidaExternaProveedorNumeroDocumento = $DatFichaAccionSalidaExterna->PrvNumeroDocumento;
                $FichaAccionSalidaExternaProveedorTipoDocumentoId = $DatFichaAccionSalidaExterna->TdoId;
                $FichaAccionSalidaExternaFechaSalida = $DatFichaAccionSalidaExterna->FsxFechaSalida;
                $FichaAccionSalidaExternaFechaFinalizacion = $DatFichaAccionSalidaExterna->FsxFechaFinalizacion;
                
            }
        }
        
        ?>
                    
        <table border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                      <tr>
                        <td>&nbsp;</td>
                        <td colspan="2"><span class="EstFormularioSubTitulo">Envio a Taller Externo</span></td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td align="left" valign="top">&nbsp;</td>
                        <td align="left" valign="top">&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td align="left" valign="top">Proveedor: <input name="CmpFichaAccionSalidaExternaId" type="hidden" id="CmpFichaAccionSalidaExternaId" value="<?php echo $FichaAccionSalidaExternaId;?>" size="3" /></td>
                        <td align="left" valign="top">
                        <table>
                          <tr>
                            <td><a href="javascript:FncProveedorNuevo();"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                            <td><span id="sprytextfield5">
                              <label>
                                <input <?php if(!empty($FichaAccionSalidaExternaProveedorId)){ echo 'readonly="readonly"';} ?> class="EstFormularioCaja" name="CmpProveedorNombre" type="text" id="CmpProveedorNombre" value="<?php echo $FichaAccionSalidaExternaProveedorNombreCompleto;?>" size="45" maxlength="255"  />
                            </label>
                              <span class="textfieldRequiredMsg">Se necesita un valor.</span></span> <a href="comunes/Proveedor/FrmProveedorBuscar.php?height=440&amp;width=850" class="thickbox" title=""><img src="imagenes/acciones/buscador.png" width="25" height="25" border="0" align="absmiddle" ></a></td>
                            <td><a id="BtnProveedorRegistrar" onclick="FncProveedorCargarFormulario('Registrar');"  href="javascript:void(0)" title=""> <img src="imagenes/acciones/registrar.png" alt="[Registrar]" width="25" height="25" border="0" align="absmiddle" title="Registrar" /></a> <a id="BtnProveedorEditar" onclick="FncProveedorCargarFormulario('Editar');" href="javascript:void(0)"   title=""> <img src="imagenes/acciones/editar.png" alt="[Editar]" width="25" height="25" border="0" align="absmiddle" title="Editar" /></a></td>
                          </tr>
                          </table>
                        </td>
                        <td align="left" valign="top">Tipo Doc.:
                          <input name="CmpProveedorId" type="hidden" id="CmpProveedorId" value="<?php echo $FichaAccionSalidaExternaProveedorId;?>" size="3" /></td>
                        <td align="left" valign="top"><select <?php if(!empty($FichaAccionSalidaExternaProveedorId)){ echo 'disabled="disabled"';} ?>  class="EstFormularioCombo" name="CmpProveedorTipoDocumento" id="CmpProveedorTipoDocumento">
                          <option value="">Escoja una opcion</option>
                          <?php
foreach($ArrTipoDocumentos as $DatTipoDocumento){
?>
                          <option <?php echo $DatTipoDocumento->TdoId;?> <?php echo ($DatTipoDocumento->TdoId==$FichaAccionSalidaExternaProveedorTipoDocumentoId)?'selected="selected"':"";?> value="<?php echo $DatTipoDocumento->TdoId?>"><?php echo $DatTipoDocumento->TdoCodigo?> - <?php echo $DatTipoDocumento->TdoNombre?></option>
                          <?php
}
?>
                        </select></td>
                        <td>Num. Doc.:</td>
                        <td><table border="0" cellpadding="0" cellspacing="0">
                          <tr>
                            <td><a href="javascript:FncProveedorNuevo();"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                            <td><input <?php if(!empty($FichaAccionSalidaExternaProveedorId)){ echo 'readonly="readonly"';} ?> name="CmpProveedorNumeroDocumento" type="text" class="EstFormularioCaja" id="CmpProveedorNumeroDocumento"  value="<?php echo $FichaAccionSalidaExternaProveedorNumeroDocumento;?>" size="20" maxlength="50" /></td>
                            <td><a href="javascript:FncProveedorBuscar('NumeroDocumento');"><img src="imagenes/acciones/buscar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                            <td>&nbsp;</td>
                            <td><div id="CapProveedorBuscar"></div></td>
                          </tr>
                        </table></td>
                        <td>&nbsp;</td>
                        </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td align="left" valign="top">Fecha de Salida:<br />
                          <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
                        <td align="left" valign="top"><span id="sprytextfield7">
                          <label>
                            <input class="EstFormularioCajaFecha" name="CmpSalidaExternaFechaSalida" type="text" id="CmpSalidaExternaFechaSalida" value="<?php  echo $FichaAccionSalidaExternaFechaSalida; ?>" size="15" maxlength="10" />
                          </label>
                          <span class="textfieldInvalidFormatMsg"><img src="imagenes/advertencia.png" alt=""  border="0" align="absmiddle" title="Formato no valido"  /></span></span><img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnSalidaExternaFechaSalida" name="BtnSalidaExternaFechaSalida" width="25" height="25" align="absmiddle"  style="cursor:pointer;" /></td>
                        <td align="left" valign="top">Fecha de Finalizacion:<br />
                          <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
                        <td align="left" valign="top"><span id="sprytextfield7">
                          <label>
                            <input class="EstFormularioCajaFecha" name="CmpSalidaExternaFechaFinalizacion" type="text" id="CmpSalidaExternaFechaFinalizacion" value="<?php  echo $FichaAccionSalidaExternaFechaFinalizacion;?>" size="15" maxlength="10" />
                          </label>
                          <span class="textfieldInvalidFormatMsg"><img src="imagenes/advertencia.png" alt=""  border="0" align="absmiddle" title="Formato no valido"  /></span></span><img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnSalidaExternaFechaFinalizacion" name="BtnSalidaExternaFechaFinalizacion" width="25" height="25" align="absmiddle"  style="cursor:pointer;" /></td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td align="left" valign="top">Num. Comprobante:</td>
                        <td align="left" valign="top"><input name="CmpComprobanteNumero" type="text" class="EstFormularioCaja" id="CmpComprobanteNumero" size="20" maxlength="20" value="<?php echo $FichaAccionComprobanteNumero;?>" /></td>
                        <td>Fecha de Comprobante:<br />
                          <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
                        <td><span id="sprytextfield">
                          <label>
                            <input class="EstFormularioCajaFecha" name="CmpComprobanteFecha" type="text" id="CmpComprobanteFecha" value="<?php  echo $FichaAccionComprobanteFecha; ?>" size="15" maxlength="10" />
                          </label>
                          <span class="textfieldInvalidFormatMsg"><img src="imagenes/advertencia.png" alt=""  border="0" align="absmiddle" title="Formato no valido"  /></span></span><img src="imagenes/acciones/calendario.png" alt="[Calendario]"  id="BtnComprobanteFecha" name="BtnComprobanteFecha" width="25" height="25" align="absmiddle"  style="cursor:pointer;" /></td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td align="left" valign="top">&nbsp;</td>
                        <td align="left" valign="top">&nbsp;</td>
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
              <tr>
            <td align="left" valign="top">
            
            
<div class="EstFormularioArea" >
              <table border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                <tr>
                  <td align="left" valign="top">&nbsp;</td>
                  <td align="left" valign="top">
                    
                   
<span class="EstFormularioSubTitulo">Causas del Problema</span>
                    
                    
                  </td>
                  <td align="left" valign="top">&nbsp;</td>
                </tr>
                <tr>
                  <td align="left" valign="top">&nbsp;</td>
                  <td align="left" valign="top">
                  
                                          
                      <script type="text/javascript">


tinymce.init({
selector: "textarea#CmpFichaAccionCausa_<?php echo $DatFichaIngresoModalidad->MinSigla?>",
theme: "modern",
menubar : false,
toolbar1: "bold italic | bullist numlist",
width : 830,
height : 80
});

</script>


<textarea name="CmpFichaAccionCausa_<?php echo $DatFichaIngresoModalidad->MinSigla?>" cols="60" rows="2" class="EstFormularioCaja" id="CmpFichaAccionCausa_<?php echo $DatFichaIngresoModalidad->MinSigla?>"><?php echo stripslashes($FichaAccionCausa);?></textarea>





                  </td>
                  <td align="left" valign="top">&nbsp;</td>
                </tr>
                <tr>
                  <td align="left" valign="top">&nbsp;</td>
                  <td align="left" valign="top">
                  
                    
                   
                    
                    
                   </td>
                  <td align="left" valign="top">&nbsp;</td>
                </tr>
              </table>
            </div>
            
            </td>
          </tr>

          <tr>
            <td align="left" valign="top">
            


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
                  <td width="136" align="left" valign="top">&nbsp;</td>
                  <td width="139" align="right" valign="top"><a href="javascript:FncFichaAccionFotoListar('<?php echo $DatFichaIngresoModalidad->MinSigla?>');"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a></td>
                  <td align="left" valign="top">&nbsp;</td>
                </tr>
                <tr>
                  <td align="left" valign="top">&nbsp;</td>
                  <td align="left" valign="top">
<div id="fileuploader<?php echo $DatFichaIngresoModalidad->MinSigla?>">Escoger Archivos</div>


<script type="text/javascript">
$(document).ready(function()
{
$("#fileuploader<?php echo $DatFichaIngresoModalidad->MinSigla?>").uploadFile({

allowedTypes:"png,gif,jpg,jpeg",
url:"formularios/PDIFichaAccion/acc/AccPDIFichaAccionSubirFoto2.php",
formData: {"Identificador":"<?php echo $Identificador;?>","ModalidadIngreso":"<?php echo $DatFichaIngresoModalidad->MinSigla;?>"},
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
sizeErrorStr:"Tamaño no permitido",
uploadErrorStr:"No se pudo subir el archivo",

dragdropWidth: 400,

onSuccess:function(files,data,xhr){
FncFichaAccionFotoListar('<?php echo $DatFichaIngresoModalidad->MinSigla;?>');
}

});
});

</script>


                    
                  </td>
                  <td align="left" valign="top"><div class="EstCapFichaAccionFotos" id="CapFichaAccion<?php echo $DatFichaIngresoModalidad->MinSigla;?>Fotos"></div></td>
                  <td align="left" valign="top">&nbsp;</td>
                </tr>
                <tr>
                  <td align="left" valign="top">&nbsp;</td>
                  <td colspan="2" align="left" valign="top">
                    
                    <span class="EstFormularioNota">* Fotos del trabajo realizado </span>
                    
                  </td>
                  <td align="left" valign="top">&nbsp;</td>
                </tr>
              </table>
            </div>
            
            
            </td>
          </tr>
          <tr>
            <td align="left" valign="top">&nbsp;</td>
          </tr>
          
        </table>
     </div>
     
     
      <script type="text/javascript">


Calendar.setup({ 
inputField : "CmpSalidaExternaFechaSalida",  // id del campo de texto 
ifFormat   : "%d/%m/%Y",  //  
button     : "BtnSalidaExternaFechaSalida"// el id del botón que  
});

Calendar.setup({ 
inputField : "CmpSalidaExternaFechaFinalizacion",  // id del campo de texto 
ifFormat   : "%d/%m/%Y",  //  
button     : "BtnSalidaExternaFechaFinalizacion"// el id del botón que  
});	


Calendar.setup({ 
inputField : "CmpComprobanteFecha",  // id del campo de texto 
ifFormat   : "%d/%m/%Y",  //  
button     : "BtnComprobanteFecha"// el id del botón que  
});	

</script>
      
         <?php
         break;
         
     }
     ?> 
                     
					
                      
                      
                      
                      </td>
                    </tr>
                    </table>
           </div>            
	</div>
    	<?php
		}
		?>
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
                                  <td width="0%">&nbsp;</td>
                                  <td width="50%"><div class="EstFormularioAccion" id="CapHerramientaAccion">Listo
                                    para registrar elementos
                                      
                                  </div></td>
                                  <td width="49%" align="right"><a href="javascript:FncFichaAccionHerramientaListar();"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a></td>
                                  <td width="1%"><div id="CapFichaAccionHerramientasResultado"> </div></td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td colspan="2"><div id="CapFichaAccionHerramientas" class="EstCapFichaAccionHerramientas" ></div></td>
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

 
	<div id="tab<?php echo $c;?>" class="tab_content">
    
	    <div class="EstFormularioArea">

	  <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
	    <tr>
	      <td>&nbsp;</td>
	      <td colspan="2"><span class="EstFormularioSubTitulo">OBSERVACIONES </span></td>
	      <td>&nbsp;</td>
	      </tr>
	    <tr>
	      <td>&nbsp;</td>
	      <td align="left" valign="top">&nbsp;</td>
	      <td align="left" valign="top">&nbsp;</td>
	      <td align="left" valign="top">&nbsp;</td>
	      </tr>
	    <tr>
	      <td>&nbsp;</td>
	      <td align="left" valign="top">Observaciones:</td>
	      <td align="left" valign="top">
          
        


<div class="EstFormularioCajaObservacion">
        <?php echo stripslashes($InsFichaIngreso->FinSalidaObservacion);?>
        </div>
        
        
        
        
        
        </td>
	      <td align="left" valign="top">&nbsp;</td>
	      </tr>
	    <tr>
	      <td>&nbsp;</td>
	      <td align="left" valign="top">&nbsp;</td>
	      <td align="left" valign="top">&nbsp;</td>
	      <td align="left" valign="top">&nbsp;</td>
	      </tr>
	    </table>

        </div>
        
	</div>
    
    
                <div id="tab<?php echo $c+1;?>" class="tab_content">
    	<table width="100%" border="0" cellpadding="2" cellspacing="2">
            
            <tr>
              <td width="97%" valign="top">
                <div class="EstFormularioArea">
                  <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                    <tr>
                      <td><span class="EstFormularioSubTitulo">Historial</span></td>
                      </tr>
                    <tr>
                      <td><div class="EstFormularioArea" >
                        <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                          <tr>
                            <td width="3%">&nbsp;</td>
                            <td width="47%"><div class="EstFormularioAccion" id="CapFichaAccionHistorialAccion">Listo
                              para registrar elementos</div></td>
                            <td width="49%" align="right"><a href="javascript:FncFichaAccionHistorialListar();"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a></td>
                            <td width="1%"><div id="CapFichaAccionHistorialesResultado"> </div></td>
                            </tr>
                          <tr>
                            <td>&nbsp;</td>
                            <td colspan="2"><div id="CapFichaAccionHistoriales" class="EstCapFichaAccionHistoriales" > </div></td>
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
                </td>
            </tr>
            </table>    
    </div>
    
    
    
            <div id="tab<?php echo $c+2;?>" class="tab_content">
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
                                    
                                  <span class="EstFormularioSubTitulo">Fotos</span></td>
                                  <td width="4" align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td width="137" align="left" valign="top">&nbsp;</td>
                                  <td width="138" align="right" valign="top"><a href="javascript:FncFichaAccionFotoVINListar();"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a></td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td colspan="2" align="left" valign="top"><div class="EstCapFichaAccionFotoVINs" id="CapFichaAccionFotoVINs"></div></td>
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
                            
                            
                      <!--<div class="EstFormularioArea" >
                        <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                          <tr>
                            <td width="3%">&nbsp;</td>
                            <td width="96%" colspan="2"><iframe src="formularios/PDIFichaAccion/acc/AccPDIFichaAccionSubirFotoVIN.php?Identificador=<?php echo $Identificador;?>" id="IfrFichaAccionSubirFotoVin" name="IfrFichaAccionSubirFotoVin" scrolling="Auto"  frameborder="0" width="600" height="140"></iframe></td>
                            <td width="1%">&nbsp;</td>
                          </tr>
                          <tr>
                            <td>&nbsp;</td>
                            <td colspan="2">&nbsp;</td>
                            <td>&nbsp;</td>
                          </tr>
                        </table>
                      </div>--></td>
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
                                    
                                    <span class="EstFormularioSubTitulo">Fotos</span>
                                    
                                    <a href="javascript:FncFichaAccionFotoDelanteraListar();"></a>                                  </td>
                                  <td width="4" align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td width="138" align="left" valign="top">&nbsp;</td>
                                  <td width="137" align="right" valign="top"><a href="javascript:FncFichaAccionFotoDelanteraListar();"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a></td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td colspan="2" align="left" valign="top"><div class="EstCapFichaAccionFotoDelanteras" id="CapFichaAccionFotoDelanteras"></div></td>
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
                            
                            
                            
                      <!--<div class="EstFormularioArea" >
                        <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                          <tr>
                            <td width="3%">&nbsp;</td>
                            <td width="96%" colspan="2"><iframe src="formularios/PDIFichaAccion/acc/AccPDIFichaAccionSubirFotoDelantera.php?Identificador=<?php echo $Identificador;?>" id="IfrFichaAccionSubirFotoDelantera" name="IfrFichaAccionSubirFotoDelantera" scrolling="Auto"  frameborder="0" width="600" height="140"></iframe></td>
                            <td width="1%">&nbsp;</td>
                          </tr>
                          <tr>
                            <td>&nbsp;</td>
                            <td colspan="2">&nbsp;</td>
                            <td>&nbsp;</td>
                          </tr>
                        </table>
                      </div>-->
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
                            <td width="139" align="left" valign="top"><span class="EstFormularioSubTitulo">Fotos</span></td>
                            <td width="136" align="right" valign="top"><a href="javascript:FncFichaAccionFotoCuponListar();"></a></td>
                            <td width="4" align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr>
                            <td align="left" valign="top">&nbsp;</td>
                            <td align="left" valign="top">&nbsp;</td>
                            <td align="right" valign="top"><a href="javascript:FncFichaAccionFotoCuponListar();"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a></td>
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr>
                            <td align="left" valign="top">&nbsp;</td>
                            <td colspan="2" align="left" valign="top"><div class="EstCapFichaAccionFotoCupones" id="CapFichaAccionFotoCupones"></div></td>
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
                      <td>Foto Mantenimiento</td>
                    </tr>
                    <tr>
                      <td><div class="EstFormularioArea" >
                        <table border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                          <tr>
                            <td width="4" align="left" valign="top">&nbsp;</td>
                            <td width="139" align="left" valign="top"><span class="EstFormularioSubTitulo">Fotos</span></td>
                            <td width="136" align="right" valign="top"><a href="javascript:FncFichaAccionFotoMantenimientoListar();"></a></td>
                            <td width="4" align="left" valign="top">&nbsp;</td>
                            </tr>
                          <tr>
                            <td align="left" valign="top">&nbsp;</td>
                            <td align="left" valign="top">&nbsp;</td>
                            <td align="right" valign="top"><a href="javascript:FncFichaAccionFotoMantenimientoListar();"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a></td>
                            <td align="left" valign="top">&nbsp;</td>
                            </tr>
                          <tr>
                            <td align="left" valign="top">&nbsp;</td>
                            <td colspan="2" align="left" valign="top"><div class="EstCapFichaAccionFotoMantenimientos" id="CapFichaAccionFotoMantenimientos"></div></td>
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
                  
                                  
                
<!--                <div class="EstFormularioArea">
                  <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                    <tr>
                      <td><span class="EstFormularioSubTitulo">Foto VIN</span></td>
                      </tr>
                    <tr>
                      <td><div class="EstFormularioArea" >
                        <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                          <tr>
                            <td width="3%">&nbsp;</td>
                            <td width="96%" colspan="2"><iframe src="formularios/PDIFichaAccion/acc/AccPDIFichaAccionSubirFotoVIN.php?Identificador=<?php echo $Identificador;?>" id="IfrFichaAccionSubirFotoVin" name="IfrFichaAccionSubirFotoVin" scrolling="Auto"  frameborder="0" width="600" height="140"></iframe></td>
                            <td width="1%">&nbsp;</td>
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
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td><span class="EstFormularioSubTitulo">Foto Frontal</span></td>
                    </tr>
                    <tr>
                      <td>
                      
                      <div class="EstFormularioArea" >
                        <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                          <tr>
                            <td width="3%">&nbsp;</td>
                            <td width="96%" colspan="2"><iframe src="formularios/PDIFichaAccion/acc/AccPDIFichaAccionSubirFotoDelantera.php?Identificador=<?php echo $Identificador;?>" id="IfrFichaAccionSubirFotoDelantera" name="IfrFichaAccionSubirFotoDelantera" scrolling="Auto"  frameborder="0" width="600" height="140"></iframe></td>
                            <td width="1%">&nbsp;</td>
                          </tr>
                          <tr>
                            <td>&nbsp;</td>
                            <td colspan="2">&nbsp;</td>
                            <td>&nbsp;</td>
                          </tr>
                        </table>
                      </div>
                      </td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      </tr>
                    </table>
                  
                  
                  
                  </div>  -->   
                  
                  
                </td>
            </tr>
            </table>    
    </div>
    
	<?php
	if($InsFichaIngreso->FinTipo == 2){
	?>
    
          <div id="tab<?php echo $c+3;?>" class="tab_content">
    	<table width="100%" border="0" cellpadding="2" cellspacing="2">
            
            <tr>
              <td width="97%" valign="top">
                <div class="EstFormularioArea">
                  
                  
                 
                  <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                    <tr>
                      <td><span class="EstFormularioSubTitulo">Formato PDS</span></td>
                      </tr>
                    <tr>
                      <td><div class="EstFormularioArea" >
                        <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                          <tr>
                            <td width="3%">&nbsp;</td>
                            <td width="47%"><div class="EstFormularioAccion" id="CapPreEntregaPDSDetallelAccion">Listo
                              para registrar elementos</div></td>
                            <td width="49%" align="right"><a href="javascript:FncPreEntregaPDSDetalleListar();"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a></td>
                            <td width="1%"><div id="CapPreEntregaPDSDetallesResultado"> </div></td>
                            </tr>
                          <tr>
                            <td>&nbsp;</td>
                            <td colspan="2"><div id="CapPreEntregaPDSDetalles" class="EstCapPreEntregaPDSDetalles" > </div></td>
                            <td>&nbsp;</td>
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
    <?php
	}
	?>
    
    
 
	<div id="tab<?php echo $c+4;?>" class="tab_content">
		 <div class="EstFormularioArea">
	  <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
	    <tr>
	      <td width="4">&nbsp;</td>
	      <td colspan="2"><span class="EstFormularioSubTitulo"> OBSERVACIONES ALMACEN</span></td>
	      <td width="4">&nbsp;</td>
	      </tr>
	    <tr>
	      <td>&nbsp;</td>
	      <td width="104" align="left" valign="top">&nbsp;</td>
	      <td width="196" align="left" valign="top">&nbsp;</td>
	      <td align="left" valign="top">&nbsp;</td>
	      </tr>
	    <tr>
	      <td>&nbsp;</td>
	      <td align="left" valign="top">Observaciones:</td>
	      <td align="left" valign="top">
          
        <div class="EstFormularioCajaObservacion">
        <?php echo stripslashes($InsFichaIngreso->FinAlmacenObservacion);?>
        </div>
          
        
         </td>
	      <td align="left" valign="top">&nbsp;</td>
	      </tr>
	    <tr>
	      <td>&nbsp;</td>
	      <td align="left" valign="top">&nbsp;</td>
	      <td align="left" valign="top">&nbsp;</td>
	      <td align="left" valign="top">&nbsp;</td>
	      </tr>
	    </table>
        
        </div>
        
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
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5");
var sprytextfield7 = new Spry.Widget.ValidationTextField("sprytextfield7", "date", {format:"dd/mm/yyyy", isRequired:false});
var sprytextfield7 = new Spry.Widget.ValidationTextField("sprytextfield7", "date", {format:"dd/mm/yyyy", isRequired:false});
var sprytextfield = new Spry.Widget.ValidationTextField("sprytextfield", "date", {format:"dd/mm/yyyy", isRequired:false});
</script>


<?php
}else{
	echo ERR_FCC_703;
}
?>


<?php

}else{
	echo ERR_GEN_101;
}

if(!$_SESSION['MysqlDeb']){
	$InsMensaje->MtdRedireccionar("principal.php?Mod=".$GET_mod."&Form=Listado",$Edito,1500);
}




?>