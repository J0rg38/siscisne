<?php
if($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,$GET_form)){
?>
<!-- CONTROL DE PRIVILEGIOS -->
<?php $PrivilegioVistaPreliminar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"VistaPreliminar"))?true:false;?>
<?php $PrivilegioImprimir = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Imprimir"))?true:false;?>
<?php $PrivilegioEditar = ($InsACL->MtdVerificarACL($_SESSION['SesionRol'],$GET_mod,"Editar"))?true:false;?>

<!-- ARCHIVO DE FUNCIONES JS -->
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('FichaIngreso');?>JsFichaIngresoVerificarPendienteFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Vehiculo');?>JsVehiculoIngresoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Vehiculo');?>JsVehiculoIngresoAutocompletar.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Vehiculo");?>JsVehiculoModeloFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Vehiculo");?>JsVehiculoVersionFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Cliente');?>JsClienteSimpleFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Cliente');?>JsClienteSimpleAutocompletar.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('AvisoRapido');?>JsAvisoRapidoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Vehiculo');?>JsVehiculoMantenimientoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('FichaIngreso');?>JsOrdenVentaVehiculoMantenimientoVerificar.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs("Cliente");?>JsClienteNotaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdComunesJs('Vehiculo');?>JsCitaFunciones.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsFichaIngresoFuncionesv2.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsFichaIngresoProductoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsFichaIngresoTareaFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsFichaIngresoManoObraFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsFichaIngresoMantenimientoFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsFichaIngresoSuministroFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsFichaIngresoHistorialFunciones.js" ></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsFichaIngresoCotizacionesFunciones.js" ></script>

<script type="text/javascript" src="<?php echo $InsProyecto->MtdFormulariosJs($GET_mod);?>JsFichaIngresoPresupuestoFunciones.js" ></script>

<!-- ARCHIVO DE ESTILOS CSS -->
<style type="text/css">
@import url('<?php echo $InsProyecto->MtdFormulariosCss($GET_mod);?>CssFichaIngreso.css');
@import url('<?php echo $InsProyecto->MtdFormulariosCss("PlanMantenimiento");?>CssPlanMantenimiento.css');
</style>

<?php
$GET_id = $_GET['Id'];

include($InsProyecto->MtdFormulariosMsj($GET_mod).'MsjFichaIngreso.php');
include($InsProyecto->MtdFormulariosMsj('Cliente').'MsjCliente.php');
include($InsProyecto->MtdFormulariosMsj('Vehiculo').'MsjVehiculo.php');

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

//require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoSalida.php');
//require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoSalidaDetalle.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsTallerPedido.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsTallerPedidoDetalle.php');

require_once($InsPoo->MtdPaqRRHH().'ClsPersonal.php');

require_once($InsPoo->MtdPaqActividad().'ClsTipoReparacion.php');
require_once($InsPoo->MtdPaqLogistica().'ClsClienteTipo.php');
require_once($InsPoo->MtdPaqEmpresa().'ClsSucursal.php');
require_once($InsPoo->MtdPaqActividad().'ClsPlanMantenimiento.php');

$InsFichaIngreso = new ClsFichaIngreso();
$InsModalidadIngreso = new ClsModalidadIngreso();
$InsPlanMantenimiento = new ClsPlanMantenimiento();
$InsTipoDocumento = new ClsTipoDocumento();
$InsVehiculoMarca = new ClsVehiculoMarca();

$InsPersonal = new ClsPersonal();

$InsTipoReparacion = new ClsTipoReparacion();
$InsClienteTipo = new ClsClienteTipo();
$InsSucursal = new ClsSucursal();
$InsPlanMantenimiento = new ClsPlanMantenimiento();


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
	
	if (!isset($_SESSION['InsFichaIngresoManoObra'.$DatModalidadIngreso->MinSigla.$Identificador])){	
		$_SESSION['InsFichaIngresoManoObra'.$DatModalidadIngreso->MinSigla.$Identificador] = new ClsSesionObjeto();
	}else{	
		$_SESSION['InsFichaIngresoManoObra'.$DatModalidadIngreso->MinSigla.$Identificador] = FncRepararClase('ClsSesionObjeto', $_SESSION['InsFichaIngresoManoObra'.$DatModalidadIngreso->MinSigla.$Identificador]);
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

include($InsProyecto->MtdFormulariosAcc($GET_mod).'AccFichaIngresoEditar.php');

$RepTipoDocumento = $InsTipoDocumento->MtdObtenerTipoDocumentos(NULL,NULL,'TdoNombre',"ASC",NULL);
$ArrTipoDocumentos = $RepTipoDocumento['Datos'];

$RepVehiculoMarca = $InsVehiculoMarca->MtdObtenerVehiculoMarcas(NULL,NULL,"VmaNombre","ASC",NULL);
$ArrVehiculoMarcas = $RepVehiculoMarca['Datos'];

//MtdObtenerPersonales($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PerId',$oSentido = 'Desc',$oPaginacion = '0,10',$oPersonalTipo=NULL,$oEstado=NULL,$oFechaNacimientoRango=NULL,$oTaller=NULL,$oRecepcion=NULL,$oVenta=NULL,$oArea=NULL,$oSucursal=NULL,$oAlmacen=NULL,$oFirmante=NULL,$oMultisucursal=false)
$ResPersonal = $InsPersonal->MtdObtenerPersonales(NULL,NULL,NULL,"PerNombre","ASC",NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,$_SESSION['SesionSucursal'],NULL,NULL,true);
$ArrTecnicos = $ResPersonal['Datos'];

//MtdObtenerPersonales($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PerId',$oSentido = 'Desc',$oPaginacion = '0,10',$oPersonalTipo=NULL,$oEstado=NULL,$oFechaNacimientoRango=NULL,$oTaller=NULL,$oRecepcion=NULL,$oVenta=NULL,$oArea=NULL,$oSucursal=NULL,$oAlmacen=NULL,$oFirmante=NULL,$oMultisucursal=false)
$ResPersonal = $InsPersonal->MtdObtenerPersonales(NULL,NULL,NULL,"PerNombre","ASC",NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,$_SESSION['SesionSucursal'],NULL,NULL,true);
$ArrAsesores = $ResPersonal['Datos'];

$ResTipoReparacion = $InsTipoReparacion->MtdObtenerTipoReparaciones(NULL,NULL,"TreOrden","ASC",NULL,1);
$ArrTipoReparaciones = $ResTipoReparacion['Datos'];

$RepClienteTipo = $InsClienteTipo->MtdObtenerClienteTipos(NULL,NULL,NULL,'VmaNombre,LtiNombre',"ASC",NULL);
$ArrClienteTipos = $RepClienteTipo['Datos'];


$RepSucursal = $InsSucursal->MtdObtenerSucursales(NULL,NULL,"SucNombre","ASC",NULL);
$ArrSucursales = $RepSucursal['Datos'];


$ResPlanMantenimiento = $InsPlanMantenimiento->MtdObtenerPlanMantenimientos(NULL,NULL,NULL,"PmaNombre","ASC",1,NULL);
$ArrPlanMantenimientos = $ResPlanMantenimiento['Datos'];

?>


<script type="text/javascript">
/*
Configuracion carga de datos y animacion
*/

$(document).ready(function (){

	$('#CmpModalidad').focus();	

//	$('input[type=checkbox]').each(function () {
//		if($(this).attr('etiqueta')=="modalidad"){
//			FncFichaIngresoTareaListar($(this).attr('sigla'));
//			FncFichaIngresoProductoListar($(this).attr('sigla'));
//			FncFichaIngresoMantenimientoListar($(this).attr('sigla'));
//			FncFichaIngresoSuministroListar($(this).attr('sigla'));
//		}			 
//	});
	
	FncFichaIngresoHistorialListar();
	
	FncFichaIngresoCotizacionesListar();

	FncFichaIngresoMantenimientoKilometrajeEstablecer();
	FncFichaIngresoPresupuestoMantenimientoKilometrajeEstablecer();
	
	FncClienteNotaVerificar();
	
});


/*
Configuracion Formulario
*/

var FichaIngresoProductoEditar = 2;
var FichaIngresoProductoEliminar = 2;

var FichaIngresoTareaEditar = 2;
var FichaIngresoTareaEliminar = 2;

var FichaIngresoManoObraEditar = 2;
var FichaIngresoManoObraEliminar = 2;

var FichaIngresoSuministroEditar = 2;
var FichaIngresoSuministroEliminar = 2;

var FichaIngresoMantenimientoEditar = 2;
var FichaIngresoMantenimientoEliminar = 2;

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
			if($PrivilegioEditar and $InsFichaIngreso->FinEstado == 1){
			?>           
             
             <div class="EstSubMenuBoton"><a href="principal<?php echo (!empty($GET_dia)?'2':'');?>.php?Mod=<?php echo $GET_mod;?>&Form=Editar<?php echo (!empty($GET_dia)?'&Dia=1':'');?>&Id=<?php echo $InsFichaIngreso->FinId;?>"><img src="imagenes/iconos/editar.png" alt="[Editar]" title="Editar" />Editar</a></div>
             <?php
			}
			?>   
              

            <?php
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
        <td width="1922" height="25" colspan="2"><span class="EstFormularioTitulo">VER ORDEN DE TRABAJO</span></td>
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
    <li><a href="#tab4">Presupuesto</a></li>

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
               <td align="left" valign="top"><input name="CmpVehiculoIngresoVIN" type="text" class="EstFormularioCaja" id="CmpVehiculoIngresoVIN"  value="<?php echo $InsFichaIngreso->EinVIN;?>" size="20" maxlength="50" readonly="readonly" /></td>
               <td align="left" valign="top">Placa:</td>
               <td align="left" valign="top"><table>
                 <tr>
                   <td>&nbsp;</td>
                   <td><input  name="CmpVehiculoIngresoPlaca" type="text"  class="EstFormularioCaja" id="CmpVehiculoIngresoPlaca" value="<?php echo $InsFichaIngreso->EinPlaca;?>" size="30" maxlength="50" readonly="readonly"  /></td>
                   <td>&nbsp;</td>
                 </tr>
               </table></td>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
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
               <td align="left" valign="top">Version:
                 <input name="CmpVehiculoIngresoVersionId" type="hidden" id="CmpVehiculoIngresoVersionId" value="<?php echo $InsFichaIngreso->VveId;?>" size="3" /></td>
               <td align="left" valign="top"><input  name="CmpVehiculoIngresoVersion" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpVehiculoIngresoVersion" value="<?php echo $InsFichaIngreso->VveNombre;?>" size="30" maxlength="50" readonly="readonly" /></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">A&ntilde;o de Fabricacion:</td>
               <td align="left" valign="top"><input  name="CmpVehiculoIngresoAnoFabricacion" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpVehiculoIngresoAnoFabricacion" value="<?php echo $InsFichaIngreso->EinAnoFabricacion;?>" size="30" maxlength="45" readonly="readonly" /></td>
               <td align="left" valign="top">Color:</td>
               <td align="left" valign="top"><input  name="CmpVehiculoIngresoColor" type="text"  class="EstFormularioCajaDeshabilitada" id="CmpVehiculoIngresoColor" value="<?php echo $InsFichaIngreso->EinColor;?>" size="30" maxlength="50" readonly="readonly" /></td>
               <td align="left" valign="top"><input name="CmpVehiculoIngresoClienteId" type="hidden" id="CmpVehiculoIngresoClienteId" value="<?php echo $InsFichaIngreso->CliId;?>" size="3" />
                 <input name="CmpMonedaId" type="hidden" id="CmpVehiculoIngresoId2" value="<?php echo $InsFichaIngreso->MonId;?>" size="3" />
                 <input name="CmpTipoCambio" type="hidden" id="CmpTipoCambio" value="<?php echo $InsFichaIngreso->FinTipoCambio;?>" size="3" /></td>
               <td align="left" valign="top">&nbsp;</td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Kilometraje:</td>
               <td align="left" valign="top"><input  name="CmpVehiculoKilometraje" type="text" class="EstFormularioCaja" id="CmpVehiculoKilometraje" value="<?php if(empty($InsFichaIngreso->FinVehiculoKilometraje)){ echo "0.00"; }else{echo $InsFichaIngreso->FinVehiculoKilometraje;}?>" size="10" maxlength="5" readonly="readonly" /></td>
               <td align="left" valign="top">Kilometraje/Plan Mant.:</td>
               <td align="left" valign="top"><select class="EstFormularioCombo" name="CmpMantenimientoKilometraje" id="CmpMantenimientoKilometraje" disabled="disabled" >
               </select>
                 <input type="hidden" name="CmpMantenimientoKilometrajeAux" id="CmpMantenimientoKilometrajeAux" value="<?php echo $InsFichaIngreso->FinMantenimientoKilometraje;?>" />
                
                <!-- <input type="hidden" name="CmpPlanMantenimientoId" id="CmpPlanMantenimientoId" value="<?php echo $InsFichaIngreso->PmaId;?>" />-->
                
                 <input type="hidden" name="CmpPlanMantenimientoNombre" id="CmpPlanMantenimientoNombre" value="<?php echo $InsFichaIngreso->PmaNombre;?>" />
                  <br />
                         
                         <a href="javascript:FncVehiculoMantenimientoResumenListado();">Ver Mantenimientos</a>
                         
                         
                         </td>
               <td align="left" valign="top"><input name="CmpCitaId" type="hidden" id="CmpCitaId" value="<?php echo $InsFichaIngreso->CitId;?>" size="3" /></td>
               <td align="left" valign="top">&nbsp;</td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td>Fecha de Venta</td>
               <td><input name="CmpVehiculoIngresoFechaVenta" type="text" class="EstFormularioCajaDeshabilitada" id="CmpVehiculoIngresoFechaVenta"  value="<?php echo $InsFichaIngreso->FinFechaVenta;?>" size="20" maxlength="20" readonly="readonly" /></td>
               <td>Cant. Mant.:</td>
               <td><input name="CmpVehiculoIngresoCantidadMantenimientos" type="text" class="EstFormularioCajaDeshabilitada" id="CmpVehiculoIngresoCantidadMantenimientos"  value="<?php echo $InsFichaIngreso->FinCantidadMantenimientos;?>" size="5" maxlength="20" readonly="readonly" /></td>
               <td align="left" valign="top">Ord. Venta: </td>
               <td align="left" valign="top"><input name="CmpOrdenVentaVehiculoId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpOrdenVentaVehiculoId"  value="<?php echo $InsFichaIngreso->OvvId;?>" size="20" maxlength="20" readonly="readonly" /></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Campa&ntilde;a:</td>
               <td colspan="5" align="left" valign="top"><input name="CmpCampanaId" type="hidden" id="CmpCampanaId"  value="<?php echo $InsFichaIngreso->CamId;?>" size="20" maxlength="50" />
                 <input name="CmpCampanaCodigo" type="text" class="EstFormularioCajaDeshabilitada" id="CmpCampanaCodigo"  value="<?php echo $InsFichaIngreso->CamCodigo;?>" size="20" maxlength="20" readonly="readonly" />
                 <input name="CmpCampanaNombre" type="text" class="EstFormularioCajaDeshabilitada" id="CmpCampanaNombre"  value="<?php echo $InsFichaIngreso->CamNombre;?>" size="60" maxlength="500" readonly="readonly" /></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Promocion:</td>
               <td colspan="5" align="left" valign="top"><table border="0" cellpadding="0" cellspacing="0">
                 <tr>
                   <td><a href="javascript:FncCampanaVehiculoNuevo();"></a></td>
                   <td><input name="CmpObsequioId" type="hidden" id="CmpObsequioId"  value="<?php echo $InsFichaIngreso->ObsId;?>" size="20" maxlength="50" />
                     <input name="CmpObsequioNombre" type="text" class="EstFormularioCajaDeshabilitada" id="CmpObsequioNombre"  value="<?php echo $InsFichaIngreso->ObsNombre;?>" size="40" maxlength="500" readonly="readonly" /></td>
                   <td><div id="CapVehiculoPromocionResumen"></div></td>
                   </tr>
               </table></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">Mant./Obsequio:</td>
               <td colspan="3" align="left"><table border="0" cellpadding="0" cellspacing="0">
                 <tr>
                   <td><a href="javascript:FncCampanaVehiculoNuevo();"></a></td>
                   <td><input name="CmpOrdenVentaVehiculoMantenimientoId" type="hidden" id="CmpOrdenVentaVehiculoMantenimientoId"  value="<?php echo $InsFichaIngreso->OvmId;?>" size="20" maxlength="50" />
                     Mant./
                       <input name="CmpObsequioNombre2" type="text" class="EstFormularioCajaDeshabilitada" id="CmpObsequioNombre2"  value="<?php echo $InsFichaIngreso->OvmKilometraje;?>" size="40" maxlength="500" readonly="readonly" /></td>
                   <td>&nbsp;</td>
                   </tr>
               </table></td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td align="left" valign="top">&nbsp;</td>
               <td colspan="3" align="left">&nbsp;</td>
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
                  <td align="left" valign="top">Codigo:</td>
                  <td align="left" valign="top"><input readonly="readonly" name="CmpId" type="text" class="EstFormularioCajaDeshabilitada" id="CmpId" value="<?php echo $InsFichaIngreso->FinId;?>" size="15" maxlength="20" /></td>
                  <td align="left" valign="top">&nbsp;</td>
                  <td align="left" valign="top">&nbsp;</td>
                  <td>&nbsp;</td>
                  </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td rowspan="12" align="left" valign="top"><?php
	
		
		foreach($ArrModalidadIngresos as $DatModalidadIngreso){
		?>
                    <?php
            if(is_array($InsFichaIngreso->FichaIngresoModalidad)){	
                foreach($InsFichaIngreso->FichaIngresoModalidad as $DatFichaIngresoModalidad ){
                    $aux = '';
                    if($DatFichaIngresoModalidad->MinId==$DatModalidadIngreso->MinId){
                        $aux = 'checked="checked"';						
                        break;
                    }					
                }
            }				
            ?>
                    <input disabled="disabled" etiqueta="modalidad" <?php echo $aux;?> type="checkbox" value="<?php echo $DatModalidadIngreso->MinId?>" name="CmpModalidadId_<?php echo $DatModalidadIngreso->MinSigla?>" id="CmpModalidadId_<?php echo $DatModalidadIngreso->MinSigla?>" sigla="<?php echo $DatModalidadIngreso->MinSigla;?>" />
                    <?php echo $DatModalidadIngreso->MinNombre?><br />
                    <?php	
		}
		?></td>
                  <td align="left" valign="top">Sucursal:</td>
                  <td colspan="3" align="left" valign="top"><select disabled="disabled" class="EstFormularioCombo" name="CmpSucursal" id="CmpSucursal">
                    <option value="">Escoja una opcion</option>
                    <?php
    foreach($ArrSucursales as $DatSucursal){
    ?>
                    <option value="<?php echo $DatSucursal->SucId;?>" <?php if($InsFichaIngreso->SucId==$DatSucursal->SucId){ echo 'selected="selected"';} ?> ><?php echo $DatSucursal->SucNombre;?></option>
                    <?php
    }
    ?>
                  </select></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Asesor:</td>
                  <td colspan="3" align="left" valign="top"><select disabled="disabled"  class="EstFormularioCombo" name="CmpAsesor" id="CmpAsesor" >
                    <option value="">Escoja una opcion</option>
                    <?php
					foreach($ArrAsesores as $DatAsesor){
					?>
                    <option <?php echo ($DatAsesor->PerId==$InsFichaIngreso->PerIdAsesor)?'selected="selected"':'';?>  value="<?php echo $DatAsesor->PerId;?>"><?php echo $DatAsesor->PerNombre ?> <?php echo $DatAsesor->PerApellidoPaterno; ?> <?php echo $DatAsesor->PerApellidoMaterno; ?></option>
                    <?php
					}
					?>
                  </select></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Fecha de Ingreso:<br />
                    <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
                  <td align="left" valign="top"><input name="CmpFecha" type="text" class="EstFormularioCajaFecha" id="CmpFecha" value="<?php echo $InsFichaIngreso->FinFecha;?>" size="15" maxlength="10" readonly="readonly" /></td>
                  <td align="left" valign="top">Hora:</td>
                  <td align="left" valign="top"><input  name="CmpHora" type="text" class="EstFormularioCaja" id="CmpHora" value="<?php if(empty($InsFichaIngreso->FinHora)){ echo date("H:i"); }else{echo $InsFichaIngreso->FinHora;}?>" size="10" maxlength="8" readonly="readonly" /></td>
                  <td>&nbsp;</td>
                  </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Fecha de Entrega:<br />
                    <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
                  <td align="left" valign="top"><input name="CmpFechaEntrega" type="text" class="EstFormularioCajaFecha" id="CmpFechaEntrega" value="<?php echo $InsFichaIngreso->FinFechaEntrega;?>" size="15" maxlength="10" readonly="readonly" /></td>
                  <td align="left" valign="top">Hora Entrega:</td>
                  <td align="left" valign="top"><input  name="CmpHoraEntrega" type="text" class="EstFormularioCajaHora" id="CmpHoraEntrega" value="<?php if(empty($InsFichaIngreso->FinHoraEntrega)){ echo ""; }else{echo $InsFichaIngreso->FinHoraEntrega;}?>" size="10" maxlength="8" readonly="readonly" /></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Fecha de Cita:<br />
                    <span class="EstFormularioSubEtiqueta">(dd/mm/yyyy)</span></td>
                  <td align="left" valign="top"><input name="CmpFechaCita" type="text" class="EstFormularioCajaFecha" id="CmpFechaCita" value="<?php echo $InsFichaIngreso->FinFechaCita;?>" size="15" maxlength="10" readonly="readonly" /></td>
                  <td align="left" valign="top">&nbsp;</td>
                  <td align="left" valign="top">&nbsp;</td>
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
                    <select  disabled="disabled" class="EstFormularioCombo" name="CmpPrioridad" id="CmpPrioridad">
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
                  <td colspan="3" align="left" valign="top"><select  class="EstFormularioCombo" name="CmpPersonal" id="CmpPersonal" disabled="disabled" >
                    <option value="">Escoja una opcion</option>
                    <?php
					foreach($ArrTecnicos as $DatTecnico){
					?>
                    <option <?php echo ($DatTecnico->PerId==$InsFichaIngreso->PerId)?'selected="selected"':'';?>  value="<?php echo $DatTecnico->PerId;?>"><?php echo $DatTecnico->PerNombre ?> <?php echo $DatTecnico->PerApellidoPaterno; ?> <?php echo $DatTecnico->PerApellidoMaterno; ?></option>
                    <?php
					}
					?>
                  </select></td>
                  <td>&nbsp;</td>
                  </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Presupuesto Maximo a Utilizar:</td>
                  <td align="left" valign="top"><input class="EstFormularioCaja" name="CmpMontoPresupuesto" type="text" id="CmpMontoPresupuesto" value="<?php echo number_format($InsFichaIngreso->FinMontoPresupuesto,2);?>" size="10" maxlength="10" /></td>
                  <td align="left" valign="top">&iquest;Es una cita programada?</td>
                  <td align="left" valign="top"><?php
					switch($InsFichaIngreso->FinCita){
						case "1":
							$OpcCita1 = 'selected = "selected"';
						break;
						
						case "2":
							$OpcCita2 = 'selected = "selected"';						
						break;
						
						case "3":
							$OpcCita3 = 'selected = "selected"';						
						break;


					}
					?>
                    <select disabled="disabled"  class="EstFormularioCombo" name="CmpCita" id="CmpCita">
                      <option value="">Escoja una opcion</option>
                      <option <?php echo $OpcCita1;?> value="1">Cliente Separo Cita</option>
                      <option <?php echo $OpcCita2;?> value="2">Concesionario llamo a cliente</option>
                      <option <?php echo $OpcCita3;?> value="3">Sin Cita / Libre</option>
                    </select></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Notas:<br />
                    <span class="EstFormularioSubEtiqueta">(Resumen de la situacion actual de la O.T.)</span></td>
                  <td colspan="3" align="left" valign="top"><textarea name="CmpNota" cols="60" rows="2" readonly="readonly" class="EstFormularioCaja" id="CmpNota"><?php echo $InsFichaIngreso->FinNota;?></textarea></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Indicaciones para el Tecnico:<br />
                    <span class="EstFormularioSubEtiqueta">(Mensaje que aparecera constantemente al tecnico )</span></td>
                  <td colspan="3" align="left" valign="top"><textarea name="CmpIndicacionTecnico" cols="60" rows="2" readonly="readonly" class="EstFormularioCaja" id="CmpIndicacionTecnico"><?php echo $InsFichaIngreso->FinIndicacionTecnico;?></textarea></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">Referencia:
                  <br />
                    <span class="EstFormularioSubEtiqueta">(Numero de O.T. de la hoja en fisico)</span></td>
                  <td colspan="3" align="left" valign="top"><input name="CmpReferencia" type="text" class="EstFormularioCajaEspecial" id="CmpReferencia"  value="<?php echo $InsFichaIngreso->FinReferencia;?>" size="40" maxlength="500" readonly="readonly" /></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="top">&nbsp;</td>
                  <td colspan="3" align="left" valign="top">&nbsp;</td>
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
                 <td colspan="4"><span class="EstFormularioSubTitulo">Datos del Cliente</span></td>
                 <td>&nbsp;</td>
                 </tr>
               <tr>
                 <td>&nbsp;</td>
                 <td>&nbsp;</td>
                 <td>&nbsp;</td>
                 <td>&nbsp;</td>
                 <td align="center">&nbsp;</td>
                 <td>&nbsp;</td>
                 </tr>
               <tr>
                 <td>&nbsp;</td>
                 <td align="left" valign="top"><select disabled="disabled" class="EstFormularioCombo" name="CmpClienteTipoDocumento" id="CmpClienteTipoDocumento">
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
                   <input name="CmpClienteId" type="hidden" id="CmpClienteId" value="<?php echo $InsFichaIngreso->CliId;?>" size="3" />
                   <input name="CmpClienteTipo" type="hidden" id="CmpClienteTipo" value="<?php echo $InsFichaIngreso->LtiId;?>" size="3" /></td>
                 <td align="left" valign="top"><table border="0" cellpadding="0" cellspacing="0">
                   <tr>
                     <td><input name="CmpClienteNumeroDocumento" type="text" class="EstFormularioCaja" id="CmpClienteNumeroDocumento"  value="<?php echo $InsFichaIngreso->CliNumeroDocumento;?>" size="20" maxlength="50" readonly="readonly" /></td>
                     <td><div id="CapClienteBuscar"></div></td>
                     </tr>
                   </table></td>
                 <td align="left" valign="top">Cliente:
                   <input class="EstFormularioCaja" name="CmpClienteNombre2" type="hidden" id="CmpClienteNombre2" value="<?php echo $InsFichaIngreso->CliNombre;?>" size="45" maxlength="255"  />
                   <input class="EstFormularioCaja" name="CmpClienteApellidoPaterno" type="hidden" id="CmpClienteApellidoPaterno" value="<?php echo $InsFichaIngreso->CliApellidoPaterno;?>" size="45" maxlength="255"  />
                   <input class="EstFormularioCaja" name="CmpClienteApellidoPaterno" type="hidden" id="CmpClienteApellidoPaterno" value="<?php echo $InsFichaIngreso->CliApellidoMaterno;?>" size="45" maxlength="255"  /></td>
                 <td align="left" valign="top"><input name="CmpClienteNombreCompleto" type="text" class="EstFormularioCaja" id="CmpClienteNombreCompleto" value="<?php echo $InsFichaIngreso->CliNombreCompleto;?>" size="45" maxlength="255" readonly="readonly" /></td>
                 <td>&nbsp;</td>
                 </tr>
               <tr>
                 <td>&nbsp;</td>
                 <td align="left" valign="top">Celular:</td>
                 <td align="left" valign="top"><input  name="CmpClienteCelular" type="text"  class="EstFormularioCaja" id="CmpClienteCelular" value="<?php echo $InsFichaIngreso->FinTelefono;?>" size="40" maxlength="50" readonly="readonly" /></td>
                 <td align="left" valign="top">Email:</td>
                 <td align="left" valign="top"><input  name="CmpClienteEmail" type="text"  class="EstFormularioCaja" id="CmpClienteEmail" value="<?php echo $InsFichaIngreso->FinClienteEmail;?>" size="40" maxlength="50" readonly="readonly" /></td>
                 <td>&nbsp;</td>
                 </tr>
               <tr>
                 <td>&nbsp;</td>
                 <td align="left" valign="top">Direccion:</td>
                 <td colspan="3" align="left" valign="top"><input  name="CmpClienteDireccion" type="text"  class="EstFormularioCaja" id="CmpClienteDireccion" value="<?php echo $InsFichaIngreso->FinDireccion;?>" size="40" maxlength="200" readonly="readonly" /></td>
                 <td>&nbsp;</td>
               </tr>
               <tr>
                 <td>&nbsp;</td>
                 <td align="left" valign="top">Contacto:</td>
                 <td colspan="3" align="left" valign="top"><input name="CmpClienteContacto" type="text" class="EstFormularioCaja" id="CmpClienteContacto" value="<?php echo $InsFichaIngreso->FinContacto;?>" size="45" maxlength="255" readonly="readonly"  /></td>
                 <td>&nbsp;</td>
                 </tr>
               <tr>
                 <td>&nbsp;</td>
                 <td align="left" valign="top">Conductor:</td>
                 <td colspan="3" align="left" valign="top"><input name="CmpConductor" type="text" class="EstFormularioCaja" id="CmpConductor" value="<?php echo $InsFichaIngreso->FinConductor;?>" size="45" maxlength="255" readonly="readonly"  /></td>
                 <td>&nbsp;</td>
                 </tr>
               <tr>
                 <td>&nbsp;</td>
                 <td>&nbsp;</td>
                 <td>&nbsp;</td>
                 <td>&nbsp;</td>
                 <td align="center">&nbsp;</td>
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
                      <td>5ta  de Aro:</td>
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
                      <td align="left" valign="top">Observacion:</td>
                      <td colspan="10" align="left" valign="top"><textarea name="CmpObservacion" cols="60" rows="2" class="EstFormularioCaja" id="CmpObservacion"><?php echo $InsFichaIngreso->FinObservacion;?></textarea></td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td colspan="10" align="left" valign="top">&nbsp;</td>
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
                      <td><span class="EstFormularioSubTitulo">Historial OTs</span></td>
                      </tr>
                    <tr>
                      <td><div class="EstFormularioArea" >
                        <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                          <tr>
                            <td width="3%">&nbsp;</td>
                            <td width="47%"><div class="EstFormularioAccion" id="CapFichaIngresoHistorialAccion">Listo
                              para registrar elementos</div></td>
                            <td width="49%" align="right"><a href="javascript:FncFichaIngresoHistorialListar();"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a></td>
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
                    <tr>
                      <td><span class="EstFormularioSubTitulo">Cotizaciones</span></td>
                    </tr>
                    <tr>
                      <td><div class="EstFormularioArea" >
                        <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                          <tr>
                            <td width="3%">&nbsp;</td>
                            <td width="47%"><div class="EstFormularioAccion" id="CapFichaIngresoCotizacionesAccion">Listo
                              para registrar elementos</div></td>
                            <td width="49%" align="right"><a href="javascript:FncFichaIngresoCotizacionesListar();"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a></td>
                            <td width="1%"><div id="CapFichaIngresoCotizacionesResultado"> </div></td>
                            </tr>
                          <tr>
                            <td>&nbsp;</td>
                            <td colspan="2"><div id="CapFichaIngresoCotizaciones" class="EstCapFichaIngresoCotizaciones" > </div></td>
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
    
    
      <div id="tab4" class="tab_content">
    	<table width="100%" border="0" cellpadding="2" cellspacing="2">
            
            <tr>
              <td width="97%" valign="top">
                <iframe src="principal2.php?Mod=PlanMantenimientoPresupuesto&Form=Consulta" width="100%" height="800" frameborder="0" scrolling="no"></iframe>
                    
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
               <input type="hidden" id="CmpModalidadIngresoId_<?php echo $DatModalidadIngreso->MinSigla;?>" name="CmpModalidadIngresoId_<?php echo $DatModalidadIngreso->MinSigla;?>" value="<?php echo $DatModalidadIngreso->MinId;?>" />      
		
            
              <?php
			
			switch($DatModalidadIngreso->MinSigla){
				
				default:
			?>
            
              <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                <tr>
                  <td colspan="3" align="center"><span class="EstFormularioSubTitulo">Tareas y Productos <?php echo $DatModalidadIngreso->MinNombre;?></span></td>
                </tr>
                <tr>
                  <td width="50%" align="left" valign="top"><div class="EstFormularioArea" >
                    <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                      <tr>
                        <td>&nbsp;</td>
                        <td colspan="2"><span class="EstFormularioSubTitulo">TAREAS</span></td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td width="1%">&nbsp;</td>
                        <td width="49%"><div class="EstFormularioAccion" id="Cap<?php echo $DatModalidadIngreso->MinSigla;?>TareaAccion">Listo
                          para registrar elementos</div></td>
                        <td width="49%" align="right"><a href="javascript:FncFichaIngresoTareaListar('<?php echo $DatModalidadIngreso->MinSigla;?>');"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a></td>
                        <td width="1%"><div id="CapFichaIngreso<?php echo $DatModalidadIngreso->MinSigla;?>TareasResultado"> </div></td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td colspan="2"><div id="CapFichaIngreso<?php echo $DatModalidadIngreso->MinSigla;?>Tareas" class="EstCapFichaIngresoTareas" > </div></td>
                        <td>&nbsp;</td>
                      </tr>
                      </table>
                  </div></td>
                  <td width="48%" align="left" valign="top"><div class="EstFormularioArea" >
                    <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                      <tr>
                        <td>&nbsp;</td>
                        <td colspan="2"><span class="EstFormularioSubTitulo">PRODUCTOS</span></td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td width="1%">&nbsp;</td>
                        <td width="49%"><div class="EstFormularioAccion" id="Cap<?php echo $DatModalidadIngreso->MinSigla;?>ProductoAccion">Listo
                          para registrar elementos</div></td>
                        <td width="48%" align="right"><a href="javascript:FncFichaIngresoProductoListar('<?php echo $DatModalidadIngreso->MinSigla;?>');"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a></td>
                        <td width="2%"><div id="CapFichaIngreso<?php echo $DatModalidadIngreso->MinSigla;?>ProductosResultado"> </div></td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td colspan="2"><div id="CapFichaIngreso<?php echo $DatModalidadIngreso->MinSigla;?>Productos" class="EstCapFichaIngresoProductos" > </div></td>
                        <td>&nbsp;</td>
                      </tr>
                    </table>
                  </div></td>
                  <td align="left" valign="top">&nbsp;</td>
                </tr>
                <tr>
                  <td colspan="2" align="left" valign="top">
                  
                  <?php
						  if($DatModalidadIngreso->MinSigla == "RE"){
						?>
                         <div class="EstFormularioArea">
                            
                            
                            <!--<table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                              <tr>
                                <td>&nbsp;</td>
                                <td><span class="EstFormularioSubTitulo">OPCIONES DE REPARACION</span></td>
                                <td>&nbsp;</td>
                              </tr>
                              <tr>
                                <td>&nbsp;</td>
                                <td>  
								
								
								
								<?php
						  if(!empty($ArrTipoReparaciones)){
							  foreach($ArrTipoReparaciones as $DatTipoReparacion){
							 ?>
                            <input disabled="disabled" <?php echo (($DatTipoReparacion->TreId == $InsFichaIngreso->TreId)?'checked="checked"':'');?>  type="radio" name="CmpTipoReparacion" id="CmpTipoReparacion_<?php echo $DatTipoReparacion->TreId;?>" value="<?php echo $DatTipoReparacion->TreId;?>" /> <?php echo $DatTipoReparacion->TreNombre;?><br />
                            
                             <span class="EstFormularioSubEtiqueta"><?php echo $DatTipoReparacion->TreDescripcion;?></span>
                            
                            <br />
                            
                             <?php
							  }
						  }
						  ?>
                          
                          
                          </td>
                                <td>&nbsp;</td>
                              </tr>
                            </table>-->
                            
                            
                    </div>
                            
                          
                        <?php
						  }
						  ?>
                          
                          
                          
                          
                  </td>
                  <td width="2%" align="left" valign="top">
                    
                    <?php
				  /*
				  ?>
                  <div class="EstFormularioArea" >
                    <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                      <tr>
                        <td>&nbsp;</td>
                        <td colspan="2"><span class="EstFormularioSubTitulo">SUMINISTROS</span></td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td width="1%">&nbsp;</td>
                        <td width="49%"><div class="EstFormularioAccion" id="Cap<?php echo $DatModalidadIngreso->MinSigla;?>SuministroAccion">Listo
                          para registrar elementos</div></td>
                        <td width="48%" align="right"><a href="javascript:FncFichaIngresoSuministroListar('<?php echo $DatModalidadIngreso->MinSigla;?>');"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a></td>
                        <td width="2%"><div id="CapFichaIngreso<?php echo $DatModalidadIngreso->MinSigla;?>SuministrosResultado"> </div></td>
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
				
							case "EX":
?>
<table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                        <tr>
                          <td colspan="2" align="center"><span class="EstFormularioSubTitulo">EX - Servicios y Productos <?php echo $DatModalidadIngreso->MinNombre;?></span></td>
                        </tr>
                        
                        
                        
                        <tr>
                          <td width="50%" align="left" valign="top"><div class="EstFormularioArea">
                            
                            
                            <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                              <tr>
                                <td>&nbsp;</td>
                                <td colspan="4"><span class="EstFormularioSubTitulo">SERVICIOS </span>
                                  <input type="hidden" name="Cmp<?php echo $DatModalidadIngreso->MinSigla;?>ManoObraItem" id="Cmp<?php echo $DatModalidadIngreso->MinSigla;?>ManoObraItem" />
                                  <input type="hidden" name="Cmp<?php echo $DatModalidadIngreso->MinSigla;?>ManoObraId" id="Cmp<?php echo $DatModalidadIngreso->MinSigla;?>ManoObraId" /></td>
                              </tr>
                            </table>
                            
                            
                          </div></td>
                          <td width="47%" align="left" valign="top"><div class="EstFormularioArea">
                            <table class="EstFormulario" border="0" cellpadding="2" cellspacing="2">
                              <tr>
                                <td>&nbsp;</td>
                                <td colspan="6"><span class="EstFormularioSubTitulo">PRODUCTOS </span><span class="EstFormularioSubTitulo">
                                <input type="hidden" name="Cmp<?php echo $DatModalidadIngreso->MinSigla;?>ProductoId"    id="Cmp<?php echo $DatModalidadIngreso->MinSigla;?>ProductoId"   />
                                  <input type="hidden" name="Cmp<?php echo $DatModalidadIngreso->MinSigla;?>ProductoItem" id="Cmp<?php echo $DatModalidadIngreso->MinSigla;?>ProductoItem" />
                                  
                               
                                <input type="hidden" name="Cmp<?php echo $DatModalidadIngreso->MinSigla;?>ProductoCodigoOriginal"    id="Cmp<?php echo $DatModalidadIngreso->MinSigla;?>ProductoCodigoOriginal"   />
                                
                                 <input type="hidden" name="Cmp<?php echo $DatModalidadIngreso->MinSigla;?>ProductoCodigoAlternativo"    id="Cmp<?php echo $DatModalidadIngreso->MinSigla;?>ProductoCodigoAlternativo"   />
                                 
                                 
                                    
                                  <input type="hidden" name="CmpFichaIngreso<?php echo $DatModalidadIngreso->MinSigla;?>ProductoId"  class="EstFormularioCaja" id="CmpFichaIngreso<?php echo $DatModalidadIngreso->MinSigla;?>ProductoId"  />
                                  
                                 
                                  
                                  
                                </span></td>
                              </tr>
                            </table>
                          </div></td>
                        </tr>
                        <tr>
                          <td align="left" valign="top"><div class="EstFormularioArea" >
                              <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                                <tr>
                                  <td width="2%">&nbsp;</td>
                                  <td width="48%"><div class="EstFormularioAccion" id="Cap<?php echo $DatModalidadIngreso->MinSigla;?>ManoObraAccion">Listo
                                  para registrar elementos</div></td>
                                  <td width="49%" align="right"><a href="javascript:FncFichaIngresoManoObraListar('<?php echo $DatModalidadIngreso->MinSigla;?>');"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a> <a href="javascript:FncFichaIngresoManoObraEliminarTodo('<?php echo $DatModalidadIngreso->MinSigla;?>');"><img  src="imagenes/acciones/listado_eliminar_todo.png"  width="25" height="25"  border="0" title="Eliminar Todo"   alt="[Eli. Todo.]" align="absmiddle"/> Eliminar Todo</a></td>
                                  <td width="1%"><div id="CapFichaIngreso<?php echo $DatModalidadIngreso->MinSigla;?>ManoObrasResultado"> </div></td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td colspan="2"><div id="CapFichaIngreso<?php echo $DatModalidadIngreso->MinSigla;?>ManoObras" class="EstCapFichaIngresoManoObras" > </div></td>
                                  <td>&nbsp;</td>
                                </tr>
                              </table>
                          </div></td>
                          <td align="left" valign="top"><div class="EstFormularioArea" >
                            <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                              <tr>
                                <td width="1%">&nbsp;</td>
                                <td width="48%"><div class="EstFormularioAccion" id="Cap<?php echo $DatModalidadIngreso->MinSigla;?>ProductoAccion">Listo
                                  para registrar elementos</div></td>
                                <td width="50%" align="right"><a href="javascript:FncFichaIngresoProductoListar('<?php echo $DatModalidadIngreso->MinSigla;?>');"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a> <a href="javascript:FncFichaIngresoProductoEliminarTodo('<?php echo $DatModalidadIngreso->MinSigla;?>');"><img  src="imagenes/acciones/listado_eliminar_todo.png"  width="25" height="25"  border="0" title="Eliminar Todo"   alt="[Eli. Todo.]" align="absmiddle"/> Eliminar Todo</a></td>
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
                          <td colspan="2" align="left" valign="top">&nbsp;</td>
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
                          <td align="left" valign="top">Plan de Mantenimiento:
                            <select disabled="disabled" class="EstFormularioCombo" name="CmpPlanMantenimientoId" id="CmpPlanMantenimientoId">
                              <option value="">Escoja una opcion</option>
                              <?php
foreach($ArrPlanMantenimientos as $DatPlanMantenimiento){
?>
                              <option <?php echo (($DatPlanMantenimiento->PmaId==$InsFichaIngreso->PmaId)?'selected="selected"':'');?>  value="<?php echo $DatPlanMantenimiento->PmaId?>"><?php echo $DatPlanMantenimiento->PmaNombre;?> / MODELO: <?php echo $DatPlanMantenimiento->VmaNombre;?> <?php echo $DatPlanMantenimiento->VmoNombre;?> <?php echo $DatPlanMantenimiento->VveNombre;?></option>
                              <?php
}
?>
                          </select></td>
                        </tr>
                        <tr>
                          <td align="left" valign="top"><input disabled="disabled" <?php echo ($FichaIngresoModalidadObsequio==1)?'checked="checked"':''; ?>  type="checkbox" name="CmpFichaIngresoModalidadObsequio_<?php echo $DatModalidadIngreso->MinSigla; ?>" id="CmpFichaIngresoModalidadObsequio_<?php echo $DatModalidadIngreso->MinSigla; ?>" value="1" />
<span class="EstFormularioResaltar"> Este SERVICIO es GRATUITO </span></td>
                        </tr>
                        <tr>
                          <td align="left" valign="top">
                            
                            
                            <div class="EstFormularioArea" >
                              <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                                <tr>
                                  <td width="1%">
                                  </td>
                                  <td width="49%"><div class="EstFormularioAccion" id="Cap<?php echo $DatModalidadIngreso->MinSigla;?>MantenimientoAccion">Listo
                                  para registrar elementos</div></td>
                                  <td width="49%" align="right"><a href="javascript:FncFichaIngresoMantenimientoListar('<?php echo $DatModalidadIngreso->MinSigla;?>');"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a> <a href="javascript:FncFichaIngresoMantenimientoEliminarTodo('<?php echo $DatModalidadIngreso->MinSigla;?>');"></a></td>
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
                          <td width="31%" align="center"><span class="EstFormularioSubTitulo">SI - Tareas y Productos <?php echo $DatModalidadIngreso->MinNombre;?></span></td>
                        </tr>
                        
                        <tr>
                          <td align="left" valign="top"><div class="EstFormularioArea" >
                            <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                              <tr>
                                <td>&nbsp;</td>
                                <td colspan="2"><span class="EstFormularioSubTitulo">PRODUCTOS que componen la ORDEN DE TRABAJO</span></td>
                                <td>&nbsp;</td>
                              </tr>
                              <tr>
                                <td width="1%">&nbsp;</td>
                                <td width="48%"><div class="EstFormularioAccion" id="Cap<?php echo $DatModalidadIngreso->MinSigla;?>ProductoAccion">Listo
                                  para registrar elementos</div></td>
                                <td width="50%" align="right"><a href="javascript:FncFichaIngresoProductoListar('<?php echo $DatModalidadIngreso->MinSigla;?>');"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a> <a href="javascript:FncFichaIngresoProductoEliminarTodo('<?php echo $DatModalidadIngreso->MinSigla;?>');"><img  src="imagenes/acciones/listado_eliminar_todo.png"  width="25" height="25"  border="0" title="Eliminar Todo"   alt="[Eli. Todo.]" align="absmiddle"/> Eliminar Todo</a></td>
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
                          <td align="left" valign="top">
                            
                            
                            <div class="EstFormularioArea" >
                              <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                                <tr>
                                  <td>&nbsp;</td>
                                  <td colspan="2"><span class="EstFormularioSubTitulo">TAREAS que componen la ORDEN DE TRABAJO</span></td>
                                  <td>&nbsp;</td>
                                </tr>
                                <tr>
                                  <td width="2%">&nbsp;</td>
                                  <td width="48%"><div class="EstFormularioAccion" id="Cap<?php echo $DatModalidadIngreso->MinSigla;?>TareaAccion">Listo
                                  para registrar elementos</div></td>
                                  <td width="49%" align="right"><a href="javascript:FncFichaIngresoTareaListar('<?php echo $DatModalidadIngreso->MinSigla;?>');"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a> <a href="javascript:FncFichaIngresoTareaEliminarTodo('<?php echo $DatModalidadIngreso->MinSigla;?>');"><img  src="imagenes/acciones/listado_eliminar_todo.png"  width="25" height="25"  border="0" title="Eliminar Todo"   alt="[Eli. Todo.]" align="absmiddle"/> Eliminar Todo</a></td>
                                  <td width="1%"><div id="CapFichaIngreso<?php echo $DatModalidadIngreso->MinSigla;?>TareasResultado"> </div></td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td colspan="2"><div id="CapFichaIngreso<?php echo $DatModalidadIngreso->MinSigla;?>Tareas" class="EstCapFichaIngresoTareas" > </div></td>
                                  <td>&nbsp;</td>
                                </tr>
                              </table>
                          </div></td>
                        </tr>
                      </table>
            <?php	
				break;
				
				case "LI":
			?>
            
<table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                        <tr>
                          <td width="31%" align="center"><span class="EstFormularioSubTitulo">LI - Tareas y Productos <?php echo $DatModalidadIngreso->MinNombre;?></span></td>
                        </tr>
                        
                        <tr>
                          <td align="left" valign="top"><div class="EstFormularioArea" >
                            <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                              <tr>
                                <td>&nbsp;</td>
                                <td colspan="2"><span class="EstFormularioSubTitulo">PRODUCTOS que componen la ORDEN DE TRABAJO</span></td>
                                <td>&nbsp;</td>
                              </tr>
                              <tr>
                                <td width="1%">&nbsp;</td>
                                <td width="48%"><div class="EstFormularioAccion" id="Cap<?php echo $DatModalidadIngreso->MinSigla;?>ProductoAccion">Listo
                                  para registrar elementos</div></td>
                                <td width="50%" align="right"><a href="javascript:FncFichaIngresoProductoListar('<?php echo $DatModalidadIngreso->MinSigla;?>');"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a> <a href="javascript:FncFichaIngresoProductoEliminarTodo('<?php echo $DatModalidadIngreso->MinSigla;?>');"><img  src="imagenes/acciones/listado_eliminar_todo.png"  width="25" height="25"  border="0" title="Eliminar Todo"   alt="[Eli. Todo.]" align="absmiddle"/> Eliminar Todo</a></td>
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
                          <td align="left" valign="top">
                            
                            
                            <div class="EstFormularioArea" >
                              <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
                                <tr>
                                  <td>&nbsp;</td>
                                  <td colspan="2"><span class="EstFormularioSubTitulo">TAREAS que componen la ORDEN DE TRABAJO</span></td>
                                  <td>&nbsp;</td>
                                </tr>
                                <tr>
                                  <td width="2%">&nbsp;</td>
                                  <td width="48%"><div class="EstFormularioAccion" id="Cap<?php echo $DatModalidadIngreso->MinSigla;?>TareaAccion">Listo
                                  para registrar elementos</div></td>
                                  <td width="49%" align="right"><a href="javascript:FncFichaIngresoTareaListar('<?php echo $DatModalidadIngreso->MinSigla;?>');"><img src="imagenes/acciones/listado_recargar.png" width="25" height="25" border="0" title="Recargar" alt="[Recargar]" align="absmiddle" /> Recargar</a> <a href="javascript:FncFichaIngresoTareaEliminarTodo('<?php echo $DatModalidadIngreso->MinSigla;?>');"><img  src="imagenes/acciones/listado_eliminar_todo.png"  width="25" height="25"  border="0" title="Eliminar Todo"   alt="[Eli. Todo.]" align="absmiddle"/> Eliminar Todo</a></td>
                                  <td width="1%"><div id="CapFichaIngreso<?php echo $DatModalidadIngreso->MinSigla;?>TareasResultado"> </div></td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td colspan="2"><div id="CapFichaIngreso<?php echo $DatModalidadIngreso->MinSigla;?>Tareas" class="EstCapFichaIngresoTareas" > </div></td>
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

	
	
	
        

<?php
}else{
	echo ERR_GEN_101;
}

?>
