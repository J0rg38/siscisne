<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>

<?php $PrivilegioEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar"))?true:false;?>
<?php $PrivilegioVistaPreliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"VistaPreliminar"))?true:false;?>
<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Imprimir"))?true:false;?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsTrabajoTerminadoFunciones.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsTrabajoTerminadoTareaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsTrabajoTerminadoProductoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsTrabajoTerminadoSuministroFunciones.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsTrabajoTerminadoMantenimientoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsTrabajoTerminadoHerramientaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsTrabajoTerminadoGastoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsTrabajoTerminadoTemparioFunciones.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsTrabajoTerminadoFotoFunciones.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsTrabajoTerminadoFotoVINFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsTrabajoTerminadoFotoDelanteraFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsTrabajoTerminadoFotoCuponFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsTrabajoTerminadoFotoMantenimientoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsTrabajoTerminadoHistorialFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsTrabajoTerminadoCotizacionesFunciones.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('AvisoRapido');?>JsAvisoRapidoFunciones.js" ></script>



<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssTrabajoTerminado.css');
@import url('<?php echo $InsProyecto->MtdFormulariosCss("PlanMantenimiento");?>CssPlanMantenimiento.css');
</style>

<?php
$GET_Id = $_GET['Id'];

$Registro = false;

if(!empty($_POST['Identificador'])){
	$Identificador = $_POST['Identificador'];
}
include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjTrabajoTerminado.php');
include($InsProyecto->MtdFormulariosMsj("FichaIngreso").'MsjFichaIngreso.php');

require_once($InsPoo->MtdPaqActividad().'ClsFichaAccion.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionSalidaExterna.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionFoto.php');
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
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoManoObra.php');
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
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculo.php');

$InsFichaAccion = new ClsFichaAccion();
$InsFichaIngreso = new ClsFichaIngreso();
$InsModalidadIngreso = new ClsModalidadIngreso();

$InsPlanMantenimiento = new ClsPlanMantenimiento();
$InsPlanMantenimientoTarea = new ClsPlanMantenimientoTarea();
$InsPlanMantenimientoSeccion = new ClsPlanMantenimientoSeccion();

$InsProducto = new ClsProducto();
$InsUnidadMedida = new ClsUnidadMedida();
$InsUnidadMedidaConversion = new ClsUnidadMedidaConversion();

$InsFichaIngreso->FinId = $GET_Id;
$InsFichaIngreso = $InsFichaIngreso->MtdObtenerFichaIngreso();	
$InsFichaIngreso->UsuId = $_SESSION['SesionId'];
	
$ArrFichaAccion = null;	
$ArrFichaAccion = array();

if(!empty($InsFichaIngreso->FichaIngresoModalidad)){
	foreach($InsFichaIngreso->FichaIngresoModalidad as $DatFichaIngresoModalidad){

		if (!isset($_SESSION['InsTrabajoTerminadoTarea'.$DatFichaIngresoModalidad->MinSigla.$Identificador])){	
			$_SESSION['InsTrabajoTerminadoTarea'.$DatFichaIngresoModalidad->MinSigla.$Identificador] = new ClsSesionObjeto();
		}else{	
			$_SESSION['InsTrabajoTerminadoTarea'.$DatFichaIngresoModalidad->MinSigla.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsTrabajoTerminadoTarea'.$DatFichaIngresoModalidad->MinSigla.$Identificador]);
		}		

		if (!isset($_SESSION['InsTrabajoTerminadoProducto'.$DatFichaIngresoModalidad->MinSigla.$Identificador])){	
			$_SESSION['InsTrabajoTerminadoProducto'.$DatFichaIngresoModalidad->MinSigla.$Identificador] = new ClsSesionObjeto();
		}else{	
			$_SESSION['InsTrabajoTerminadoProducto'.$DatFichaIngresoModalidad->MinSigla.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsTrabajoTerminadoProducto'.$DatFichaIngresoModalidad->MinSigla.$Identificador]);
		}
		
		if (!isset($_SESSION['InsTrabajoTerminadoProductoAdicional'.$DatFichaIngresoModalidad->MinSigla.$Identificador])){	
			$_SESSION['InsTrabajoTerminadoProductoAdicional'.$DatFichaIngresoModalidad->MinSigla.$Identificador] = new ClsSesionObjeto();
		}else{	
			$_SESSION['InsTrabajoTerminadoProductoAdicional'.$DatFichaIngresoModalidad->MinSigla.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsTrabajoTerminadoProductoAdicional'.$DatFichaIngresoModalidad->MinSigla.$Identificador]);
		}
		
		if (!isset($_SESSION['InsTrabajoTerminadoMantenimiento'.$DatFichaIngresoModalidad->MinSigla.$Identificador])){	
			$_SESSION['InsTrabajoTerminadoMantenimiento'.$DatFichaIngresoModalidad->MinSigla.$Identificador] = new ClsSesionObjeto();
		}else{	
			$_SESSION['InsTrabajoTerminadoMantenimiento'.$DatFichaIngresoModalidad->MinSigla.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsTrabajoTerminadoMantenimiento'.$DatFichaIngresoModalidad->MinSigla.$Identificador]);
		}

		if (!isset($_SESSION['InsTrabajoTerminadoSuministro'.$DatFichaIngresoModalidad->MinSigla.$Identificador])){	
			$_SESSION['InsTrabajoTerminadoSuministro'.$DatFichaIngresoModalidad->MinSigla.$Identificador] = new ClsSesionObjeto();
		}else{	
			$_SESSION['InsTrabajoTerminadoSuministro'.$DatFichaIngresoModalidad->MinSigla.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsTrabajoTerminadoSuministro'.$DatFichaIngresoModalidad->MinSigla.$Identificador]);
		}
		
	}
}

if (!isset($_SESSION['InsTrabajoTerminadoHerramienta'.$Identificador])){	
	$_SESSION['InsTrabajoTerminadoHerramienta'.$Identificador] = new ClsSesionObjeto();
}else{	
	$_SESSION['InsTrabajoTerminadoHerramienta'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsTrabajoTerminadoMantenimiento'.$Identificador]);
}
		
if (!isset($_SESSION['InsTrabajoTerminadoGasto'.$Identificador])){	
	$_SESSION['InsTrabajoTerminadoGasto'.$Identificador] = new ClsSesionObjeto();
}else{	
	$_SESSION['InsTrabajoTerminadoGasto'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsTrabajoTerminadoGasto'.$Identificador]);
}


$RepPlanMantenimientoSeccion = $InsPlanMantenimientoSeccion->MtdObtenerPlanMantenimientoSecciones(NULL,NULL,"PmsId","ASC",NULL);
$ArrPlanMantenimientoSecciones = $RepPlanMantenimientoSeccion['Datos'];

include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccTrabajoTerminadoEditar.php');


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

	FncTrabajoTerminadoHerramientaListar();

	$('input[type=checkbox]').each(function () {
		if($(this).attr('etiqueta')=="modalidad"){
			
			FncTrabajoTerminadoFotoListar($(this).attr('sigla'));
			
			
			FncTrabajoTerminadoTareaListar($(this).attr('sigla'));
			FncTrabajoTerminadoTareaListar2($(this).attr('sigla'));
			
			FncTrabajoTerminadoProductoListar($(this).attr('sigla'));
			FncTrabajoTerminadoProductoListar2($(this).attr('sigla'));
			
			FncTrabajoTerminadoSuministroListar($(this).attr('sigla'));
			FncTrabajoTerminadoSuministroListar2($(this).attr('sigla'));
						
			FncTrabajoTerminadoMantenimientoListar($(this).attr('sigla'));
			
		}			 
	});

	FncTrabajoTerminadoFotoVINListar();
	FncTrabajoTerminadoFotoDelanteraListar();
	FncTrabajoTerminadoFotoCuponListar();
	FncTrabajoTerminadoFotoMantenimientoListar();
	
	FncTrabajoTerminadoHistorialListar();
	FncTrabajoTerminadoCotizacionesListar();
	
	FncTrabajoTerminadoGastoListar();


});

/*
Configuracion Formulario
*/

var TrabajoTerminadoTareaEditar = 2;
var TrabajoTerminadoTareaEliminar = 2;

var TrabajoTerminadoProductoEditar = 2;
var TrabajoTerminadoProductoEliminar = 2;

var TrabajoTerminadoSuministroEditar = 2;
var TrabajoTerminadoSuministroEliminar = 2;

var FichaAccionMantenimientoEditar = 2;
var FichaAccionMantenimientoEliminar = 2;

var TrabajoTerminadoHerramientaEditar = 2;
var TrabajoTerminadoHerramientaEliminar = 2;

var TrabajoTerminadoGastoEditar = 2;
var TrabajoTerminadoGastoEliminar = 2;


var TrabajoTerminadoFotoEditar = 2;
var TrabajoTerminadoFotoEliminar = 2;

var TrabajoTerminadoFotoVINEliminar = 2;
var TrabajoTerminadoFotoDelanteraEliminar = 2;
var TrabajoTerminadoFotoCuponEliminar = 2;
var TrabajoTerminadoFotoMantenimientoEliminar = 2;

</script>

<div class="EstCapMenu">

	<?php
    if($PrivilegioVistaPreliminar){
    ?>
    <div class="EstSubMenuBoton"><a href="javascript:FncVistaPreliminar('<?php echo $InsFichaIngreso->FinId;?>');"><img src="imagenes/iconos/preliminar.png" alt="[Vista Preliminar]" title="Vista preliminar" />V.P.</a></div>
    <?php
    }
    ?>
	<?php
    if($PrivilegioImprimir){
    ?>
    <div class="EstSubMenuBoton"><a href="javascript:FncImprmir('<?php echo $InsFichaIngreso->FinId;?>');"><img src="imagenes/iconos/imprimir.png" alt="[Imprimir]" title="Imprimir"  />Imprimir</a></div>
    <?php
    }
    ?>
              	<?php
			if($PrivilegioEditar and ($InsFichaIngreso->FinEstado == 73 or $InsFichaIngreso->FinEstado == 74)){
			?>           
             
             <div class="EstSubMenuBoton"><a href="principal<?php echo (!empty($GET_dia)?'2':'');?>.php?Mod=<?php echo $GET_mod;?>&Form=Editar<?php echo (!empty($GET_dia)?'&Dia=1':'');?>&Id=<?php echo $InsFichaIngreso->FinId;?>"><img src="imagenes/iconos/editar.png" alt="[Editar]" title="Editar" />Editar</a></div>
             <?php
			}
			?>   
                        
</div>

<div class="EstCapContenido">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
      
      <tr>
        <td width="1922" height="25" colspan="2"><span class="EstFormularioTitulo">VER  ORDEN DE TRABAJO TERMINADO</span></td>
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
        
        
                 <input name="CmpOrdenVentaVehiculoId" type="hidden" class="EstFormularioCaja" id="CmpOrdenVentaVehiculoId" value="<?php echo $InsFichaIngreso->FinOrdenVentaVehiculo;?>"  />
                 
<!--
HISTORIALES
-->
                 <input name="CmpVehiculoIngresoId" type="hidden" id="CmpVehiculoIngresoId" value="<?php echo $InsFichaIngreso->EinId;?>" />
                 
                 <input name="CmpVehiculoIngresoVIN" type="hidden" id="CmpVehiculoIngresoVIN" value="<?php echo $InsFichaIngreso->EinVIN;?>" />
                 
        
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
      <td align="left" valign="top">Fecha de Trabajo Terminado:</td>
      <td align="left" valign="top"><input name="CmpTrabajoTerminadoFecha" type="text" class="EstFormularioCajaFecha" id="CmpTrabajoTerminadoFecha" value="<?php echo $InsFichaIngreso->FinTiempoTrabajoTerminado;?>" size="15" maxlength="10" readonly="readonly" />        <script type="text/javascript">
Calendar.setup({ 
inputField : "CmpTrabajoTerminadoFecha",  // id del campo de texto 
ifFormat   : "%d/%m/%Y",  //  
button     : "BtnTrabajoTerminadoFecha"// el id del botón que  
});

        </script></td>
      <td align="left" valign="top" bgcolor="#F3F3F3">&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
  </table>
</div>  
<br />

          
<ul class="tabs">


 
	<?php
	$c = 3;
	foreach($InsFichaIngreso->FichaIngresoModalidad as $DatFichaIngresoModalidad){
    ?>
		<li><a href="#tab<?php echo $c;?>"><?php echo $DatFichaIngresoModalidad->MinNombre;?></a></li>
	<?php
	$c++;
    }
    ?>
    
      <li><a href="#tab<?php echo $c+4;?>">Historial</a></li>
  
    
    <li><a href="#tab<?php echo $c+7;?>">Gastos Adicionales</a></li>
    
    <li><a href="#tab2">Inventario</a></li>
	<li><a href="#tab<?php echo $c;?>">Obs./Taller</a></li>
     <li><a href="#tab<?php echo $c+2;?>">Obs./Almacen</a></li>
 	<li><a href="#tab<?php echo $c+1;?>">Actas de Entrega</a></li>
    <li><a href="#tab<?php echo $c+3;?>">Fotos GM</a></li>
    
 
</ul>
	
<div class="tab_container">

    
	<?php
	$c = 3;
	//foreach($InsFichaIngreso->FichaIngresoModalidad as $DatFichaIngresoModalidad){
	foreach($InsFichaIngreso->FichaIngresoModalidad as $DatFichaIngresoModalidad){

			$FichaAccionId = '';
			$FichaAccionFecha = date("d/m/Y");
			$FichaAccionObservacion = '';
			$FichaIngresoModalidadId = '';
			$FichaIngresoModalidadObsequio = 2;
			$FichaAccionManoObra = 0;
			$FichaAccionManoObraDetalle = '';
			
            if(!empty($ArrFichaAccion)){	
                foreach($ArrFichaAccion as $DatFichaAccion ){
					
                    if($DatFichaIngresoModalidad->MinId==$DatFichaAccion->MinId){

						$FichaAccionId = $DatFichaAccion->FccId;
						$FichaAccionFecha = $DatFichaAccion->FccFecha;
						$FichaAccionObservacion = $DatFichaAccion->FccObservacion;
						$FichaIngresoModalidadId = $DatFichaAccion->FimId;
						$FichaIngresoModalidadObsequio = $DatFichaAccion->FimObsequio;
						$FichaAccionManoObra = $DatFichaAccion->FccManoObra;
						$FichaAccionManoObraDetalle = $DatFichaAccion->FccManoObraDetalle;
						
                        break;
                    }					
                }
            }	
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
                            <td align="left" valign="top"><input style="visibility:hidden;" etiqueta="modalidad" checked="checked"  type="checkbox" value="<?php echo $DatFichaIngresoModalidad->MinId?>" name="CmpModalidadId_<?php echo $DatFichaIngresoModalidad->MinSigla?>" id="CmpModalidadId_<?php echo $DatFichaIngresoModalidad->MinSigla?>" sigla="<?php echo $DatFichaIngresoModalidad->MinSigla?>" /></td>
                            <td align="left" valign="top">
                            
<input name="CmpFecha_<?php echo $DatFichaIngresoModalidad->MinSigla?>" type="hidden" id="CmpFecha_<?php echo $DatFichaIngresoModalidad->MinSigla?>" value="<?php echo $FichaAccionFecha;?>" />

<input name="CmpObservacion_<?php echo $DatFichaIngresoModalidad->MinSigla?>" type="hidden" id="CmpObservacion_<?php echo $DatFichaIngresoModalidad->MinSigla?>" value="<?php echo $FichaAccionObservacion;?>" />

<input name="CmpId_<?php echo $DatFichaIngresoModalidad->MinSigla?>" type="hidden" class="EstFormularioCaja" id="CmpId_<?php echo $DatFichaIngresoModalidad->MinSigla?>" value="<?php echo $FichaAccionId ;?>" size="15" maxlength="20" readonly="readonly" />                           

<input name="CmpModalidadIngresoSigla_<?php echo $DatFichaIngresoModalidad->MinSigla?>" type="hidden" id="CmpModalidadIngresoSigla_<?php echo $DatFichaIngresoModalidad->MinSigla?>" value="<?php echo $DatFichaIngresoModalidad->MinSigla?>" />

<input name="CmpModalidadIngresoNombre_<?php echo $DatFichaIngresoModalidad->MinSigla?>" type="hidden" id="CmpModalidadIngresoNombre_<?php echo $DatFichaIngresoModalidad->MinSigla?>" value="<?php echo $DatFichaIngresoModalidad->MinNombre;?>" />

<input name="CmpModalidadIngresoId_<?php echo $DatFichaIngresoModalidad->MinSigla?>" type="hidden" id="CmpModalidadIngresoId_<?php echo $DatFichaIngresoModalidad->MinSigla?>" value="<?php echo $DatFichaIngresoModalidad->MinId;?>" />


                            
                            <span style="color:#F5F5F5">(<?php echo $FichaAccionId;?>) / (<?php echo $DatFichaIngresoModalidad->FimId;?>) / (<?php echo $FichaAccionFecha;?>) </span>
                            </td>
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr>
                            <td>&nbsp;</td>
                            <td align="left" valign="top">Detalle de Mano de Obra:</td>
                            <td align="left" valign="top"><textarea name="CmpFichaAccionManoObraDetalle_<?php echo $DatFichaIngresoModalidad->MinSigla?>" cols="45" rows="2" readonly="readonly" class="EstFormularioCaja" id="CmpFichaAccionManoObraDetalle_<?php echo $DatFichaIngresoModalidad->MinSigla?>"><?php echo stripslashes($FichaAccionManoObraDetalle);?></textarea></td>
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr>
                            <td>&nbsp;</td>
                            <td align="left" valign="top">Costo de Mano de Obra:</td>
                            <td align="left" valign="top"><input name="CmpFichaAccionManoObra_<?php echo $DatFichaIngresoModalidad->MinSigla?>" type="text" class="EstFormularioCaja" id="CmpFichaAccionManoObra_<?php echo $DatFichaIngresoModalidad->MinSigla?>" value="<?php echo number_format($FichaAccionManoObra,2);?>" size="10" maxlength="10" readonly="readonly" /></td>
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr>
                            <td>&nbsp;</td>
                            <td colspan="2" align="left" valign="top"><input disabled="disabled" <?php echo ($FichaIngresoModalidadObsequio==1)?'checked="checked"':''; ?>  type="checkbox" name="CmpFichaIngresoModalidadObsequio_<?php echo $DatFichaIngresoModalidad->MinSigla; ?>" id="CmpFichaIngresoModalidadObsequio_<?php echo $DatFichaIngresoModalidad->MinSigla; ?>" value="1" />
        Este SERVICIO es GRATUITO</td>
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                        </table>

                      </div>
                      
                      </td>
                    </tr>
                    <tr>
                      <td colspan="4">
                      
                      
                     <?php
					//deb($DatFichaIngresoModalidad->MinSigla);
					switch($DatFichaIngresoModalidad->MinSigla){
						 
						 default:
						?>
                        
							<div class="EstFormularioArea" >
                        <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                          
                          
                                                    
						<?php
						if($DatFichaIngresoModalidad->MinSigla == "GA" || $DatFichaIngresoModalidad->MinSigla == "CA" || $DatFichaIngresoModalidad->MinSigla == "PO"){
						?>
                          <tr>
                            <td colspan="2" align="left"><?php
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
                            <td colspan="2" align="left">
                            
                            
                            <div class="EstFormularioArea" >
                              <table border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td colspan="2" align="left" valign="top"><span class="EstFormularioSubTitulo">TEMPARIO</span></td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td align="left" valign="top"><div class="EstFormularioAccion" id="CapTemparioAccion">Listo
                                    para registrar elementos<a href="javascript:FncTrabajoTerminadoTemparioEliminarTodo('<?php echo $DatFichaIngresoModalidad->MinSigla?>');"></a></div></td>
                                  <td align="right" valign="top"><a href="javascript:FncTrabajoTerminadoTemparioListar('<?php echo $DatFichaIngresoModalidad->MinSigla?>');"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a> <a href="javascript:FncTrabajoTerminadoTemparioEliminarTodo('<?php echo $DatFichaIngresoModalidad->MinSigla?>');"></a></td>
                                  <td align="left" valign="top"><div id="CapTrabajoTerminadoTempariosResultado"> </div></td>
                                </tr>
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td colspan="2" align="left" valign="top"><div id="CapTrabajoTerminado<?php echo $DatFichaIngresoModalidad->MinSigla?>Temparios" class="EstCapTrabajoTerminadoTemparios" > </div></td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td colspan="2" align="left" valign="top"></td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                              </table>
                            </div>
                            </td>
                          </tr>
                          
                          <?php
						}
						  ?>
                          
                         
                          <tr>
                            <td colspan="2" align="center"><span class="EstFormularioSubTitulo">Tareas y Productos: <?php echo strtoupper($DatFichaIngresoModalidad->MinNombre);?></span></td>
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
                          </tr>
                          <tr>
                            <td align="left" valign="top"><div class="EstFormularioArea" >
                              <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                                <tr>
                                  <td width="4%" align="left" valign="top"><a href="javascript:FncTrabajoTerminadoTareaEliminarTodo('<?php echo $DatFichaIngresoModalidad->MinSigla?>');">
                                    <input type="hidden" name="CmpFichaAccion<?php echo $DatFichaIngresoModalidad->MinSigla?>TareaAccion" id="CmpFichaAccion<?php echo $DatFichaIngresoModalidad->MinSigla?>TareaAccion" value="AccFichaAccionTareaRegistrar.php" />
                                  </a></td>
                                  <td colspan="2" align="left" valign="top">TAREAS asignadas en la Orden de Trabajo</td>
                                  <td width="1%" align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td width="46%" align="left" valign="top"><div class="EstFormularioAccion" id="CapTareaAccion">Listo
                                  para registrar elementos<a href="javascript:FncTrabajoTerminadoTareaEliminarTodo('<?php echo $DatFichaIngresoModalidad->MinSigla?>');"></a></div></td>
                                  <td width="49%" align="left" valign="top"><a href="javascript:FncTrabajoTerminadoTareaListar('<?php echo $DatFichaIngresoModalidad->MinSigla?>');"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a></td>
                                  <td align="left" valign="top"><div id="CapTrabajoTerminadoTareasResultado"> </div></td>
                                </tr>
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td colspan="2" align="left" valign="top"><div id="CapTrabajoTerminado<?php echo $DatFichaIngresoModalidad->MinSigla?>Tareas" class="EstCapTrabajoTerminadoTareas" > </div></td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td colspan="2" align="left" valign="top">&nbsp;</td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                              </table>
                            </div></td>
                            <td align="left" valign="top"><div class="EstFormularioArea" >
                              <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                                <tr>
                                  <td width="4%"><input type="hidden" name="CmpFichaAccion<?php echo $DatFichaIngresoModalidad->MinSigla?>ProductoAccion" id="CmpFichaAccion<?php echo $DatFichaIngresoModalidad->MinSigla?>ProductoAccion" value="AccFichaAccionProductoRegistrar.php" /></td>
                                  <td colspan="2">PRODUCTOS asignados en la Orden de Trabajo</td>
                                  <td width="1%">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td width="47%"><div class="EstFormularioAccion" id="Cap<?php echo $DatFichaIngresoModalidad->MinSigla?>ProductoAccion">Listo
                                  para registrar elementos </div></td>
                                  <td width="48%" align="right"><a href="javascript:FncTrabajoTerminadoProductoListar('<?php echo $DatFichaIngresoModalidad->MinSigla?>');"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a></td>
                                  <td><div id="CapTrabajoTerminado<?php echo $DatFichaIngresoModalidad->MinSigla?>ProductosResultado"> </div></td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td colspan="2"><div id="CapTrabajoTerminado<?php echo $DatFichaIngresoModalidad->MinSigla?>Productos2" class="EstCapTrabajoTerminadoProductos" ></div></td>
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
                            <td colspan="2" align="left" valign="top"><div class="EstFormularioArea" >
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
                          <tr>
                            <td colspan="2" align="left" valign="top"><div class="EstFormularioArea" >
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
                            </div></td>
                          </tr>
                          <tr>
                            <td colspan="2" align="left" valign="top"><div class="EstFormularioArea" >
                              <table border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td align="left" valign="top"><span class="EstFormularioSubTitulo">Solucion al Problema</span></td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td align="left" valign="top"><div class="EstFormularioCajaObservacion"> <?php echo stripslashes($FichaAccionSolucion);?> </div></td>
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
                            <td colspan="2" align="left" valign="top"><div class="EstFormularioArea" >
                              <table border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                                <tr>
                                  <td width="4" align="left" valign="top">&nbsp;</td>
                                  <td colspan="2" align="left" valign="top"><span class="EstFormularioSubTitulo">Fotos</span> <a href="javascript:FncFichaAccionFotoListar('<?php echo $DatFichaIngresoModalidad->MinSigla?>');"></a></td>
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
                                  <td colspan="2" align="left" valign="top"><div class="EstCapTrabajoTerminadoFotos" id="CapTrabajoTerminado<?php echo $DatFichaIngresoModalidad->MinSigla;?>Fotos"></div></td>
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
                          <tr>
                            <td width="32%" align="left" valign="top"></td>
                            <td width="34%" align="left" valign="top"></td>
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
                            <td>Kilometraje/Plan Mant.:</td>
                            <td><?php
							//deb($InsFichaIngreso->VmaId);
							?>
                              <select class="EstFormularioCombo" name="CmpMantenimientoKilometraje" id="CmpMantenimientoKilometraje" disabled="disabled">
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
                            <td width="48%" colspan="2"><span class="EstFormularioSubTitulo"> Tareas del Plan de Mantenimiento</span></td>
                            <td width="50%" align="right"><a href="javascript:FncTrabajoTerminadoMantenimientoListar('<?php echo $DatFichaIngresoModalidad->MinSigla?>');"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a></td>
                            <td width="1%">&nbsp;</td>
                          </tr>
                          <tr>
                            <td>&nbsp;</td>
                            <td colspan="3"><div id="CapTrabajoTerminado<?php echo $DatFichaIngresoModalidad->MinSigla?>Mantenimientos" class="EstCapTrabajoTerminadoMantenimientos" > </div></td>
                            <td><div id="CapTrabajoTerminado<?php echo $DatFichaIngresoModalidad->MinSigla?>MantenimientosResultado"> </div></td>
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
                            <td colspan="3"><div id="CapTrabajoTerminado<?php echo $DatFichaIngresoModalidad->MinSigla?>Productos" class="EstCapTrabajoTerminadoProductos" ></div></td>
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
                                  <td colspan="2" align="left" valign="top"><span class="EstFormularioSubTitulo">Fotos</span> <a href="javascript:FncFichaAccionFotoListar('<?php echo $DatFichaIngresoModalidad->MinSigla?>');"></a></td>
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
                                  <td colspan="2" align="left" valign="top"><div class="EstCapTrabajoTerminadoFotos" id="CapTrabajoTerminado<?php echo $DatFichaIngresoModalidad->MinSigla;?>Fotos"></div></td>
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
                            <td colspan="3"></td>
                            <td>&nbsp;</td>
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
                                  <td width="50%" align="left" valign="top"><div class="EstFormularioAccion" id="Cap<?php echo $DatFichaIngresoModalidad->MinSigla?>TareaAccion"> Listo
                                    para registrar elementos</div></td>
                                  <td width="48%" align="right" valign="top"><a href="javascript:FncTrabajoTerminadoTareaListar('<?php echo $DatFichaIngresoModalidad->MinSigla?>');"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a> <a href="javascript:FncTrabajoTerminadoTareaEliminarTodo('<?php echo $DatFichaIngresoModalidad->MinSigla?>');"></a></td>
                                  <td align="left" valign="top"><div id="CapTrabajoTerminadoTareasResultado2"> </div></td>
                                </tr>
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td colspan="2" align="left" valign="top"><div id="CapTrabajoTerminado<?php echo $DatFichaIngresoModalidad->MinSigla?>Tareas3" class="EstCapTrabajoTerminadoTareas" > </div></td>
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
                                    <td width="47%" align="right"><a href="javascript:FncTrabajoTerminadoProductoListar('<?php echo $DatFichaIngresoModalidad->MinSigla?>');"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a> <a href="javascript:FncTrabajoTerminadoProductoEliminarTodo('<?php echo $DatFichaIngresoModalidad->MinSigla?>');"></a></td>
                                    <td><div id="CapTrabajoTerminado<?php echo $DatFichaIngresoModalidad->MinSigla?>ProductosResultado"> </div></td>
                                  </tr>
                                  <tr>
                                    <td>&nbsp;</td>
                                    <td colspan="2"><div id="CapTrabajoTerminado<?php echo $DatFichaIngresoModalidad->MinSigla?>Productos" class="EstCapTrabajoTerminadoProductos" ></div></td>
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
                                  <td align="left" valign="top"><input type="hidden" name="CmpFichaAccionPedido_<?php echo $DatFichaIngresoModalidad->MinSigla?>" id="CmpFichaAccionPedido_<?php echo $DatFichaIngresoModalidad->MinSigla?>" value="<?php echo stripslashes($FichaAccionPedido);?>" />
                                    <div class="EstFormularioObservacion"> <?php echo stripslashes($FichaAccionPedido);?></div></td>
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
                            <td align="left" valign="top">&nbsp;</td>
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
                                  <td width="50%" align="left" valign="top"><div class="EstFormularioAccion" id="Cap<?php echo $DatFichaIngresoModalidad->MinSigla?>TareaAccion"> Listo
                                    para registrar elementos</div></td>
                                  <td width="48%" align="right" valign="top"><a href="javascript:FncTrabajoTerminadoTareaListar('<?php echo $DatFichaIngresoModalidad->MinSigla?>');"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a> <a href="javascript:FncTrabajoTerminadoTareaEliminarTodo('<?php echo $DatFichaIngresoModalidad->MinSigla?>');"></a></td>
                                  <td align="left" valign="top"><div id="CapTrabajoTerminadoTareasResultado2"> </div></td>
                                </tr>
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td colspan="2" align="left" valign="top"><div id="CapTrabajoTerminado<?php echo $DatFichaIngresoModalidad->MinSigla?>Tareas3" class="EstCapTrabajoTerminadoTareas" > </div></td>
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
                                    <td width="47%" align="right"><a href="javascript:FncTrabajoTerminadoProductoListar('<?php echo $DatFichaIngresoModalidad->MinSigla?>');"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a> <a href="javascript:FncTrabajoTerminadoProductoEliminarTodo('<?php echo $DatFichaIngresoModalidad->MinSigla?>');"></a></td>
                                    <td><div id="CapTrabajoTerminado<?php echo $DatFichaIngresoModalidad->MinSigla?>ProductosResultado"> </div></td>
                                  </tr>
                                  <tr>
                                    <td>&nbsp;</td>
                                    <td colspan="2"><div id="CapTrabajoTerminado<?php echo $DatFichaIngresoModalidad->MinSigla?>Productos" class="EstCapTrabajoTerminadoProductos" ></div></td>
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
                                  <td align="left" valign="top"><input type="hidden" name="CmpFichaAccionPedido_<?php echo $DatFichaIngresoModalidad->MinSigla?>" id="CmpFichaAccionPedido_<?php echo $DatFichaIngresoModalidad->MinSigla?>" value="<?php echo stripslashes($FichaAccionPedido);?>" />
                                    <div class="EstFormularioObservacion"> <?php echo stripslashes($FichaAccionPedido);?></div></td>
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
                                  <td colspan="2" align="left" valign="top"><span class="EstFormularioSubTitulo">Fotos</span> <a href="javascript:FncFichaAccionFotoListar('<?php echo $DatFichaIngresoModalidad->MinSigla?>');"></a></td>
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
                                  <td colspan="2" align="left" valign="top"><div class="EstCapTrabajoTerminadoFotos" id="CapTrabajoTerminado<?php echo $DatFichaIngresoModalidad->MinSigla;?>Fotos"></div></td>
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
                          <tr>
                            <td align="left" valign="top">&nbsp;</td>
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
                                  <td align="left" valign="top"><div id="CapTrabajoTerminadoTareasResultado"> </div></td>
                                </tr>
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td colspan="2" align="left" valign="top"><div id="CapTrabajoTerminado<?php echo $DatFichaIngresoModalidad->MinSigla?>Tareas" class="EstCapTrabajoTerminadoTareas" > </div></td>
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
                                    <td><div id="CapTrabajoTerminado<?php echo $DatFichaIngresoModalidad->MinSigla?>ProductosResultado"> </div></td>
                                  </tr>
                                  <tr>
                                    <td>&nbsp;</td>
                                    <td colspan="2"><div id="CapTrabajoTerminado<?php echo $DatFichaIngresoModalidad->MinSigla?>Productos" class="EstCapTrabajoTerminadoProductos2" ></div></td>
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
                                  <td align="left" valign="top"></td>
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
                                  <td colspan="2" align="left" valign="top">                                    <div class="EstCapTrabajoTerminadoFotos" id="CapTrabajoTerminado<?php echo $DatFichaIngresoModalidad->MinSigla;?>Fotos"></div></td>
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
                          
                        </table>
                      </div>
                      
                        <?php
						 break;
						 
						 
					 }
					 
					 ?> 
                     
                     
                        
                      
					<?php
					/*if($DatFichaIngresoModalidad->MinId <> "MIN-10001"){
					?>

                   
                    
					<?php
					}else{
					?>	
					
                    <?php	
					}*/
					?>
                      
                      
                      
                      </td>
                    </tr>
                    </table>
                  
	</div>
    
	<?php
	$c++;
    }
    ?>



    
            <div id="tab<?php echo $c+4;?>" class="tab_content">
    	<table width="100%" border="0" cellpadding="2" cellspacing="2">
            
            <tr>
              <td width="97%" valign="top">
                <div class="EstFormularioArea">
                  <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                    <tr>
                      <td><span class="EstFormularioSubTitulo">Historial de Ordenes de Trabajo</span></td>
                      </tr>
                    <tr>
                      <td><div class="EstFormularioArea" >
                        <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                          <tr>
                            <td width="3%">&nbsp;</td>
                            <td width="47%"><div class="EstFormularioAccion" id="CapTrabajoTerminadoHistorialAccion">Listo
                              para registrar elementos</div></td>
                            <td width="49%" align="right"><a href="javascript:FncTrabajoTerminadoHistorialListar();"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a></td>
                            <td width="1%"><div id="CapTrabajoTerminadoHistorialesResultado"> </div></td>
                          </tr>
                          <tr>
                            <td>&nbsp;</td>
                            <td colspan="2"><div id="CapTrabajoTerminadoHistoriales" class="EstCapTrabajoTerminadoHistoriales" > </div></td>
                            <td>&nbsp;</td>
                          </tr>
                        </table>
                      </div></td>
                    </tr>
                    <tr>
                      <td><span class="EstFormularioSubTitulo">Historial de Cotizaciones</span></td>
                    </tr>
                    <tr>
                      <td><div class="EstFormularioArea" >
                        <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                          <tr>
                            <td width="3%">&nbsp;</td>
                            <td width="47%"><div class="EstFormularioAccion" id="CapTrabajoTerminadoCotizacionesAccion">Listo
                              para registrar elementos</div></td>
                            <td width="49%" align="right"><a href="javascript:FncTrabajoTerminadoCotizacionesListar();"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a></td>
                            <td width="1%"><div id="CapTrabajoTerminadoCotizacionesesResultado"> </div></td>
                          </tr>
                          <tr>
                            <td>&nbsp;</td>
                            <td colspan="2"><div id="CapTrabajoTerminadoCotizacioneses" class="EstCapTrabajoTerminadoCotizacioneses" > </div></td>
                            <td>&nbsp;</td>
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
                              <table width="852" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                                <tr>
                                  <td width="4">&nbsp;</td>
                                  <td width="780" colspan="10"><span class="EstFormularioSubTitulo">GASTOS  </span><span class="EstFormularioSubTitulo">
                                    
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
                              </table>
                            </div>
                            
                            
                            
                        </td>
                    </tr>
                    <tr>
                      <td><div class="EstFormularioArea" >
                        <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                          <tr>
                            <td width="1%">&nbsp;</td>
                            <td width="49%"><div class="EstFormularioAccion" id="CapTrabajoTerminadoGastoAccion">Listo
                              para registrar elementos</div></td>
                            <td width="49%" align="right"><a href="javascript:FncTrabajoTerminadoGastoListar();"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a></td>
                            <td width="1%"><div id="CapTrabajoTerminadoGastosResultado"> </div></td>
                            </tr>
                          <tr>
                            <td>&nbsp;</td>
                            <td colspan="2"><div id="CapTrabajoTerminadoGastos" class="EstCapTrabajoTerminadoGastos" > </div></td>
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
    
      
     <div id="tab2" class="tab_content">
    	<table width="100%" border="0" cellpadding="2" cellspacing="2">
            
            <tr>
              <td width="97%" valign="top">
                <div class="EstFormularioArea">
                  <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                    <tr>
                      <td>&nbsp;</td>
                      <td colspan="8"><span class="EstFormularioSubTitulo">Inventario de Ingreso</span></td>
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
                      <td>&nbsp;</td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>EXTERIORES</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>INTERIORES</td>
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
                      <td>&nbsp;</td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td><p>Lado Delantero</p></td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>Lado Derecho</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>Llave de Contacto:</td>
                      <td><input  name="CmpInterior1" type="text" class="EstFormularioCaja" id="CmpInterior1" value="<?php if(empty($InsFichaIngreso->FinInterior1)){ echo "1"; }else{echo $InsFichaIngreso->FinInterior1;}?>" size="10" maxlength="1" readonly="readonly" /></td>
                      <td>&nbsp;</td>
                      <td>Cenicero:</td>
                      <td><input class="EstFormularioCaja"  name="CmpInterior15" type="text" id="CmpInterior15" value="<?php if(empty($InsFichaIngreso->FinInterior15)){ echo "1"; }else{echo $InsFichaIngreso->FinInterior15;}?>" size="10" maxlength="1" /></td>
                      <td>&nbsp;</td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>Parachoque:</td>
                      <td><input  name="CmpExteriorDelantero1" type="text" class="EstFormularioCaja" id="CmpExteriorDelantero1" value="<?php if(empty($InsFichaIngreso->FinExteriorDelantero1)){ echo "1"; }else{echo $InsFichaIngreso->FinExteriorDelantero1;}?>" size="10" maxlength="1" readonly="readonly" /></td>
                      <td>&nbsp;</td>
                      <td>Gdfgo  Posterior:</td>
                      <td><input  name="CmpExteriorDerecho1" type="text" class="EstFormularioCaja" id="CmpExteriorDerecho1" value="<?php if(empty($InsFichaIngreso->FinExteriorDerecho1)){ echo "1"; }else{echo $InsFichaIngreso->FinExteriorDerecho1;}?>" size="10" maxlength="1" readonly="readonly" /></td>
                      <td>&nbsp;</td>
                      <td>Lunas Electricas:</td>
                      <td><input  name="CmpInterior2" type="text" class="EstFormularioCaja" id="CmpInterior2" value="<?php if(empty($InsFichaIngreso->FinInterior2)){ echo "1"; }else{echo $InsFichaIngreso->FinInterior2;}?>" size="10" maxlength="1" readonly="readonly" /></td>
                      <td>&nbsp;</td>
                      <td>Manual:</td>
                      <td><input class="EstFormularioCaja"  name="CmpInterior16" type="text" id="CmpInterior16" value="<?php if(empty($InsFichaIngreso->FinInterior16)){ echo "1"; }else{echo $InsFichaIngreso->FinInterior16;}?>" size="10" maxlength="1" /></td>
                      <td>&nbsp;</td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>Neblineros:</td>
                      <td><input  name="CmpExteriorDelantero2" type="text" class="EstFormularioCaja" id="CmpExteriorDelantero2" value="<?php if(empty($InsFichaIngreso->FinExteriorDelantero2)){ echo "1"; }else{echo $InsFichaIngreso->FinExteriorDelantero2;}?>" size="10" maxlength="1" readonly="readonly" /></td>
                      <td>&nbsp;</td>
                      <td>Tapa de Combustible:</td>
                      <td><input  name="CmpExteriorDerecho2" type="text" class="EstFormularioCaja" id="CmpExteriorDerecho2" value="<?php if(empty($InsFichaIngreso->FinExteriorDerecho2)){ echo "1"; }else{echo $InsFichaIngreso->FinExteriorDerecho2;}?>" size="10" maxlength="1" readonly="readonly" /></td>
                      <td>&nbsp;</td>
                      <td>Asiento (tela, cuero):</td>
                      <td><input  name="CmpInterior3" type="text" class="EstFormularioCaja" id="CmpInterior3" value="<?php if(empty($InsFichaIngreso->FinInterior3)){ echo "1"; }else{echo $InsFichaIngreso->FinInterior3;}?>" size="10" maxlength="1" readonly="readonly" /></td>
                      <td>&nbsp;</td>
                      <td>Antena:</td>
                      <td><input class="EstFormularioCaja"  name="CmpInterior17" type="text" id="CmpInterior17" value="<?php if(empty($InsFichaIngreso->FinInterior17)){ echo "1"; }else{echo $InsFichaIngreso->FinInterior17;}?>" size="10" maxlength="1" /></td>
                      <td>&nbsp;</td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>Faros:</td>
                      <td><input  name="CmpExteriorDelantero3" type="text" class="EstFormularioCaja" id="CmpExteriorDelantero3" value="<?php if(empty($InsFichaIngreso->FinExteriorDelantero3)){ echo "1"; }else{echo $InsFichaIngreso->FinExteriorDelantero3;}?>" size="10" maxlength="1" readonly="readonly" /></td>
                      <td>&nbsp;</td>
                      <td>Aros:</td>
                      <td><input  name="CmpExteriorDerecho3" type="text" class="EstFormularioCaja" id="CmpExteriorDerecho3" value="<?php if(empty($InsFichaIngreso->FinExteriorDerecho3)){ echo "1"; }else{echo $InsFichaIngreso->FinExteriorDerecho3;}?>" size="10" maxlength="1" readonly="readonly" /></td>
                      <td>&nbsp;</td>
                      <td>Asiento Piloto:</td>
                      <td><input  name="CmpInterior4" type="text" class="EstFormularioCaja" id="CmpInterior4" value="<?php if(empty($InsFichaIngreso->FinInterior4)){ echo "1"; }else{echo $InsFichaIngreso->FinInterior4;}?>" size="10" maxlength="1" readonly="readonly" /></td>
                      <td>&nbsp;</td>
                      <td>Copas de Aros / Vasos:</td>
                      <td><input class="EstFormularioCaja"  name="CmpInterior18" type="text" id="CmpInterior18" value="<?php if(empty($InsFichaIngreso->FinInterior18)){ echo "1"; }else{echo $InsFichaIngreso->FinInterior18;}?>" size="10" maxlength="1" /></td>
                      <td>&nbsp;</td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>Plumillas:</td>
                      <td><input  name="CmpExteriorDelantero4" type="text" class="EstFormularioCaja" id="CmpExteriorDelantero4" value="<?php if(empty($InsFichaIngreso->FinExteriorDelantero4)){ echo "1"; }else{echo $InsFichaIngreso->FinExteriorDelantero4;}?>" size="10" maxlength="1" readonly="readonly" /></td>
                      <td>&nbsp;</td>
                      <td>Puerta Posterior:</td>
                      <td><input  name="CmpExteriorDerecho4" type="text" class="EstFormularioCaja" id="CmpExteriorDerecho4" value="<?php if(empty($InsFichaIngreso->FinExteriorDerecho4)){ echo "1"; }else{echo $InsFichaIngreso->FinExteriorDerecho4;}?>" size="10" maxlength="1" readonly="readonly" /></td>
                      <td>&nbsp;</td>
                      <td>Controles de Tim&oacute;n:</td>
                      <td><input  name="CmpInterior5" type="text" class="EstFormularioCaja" id="CmpInterior5" value="<?php if(empty($InsFichaIngreso->FinInterior5)){ echo "1"; }else{echo $InsFichaIngreso->FinInterior5;}?>" size="10" maxlength="1" readonly="readonly" /></td>
                      <td>&nbsp;</td>
                      <td>Airbags:</td>
                      <td><input class="EstFormularioCaja"  name="CmpInterior19" type="text" id="CmpInterior19" value="<?php if(empty($InsFichaIngreso->FinInterior19)){ echo "1"; }else{echo $InsFichaIngreso->FinInterior19;}?>" size="10" maxlength="1" /></td>
                      <td>&nbsp;</td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>Parabrisas:</td>
                      <td><input  name="CmpExteriorDelantero5" type="text" class="EstFormularioCaja" id="CmpExteriorDelantero5" value="<?php if(empty($InsFichaIngreso->FinExteriorDelantero5)){ echo "1"; }else{echo $InsFichaIngreso->FinExteriorDelantero5;}?>" size="10" maxlength="1" readonly="readonly" /></td>
                      <td>&nbsp;</td>
                      <td>Puerta Delantera:</td>
                      <td><input  name="CmpExteriorDerecho5" type="text" class="EstFormularioCaja" id="CmpExteriorDerecho5" value="<?php if(empty($InsFichaIngreso->FinExteriorDerecho5)){ echo "1"; }else{echo $InsFichaIngreso->FinExteriorDerecho5;}?>" size="10" maxlength="1" readonly="readonly" /></td>
                      <td>&nbsp;</td>
                      <td>Perilla de Palanca:</td>
                      <td><input  name="CmpInterior6" type="text" class="EstFormularioCaja" id="CmpInterior6" value="<?php if(empty($InsFichaIngreso->FinInterior6)){ echo "1"; }else{echo $InsFichaIngreso->FinInterior6;}?>" size="10" maxlength="1" readonly="readonly" /></td>
                      <td>&nbsp;</td>
                      <td>Seguro Cromado Rueda:</td>
                      <td><input class="EstFormularioCaja"  name="CmpInterior20" type="text" id="CmpInterior20" value="<?php if(empty($InsFichaIngreso->FinInterior20)){ echo "1"; }else{echo $InsFichaIngreso->FinInterior20;}?>" size="10" maxlength="1" /></td>
                      <td>&nbsp;</td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>Emble:</td>
                      <td><input  name="CmpExteriorDelantero6" type="text" class="EstFormularioCaja" id="CmpExteriorDelantero6" value="<?php if(empty($InsFichaIngreso->FinExteriorDelantero6)){ echo "1"; }else{echo $InsFichaIngreso->FinExteriorDelantero6;}?>" size="10" maxlength="1" readonly="readonly" /></td>
                      <td>&nbsp;</td>
                      <td>Espejo Lateral:</td>
                      <td><input  name="CmpExteriorDerecho6" type="text" class="EstFormularioCaja" id="CmpExteriorDerecho6" value="<?php if(empty($InsFichaIngreso->FinExteriorDerecho6)){ echo "1"; }else{echo $InsFichaIngreso->FinExteriorDerecho6;}?>" size="10" maxlength="1" readonly="readonly" /></td>
                      <td>&nbsp;</td>
                      <td>Radio (Cass/CD/MP/A/C):</td>
                      <td><input  name="CmpInterior7" type="text" class="EstFormularioCaja" id="CmpInterior7" value="<?php if(empty($InsFichaIngreso->FinInterior7)){ echo "1"; }else{echo $InsFichaIngreso->FinInterior7;}?>" size="10" maxlength="1" readonly="readonly" /></td>
                      <td>&nbsp;</td>
                      <td>Gancho de remolque:</td>
                      <td><input class="EstFormularioCaja"  name="CmpInterior21" type="text" id="CmpInterior21" value="<?php if(empty($InsFichaIngreso->FinInterior21)){ echo "1"; }else{echo $InsFichaIngreso->FinInterior21;}?>" size="10" maxlength="1" /></td>
                      <td>&nbsp;</td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>Bicel/Mascara:</td>
                      <td><input  name="CmpExteriorDelantero7" type="text" class="EstFormularioCaja" id="CmpExteriorDelantero7" value="<?php if(empty($InsFichaIngreso->FinExteriorDelantero7)){ echo "1"; }else{echo $InsFichaIngreso->FinExteriorDelantero7;}?>" size="10" maxlength="1" readonly="readonly" /></td>
                      <td>&nbsp;</td>
                      <td>Gdfgo  Delantero:</td>
                      <td><input  name="CmpExteriorDerecho7" type="text" class="EstFormularioCaja" id="CmpExteriorDerecho7" value="<?php if(empty($InsFichaIngreso->FinExteriorDerecho7)){ echo "1"; }else{echo $InsFichaIngreso->FinExteriorDerecho7;}?>" size="10" maxlength="1" readonly="readonly" /></td>
                      <td>&nbsp;</td>
                      <td>A/C:</td>
                      <td><input  name="CmpInterior8" type="text" class="EstFormularioCaja" id="CmpInterior8" value="<?php if(empty($InsFichaIngreso->FinInterior8)){ echo "1"; }else{echo $InsFichaIngreso->FinInterior8;}?>" size="10" maxlength="1" readonly="readonly" /></td>
                      <td>&nbsp;</td>
                      <td>Estuche de Herram.:</td>
                      <td><input class="EstFormularioCaja"  name="CmpInterior22" type="text" id="CmpInterior22" value="<?php if(empty($InsFichaIngreso->FinInterior22)){ echo "1"; }else{echo $InsFichaIngreso->FinInterior22;}?>" size="10" maxlength="1" /></td>
                      <td>&nbsp;</td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>Lunas:</td>
                      <td><input  name="CmpExteriorDerecho8" type="text" class="EstFormularioCaja" id="CmpExteriorDerecho8" value="<?php if(empty($InsFichaIngreso->FinExteriorDerecho8)){ echo "1"; }else{echo $InsFichaIngreso->FinExteriorDerecho8;}?>" size="10" maxlength="1" readonly="readonly" /></td>
                      <td>&nbsp;</td>
                      <td>Reloj:</td>
                      <td><input class="EstFormularioCaja"  name="CmpInterior9" type="text" id="CmpInterior9" value="<?php if(empty($InsFichaIngreso->FinInterior9)){ echo "1"; }else{echo $InsFichaIngreso->FinInterior9;}?>" size="10" maxlength="1" /></td>
                      <td>&nbsp;</td>
                      <td>Gata llave de rueda Palanca:</td>
                      <td><input class="EstFormularioCaja"  name="CmpInterior23" type="text" id="CmpInterior23" value="<?php if(empty($InsFichaIngreso->FinInterior23)){ echo "1"; }else{echo $InsFichaIngreso->FinInterior23;}?>" size="10" maxlength="1" /></td>
                      <td>&nbsp;</td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>Lado Posterior</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>Espejo Retovisor:</td>
                      <td><input class="EstFormularioCaja"  name="CmpInterior10" type="text" id="CmpInterior10" value="<?php if(empty($InsFichaIngreso->FinInterior10)){ echo "1"; }else{echo $InsFichaIngreso->FinInterior10;}?>" size="10" maxlength="1" /></td>
                      <td>&nbsp;</td>
                      <td>Luz de Sal&oacute;n:</td>
                      <td><input class="EstFormularioCaja"  name="CmpInterior24" type="text" id="CmpInterior24" value="<?php if(empty($InsFichaIngreso->FinInterior24)){ echo "1"; }else{echo $InsFichaIngreso->FinInterior24;}?>" size="10" maxlength="1" /></td>
                      <td>&nbsp;</td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>Parachoque:</td>
                      <td><input  name="CmpExteriorPosterior1" type="text" class="EstFormularioCaja" id="CmpExteriorPosterior1" value="<?php if(empty($InsFichaIngreso->FinExteriorPosterior1)){ echo "1"; }else{echo $InsFichaIngreso->FinExteriorPosterior1;}?>" size="10" maxlength="1" readonly="readonly" /></td>
                      <td>&nbsp;</td>
                      <td>Lado Izquierdo</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>Correas de Seguridad:</td>
                      <td><input class="EstFormularioCaja"  name="CmpInterior11" type="text" id="CmpInterior11" value="<?php if(empty($InsFichaIngreso->FinInterior11)){ echo "1"; }else{echo $InsFichaIngreso->FinInterior11;}?>" size="10" maxlength="1" /></td>
                      <td>&nbsp;</td>
                      <td>Triangulo:</td>
                      <td><input class="EstFormularioCaja"  name="CmpInterior25" type="text" id="CmpInterior25" value="<?php if(empty($InsFichaIngreso->FinInterior25)){ echo "1"; }else{echo $InsFichaIngreso->FinInterior25;}?>" size="10" maxlength="1" /></td>
                      <td>&nbsp;</td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>Faros:</td>
                      <td><input  name="CmpExteriorPosterior2" type="text" class="EstFormularioCaja" id="CmpExteriorPosterior2" value="<?php if(empty($InsFichaIngreso->FinExteriorPosterior2)){ echo "1"; }else{echo $InsFichaIngreso->FinExteriorPosterior2;}?>" size="10" maxlength="1" readonly="readonly" /></td>
                      <td>&nbsp;</td>
                      <td>Gdfgo Posterior:</td>
                      <td><input  name="CmpExteriorIzquierdo1" type="text" class="EstFormularioCaja" id="CmpExteriorIzquierdo1" value="<?php if(empty($InsFichaIngreso->FinExteriorIzquierdo1)){ echo "1"; }else{echo $InsFichaIngreso->FinExteriorIzquierdo1;}?>" size="10" maxlength="1" readonly="readonly" /></td>
                      <td>&nbsp;</td>
                      <td>Tapasoles:</td>
                      <td><input class="EstFormularioCaja"  name="CmpInterior12" type="text" id="CmpInterior12" value="<?php if(empty($InsFichaIngreso->FinInterior12)){ echo "1"; }else{echo $InsFichaIngreso->FinInterior12;}?>" size="10" maxlength="1" /></td>
                      <td>&nbsp;</td>
                      <td>Extintor:</td>
                      <td><input class="EstFormularioCaja"  name="CmpInterior26" type="text" id="CmpInterior26" value="<?php if(empty($InsFichaIngreso->FinInterior26)){ echo "1"; }else{echo $InsFichaIngreso->FinInterior26;}?>" size="10" maxlength="1" /></td>
                      <td>&nbsp;</td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>Maletera:</td>
                      <td><input  name="CmpExteriorPosterior3" type="text" class="EstFormularioCaja" id="CmpExteriorPosterior3" value="<?php if(empty($InsFichaIngreso->FinExteriorPosterior3)){ echo "1"; }else{echo $InsFichaIngreso->FinExteriorPosterior3;}?>" size="10" maxlength="1" readonly="readonly" /></td>
                      <td>&nbsp;</td>
                      <td>Aros:</td>
                      <td><input  name="CmpExteriorIzquierdo2" type="text" class="EstFormularioCaja" id="CmpExteriorIzquierdo2" value="<?php if(empty($InsFichaIngreso->FinExteriorIzquierdo2)){ echo "1"; }else{echo $InsFichaIngreso->FinExteriorIzquierdo2;}?>" size="10" maxlength="1" readonly="readonly" /></td>
                      <td>&nbsp;</td>
                      <td>Sunroof:</td>
                      <td><input class="EstFormularioCaja"  name="CmpInterior13" type="text" id="CmpInterior13" value="<?php if(empty($InsFichaIngreso->FinInterior13)){ echo "1"; }else{echo $InsFichaIngreso->FinInterior13;}?>" size="10" maxlength="1" /></td>
                      <td>&nbsp;</td>
                      <td>Cobertor de Maletera:</td>
                      <td><input class="EstFormularioCaja"  name="CmpInterior27" type="text" id="CmpInterior27" value="<?php if(empty($InsFichaIngreso->FinInterior27)){ echo "1"; }else{echo $InsFichaIngreso->FinInterior27;}?>" size="10" maxlength="1" /></td>
                      <td>&nbsp;</td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>Plumillas:</td>
                      <td><input  name="CmpExteriorPosterior4" type="text" class="EstFormularioCaja" id="CmpExteriorPosterior4" value="<?php if(empty($InsFichaIngreso->FinExteriorPosterior4)){ echo "1"; }else{echo $InsFichaIngreso->FinExteriorPosterior4;}?>" size="10" maxlength="1" readonly="readonly" /></td>
                      <td>&nbsp;</td>
                      <td>Puerta Posterior:</td>
                      <td><input  name="CmpExteriorIzquierdo3" type="text" class="EstFormularioCaja" id="CmpExteriorIzquierdo3" value="<?php if(empty($InsFichaIngreso->FinExteriorIzquierdo3)){ echo "1"; }else{echo $InsFichaIngreso->FinExteriorIzquierdo3;}?>" size="10" maxlength="1" readonly="readonly" /></td>
                      <td>&nbsp;</td>
                      <td>Encendedor:</td>
                      <td><input class="EstFormularioCaja"  name="CmpInterior14" type="text" id="CmpInterior14" value="<?php if(empty($InsFichaIngreso->FinInterior14)){ echo "1"; }else{echo $InsFichaIngreso->FinInterior14;}?>" size="10" maxlength="1" /></td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>5ta Llave de Aro:</td>
                      <td><input  name="CmpExteriorPosterior5" type="text" class="EstFormularioCaja" id="CmpExteriorPosterior5" value="<?php if(empty($InsFichaIngreso->FinExteriorPosterior5)){ echo "1"; }else{echo $InsFichaIngreso->FinExteriorPosterior5;}?>" size="10" maxlength="1" readonly="readonly" /></td>
                      <td>&nbsp;</td>
                      <td>Puerta Delantera:</td>
                      <td><input  name="CmpExteriorIzquierdo4" type="text" class="EstFormularioCaja" id="CmpExteriorIzquierdo4" value="<?php if(empty($InsFichaIngreso->FinExteriorIzquierdo4)){ echo "1"; }else{echo $InsFichaIngreso->FinExteriorIzquierdo4;}?>" size="10" maxlength="1" readonly="readonly" /></td>
                      <td>&nbsp;</td>
                      <td colspan="5" rowspan="4" align="right"><table border="0" cellpadding="0" cellspacing="0">
                        <tr>
                          <td>1</td>
                          <td>&nbsp;</td>
                          <td>Buen Estado</td>
                          <td>&nbsp;</td>
                          </tr>
                        <tr>
                          <td>2</td>
                          <td>&nbsp;</td>
                          <td>Pintura Rayada</td>
                          <td>&nbsp;</td>
                          </tr>
                        <tr>
                          <td>3</td>
                          <td>&nbsp;</td>
                          <td>Abolladura</td>
                          <td>&nbsp;</td>
                          </tr>
                        <tr>
                          <td>4</td>
                          <td>&nbsp;</td>
                          <td>Rotura</td>
                          <td>&nbsp;</td>
                          </tr>
                        <tr>
                          <td>5</td>
                          <td>&nbsp;</td>
                          <td>Faltante</td>
                          <td>&nbsp;</td>
                          </tr>
                        <tr>
                          <td>6</td>
                          <td>&nbsp;</td>
                          <td>Oxido</td>
                          <td>&nbsp;</td>
                          </tr>
                        <tr>
                          <td>0</td>
                          <td>&nbsp;</td>
                          <td>No preseta</td>
                          <td>&nbsp;</td>
                          </tr>
                        </table></td>
                      <td>&nbsp;</td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>Emblema:</td>
                      <td><input  name="CmpExteriorPosterior6" type="text" class="EstFormularioCaja" id="CmpExteriorPosterior6" value="<?php if(empty($InsFichaIngreso->FinExteriorPosterior6)){ echo "1"; }else{echo $InsFichaIngreso->FinExteriorPosterior6;}?>" size="10" maxlength="1" readonly="readonly" /></td>
                      <td>&nbsp;</td>
                      <td>Espejo Lateral:</td>
                      <td><input  name="CmpExteriorIzquierdo5" type="text" class="EstFormularioCaja" id="CmpExteriorIzquierdo5" value="<?php if(empty($InsFichaIngreso->FinExteriorIzquierdo5)){ echo "1"; }else{echo $InsFichaIngreso->FinExteriorIzquierdo5;}?>" size="10" maxlength="1" readonly="readonly" /></td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>Gdfgo Delantero:</td>
                      <td><input  name="CmpExteriorIzquierdo6" type="text" class="EstFormularioCaja" id="CmpExteriorIzquierdo6" value="<?php if(empty($InsFichaIngreso->FinExteriorIzquierdo6)){ echo "1"; }else{echo $InsFichaIngreso->FinExteriorIzquierdo6;}?>" size="10" maxlength="1" readonly="readonly" /></td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>Lunas:</td>
                      <td><input  name="CmpExteriorIzquierdo7" type="text" class="EstFormularioCaja" id="CmpExteriorIzquierdo7" value="<?php if(empty($InsFichaIngreso->FinExteriorIzquierdo7)){ echo "1"; }else{echo $InsFichaIngreso->FinExteriorIzquierdo7;}?>" size="10" maxlength="1" readonly="readonly" /></td>
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
                      <td>&nbsp;</td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left" valign="top">Observacion:</td>
                      <td colspan="10" align="left" valign="top"><textarea name="CmpObservacion" cols="60" rows="2" readonly="readonly" class="EstFormularioCaja" id="CmpObservacion"><?php echo $InsFichaIngreso->FinObservacion;?></textarea></td>
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
                      <td>&nbsp;</td>
                      </tr>
                    
                    
                    </table>
                  
                  
                  
                  </div>     
                </td>
            </tr>
            </table>    
    </div>
 
	<div id="tab<?php echo $c;?>" class="tab_content">
		 <div class="EstFormularioArea">
	  <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
              <tr>
                <td width="1">&nbsp;</td>
                <td colspan="2"><span class="EstFormularioSubTitulo">OBSERVACIONES DE TALLER</span></td>
                <td width="1">&nbsp;</td>
                </tr>
              <tr>
                <td>&nbsp;</td>
                <td width="93" align="left" valign="top">&nbsp;</td>
                <td width="159" align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                </tr>
              <tr>
                <td>&nbsp;</td>
                <td align="left" valign="top">Observaciones:</td>
                <td align="left" valign="top"> 
        </td>
                <td align="left" valign="top">&nbsp;</td>
                </tr>
              <tr>
                <td>&nbsp;</td>
                <td colspan="2" align="left" valign="top">
        
        <script type="text/javascript">
      //  tinymce.init({
//          selector: "textarea#CmpObservacionSalida",
//          theme: "modern",
//          menubar : false,
//          toolbar1: "bold italic | bullist numlist",
//          width : 700,
//          height : 180
//        });
        </script>
        
        
        <!--<textarea name="CmpObservacionSalida" class="EstFormularioCaja" id="CmpObservacionSalida"><?php echo stripslashes($InsFichaIngreso->FinSalidaObservacion);?></textarea>
        -->
        
        
        
          <div class="EstFormularioCajaObservacion">
        <?php echo stripslashes($InsFichaIngreso->FinSalidaObservacion);?>
        </div>
          
        <input type="hidden" name="CmpObservacionSalida" id="CmpObservacionSalida" value="<?php echo stripslashes($InsFichaIngreso->FinSalidaObservacion);?>" />
        
        
                <!--  <div class="EstCapTrabajoTerminadoObservacion">
                <?php echo stripslashes($InsFichaIngreso->FinSalidaObservacion);?>
                </div>-->
                <!--<input type="hidden" name="CmpObservacionSalida" id="CmpObservacionSalida" value="<?php echo stripslashes($InsFichaIngreso->FinSalidaObservacion);?>" />--></td>
                <td align="left" valign="top">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td align="left" valign="top">Obs. Internas:</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td colspan="2" align="left" valign="top">
                
                  
          <div class="EstFormularioCajaObservacion">
        <?php echo stripslashes($InsFichaIngreso->CmpObservacionSalidaInterna);?>
        </div>
          
        <input type="hidden" name="CmpObservacionSalidaInterna" id="CmpObservacionSalidaInterna" value="<?php echo stripslashes($InsFichaIngreso->CmpObservacionSalidaInterna);?>" />
        
        
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
    
    <div id="tab<?php echo $c+2;?>" class="tab_content">
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
       
         </td>
	      <td align="left" valign="top">&nbsp;</td>
	      </tr>
	    <tr>
	      <td>&nbsp;</td>
	      <td colspan="2" align="left" valign="top">   
        <div class="EstFormularioCajaObservacion">
        <?php echo stripslashes($InsFichaIngreso->FinAlmacenObservacion);?>
        </div>
          
        <input type="hidden" name="CmpObservacionAlmaccen" id="CmpObservacionAlmacen" value="<?php echo stripslashes($InsFichaIngreso->FinAlmacenObservacion);?>" /></td>
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
 <div class="EstFormularioArea">
	  <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
	    <tr>
	      <td>&nbsp;</td>
	      <td colspan="2"><span class="EstFormularioSubTitulo">CONTENIDO DE ACTAS</span></td>
	      <td>&nbsp;</td>
	      </tr>
	    <tr>
	      <td>&nbsp;</td>
	      <td colspan="2" align="left" valign="top">Entrega de vehiculos </td>
	      <td align="left" valign="top">&nbsp;</td>
	      </tr>
	    <tr>
	      <td>&nbsp;</td>
	      <td align="left" valign="top">Fecha:</td>
	      <td align="left" valign="top"><input name="CmpActaEntregaFecha" type="text" class="EstFormularioCajaFecha" id="CmpActaEntregaFecha" value="<?php echo $InsFichaIngreso->FinActaEntregaFecha; ?>" size="15" maxlength="10" readonly="readonly" /></td>
	      <td align="left" valign="top">&nbsp;</td>
	      </tr>
	    <tr>
	      <td>&nbsp;</td>
	      <td align="left" valign="top">Contenido:</td>
	      <td align="left" valign="top"> 




<div class="EstFormularioCajaObservacion">
           <?php echo stripslashes($InsFichaIngreso->FinActaEntrega);?>
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
	    <tr>
	      <td>&nbsp;</td>
	      <td colspan="2" align="left" valign="top">Entrega de venta de vehiculo </td>
	      <td align="left" valign="top">&nbsp;</td>
	      </tr>
	    <tr>
	      <td>&nbsp;</td>
	      <td align="left" valign="top">Fecha:</td>
	      <td align="left" valign="top"><input name="CmpVentaFechaEntrega" type="text" class="EstFormularioCajaFecha" id="CmpVentaFechaEntrega" value="<?php echo $InsFichaIngreso->FinVentaFechaEntrega; ?>" size="15" maxlength="10" readonly="readonly" /></td>
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
    
   	
    
           <div id="tab<?php echo $c+3;?>" class="tab_content">
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
                                  <td width="136" align="left" valign="top">
                                  
                                  <span class="EstFormularioSubTitulo">Fotos</span></td>
                                  <td width="139" align="right" valign="top">

									<a href="javascript:FncTrabajoTerminadoFotoVINListar();"></a>

                                  </td>
                                  <td width="4" align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td align="right" valign="top"><a href="javascript:FncTrabajoTerminadoFotoVINListar();"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a></td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td align="left" valign="top">
<div id="fileuploaderVIN">Escoger Archivos</div>

        
				

                                    
                                  </td>
                                  <td align="left" valign="top"><div class="EstCapTrabajoTerminadoFotoVINs" id="CapTrabajoTerminadoFotoVINs"></div></td>
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
                                  <td width="138" align="left" valign="top">
                                  
                                  <span class="EstFormularioSubTitulo">Fotos</span></td>
                                  <td width="137" align="right" valign="top">

									<a href="javascript:FncTrabajoTerminadoFotoDelanteraListar();"></a>

                                  </td>
                                  <td width="4" align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td align="right" valign="top"><a href="javascript:FncTrabajoTerminadoFotoDelanteraListar();"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a></td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td align="left" valign="top">
<div id="fileuploaderDelantera">Escoger Archivos</div>

        
				

                                    
                                  </td>
								<td align="left" valign="top"><div class="EstCapTrabajoTerminadoFotoDelanteras" id="CapTrabajoTerminadoFotoDelanteras"></div></td>
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
                            <td width="136" align="right" valign="top"><a href="javascript:FncTrabajoTerminadoFotoCuponListar();"></a></td>
                            <td width="4" align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr>
                            <td align="left" valign="top">&nbsp;</td>
                            <td align="left" valign="top">&nbsp;</td>
                            <td align="right" valign="top"><a href="javascript:FncTrabajoTerminadoFotoCuponListar();"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a></td>
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr>
                            <td align="left" valign="top">&nbsp;</td>
                            <td align="left" valign="top"><div id="fileuploaderCupon">Escoger Archivos</div>
                              </td>
                            <td align="left" valign="top"><div class="EstCapTrabajoTerminadoFotoCupones" id="CapTrabajoTerminadoFotoCupones"></div></td>
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
                            <td width="139" align="left" valign="top"><span class="EstFormularioSubTitulo">Fotos</span></td>
                            <td width="136" align="right" valign="top"><a href="javascript:FncTrabajoTerminadoFotoMantenimientoListar();"></a></td>
                            <td width="4" align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr>
                            <td align="left" valign="top">&nbsp;</td>
                            <td align="left" valign="top">&nbsp;</td>
                            <td align="right" valign="top"><a href="javascript:FncTrabajoTerminadoFotoMantenimientoListar();"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a></td>
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr>
                            <td align="left" valign="top">&nbsp;</td>
                            <td align="left" valign="top"><div id="fileuploaderMantenimiento">Escoger Archivos</div>
                             </td>
                            <td align="left" valign="top"><div class="EstCapTrabajoTerminadoFotoMantenimientos" id="CapTrabajoTerminadoFotoMantenimientos"></div></td>
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