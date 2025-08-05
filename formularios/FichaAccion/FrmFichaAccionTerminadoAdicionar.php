<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar")){
?>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsFichaAccionFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsFichaAccionTareaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsFichaAccionProductoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsFichaAccionSuministroFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsFichaAccionMantenimientoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsFichaAccionHerramientaFunciones.js" ></script>

<style type="text/css">
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


$ResModalidadIngreso = $InsModalidadIngreso->MtdObtenerModalidadIngresos(NULL,NULL,"MinId","ASC",NULL,"1,3");
$ArrModalidadIngresos = $ResModalidadIngreso['Datos'];

if(!empty($InsFichaIngreso->FichaIngresoModalidad)){
	foreach($InsFichaIngreso->FichaIngresoModalidad as $DatFichaIngresoModalidad){
			
			
		if (!isset($_SESSION['InsFichaAccionTarea'.$DatFichaIngresoModalidad->MinSigla.$Identificador])){	
			$_SESSION['InsFichaAccionTarea'.$DatFichaIngresoModalidad->MinSigla.$Identificador] = new ClsSesionObjeto();
		}else{	
			$_SESSION['InsFichaAccionTarea'.$DatFichaIngresoModalidad->MinSigla.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsFichaAccionTarea'.$DatFichaIngresoModalidad->MinSigla.$Identificador]);
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

	}
}

if (!isset($_SESSION['InsFichaAccionHerramienta'.$Identificador])){	
	$_SESSION['InsFichaAccionHerramienta'.$Identificador] = new ClsSesionObjeto();
}else{	
	$_SESSION['InsFichaAccionHerramienta'.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsFichaAccionHerramienta'.$Identificador]);
}


$RepPlanMantenimientoSeccion = $InsPlanMantenimientoSeccion->MtdObtenerPlanMantenimientoSecciones(NULL,NULL,"PmsId","ASC",NULL);
$ArrPlanMantenimientoSecciones = $RepPlanMantenimientoSeccion['Datos'];

if($InsFichaIngreso->FinEstado==4  || $InsFichaIngreso->FinEstado==5 || $InsFichaIngreso->FinEstado==6 || $InsFichaIngreso->FinEstado == 72 ){
	
	include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccFichaAccionAdicionar.php');
	
}

$ResModalidadIngreso = $InsModalidadIngreso->MtdObtenerModalidadIngresos(NULL,NULL,'MinId','ASC',NULL,"1,3");
$ArrModalidadIngresos = $ResModalidadIngreso['Datos'];


?>

<?php
//deb($InsFichaIngreso->FinEstado);
?>

<?php
if($InsFichaIngreso->FinEstado==4 || $InsFichaIngreso->FinEstado==5 || $InsFichaIngreso->FinEstado==6 || $InsFichaIngreso->FinEstado == 72 ){
//if($InsFichaIngreso->FinEstado==2 or $InsFichaIngreso->FinEstado==3 or $InsFichaIngreso->FinEstado==7 or $InsFichaIngreso->FinEstado==71){
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
			FncFichaAccionTareaListar($(this).attr('sigla'));
			FncFichaAccionTareaListar2($(this).attr('sigla'));
			
			FncFichaAccionProductoListar($(this).attr('sigla'));
			FncFichaAccionProductoListar2($(this).attr('sigla'));
			
			FncFichaAccionSuministroListar($(this).attr('sigla'));
			FncFichaAccionSuministroListar2($(this).attr('sigla'));
			
			FncFichaAccionMantenimientoListar($(this).attr('sigla'));
		}			 
	});

});

/*
Configuracion Formulario
*/

var Formulario = "FrmEditar";

var FichaAccionTareaEditar = 1;
var FichaAccionTareaEliminar = 1;

var FichaAccionProductoEditar = 2;
var FichaAccionProductoEliminar = 2;

var FichaAccionSuministroEditar = 2;
var FichaAccionSuministroEliminar = 2;

var FichaAccionMantenimientoEditar = 2;
var FichaAccionMantenimientoEliminar = 2;

var FichaAccionHerramientaEditar = 2;
var FichaAccionHerramientaEliminar = 2;

var FichaAccionRecibirMantenimientoEditar = 1;

</script>


<form id="FrmEditar" name="FrmEditar" method="post" action="#" enctype="multipart/form-data" onsubmit="FncGuardar();" >

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
}
?>            

</div>

<div class="EstCapContenido">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
      
      <tr>
        <td width="1922" height="25" colspan="2"><span class="EstFormularioTitulo">ADICIONAR SUB ORDENES DE TRABAJO</span></td>
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
        <input name="CmpVehiculoIngresoAnoFabricacion" type="hidden" class="EstFormularioCaja" id="CmpVehiculoIngresoAnoFabricacion" value="<?php echo $InsFichaIngreso->EinAnoFabricacion;?>"  /></td>
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
          <td colspan="11" align="left" valign="top">&nbsp;</td>
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
		<li><a id="TabModalidad<?php echo $DatFichaIngresoModalidad->MinSigla;;?>" href="#tab<?php echo $c;?>"><?php echo $DatFichaIngresoModalidad->MinNombre;?></a></li>
	<?php
	$c++;
    }
    ?>
    
     <li><a href="#tab1">Herramientas</a></li>
     <li><a href="#tab<?php echo $c;?>">Observaciones</a></li>

</ul>
	
<div class="tab_container">


    
	<?php
	$c=2;
	//foreach($ArrModalidadIngresos  as $DatFichaIngresoModalidad){
	foreach($InsFichaIngreso->FichaIngresoModalidad as $DatFichaIngresoModalidad){	
			$FichaAccionId = '';
			$FichaAccionFecha = date("d/m/Y");
			$FichaAccionObservacion = '';
			$FichaIngresoModalidadId = '';
						
            if(!empty($ArrFichaAccion)){	
                foreach($ArrFichaAccion as $DatFichaAccion ){
					
                    if($DatFichaIngresoModalidad->MinId==$DatFichaAccion->MinId){

						$FichaAccionId = $DatFichaAccion->FccId;
						$FichaAccionFecha = $DatFichaAccion->FccFecha;
						$FichaAccionObservacion = $DatFichaAccion->FccObservacion;
						$FichaIngresoModalidadId = $DatFichaAccion->FimId;
                      
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
                            <td colspan="2"><span class="EstFormularioSubTitulo">Datos de la SUB ORDEN DE TRABAJO: <?php echo strtoupper($DatFichaIngresoModalidad->MinNombre);?>
                              
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
//					if($DatFichaAccion->MinId <> "MIN-10001"){
					if($DatFichaIngresoModalidad->MinId <> "MIN-10001"){
						
					?>

                     <div class="EstFormularioArea" id="CapModalidad">
                        <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                          <tr>
                            <td colspan="3" align="center"><span class="EstFormularioSubTitulo">Tareas y Productos: <?php echo strtoupper($DatFichaIngresoModalidad->MinNombre);?></span></td>
                          </tr>
                          <tr>
                            <td width="33%" align="left" valign="top">&nbsp;</td>
                            <td width="33%" align="left" valign="top">&nbsp;</td>
                            <td width="34%" align="left" valign="top">
                             <?php
							if($InsFichaIngreso->FinEstado<>7 and $InsFichaIngreso->FinEstado<>71){
							?>
                             <?php
							}
							?>                           
                            </td>
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
                                  <td colspan="2" align="left" valign="top"><div id="CapFichaAccion<?php echo $DatFichaIngresoModalidad->MinSigla?>Tareas2" class="EstCapFichaAccionTareas2" > </div></td>
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
                                    para registrar elementos<a href="javascript:FncFichaAccionTareaEliminarTodo('<?php echo $DatFichaIngresoModalidad->MinSigla?>');"></a></div></td>
                                  <td width="48%" align="right" valign="top"><a href="javascript:FncFichaAccionTareaListar('<?php echo $DatFichaIngresoModalidad->MinSigla?>');"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a> <a href="javascript:FncFichaAccionTareaEliminarTodo('<?php echo $DatFichaIngresoModalidad->MinSigla?>');"><img  src="imagenes/acciones/listado_eliminar_todo.png"  width="25" height="25"  border="0" title="Eliminar Todo"   alt="[Eli. Todo.]" align="absmiddle"/> Eliminar Todo</a></td>
                                  <td align="left" valign="top"><div id="CapFichaAccionTareasResultado"> </div></td>
                                </tr>
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td colspan="2" align="left" valign="top">TAREAS adicionales</td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td colspan="2" align="left" valign="top"><div id="CapFichaAccion<?php echo $DatFichaIngresoModalidad->MinSigla?>Tareas" class="EstCapFichaAccionTareas2" > </div></td>
                                  <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  <td colspan="2" align="left" valign="top">* Las TAREAS adicionales a las que se asignaron inicialmente en la Orden de Trabajo van en este espacio</td>
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
                                  <td colspan="2"><div id="CapFichaAccion<?php echo $DatFichaIngresoModalidad->MinSigla?>Productos2" class="EstCapFichaAccionProductos" > </div></td>
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
                                  <td width="50%"><div class="EstFormularioAccion" id="Cap<?php echo $DatFichaIngresoModalidad->MinSigla?>ProductoAccion">Listo
                                    para registrar elementos </div></td>
                                  <td width="46%" align="right"><a href="javascript:FncFichaAccionProductoListar('<?php echo $DatFichaIngresoModalidad->MinSigla?>');"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a> <a href="javascript:FncFichaAccionProductoEliminarTodo('<?php echo $DatFichaIngresoModalidad->MinSigla?>');"></a></td>
                                  <td><div id="CapFichaAccion<?php echo $DatFichaIngresoModalidad->MinSigla?>ProductosResultado"> </div></td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td colspan="2">PRODUCTOS adicionales</td>
                                  <td>&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td colspan="2"><div id="CapFichaAccion<?php echo $DatFichaIngresoModalidad->MinSigla?>Productos" class="EstCapFichaAccionProductos" ></div></td>
                                  <td>&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td colspan="2">* Los PRODUCTOS adicionales a las que se asignaron inicialmente en la Orden de Trabajo van en este espacio</td>
                                  <td>&nbsp;</td>
                                </tr>
                              </table>
                            </div></td>
                            <td align="left" valign="top"><div class="EstFormularioArea" >
                              <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                                <tr>
                                  <td width="1%">&nbsp;</td>
                                  <td colspan="2"><span class="EstFormularioSubTitulo">SUMINISTROS</span> asignados en la Orden de Trabajo</td>
                                  <td width="2%">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td colspan="2"><div id="CapFichaAccion<?php echo $DatFichaIngresoModalidad->MinSigla?>Suministros2" class="EstCapFichaAccionSuministros2" > </div></td>
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
                                  <td width="50%"><div class="EstFormularioAccion" id="Cap<?php echo $DatFichaIngresoModalidad->MinSigla?>SuministroAccion">Listo
                                    para registrar elementos </div></td>
                                  <td width="47%" align="right"><a href="javascript:FncFichaAccionSuministroListar('<?php echo $DatFichaIngresoModalidad->MinSigla?>');"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a> <a href="javascript:FncFichaAccionSuministroEliminarTodo('<?php echo $DatFichaIngresoModalidad->MinSigla?>');"></a></td>
                                  <td><div id="CapFichaAccion<?php echo $DatFichaIngresoModalidad->MinSigla?>SuministrosResultado"> </div></td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td colspan="2">SUMINISTROS adicionales</td>
                                  <td>&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td colspan="2"><div id="CapFichaAccion<?php echo $DatFichaIngresoModalidad->MinSigla?>Suministros" class="EstCapFichaAccionSuministros2" ></div></td>
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
                            <td>&nbsp;</td>
                            <td width="24%">Kilometraje/Plan Mant.:</td>
                            <td width="49%"><?php
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
                            <td align="right">&nbsp;</td>
                            <td>&nbsp;</td>
                          </tr>
                          <tr>
                            <td width="1%">&nbsp;</td>
                            <td colspan="2"><span class="EstFormularioSubTitulo"> Tareas del Plan de Mantenimiento</span></td>
                            <td width="25%" align="right">
                              
  <?php
//deb($InsFichaIngreso->FinEstado);
?>
                              
                              <input type="hidden" name="CmpMantenimientoLlenadoAutomatico" id="CmpMantenimientoLlenadoAutomatico" value="<?php echo ($InsFichaIngreso->FinEstado == 11 || $InsFichaIngreso->FinEstado == 2 )?'1':'2';?>"   />
                              
                              
                              
                              <a href="javascript:FncFichaAccionMantenimientoListar('<?php echo $DatFichaIngresoModalidad->MinSigla?>');">
                            <img  src="imagenes/recargar.gif"  width="20" height="20"  border="0" title="Recargar"   alt="[Recargar]" align="absmiddle"/> </a></td>
                            <td width="1%">&nbsp;</td>
                          </tr>
                          <tr>
                            <td>&nbsp;</td>
                            <td colspan="3"><div id="CapFichaAccion<?php echo $DatFichaIngresoModalidad->MinSigla?>Mantenimientos" class="EstCapFichaAccionMantenimientos" > </div></td>
                            <td><div id="CapFichaAccion<?php echo $DatFichaIngresoModalidad->MinSigla?>MantenimientosResultado"> </div></td>
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
	      <td colspan="2"><span class="EstFormularioSubTitulo">Observaciones  de la ORDEN DE TRABAJO: <?php echo strtoupper($DatFichaIngresoModalidad->MinNombre);?> </span></td>
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