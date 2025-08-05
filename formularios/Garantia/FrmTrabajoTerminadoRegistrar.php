<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar")){
?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsGarantiaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsGarantiaTareaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsGarantiaProductoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsGarantiaSuministroFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsGarantiaMantenimientoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsGarantiaHerramientaFunciones.js" ></script>

<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssGarantia.css');
@import url('<?php echo $InsProyecto->MtdFormulariosCss("PlanMantenimiento");?>CssPlanMantenimiento.css');
</style>

<?php
$GET_Id = $_GET['Id'];
$POST_FichaIngresoEnviar = $_POST['CmpFichaIngresoEnviar'];

$Registro = false;

if(!empty($_POST['Identificador'])){
	$Identificador = $_POST['Identificador'];
}
include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjGarantia.php');
include($InsProyecto->MtdFormulariosMsj("FichaIngreso").'MsjFichaIngreso.php');

require_once($InsPoo->MtdPaqActividad().'ClsFichaAccion.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionTarea.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionProducto.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionMantenimiento.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionSuministro.php');

require_once($InsPoo->MtdPaqActividad().'ClsModalidadIngreso.php');

require_once($InsPoo->MtdPaqActividad().'ClsFichaIngreso.php');
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
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoVehiculoVersion.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoAno.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsListaPrecio.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoCosto.php');

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

		if (!isset($_SESSION['InsGarantiaTarea'.$DatFichaIngresoModalidad->MinSigla.$Identificador])){	
			$_SESSION['InsGarantiaTarea'.$DatFichaIngresoModalidad->MinSigla.$Identificador] = new ClsSesionObjeto();
		}else{	
			$_SESSION['InsGarantiaTarea'.$DatFichaIngresoModalidad->MinSigla.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsGarantiaTarea'.$DatFichaIngresoModalidad->MinSigla.$Identificador]);
		}		

		if (!isset($_SESSION['InsGarantiaProducto'.$DatFichaIngresoModalidad->MinSigla.$Identificador])){	
			$_SESSION['InsGarantiaProducto'.$DatFichaIngresoModalidad->MinSigla.$Identificador] = new ClsSesionObjeto();
		}else{	
			$_SESSION['InsGarantiaProducto'.$DatFichaIngresoModalidad->MinSigla.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsGarantiaProducto'.$DatFichaIngresoModalidad->MinSigla.$Identificador]);
		}
		
		if (!isset($_SESSION['InsGarantiaMantenimiento'.$DatFichaIngresoModalidad->MinSigla.$Identificador])){	
			$_SESSION['InsGarantiaMantenimiento'.$DatFichaIngresoModalidad->MinSigla.$Identificador] = new ClsSesionObjeto();
		}else{	
			$_SESSION['InsGarantiaMantenimiento'.$DatFichaIngresoModalidad->MinSigla.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsGarantiaMantenimiento'.$DatFichaIngresoModalidad->MinSigla.$Identificador]);
		}

		if (!isset($_SESSION['InsGarantiaSuministro'.$DatFichaIngresoModalidad->MinSigla.$Identificador])){	
			$_SESSION['InsGarantiaSuministro'.$DatFichaIngresoModalidad->MinSigla.$Identificador] = new ClsSesionObjeto();
		}else{	
			$_SESSION['InsGarantiaSuministro'.$DatFichaIngresoModalidad->MinSigla.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsGarantiaSuministro'.$DatFichaIngresoModalidad->MinSigla.$Identificador]);
		}
		
	}
}

if (!isset($_SESSION['InsGarantiaHerramienta'.$Identificador])){	
	$_SESSION['InsGarantiaHerramienta'.$Identificador] = new ClsSesionObjeto();
}else{	
	$_SESSION['InsGarantiaHerramienta'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsGarantiaHerramienta'.$Identificador]);
}

$RepPlanMantenimientoSeccion = $InsPlanMantenimientoSeccion->MtdObtenerPlanMantenimientoSecciones(NULL,NULL,"PmsId","ASC",NULL);
$ArrPlanMantenimientoSecciones = $RepPlanMantenimientoSeccion['Datos'];

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
*/include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccGarantiaRegistrar.php');

$ResModalidadIngreso = $InsModalidadIngreso->MtdObtenerModalidadIngresos(NULL,NULL,'MinId','ASC',NULL);
$ArrModalidadIngresos = $ResModalidadIngreso['Datos'];
?>

<?php

//deb($InsFichaIngreso->FinEstado);
if($InsFichaIngreso->FinEstado == 73){
//if($InsFichaIngreso->FinEstado == 74 or $InsFichaIngreso->FinEstado == 73){
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

	FncGarantiaHerramientaListar();

	$('input[type=checkbox]').each(function () {
		if($(this).attr('etiqueta')=="modalidad"){
			
			FncGarantiaTareaListar($(this).attr('sigla'));
			FncGarantiaTareaListar2($(this).attr('sigla'));

			FncGarantiaProductoListar($(this).attr('sigla'));
			FncGarantiaProductoListar2($(this).attr('sigla'));

			FncGarantiaSuministroListar($(this).attr('sigla'));
			FncGarantiaSuministroListar2($(this).attr('sigla'));

			FncGarantiaMantenimientoListar($(this).attr('sigla'));

		}
	});

});

/*
Configuracion Formulario
*/

var Formulario = "FrmRegistrar";

var GarantiaTareaEditar = 2;
var GarantiaTareaEliminar = 2;

var GarantiaProductoEditar = 2;
var GarantiaProductoEliminar = 2;

var GarantiaSuministroEditar = 2;
var GarantiaSuministroEliminar = 2;

var FichaAccionMantenimientoEditar = 2;
var FichaAccionMantenimientoEliminar = 2;

var GarantiaHerramientaEditar = 2;
var GarantiaHerramientaEliminar = 2;
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
	<div class="EstSubMenuBoton"><a href="javascript:self.parent.tb_remove('<?php echo $GET_mod;?>');" ><img src="imagenes/iconos/salir.png" alt="[Salir]" title="Salir" border="0"  />Salir</a></div>
<?php	
}
?>
	



<?php
if($Registro){
?>    

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
}
?>            

</div>

<div class="EstCapContenido">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
      
      <tr>
        <td width="1922" height="25" colspan="2"><span class="EstFormularioTitulo">REVISAR  ORDEN DE TRABAJO TERMINADO</span></td>
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
      <td colspan="5" align="left" valign="top"><input name="CmpFichaIngresoCliente" type="text" class="EstFormularioCaja" id="CmpFichaIngresoCliente" value="<?php echo $InsFichaIngreso->CliNombre;?>" size="45" readonly="readonly" /></td>
      <td align="left" valign="top"><input type="hidden" name="Guardar" id="Guardar"   />
        <input type="hidden" name="Identificador" id="Identificador"  value="<?php echo $Identificador; ?>" />
        <input name="CmpFichaIngresoVehiculoVersion" type="hidden" class="EstFormularioCaja" id="CmpFichaIngresoVehiculoVersion" value="<?php echo $InsFichaIngreso->VveId;?>"  /><!-- REVISAR -->
        <input name="CmpFichaIngresoMantenimientoKilometraje" type="hidden" class="EstFormularioCaja" id="CmpFichaIngresoMantenimientoKilometraje" value="<?php echo $InsFichaIngreso->FinMantenimientoKilometraje;?>"  />
        <input name="CmpFichaIngresoEstado" type="hidden" class="EstFormularioCaja" id="CmpFichaIngresoEstado" value="<?php echo $InsFichaIngreso->FinEstado;?>"  />
        <input name="CmpVehiculoIngresoMarcaId" type="hidden" class="EstFormularioCaja" id="CmpVehiculoIngresoMarcaId" value="<?php echo $InsFichaIngreso->VmaId;?>"  />
        <input name="CmpVehiculoIngresoModeloId" type="hidden" class="EstFormularioCaja" id="CmpVehiculoIngresoModeloId" value="<?php echo $InsFichaIngreso->VmoId;?>"  />
        <input name="CmpVehiculoIngresoVersionId" type="hidden" class="EstFormularioCaja" id="CmpVehiculoIngresoVersionId" value="<?php echo $InsFichaIngreso->VveId;?>"  />
        <input name="CmpVehiculoIngresoAnoFabricacion" type="hidden" class="EstFormularioCaja" id="CmpVehiculoIngresoAnoFabricacion" value="<?php echo $InsFichaIngreso->EinAnoFabricacion;?>"  /></td>
    </tr>
    <tr>
      <td align="left" valign="top"> Placa </td>
      <td align="left" valign="top"><input name="CmpFichaIngresoPlaca2" type="text" class="EstFormularioCaja" id="CmpFichaIngresoPlaca2" value="<?php echo $InsFichaIngreso->EinPlaca;?>" size="15" readonly="readonly" /></td>
      <td align="left" valign="top">VIN:</td>
      <td align="left" valign="top"><input name="CmpFichaIngresoVIN2" type="text" class="EstFormularioCaja" id="CmpFichaIngresoVIN2" value="<?php echo $InsFichaIngreso->EinVIN;?>" size="15" readonly="readonly" /></td>
      <td align="left" valign="top">Marca:</td>
      <td align="left" valign="top"><input name="CmpFichaIngresoMarca2" type="text" class="EstFormularioCaja" id="CmpFichaIngresoMarca2" value="<?php echo $InsFichaIngreso->VmaNombre;?>" size="15" readonly="readonly" /></td>
      <td align="left" valign="top">Modelo:</td>
      <td align="left" valign="top"><input name="CmpFichaIngresoModelo2" type="text" class="EstFormularioCaja" id="CmpFichaIngresoModelo2" value="<?php echo $InsFichaIngreso->VmoNombre;?>" size="15" readonly="readonly" /></td>
      <td align="left" valign="top">Version:</td>
      <td align="left" valign="top"><input name="CmpFichaIngresoVersion2" type="text" class="EstFormularioCaja" id="CmpFichaIngresoVersion2" value="<?php echo $InsFichaIngreso->VveNombre;?>" size="15" readonly="readonly" /></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="11" align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="11" align="left" valign="top"><input checked="checked" type="checkbox" name="CmpFichaIngresoEnviar" id="CmpFichaIngresoEnviar" value="1" />
        <label for="CmpFichaIngresoEnviar">Enviar a ORDEN DE TRABAJO a FACTURACION una vez guardado este formulario</label></td>
    </tr>
    </table>
</div>  
<br />


<?php
//deb($ArrFichaAccion);
?>
          
<ul class="tabs">

	<?php
	$c=3;
	//foreach($InsFichaIngreso->FichaIngresoModalidad as $DatFichaAccion){
	foreach($ArrFichaAccion as $DatFichaAccion){
    ?>
		<li><a href="#tab<?php echo $c;?>"><?php echo $DatFichaAccion->MinNombre;?></a></li>
	<?php
	$c++;
    }
    ?>
    
	<li><a href="#tab1">Herramientas</a></li>
	<li><a href="#tab2">Inventario</a></li>
	<li><a href="#tab<?php echo $c;?>">Observaciones</a></li>

</ul>
	
<div class="tab_container">




	<?php
	$c=3;
	//foreach($InsFichaIngreso->FichaIngresoModalidad as $DatFichaAccion){
	foreach($ArrFichaAccion as $DatFichaAccion){
		
	//	deb($DatFichaAccion);
	?>

	<div id="tab<?php echo $c;?>" class="tab_content">

                    <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                    <tr>
                      <td colspan="4">
                      
                      <div class="EstFormularioArea">
                        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                          <tr>
                            <td width="4">&nbsp;</td>
                            <td colspan="2"><span class="EstFormularioSubTitulo">Datos de la  SUB ORDEN DE TRABAJO: <?php echo strtoupper($DatFichaAccion->MinNombre);?>
                              
                            </span></td>
                            <td width="4">&nbsp;</td>
                          </tr>
                          <tr>
                            <td>&nbsp;</td>
                            <td width="106" align="left" valign="top"><input style="visibility:hidden;" etiqueta="modalidad" checked="checked"  type="checkbox" value="<?php echo $DatFichaAccion->MinId?>" name="CmpModalidadId_<?php echo $DatFichaAccion->MinSigla?>" id="CmpModalidadId_<?php echo $DatFichaAccion->MinSigla?>" sigla="<?php echo $DatFichaAccion->MinSigla?>" /></td>
                            <td width="174" align="left" valign="top"><input name="CmpFecha_<?php echo $DatFichaAccion->MinSigla?>" type="hidden" id="CmpFecha_<?php echo $DatFichaAccion->MinSigla?>" value="<?php echo $DatFichaAccion->FccFecha;?>" />
                              <input name="CmpObservacion_<?php echo $DatFichaAccion->MinSigla?>" type="hidden" id="CmpObservacion_<?php echo $DatFichaAccion->MinSigla?>" value="<?php echo $DatFichaAccion->FccObservacion;?>" />
                              <input name="CmpModalidadIngresoSigla_<?php echo $DatFichaAccion->MinSigla?>" type="hidden" id="CmpModalidadIngresoSigla_<?php echo $DatFichaAccion->MinSigla?>" value="<?php echo $DatFichaAccion->MinSigla?>" />
                              <input name="CmpModalidadIngresoNombre_<?php echo $DatFichaAccion->MinSigla?>" type="hidden" id="CmpModalidadIngresoNombre_<?php echo $DatFichaAccion->MinSigla?>" value="<?php echo $DatFichaAccion->MinNombre;?>" />
                              <input name="CmpModalidadIngresoId_<?php echo $DatFichaAccion->MinSigla?>" type="hidden" id="CmpModalidadIngresoId_<?php echo $DatFichaAccion->MinSigla?>" value="<?php echo $DatFichaAccion->MinId;?>" />
                            <input name="CmpId_<?php echo $DatFichaAccion->MinSigla?>" type="hidden" class="EstFormularioCaja" id="CmpId_<?php echo $DatFichaAccion->MinSigla?>" value="<?php echo $DatFichaAccion->FccId;?>" size="15" maxlength="20" readonly="readonly" /></td>
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr>
                            <td>&nbsp;</td>
                            <td align="left" valign="top">Costo de Mano de Obra:</td>
                            <td align="left" valign="top"><input class="EstFormularioCaja" name="CmpFichaAccionManoObra_<?php echo $DatFichaAccion->MinSigla?>" type="text" id="CmpFichaAccionManoObra_<?php echo $DatFichaAccion->MinSigla?>" value="<?php echo number_format($DatFichaAccion->FccManoObra,2);?>" size="10" maxlength="10" /></td>
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
                      
                      </td>
                    </tr>
                    <tr>
                      <td colspan="4">
                      
                      
					<?php
					if($DatFichaAccion->MinId <> "MIN-10001"){
					?>

                     <div class="EstFormularioArea" id="CapModalidad">
                        <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                          <tr>
                            <td colspan="3" align="center"><span class="EstFormularioSubTitulo">Tareas y Productos: <?php echo strtoupper($DatFichaAccion->MinNombre);?></span></td>
                          </tr>
                          <tr>
                            <td width="33%" align="left" valign="top"><div class="EstFormularioArea" >
                              <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                                <tr>
                                  <td width="2%" align="left" valign="top">&nbsp;</td>
                                  <td colspan="2" align="left" valign="top">TAREAS asignadas en la Orden de Trabajo</td>
                                  <td width="1%" align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td colspan="2" align="left" valign="top"><div id="CapFichaAccion<?php echo $DatFichaAccion->MinSigla?>Tareas2" class="EstCapGarantiaTareas2" > </div></td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td colspan="2" align="left" valign="top">* Marque el casillero de verificacion si la TAREA se va llevar a cabo caso contrario dejarlo sin marcar.</td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td colspan="2" align="left" valign="top">&nbsp;</td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td width="49%" align="left" valign="top"><div class="EstFormularioAccion" id="CapTareaAccion">Listo
                                    para registrar elementos<a href="javascript:FncGarantiaTareaEliminarTodo('<?php echo $DatFichaAccion->MinSigla?>');"></a></div></td>
                                  <td width="48%" align="right" valign="top"><a href="javascript:FncGarantiaTareaListar('<?php echo $DatFichaAccion->MinSigla?>');"><img  src="imagenes/recargar.gif"  width="20" height="20"  border="0" title="Recargar"   alt="[Recargar]" align="absmiddle"/></a></td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td colspan="2" align="left" valign="top">TAREAS adicionales</td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td colspan="2" align="left" valign="top"><div id="CapFichaAccion<?php echo $DatFichaAccion->MinSigla?>Tareas" class="EstCapGarantiaTareas2" > </div></td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td colspan="2" align="left" valign="top">* Las TAREAS adicionales a las que se asignaron inicialmente en la Orden de Trabajo van en este espacio</td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                              </table>
                            </div></td>
                            <td width="33%" align="left" valign="top"><div class="EstFormularioArea" >
                              <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                                <tr>
                                  <td width="2%">&nbsp;</td>
                                  <td colspan="2">PRODUCTOS asignados en la Orden de Trabajo</td>
                                  <td width="2%">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td colspan="2"><div id="CapFichaAccion<?php echo $DatFichaAccion->MinSigla?>Productos2" class="EstCapGarantiaProductos2" > </div></td>
                                  <td>&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td colspan="2"> * Marque el casillero de verificacion si el PRODUCTO va a ser solicitado como PEDIDO a ALMACEN <br />
                                    * No olvide definir la UNIDAD DE MEDIDA y la CANTIDAD a solicitar </td>
                                  <td>&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td colspan="2">&nbsp;</td>
                                  <td>&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td width="50%"><div class="EstFormularioAccion" id="Cap<?php echo $DatFichaAccion->MinSigla?>ProductoAccion">Listo
                                    para registrar elementos </div></td>
                                  <td width="46%" align="right"><a href="javascript:FncGarantiaProductoListar('<?php echo $DatFichaAccion->MinSigla?>');"><img  src="imagenes/recargar.gif"  width="20" height="20"  border="0" title="Recargar"   alt="[Recargar]" align="absmiddle"/></a></td>
                                  <td>&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td colspan="2">PRODUCTOS adicionales</td>
                                  <td>&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td colspan="2"><div id="CapFichaAccion<?php echo $DatFichaAccion->MinSigla?>Productos" class="EstCapGarantiaProductos2" ></div></td>
                                  <td>&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td colspan="2">* Los PRODUCTOS adicionales a las que se asignaron inicialmente en la Orden de Trabajo van en este espacio</td>
                                  <td>&nbsp;</td>
                                </tr>
                              </table>
                            </div></td>
                            <td width="34%" align="left" valign="top"><div class="EstFormularioArea" >
                              <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                                <tr>
                                  <td width="1%">&nbsp;</td>
                                  <td colspan="2"><span class="EstFormularioSubTitulo">SUMINISTROS</span> asignados en la Orden de Trabajo</td>
                                  <td width="2%">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td colspan="2"><div id="CapFichaAccion<?php echo $DatFichaAccion->MinSigla?>Suministros2" class="EstCapGarantiaSuministros2" > </div></td>
                                  <td>&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td colspan="2">* Los <span class="EstFormularioSubTitulo">SUMINISTROS</span> asignados inicialmente desde la ORDEN DE TRABAJO van en este espacio<br />
                                    * Marque el casillero de verificacion si el SUMINISTRO va a ser solicitado como PEDIDO a ALMACEN </td>
                                  <td>&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td colspan="2">&nbsp;</td>
                                  <td>&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td width="50%"><div class="EstFormularioAccion" id="Cap<?php echo $DatFichaAccion->MinSigla?>SuministroAccion">Listo
                                    para registrar elementos </div></td>
                                  <td width="47%" align="right"><a href="javascript:FncGarantiaSuministroListar('<?php echo $DatFichaAccion->MinSigla?>');"><img  src="imagenes/recargar.gif"  width="20" height="20"  border="0" title="Recargar"   alt="[Recargar]" align="absmiddle"/></a></td>
                                  <td>&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td colspan="2">SUMINISTROS adicionales</td>
                                  <td>&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td colspan="2"><div id="CapFichaAccion<?php echo $DatFichaAccion->MinSigla?>Suministros" class="EstCapGarantiaSuministros2" ></div></td>
                                  <td>&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td colspan="2">* Los SUMINISTROS adicionales a las que se asignaron inicialmente en la Orden de Trabajo van en este espacio</td>
                                  <td>&nbsp;</td>
                                </tr>
                              </table>
                            </div>
                            
                            </td>
                          </tr>
                        </table>
                      </div>
                      
                    
					<?php
					}else{
					?>	
					<div class="EstFormularioArea" >
                        <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                          <tr>
                            <td width="0%">&nbsp;</td>
                            <td width="49%"><span class="EstFormularioSubTitulo"> Tareas del Plan de Mantenimiento</span></td>
                            <td width="51%" align="right"><a href="javascript:FncGarantiaMantenimientoListar('<?php echo $DatFichaAccion->MinSigla?>');"><img  src="imagenes/recargar.gif"  width="20" height="20"  border="0" title="Recargar"   alt="[Recargar]" align="absmiddle"/> Recargar</a></td>
                            <td width="0%">&nbsp;</td>
                          </tr>
                          <tr>
                            <td>&nbsp;</td>
                            <td colspan="2"><div id="CapFichaAccion<?php echo $DatFichaAccion->MinSigla?>Mantenimientos" class="EstCapGarantiaMantenimientos" > </div></td>
                            <td><div id="CapFichaAccion<?php echo $DatFichaAccion->MinSigla?>MantenimientosResultado"> </div></td>
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
                           
                            <td width="50%" align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr>
                           
                            <td align="left" valign="top"><div class="EstFormularioArea" >
                              <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                                <tr>
                                  <td width="0%">&nbsp;</td>
                                  <td width="50%"><div class="EstFormularioAccion" id="CapHerramientaAccion">Listo
                                    para registrar elementos
                                      
                                  </div></td>
                                  <td width="49%" align="right"><a href="javascript:FncGarantiaHerramientaListar();"><img  src="imagenes/recargar.gif"  width="20" height="20"  border="0" title="Recargar"   alt="[Recargar]" align="absmiddle"/></a><a href="javascript:FncGarantiaHerramientaEliminarTodo();"><img  src="imagenes/eliminar_todo.png"  width="20" height="20"  border="0" title="Eliminar Todo"   alt="[Eli. Todo.]" align="absmiddle"/></a></td>
                                  <td width="1%"><div id="CapFichaAccionHerramientasResultado"> </div></td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td colspan="2"><div id="CapFichaAccionHerramientas" class="EstCapGarantiaHerramientas" ></div></td>
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
                      <td colspan="10" align="left" valign="top"><textarea name="CmpObservacion" cols="60" rows="2" class="EstFormularioCaja" id="CmpObservacion"><?php echo $InsFichaIngreso->FinObservacion;?></textarea></td>
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
	      <td>&nbsp;</td>
	      <td colspan="2"><span class="EstFormularioSubTitulo">Observaciones  de la ORDEN DE TRABAJO: <?php echo strtoupper($DatFichaAccion->MinNombre);?> </span></td>
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
	      <td align="left" valign="top"><textarea name="CmpObservacionSalida" cols="60" rows="2" readonly="readonly" class="EstFormularioCaja" id="CmpObservacionSalida"><?php echo stripslashes($InsFichaIngreso->FinSalidaObservacion);?></textarea></td>
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
Calendar.setup({ 
	inputField : "CmpFecha",  // id del campo de texto 
	ifFormat   : "%d/%m/%Y",  //  
	button     : "BtnFecha"// el id del botón que  
	});
</script>

<?php
}else{
	echo ERR_TTE_301;
}
?>



<?php
}else{
	echo ERR_GEN_101;
}


	if(!$_SESSION['MysqlDeb']){
		$InsMensaje->MtdRedireccionar("principal.php?Mod=".$GET_mod."&Form=Listado",$Registro,1500);
	}




?>