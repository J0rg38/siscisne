<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>

<?php //$PrivilegioVistaPreliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"VistaPreliminar"))?true:false;?>
<?php //$PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Imprimir"))?true:false;?>
<?php $PrivilegioEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar"))?true:false;?>

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
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssPreEntrega.css');
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssFichaAccion.css');
@import url('<?php echo $InsProyecto->MtdFormulariosCss("PlanMantenimiento");?>CssPlanMantenimiento.css');
</style>

<?php
$GET_Id = $_GET['Id'];

$Registro = false;

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

$ArrFichaAccion = null;	
$ArrFichaAccion = array();

$ResModalidadIngreso = $InsModalidadIngreso->MtdObtenerModalidadIngresos(NULL,NULL,'MinId','ASC',NULL,"1,3");
$ArrModalidadIngresos = $ResModalidadIngreso['Datos'];

	if (!isset($_SESSION['InsPreEntregaDetalle'.$Identificador])){	
		$_SESSION['InsPreEntregaDetalle'.$Identificador] = new ClsSesionObjeto();
	}else{	
		$_SESSION['InsPreEntregaDetalle'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsPreEntregaDetalle'.$Identificador]);
	}
	
if(!empty($InsFichaIngreso->FichaIngresoModalidad)){
	foreach($InsFichaIngreso->FichaIngresoModalidad as $DatFichaIngresoModalidad){
		
//if(!empty($ArrModalidadIngresos)){
//	foreach($ArrModalidadIngresos as $DatModalidadIngreso){

		if (!isset($_SESSION['InsFichaAccionTarea'.$DatModalidadIngreso->MinSigla.$Identificador])){	
			$_SESSION['InsFichaAccionTarea'.$DatModalidadIngreso->MinSigla.$Identificador] = new ClsSesionObjeto();
		}else{	
			$_SESSION['InsFichaAccionTarea'.$DatModalidadIngreso->MinSigla.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsFichaAccionTarea'.$DatModalidadIngreso->MinSigla.$Identificador]);
		}
		
		if (!isset($_SESSION['InsFichaAccionTempario'.$DatModalidadIngreso->MinSigla.$Identificador])){	
			$_SESSION['InsFichaAccionTempario'.$DatModalidadIngreso->MinSigla.$Identificador] = new ClsSesionObjeto();
		}else{	
			$_SESSION['InsFichaAccionTempario'.$DatModalidadIngreso->MinSigla.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsFichaAccionTempario'.$DatModalidadIngreso->MinSigla.$Identificador]);
		}		

		if (!isset($_SESSION['InsFichaAccionProducto'.$DatModalidadIngreso->MinSigla.$Identificador])){	
			$_SESSION['InsFichaAccionProducto'.$DatModalidadIngreso->MinSigla.$Identificador] = new ClsSesionObjeto();
		}else{	
			$_SESSION['InsFichaAccionProducto'.$DatModalidadIngreso->MinSigla.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsFichaAccionProducto'.$DatModalidadIngreso->MinSigla.$Identificador]);
		}
		
		if (!isset($_SESSION['InsFichaAccionMantenimiento'.$DatModalidadIngreso->MinSigla.$Identificador])){	
			$_SESSION['InsFichaAccionMantenimiento'.$DatModalidadIngreso->MinSigla.$Identificador] = new ClsSesionObjeto();
		}else{	
			$_SESSION['InsFichaAccionMantenimiento'.$DatModalidadIngreso->MinSigla.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsFichaAccionMantenimiento'.$DatModalidadIngreso->MinSigla.$Identificador]);
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
	$_SESSION['InsFichaAccionHerramienta'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsFichaAccionMantenimiento'.$Identificador]);
}
		
$RepPlanMantenimientoSeccion = $InsPlanMantenimientoSeccion->MtdObtenerPlanMantenimientoSecciones(NULL,NULL,"PmsId","ASC",NULL);
$ArrPlanMantenimientoSecciones = $RepPlanMantenimientoSeccion['Datos'];

include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccFichaAccionEditar.php');

$RepTipoDocumento = $InsTipoDocumento->MtdObtenerTipoDocumentos(NULL,NULL,"TdoId","ASC",NULL);
$ArrTipoDocumentos = $RepTipoDocumento['Datos'];

$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","ASC",NULL,1);
$ArrMonedas = $ResMoneda['Datos'];

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

	//$('#CmpFecha').focus();	
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
	
//	$('input[type=checkbox]').each(function () {
//		if($(this).attr('etiqueta')=="modalidad"){
//			FncFichaAccionProductoListar($(this).attr('sigla'));
//			FncFichaAccionProductoListar2($(this).attr('sigla'));
//		}			 
//	});
		
});

/*
Configuracion Formulario
*/

var FichaAccionTareaEditar = 2;
var FichaAccionTareaEliminar = 2;

var FichaAccionFotoEditar = 2;
var FichaAccionFotoEliminar = 2;

var FichaAccionTemparioEditar = 2;
var FichaAccionTemparioEliminar = 2;

var FichaAccionProductoEditar = 2;
var FichaAccionProductoEliminar = 2;

var FichaAccionSuministroEditar = 2;//CAMBIO DE 1 A 2
var FichaAccionSuministroEliminar = 2;

var FichaAccionMantenimientoEditar = 2;
var FichaAccionMantenimientoEliminar = 2;

var FichaAccionHerramientaEditar = 2;
var FichaAccionHerramientaEliminar = 2;

var FichaAccionRecibirMantenimientoEditar = 2;

var PreEntregaDetalleEditar = 2;
var PreEntregaDetalleEliminar = 2; 


var FichaAccionFotoVINEliminar = 2;
var FichaAccionFotoDelanteraEliminar = 2;
var FichaAccionFotoCuponEliminar = 2;
var FichaAccionFotoMantenimientoEliminar = 2;

</script>

<div class="EstCapMenu">

	<?php
    /*if($PrivilegioVistaPreliminar){
    ?>
    <div class="EstSubMenuBoton"><a href="javascript:FncVistaPreliminar('<?php echo $InsFichaAccion->FccId;?>');"><img src="imagenes/iconos/preliminar.png" alt="[Vista Preliminar]" title="Vista preliminar" />V.P.</a></div>
    <?php
    }
    ?>
	<?php
    if($PrivilegioImprimir){
    ?>
    <div class="EstSubMenuBoton"><a href="javascript:FncImprmir('<?php echo $InsFichaAccion->FccId;?>');"><img src="imagenes/iconos/imprimir.png" alt="[Imprimir]" title="Imprimir"  />Imprimir</a></div>
    <?php
    }*/
    ?>
              	<?php
			if($PrivilegioEditar and ($InsFichaIngreso->FinEstado == 2 or $InsFichaIngreso->FinEstado == 3)){
			?>           
             
             <div class="EstSubMenuBoton"><a href="principal<?php echo (!empty($GET_dia)?'2':'');?>.php?Mod=<?php echo $GET_mod;?>&Form=Editar<?php echo (!empty($GET_dia)?'&Dia=1':'');?>&Id=<?php echo $InsFichaIngreso->FinId;?>"><img src="imagenes/iconos/editar.png" alt="[Editar]" title="Editar" />Editar</a></div>
             <?php
			}
			?>   
                        
</div>

<div class="EstCapContenido">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
      
      <tr>
        <td width="1922" height="25" colspan="2"><span class="EstFormularioTitulo">VER ORDEN DE TRABAJO (TALLER)</span></td>
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
        <input name="CmpFichaIngresoMantenimientoKilometraje" type="hidden" class="EstFormularioCaja" id="CmpFichaIngresoMantenimientoKilometraje" value="<?php echo $InsFichaIngreso->FinMantenimientoKilometraje;?>"  />
        <input name="CmpFichaIngresoEstado" type="hidden" class="EstFormularioCaja" id="CmpFichaIngresoEstado" value="<?php echo $InsFichaIngreso->FinEstado;?>"  />
        <input name="CmpVehiculoIngresoMarcaId" type="hidden" class="EstFormularioCaja" id="CmpVehiculoIngresoMarcaId" value="<?php echo $InsFichaIngreso->VmaId;?>"  />
        <input name="CmpVehiculoIngresoModeloId" type="hidden" class="EstFormularioCaja" id="CmpVehiculoIngresoModeloId" value="<?php echo $InsFichaIngreso->VmoId;?>"  />
        <input name="CmpVehiculoIngresoVersionId" type="hidden" class="EstFormularioCaja" id="CmpVehiculoIngresoVersionId" value="<?php echo $InsFichaIngreso->VveId;?>"  />
        <input name="CmpVehiculoIngresoAnoFabricacion" type="hidden" class="EstFormularioCaja" id="CmpVehiculoIngresoAnoFabricacion" value="<?php echo $InsFichaIngreso->EinAnoFabricacion;?>"  />
        

<input name="CmpFichaIngresoTipo" type="hidden" class="EstFormularioCaja" id="CmpFichaIngresoTipo" value="<?php echo $InsFichaIngreso->FinTipo;?>"  />

     
<input name="CmpFichaIngresoIndicacionTecnico" type="hidden" class="EstFormularioCaja" id="CmpFichaIngresoIndicacionTecnico" value="<?php echo $InsFichaIngreso->FinIndicacionTecnico;?>"  />

         
         
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
      <td align="left" valign="top">Monto Presupuestado:</td>
      <td align="left" valign="top"><input name="CmpMontoPresupuesto" type="text" class="EstFormularioCaja" id="CmpMontoPresupuesto" value="<?php echo number_format($InsFichaIngreso->FinMontoPresupuesto,2);?>" size="10" maxlength="10" readonly="readonly"  /></td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="5" align="left" valign="top">OPCIONES ADICIONALES</td>
      <td colspan="6" align="left" valign="top"><span class="EstFormularioSubTitulo">TIEMPO DE TRABAJO</span></td>
      </tr>
    <tr>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
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
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
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
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
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
    
    
  </table>
</div>  
<br />

          
          
          <?php
		  ?>
<ul class="tabs">


 
	<?php
	$c=2;
	//foreach($InsFichaIngreso->FichaIngresoModalidad as $DatFichaIngresoModalidad){
	foreach($InsFichaIngreso->FichaIngresoModalidad as $DatFichaIngresoModalidad){
	//foreach($ArrFichaAccion as $DatFichaIngresoModalidad){
    ?>
		<li><a href="#tab<?php echo $c;?>"><?php echo $DatFichaIngresoModalidad->MinNombre;?></a></li>
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
	//foreach($InsFichaIngreso->FichaIngresoModalidad as $DatFichaIngresoModalidad){
	//foreach($ArrFichaAccion as $DatFichaIngresoModalidad){
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
			
			
			
//
//						$FichaAccionId = $DatFichaIngresoModalidad->FccId;
//						$FichaAccionFecha = $DatFichaIngresoModalidad->FccFecha;
//						$FichaAccionObservacion = $DatFichaIngresoModalidad->FccObservacion;
//						$FichaIngresoModalidadId = $DatFichaIngresoModalidad->FimId;
                      
                   
	//	deb($DatFichaIngresoModalidad);
	?>

	<div id="tab<?php echo $c;?>" class="tab_content">

                    <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                    <tr>
                      <td colspan="4">
                      
                      <div class="EstFormularioArea">
                        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                          <tr>
                            <td>&nbsp;</td>
                            <td colspan="2"><span class="EstFormularioSubTitulo">Datos de la MODALIDAD de ORDEN DE TRABAJO: <?php echo strtoupper($DatFichaIngresoModalidad->MinNombre);?>
                              
                            </span></td>
                            <td>&nbsp;</td>
                          </tr>
                          <tr>
                            <td>&nbsp;</td>
                            <td align="left" valign="top">

<input style="visibility:hidden;" etiqueta="modalidad" checked="checked"  type="checkbox" value="<?php echo $DatFichaIngresoModalidad->MinId?>" name="CmpModalidadId_<?php echo $DatFichaIngresoModalidad->MinSigla?>" id="CmpModalidadId_<?php echo $DatFichaIngresoModalidad->MinSigla?>" sigla="<?php echo $DatFichaIngresoModalidad->MinSigla?>" />
							
                            </td>
                            <td align="left" valign="top"><input name="CmpFecha_<?php echo $DatFichaIngresoModalidad->MinSigla?>" type="hidden" id="CmpFecha_<?php echo $DatFichaIngresoModalidad->MinSigla?>" value="<?php echo $DatFichaIngresoModalidad->FccFecha;?>" />
                              <input name="CmpObservacion_<?php echo $DatFichaIngresoModalidad->MinSigla?>" type="hidden" id="CmpObservacion_<?php echo $DatFichaIngresoModalidad->MinSigla?>" value="<?php echo $DatFichaIngresoModalidad->FccObservacion;?>" />
                              <input name="CmpModalidadIngresoSigla_<?php echo $DatFichaIngresoModalidad->MinSigla?>" type="hidden" id="CmpModalidadIngresoSigla_<?php echo $DatFichaIngresoModalidad->MinSigla?>" value="<?php echo $DatFichaIngresoModalidad->MinSigla?>" />
                              <input name="CmpModalidadIngresoNombre_<?php echo $DatFichaIngresoModalidad->MinSigla?>" type="hidden" id="CmpModalidadIngresoNombre_<?php echo $DatFichaIngresoModalidad->MinSigla?>" value="<?php echo $DatFichaIngresoModalidad->MinNombre;?>" />
                              <input name="CmpModalidadIngresoId_<?php echo $DatFichaIngresoModalidad->MinSigla?>" type="hidden" id="CmpModalidadIngresoId_<?php echo $DatFichaIngresoModalidad->MinSigla?>" value="<?php echo $DatFichaIngresoModalidad->MinId;?>" />
                            <input name="CmpId_<?php echo $DatFichaIngresoModalidad->MinSigla?>" type="hidden" class="EstFormularioCaja" id="CmpId_<?php echo $DatFichaIngresoModalidad->MinSigla?>" value="<?php echo $DatFichaIngresoModalidad->FccId;?>" size="15" maxlength="20" readonly="readonly" />
                            
                            
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
                            <td colspan="3" align="left"><?php
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
                            <td colspan="3" align="left"><div class="EstFormularioArea" >
                              <table border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td colspan="2" align="left" valign="top"><span class="EstFormularioSubTitulo">TEMPARIO</span></td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td align="left" valign="top"><div class="EstFormularioAccion" id="CapTemparioAccion">Listo
                                    para registrar elementos<a href="javascript:FncFichaAccionTemparioEliminarTodo('<?php echo $DatFichaIngresoModalidad->MinSigla?>');"></a></div></td>
                                  <td align="right" valign="top"><a href="javascript:FncFichaAccionTemparioListar('<?php echo $DatFichaIngresoModalidad->MinSigla?>');"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a> <a href="javascript:FncFichaAccionTemparioEliminarTodo('<?php echo $DatFichaIngresoModalidad->MinSigla?>');"></a></td>
                                  <td align="left" valign="top"><div id="CapFichaAccionTempariosResultado"> </div></td>
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
                            <td align="left" valign="top"><div class="EstFormularioArea">
                              <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                                <tr>
                                  <td width="4" align="left" valign="top">&nbsp;</td>
                                  <td width="344" align="left" valign="top"><span class="EstFormularioSubTitulo">TAREAS</span></td>
                                  <td width="5" align="left" valign="top">&nbsp;</td>
                                </tr>
                              </table>
                            </div></td>
                            <td align="left" valign="top"><div class="EstFormularioArea">
                              <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                                <tr>
                                  <td width="4" align="left" valign="top">&nbsp;</td>
                                  <td width="344" align="left" valign="top"><span class="EstFormularioSubTitulo">PRODUCTOS</span></td>
                                  <td width="5" align="left" valign="top">&nbsp;</td>
                                </tr>
                              </table>
                            </div></td>
                            <td align="left" valign="top">
                            <?php
						/*	
							?>
                            
                            <div class="EstFormularioArea">
                              <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                                <tr>
                                  <td width="4" align="left" valign="top">&nbsp;</td>
                                  <td width="344" align="left" valign="top"><span class="EstFormularioSubTitulo">SUMINISTROS</span></td>
                                  <td width="5" align="left" valign="top">&nbsp;</td>
                                </tr>
                              </table>
                            </div>
                              <?php
							*/
							?>
                            
                            </td>
                          </tr>
                          <tr>
                            <td width="48%" align="left" valign="top"><div class="EstFormularioArea" >
                              <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td colspan="2" align="left" valign="top"><a href="javascript:FncFichaAccionTareaEliminarTodo('<?php echo $DatFichaIngresoModalidad->MinSigla?>');">
                                    <input type="hidden" name="CmpFichaAccion<?php echo $DatFichaIngresoModalidad->MinSigla?>TareaAccion" id="CmpFichaAccion<?php echo $DatFichaIngresoModalidad->MinSigla?>TareaAccion" value="AccFichaAccionTareaRegistrar.php" />
                                  </a></td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td width="2%" align="left" valign="top"><a href="javascript:FncFichaAccionTareaEliminarTodo('<?php echo $DatFichaIngresoModalidad->MinSigla?>');"></a></td>
                                  <td colspan="2" align="left" valign="top"><a href="javascript:FncFichaAccionTareaEliminarTodo('<?php echo $DatFichaIngresoModalidad->MinSigla?>');"></a>TAREAS asignadas en la Orden de Trabajo</td>
                                  <td width="2%" align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td width="48%" align="left" valign="top"><div class="EstFormularioAccion" id="Cap<?php echo $DatFichaIngresoModalidad->MinSigla?>TareaAccion">Listo
                                    para registrar elementos<a href="javascript:FncFichaAccionTareaEliminarTodo('<?php echo $DatFichaIngresoModalidad->MinSigla?>');"></a></div></td>
                                  <td width="48%" align="right" valign="top"><a href="javascript:FncFichaAccionTareaListar('<?php echo $DatFichaIngresoModalidad->MinSigla?>');"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a></td>
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
                                  <td colspan="2" align="left" valign="top">&nbsp;</td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                              </table>
                            </div></td>
                            <td width="50%" align="left" valign="top"><div class="EstFormularioArea" >
                              <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                                <tr>
                                  <td>&nbsp;</td>
                                  <td colspan="2"><input type="hidden" name="CmpFichaAccion<?php echo $DatFichaIngresoModalidad->MinSigla?>ProductoAccion" id="CmpFichaAccion<?php echo $DatFichaIngresoModalidad->MinSigla?>ProductoAccion" value="AccFichaAccionProductoRegistrar.php" /></td>
                                  <td>&nbsp;</td>
                                </tr>
                                <tr>
                                  <td width="2%">&nbsp;</td>
                                  <td colspan="2">                                  PRODUCTOS asignados en la Orden de Trabajo</td>
                                  <td width="2%">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td width="49%"><div class="EstFormularioAccion" id="Cap<?php echo $DatFichaIngresoModalidad->MinSigla?>ProductoAccion">Listo
                                    para registrar elementos </div></td>
                                  <td width="47%" align="right"><a href="javascript:FncFichaAccionProductoListar('<?php echo $DatFichaIngresoModalidad->MinSigla?>');"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a></td>
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
                            <td width="2%" align="left" valign="top">
                            
                            <?php
							/*
							?>
                            <div class="EstFormularioArea" >
                              <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                                <tr>
                                  <td>&nbsp;</td>
                                  <td colspan="2"><span class="EstFormularioAccion">
                                    <input type="hidden" name="CmpFichaAccion<?php echo $DatFichaIngresoModalidad->MinSigla?>SuministroAccion" id="CmpFichaAccion<?php echo $DatFichaIngresoModalidad->MinSigla?>SuministroAccion" value="AccFichaAccionSuministroRegistrar.php" />
                                  </span></td>
                                  <td>&nbsp;</td>
                                </tr>
                                <tr>
                                  <td width="2%">&nbsp;</td>
                                  <td colspan="2">SUMINISTROS asignados en la Orden de Trabajo</td>
                                  <td width="2%">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td width="49%"><div class="EstFormularioAccion" id="Cap<?php echo $DatFichaIngresoModalidad->MinSigla?>SuministroAccion">Listo
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
                                  <td align="left" valign="top">
                                    
                                    
                                    <div class="EstFormularioCajaObservacion">
                                      <?php echo stripslashes($FichaAccionPedido);?>
                                    </div>
                                    
                                    
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
                            <td colspan="3" align="left" valign="top">
							
							
                                 
                                 
                                 
                                 
                                 
                                 <div class="EstFormularioArea" >
                              <table border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td align="left" valign="top"><span class="EstFormularioSubTitulo">Causas del Problema</span></td>
                                  <td align="left" valign="top">&nbsp;</td>
                                  </tr>
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td align="left" valign="top">
								  
                                  
                                  <div class="EstFormularioCajaObservacion"><?php echo stripslashes($FichaAccionCausa);?></div>

                                  
                                  
                                  </td>
                                  <td align="left" valign="top">&nbsp;</td>
                                  </tr>
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td align="left" valign="top"><span class="EstFormularioNota">* En caso de una Garantia, Campaña o Politica, rellene este espacio.</span></td>
                                  <td align="left" valign="top">&nbsp;</td>
                                  </tr>
                                </table>
                            </div>
                                 
                                  
		  
		  
		  
                                 </td>
                          </tr>
                          
                          <tr>
                                      <td colspan="3" align="left" valign="top"><div class="EstFormularioArea" >
                              <table border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td align="left" valign="top"><span class="EstFormularioSubTitulo">Solucion al Problema</span></td>
                                  <td align="left" valign="top">&nbsp;</td>
                                  </tr>
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td align="left" valign="top">
								  
                                  
                                  <div class="EstFormularioCajaObservacion">
                                  
                                  
                                  
                                  
                                  
          <?php echo stripslashes($FichaAccionSolucion);?>
          </div>

                                  
                                  
                                  </td>
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
                            <td colspan="3" align="left" valign="top"><div class="EstFormularioArea" >
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
                                  <td width="131" align="left" valign="top"></td>
                                  <td width="130" align="right" valign="top"><a href="javascript:FncFichaAccionFotoListar('<?php echo $DatFichaIngresoModalidad->MinSigla?>');"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a></td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td colspan="2" align="left" valign="top"></td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td colspan="2" align="left" valign="top">                                    <div class="EstCapFichaAccionFotos" id="CapFichaAccion<?php echo $DatFichaIngresoModalidad->MinSigla;?>Fotos"></div></td>
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
                            <td align="left" valign="top"></td>
                            <td align="left" valign="top"></td>
                            <td align="left" valign="top"></td>
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
                                    <td width="47%" align="right"><a href="javascript:FncFichaAccionProductoListar('<?php echo $DatFichaIngresoModalidad->MinSigla?>');"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a></td>
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
                            <td colspan="3">
                            

<div class="EstFormularioArea" >
                              <table border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td align="left" valign="top"><span class="EstFormularioSubTitulo">Pedidos</span></td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td align="left" valign="top">
                                    
                                    
                                    <div class="EstFormularioObservacion">
                                    <?php echo stripslashes($FichaAccionPedido);?>
                                    </div>
                                    
                                    <input type="hidden" name="CmpFichaAccionPedido_<?php echo $DatFichaIngresoModalidad->MinSigla?>" id="CmpFichaAccionPedido_<?php echo $DatFichaIngresoModalidad->MinSigla?>" value="<?php echo stripslashes($FichaAccionPedido);?>" >
                                    
                                  </td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td align="left" valign="top"><span class="EstFormularioNota">* Pedidos adicionales a almacen </span></td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                              </table>
                            </div>
                            
                            
                            </td>
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
                                  <td width="131" align="left" valign="top"></td>
                                  <td width="130" align="right" valign="top"><a href="javascript:FncFichaAccionFotoListar('<?php echo $DatFichaIngresoModalidad->MinSigla?>');"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a></td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td colspan="2" align="left" valign="top"></td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td colspan="2" align="left" valign="top">                                    <div class="EstCapFichaAccionFotos" id="CapFichaAccion<?php echo $DatFichaIngresoModalidad->MinSigla;?>Fotos"></div></td>
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
                            <td colspan="3">&nbsp;</td>
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
                          
                          <?php
						  /*
						  ?>
                          <tr>
                            <td width="33%" align="left"><div class="EstFormularioArea" >
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
                              </table>
                            </div></td>
                          </tr>
                          <?php
						  */
						  ?>
                          
                          <tr>
                            <td align="center"><span class="EstFormularioSubTitulo">SI - Tareas y Productos: <?php echo strtoupper($DatFichaIngresoModalidad->MinNombre);?></span></td>
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
                                </table>
                            </div></td>
                          </tr>
                          <tr>
                            <td align="left" valign="top"><div class="EstFormularioArea">
                              <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                                <tr>
                                  <td width="4" align="left" valign="top">&nbsp;</td>
                                  <td width="344" align="left" valign="top"><span class="EstFormularioSubTitulo">PRODUCTOS</span></td>
                                  <td width="5" align="left" valign="top">&nbsp;</td>
                                </tr>
                              </table>
                            </div></td>
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
                                    <td width="47%" align="right"><a href="javascript:FncFichaAccionProductoListar('<?php echo $DatFichaIngresoModalidad->MinSigla?>');"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a></td>
                                    <td><div id="CapFichaAccion<?php echo $DatFichaIngresoModalidad->MinSigla?>ProductosResultado"> </div></td>
                                  </tr>
                                  <tr>
                                    <td>&nbsp;</td>
                                    <td colspan="2"><div id="CapFichaAccion<?php echo $DatFichaIngresoModalidad->MinSigla?>Productos" class="EstCapFichaAccionProductos" ></div></td>
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
                                  <td align="left" valign="top"><span class="EstFormularioSubTitulo">Pedidos</span></td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td align="left" valign="top">
                                    
                                    
                                    <div class="EstFormularioObservacion">
                                    <?php echo stripslashes($FichaAccionPedido);?>
                                    </div>
                                    
                                    <input type="hidden" name="CmpFichaAccionPedido_<?php echo $DatFichaIngresoModalidad->MinSigla?>" id="CmpFichaAccionPedido_<?php echo $DatFichaIngresoModalidad->MinSigla?>" value="<?php echo stripslashes($FichaAccionPedido);?>" >
                                    
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
                                  <td width="131" align="left" valign="top"></td>
                                  <td width="130" align="right" valign="top"><a href="javascript:FncFichaAccionFotoListar('<?php echo $DatFichaIngresoModalidad->MinSigla?>');"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a></td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td colspan="2" align="left" valign="top"></td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td colspan="2" align="left" valign="top">                                    <div class="EstCapFichaAccionFotos" id="CapFichaAccion<?php echo $DatFichaIngresoModalidad->MinSigla;?>Fotos"></div></td>
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
                          
                          <?php
						  /*
						  ?>
                          <tr>
                            <td width="33%" align="left"><div class="EstFormularioArea" >
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
                              </table>
                            </div></td>
                          </tr>
                          <?php
						  */
						  ?>
                          
                          <tr>
                            <td align="center"><span class="EstFormularioSubTitulo">SI - Tareas y Productos: <?php echo strtoupper($DatFichaIngresoModalidad->MinNombre);?></span></td>
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
                                </table>
                            </div></td>
                          </tr>
                          <tr>
                            <td align="left" valign="top"><div class="EstFormularioArea">
                              <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                                <tr>
                                  <td width="4" align="left" valign="top">&nbsp;</td>
                                  <td width="344" align="left" valign="top"><span class="EstFormularioSubTitulo">PRODUCTOS</span></td>
                                  <td width="5" align="left" valign="top">&nbsp;</td>
                                </tr>
                              </table>
                            </div></td>
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
                                    <td width="47%" align="right"><a href="javascript:FncFichaAccionProductoListar('<?php echo $DatFichaIngresoModalidad->MinSigla?>');"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a></td>
                                    <td><div id="CapFichaAccion<?php echo $DatFichaIngresoModalidad->MinSigla?>ProductosResultado"> </div></td>
                                  </tr>
                                  <tr>
                                    <td>&nbsp;</td>
                                    <td colspan="2"><div id="CapFichaAccion<?php echo $DatFichaIngresoModalidad->MinSigla?>Productos" class="EstCapFichaAccionProductos" ></div></td>
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
                                  <td align="left" valign="top"><span class="EstFormularioSubTitulo">Pedidos</span></td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td align="left" valign="top">
                                    
                                    
                                    <div class="EstFormularioObservacion">
                                    <?php echo stripslashes($FichaAccionPedido);?>
                                    </div>
                                    
                                    <input type="hidden" name="CmpFichaAccionPedido_<?php echo $DatFichaIngresoModalidad->MinSigla?>" id="CmpFichaAccionPedido_<?php echo $DatFichaIngresoModalidad->MinSigla?>" value="<?php echo stripslashes($FichaAccionPedido);?>" >
                                    
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
                                  <td width="131" align="left" valign="top"></td>
                                  <td width="130" align="right" valign="top"><a href="javascript:FncFichaAccionFotoListar('<?php echo $DatFichaIngresoModalidad->MinSigla?>');"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a></td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td colspan="2" align="left" valign="top"></td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td colspan="2" align="left" valign="top">                                    <div class="EstCapFichaAccionFotos" id="CapFichaAccion<?php echo $DatFichaIngresoModalidad->MinSigla;?>Fotos"></div></td>
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
                                </table>
                            </div></td>
                          </tr>
                          <tr>
                            <td align="left" valign="top"><div class="EstFormularioArea">
                              <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                                <tr>
                                  <td width="4" align="left" valign="top">&nbsp;</td>
                                  <td width="344" align="left" valign="top"><span class="EstFormularioSubTitulo">PRODUCTOS</span></td>
                                  <td width="5" align="left" valign="top">&nbsp;</td>
                                </tr>
                              </table>
                            </div></td>
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
                            </div>
                              
                            </td>
                          </tr>
                         
                          <tr>
                            <td align="left" valign="top"><div class="EstFormularioArea" >
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
                                       <td align="left" valign="top">Proveedor: <input name="CmpFichaAccionSalidaExternaId" type="hidden" id="CmpFichaAccionSalidaExternaId" value="<?php echo $FichaAccionSalidaExternaId;?>" size="3" /></td>
                                       <td align="left" valign="top"><table>
                                         <tr>
                                           <td><input name="CmpProveedorNombre" type="text" class="EstFormularioCaja" id="CmpProveedorNombre" value="<?php echo $FichaAccionSalidaExternaProveedorNombreCompleto;?>" size="45" maxlength="255" readonly="readonly" <?php if(!empty($FichaAccionSalidaExternaProveedorId)){ echo 'readonly="readonly"';} ?>  /></td>
                                           <td></td>
                                         </tr>
                                       </table></td>
                                       <td align="left" valign="top">Tipo Doc.:
                                         <input name="CmpProveedorId" type="hidden" id="CmpProveedorId" value="<?php echo $FichaAccionSalidaExternaProveedorId;?>" size="3" /></td>
                                       <td align="left" valign="top"><select <?php if(!empty($FichaAccionSalidaExternaProveedorId)){ echo 'disabled="disabled"';} ?>  class="EstFormularioCombo" name="CmpProveedorTipoDocumento" id="CmpProveedorTipoDocumento" disabled="disabled">
                                         <option value="">Escoja una opcion</option>
                                         <?php
			foreach($ArrTipoDocumentos as $DatTipoDocumento){
			?>
                                         <option <?php echo $DatTipoDocumento->TdoId;?> <?php echo ($DatTipoDocumento->TdoId==$FichaAccionSalidaExternaProveedorTipoDocumentoId)?'selected="selected"':"";?> value="<?php echo $DatTipoDocumento->TdoId?>"><?php echo $DatTipoDocumento->TdoCodigo?> - <?php echo $DatTipoDocumento->TdoNombre?></option>
                                         <?php
			}
			?>
                                       </select></td>
                                       <td align="left" valign="top">Num. Doc.:</td>
                                       <td align="left" valign="top"><table border="0" cellpadding="0" cellspacing="0">
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
                                       <td valign="top">&nbsp;</td>
                                       <td valign="top">&nbsp;</td>
                                       <td>&nbsp;</td>
                                     </tr>
                                     <tr>
                                       <td>&nbsp;</td>
                                       <td align="left" valign="top">Num. Comprobante:</td>
                                       <td align="left" valign="top"><input name="CmpComprobanteNumero" type="text" class="EstFormularioCaja" id="CmpComprobanteNumero" value="<?php echo $FichaAccionComprobanteNumero;?>" size="20" maxlength="20" readonly="readonly" /></td>
                                       <td valign="top">Fecha de Comprobante:<br />
                                         <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
                                       <td valign="top"><input name="CmpComprobanteFecha" type="text" class="EstFormularioCajaFecha" id="CmpComprobanteFecha" value="<?php  echo $FichaAccionComprobanteFecha; ?>" size="15" maxlength="10" readonly="readonly" /></td>
                                       <td valign="top">&nbsp;</td>
                                       <td valign="top">&nbsp;</td>
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
                                
                          </div></td>
                           </tr>
                           
                           

                             <?php
						 // if($DatFichaIngresoModalidad->MinSigla == "GA" || $DatFichaIngresoModalidad->MinSigla == "CA" || $DatFichaIngresoModalidad->MinSigla == "PO" || $DatFichaIngresoModalidad->MinSigla == "IF"){
						?>
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
  
  
            <div class="EstFormularioCajaObservacion">
                                    
                                    
                                    
                                    
                                    
            <?php echo stripslashes($FichaAccionCausa);?>
            </div>
            
            
     
            
            
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
                                    <td align="left" valign="top">&nbsp;</td>
                                    <td align="left" valign="top">
                                      
                                     
  <span class="EstFormularioSubTitulo">Solucion al Problema</span>
                                      
                                      
                                    </td>
                                    <td align="left" valign="top">&nbsp;</td>
                                  </tr>
                                  <tr>
                                    <td align="left" valign="top">&nbsp;</td>
                                    <td align="left" valign="top">
                                    
                                                            
                                      <script type="text/javascript">
  
  
  tinymce.init({
      selector: "textarea#CmpFichaAccionSolucion_<?php echo $DatFichaIngresoModalidad->MinSigla?>",
      theme: "modern",
      menubar : false,
      toolbar1: "bold italic | bullist numlist",
      width : 830,
      height : 80
  });
  
  </script>
  
  
            <div class="EstFormularioCajaObservacion">
                                    
                                    
                                    
                                    
                                    
            <?php echo stripslashes($FichaAccionSolucion);?>
            </div>
            
            
     
            
            
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
<?php
						 // }
?>   
                          
                          
                          
                           <tr>
                             <td align="left" valign="top"><div class="EstFormularioArea" >
                              <table border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                                <tr>
                                  <td width="4" align="left" valign="top">&nbsp;</td>
                                  <td width="129" align="left" valign="top">
                                  
                                  <span class="EstFormularioSubTitulo">Fotos</span></td>
                                  <td width="132" align="right" valign="top">

									<a href="javascript:FncFichaAccionFotoListar('<?php echo $DatFichaIngresoModalidad->MinSigla?>');"></a>

                                  </td>
                                  <td width="4" align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td align="right" valign="top"><a href="javascript:FncFichaAccionFotoListar('<?php echo $DatFichaIngresoModalidad->MinSigla?>');"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a></td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td colspan="2" align="left" valign="top"></td>
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
                            <td align="left" valign="top"></td>
                          </tr>
                          
                        </table>
                      </div>
                      
                        <?php
						 break;
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
                                  <td>&nbsp;</td>
                                  <td><span class="EstFormularioAccion">
                                    <input type="hidden" name="CmpFichaAccionHerramientaAccion" id="CmpFichaAccionHerramientaAccion" value="AccFichaAccionHerramientaRegistrar.php" />
                                  </span></td>
                                  <td align="right">&nbsp;</td>
                                  <td>&nbsp;</td>
                                </tr>
                                <tr>
                                  <td width="1%">&nbsp;</td>
                                  <td width="49%"><div class="EstFormularioAccion" id="CapHerramientaAccion">Listo
                                    para registrar elementos
                                      
                                  </div></td>
                                  <td width="49%" align="right"><a href="javascript:FncFichaAccionHerramientaListar();"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a> <a href="javascript:FncFichaAccionHerramientaEliminarTodo();"></a></td>
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
	      <td width="4">&nbsp;</td>
	      <td width="230"><span class="EstFormularioSubTitulo">Observaciones de Taller</span></td>
	      <td width="4">&nbsp;</td>
	      </tr>
	    <tr>
	      <td>&nbsp;</td>
	      <td align="left" valign="top">
	        <!--

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


          <textarea name="CmpObservacionSalida" cols="60" rows="2" readonly="readonly" class="EstFormularioCaja" id="CmpObservacionSalida"><?php echo stripslashes($InsFichaIngreso->FinSalidaObservacion);?></textarea>-->
	        
	        <div class="EstFormularioCajaObservacion">
	          <?php echo stripslashes($InsFichaIngreso->FinSalidaObservacion);?>
	          </div>
	        <input type="hidden" name="CmpObservacionSalida" id="CmpObservacionSalida" value="<?php echo stripslashes($InsFichaIngreso->FinSalidaObservacion);?>" />
	        </td>
	      <td align="left" valign="top">&nbsp;</td>
	      </tr>
	    <tr>
	      <td>&nbsp;</td>
	      <td align="left" valign="top"><span class="EstFormularioSubTitulo">Observaciones Internas</span></td>
	      <td align="left" valign="top">&nbsp;</td>
	      </tr>
	    <tr>
	      <td>&nbsp;</td>
	      <td align="left" valign="top">
          
          
	        <div class="EstFormularioCajaObservacion"> <?php echo stripslashes($InsFichaIngreso->FinSalidaObservacionInterna);?> </div>
	        <input type="hidden" name="CmpObservacionSalidaInterna" id="CmpObservacionSalidaInterna" value="<?php echo stripslashes($InsFichaIngreso->FinSalidaObservacionInterna);?>" /></td>
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
                            <td colspan="2"></td>
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
                                  
                                  <span class="EstFormularioSubTitulo">Fotos</span>

									<a href="javascript:FncFichaAccionFotoVINListar();"></a>                                  </td>
                                  <td width="4" align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td width="1" align="left" valign="top">&nbsp;</td>
                                  <td width="260" align="right" valign="top"><a href="javascript:FncFichaAccionFotoVINListar();"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a></td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td align="left" valign="top">&nbsp;</td>
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
                                  <td width="1" align="left" valign="top">&nbsp;</td>
                                  <td width="260" align="right" valign="top"><a href="javascript:FncFichaAccionFotoDelanteraListar();"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a></td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td align="left" valign="top">&nbsp;</td>
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
                            <td colspan="2" align="left" valign="top"><span class="EstFormularioSubTitulo">Fotos</span><a href="javascript:FncFichaAccionFotoCuponListar();"></a></td>
                            <td width="4" align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr>
                            <td align="left" valign="top">&nbsp;</td>
                            <td width="1" align="left" valign="top">&nbsp;</td>
                            <td width="274" align="right" valign="top"><a href="javascript:FncFichaAccionFotoCuponListar();"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a></td>
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr>
                            <td align="left" valign="top">&nbsp;</td>
                            <td align="left" valign="top"><script type="text/javascript">
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
                      <td><span class="EstFormularioSubTitulo">Foto Mantenimiento</span></td>
                    </tr>
                    <tr>
                      <td><div class="EstFormularioArea" >
                        <table border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                          <tr>
                            <td width="4" align="left" valign="top">&nbsp;</td>
                            <td colspan="2" align="left" valign="top"><span class="EstFormularioSubTitulo">Fotos</span><a href="javascript:FncFichaAccionFotoMantenimientoListar();"></a></td>
                            <td width="4" align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr>
                            <td align="left" valign="top">&nbsp;</td>
                            <td width="1" align="left" valign="top">&nbsp;</td>
                            <td width="274" align="right" valign="top"><a href="javascript:FncFichaAccionFotoMantenimientoListar();"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a></td>
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr>
                            <td align="left" valign="top">&nbsp;</td>
                            <td align="left" valign="top"><script type="text/javascript">
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
	      <td><span class="EstFormularioSubTitulo">OBSERVACIONES DE ALMACEN</span></td>
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

	
	
	
    
       


     

<?php
}else{
	echo ERR_GEN_101;
}

//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();
?>



<?php
//$InsMensaje->MenResultado = $Resultado;
//$InsMensaje->MtdImprimirResultado();
?>