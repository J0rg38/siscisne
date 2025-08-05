<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar")){
?>

<!-- CONTROL DE PRIVILEGIOS -->
<?php $PrivilegioVistaPreliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"VistaPreliminar"))?true:false;?>
<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Imprimir"))?true:false;?>
<!-- ARCHIVO DE FUNCIONES JS -->
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Vehiculo');?>JsVehiculoIngresoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Vehiculo');?>JsVehiculoIngresoAutocompletar.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Vehiculo");?>JsVehiculoModeloFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Vehiculo");?>JsVehiculoVersionFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Vehiculo');?>JsCampanaVehiculoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Vehiculo');?>JsPlanMantenimientoVehiculoFunciones.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Cliente');?>JsClienteFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Cliente');?>JsClienteAutocompletar.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsFichaIngresoFuncionesv2.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsFichaIngresoProductoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsFichaIngresoTareaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsFichaIngresoMantenimientoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsFichaIngresoSuministroFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsFichaIngresoHistorialFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsFichaIngresoPresupuestoFunciones.js" ></script>


<!-- ARCHIVO DE ESTILOS CSS -->
<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssFichaIngreso.css');
@import url('<?php echo $InsProyecto->MtdFormulariosCss("PlanMantenimiento");?>CssPlanMantenimiento.css');
</style>
<?php
$GET_id = $_GET['Id'];
$Edito = false;

if(!empty($_POST['Identificador'])){
	$Identificador = $_POST['Identificador'];
}
include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjFichaIngreso.php');
include($InsProyecto->MtdFormulariosMsj('Cliente').'MsjCliente.php');
include($InsProyecto->MtdFormulariosMsj('Vehiculo').'MsjVehiculo.php');

require_once($InsPoo->MtdPaqActividad().'ClsFichaIngreso.php');
require_once($InsPoo->MtdPaqActividad().'ClsPreEntregaDetalle.php');
require_once($InsPoo->MtdPaqActividad().'ClsPreEntregaTarea.php');
require_once($InsPoo->MtdPaqActividad().'ClsPreEntregaSeccion.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoProducto.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoTarea.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoModalidad.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoHerramienta.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoSuministro.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoMantenimiento.php');

require_once($InsPoo->MtdPaqActividad().'ClsModalidadIngreso.php');
require_once($InsPoo->MtdPaqLogistica().'ClsCliente.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculo.php');
require_once($InsPoo->MtdPaqActividad().'ClsPlanMantenimiento.php');
require_once($InsPoo->MtdPaqLogistica().'ClsTipoDocumento.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoMarca.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngreso.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngresoCliente.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoIngresoFoto.php');


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
require_once($InsPoo->MtdPaqActividad().'ClsPlanMantenimientoDetalle.php');
require_once($InsPoo->MtdPaqActividad().'ClsPlanMantenimientoSeccion.php');
require_once($InsPoo->MtdPaqActividad().'ClsPlanMantenimientoTarea.php');

require_once($InsPoo->MtdPaqRRHH().'ClsPersonal.php');



require_once($InsPoo->MtdPaqRRHH().'ClsPersonal.php');

$InsFichaIngreso = new ClsFichaIngreso();
$InsModalidadIngreso = new ClsModalidadIngreso();
$InsPlanMantenimiento = new ClsPlanMantenimiento();
$InsTipoDocumento = new ClsTipoDocumento();
$InsVehiculoMarca = new ClsVehiculoMarca();

$InsPlanMantenimiento = new ClsPlanMantenimiento();
$InsPlanMantenimientoSeccion = new ClsPlanMantenimientoSeccion();
$InsPlanMantenimientoDetalle = new ClsPlanMantenimientoDetalle();
$InsPlanMantenimientoTarea = new ClsPlanMantenimientoTarea();

$InsPersonal = new ClsPersonal();

$ResModalidadIngreso = $InsModalidadIngreso->MtdObtenerModalidadIngresos(NULL,NULL,"MinOrden","ASC",NULL,"1,3");
$ArrModalidadIngresos = $ResModalidadIngreso['Datos'];



foreach($ArrModalidadIngresos as $DatModalidadIngreso){

	if (!isset($_SESSION['InsFichaIngresoProducto'.$DatModalidadIngreso->MinSigla.$Identificador])){	
		$_SESSION['InsFichaIngresoProducto'.$DatModalidadIngreso->MinSigla.$Identificador] = new ClsSesionObjeto();
	}else{	
		$_SESSION['InsFichaIngresoProducto'.$DatModalidadIngreso->MinSigla.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsFichaIngresoProducto'.$DatModalidadIngreso->MinSigla.$Identificador]);
	}

	if (!isset($_SESSION['InsFichaIngresoTarea'.$DatModalidadIngreso->MinSigla.$Identificador])){	
		$_SESSION['InsFichaIngresoTarea'.$DatModalidadIngreso->MinSigla.$Identificador] = new ClsSesionObjeto();
	}else{	
		$_SESSION['InsFichaIngresoTarea'.$DatModalidadIngreso->MinSigla.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsFichaIngresoTarea'.$DatModalidadIngreso->MinSigla.$Identificador]);
	}
	
	if (!isset($_SESSION['InsFichaIngresoSuministro'.$DatModalidadIngreso->MinSigla.$Identificador])){	
		$_SESSION['InsFichaIngresoSuministro'.$DatModalidadIngreso->MinSigla.$Identificador] = new ClsSesionObjeto();
	}else{	
		$_SESSION['InsFichaIngresoSuministro'.$DatModalidadIngreso->MinSigla.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsFichaIngresoSuministro'.$DatModalidadIngreso->MinSigla.$Identificador]);
	}
	
	if (!isset($_SESSION['InsFichaIngresoMantenimiento'.$DatModalidadIngreso->MinSigla.$Identificador])){	
		$_SESSION['InsFichaIngresoMantenimiento'.$DatModalidadIngreso->MinSigla.$Identificador] = new ClsSesionObjeto();
	}else{	
		$_SESSION['InsFichaIngresoMantenimiento'.$DatModalidadIngreso->MinSigla.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsFichaIngresoMantenimiento'.$DatModalidadIngreso->MinSigla.$Identificador]);
	}

	if (!isset($_SESSION['InsFichaIngresoPresupuesto'.$DatModalidadIngreso->MinSigla.$Identificador])){	
		$_SESSION['InsFichaIngresoPresupuesto'.$DatModalidadIngreso->MinSigla.$Identificador] = new ClsSesionObjeto();
	}else{	
		$_SESSION['InsFichaIngresoPresupuesto'.$DatModalidadIngreso->MinSigla.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsFichaIngresoPresupuesto'.$DatModalidadIngreso->MinSigla.$Identificador]);
	}



}


include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccFichaIngresoCorregir.php');

$RepTipoDocumento = $InsTipoDocumento->MtdObtenerTipoDocumentos(NULL,NULL,'TdoNombre',"ASC",NULL);
$ArrTipoDocumentos = $RepTipoDocumento['Datos'];

$RepVehiculoMarca = $InsVehiculoMarca->MtdObtenerVehiculoMarcas(NULL,NULL,"VmaNombre","ASC",NULL);
$ArrVehiculoMarcas = $RepVehiculoMarca['Datos'];

$ResPersonal = $InsPersonal->MtdObtenerPersonales(NULL,NULL,NULL,"PerNombre","ASC",NULL,NULL,NULL,NULL,1);
$ArrPersonales = $ResPersonal['Datos'];

?>

<?php
//if($InsFichaIngreso->FinEstado==11 or $InsFichaIngreso->FinEstado==2){
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

	FncFichaIngresoHistorialListar();
	
	FncFichaIngresoMantenimientoKilometrajeEstablecer();
});

/*
Configuracion Formulario
*/

var Formulario = "FrmEditar";

//var FichaIngresoMantenimientoEditar = <?php echo ($InsFichaIngreso->FinEstado==11)?'1':'2'?>;



var FichaIngresoProductoEditar = 1;
var FichaIngresoProductoEliminar = 1;

var FichaIngresoTareaEditar = 1;
var FichaIngresoTareaEliminar = 1;

var FichaIngresoSuministroEditar = 1;
var FichaIngresoSuministroEliminar = 1;

var FichaIngresoMantenimientoEditar = 1;
var FichaIngresoMantenimientoEliminar = 1;


</script>

<form id="FrmEditar" name="FrmEditar" method="post" action="#" enctype="multipart/form-data"  onsubmit="FncGuardar();">


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
if($Edito){
?>    

	<?php
/*    if($PrivilegioVistaPreliminar){
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
    }*/
    ?>         

<?php
}
?>         
                        
</div>

<div class="EstCapContenido">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
      
      <tr>
        <td width="1922" height="25" colspan="2"><span class="EstFormularioTitulo">CORREGIR
        ORDEN DE TRABAJO</span></td>
      </tr>
      <tr>
        <td colspan="2">
        
         <div class="EstFormularioArea">
         
        <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td>Creado el:</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsFichaIngreso->FinTiempoCreacion;?></span></td>
            <td>&nbsp;</td>
            <td>Modificado el</td>
            <td><span class="EstFormularioDatoRegistro"><?php echo $InsFichaIngreso->FinTiempoModificacion;?></span></td>
          </tr>
        </table>
        
        </div>  
<br />
               
<ul class="tabs">
	<li><a href="#tab1">Orden de Trabajo</a></li>
	<li><a href="#tab2">Inventario</a></li>
    <li><a href="#tab3">Historial</a></li>
    
    
 <?php
	$c = 5;
	foreach($ArrModalidadIngresos as $DatModalidadIngreso){
			

?>		
		<li><a id="TabModalidad<?php echo $DatModalidadIngreso->MinSigla;;?>" href="#tab<?php echo $c;?>"><?php echo $DatModalidadIngreso->MinNombre;?></a></li>
<?php

	$c++;
	}
?>    
    
    
</ul>
 <div class="tab_container">
    <div id="tab1" class="tab_content">
        <!--Content-->     
      
        
             <table width="100%" border="0" cellpadding="2" cellspacing="2">
        <tr>
          <td valign="top">
          
          
          
          <div class="EstFormularioArea">
             <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
               <tr>
                 <td>&nbsp;</td>
                 <td colspan="4"><span class="EstFormularioSubTitulo">Datos del Vehiculo</span></td>
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
                 </tr>
               <tr>
                 <td>&nbsp;</td>
                 <td align="left" valign="top">VIN:
                   <input name="CmpVehiculoIngresoId" type="hidden" id="CmpVehiculoIngresoId" value="<?php echo $InsFichaIngreso->EinId;?>" size="3" /></td>
                 <td align="left" valign="top"><table border="0" cellpadding="0" cellspacing="0">
                   <tr>
                     <td><input name="CmpVehiculoIngresoVIN" type="text" class="EstFormularioCajaDeshabilitada" id="CmpVehiculoIngresoVIN"  value="<?php echo $InsFichaIngreso->EinVIN;?>" size="20" maxlength="50" readonly="readonly" /></td>
                     </tr>
                 </table></td>
                 <td align="left" valign="top">Placa:</td>
                 <td align="left" valign="top"><input  name="CmpVehiculoIngresoPlaca" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpVehiculoIngresoPlaca" value="<?php echo $InsFichaIngreso->EinPlaca;?>" size="30" maxlength="50" readonly="readonly" /></td>
                 <td>&nbsp;</td>
                 <td>&nbsp;</td>
                 <td>&nbsp;</td>
                 </tr>
               <tr>
                 <td>&nbsp;</td>
                 <td align="left" valign="top">Marca:
                   <input name="CmpVehiculoIngresoMarcaId" type="hidden" id="CmpVehiculoIngresoMarcaId" value="<?php echo $InsFichaIngreso->VmaId;?>" size="3" /></td>
                 <td align="left" valign="top"><input  name="CmpVehiculoIngresoMarca" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpVehiculoIngresoMarca" value="<?php echo $InsFichaIngreso->VmaNombre;?>" size="30" maxlength="50" readonly="readonly" /></td>
                 <td align="left" valign="top">Modelo:
                   <input name="CmpVehiculoIngresoModeloId" type="hidden" id="CmpVehiculoIngresoModeloId" value="<?php echo $InsFichaIngreso->VmoId;?>" size="3" />
                   <input name="CmpVehiculoModeloId" type="hidden" id="CmpVehiculoModeloId" value="<?php echo $InsFichaIngreso->VmoId;?>" size="3" /></td>
                 <td align="left" valign="top"><input  name="CmpVehiculoIngresoModelo" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpVehiculoIngresoModelo" value="<?php echo $InsFichaIngreso->VmoNombre;?>" size="30" maxlength="50" readonly="readonly" /></td>
                 <td>Version:
                   <input name="CmpVehiculoIngresoVersionId" type="hidden" id="CmpVehiculoIngresoVersionId" value="<?php echo $InsFichaIngreso->VveId;?>" size="3" /></td>
                 <td><input  name="CmpVehiculoIngresoVersion" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpVehiculoIngresoVersion" value="<?php echo $InsFichaIngreso->VveNombre;?>" size="30" maxlength="50" readonly="readonly" /></td>
                 <td>&nbsp;</td>
               </tr>
               <tr>
                 <td>&nbsp;</td>
                 <td align="left" valign="top">A&ntilde;o de Fabricacion:</td>
                 <td align="left" valign="top"><input  name="CmpVehiculoIngresoAnoFabricacion" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpVehiculoIngresoAnoFabricacion" value="<?php echo $InsFichaIngreso->EinAnoFabricacion;?>" size="30" maxlength="45" readonly="readonly" /></td>
                 <td align="left" valign="top">Color:</td>
                 <td align="left" valign="top"><input  name="CmpVehiculoIngresoColor" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpVehiculoIngresoColor" value="<?php echo $InsFichaIngreso->EinColor;?>" size="30" maxlength="50" readonly="readonly" /></td>
                 <td><input name="CmpVehiculoIngresoClienteId" type="hidden" id="CmpVehiculoIngresoClienteId" value="<?php echo $InsFichaIngreso->CliId;?>" size="3" /></td>
                 <td>&nbsp;</td>
                 <td>&nbsp;</td>
               </tr>
               <tr>
                 <td>&nbsp;</td>
                 <td align="left" valign="top">Kilometraje:</td>
                 <td align="left"><span id="sprytextfield9">
                   <input class="EstFormularioCaja"  name="CmpVehiculoKilometraje" type="text" id="CmpVehiculoKilometraje" value="<?php if(empty($InsFichaIngreso->FinVehiculoKilometraje)){ echo "0.00"; }else{echo $InsFichaIngreso->FinVehiculoKilometraje;}?>" size="10" maxlength="." />
                   <span class="textfieldRequiredMsg"><img src="imagenes/advertencia.png" width="20" height="20" border="0" align="absmiddle" title="Debe completar este campo" alt="[A]"  /></span><span class="textfieldInvalidFormatMsg"><img src="imagenes/advertencia.png" width="20" height="20" border="0" align="absmiddle" title="Formato no valido" alt="[A]"  /></span><span class="textfieldMinValueMsg">El valor introducido es inferior al m&iacute;nimo permitido.</span></span></td>
                 <td align="left" valign="top">Kilometraje/Plan Mant.:</td>
                 <td align="left"><select class="EstFormularioCombo" name="CmpMantenimientoKilometraje" id="CmpMantenimientoKilometraje" disabled="disabled" >
                 </select>
                   <input type="hidden" name="CmpMantenimientoKilometrajeAux" id="CmpMantenimientoKilometrajeAux" value="<?php echo $InsFichaIngreso->FinMantenimientoKilometraje;?>" />
                   <input type="hidden" name="CmpPlanMantenimientoId" id="CmpPlanMantenimientoId" value="<?php echo $InsFichaIngreso->PmaId;?>" />
                   <input type="hidden" name="CmpPlanMantenimientoNombre" id="CmpPlanMantenimientoNombre" value="<?php echo $InsFichaIngreso->PmaNombre;?>" /></td>
                 <td>&nbsp;</td>
                 <td>&nbsp;</td>
                 <td>&nbsp;</td>
               </tr>
               <tr>
                 <td>&nbsp;</td>
                 <td align="left" valign="top">Campa&ntilde;a:</td>
                 <td colspan="5" align="left">
                 <table border="0" cellpadding="0" cellspacing="0">
                               
                               <tr>
                               <td>
                               
                               
                               <a href="javascript:FncCampanaVehiculoNuevo();"><img src="imagenes/registrar.png" width="20" height="20" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a>
                               
                               </td>
                               <td>
                               
                               
                                 <input name="CmpCampanaId" type="hidden" id="CmpCampanaId"  value="<?php echo $InsFichaIngreso->CamId;?>" size="20" maxlength="50" />
                       <input name="CmpCampanaFecha" type="hidden" id="CmpCampanaFecha"  value="<?php echo $InsFichaIngreso->CamFecha;?>" size="20" maxlength="50" />
                       <input name="CmpCampanaCodigo" type="text" class="EstFormularioCajaDeshabilitada" id="CmpCampanaCodigo"  value="<?php echo $InsFichaIngreso->CamCodigo;?>" size="20" maxlength="20" />
                       <input name="CmpCampanaNombre" type="text" class="EstFormularioCajaDeshabilitada" id="CmpCampanaNombre"  value="<?php echo $InsFichaIngreso->CamNombre;?>" size="60" maxlength="500" />
                       
                       
                               </td>
                               </tr>
                               </table>
                               
                 </td>
                 <td>&nbsp;</td>
               </tr>
               <tr>
                 <td>&nbsp;</td>
                 <td align="left" valign="top">&nbsp;</td>
                 <td align="left">&nbsp;</td>
                 <td align="left">&nbsp;</td>
                 <td align="left">&nbsp;</td>
                 <td>&nbsp;</td>
                 <td>&nbsp;</td>
                 <td>&nbsp;</td>
               </tr>
               </table>
             </div>
          
          
          </td>
        </tr>
        <tr>
          <td valign="top">
            
            <div class="EstFormularioArea">
              
              <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                <tr>
                  <td>&nbsp;</td>
                  <td colspan="5"><span class="EstFormularioSubTitulo">Datos de la Orden de Trabajo
                    <input type="hidden" name="Guardar" id="Guardar"   />
                    <input type="hidden" name="Identificador" id="Identificador"  value="<?php echo $Identificador; ?>" />
                    </span></td>
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
                  </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Modalidad de Ingreso:</td>
                  <td align="left" valign="top">Codigo (*):</td>
                  <td align="left" valign="top"><input readonly="readonly" name="CmpId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpId" value="<?php echo $InsFichaIngreso->FinId;?>" size="15" maxlength="20" /></td>
                  <td align="left" valign="top">&nbsp;</td>
                  <td align="left" valign="top">&nbsp;</td>
                  <td>&nbsp;</td>
                  </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td rowspan="5" align="left" valign="top"><?php
	
		
		//deb($InsFichaIngreso->FichaIngresoModalidad);
		
		foreach($ArrModalidadIngresos as $DatModalidadIngreso){
		?>

			<?php
			$aux = '';
			$FichaIngresoModalidadId = "";
			
            if(!empty($InsFichaIngreso->FichaIngresoModalidad)){	
                foreach($InsFichaIngreso->FichaIngresoModalidad as $DatFichaIngresoModalidad ){
                   
					$FichaIngresoModalidadId = '';
                    if($DatFichaIngresoModalidad->MinId == $DatModalidadIngreso->MinId){
                        $aux = 'checked="checked"';
						$FichaIngresoModalidadId = $DatFichaIngresoModalidad->FimId;
                        break;
                    }					
                }
				
            }		
					
            ?>
                    
                    <input etiqueta="modalidad" <?php echo $aux;?> type="checkbox" value="<?php echo $DatModalidadIngreso->MinId?>" name="CmpModalidadId_<?php echo $DatModalidadIngreso->MinSigla?>" id="CmpModalidadId_<?php echo $DatModalidadIngreso->MinSigla?>" sigla="<?php echo $DatModalidadIngreso->MinSigla;?>" disabled="disabled" />
                    
                    <input type="hidden" name="CmpFichaIngresoModalidadId_<?php echo $DatModalidadIngreso->MinSigla?>" id="CmpFichaIngresoModalidadId_<?php echo $DatModalidadIngreso->MinSigla?>" value="<?php echo $FichaIngresoModalidadId;?>" />
                    <?php echo $DatModalidadIngreso->MinNombre?><br />
                    
                    <?php	
				
				
		}
		?>
                    </td>
                  <td align="left" valign="top">Fecha de Ingreso:<br />
                    <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
                  <td align="left" valign="top"><input name="CmpFecha" type="text" class="EstFormularioCajaDeshabilitada" id="CmpFecha" value="<?php echo $InsFichaIngreso->FinFecha;?>" size="15" maxlength="10" readonly="readonly" /></td>
                  <td align="left" valign="top">Hora:</td>
                  <td align="left" valign="top"><input  name="CmpHora" type="text" class="EstFormularioCajaDeshabilitada" id="CmpHora" value="<?php if(empty($InsFichaIngreso->FinHora)){ echo date("H:i"); }else{echo $InsFichaIngreso->FinHora;}?>" size="10" maxlength="5" readonly="readonly" /></td>
                  <td>&nbsp;</td>
                  </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Fecha de Cita:<br />
                    <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
                  <td align="left" valign="top"><input name="CmpFechaCita" type="text" class="EstFormularioCajaDeshabilitada" id="CmpFechaCita" value="<?php echo $InsFichaIngreso->FinFechaCita;?>" size="15" maxlength="10" readonly="readonly" /></td>
                  <td align="left" valign="top">Fecha de Entrega:<br />
                    <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
                  <td align="left" valign="top"><input name="CmpFechaEntrega" type="text" class="EstFormularioCajaDeshabilitada" id="CmpFechaEntrega" value="<?php echo $InsFichaIngreso->FinFechaEntrega;?>" size="15" maxlength="10" readonly="readonly" /></td>
                  <td>&nbsp;</td>
                  </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Prioridad:</td>
                  <td align="left" valign="top"><?php
					switch($InsFichaIngreso->FinPrioridad){
						case 1:
							$OpcPrioridad1 = 'selected = "selected"';
						break;
						
						case 2:
							$OpcPrioridad2 = 'selected = "selected"';						
						break;

					}
					?>
                    <select disabled="disabled"  class="EstFormularioCombo" name="CmpPrioridad" id="CmpPrioridad">
                      <option <?php echo $OpcPrioridad1;?> value="1">Urgente</option>
                      <option <?php echo $OpcPrioridad2;?> value="2">Normal</option>
                      </select></td>
                  <td align="left" valign="top">Estado: </td>
                  <td align="left" valign="top"><?php
					switch($InsFichaIngreso->FinEstado){
						case 1:
							$OpcEstado1 = 'selected = "selected"';
						break;
						
						case 2:
							$OpcEstado2 = 'selected = "selected"';						
						break;
						
						case 3:
							$OpcEstado3 = 'selected = "selected"';						
						break;
						
						case 4:
							$OpcEstado4 = 'selected = "selected"';						
						break;
					}
					?>
                    <select  class="EstFormularioCombo" name="CmpEstadoAux" id="CmpEstadoAux" disabled="disabled">
                      <option <?php echo $OpcEstado1;?> value="1">Pendiente</option>
                      <option <?php echo $OpcEstado2;?> value="2">Revisado</option>
                      <option <?php echo $OpcEstado3;?> value="3">Pedido [Preparando]</option>
                      <option <?php echo $OpcEstado4;?> value="4">Pedido [Enviado]</option>
                      </select>
                    <input type="hidden" name="CmpEstado" id="CmpEstado" value="<?php echo $InsFichaIngreso->FinEstado;?>" /></td>
                  <td>&nbsp;</td>
                  </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Tecnico:</td>
                  <td colspan="3" align="left" valign="top"><select  class="EstFormularioCombo" name="CmpPersonal" id="CmpPersonal" >
                    <option value="">Escoja una opcion</option>
                    <?php
					foreach($ArrPersonales as $DatPersonal){
					?>
                    <option <?php echo ($DatPersonal->PerId==$InsFichaIngreso->PerId)?'selected="selected"':'';?>  value="<?php echo $DatPersonal->PerId;?>"><?php echo $DatPersonal->PerNombre ?> <?php echo $DatPersonal->PerApellidoPaterno; ?> <?php echo $DatPersonal->PerApellidoMaterno; ?></option>
                    <?php
					}
					?>
                  </select></td>
                  <td>&nbsp;</td>
                  </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">&nbsp;</td>
                  <td align="left" valign="top">&nbsp;</td>
                  <td align="left" valign="top">&nbsp;</td>
                  <td align="left" valign="top">&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                </table>
              </div></td>
        </tr>
       <tr>
         <td valign="top">
           
           <div class="EstFormularioArea">
             
             
             <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
               <tr>
                 <td>&nbsp;</td>
                 <td colspan="4"><span class="EstFormularioSubTitulo">Datos del Cliente</span></td>
                 <td>&nbsp;</td>
                 </tr>
               
               <tr>
                 <td>&nbsp;</td>
                 <td>&nbsp;</td>
                 <td>&nbsp;</td>
                 <td>&nbsp;</td>
                 <td></td>
                 <td>&nbsp;</td>
                 </tr>
               <tr>
                 <td>&nbsp;</td>
                 <td align="left" valign="top">
                 
                   <select disabled="disabled" class="EstFormularioCombo" name="CmpClienteTipoDocumento" id="CmpClienteTipoDocumento">
                     <option value="">Escoja una opcion</option>
                     <?php
			foreach($ArrTipoDocumentos as $DatTipoDocumento){
			?>
                     <option <?php echo $DatTipoDocumento->TdoId;?> <?php echo ($DatTipoDocumento->TdoId==$InsFichaIngreso->TdoId)?'selected="selected"':"";?> value="<?php echo $DatTipoDocumento->TdoId?>"><?php echo $DatTipoDocumento->TdoCodigo?> - <?php echo $DatTipoDocumento->TdoNombre?></option>
                     <?php
			}
			?>
                   </select>
:
<input name="CmpClienteId" type="hidden" id="CmpClienteId" value="<?php echo $InsFichaIngreso->CliId;?>" size="3" /></td>
                 <td align="left" valign="top"><table border="0" cellpadding="0" cellspacing="0">
                   <tr>
                     <td align="left" valign="top"><input name="CmpClienteNumeroDocumento" type="text" class="EstFormularioCajaDeshabilitada" id="CmpClienteNumeroDocumento"  value="<?php echo $InsFichaIngreso->CliNumeroDocumento;?>" size="20" maxlength="50" readonly="readonly" /></td>
                     <td valign="top">
                       <div id="CapClienteBuscar"></div>
                     </td>
                     </tr>
                   </table></td>
                 <td align="left" valign="top">Cliente:</td>
                 <td align="left" valign="top"><input name="CmpClienteNombre" type="text" class="EstFormularioCajaDeshabilitada" id="CmpClienteNombre" value="<?php echo $InsFichaIngreso->CliNombreCompleto;?>" size="45" maxlength="255" readonly="readonly"  /></td>
                 <td>&nbsp;</td>
                 </tr>
               <tr>
                 <td>&nbsp;</td>
                 <td align="left" valign="top">Celular:</td>
                 <td align="left" valign="top"><input  name="CmpClienteCelular" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpClienteCelular" value="<?php echo $InsFichaIngreso->FinTelefono;?>" size="40" maxlength="50" readonly="readonly" /></td>
                 <td align="left" valign="top">Direccion:</td>
                 <td align="left" valign="top"><input  name="CmpClienteDireccion" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpClienteDireccion" value="<?php echo $InsFichaIngreso->FinDireccion;?>" size="40" maxlength="200" readonly="readonly" /></td>
                 <td>&nbsp;</td>
                 </tr>
               <tr>
                 <td>&nbsp;</td>
                 <td align="left" valign="top">Contacto:</td>
                 <td colspan="3" align="left" valign="top"><input name="CmpClienteContacto" type="text" class="EstFormularioCajaDeshabilitada" id="CmpClienteContacto" value="<?php echo $InsFichaIngreso->FinContacto;?>" size="45" maxlength="255" readonly="readonly"  /></td>
                 <td>&nbsp;</td>
                 </tr>
               <tr>
                 <td>&nbsp;</td>
                 <td align="left" valign="top">Conductor:</td>
                 <td colspan="3" align="left" valign="top"><input name="CmpConductor" type="text" class="EstFormularioCajaDeshabilitada" id="CmpConductor" value="<?php echo $InsFichaIngreso->FinConductor;?>" size="45" maxlength="255" readonly="readonly"  /></td>
                 <td>&nbsp;</td>
                 </tr>
               <tr>
                 <td>&nbsp;</td>
                 <td align="left" valign="top">&nbsp;</td>
                 <td colspan="3" align="left">&nbsp;</td>
                 <td>&nbsp;</td>
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
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left" valign="top">EXTERIORES</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">INTERIORES</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td>&nbsp;</td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td>&nbsp;</td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left" valign="top"><p>Lado Delantero</p></td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">Lado Derecho</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">Llave de Contacto:</td>
                      <td align="left" valign="top"><input class="EstFormularioCaja"  name="CmpInterior1" type="text" id="CmpInterior1" value="<?php if(empty($InsFichaIngreso->FinInterior1)){ echo "1"; }else{echo $InsFichaIngreso->FinInterior1;}?>" size="10" maxlength="1" /></td>
                      <td align="left" valign="top">Cenicero:</td>
                      <td align="left" valign="top"><input class="EstFormularioCaja"  name="CmpInterior15" type="text" id="CmpInterior15" value="<?php if(empty($InsFichaIngreso->FinInterior15)){ echo "1"; }else{echo $InsFichaIngreso->FinInterior15;}?>" size="10" maxlength="1" /></td>
                      <td>&nbsp;</td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left" valign="top">Parachoque:</td>
                      <td align="left" valign="top"><input class="EstFormularioCaja"  name="CmpExteriorDelantero1" type="text" id="CmpExteriorDelantero1" value="<?php if(empty($InsFichaIngreso->FinExteriorDelantero1)){ echo "1"; }else{echo $InsFichaIngreso->FinExteriorDelantero1;}?>" size="10" maxlength="1" /></td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">Gdfgo  Posterior:</td>
                      <td align="left" valign="top"><input class="EstFormularioCaja"  name="CmpExteriorDerecho1" type="text" id="CmpExteriorDerecho1" value="<?php if(empty($InsFichaIngreso->FinExteriorDerecho1)){ echo "1"; }else{echo $InsFichaIngreso->FinExteriorDerecho1;}?>" size="10" maxlength="1" /></td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">Lunas Electricas:</td>
                      <td align="left" valign="top"><input class="EstFormularioCaja"  name="CmpInterior2" type="text" id="CmpInterior2" value="<?php if(empty($InsFichaIngreso->FinInterior2)){ echo "1"; }else{echo $InsFichaIngreso->FinInterior2;}?>" size="10" maxlength="1" /></td>
                      <td align="left" valign="top">Manual:</td>
                      <td align="left" valign="top"><input class="EstFormularioCaja"  name="CmpInterior16" type="text" id="CmpInterior16" value="<?php if(empty($InsFichaIngreso->FinInterior16)){ echo "1"; }else{echo $InsFichaIngreso->FinInterior16;}?>" size="10" maxlength="1" /></td>
                      <td>&nbsp;</td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left" valign="top">Neblineros:</td>
                      <td align="left" valign="top"><input class="EstFormularioCaja"  name="CmpExteriorDelantero2" type="text" id="CmpExteriorDelantero2" value="<?php if(empty($InsFichaIngreso->FinExteriorDelantero2)){ echo "1"; }else{echo $InsFichaIngreso->FinExteriorDelantero2;}?>" size="10" maxlength="1" /></td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">Tapa de Combustible:</td>
                      <td align="left" valign="top"><input class="EstFormularioCaja"  name="CmpExteriorDerecho2" type="text" id="CmpExteriorDerecho2" value="<?php if(empty($InsFichaIngreso->FinExteriorDerecho2)){ echo "1"; }else{echo $InsFichaIngreso->FinExteriorDerecho2;}?>" size="10" maxlength="1" /></td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">Asiento (tela, cuero):</td>
                      <td align="left" valign="top"><input class="EstFormularioCaja"  name="CmpInterior3" type="text" id="CmpInterior3" value="<?php if(empty($InsFichaIngreso->FinInterior3)){ echo "1"; }else{echo $InsFichaIngreso->FinInterior3;}?>" size="10" maxlength="1" /></td>
                      <td align="left" valign="top">Antena:</td>
                      <td align="left" valign="top"><input class="EstFormularioCaja"  name="CmpInterior17" type="text" id="CmpInterior17" value="<?php if(empty($InsFichaIngreso->FinInterior17)){ echo "1"; }else{echo $InsFichaIngreso->FinInterior17;}?>" size="10" maxlength="1" /></td>
                      <td>&nbsp;</td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left" valign="top">Faros:</td>
                      <td align="left" valign="top"><input class="EstFormularioCaja"  name="CmpExteriorDelantero3" type="text" id="CmpExteriorDelantero3" value="<?php if(empty($InsFichaIngreso->FinExteriorDelantero3)){ echo "1"; }else{echo $InsFichaIngreso->FinExteriorDelantero3;}?>" size="10" maxlength="1" /></td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">Aros:</td>
                      <td align="left" valign="top"><input class="EstFormularioCaja"  name="CmpExteriorDerecho3" type="text" id="CmpExteriorDerecho3" value="<?php if(empty($InsFichaIngreso->FinExteriorDerecho3)){ echo "1"; }else{echo $InsFichaIngreso->FinExteriorDerecho3;}?>" size="10" maxlength="1" /></td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">Asiento Piloto:</td>
                      <td align="left" valign="top"><input class="EstFormularioCaja"  name="CmpInterior4" type="text" id="CmpInterior4" value="<?php if(empty($InsFichaIngreso->FinInterior4)){ echo "1"; }else{echo $InsFichaIngreso->FinInterior4;}?>" size="10" maxlength="1" /></td>
                      <td align="left" valign="top">Copas de Aros / Vasos:</td>
                      <td align="left" valign="top"><input class="EstFormularioCaja"  name="CmpInterior18" type="text" id="CmpInterior18" value="<?php if(empty($InsFichaIngreso->FinInterior18)){ echo "1"; }else{echo $InsFichaIngreso->FinInterior18;}?>" size="10" maxlength="1" /></td>
                      <td>&nbsp;</td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left" valign="top">Plumillas:</td>
                      <td align="left" valign="top"><input class="EstFormularioCaja"  name="CmpExteriorDelantero4" type="text" id="CmpExteriorDelantero4" value="<?php if(empty($InsFichaIngreso->FinExteriorDelantero4)){ echo "1"; }else{echo $InsFichaIngreso->FinExteriorDelantero4;}?>" size="10" maxlength="1" /></td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">Puerta Posterior:</td>
                      <td align="left" valign="top"><input class="EstFormularioCaja"  name="CmpExteriorDerecho4" type="text" id="CmpExteriorDerecho4" value="<?php if(empty($InsFichaIngreso->FinExteriorDerecho4)){ echo "1"; }else{echo $InsFichaIngreso->FinExteriorDerecho4;}?>" size="10" maxlength="1" /></td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">Controles de Tim&oacute;n:</td>
                      <td align="left" valign="top"><input class="EstFormularioCaja"  name="CmpInterior5" type="text" id="CmpInterior5" value="<?php if(empty($InsFichaIngreso->FinInterior5)){ echo "1"; }else{echo $InsFichaIngreso->FinInterior5;}?>" size="10" maxlength="1" /></td>
                      <td align="left" valign="top">Airbags:</td>
                      <td align="left" valign="top"><input class="EstFormularioCaja"  name="CmpInterior19" type="text" id="CmpInterior19" value="<?php if(empty($InsFichaIngreso->FinInterior19)){ echo "1"; }else{echo $InsFichaIngreso->FinInterior19;}?>" size="10" maxlength="1" /></td>
                      <td>&nbsp;</td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left" valign="top">Parabrisas:</td>
                      <td align="left" valign="top"><input class="EstFormularioCaja"  name="CmpExteriorDelantero5" type="text" id="CmpExteriorDelantero5" value="<?php if(empty($InsFichaIngreso->FinExteriorDelantero5)){ echo "1"; }else{echo $InsFichaIngreso->FinExteriorDelantero5;}?>" size="10" maxlength="1" /></td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">Puerta Delantera:</td>
                      <td align="left" valign="top"><input class="EstFormularioCaja"  name="CmpExteriorDerecho5" type="text" id="CmpExteriorDerecho5" value="<?php if(empty($InsFichaIngreso->FinExteriorDerecho5)){ echo "1"; }else{echo $InsFichaIngreso->FinExteriorDerecho5;}?>" size="10" maxlength="1" /></td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">Perilla de Palanca:</td>
                      <td align="left" valign="top"><input class="EstFormularioCaja"  name="CmpInterior6" type="text" id="CmpInterior6" value="<?php if(empty($InsFichaIngreso->FinInterior6)){ echo "1"; }else{echo $InsFichaIngreso->FinInterior6;}?>" size="10" maxlength="1" /></td>
                      <td align="left" valign="top">Seguro Cromado Rueda:</td>
                      <td align="left" valign="top"><input class="EstFormularioCaja"  name="CmpInterior20" type="text" id="CmpInterior20" value="<?php if(empty($InsFichaIngreso->FinInterior20)){ echo "1"; }else{echo $InsFichaIngreso->FinInterior20;}?>" size="10" maxlength="1" /></td>
                      <td>&nbsp;</td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left" valign="top">Emble:</td>
                      <td align="left" valign="top"><input class="EstFormularioCaja"  name="CmpExteriorDelantero6" type="text" id="CmpExteriorDelantero6" value="<?php if(empty($InsFichaIngreso->FinExteriorDelantero6)){ echo "1"; }else{echo $InsFichaIngreso->FinExteriorDelantero6;}?>" size="10" maxlength="1" /></td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">Espejo Lateral:</td>
                      <td align="left" valign="top"><input class="EstFormularioCaja"  name="CmpExteriorDerecho6" type="text" id="CmpExteriorDerecho6" value="<?php if(empty($InsFichaIngreso->FinExteriorDerecho6)){ echo "1"; }else{echo $InsFichaIngreso->FinExteriorDerecho6;}?>" size="10" maxlength="1" /></td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">Radio (Cass/CD/MP/A/C):</td>
                      <td align="left" valign="top"><input class="EstFormularioCaja"  name="CmpInterior7" type="text" id="CmpInterior7" value="<?php if(empty($InsFichaIngreso->FinInterior7)){ echo "1"; }else{echo $InsFichaIngreso->FinInterior7;}?>" size="10" maxlength="1" /></td>
                      <td align="left" valign="top">Gancho de remolque:</td>
                      <td align="left" valign="top"><input class="EstFormularioCaja"  name="CmpInterior21" type="text" id="CmpInterior21" value="<?php if(empty($InsFichaIngreso->FinInterior21)){ echo "1"; }else{echo $InsFichaIngreso->FinInterior21;}?>" size="10" maxlength="1" /></td>
                      <td>&nbsp;</td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left" valign="top">Bicel/Mascara:</td>
                      <td align="left" valign="top"><input class="EstFormularioCaja"  name="CmpExteriorDelantero7" type="text" id="CmpExteriorDelantero7" value="<?php if(empty($InsFichaIngreso->FinExteriorDelantero7)){ echo "1"; }else{echo $InsFichaIngreso->FinExteriorDelantero7;}?>" size="10" maxlength="1" /></td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">Gdfgo  Delantero:</td>
                      <td align="left" valign="top"><input class="EstFormularioCaja"  name="CmpExteriorDerecho7" type="text" id="CmpExteriorDerecho7" value="<?php if(empty($InsFichaIngreso->FinExteriorDerecho7)){ echo "1"; }else{echo $InsFichaIngreso->FinExteriorDerecho7;}?>" size="10" maxlength="1" /></td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">A/C:</td>
                      <td align="left" valign="top"><input class="EstFormularioCaja"  name="CmpInterior8" type="text" id="CmpInterior8" value="<?php if(empty($InsFichaIngreso->FinInterior8)){ echo "1"; }else{echo $InsFichaIngreso->FinInterior8;}?>" size="10" maxlength="1" /></td>
                      <td align="left" valign="top">Estuche de Herram.:</td>
                      <td align="left" valign="top"><input class="EstFormularioCaja"  name="CmpInterior22" type="text" id="CmpInterior22" value="<?php if(empty($InsFichaIngreso->FinInterior22)){ echo "1"; }else{echo $InsFichaIngreso->FinInterior22;}?>" size="10" maxlength="1" /></td>
                      <td>&nbsp;</td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">Lunas:</td>
                      <td align="left" valign="top"><input class="EstFormularioCaja"  name="CmpExteriorDerecho8" type="text" id="CmpExteriorDerecho8" value="<?php if(empty($InsFichaIngreso->FinExteriorDerecho8)){ echo "1"; }else{echo $InsFichaIngreso->FinExteriorDerecho8;}?>" size="10" maxlength="1" /></td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">Reloj:</td>
                      <td align="left" valign="top"><input class="EstFormularioCaja"  name="CmpInterior9" type="text" id="CmpInterior9" value="<?php if(empty($InsFichaIngreso->FinInterior9)){ echo "1"; }else{echo $InsFichaIngreso->FinInterior9;}?>" size="10" maxlength="1" /></td>
                      <td align="left" valign="top">Gata llave de rueda Palanca:</td>
                      <td align="left" valign="top"><input class="EstFormularioCaja"  name="CmpInterior23" type="text" id="CmpInterior23" value="<?php if(empty($InsFichaIngreso->FinInterior23)){ echo "1"; }else{echo $InsFichaIngreso->FinInterior23;}?>" size="10" maxlength="1" /></td>
                      <td>&nbsp;</td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left" valign="top">Lado Posterior</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">Espejo Retovisor:</td>
                      <td align="left" valign="top"><input class="EstFormularioCaja"  name="CmpInterior10" type="text" id="CmpInterior10" value="<?php if(empty($InsFichaIngreso->FinInterior10)){ echo "1"; }else{echo $InsFichaIngreso->FinInterior10;}?>" size="10" maxlength="1" /></td>
                      <td align="left" valign="top">Luz de Sal&oacute;n:</td>
                      <td align="left" valign="top"><input class="EstFormularioCaja"  name="CmpInterior24" type="text" id="CmpInterior24" value="<?php if(empty($InsFichaIngreso->FinInterior24)){ echo "1"; }else{echo $InsFichaIngreso->FinInterior24;}?>" size="10" maxlength="1" /></td>
                      <td>&nbsp;</td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left" valign="top">Parachoque:</td>
                      <td align="left" valign="top"><input class="EstFormularioCaja"  name="CmpExteriorPosterior1" type="text" id="CmpExteriorPosterior1" value="<?php if(empty($InsFichaIngreso->FinExteriorPosterior1)){ echo "1"; }else{echo $InsFichaIngreso->FinExteriorPosterior1;}?>" size="10" maxlength="1" /></td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">Lado Izquierdo</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">Correas de Seguridad:</td>
                      <td align="left" valign="top"><input class="EstFormularioCaja"  name="CmpInterior11" type="text" id="CmpInterior11" value="<?php if(empty($InsFichaIngreso->FinInterior11)){ echo "1"; }else{echo $InsFichaIngreso->FinInterior11;}?>" size="10" maxlength="1" /></td>
                      <td align="left" valign="top">Triangulo:</td>
                      <td align="left" valign="top"><input class="EstFormularioCaja"  name="CmpInterior25" type="text" id="CmpInterior25" value="<?php if(empty($InsFichaIngreso->FinInterior25)){ echo "1"; }else{echo $InsFichaIngreso->FinInterior25;}?>" size="10" maxlength="1" /></td>
                      <td>&nbsp;</td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left" valign="top">Faros:</td>
                      <td align="left" valign="top"><input class="EstFormularioCaja"  name="CmpExteriorPosterior2" type="text" id="CmpExteriorPosterior2" value="<?php if(empty($InsFichaIngreso->FinExteriorPosterior2)){ echo "1"; }else{echo $InsFichaIngreso->FinExteriorPosterior2;}?>" size="10" maxlength="1" /></td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">Gdfgo Posterior:</td>
                      <td align="left" valign="top"><input class="EstFormularioCaja"  name="CmpExteriorIzquierdo1" type="text" id="CmpExteriorIzquierdo1" value="<?php if(empty($InsFichaIngreso->FinExteriorIzquierdo1)){ echo "1"; }else{echo $InsFichaIngreso->FinExteriorIzquierdo1;}?>" size="10" maxlength="1" /></td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">Tapasoles:</td>
                      <td align="left" valign="top"><input class="EstFormularioCaja"  name="CmpInterior12" type="text" id="CmpInterior12" value="<?php if(empty($InsFichaIngreso->FinInterior12)){ echo "1"; }else{echo $InsFichaIngreso->FinInterior12;}?>" size="10" maxlength="1" /></td>
                      <td align="left" valign="top">Extintor:</td>
                      <td align="left" valign="top"><input class="EstFormularioCaja"  name="CmpInterior26" type="text" id="CmpInterior26" value="<?php if(empty($InsFichaIngreso->FinInterior26)){ echo "1"; }else{echo $InsFichaIngreso->FinInterior26;}?>" size="10" maxlength="1" /></td>
                      <td>&nbsp;</td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left" valign="top">Maletera:</td>
                      <td align="left" valign="top"><input class="EstFormularioCaja"  name="CmpExteriorPosterior3" type="text" id="CmpExteriorPosterior3" value="<?php if(empty($InsFichaIngreso->FinExteriorPosterior3)){ echo "1"; }else{echo $InsFichaIngreso->FinExteriorPosterior3;}?>" size="10" maxlength="1" /></td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">Aros:</td>
                      <td align="left" valign="top"><input class="EstFormularioCaja"  name="CmpExteriorIzquierdo2" type="text" id="CmpExteriorIzquierdo2" value="<?php if(empty($InsFichaIngreso->FinExteriorIzquierdo2)){ echo "1"; }else{echo $InsFichaIngreso->FinExteriorIzquierdo2;}?>" size="10" maxlength="1" /></td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">Sunroof:</td>
                      <td align="left" valign="top"><input class="EstFormularioCaja"  name="CmpInterior13" type="text" id="CmpInterior13" value="<?php if(empty($InsFichaIngreso->FinInterior13)){ echo "1"; }else{echo $InsFichaIngreso->FinInterior13;}?>" size="10" maxlength="1" /></td>
                      <td align="left" valign="top">Cobertor de Maletera:</td>
                      <td align="left" valign="top"><input class="EstFormularioCaja"  name="CmpInterior27" type="text" id="CmpInterior27" value="<?php if(empty($InsFichaIngreso->FinInterior27)){ echo "1"; }else{echo $InsFichaIngreso->FinInterior27;}?>" size="10" maxlength="1" /></td>
                      <td>&nbsp;</td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left" valign="top">Plumillas:</td>
                      <td align="left" valign="top"><input class="EstFormularioCaja"  name="CmpExteriorPosterior4" type="text" id="CmpExteriorPosterior4" value="<?php if(empty($InsFichaIngreso->FinExteriorPosterior4)){ echo "1"; }else{echo $InsFichaIngreso->FinExteriorPosterior4;}?>" size="10" maxlength="1" /></td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">Puerta Posterior:</td>
                      <td align="left" valign="top"><input class="EstFormularioCaja"  name="CmpExteriorIzquierdo3" type="text" id="CmpExteriorIzquierdo3" value="<?php if(empty($InsFichaIngreso->FinExteriorIzquierdo3)){ echo "1"; }else{echo $InsFichaIngreso->FinExteriorIzquierdo3;}?>" size="10" maxlength="1" /></td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">Encendedor:</td>
                      <td align="left" valign="top"><input class="EstFormularioCaja"  name="CmpInterior14" type="text" id="CmpInterior14" value="<?php if(empty($InsFichaIngreso->FinInterior14)){ echo "1"; }else{echo $InsFichaIngreso->FinInterior14;}?>" size="10" maxlength="1" /></td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td>&nbsp;</td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left" valign="top">5ta Llave de Aro:</td>
                      <td align="left" valign="top"><input class="EstFormularioCaja"  name="CmpExteriorPosterior5" type="text" id="CmpExteriorPosterior5" value="<?php if(empty($InsFichaIngreso->FinExteriorPosterior5)){ echo "1"; }else{echo $InsFichaIngreso->FinExteriorPosterior5;}?>" size="10" maxlength="1" /></td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">Puerta Delantera:</td>
                      <td align="left" valign="top"><input class="EstFormularioCaja"  name="CmpExteriorIzquierdo4" type="text" id="CmpExteriorIzquierdo4" value="<?php if(empty($InsFichaIngreso->FinExteriorIzquierdo4)){ echo "1"; }else{echo $InsFichaIngreso->FinExteriorIzquierdo4;}?>" size="10" maxlength="1" /></td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td colspan="4" rowspan="4" align="right" valign="top"><table border="0" cellpadding="0" cellspacing="0">
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
                      <td align="left" valign="top">Emblema:</td>
                      <td align="left" valign="top"><input class="EstFormularioCaja"  name="CmpExteriorPosterior6" type="text" id="CmpExteriorPosterior6" value="<?php if(empty($InsFichaIngreso->FinExteriorPosterior6)){ echo "1"; }else{echo $InsFichaIngreso->FinExteriorPosterior6;}?>" size="10" maxlength="1" /></td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">Espejo Lateral:</td>
                      <td align="left" valign="top"><input class="EstFormularioCaja"  name="CmpExteriorIzquierdo5" type="text" id="CmpExteriorIzquierdo5" value="<?php if(empty($InsFichaIngreso->FinExteriorIzquierdo5)){ echo "1"; }else{echo $InsFichaIngreso->FinExteriorIzquierdo5;}?>" size="10" maxlength="1" /></td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td>&nbsp;</td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">Gdfgo Delantero:</td>
                      <td align="left" valign="top"><input class="EstFormularioCaja"  name="CmpExteriorIzquierdo6" type="text" id="CmpExteriorIzquierdo6" value="<?php if(empty($InsFichaIngreso->FinExteriorIzquierdo6)){ echo "1"; }else{echo $InsFichaIngreso->FinExteriorIzquierdo6;}?>" size="10" maxlength="1" /></td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td>&nbsp;</td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">Lunas:</td>
                      <td align="left" valign="top"><input class="EstFormularioCaja"  name="CmpExteriorIzquierdo7" type="text" id="CmpExteriorIzquierdo7" value="<?php if(empty($InsFichaIngreso->FinExteriorIzquierdo7)){ echo "1"; }else{echo $InsFichaIngreso->FinExteriorIzquierdo7;}?>" size="10" maxlength="1" /></td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td>&nbsp;</td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td>&nbsp;</td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left" valign="top">Observacion:</td>
                      <td colspan="9" align="left" valign="top"><textarea readonly="readonly" name="CmpObservacion" cols="60" rows="2" class="EstFormularioCajaDeshabilitada" id="CmpObservacion"><?php echo $InsFichaIngreso->FinObservacion;?></textarea></td>
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
                      </tr>
                    
                    
                    </table>
                  
                  
                  
                  </div>     
                </td>
            </tr>
            </table>    
    </div>
 

    
    
        <div id="tab3" class="tab_content">
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
                            <td width="47%"><div class="EstFormularioAccion" id="CapFichaIngresoHistorialAccion">Listo
                              para registrar elementos</div></td>
                            <td width="49%" align="right"><a href="javascript:FncFichaIngresoHistorialListar();"><img  src="imagenes/recargar.gif"  width="20" height="20"  border="0" title="Recargar"   alt="[Recargar]" align="absmiddle"/> Recargar</a></td>
                            <td width="1%"><div id="CapFichaIngresoHistorialesResultado"> </div></td>
                            </tr>
                          <tr>
                            <td>&nbsp;</td>
                            <td colspan="2"><div id="CapFichaIngresoHistoriales" class="EstCapFichaIngresoHistoriales" > </div></td>
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
	$c = 5;
	foreach($ArrModalidadIngresos as $DatModalidadIngreso){
		
		
		$FichaIngresoModalidadObsequio = '';

		if(!empty($InsFichaIngreso->FichaIngresoModalidad)){	
			foreach($InsFichaIngreso->FichaIngresoModalidad as $DatFichaIngresoModalidad ){

				if($DatFichaIngresoModalidad->MinId == $DatModalidadIngreso->MinId){

					$FichaIngresoModalidadObsequio = $DatFichaIngresoModalidad->FimObsequio;
				  
					break;
				}

			}
		}	
		
		
?>		

        <div id="tab<?php echo $c;?>" class="tab_content">
        
        
              <div class="EstFormularioArea" id="CapModalidad<?php echo $DatModalidadIngreso->MinSigla;?>">
           
            <?php
			
			switch($DatModalidadIngreso->MinSigla){
				
				default:
			?>
              <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                <tr>
                  <td colspan="3" align="center"><span class="EstFormularioSubTitulo">Tareas y Productos <?php echo $DatModalidadIngreso->MinNombre;?></span></td>
                </tr>
                <tr>
                  <td width="50%" align="left" valign="top"><div class="EstFormularioArea">
                    <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                      <tr>
                        <td>&nbsp;</td>
                        <td colspan="4"><span class="EstFormularioSubTitulo">TAREAS </span>
                          <input type="hidden" name="Cmp<?php echo $DatModalidadIngreso->MinSigla;?>TareaItem" id="Cmp<?php echo $DatModalidadIngreso->MinSigla;?>TareaItem" />
                          <input type="hidden" name="Cmp<?php echo $DatModalidadIngreso->MinSigla;?>TareaId" id="Cmp<?php echo $DatModalidadIngreso->MinSigla;?>TareaId" /></td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>Descripcion: </td>
                        <td>Actividad:</td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td><a href="javascript:FncFichaIngresoTareaNuevo('<?php echo $DatModalidadIngreso->MinSigla;?>');"><img src="imagenes/registrar.png" width="20" height="20" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                        <td><input name="Cmp<?php echo $DatModalidadIngreso->MinSigla;?>TareaDescripcion" type="text" class="EstFormularioCaja" id="Cmp<?php echo $DatModalidadIngreso->MinSigla;?>TareaDescripcion" size="50" maxlength="200" /></td>
                        <td><select class="EstFormularioCombo" name="Cmp<?php echo $DatModalidadIngreso->MinSigla;?>TareaAccion" id="Cmp<?php echo $DatModalidadIngreso->MinSigla;?>TareaAccion">
                          <option value="I">Inspeccionar</option>
                          <option value="R">Realizar</option>
                        </select></td>
                        <td><a href="javascript:FncFichaIngresoTareaGuardar('<?php echo $DatModalidadIngreso->MinSigla;?>');"><img src="imagenes/guardar.gif" width="20" height="20" border="0" title="Guardar" alt="[Guardar]" align="absmiddle" /></a></td>
                      </tr>
                    </table>
                  </div></td>
                  <td width="47%" align="left" valign="top"><div class="EstFormularioArea">
                    <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                      <tr>
                        <td>&nbsp;</td>
                        <td colspan="4"><span class="EstFormularioSubTitulo">PRODUCTOS</span><span class="EstFormularioSubTitulo">
                          <input type="hidden" name="Cmp<?php echo $DatModalidadIngreso->MinSigla;?>ProductoId"    id="Cmp<?php echo $DatModalidadIngreso->MinSigla;?>ProductoId"   />
                          <input type="hidden" name="Cmp<?php echo $DatModalidadIngreso->MinSigla;?>ProductoItem" id="Cmp<?php echo $DatModalidadIngreso->MinSigla;?>ProductoItem" />
                          
                                                          <input type="hidden" name="Cmp<?php echo $DatModalidadIngreso->MinSigla;?>ProductoCodigoOriginal"    id="Cmp<?php echo $DatModalidadIngreso->MinSigla;?>ProductoCodigoOriginal"   />
                                
                                 <input type="hidden" name="Cmp<?php echo $DatModalidadIngreso->MinSigla;?>ProductoCodigoAlternativo"    id="Cmp<?php echo $DatModalidadIngreso->MinSigla;?>ProductoCodigoAlternativo"   />
                             
                             
                             
                             
                          <input type="hidden" name="CmpFichaIngreso<?php echo $DatModalidadIngreso->MinSigla;?>ProductoId"  class="EstFormularioCaja" id="CmpFichaIngreso<?php echo $DatModalidadIngreso->MinSigla;?>ProductoId"  />
                        
                        

                                  
                                  
                                  </span></td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td><div id="Cap<?php echo $DatModalidadIngreso->MinSigla;?>ProductoBuscar"></div></td>
                        <td>Nombre : </td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td><a href="javascript:FncFichaIngresoProductoNuevo('<?php echo $DatModalidadIngreso->MinSigla;?>');"><img src="imagenes/registrar.png" width="20" height="20" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                        <td><input name="Cmp<?php echo $DatModalidadIngreso->MinSigla;?>ProductoNombre" type="text" class="EstFormularioCaja" id="Cmp<?php echo $DatModalidadIngreso->MinSigla;?>ProductoNombre" size="40" /></td>
                        <td><a href="javascript:FncFichaIngresoProductoGuardar('<?php echo $DatModalidadIngreso->MinSigla;?>');"><img src="imagenes/guardar.gif" width="20" height="20" border="0" title="Guardar" alt="[Guardar]" align="absmiddle" /></a></td>
                        <td><a href="comunes/Producto/FrmProductoBuscar.php?height=440&width=850&Modalidad=MIN-10000" class="thickbox" title="">[...]</a></td>
                      </tr>
                    </table>
                  </div></td>
                  <td width="3%" align="left" valign="top">
                  
                  <?php
				/*  
				  ?>
                  <div class="EstFormularioArea">
                    <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                      <tr>
                        <td>&nbsp;</td>
                        <td colspan="6"><span class="EstFormularioSubTitulo">SUMINISTROS </span><span class="EstFormularioSubTitulo">
                          <input type="hidden" name="Cmp<?php echo $DatModalidadIngreso->MinSigla;?>SuministroId"    id="Cmp<?php echo $DatModalidadIngreso->MinSigla;?>SuministroId"   />
                          <input type="hidden" name="Cmp<?php echo $DatModalidadIngreso->MinSigla;?>SuministroItem" id="Cmp<?php echo $DatModalidadIngreso->MinSigla;?>SuministroItem" />
                          <input type="hidden" name="CmpFichaIngreso<?php echo $DatModalidadIngreso->MinSigla;?>SuministroId"  class="EstFormularioCaja" id="CmpFichaIngreso<?php echo $DatModalidadIngreso->MinSigla;?>SuministroId"  />
                        </span></td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td><div id="Cap<?php echo $DatModalidadIngreso->MinSigla;?>SuministroBuscar"></div></td>
                        <td>Nombre : </td>
                        <td>U.M. </td>
                        <td>Cantidad:</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td><a href="javascript:FncFichaIngresoSuministroNuevo('<?php echo $DatModalidadIngreso->MinSigla;?>');"><img src="imagenes/registrar.png" width="20" height="20" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                        <td><input name="Cmp<?php echo $DatModalidadIngreso->MinSigla;?>SuministroNombre" type="text" class="EstFormularioCaja" id="Cmp<?php echo $DatModalidadIngreso->MinSigla;?>SuministroNombre" size="40" /></td>
                        <td><select  class="EstFormularioCombo" name="Cmp<?php echo $DatModalidadIngreso->MinSigla?>SuministroUnidadMedidaConvertir" id="Cmp<?php echo $DatModalidadIngreso->MinSigla?>SuministroUnidadMedidaConvertir">
                        </select></td>
                        <td><input name="Cmp<?php echo $DatModalidadIngreso->MinSigla?>SuministroCantidad" type="text" class="EstFormularioCaja" id="Cmp<?php echo $DatModalidadIngreso->MinSigla?>SuministroCantidad" size="10" maxlength="10"  /></td>
                        <td><a href="javascript:FncFichaIngresoSuministroGuardar('<?php echo $DatModalidadIngreso->MinSigla;?>');"><img src="imagenes/guardar.gif" width="20" height="20" border="0" title="Guardar" alt="[Guardar]" align="absmiddle" /></a></td>
                        <td><a href="comunes/Suministro/FrmSuministroBuscar.php?height=440&width=850&Modalidad=MIN-10000" class="thickbox" title="">[...]</a></td>
                      </tr>
                    </table>
                  </div>
                   <?php
				  */
				  ?>
                  
                  </td>
                </tr>
                <tr>
                  <td align="left" valign="top"><div class="EstFormularioArea" >
                    <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                      <tr>
                        <td width="3%"><input type="hidden" name="CmpFichaIngreso<?php echo $DatModalidadIngreso->MinSigla;?>TareaAccion" id="CmpFichaIngreso<?php echo $DatModalidadIngreso->MinSigla;?>TareaAccion" value="AccFichaIngresoTareaRegistrar.php" /></td>
                        <td width="47%"><div class="EstFormularioAccion" id="Cap<?php echo $DatModalidadIngreso->MinSigla;?>TareaAccion">Listo
                          para registrar elementos</div></td>
                        <td width="49%" align="right"><a href="javascript:FncFichaIngresoTareaListar('<?php echo $DatModalidadIngreso->MinSigla;?>');"><img  src="imagenes/recargar.gif"  width="20" height="20"  border="0" title="Recargar"   alt="[Recargar]" align="absmiddle"/> Recargar</a><a href="javascript:FncFichaIngresoTareaEliminarTodo('<?php echo $DatModalidadIngreso->MinSigla;?>');"><img  src="imagenes/eliminar_todo.png"  width="20" height="20"  border="0" title="Eliminar Todo"   alt="[Eli. Todo.]" align="absmiddle"/></a></td>
                        <td width="1%"><div id="CapFichaIngreso<?php echo $DatModalidadIngreso->MinSigla;?>TareasResultado"> </div></td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td colspan="2"><div id="CapFichaIngreso<?php echo $DatModalidadIngreso->MinSigla;?>Tareas" class="EstCapFichaIngresoTareas" > </div></td>
                        <td>&nbsp;</td>
                      </tr>
                    </table>
                  </div></td>
                  <td align="left" valign="top"><div class="EstFormularioArea" >
                    <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                      <tr>
                        <td width="4%"><input type="hidden" name="CmpFichaIngreso<?php echo $DatModalidadIngreso->MinSigla;?>ProductoAccion" id="CmpFichaIngreso<?php echo $DatModalidadIngreso->MinSigla;?>ProductoAccion" value="AccFichaIngresoProductoRegistrar.php" /></td>
                        <td width="45%"><div class="EstFormularioAccion" id="Cap<?php echo $DatModalidadIngreso->MinSigla;?>ProductoAccion">Listo
                          para registrar elementos</div></td>
                        <td width="50%" align="right"><a href="javascript:FncFichaIngresoProductoListar('<?php echo $DatModalidadIngreso->MinSigla;?>');"><img  src="imagenes/recargar.gif"  width="20" height="20"  border="0" title="Recargar"   alt="[Recargar]" align="absmiddle"/> Recargar</a><a href="javascript:FncFichaIngresoProductoEliminarTodo('<?php echo $DatModalidadIngreso->MinSigla;?>');"><img  src="imagenes/eliminar_todo.png"  width="20" height="20"  border="0" title="Eliminar Todo"   alt="[Eli. Todo.]" align="absmiddle"/></a></td>
                        <td width="1%"><div id="CapFichaIngreso<?php echo $DatModalidadIngreso->MinSigla;?>ProductosResultado"> </div></td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td colspan="2"><div id="CapFichaIngreso<?php echo $DatModalidadIngreso->MinSigla;?>Productos" class="EstCapFichaIngresoProductos" > </div></td>
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
                        <td width="3%"><input type="hidden" name="CmpFichaIngreso<?php echo $DatModalidadIngreso->MinSigla;?>SuministroAccion" id="CmpFichaIngreso<?php echo $DatModalidadIngreso->MinSigla;?>SuministroAccion" value="AccFichaIngresoSuministroRegistrar.php" /></td>
                        <td width="47%"><div class="EstFormularioAccion" id="Cap<?php echo $DatModalidadIngreso->MinSigla;?>SuministroAccion">Listo
                          para registrar elementos</div></td>
                        <td width="49%" align="right"><a href="javascript:FncFichaIngresoSuministroListar('<?php echo $DatModalidadIngreso->MinSigla;?>');"><img  src="imagenes/recargar.gif"  width="20" height="20"  border="0" title="Recargar"   alt="[Recargar]" align="absmiddle"/> Recargar</a><a href="javascript:FncFichaIngresoSuministroEliminarTodo('<?php echo $DatModalidadIngreso->MinSigla;?>');"><img  src="imagenes/eliminar_todo.png"  width="20" height="20"  border="0" title="Eliminar Todo"   alt="[Eli. Todo.]" align="absmiddle"/></a></td>
                        <td width="1%"><div id="CapFichaIngreso<?php echo $DatModalidadIngreso->MinSigla;?>SuministrosResultado"></div></td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td colspan="2"><div id="CapFichaIngreso<?php echo $DatModalidadIngreso->MinSigla;?>Suministros" class="EstCapFichaIngresoSuministros" > </div></td>
                        <td>&nbsp;</td>
                      </tr>
                    </table>
                  </div>
                  <?php
				  */
				  ?>
                  
                  </td>
                </tr>
              </table>
            <?php	
				break;
				
				case "MA":
			?>
			    <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                        <tr>
                          <td width="50%" align="center"><span class="EstFormularioSubTitulo">Plan de Mantenimiento</span></td>
                        </tr>
                        
                        <tr>
                          <td align="left" valign="top"><span class="EstFormularioSubTitulo">OPCIONES ADICIONALES</span></td>
                        </tr>
                        <tr>
                          <td align="left" valign="top">&nbsp;</td>
                        </tr>
                        <tr>
                          <td align="left" valign="top"><input <?php echo ($FichaIngresoModalidadObsequio==1)?'checked="checked"':''; ?>  type="checkbox" name="CmpFichaIngresoModalidadObsequio_<?php echo $DatModalidadIngreso->MinSigla; ?>" id="CmpFichaIngresoModalidadObsequio_<?php echo $DatModalidadIngreso->MinSigla; ?>" value="1" />
<span class="EstFormularioResaltar"> Este SERVICIO es GRATUITO </span></td>
                        </tr>
                        <tr>
                          <td align="left" valign="top">&nbsp;</td>
                        </tr>
                        <tr>
                          <td align="left" valign="top">
                            
                            
                            <div class="EstFormularioArea" >
                              <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                                <tr>
                                  <td width="0%">
                                  </td>
                                  <td width="49%"><div class="EstFormularioAccion" id="Cap<?php echo $DatModalidadIngreso->MinSigla;?>MantenimientoAccion">Listo
                                  para registrar elementos</div></td>
                                  <td width="50%" align="right"><a href="javascript:FncFichaIngresoMantenimientoListar('<?php echo $DatModalidadIngreso->MinSigla;?>');"><img  src="imagenes/recargar.gif"  width="20" height="20"  border="0" title="Recargar"   alt="[Recargar]" align="absmiddle"/> Recargar</a><a href="javascript:FncFichaIngresoMantenimientoEliminarTodo('<?php echo $DatModalidadIngreso->MinSigla;?>');"></a></td>
                                  <td width="1%"><div id="CapFichaIngreso<?php echo $DatModalidadIngreso->MinSigla;?>MantenimientosResultado"> </div></td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td colspan="2"><div id="CapFichaIngreso<?php echo $DatModalidadIngreso->MinSigla;?>Mantenimientos" class="EstCapFichaIngresoMantenimientos" > </div></td>
                                  <td>&nbsp;</td>
                                </tr>
                              </table>
                          </div></td>
                        </tr>
                      </table>
			<?php	
				break;
				
				case "SI":
			?>
<table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                        <tr>
                          <td align="center"><span class="EstFormularioSubTitulo">Tareas y Productos <?php echo $DatModalidadIngreso->MinNombre;?></span></td>
                        </tr>
                        
                        <tr>
                          <td align="left" valign="top"><div class="EstFormularioArea">
                            <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                              <tr>
                                <td>&nbsp;</td>
                                <td colspan="8"><span class="EstFormularioSubTitulo">PRODUCTOS que componen la ORDEN DE TRABAJO</span><span class="EstFormularioSubTitulo">
                                  <input type="hidden" name="Cmp<?php echo $DatModalidadIngreso->MinSigla;?>ProductoId"    id="Cmp<?php echo $DatModalidadIngreso->MinSigla;?>ProductoId"   />
                                  <input type="hidden" name="Cmp<?php echo $DatModalidadIngreso->MinSigla;?>ProductoItem" id="Cmp<?php echo $DatModalidadIngreso->MinSigla;?>ProductoItem" />
                                  <input type="hidden" name="CmpFichaIngreso<?php echo $DatModalidadIngreso->MinSigla;?>ProductoId"  class="EstFormularioCaja" id="CmpFichaIngreso<?php echo $DatModalidadIngreso->MinSigla;?>ProductoId"  />
                                </span></td>
                              </tr>
                              <tr>
                                <td>&nbsp;</td>
                                <td><input type="hidden" name="CmpFichaIngreso<?php echo $DatModalidadIngreso->MinSigla;?>ProductoAccion" id="CmpFichaIngreso<?php echo $DatModalidadIngreso->MinSigla;?>ProductoAccion" value="AccFichaIngresoProductoRegistrar.php" /></td>
                                <td>C&oacute;digo Orig.</td>
                                <td>&nbsp;</td>
                                <td>C&oacute;digo Alt.</td>
                                <td>&nbsp;</td>
                                <td>Nombre : </td>
                                <td><div id="Cap<?php echo $DatModalidadIngreso->MinSigla;?>ProductoBuscar"></div></td>
                                <td>&nbsp;</td>
                              </tr>
                              <tr>
                                <td>&nbsp;</td>
                                <td><a href="javascript:FncFichaIngresoProductoNuevo('<?php echo $DatModalidadIngreso->MinSigla;?>');"><img src="imagenes/registrar.png" width="20" height="20" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a></td>
                                <td>
                                
                                <input name="Cmp<?php echo $DatModalidadIngreso->MinSigla?>ProductoCodigoOriginal"  type="text" class="EstFormularioCaja" id="Cmp<?php echo $DatModalidadIngreso->MinSigla?>ProductoCodigoOriginal" size="10" maxlength="20" />
                                
                                </td>
                                <td>
                                <a href="javascript:FncProductoBuscar('CodigoOriginal','<?php echo $DatModalidadIngreso->MinSigla?>');"><img src="imagenes/buscar2.gif" width="25" height="25" alt="[Buscar]" align="absmiddle" title="Buscar" border="0" /></a>
                                
                                </td>
                                <td>
                                
                                <input name="Cmp<?php echo $DatModalidadIngreso->MinSigla?>ProductoCodigoAlternativo"  type="text" class="EstFormularioCaja" id="Cmp<?php echo $DatModalidadIngreso->MinSigla?>ProductoCodigoAlternativo" size="10" maxlength="20" />
                                
                                </td>
                                <td>&nbsp;</td>
                                <td>
                                
                                <input name="Cmp<?php echo $DatModalidadIngreso->MinSigla;?>ProductoNombre" type="text" class="EstFormularioCaja" id="Cmp<?php echo $DatModalidadIngreso->MinSigla;?>ProductoNombre" size="40" />
                                
                                </td>
                                <td><a href="javascript:FncFichaIngresoProductoGuardar('<?php echo $DatModalidadIngreso->MinSigla;?>');"><img src="imagenes/guardar.gif" width="20" height="20" border="0" title="Guardar" alt="[Guardar]" align="absmiddle" /></a></td>
                                <td><a href="comunes/Producto/FrmProductoBuscar.php?height=440&amp;width=850&amp;Modalidad=MIN-10000" class="thickbox" title="">[...]</a></td>
                              </tr>
                            </table>
                          </div></td>
                        </tr>
                        <tr>
                          <td align="left" valign="top"><div class="EstFormularioArea" >
                            <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                              <tr>
                                <td width="1%">&nbsp;</td>
                                <td width="48%"><div class="EstFormularioAccion" id="Cap<?php echo $DatModalidadIngreso->MinSigla;?>ProductoAccion">Listo
                                  para registrar elementos</div></td>
                                <td width="50%" align="right"><a href="javascript:FncFichaIngresoProductoListar('<?php echo $DatModalidadIngreso->MinSigla;?>');"><img  src="imagenes/recargar.gif"  width="20" height="20"  border="0" title="Recargar"   alt="[Recargar]" align="absmiddle"/> Recargar</a><a href="javascript:FncFichaIngresoProductoEliminarTodo('<?php echo $DatModalidadIngreso->MinSigla;?>');"><img  src="imagenes/eliminar_todo.png"  width="20" height="20"  border="0" title="Eliminar Todo"   alt="[Eli. Todo.]" align="absmiddle"/></a></td>
                                <td width="1%"><div id="CapFichaIngreso<?php echo $DatModalidadIngreso->MinSigla;?>ProductosResultado"> </div></td>
                              </tr>
                              <tr>
                                <td>&nbsp;</td>
                                <td colspan="2"><div id="CapFichaIngreso<?php echo $DatModalidadIngreso->MinSigla;?>Productos" class="EstCapFichaIngresoProductos" > </div></td>
                                <td>&nbsp;</td>
                              </tr>
                            </table>
                          </div></td>
                        </tr>
                        <tr>
                          <td width="31%" align="left" valign="top"><div class="EstFormularioArea">
                            
                            
                            <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                              <tr>
                                <td>&nbsp;</td>
                                <td colspan="5"><span class="EstFormularioSubTitulo">TAREAS que componen la ORDEN DE TRABAJO</span>
                                  <input type="hidden" name="Cmp<?php echo $DatModalidadIngreso->MinSigla;?>TareaItem" id="Cmp<?php echo $DatModalidadIngreso->MinSigla;?>TareaItem" />
                                  <input type="hidden" name="Cmp<?php echo $DatModalidadIngreso->MinSigla;?>TareaId" id="Cmp<?php echo $DatModalidadIngreso->MinSigla;?>TareaId" /></td>
                              </tr>
                              <tr>
                                <td>&nbsp;</td>
                                <td><input type="hidden" name="CmpFichaIngreso<?php echo $DatModalidadIngreso->MinSigla;?>TareaAccion" id="CmpFichaIngreso<?php echo $DatModalidadIngreso->MinSigla;?>TareaAccion" value="AccFichaIngresoTareaRegistrar.php" /></td>
                                <td>Actividad:</td>
                                <td>Descripcion: </td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                              </tr>
                              <tr>
                                <td>&nbsp;</td>
                                <td>
                                  
                                  <a href="javascript:FncFichaIngresoTareaNuevo('<?php echo $DatModalidadIngreso->MinSigla;?>');"><img src="imagenes/registrar.png" width="20" height="20" border="0" title="Limpiar/Nuevo" alt="[Nuevo]" align="absmiddle" /></a>
                                  
                                </td>
                                <td><select class="EstFormularioCombo" name="Cmp<?php echo $DatModalidadIngreso->MinSigla;?>TareaAccion" id="Cmp<?php echo $DatModalidadIngreso->MinSigla;?>TareaAccion">
                                    <option value="L">Planchado</option>
                                    <option value="N">Pintado</option>
                                    <option value="E">Centrado</option>
                                     <option value="Z">Tarea/Reparacion</option>
                                  </select></td>
                                <td><input name="Cmp<?php echo $DatModalidadIngreso->MinSigla;?>TareaDescripcion" type="text" class="EstFormularioCaja" id="Cmp<?php echo $DatModalidadIngreso->MinSigla;?>TareaDescripcion" size="50" maxlength="200" /></td>
                                <td>
                                  
                                  </td>
                                <td><a href="javascript:FncFichaIngresoTareaGuardar('<?php echo $DatModalidadIngreso->MinSigla;?>');"><img src="imagenes/guardar.gif" width="20" height="20" border="0" title="Guardar" alt="[Guardar]" align="absmiddle" /></a></td>
                              </tr>
                            </table>
                            
                            
                          </div></td>
                        </tr>
                        <tr>
                          <td align="left" valign="top">
                            
                            
                            <div class="EstFormularioArea" >
                              <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                                <tr>
                                  <td width="2%">&nbsp;</td>
                                  <td width="48%"><div class="EstFormularioAccion" id="Cap<?php echo $DatModalidadIngreso->MinSigla;?>TareaAccion">Listo
                                  para registrar elementos</div></td>
                                  <td width="49%" align="right"><a href="javascript:FncFichaIngresoTareaListar('<?php echo $DatModalidadIngreso->MinSigla;?>');"><img  src="imagenes/recargar.gif"  width="20" height="20"  border="0" title="Recargar"   alt="[Recargar]" align="absmiddle"/> Recargar</a><a href="javascript:FncFichaIngresoTareaEliminarTodo('<?php echo $DatModalidadIngreso->MinSigla;?>');"><img  src="imagenes/eliminar_todo.png"  width="20" height="20"  border="0" title="Eliminar Todo"   alt="[Eli. Todo.]" align="absmiddle"/></a></td>
                                  <td width="1%"><div id="CapFichaIngreso<?php echo $DatModalidadIngreso->MinSigla;?>TareasResultado"> </div></td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td colspan="2"><div id="CapFichaIngreso<?php echo $DatModalidadIngreso->MinSigla;?>Tareas" class="EstCapFichaIngresoTareas2" > </div></td>
                                  <td>&nbsp;</td>
                                </tr>
                              </table>
                          </div></td>
                        </tr>
                      </table>
			<?php	
				break;
				
			}
			
			?>
           
        
        </div>
        </div>
<?php
	$c++;
	}
?>



    
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
var sprytextfield9 = new Spry.Widget.ValidationTextField("sprytextfield9", "currency", {minValue:1});
</script>


<?php
}else{
	echo ERR_FIN_700;
}
?>


<?php



//}else{
//	echo ERR_GEN_101;
//}

if(!$_SESSION['MysqlDeb']){
	$InsMensaje->MtdRedireccionar("principal.php?Mod=".$GET_mod."&Form=Listado",$Edito,1500);
}


?>


