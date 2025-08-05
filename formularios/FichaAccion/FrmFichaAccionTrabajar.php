<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar")){
?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Proveedor');?>JsProveedorAutocompletar.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Proveedor');?>JsProveedorFunciones.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsFichaAccionFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsFichaAccionTareaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsFichaAccionFotoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsFichaAccionTemparioFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsFichaAccionProductoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsFichaAccionSuministroFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsFichaAccionMantenimientoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsFichaAccionHerramientaFunciones.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsFichaAccionHistorialFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsFichaAccionCotizacionesFunciones.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsFichaAccionFotoVINFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsFichaAccionFotoDelanteraFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsFichaAccionFotoCuponFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsFichaAccionFotoMantenimientoFunciones.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs("PreEntrega");?>JsPreEntregaPDSDetalleFunciones.js" ></script>



<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss("PreEntrega");?>CssPreEntrega.css');
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssFichaAccion.css');
@import url('<?php echo $InsProyecto->MtdFormulariosCss("PlanMantenimiento");?>CssPlanMantenimiento.css');
</style>

<?php
$GET_Id = $_GET['Id'];

$Edito = false;

if(!empty($_POST['Identificador'])){
	$Identificador = $_POST['Identificador'];
}
include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjFichaAccion.php');
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
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoFoto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoCodigoReemplazo.php');require_once($InsPoo->MtdPaqAlmacen().'ClsProductoVehiculoVersion.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoAno.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoFoto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsListaPrecio.php');
//require_once($InsPoo->MtdPaqAlmacen().'ClsProductoCosto.php');

require_once($InsPoo->MtdPaqLogistica().'ClsTipoDocumento.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngreso.php');

require_once($InsPoo->MtdPaqActividad().'ClsPreEntregaDetalle.php');
require_once($InsPoo->MtdPaqActividad().'ClsPreEntregaSeccion.php');
require_once($InsPoo->MtdPaqActividad().'ClsPreEntregaTarea.php');

require_once($InsPoo->MtdPaqRRHH().'ClsPersonal.php');



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

//if($InsFichaIngreso->FinEstado==4  or $InsFichaIngreso->FinEstado==5 or $InsFichaIngreso->FinEstado==6 or $InsFichaIngreso->FinEstado == 72 or $InsFichaIngreso->FinEstado == 7 or $InsFichaIngreso->FinEstado == 71 or $InsFichaIngreso->FinEstado == 73 or $InsFichaIngreso->FinEstado == 74 or $InsFichaIngreso->FinEstado == 75  or $InsFichaIngreso->FinEstado == 9){
	
	include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccFichaAccionTrabajar.php');
	
//}

$ResModalidadIngreso = $InsModalidadIngreso->MtdObtenerModalidadIngresos(NULL,NULL,'MinId','ASC',NULL,"1,3");
$ArrModalidadIngresos = $ResModalidadIngreso['Datos'];

$RepTipoDocumento = $InsTipoDocumento->MtdObtenerTipoDocumentos(NULL,NULL,"TdoId","ASC",NULL);
$ArrTipoDocumentos = $RepTipoDocumento['Datos'];

$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","ASC",NULL,1);
$ArrMonedas = $ResMoneda['Datos'];


?>

<?php
//deb($InsFichaIngreso->FinEstado);
?>

<?php
//if($InsFichaIngreso->FinEstado==4 || $InsFichaIngreso->FinEstado==5 || $InsFichaIngreso->FinEstado==6 || $InsFichaIngreso->FinEstado == 72 || $InsFichaIngreso->FinEstado == 7  || $InsFichaIngreso->FinEstado == 71 || $InsFichaIngreso->FinEstado == 73 ){
if($InsFichaIngreso->FinEstado==4  or $InsFichaIngreso->FinEstado==5 or $InsFichaIngreso->FinEstado==6 or $InsFichaIngreso->FinEstado == 72 or $InsFichaIngreso->FinEstado == 7 or $InsFichaIngreso->FinEstado == 71 or $InsFichaIngreso->FinEstado == 73 or $InsFichaIngreso->FinEstado == 74 or $InsFichaIngreso->FinEstado == 75  or $InsFichaIngreso->FinEstado == 9 or $InsFichaIngreso->FinEstado == 10){
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
			//FncFichaAccionTareaListar2($(this).attr('sigla'));
			
			FncFichaAccionTemparioListar($(this).attr('sigla'));
			
			FncFichaAccionProductoListar($(this).attr('sigla'));
			//FncFichaAccionProductoListar2($(this).attr('sigla'));
			
			FncFichaAccionSuministroListar($(this).attr('sigla'));
			//FncFichaAccionSuministroListar2($(this).attr('sigla'));
			
			FncFichaAccionMantenimientoListar($(this).attr('sigla'));
			
		}			 
	});


	FncFichaAccionHistorialListar();
	FncFichaAccionCotizacionesListar();
	
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

var FichaAccionProductoEditar = 1;
var FichaAccionProductoEliminar = 1;

var FichaAccionSuministroEditar = 2;
var FichaAccionSuministroEliminar = 2;

var FichaAccionMantenimientoEditar = 1;
var FichaAccionMantenimientoEliminar = 1;
var FichaAccionRecibirMantenimientoEditar = 1;

var FichaAccionHerramientaEditar = 2;
var FichaAccionHerramientaEliminar = 2;



var PreEntregaDetalleEditar = 1;
var PreEntregaDetalleEliminar = 1; 


var FichaAccionFotoVINEliminar = 1;
var FichaAccionFotoDelanteraEliminar = 1;
var FichaAccionFotoCuponEliminar = 1;
var FichaAccionFotoMantenimientoEliminar = 1;

</script>

 <form id="FrmEditar" name="FrmEditar" method="post" action="#" enctype="multipart/form-data" onsubmit="FncGuardar();" >

<div class="EstCapSubMenu">

           
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
}
?>            

</div>

<div class="EstCapContenido">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
      
      <tr>
        <td width="1922" height="25" colspan="2"><span class="EstFormularioTitulo">EDITAR  ORDEN DE TRABAJO (TALLER)*</span></td>
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


              
<input name="CmpFichaIngresoIndicacionTecnico" type="hidden" class="EstFormularioCaja" id="CmpFichaIngresoIndicacionTecnico" value="<?php echo $InsFichaIngreso->FinIndicacionTecnico;?>"  />
         
        <input name="CmpPlanMantenimientoId" type="hidden" class="EstFormularioCaja" id="CmpPlanMantenimientoId" value="<?php echo $InsFichaIngreso->PmaId;?>"  /></td>
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
      <td align="left" valign="top">Monto Presupuestado:</td>
      <td align="left" valign="top"><input name="CmpMontoPresupuesto" type="text" class="EstFormularioCaja" id="CmpMontoPresupuesto" value="<?php echo number_format($InsFichaIngreso->FinMontoPresupuesto,2);?>" size="10" maxlength="10" readonly="readonly"  /></td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top"><?php

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
    
    
    
        <tr>
          <td colspan="5" align="left" valign="top"><span class="EstFormularioSubTitulo">OPCIONES ADICIONALES</span></td>
          <td colspan="6" align="left" valign="top"><span class="EstFormularioSubTitulo">TIEMPO DE TRABAJO</span></td>
          </tr>
        <tr>
          <td colspan="5" align="left" valign="top"><input <?php echo (!empty($InsFichaIngreso->FinTiempoTallerConcluido)?'checked="checked"':'');?> type="checkbox" name="CmpFichaIngresoTrabajoConcluido" id="CmpFichaIngresoTrabajoConcluido" value="1" />
          
<span class="EstFormularioResaltar">Marcar ORDEN DE TRABAJO como CONCLUIDO</span>
<img src="imagenes/alerta.gif" alt="Revisar" title="Revisar" width="15" height="15"  align="absmiddle" /></td>
          <td align="left" valign="top">Fecha y hora Inicio:</td>
          <td colspan="5" align="left" valign="top"><?php 
if(!empty($InsFichaIngreso->FinTiempoTallerRevisando)){
?>
           <img src="imagenes/iconos/cronometro.png" alt="Cronometro" title="Cronometro" width="15" height="15" border="0" align="absmiddle" /> <?php echo $InsFichaIngreso->FinTiempoTallerRevisando;?>
            <?php
}else{
?>
No hay fecha y hora
<?php	
}
?>
<input type="hidden" name="CmpFichaIngresoTiempoTallerRevisando" id="CmpFichaIngresoTiempoTallerRevisando" value="<?php echo $InsFichaIngreso->FinTiempoTallerRevisando; ?>" />

</td>
          </tr>
        <tr>
          <td colspan="5" align="left" valign="top"></td>
          <td align="left" valign="top">Fecha y hora Fin:</td>
          <td colspan="5" align="left" valign="top"><?php 
if(!empty($InsFichaIngreso->FinTiempoTallerConcluido)){
?>
            <img src="imagenes/iconos/cronometro.png" alt="Cronometro" title="Cronometro" width="15" height="15" border="0" align="absmiddle" /> <?php echo $InsFichaIngreso->FinTiempoTallerConcluido;?>
            <?php
}else{
?>
No hay fecha
<?php	
}
?>
<input type="hidden" name="CmpFichaIngresoTiempoTrabajoConcluido" id="CmpFichaIngresoTiempoTrabajoConcluido" value="<?php echo $InsFichaIngreso->FinTiempoTallerConcluido; ?>" /></td>
          </tr>
        <tr>
          <td colspan="5" align="left" valign="top">
            
            
</td>
          <td align="left" valign="top">Tiempo Trabajado:</td>
          <td colspan="5" align="left" valign="top"><?php 
if(!empty($InsFichaIngreso->FinTiempoTallerTrabajado)){
?>
            <img src="imagenes/iconos/cronometro.png" alt="Cronometro" title="Cronometro" width="15" height="15" border="0" align="absmiddle" /> <?php echo $InsFichaIngreso->FinTiempoTallerTrabajado;?>
            <?php
}else{
?>
No hay fecha
<?php	
}
?>
<input type="hidden" name="CmpFichaIngresoTiempoTrabajado" id="CmpFichaIngresoTiempoTrabajado" value="<?php echo $InsFichaIngreso->FinTiempoTallerTrabajado; ?>" />

</td>
          </tr>
        <tr>
      <td colspan="11" align="center" valign="top">
      
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
	$c=2;
	foreach($InsFichaIngreso->FichaIngresoModalidad as $DatFichaIngresoModalidad){
	//foreach($ArrModalidadIngresos  as $DatFichaIngresoModalidad){
    ?>
		<li><a id="TabModalidad<?php echo $DatFichaIngresoModalidad->MinSigla;;?>" href="#tab<?php echo $c;?>"><?php echo $DatFichaIngresoModalidad->MinNombre;?></a></li>
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
    
    <li><a href="#tab<?php echo $c+4;?>">Obs. Almacen</a></li>
    
    
</ul>
	
<div class="tab_container">


    
	<?php
	$c=2;
	//foreach($ArrModalidadIngresos  as $DatFichaIngresoModalidad){
	foreach($InsFichaIngreso->FichaIngresoModalidad as $DatFichaIngresoModalidad){	
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

						//deb($FichaAccionCausa);
						
						$FichaAccionId = $DatFichaAccion->FccId;
						$FichaAccionFecha = $DatFichaAccion->FccFecha;
						$FichaAccionObservacion = $DatFichaAccion->FccObservacion;
						$FichaAccionCausa = $DatFichaAccion->FccCausa;
						$FichaAccionSolucion = $DatFichaAccion->FccSolucion;
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
						 
						 default:
						?>
                        
                        
                     <div class="EstFormularioArea" >
                        <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                          
                          
						<?php
						if($DatFichaIngresoModalidad->MinSigla == "GA" || $DatFichaIngresoModalidad->MinSigla == "CA" || $DatFichaIngresoModalidad->MinSigla == "PO"){
						?>
                        
                          <tr>
                            <td colspan="3" align="left">
							
							<?php
							  if($DatFichaIngresoModalidad->MinSigla == "CA"){
							?>
                            CAMPAÑA:
                            
                              <?php
if(!empty($InsFichaIngreso->CamId)){
?>
                              <?php
				if(!empty($InsFichaIngreso->CamBoletin)){
				?>
                              <a  href="subidos/campana/<?php echo $InsFichaIngreso->CamBoletin; ?>" target="_blank"  > <img src="imagenes/menu/campanas.png" alt="[Campañas]" title="<?php echo $InsFichaIngreso->CamCodigo; ?> - <?php echo $InsFichaIngreso->CamNombre; ?>" border="0" align="absmiddle" width="20" height="20" /> <?php echo $InsFichaIngreso->CamCodigo; ?> - <?php echo $InsFichaIngreso->CamNombre; ?></a>
                              <?php					
				}else{
?>
                              <a  href="javascript:alert('!No se encontro boletin de campaña¡');"> <img  src="imagenes/menu/campanas.png" alt="[Campañas]" title="<?php echo $InsFichaIngreso->CamCodigo; ?> - <?php echo $InsFichaIngreso->CamNombre; ?>" border="0" align="absmiddle" width="20" height="20" /> <?php echo $InsFichaIngreso->CamCodigo; ?> - <?php echo $InsFichaIngreso->CamNombre; ?></a>
                              <?php	
				}
				?>
                              <?php   
}
?>
                            <?php
							  }
							  ?></td>
                          </tr>
                          <tr>
                            <td colspan="3" align="left"><div class="EstFormularioArea">
                              <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td colspan="7" align="left" valign="top"><span class="EstFormularioSubTitulo">TEMPARIO</span></td>
                                </tr>
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td align="left" valign="top"><a href="javascript:FncFichaAccionTemparioNuevo('<?php echo $DatFichaIngresoModalidad->MinSigla?>');"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                                  <td align="left" valign="top">Codigo: </td>
                                  <td align="left" valign="top"><input name="Cmp<?php echo $DatFichaIngresoModalidad->MinSigla?>TemparioCodigo" type="text" class="EstFormularioCaja" id="Cmp<?php echo $DatFichaIngresoModalidad->MinSigla?>TemparioCodigo" size="20" maxlength="20" /></td>
                                  <td align="left" valign="top">Tiempo:</td>
                                  <td align="left" valign="top"><input name="Cmp<?php echo $DatFichaIngresoModalidad->MinSigla?>TemparioTiempo" type="text" class="EstFormularioCaja" id="Cmp<?php echo $DatFichaIngresoModalidad->MinSigla?>TemparioTiempo" size="10" maxlength="10" /></td>
                                  <td align="left" valign="top"><a href="javascript:FncFichaAccionTemparioEliminarTodo('<?php echo $DatFichaIngresoModalidad->MinSigla?>');">
                                    <input type="hidden" name="CmpFichaAccion<?php echo $DatFichaIngresoModalidad->MinSigla?>TemparioAccion" id="CmpFichaAccion<?php echo $DatFichaIngresoModalidad->MinSigla?>TemparioAccion" value="AccFichaAccionTemparioRegistrar.php" />
                                    </a>
                                    <input type="hidden" name="Cmp<?php echo $DatFichaIngresoModalidad->MinSigla?>TemparioItem" id="Cmp<?php echo $DatFichaIngresoModalidad->MinSigla?>TemparioItem" />
                                    <input type="hidden" name="Cmp<?php echo $DatFichaIngresoModalidad->MinSigla?>TemparioId" id="Cmp<?php echo $DatFichaIngresoModalidad->MinSigla?>TemparioId" /></td>
                                  <td align="left" valign="top"><a href="javascript:FncFichaAccionTemparioGuardar('<?php echo $DatFichaIngresoModalidad->MinSigla?>');"><img src="imagenes/acciones/guardar.png" width="25" height="25" border="0" title="Guardar" alt="[Guardar]" align="absmiddle" /></a></td>
                                </tr>
                              </table>
                            </div></td>
                          </tr>
                          <tr>
                            <td colspan="3" align="left"><div class="EstFormularioArea" >
                              <table width="30%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                                <tr>
                                  <td width="1%" align="left" valign="top">&nbsp;</td>
                                  <td width="49%" align="left" valign="top"><div class="EstFormularioAccion" id="CapTemparioAccion">Listo
                                    para registrar elementos<a href="javascript:FncFichaAccionTemparioEliminarTodo('<?php echo $DatFichaIngresoModalidad->MinSigla?>');"></a></div></td>
                                  <td width="49%" align="right" valign="top"><a href="javascript:FncFichaAccionTemparioListar('<?php echo $DatFichaIngresoModalidad->MinSigla?>');"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a> <a href="javascript:FncFichaAccionTemparioEliminarTodo('<?php echo $DatFichaIngresoModalidad->MinSigla?>');"><img  src="imagenes/acciones/listado_eliminar_todo.png"  width="25" height="25"  border="0" title="Eliminar Todo"   alt="[Eli. Todo.]" align="absmiddle"/> Eliminar Todo</a></td>
                                  <td width="1%" align="left" valign="top"><div id="CapFichaAccionTempariosResultado"> </div></td>
                                </tr>
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td colspan="2" align="left" valign="top"><div id="CapFichaAccion<?php echo $DatFichaIngresoModalidad->MinSigla?>Temparios" class="EstCapFichaAccionTemparios" > </div></td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td colspan="2" align="left" valign="top"></td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                              </table>
                            </div></td>
                          </tr>

                        
                        <?php
						}
						?>
                          
                          
                          <tr>
                            <td colspan="3" align="center"><span class="EstFormularioSubTitulo">Tareas y Productos: <?php echo strtoupper($DatFichaIngresoModalidad->MinNombre);?></span></td>
                          </tr>
                          <tr>
                            <td colspan="2" align="left" valign="top">
                            
                            
                            
                          <?php
						  if($DatFichaIngresoModalidad->MinSigla == "RE"){
						?>
                         <div class="EstFormularioArea">
                            
                            
                            <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                              <tr>
                                <td>&nbsp;</td>
                                <td><span class="EstFormularioSubTitulo">OPCIONES DE REPARACION</span></td>
                                <td>&nbsp;</td>
                              </tr>
                              <tr>
                                <td>&nbsp;</td>
                                <td><img src="imagenes/estado/aviso.png" alt="Ojo" title="Ojo" border="0" width="25" height="25" align="absmiddle" /> <?php echo strtoupper($InsFichaIngreso->TreNombre);?></td>
                                <td>&nbsp;</td>
                              </tr>
                            </table>
                            
                            
                      </div>
                            
                          
                        <?php
						  }
						  ?>
                          
                          
                          </td>
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr>
                            <td width="51%" align="left" valign="top"><div class="EstFormularioArea">
                              <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                                <tr>
                                  <td width="4" align="left" valign="top">&nbsp;</td>
                                  <td colspan="6" align="left" valign="top"><span class="EstFormularioSubTitulo">TAREAS</span>
                                    <input type="hidden" name="Cmp<?php echo $DatFichaIngresoModalidad->MinSigla?>TareaItem" id="Cmp<?php echo $DatFichaIngresoModalidad->MinSigla?>TareaItem" />
                                    <input type="hidden" name="Cmp<?php echo $DatFichaIngresoModalidad->MinSigla?>TareaId" id="Cmp<?php echo $DatFichaIngresoModalidad->MinSigla?>TareaId" />
                                    
                                    
                                                                        
<input type="hidden" name="Cmp<?php echo $DatFichaIngresoModalidad->MinSigla?>TareaEspecificacion" id="Cmp<?php echo $DatFichaIngresoModalidad->MinSigla?>TareaEspecificacion" />
                                    
                                    <input type="hidden" name="Cmp<?php echo $DatFichaIngresoModalidad->MinSigla?>TareaCosto" id="Cmp<?php echo $DatFichaIngresoModalidad->MinSigla?>TareaCosto" />
                                    
                                    
                                    
                                    </td>
                                </tr>
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td width="20" align="left" valign="top"><a href="javascript:FncFichaAccionTareaEliminarTodo('<?php echo $DatFichaIngresoModalidad->MinSigla?>');">
                                    <input type="hidden" name="CmpFichaAccion<?php echo $DatFichaIngresoModalidad->MinSigla?>TareaAccion" id="CmpFichaAccion<?php echo $DatFichaIngresoModalidad->MinSigla?>TareaAccion" value="AccFichaAccionTareaRegistrar.php" />
                                  </a></td>
                                  <td width="97" align="left" valign="top">Descripcion: </td>
                                  <td width="98" align="right" valign="top">&nbsp;</td>
                                  <td width="109" align="right" valign="top"></td>
                                  <td width="98" align="right" valign="top">Actividad:</td>
                                  <td width="21" align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td align="left" valign="top"><a href="javascript:FncFichaAccionTareaNuevo('<?php echo $DatFichaIngresoModalidad->MinSigla?>');"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                                  <td colspan="3" align="left" valign="top"><input name="Cmp<?php echo $DatFichaIngresoModalidad->MinSigla?>TareaDescripcion" type="text" class="EstFormularioCaja" id="Cmp<?php echo $DatFichaIngresoModalidad->MinSigla?>TareaDescripcion" value="" size="50" /></td>
                                  <td align="left" valign="top"><select class="EstFormularioCombo" name="Cmp<?php echo $DatFichaIngresoModalidad->MinSigla?>TareaAccion" id="Cmp<?php echo $DatFichaIngresoModalidad->MinSigla?>TareaAccion">
                                    <option value="I">Inspeccionar</option>
                                    <option value="R">Realizar</option>
                                  </select></td>
                                  <td align="left" valign="top"><a href="javascript:FncFichaAccionTareaGuardar('<?php echo $DatFichaIngresoModalidad->MinSigla?>');"><img src="imagenes/acciones/guardar.png" width="25" height="25" border="0" title="Guardar" alt="[Guardar]" align="absmiddle" /></a></td>
                                </tr>
                              </table>
                            </div></td>
                            <td width="48%" align="left" valign="top">
                            
                            

<div class="EstFormularioArea">
                              <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                                <tr>
                                  <td>&nbsp;</td>
                                  <td colspan="6"><span class="EstFormularioSubTitulo">PRODUCTOS </span><span class="EstFormularioSubTitulo">
                                    <input type="hidden" name="Cmp<?php echo $DatFichaIngresoModalidad->MinSigla?>ProductoUnidadMedida" id="Cmp<?php echo $DatFichaIngresoModalidad->MinSigla?>ProductoUnidadMedida" value="" />
                                    <input type="hidden" name="Cmp<?php echo $DatFichaIngresoModalidad->MinSigla?>ProductoUnidadMedidaEquivalente"   id="Cmp<?php echo $DatFichaIngresoModalidad->MinSigla?>ProductoUnidadMedidaEquivalente" value=""  />
                                    <input type="hidden" name="Cmp<?php echo $DatFichaIngresoModalidad->MinSigla?>ProductoId"    id="Cmp<?php echo $DatFichaIngresoModalidad->MinSigla?>ProductoId" value=""   />
                                    <input type="hidden" name="Cmp<?php echo $DatFichaIngresoModalidad->MinSigla?>ProductoItem" id="Cmp<?php echo $DatFichaIngresoModalidad->MinSigla?>ProductoItem" value="" />
                                    <input type="hidden" name="CmpFichaAccion<?php echo $DatFichaIngresoModalidad->MinSigla?>ProductoId"  class="EstFormularioCaja" id="CmpFichaAccion<?php echo $DatFichaIngresoModalidad->MinSigla?>ProductoId" value=""  />
                      
                      

 <input type="hidden" name="Cmp<?php echo $DatFichaIngresoModalidad->MinSigla?>ProductoCodigoOriginal" id="Cmp<?php echo $DatFichaIngresoModalidad->MinSigla?>ProductoCodigoOriginal" value="" />
 
  <input type="hidden" name="Cmp<?php echo $DatFichaIngresoModalidad->MinSigla?>ProductoCodigoAlternativo" id="Cmp<?php echo $DatFichaIngresoModalidad->MinSigla?>ProductoCodigoAlternativo" value="" />
  
  
                



                                  </span></td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td><input type="hidden" name="CmpFichaAccion<?php echo $DatFichaIngresoModalidad->MinSigla?>ProductoAccion" id="CmpFichaAccion<?php echo $DatFichaIngresoModalidad->MinSigla?>ProductoAccion" value="AccFichaAccionProductoRegistrar.php" /></td>
                                  <td>Nombre : </td>
                                  <td>U.M. </td>
                                  <td>Cantidad:</td>
                                  <td><div id="Cap<?php echo $DatFichaIngresoModalidad->MinSigla?>ProductoBuscar"></div></td>
                                  <td>&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td><a href="javascript:FncFichaAccionProductoNuevo('<?php echo $DatFichaIngresoModalidad->MinSigla?>');"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                                  <td><input name="Cmp<?php echo $DatFichaIngresoModalidad->MinSigla?>ProductoNombre" type="text" class="EstFormularioCaja" id="Cmp<?php echo $DatFichaIngresoModalidad->MinSigla?>ProductoNombre" size="40" /></td>
                                  <td><select  class="EstFormularioCombo" name="Cmp<?php echo $DatFichaIngresoModalidad->MinSigla?>ProductoUnidadMedidaConvertir" id="Cmp<?php echo $DatFichaIngresoModalidad->MinSigla?>ProductoUnidadMedidaConvertir">
                                  </select></td>
                                  <td><input name="Cmp<?php echo $DatFichaIngresoModalidad->MinSigla?>ProductoCantidad" type="text" class="EstFormularioCaja" id="Cmp<?php echo $DatFichaIngresoModalidad->MinSigla?>ProductoCantidad" size="10" maxlength="10"  /></td>
                                  <td><a href="javascript:FncFichaAccionProductoGuardar('<?php echo $DatFichaIngresoModalidad->MinSigla?>');"><img src="imagenes/acciones/guardar.png" width="25" height="25" border="0" title="Guardar" alt="[Guardar]" align="absmiddle" /></a></td>
                                  <td><a href="comunes/Producto/FrmProductoBuscar.php?height=440&amp;width=850&amp;Modalidad=<?php echo $DatFichaIngresoModalidad->MinSigla?>" class="thickbox" title=""><img src="imagenes/acciones/buscador.png" width="25" height="25" border="0" align="absmiddle" ></a></td>
                                </tr>
                              </table>
                            </div>
                                                        
                            
                            </td>
                            <td width="1%" align="left" valign="top">&nbsp;</td>
                          </tr>
                          
                          <tr>
                            <td align="left" valign="top"><div class="EstFormularioArea" >
                              <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                                <tr>
                                  <td width="2%" align="left" valign="top">&nbsp;</td>
                                  <td colspan="2" align="left" valign="top">TAREAS asignadas en la Orden de Trabajo</td>
                                  <td width="1%" align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td width="49%" align="left" valign="top"><div class="EstFormularioAccion" id="Cap<?php echo $DatFichaIngresoModalidad->MinSigla?>TareaAccion"> Listo
                                    para registrar elementos</div></td>
                                  <td width="48%" align="right" valign="top"><a href="javascript:FncFichaAccionTareaListar('<?php echo $DatFichaIngresoModalidad->MinSigla?>');"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a> <a href="javascript:FncFichaAccionTareaEliminarTodo('<?php echo $DatFichaIngresoModalidad->MinSigla?>');"><img  src="imagenes/acciones/listado_eliminar_todo.png"  width="25" height="25"  border="0" title="Eliminar Todo"   alt="[Eli. Todo.]" align="absmiddle"/> Eliminar Todo</a></td>
                                  <td align="left" valign="top"><div id="CapFichaAccionTareasResultado"> </div></td>
                                  </tr>
                                  
<?php
/*
?>
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td colspan="2" align="left" valign="top"><div id="CapFichaAccion<?php echo $DatFichaIngresoModalidad->MinSigla?>Tareas2" class="EstCapFichaAccionTareas" > </div></td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                            
<?php
*/
?>                    
                                
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td colspan="2" align="left" valign="top"><div id="CapFichaAccion<?php echo $DatFichaIngresoModalidad->MinSigla?>Tareas" class="EstCapFichaAccionTareas" > </div></td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td colspan="2" align="left" valign="top">(*) Aun no se ha guardado </td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                              </table>
                            </div></td>
                            <td align="left" valign="top"><div class="EstFormularioArea" >
                              <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                                <tr>
                                  <td width="2%">&nbsp;</td>
                                  <td colspan="2">PRODUCTOS asignados en la Orden de Trabajo</td>
                                  <td width="2%">&nbsp;</td>
                                  </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td width="50%"><div class="EstFormularioAccion" id="Cap<?php echo $DatFichaIngresoModalidad->MinSigla?>ProductoAccion">Listo
                                    para registrar elementos </div></td>
                                  <td width="46%" align="right"><a href="javascript:FncFichaAccionProductoListar('<?php echo $DatFichaIngresoModalidad->MinSigla?>');"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a> <a href="javascript:FncFichaAccionProductoEliminarTodo('<?php echo $DatFichaIngresoModalidad->MinSigla?>');"></a></td>
                                  <td><div id="CapFichaAccion<?php echo $DatFichaIngresoModalidad->MinSigla?>ProductosResultado"> </div></td>
                                  </tr>
                                  
<?php
/*
?>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td colspan="2"><div id="CapFichaAccion<?php echo $DatFichaIngresoModalidad->MinSigla?>Productos2" class="EstCapFichaAccionProductos" > </div></td>
                                  <td>&nbsp;</td>
                                  </tr>
  <?php
*/
?>
                                    
                                  
                                <tr>
                                  <td>&nbsp;</td>
                                  <td colspan="2"><div id="CapFichaAccion<?php echo $DatFichaIngresoModalidad->MinSigla?>Productos" class="EstCapFichaAccionProductos" ></div></td>
                                  <td>&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td colspan="2">&nbsp;</td>
                                  <td>&nbsp;</td>
                                  </tr>
                                </table>
                            </div></td>
                            <td align="left" valign="top">
                            <?php
							/*
							?>
                            
                            <div class="EstFormularioArea" >
                              <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                                <tr>
                                  <td width="1%">&nbsp;</td>
                                  <td colspan="2"><span class="EstFormularioSubTitulo">SUMINISTROS</span> asignados en la Orden de Trabajo</td>
                                  <td width="2%">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td width="50%"><div class="EstFormularioAccion" id="Cap<?php echo $DatFichaIngresoModalidad->MinSigla?>SuministroAccion">Listo
                                    para registrar elementos </div></td>
                                  <td width="47%" align="right"><a href="javascript:FncFichaAccionSuministroListar('<?php echo $DatFichaIngresoModalidad->MinSigla?>');"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a> <a href="javascript:FncFichaAccionSuministroEliminarTodo('<?php echo $DatFichaIngresoModalidad->MinSigla?>');"></a></td>
                                  <td><div id="CapFichaAccion<?php echo $DatFichaIngresoModalidad->MinSigla?>SuministrosResultado"> </div></td>
                                  </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td colspan="2"><div id="CapFichaAccion<?php echo $DatFichaIngresoModalidad->MinSigla?>Suministros2" class="EstCapFichaAccionSuministros" > </div></td>
                                  <td>&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td colspan="2"><div id="CapFichaAccion<?php echo $DatFichaIngresoModalidad->MinSigla?>Suministros" class="EstCapFichaAccionSuministros" ></div></td>
                                  <td>&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td colspan="2">&nbsp;</td>
                                  <td>&nbsp;</td>
                                </tr>
                              </table>
                            </div>
                             <?php
							*/
							?>
                            
                            </td>
                          </tr>
                          
                          <tr>
                            <td colspan="3" align="left" valign="top"><div class="EstFormularioArea" >
                              <table border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td align="left" valign="top"><span class="EstFormularioSubTitulo">Pedidos</span></td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td align="left" valign="top"><script type="text/javascript">

tinymce.init({
	selector: "textarea#CmpFichaAccionPedido_<?php echo $DatFichaIngresoModalidad->MinSigla?>",
	theme: "modern",
	menubar : false,
	toolbar1: "bold italic | bullist numlist",
	width : 830,
	height : 80

});

                            </script>
                                    <textarea name="CmpFichaAccionPedido_<?php echo $DatFichaIngresoModalidad->MinSigla?>" cols="60" rows="2" class="EstFormularioCaja" id="CmpFichaAccionPedido_<?php echo $DatFichaIngresoModalidad->MinSigla?>"><?php echo stripslashes($FichaAccionPedido);?></textarea>
                                    


<input type="hidden" name="CmpFichaAccionPedido_<?php echo $DatFichaIngresoModalidad->MinSigla?>2" id="CmpFichaAccionPedido_<?php echo $DatFichaIngresoModalidad->MinSigla?>2" value="<?php echo stripslashes($FichaAccionPedido);?>" >



</td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td align="left" valign="top"><span class="EstFormularioNota">* Pedidos adicionales a almacen </span></td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                              </table>
                            </div></td>
                          </tr>
                         
         <?php
						  if($DatFichaIngresoModalidad->MinSigla == "GA" || $DatFichaIngresoModalidad->MinSigla == "CA" || $DatFichaIngresoModalidad->MinSigla == "PO"  || $DatFichaIngresoModalidad->MinSigla == "IF"){
						?>                 
                         
                             <tr>
                            <td colspan="3" align="left" valign="top"><div class="EstFormularioArea" >
                              <table border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td align="left" valign="top"><span class="EstFormularioSubTitulo">Causas del Problema</span></td>
                                  <td align="left" valign="top">&nbsp;</td>
                                  </tr>
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td align="left" valign="top"><script type="text/javascript">


tinymce.init({
	selector: "textarea#CmpFichaAccionCausa_<?php echo $DatFichaIngresoModalidad->MinSigla?>",
	theme: "modern",
	menubar : false,
	toolbar1: "bold italic | bullist numlist",
	width : 830,
	height : 80
});

                            </script>
                                    <textarea name="CmpFichaAccionCausa_<?php echo $DatFichaIngresoModalidad->MinSigla?>" cols="60" rows="2" class="EstFormularioCaja" id="CmpFichaAccionCausa_<?php echo $DatFichaIngresoModalidad->MinSigla?>"><?php echo stripslashes($FichaAccionCausa);?></textarea></td>
                                  <td align="left" valign="top">&nbsp;</td>
                                  </tr>
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td align="left" valign="top"><span class="EstFormularioNota">* En caso de una Garantia, Campaña o Politica, rellene este espacio.</span></td>
                                  <td align="left" valign="top">&nbsp;</td>
                                  </tr>
                                </table>
                            </div></td>
                          </tr>
                          
                          
                          
                                <tr>
                                                                                <td colspan="3" align="left" valign="top">
                                                                                
                                                                                
                                                                                <div class="EstFormularioArea" >
                              <table border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td align="left" valign="top"><span class="EstFormularioSubTitulo">Solucion al Problema</span></td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td align="left" valign="top"><script type="text/javascript">


tinymce.init({
	selector: "textarea#CmpFichaAccionSolucion_<?php echo $DatFichaIngresoModalidad->MinSigla?>",
	theme: "modern",
	menubar : false,
	toolbar1: "bold italic | bullist numlist",
width : 830,
	height : 80
});

                            </script>
                                    <textarea name="CmpFichaAccionSolucion_<?php echo $DatFichaIngresoModalidad->MinSigla?>" cols="60" rows="2" class="EstFormularioCaja" id="CmpFichaAccionSolucion_<?php echo $DatFichaIngresoModalidad->MinSigla?>"><?php echo stripslashes($FichaAccionSolucion);?></textarea></td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td align="left" valign="top"><span class="EstFormularioNota">* En caso de una Garantia, Campaña o Politica, rellene este espacio.</span></td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                              </table>
                            </div></td>
                                                                              </tr>           

                      

                            
   		  

                          
                     <?php
						  }
		  ?>         
                          
                          
                          
                                                                            
                                                                              <tr>
                            <td colspan="3" align="left" valign="top">
                            
                            

                            <div class="EstFormularioArea" >
                              <table border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                                <tr>
                                  <td width="4" align="left" valign="top">&nbsp;</td>
                                  <td colspan="2" align="left" valign="top">
                                    
                                    <span class="EstFormularioSubTitulo">Fotos</span>
                                    
                                    <a href="javascript:FncFichaAccionFotoListar('<?php echo $DatFichaIngresoModalidad->MinSigla?>');"></a>                                  </td>
                                  <td width="4" align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td width="93" align="left" valign="top">&nbsp;</td>
                                  <td width="168" align="right" valign="top"><a href="javascript:FncFichaAccionFotoListar('<?php echo $DatFichaIngresoModalidad->MinSigla?>');"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a></td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td colspan="2" align="left" valign="top">
  <div id="fileuploader<?php echo $DatFichaIngresoModalidad->MinSigla?>">Escoger Archivos</div>
                                    
                                    
                                    <script type="text/javascript">
		$(document).ready(function()
{
	$("#fileuploader<?php echo $DatFichaIngresoModalidad->MinSigla?>").uploadFile({
		
	allowedTypes:"png,gif,jpg,jpeg",
	url:"formularios/FichaAccion/acc/AccFichaAccionSubirFoto2.php",
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
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td colspan="2" align="left" valign="top"><div class="EstCapFichaAccionFotos" id="CapFichaAccion<?php echo $DatFichaIngresoModalidad->MinSigla;?>Fotos"></div></td>
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
                        </table>
</div>
                      
                        
                          <?php 
						 break;
						 
						 case "MA":
						?>
                        
                        <div class="EstFormularioArea" >
                        <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                          <tr>
                            <td>&nbsp;</td>
                            <td colspan="3" align="center"><span class="EstFormularioSubTitulo">MA - Tareas y Productos: <?php echo strtoupper($DatFichaIngresoModalidad->MinNombre);?></span></td>
                            <td>&nbsp;</td>
                          </tr>
                          <tr>
                            <td>&nbsp;</td>
                            <td width="24%">Kilometraje/Plan Mant.:</td>
                            <td width="25%"><?php
							//deb($InsFichaIngreso->VmaId);
							?>
                              <select class="EstFormularioCombo" name="CmpFichaIngresoMantenimientoKilometraje" id="CmpFichaIngresoMantenimientoKilometraje" disabled="disabled">
                                <option value="">Escoja una opcion</option>
                                <?php
							switch($InsFichaIngreso->VmaId){
								
								//case "VMA-10017"://CHEVROLET
								default://CHEVROLET
							?>
                                <?php
            foreach($InsPlanMantenimiento->PmaChevroletKilometrajes as $DatKilometroEtiqueta => $DatKilometro){
            ?>
                                <option <?php echo ($DatKilometro['km']==$InsFichaIngreso->FinMantenimientoKilometraje)?'selected="selected"':"";?> value="<?php echo $DatKilometro['km'];?>"><?php echo $DatKilometroEtiqueta;?> km</option>
                                <?php	
            }
            ?>
                                <?php	
								break;
								
								
								case "VMA-10018"://ISUZU
							?>
                                <?php
            foreach($InsPlanMantenimiento->PmaIsuzuKilometrajes as $DatKilometroEtiqueta => $DatKilometro){
            ?>
                                <option <?php echo ($DatKilometro['km']==$InsFichaIngreso->FinMantenimientoKilometraje)?'selected="selected"':"";?> value="<?php echo $DatKilometro['km'];?>"><?php echo $DatKilometroEtiqueta;?> km</option>
                                <?php	
            }
            ?>
                                <?php	
								break;
								
								case "":
									die("No se encontro la MARCA DEL VEHICULO");
								break;
								
								
							}
							?>
                            </select></td>
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
                            <td colspan="2"><span class="EstFormularioSubTitulo"> Tareas del Plan de Mantenimiento</span></td>
                            <td width="49%" align="right">
                              
  <?php
//deb($InsFichaIngreso->FinEstado);
?>
                              
                              <input type="hidden" name="CmpMantenimientoLlenadoAutomatico" id="CmpMantenimientoLlenadoAutomatico" value="<?php echo ($InsFichaIngreso->FinEstado == 11 || $InsFichaIngreso->FinEstado == 2 )?'1':'2';?>"   />
                              
                              
                              
                              <a href="javascript:FncFichaAccionMantenimientoListar('<?php echo $DatFichaIngresoModalidad->MinSigla?>');">
                            <img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a></td>
                            <td width="1%">&nbsp;</td>
                          </tr>
                          <tr>
                            <td>&nbsp;</td>
                            <td colspan="3"><div id="CapFichaAccion<?php echo $DatFichaIngresoModalidad->MinSigla?>Mantenimientos" class="EstCapFichaAccionMantenimientos" > </div></td>
                            <td>&nbsp;</td>
                          </tr>
                          <tr>
                            <td>&nbsp;</td>
                            <td colspan="3"><div class="EstFormularioArea">
                              <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                                <tr>
                                  <td width="4" align="left" valign="top">&nbsp;</td>
                                  <td width="344" align="left" valign="top"><span class="EstFormularioSubTitulo">PRODUCTOS</span></td>
                                  <td width="5" align="left" valign="top">&nbsp;</td>
                                </tr>
                              </table>
                            </div></td>
                            <td>&nbsp;</td>
                          </tr>
                          <tr>
                            <td>&nbsp;</td>
                            <td colspan="3"><div class="EstFormularioArea" >
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
                                    <td colspan="2"><div id="CapFichaAccion<?php echo $DatFichaIngresoModalidad->MinSigla?>Productos" class="EstCapFichaAccionProductos" ></div></td>
                                    <td>&nbsp;</td>
                                  </tr>
                                  <tr>
                                    <td>&nbsp;</td>
                                    <td colspan="2">&nbsp;</td>
                                    <td>&nbsp;</td>
                                  </tr>
                                </table>
                            </div></td>
                            <td>&nbsp;</td>
                          </tr>
                          <tr>
                            <td>&nbsp;</td>
                            <td colspan="3"><div class="EstFormularioArea" >
                              <table border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td align="left" valign="top"><span class="EstFormularioSubTitulo">Pedidos</span></td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td align="left" valign="top"><script type="text/javascript">

tinymce.init({
	selector: "textarea#CmpFichaAccionPedido_<?php echo $DatFichaIngresoModalidad->MinSigla?>",
	theme: "modern",
	menubar : false,
	toolbar1: "bold italic | bullist numlist",
	width : 830,
	height : 80

});

                            </script>
                                    <textarea name="CmpFichaAccionPedido_<?php echo $DatFichaIngresoModalidad->MinSigla?>" cols="60" rows="2" class="EstFormularioCaja" id="CmpFichaAccionPedido_<?php echo $DatFichaIngresoModalidad->MinSigla?>"><?php echo stripslashes($FichaAccionPedido);?></textarea>
                                    


<input type="hidden" name="CmpFichaAccionPedido_<?php echo $DatFichaIngresoModalidad->MinSigla?>2" id="CmpFichaAccionPedido_<?php echo $DatFichaIngresoModalidad->MinSigla?>2" value="<?php echo stripslashes($FichaAccionPedido);?>" >



</td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td align="left" valign="top"><span class="EstFormularioNota">* Pedidos adicionales a almacen </span></td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                              </table>
                            </div></td>
                            <td>&nbsp;</td>
                          </tr>
                          <tr>
                            <td>&nbsp;</td>
                            <td colspan="3"><div class="EstFormularioArea" >
                              <table border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                                <tr>
                                  <td width="4" align="left" valign="top">&nbsp;</td>
                                  <td colspan="2" align="left" valign="top">
                                    
                                    <span class="EstFormularioSubTitulo">Fotos</span>
                                    
                                    <a href="javascript:FncFichaAccionFotoListar('<?php echo $DatFichaIngresoModalidad->MinSigla?>');"></a>                                  </td>
                                  <td width="4" align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td width="93" align="left" valign="top">&nbsp;</td>
                                  <td width="168" align="right" valign="top"><a href="javascript:FncFichaAccionFotoListar('<?php echo $DatFichaIngresoModalidad->MinSigla?>');"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a></td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td colspan="2" align="left" valign="top">
  <div id="fileuploader<?php echo $DatFichaIngresoModalidad->MinSigla?>">Escoger Archivos</div>
                                    
                                    
                                    <script type="text/javascript">
		$(document).ready(function()
{
	$("#fileuploader<?php echo $DatFichaIngresoModalidad->MinSigla?>").uploadFile({
		
	allowedTypes:"png,gif,jpg,jpeg",
	url:"formularios/FichaAccion/acc/AccFichaAccionSubirFoto2.php",
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
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td colspan="2" align="left" valign="top"><div class="EstCapFichaAccionFotos" id="CapFichaAccion<?php echo $DatFichaIngresoModalidad->MinSigla;?>Fotos"></div></td>
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
                            </div></td>
                            <td>&nbsp;</td>
                          </tr>
                          <tr>
                            <td>&nbsp;</td>
                            <td colspan="3">
                            



                            
                            
                            
                            
                            </td>
                            <td><div id="CapFichaAccion<?php echo $DatFichaIngresoModalidad->MinSigla?>MantenimientosResultado"> </div></td>
                          </tr>
                          </table>
                  </div>
                        
                        
                         <?php					 
						 break;
						 
						 case "SI":
						?>
                        
                     <div class="EstFormularioArea" >
                        <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                          

                          
                          
                          <tr>
                            <td align="center"><span class="EstFormularioSubTitulo">SI - Tareas y Productos: <?php echo strtoupper($DatFichaIngresoModalidad->MinNombre);?></span></td>
                          </tr>
                          <tr>
                            <td align="left" valign="top"><div class="EstFormularioArea">
                              <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                                <tr>
                                  <td width="1" align="left" valign="top">&nbsp;</td>
                                  <td colspan="7" align="left" valign="top"><span class="EstFormularioSubTitulo">TAREAS</span>
                                    <input type="hidden" name="Cmp<?php echo $DatFichaIngresoModalidad->MinSigla?>TareaItem" id="Cmp<?php echo $DatFichaIngresoModalidad->MinSigla?>TareaItem" />
                                    <input type="hidden" name="Cmp<?php echo $DatFichaIngresoModalidad->MinSigla?>TareaId" id="Cmp<?php echo $DatFichaIngresoModalidad->MinSigla?>TareaId" /></td>
                                  </tr>
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td width="20" align="left" valign="top"><a href="javascript:FncFichaAccionTareaEliminarTodo('<?php echo $DatFichaIngresoModalidad->MinSigla?>');">
                                    <input type="hidden" name="CmpFichaAccion<?php echo $DatFichaIngresoModalidad->MinSigla?>TareaAccion" id="CmpFichaAccion<?php echo $DatFichaIngresoModalidad->MinSigla?>TareaAccion" value="AccFichaAccionTareaRegistrar.php" />
                                    </a></td>
                                  <td width="132" align="left" valign="top">Descripcion: </td>
                                  <td width="61" align="right" valign="top">&nbsp;</td>
                                  <td width="111" align="right" valign="top">
                                  
                                  
                                  </td>
                                  <td width="20" align="left" valign="top">Actividad:</td>
                                  <td width="20" align="left" valign="top">Costo:</td>
                                  <td width="20" align="left" valign="top">&nbsp;</td>
                                  </tr>
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td align="left" valign="top"><a href="javascript:FncFichaAccionTareaNuevo('<?php echo $DatFichaIngresoModalidad->MinSigla?>');"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                                  <td colspan="3" align="left" valign="top"><textarea name="Cmp<?php echo $DatFichaIngresoModalidad->MinSigla?>TareaDescripcion" cols="50" class="EstFormularioCaja" id="Cmp<?php echo $DatFichaIngresoModalidad->MinSigla?>TareaDescripcion"></textarea></td>
                                  <td align="left" valign="top"><select class="EstFormularioCombo" name="Cmp<?php echo $DatFichaIngresoModalidad->MinSigla?>TareaAccion" id="Cmp<?php echo $DatFichaIngresoModalidad->MinSigla?>TareaAccion">
                                    <option value="L">Planchado</option>
                                    <option value="N">Pintado</option>
                                    <option value="E">Centrado</option>
                                    <option value="Z">Tarea/Reparacion</option>
                                  </select></td>
                                  <td align="left" valign="top">
                                    
                                    
                                    <input name="Cmp<?php echo $DatFichaIngresoModalidad->MinSigla?>TareaCosto" type="text" class="EstFormularioCaja" id="Cmp<?php echo $DatFichaIngresoModalidad->MinSigla?>TareaCosto" size="10" maxlength="10" />
                                    
                                    
                                  </td>
                                  <td align="left" valign="top"><a href="javascript:FncFichaAccionTareaGuardar('<?php echo $DatFichaIngresoModalidad->MinSigla?>');"><img src="imagenes/acciones/guardar.png" width="25" height="25" border="0" title="Guardar" alt="[Guardar]" align="absmiddle" /></a></td>
                                  </tr>
                                </table>
                            </div></td>
                          </tr>
                          <tr>
                            <td align="left" valign="top">
                          
                            
                            <div class="EstFormularioArea" >
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
                                  <td colspan="2" align="left" valign="top"><div id="CapFichaAccion<?php echo $DatFichaIngresoModalidad->MinSigla?>Tareas" class="EstCapFichaAccionTareas" > </div></td>
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
                              <?php
							/*
							?>

<div class="EstFormularioArea">
                                <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                                  <tr>
                                    <td>&nbsp;</td>
                                    <td colspan="10"><span class="EstFormularioSubTitulo">PRODUCTOS </span><span class="EstFormularioSubTitulo">
                                      <input type="hidden" name="Cmp<?php echo $DatFichaIngresoModalidad->MinSigla?>ProductoUnidadMedida" id="Cmp<?php echo $DatFichaIngresoModalidad->MinSigla?>ProductoUnidadMedida" value="" />
                                      <input type="hidden" name="Cmp<?php echo $DatFichaIngresoModalidad->MinSigla?>ProductoUnidadMedidaEquivalente"   id="Cmp<?php echo $DatFichaIngresoModalidad->MinSigla?>ProductoUnidadMedidaEquivalente" value=""  />
                                      <input type="hidden" name="Cmp<?php echo $DatFichaIngresoModalidad->MinSigla?>ProductoId"    id="Cmp<?php echo $DatFichaIngresoModalidad->MinSigla?>ProductoId" value=""   />
                                      <input type="hidden" name="Cmp<?php echo $DatFichaIngresoModalidad->MinSigla?>ProductoItem" id="Cmp<?php echo $DatFichaIngresoModalidad->MinSigla?>ProductoItem" value="" />
                                      <input type="hidden" name="CmpFichaAccion<?php echo $DatFichaIngresoModalidad->MinSigla?>ProductoId"  class="EstFormularioCaja" id="CmpFichaAccion<?php echo $DatFichaIngresoModalidad->MinSigla?>ProductoId" value=""  />
                                    </span></td>
                                  </tr>
                                  <tr>
                                    <td>&nbsp;</td>
                                    <td><input type="hidden" name="CmpFichaAccion<?php echo $DatFichaIngresoModalidad->MinSigla?>ProductoAccion" id="CmpFichaAccion<?php echo $DatFichaIngresoModalidad->MinSigla?>ProductoAccion" value="AccFichaAccionProductoRegistrar.php" /></td>
                                    <td>C&oacute;digo Orig.</td>
                                    <td>&nbsp;</td>
                                    <td>C&oacute;digo Alt.</td>
                                    <td>&nbsp;</td>
                                    <td>Nombre : </td>
                                    <td>U.M. </td>
                                    <td>Cantidad:</td>
                                    <td><div id="Cap<?php echo $DatFichaIngresoModalidad->MinSigla?>ProductoBuscar"></div></td>
                                    <td>&nbsp;</td>
                                  </tr>
                                  <tr>
                                    <td>&nbsp;</td>
                                    <td><a href="javascript:FncFichaAccionProductoNuevo('<?php echo $DatFichaIngresoModalidad->MinSigla?>');"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                                    <td><input name="Cmp<?php echo $DatFichaIngresoModalidad->MinSigla?>ProductoCodigoOriginal"  type="text" class="EstFormularioCaja" id="Cmp<?php echo $DatFichaIngresoModalidad->MinSigla?>ProductoCodigoOriginal" size="10" maxlength="20" /></td>
                                    <td><a href="javascript:FncProductoBuscar('CodigoOriginal','<?php echo $DatFichaIngresoModalidad->MinSigla?>');"><img src="imagenes/acciones/buscar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                                    <td><input name="Cmp<?php echo $DatFichaIngresoModalidad->MinSigla?>ProductoCodigoAlternativo"  type="text" class="EstFormularioCaja" id="Cmp<?php echo $DatFichaIngresoModalidad->MinSigla?>ProductoCodigoAlternativo" size="10" maxlength="20" /></td>
                                    <td><a href="javascript:FncProductoBuscar('CodigoAlternativo','<?php echo $DatFichaIngresoModalidad->MinSigla?>');"><img src="imagenes/acciones/buscar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                                    <td><input name="Cmp<?php echo $DatFichaIngresoModalidad->MinSigla?>ProductoNombre" type="text" class="EstFormularioCaja" id="Cmp<?php echo $DatFichaIngresoModalidad->MinSigla?>ProductoNombre" size="40" /></td>
                                    <td><select  class="EstFormularioCombo" name="Cmp<?php echo $DatFichaIngresoModalidad->MinSigla?>ProductoUnidadMedidaConvertir" id="Cmp<?php echo $DatFichaIngresoModalidad->MinSigla?>ProductoUnidadMedidaConvertir">
                                    </select></td>
                                    <td><input name="Cmp<?php echo $DatFichaIngresoModalidad->MinSigla?>ProductoCantidad" type="text" class="EstFormularioCaja" id="Cmp<?php echo $DatFichaIngresoModalidad->MinSigla?>ProductoCantidad" size="10" maxlength="10"  /></td>
                                    <td><a href="javascript:FncFichaAccionProductoGuardar('<?php echo $DatFichaIngresoModalidad->MinSigla?>');"><img src="imagenes/acciones/guardar.png" width="25" height="25" border="0" title="Guardar" alt="[Guardar]" align="absmiddle" /></a></td>
                                    <td><a href="comunes/Producto/FrmProductoBuscar.php?height=440&amp;width=850&amp;Modalidad=<?php echo $DatFichaIngresoModalidad->MinSigla?>" class="thickbox" title=""><img src="imagenes/acciones/buscador.png" width="25" height="25" border="0" align="absmiddle" ></a></td>
                                  </tr>
                                </table>
                              </div>
                              
                              <?php
					 */
							  ?>
                            
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
                            <td align="left" valign="top">
                            
                            
                            <div class="EstFormularioArea" >
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
                                    <td colspan="2"><div id="CapFichaAccion<?php echo $DatFichaIngresoModalidad->MinSigla?>Productos" class="EstCapFichaAccionProductos" ></div></td>
                                    <td>&nbsp;</td>
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
                            <td align="left" valign="top"><div class="EstFormularioArea" >
                              <table border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td align="left" valign="top"><span class="EstFormularioSubTitulo">Pedidos</span></td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td align="left" valign="top"><script type="text/javascript">

tinymce.init({
	selector: "textarea#CmpFichaAccionPedido_<?php echo $DatFichaIngresoModalidad->MinSigla?>",
	theme: "modern",
	menubar : false,
	toolbar1: "bold italic | bullist numlist",
width : 830,
	height : 80
});

                            </script>
                                    <textarea name="CmpFichaAccionPedido_<?php echo $DatFichaIngresoModalidad->MinSigla?>" cols="60" rows="2" class="EstFormularioCaja" id="CmpFichaAccionPedido_<?php echo $DatFichaIngresoModalidad->MinSigla?>"><?php echo stripslashes($FichaAccionPedido);?></textarea>
                                    
                                    
                                    <input type="hidden" name="CmpFichaAccionPedido_<?php echo $DatFichaIngresoModalidad->MinSigla?>2" id="CmpFichaAccionPedido_<?php echo $DatFichaIngresoModalidad->MinSigla?>2" value="<?php echo stripslashes($FichaAccionPedido);?>" >
                                    
                                    </td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td align="left" valign="top"><span class="EstFormularioNota">* Pedidos adicionales a almacen </span></td>
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
                                  <td colspan="2" align="left" valign="top">
                                    
                                    <span class="EstFormularioSubTitulo">Fotos</span>
                                    
                                    <a href="javascript:FncFichaAccionFotoListar('<?php echo $DatFichaIngresoModalidad->MinSigla?>');"></a>                                  </td>
                                  <td width="4" align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td width="93" align="left" valign="top">&nbsp;</td>
                                  <td width="168" align="right" valign="top"><a href="javascript:FncFichaAccionFotoListar('<?php echo $DatFichaIngresoModalidad->MinSigla?>');"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a></td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td colspan="2" align="left" valign="top">
  <div id="fileuploader<?php echo $DatFichaIngresoModalidad->MinSigla?>">Escoger Archivos</div>
                                    
                                    
                                    <script type="text/javascript">
		$(document).ready(function()
{
	$("#fileuploader<?php echo $DatFichaIngresoModalidad->MinSigla?>").uploadFile({
		
	allowedTypes:"png,gif,jpg,jpeg",
	url:"formularios/FichaAccion/acc/AccFichaAccionSubirFoto2.php",
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
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td colspan="2" align="left" valign="top"><div class="EstCapFichaAccionFotos" id="CapFichaAccion<?php echo $DatFichaIngresoModalidad->MinSigla;?>Fotos"></div></td>
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
                            </div></td>
                          </tr>
                          <tr>
                            <td align="left" valign="top">
                            
                            
                            
                            
                            
                            </td>
                          </tr>
                        </table>
              </div>
                      
                         <?php
						 break;
						 
						  case "LI":
						?>
                        
                     <div class="EstFormularioArea" >
                        <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                                                  
                          <tr>
                            <td align="center"><span class="EstFormularioSubTitulo">LI - Tareas y Productos: <?php echo strtoupper($DatFichaIngresoModalidad->MinNombre);?></span></td>
                          </tr>
                          <tr>
                            <td align="left" valign="top"><div class="EstFormularioArea">
                              <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                                <tr>
                                  <td width="1" align="left" valign="top">&nbsp;</td>
                                  <td colspan="8" align="left" valign="top"><span class="EstFormularioSubTitulo">TAREAS</span>
                                    <input type="hidden" name="Cmp<?php echo $DatFichaIngresoModalidad->MinSigla?>TareaItem" id="Cmp<?php echo $DatFichaIngresoModalidad->MinSigla?>TareaItem" />
                                    <input type="hidden" name="Cmp<?php echo $DatFichaIngresoModalidad->MinSigla?>TareaId" id="Cmp<?php echo $DatFichaIngresoModalidad->MinSigla?>TareaId" /></td>
                                  </tr>
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td width="20" align="left" valign="top"><a href="javascript:FncFichaAccionTareaEliminarTodo('<?php echo $DatFichaIngresoModalidad->MinSigla?>');">
                                    <input type="hidden" name="CmpFichaAccion<?php echo $DatFichaIngresoModalidad->MinSigla?>TareaAccion" id="CmpFichaAccion<?php echo $DatFichaIngresoModalidad->MinSigla?>TareaAccion" value="AccFichaAccionTareaRegistrar.php" />
                                    </a></td>
                                  <td width="132" align="left" valign="top">Descripcion: </td>
                                  <td width="61" align="right" valign="top">&nbsp;</td>
                                  <td width="111" align="right" valign="top">
                                  
                                  
                                  </td>
                                  <td width="20" align="left" valign="top">Actividad:</td>
                                  <td width="20" align="left" valign="top">Costo:</td>
                                  <td width="20" align="left" valign="top">&nbsp;</td>
                                  <td width="20" align="left" valign="top">&nbsp;</td>
                                  </tr>
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td align="left" valign="top"><a href="javascript:FncFichaAccionTareaNuevo('<?php echo $DatFichaIngresoModalidad->MinSigla?>');"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                                  <td colspan="3" align="left" valign="top"><textarea name="Cmp<?php echo $DatFichaIngresoModalidad->MinSigla?>TareaDescripcion" cols="50" class="EstFormularioCaja" id="Cmp<?php echo $DatFichaIngresoModalidad->MinSigla?>TareaDescripcion"></textarea></td>
                                  <td align="left" valign="top"><select class="EstFormularioCombo" name="Cmp<?php echo $DatFichaIngresoModalidad->MinSigla?>TareaAccion" id="Cmp<?php echo $DatFichaIngresoModalidad->MinSigla?>TareaAccion">
                                    <option value="L">Planchado</option>
                                    <option value="N">Pintado</option>
                                    <option value="E">Centrado</option>
                                    <option value="Z">Tarea/Reparacion</option>
                                  </select></td>
                                  <td align="left" valign="top">
                                    
                                    
  <input name="Cmp<?php echo $DatFichaIngresoModalidad->MinSigla?>TareaCosto" type="text" class="EstFormularioCaja" id="Cmp<?php echo $DatFichaIngresoModalidad->MinSigla?>TareaCosto" size="10" maxlength="10" />
                                    
                                    
                                  </td>
                                  <td align="left" valign="top"></td>
                                  <td align="left" valign="top"><a href="javascript:FncFichaAccionTareaGuardar('<?php echo $DatFichaIngresoModalidad->MinSigla?>');"><img src="imagenes/acciones/guardar.png" width="25" height="25" border="0" title="Guardar" alt="[Guardar]" align="absmiddle" /></a></td>
                                  </tr>
                                </table>
                            </div></td>
                          </tr>
                          <tr>
                            <td align="left" valign="top">
                          
                            
                            <div class="EstFormularioArea" >
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
                                  <td colspan="2" align="left" valign="top"><div id="CapFichaAccion<?php echo $DatFichaIngresoModalidad->MinSigla?>Tareas" class="EstCapFichaAccionTareas" > </div></td>
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
                              <?php
							/*
							?>

<div class="EstFormularioArea">
                                <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                                  <tr>
                                    <td>&nbsp;</td>
                                    <td colspan="10"><span class="EstFormularioSubTitulo">PRODUCTOS </span><span class="EstFormularioSubTitulo">
                                      <input type="hidden" name="Cmp<?php echo $DatFichaIngresoModalidad->MinSigla?>ProductoUnidadMedida" id="Cmp<?php echo $DatFichaIngresoModalidad->MinSigla?>ProductoUnidadMedida" value="" />
                                      <input type="hidden" name="Cmp<?php echo $DatFichaIngresoModalidad->MinSigla?>ProductoUnidadMedidaEquivalente"   id="Cmp<?php echo $DatFichaIngresoModalidad->MinSigla?>ProductoUnidadMedidaEquivalente" value=""  />
                                      <input type="hidden" name="Cmp<?php echo $DatFichaIngresoModalidad->MinSigla?>ProductoId"    id="Cmp<?php echo $DatFichaIngresoModalidad->MinSigla?>ProductoId" value=""   />
                                      <input type="hidden" name="Cmp<?php echo $DatFichaIngresoModalidad->MinSigla?>ProductoItem" id="Cmp<?php echo $DatFichaIngresoModalidad->MinSigla?>ProductoItem" value="" />
                                      <input type="hidden" name="CmpFichaAccion<?php echo $DatFichaIngresoModalidad->MinSigla?>ProductoId"  class="EstFormularioCaja" id="CmpFichaAccion<?php echo $DatFichaIngresoModalidad->MinSigla?>ProductoId" value=""  />
                                    </span></td>
                                  </tr>
                                  <tr>
                                    <td>&nbsp;</td>
                                    <td><input type="hidden" name="CmpFichaAccion<?php echo $DatFichaIngresoModalidad->MinSigla?>ProductoAccion" id="CmpFichaAccion<?php echo $DatFichaIngresoModalidad->MinSigla?>ProductoAccion" value="AccFichaAccionProductoRegistrar.php" /></td>
                                    <td>C&oacute;digo Orig.</td>
                                    <td>&nbsp;</td>
                                    <td>C&oacute;digo Alt.</td>
                                    <td>&nbsp;</td>
                                    <td>Nombre : </td>
                                    <td>U.M. </td>
                                    <td>Cantidad:</td>
                                    <td><div id="Cap<?php echo $DatFichaIngresoModalidad->MinSigla?>ProductoBuscar"></div></td>
                                    <td>&nbsp;</td>
                                  </tr>
                                  <tr>
                                    <td>&nbsp;</td>
                                    <td><a href="javascript:FncFichaAccionProductoNuevo('<?php echo $DatFichaIngresoModalidad->MinSigla?>');"><img src="imagenes/acciones/limpiar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                                    <td><input name="Cmp<?php echo $DatFichaIngresoModalidad->MinSigla?>ProductoCodigoOriginal"  type="text" class="EstFormularioCaja" id="Cmp<?php echo $DatFichaIngresoModalidad->MinSigla?>ProductoCodigoOriginal" size="10" maxlength="20" /></td>
                                    <td><a href="javascript:FncProductoBuscar('CodigoOriginal','<?php echo $DatFichaIngresoModalidad->MinSigla?>');"><img src="imagenes/acciones/buscar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                                    <td><input name="Cmp<?php echo $DatFichaIngresoModalidad->MinSigla?>ProductoCodigoAlternativo"  type="text" class="EstFormularioCaja" id="Cmp<?php echo $DatFichaIngresoModalidad->MinSigla?>ProductoCodigoAlternativo" size="10" maxlength="20" /></td>
                                    <td><a href="javascript:FncProductoBuscar('CodigoAlternativo','<?php echo $DatFichaIngresoModalidad->MinSigla?>');"><img src="imagenes/acciones/buscar.png" width="25" height="25" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                                    <td><input name="Cmp<?php echo $DatFichaIngresoModalidad->MinSigla?>ProductoNombre" type="text" class="EstFormularioCaja" id="Cmp<?php echo $DatFichaIngresoModalidad->MinSigla?>ProductoNombre" size="40" /></td>
                                    <td><select  class="EstFormularioCombo" name="Cmp<?php echo $DatFichaIngresoModalidad->MinSigla?>ProductoUnidadMedidaConvertir" id="Cmp<?php echo $DatFichaIngresoModalidad->MinSigla?>ProductoUnidadMedidaConvertir">
                                    </select></td>
                                    <td><input name="Cmp<?php echo $DatFichaIngresoModalidad->MinSigla?>ProductoCantidad" type="text" class="EstFormularioCaja" id="Cmp<?php echo $DatFichaIngresoModalidad->MinSigla?>ProductoCantidad" size="10" maxlength="10"  /></td>
                                    <td><a href="javascript:FncFichaAccionProductoGuardar('<?php echo $DatFichaIngresoModalidad->MinSigla?>');"><img src="imagenes/acciones/guardar.png" width="25" height="25" border="0" title="Guardar" alt="[Guardar]" align="absmiddle" /></a></td>
                                    <td><a href="comunes/Producto/FrmProductoBuscar.php?height=440&amp;width=850&amp;Modalidad=<?php echo $DatFichaIngresoModalidad->MinSigla?>" class="thickbox" title=""><img src="imagenes/acciones/buscador.png" width="25" height="25" border="0" align="absmiddle" ></a></td>
                                  </tr>
                                </table>
                              </div>
                              
                              <?php
					 */
							  ?>
                            
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
                            <td align="left" valign="top">
                            
                            
                            <div class="EstFormularioArea" >
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
                                    <td colspan="2"><div id="CapFichaAccion<?php echo $DatFichaIngresoModalidad->MinSigla?>Productos" class="EstCapFichaAccionProductos" ></div></td>
                                    <td>&nbsp;</td>
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
                            <td align="left" valign="top"><div class="EstFormularioArea" >
                              <table border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td align="left" valign="top"><span class="EstFormularioSubTitulo">Pedidos</span></td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td align="left" valign="top"><script type="text/javascript">

tinymce.init({
	selector: "textarea#CmpFichaAccionPedido_<?php echo $DatFichaIngresoModalidad->MinSigla?>",
	theme: "modern",
	menubar : false,
	toolbar1: "bold italic | bullist numlist",
width : 830,
	height : 80
});

                            </script>
                                    <textarea name="CmpFichaAccionPedido_<?php echo $DatFichaIngresoModalidad->MinSigla?>" cols="60" rows="2" class="EstFormularioCaja" id="CmpFichaAccionPedido_<?php echo $DatFichaIngresoModalidad->MinSigla?>"><?php echo stripslashes($FichaAccionPedido);?></textarea>
                                    
                                    
                                    <input type="hidden" name="CmpFichaAccionPedido_<?php echo $DatFichaIngresoModalidad->MinSigla?>2" id="CmpFichaAccionPedido_<?php echo $DatFichaIngresoModalidad->MinSigla?>2" value="<?php echo stripslashes($FichaAccionPedido);?>" >
                                    
                                    </td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td align="left" valign="top"><span class="EstFormularioNota">* Pedidos adicionales a almacen </span></td>
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
                                  <td colspan="2" align="left" valign="top">
                                    
                                    <span class="EstFormularioSubTitulo">Fotos</span>
                                    
                                    <a href="javascript:FncFichaAccionFotoListar('<?php echo $DatFichaIngresoModalidad->MinSigla?>');"></a>                                  </td>
                                  <td width="4" align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td width="93" align="left" valign="top">&nbsp;</td>
                                  <td width="168" align="right" valign="top"><a href="javascript:FncFichaAccionFotoListar('<?php echo $DatFichaIngresoModalidad->MinSigla?>');"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a></td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td colspan="2" align="left" valign="top">
  <div id="fileuploader<?php echo $DatFichaIngresoModalidad->MinSigla?>">Escoger Archivos</div>
                                    
                                    
                                    <script type="text/javascript">
		$(document).ready(function()
{
	$("#fileuploader<?php echo $DatFichaIngresoModalidad->MinSigla?>").uploadFile({
		
	allowedTypes:"png,gif,jpg,jpeg",
	url:"formularios/FichaAccion/acc/AccFichaAccionSubirFoto2.php",
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
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td colspan="2" align="left" valign="top"><div class="EstCapFichaAccionFotos" id="CapFichaAccion<?php echo $DatFichaIngresoModalidad->MinSigla;?>Fotos"></div></td>
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

                            </div></td>
                          </tr>
                          <tr>
                            <td align="left" valign="top">
                            
                            
                            
                            
                            
                            </td>
                          </tr>
                        </table>
              </div>
                      
                         <?php
						 break;
						 
						case "PP":
						?>

                     <div class="EstFormularioArea" >
                        <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                          

                          
                          
                          <tr>
                            <td align="center"><span class="EstFormularioSubTitulo">PP - Tareas y Productos: <?php echo strtoupper($DatFichaIngresoModalidad->MinNombre);?></span></td>
                          </tr>
                          <tr>
                            <td align="left" valign="top"><div class="EstFormularioArea">
                              <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                                <tr>
                                  <td width="4" align="left" valign="top">&nbsp;</td>
                                  <td width="344" align="left" valign="top"><span class="EstFormularioSubTitulo">TAREAS</span></td>
                                  <td width="5" align="left" valign="top">&nbsp;</td>
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
                                  <td width="48%" align="right" valign="top"><a href="javascript:FncFichaAccionTareaListar('<?php echo $DatFichaIngresoModalidad->MinSigla?>');"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a> <a href="javascript:FncFichaAccionTareaEliminarTodo('<?php echo $DatFichaIngresoModalidad->MinSigla?>');"></a></td>
                                  <td align="left" valign="top"><div id="CapFichaAccionTareasResultado"> </div></td>
                                </tr>
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td colspan="2" align="left" valign="top"><div id="CapFichaAccion<?php echo $DatFichaIngresoModalidad->MinSigla?>Tareas" class="EstCapFichaAccionTareas" > </div></td>
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
                                    <td width="47%" align="right"><a href="javascript:FncFichaAccionProductoListar('<?php echo $DatFichaIngresoModalidad->MinSigla?>');"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a> <a href="javascript:FncFichaAccionProductoEliminarTodo('<?php echo $DatFichaIngresoModalidad->MinSigla?>');"></a></td>
                                    <td><div id="CapFichaAccion<?php echo $DatFichaIngresoModalidad->MinSigla?>ProductosResultado"> </div></td>
                                  </tr>
                                  <tr>
                                    <td>&nbsp;</td>
                                    <td colspan="2"><div id="CapFichaAccion<?php echo $DatFichaIngresoModalidad->MinSigla?>Productos" class="EstCapFichaAccionProductos" ></div></td>
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
                            <td align="left" valign="top"><div class="EstFormularioArea" >
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
                                  
                             

          
   <div class="EstFormularioCajaObservacion">
        <?php echo stripslashes($FichaAccionCausa);?>
        </div>
          
        <input type="hidden" name="CmpFichaAccionCausa_<?php echo $DatFichaIngresoModalidad->MinSigla?>" id="CmpFichaAccionCausa_<?php echo $DatFichaIngresoModalidad->MinSigla?>" value="<?php echo stripslashes($FichaAccionCausa);?>" />
          
          
   
          
          
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
                            </div></td>
                          </tr>
                          <tr>
                            <td align="left" valign="top"><div class="EstFormularioArea" >
                              <table border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td align="left" valign="top">
                                    
                                   
<span class="EstFormularioSubTitulo">Solucion al Problema</span>
                                    
                                    
                                  </td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td align="left" valign="top">
                                  
                             

          
<div class="EstFormularioCajaObservacion">
<?php echo stripslashes($FichaAccionSolucion);?>
</div>

<input type="hidden" name="CmpFichaAccionSolucion_<?php echo $DatFichaIngresoModalidad->MinSigla?>" id="CmpFichaAccionSolucion_<?php echo $DatFichaIngresoModalidad->MinSigla?>" value="<?php echo stripslashes($FichaAccionSolucion);?>" />


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
                                            <td><a href="javascript:FncProveedorNuevo();"></a></td>
                                            <td><input name="CmpProveedorNombre" type="text" class="EstFormularioCaja" id="CmpProveedorNombre" value="<?php echo $FichaAccionSalidaExternaProveedorNombreCompleto;?>" size="45" maxlength="255" readonly="readonly" <?php if(!empty($FichaAccionSalidaExternaProveedorId)){ echo 'readonly="readonly"';} ?>  /></td>
                                            <td>&nbsp;</td>
                                          </tr>
                                          </table>
                                        </td>
                                        <td align="left" valign="top">Tipo Doc.:
                                          <input name="CmpProveedorId" type="hidden" id="CmpProveedorId" value="<?php echo $FichaAccionSalidaExternaProveedorId;?>" size="3" /></td>
                                        <td align="left" valign="top"><select disabled="disabled"  class="EstFormularioCombo" name="CmpProveedorTipoDocumento" id="CmpProveedorTipoDocumento">
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
                                            <td><a href="javascript:FncProveedorNuevo();"></a></td>
                                            <td><input name="CmpProveedorNumeroDocumento" type="text" class="EstFormularioCaja" id="CmpProveedorNumeroDocumento"  value="<?php echo $FichaAccionSalidaExternaProveedorNumeroDocumento;?>" size="20" maxlength="50" readonly="readonly" <?php if(!empty($FichaAccionSalidaExternaProveedorId)){ echo 'readonly="readonly"';} ?> /></td>
                                            <td><a href="javascript:FncProveedorBuscar('NumeroDocumento');"></a></td>
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
                                        <td align="left" valign="top"><input name="CmpSalidaExternaFechaSalida" type="text" class="EstFormularioCajaFecha" id="CmpSalidaExternaFechaSalida" value="<?php  echo $FichaAccionSalidaExternaFechaSalida; ?>" size="15" maxlength="10" readonly="readonly" /></td>
                                        <td align="left" valign="top">Fecha de Finalizacion:<br />
                                          <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
                                        <td align="left" valign="top"><input name="CmpSalidaExternaFechaFinalizacion" type="text" class="EstFormularioCajaFecha" id="CmpSalidaExternaFechaFinalizacion" value="<?php  echo $FichaAccionSalidaExternaFechaFinalizacion;?>" size="15" maxlength="10" readonly="readonly" /></td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                      </tr>
                                      <tr>
                                        <td>&nbsp;</td>
                                        <td align="left" valign="top">Num. Comprobante:</td>
                                        <td align="left" valign="top"><input name="CmpComprobanteNumero" type="text" class="EstFormularioCaja" id="CmpComprobanteNumero" value="<?php echo $FichaAccionComprobanteNumero;?>" size="20" maxlength="20" readonly="readonly" /></td>
                                        <td>Fecha de Comprobante:<br />
                                          <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
                                        <td><input name="CmpComprobanteFecha" type="text" class="EstFormularioCajaFecha" id="CmpComprobanteFecha" value="<?php  echo $FichaAccionComprobanteFecha; ?>" size="15" maxlength="10" readonly="readonly" /></td>
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
                          
                          
    <?php
					//	  if($DatFichaIngresoModalidad->MinSigla == "GA" || $DatFichaIngresoModalidad->MinSigla == "CA" || $DatFichaIngresoModalidad->MinSigla == "PO" || $DatFichaIngresoModalidad->MinSigla == "IF"){
						?>                       
                          <?php
	//					  }
?>
                          
                          
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
                                  <td colspan="2" align="left" valign="top">
  <div id="fileuploader<?php echo $DatFichaIngresoModalidad->MinSigla?>">Escoger Archivos</div>
                                    
                                    
                                    <script type="text/javascript">
		$(document).ready(function()
{
	$("#fileuploader<?php echo $DatFichaIngresoModalidad->MinSigla?>").uploadFile({
		
	allowedTypes:"png,gif,jpg,jpeg",
	url:"formularios/FichaAccion/acc/AccFichaAccionSubirFoto2.php",
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
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td colspan="2" align="left" valign="top"><div class="EstCapFichaAccionFotos" id="CapFichaAccion<?php echo $DatFichaIngresoModalidad->MinSigla;?>Fotos"></div></td>
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
	      <td><span class="EstFormularioSubTitulo">Observaciones de Taller</span></td>
	      <td>&nbsp;</td>
	      </tr>
	    <tr>
	      <td>&nbsp;</td>
	      <td align="left" valign="top">
	        
	        <script type="text/javascript">


tinymce.init({
	selector: "textarea#CmpObservacionSalida",
	theme: "modern",
	menubar : false,
	toolbar1: "bold italic | bullist numlist",
	width : 700,
	height : 180
});

</script>
	        
	        <textarea name="CmpObservacionSalida" cols="60" rows="2" class="EstFormularioCaja" id="CmpObservacionSalida"><?php echo stripslashes($InsFichaIngreso->FinSalidaObservacion);?></textarea></td>
	      <td align="left" valign="top">&nbsp;</td>
	      </tr>
	    <tr>
	      <td>&nbsp;</td>
	      <td align="left" valign="top"><span class="EstFormularioSubTitulo">Observaciones Internas</span></td>
	      <td align="left" valign="top">&nbsp;</td>
	      </tr>
	    <tr>
	      <td>&nbsp;</td>
	      <td align="left" valign="top"><script type="text/javascript">


tinymce.init({
	selector: "textarea#CmpObservacionSalidaInterna",
	theme: "modern",
	menubar : false,
	toolbar1: "bold italic | bullist numlist",
	width : 700,
	height : 180
});

          </script>
	        <textarea name="CmpObservacionSalidaInterna" cols="60" rows="2" class="EstFormularioCaja" id="CmpObservacionSalidaInterna"><?php echo stripslashes($InsFichaIngreso->FinSalidaObservacionInterna);?></textarea></td>
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
                    <tr>
                      <td><span class="EstFormularioSubTitulo">Cotizaciones</span></td>
                    </tr>
                    <tr>
                      <td><div class="EstFormularioArea" >
                        <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                          <tr>
                            <td width="3%">&nbsp;</td>
                            <td width="47%"><div class="EstFormularioAccion" id="CapFichaAccionCotizacionesAccion">Listo
                              para registrar elementos</div></td>
                            <td width="49%" align="right"><a href="javascript:FncFichaAccionCotizacionesListar();"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a></td>
                            <td width="1%"><div id="CapFichaAccionCotizacionesResultado"> </div></td>
                            </tr>
                          <tr>
                            <td>&nbsp;</td>
                            <td colspan="2"><div id="CapFichaAccionCotizaciones" class="EstCapFichaAccionCotizaciones" > </div></td>
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
                                  <td align="left" valign="top">
<div id="fileuploaderVIN">Escoger Archivos</div>

        
<script type="text/javascript">
	$(document).ready(function()
	{
		
		$("#fileuploaderVIN").uploadFile({
			
		allowedTypes:"png,gif,jpg,jpeg",
		url:"formularios/FichaAccion/acc/AccFichaAccionSubirFotoVIN.php",
		formData: {"Identificador":"<?php echo $Identificador;?>"},
		multiple:false,
		autoSubmit:true,
		fileName:"FiledataVIN",
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
			FncFichaAccionFotoVINListar();
		}
	
	});
});
              
            </script>
				

                                    
                                  </td>
                                  <td align="left" valign="top"><div class="EstCapFichaAccionFotoVINs" id="CapFichaAccionFotoVINs"></div></td>
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
                            <td width="96%" colspan="2"><iframe src="formularios/FichaAccion/acc/AccFichaAccionSubirFotoVIN.php?Identificador=<?php echo $Identificador;?>" id="IfrFichaAccionSubirFotoVin" name="IfrFichaAccionSubirFotoVin" scrolling="Auto"  frameborder="0" width="600" height="140"></iframe></td>
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
                                  <td align="left" valign="top">
<div id="fileuploaderDelantera">Escoger Archivos</div>

        
<script type="text/javascript">
	$(document).ready(function()
	{
		
		$("#fileuploaderDelantera").uploadFile({
			
		allowedTypes:"png,gif,jpg,jpeg",
		url:"formularios/FichaAccion/acc/AccFichaAccionSubirFotoDelantera.php",
		formData: {"Identificador":"<?php echo $Identificador;?>"},
		multiple:false,
		autoSubmit:true,
		fileName:"FiledataDelantera",
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
			FncFichaAccionFotoDelanteraListar();
		}
	
	});
});
              
            </script>
				

                                    
                                  </td>
								<td align="left" valign="top"><div class="EstCapFichaAccionFotoDelanteras" id="CapFichaAccionFotoDelanteras"></div></td>
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
                            <td width="96%" colspan="2"><iframe src="formularios/FichaAccion/acc/AccFichaAccionSubirFotoDelantera.php?Identificador=<?php echo $Identificador;?>" id="IfrFichaAccionSubirFotoDelantera" name="IfrFichaAccionSubirFotoDelantera" scrolling="Auto"  frameborder="0" width="600" height="140"></iframe></td>
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
                            <td align="left" valign="top"><div id="fileuploaderCupon">Escoger Archivos</div>
                              <script type="text/javascript">
	$(document).ready(function()
	{
		
		$("#fileuploaderCupon").uploadFile({
			
		allowedTypes:"png,gif,jpg,jpeg",
		url:"formularios/FichaAccion/acc/AccFichaAccionSubirFotoCupon.php",
		formData: {"Identificador":"<?php echo $Identificador;?>"},
		multiple:false,
		autoSubmit:true,
		fileName:"FiledataCupon",
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
			FncFichaAccionFotoCuponListar();
		}
	
	});
});
              
                      </script></td>
                            <td align="left" valign="top"><div class="EstCapFichaAccionFotoCupones" id="CapFichaAccionFotoCupones"></div></td>
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
                            <td align="left" valign="top"><div id="fileuploaderMantenimiento">Escoger Archivos</div>
                              <script type="text/javascript">
	$(document).ready(function()
	{
		
		$("#fileuploaderMantenimiento").uploadFile({
			
		allowedTypes:"png,gif,jpg,jpeg",
		url:"formularios/FichaAccion/acc/AccFichaAccionSubirFotoMantenimiento.php",
		formData: {"Identificador":"<?php echo $Identificador;?>"},
		multiple:false,
		autoSubmit:true,
		fileName:"FiledataMantenimiento",
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
			FncFichaAccionFotoMantenimientoListar();
		}
	
	});
});
              
                      </script></td>
                            <td align="left" valign="top"><div class="EstCapFichaAccionFotoMantenimientos" id="CapFichaAccionFotoMantenimientos"></div></td>
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
	      <td><span class="EstFormularioSubTitulo"> OBSERVACIONES DE ALMACEN</span></td>
	      <td width="4">&nbsp;</td>
	      </tr>
	    <tr>
	      <td>&nbsp;</td>
	      <td width="196" align="left" valign="top">&nbsp;</td>
	      <td align="left" valign="top">&nbsp;</td>
	      </tr>
	    <tr>
	      <td>&nbsp;</td>
	      <td align="left" valign="top">
	        
	        <div class="EstFormularioCajaObservacion">
	          <?php echo stripslashes($InsFichaIngreso->FinAlmacenObservacion);?>
	          </div>
	        
	        <input type="hidden" name="CmpObservacionAlmaccen" id="CmpObservacionAlmacen" value="<?php echo stripslashes($InsFichaIngreso->FinAlmacenObservacion);?>" />
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
    
    
    

</div>    		 
		
        
        
        
          
       

           
  
        
        
        
        
        </td>
      </tr>
      
      <tr>
        <td colspan="2" align="center">&nbsp;</td>
      </tr>
    </table>
</div>

	
	
	
    
       


     
</form>
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